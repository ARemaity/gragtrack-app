<?php

require_once "verify.php";

require(dirname(__FILE__,5)."/base.php");
require dirname(__FILE__,5)."/".DIR_INC."DB_init.php";
require dirname(__FILE__,5)."/".DIR_INC."DB_logger.php";

$init=new DB_init();
$logger=new DB_logger();
if($verified=='true'){

// Load variables
$webhook_content = NULL;

// Get webhook content from the POST
$webhook = fopen('php://input' , 'rb');
while (!feof($webhook)) {
  $webhook_content .= fread($webhook, 4096);
}
fclose($webhook);

// Decode Shopify POST
$order = json_decode($webhook_content, TRUE);
$current_name=basename(__FILE__, '.php'); 
$get_aid=basename(dirname( dirname(__FILE__) ));

$loggers=$logger->insert_webhook_log($get_aid,'order',$current_name,$order['id'],1);
/*




*/
//Get base class
require_once (dirname(__FILE__,5)) . '/' . DIR_INC . 'API_Product_variant.php';
require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'API_inverntoryitem.php';
require_once  (dirname(__FILE__,5)).'/'.DIR_INC.'SP_Order.php';
require_once  (dirname(__FILE__,5)).'/'.DIR_INC.'SP_Product.php';
$sporder=new SP_Order();
$sproduct=new SP_Product();
$api_inve=new API_inverntoryitem();
$api_product=new API_Product_variant();
$status=0;
$type=0;
$invet_id=0;
$iscountry=false;
$address=array();
$line=array();
if(array_key_exists('billing_address',$order)){
    $address=$order['billing_address'];     
if(!empty($address['country_code'])){

$iscountry=true;

}else{

$iscountry=false;
}
}else{
   
    $iscountry=false;
}
    switch ($order['financial_status']) {
       case 'pending':
           $status=0;
           break;
       case 'authorized':
           $status=1;
           break;
       case 'partially_paid':
           $status=2;
           break;
       case 'paid':
           $status=3;
           break;
       case 'partially_refunded':
           $status=4;
           break;
       case 'partially_refunded':
           $status=5;
           break;
       case 'refunded':
           $status=6;
           break;
       case 'voided':
           $status=7;
       
       break;
       default:
       $status=0;
           break;
   }
   switch ($order['fulfillment_status']) {
    case 'null':
        $type=0;
        break;
    case 'fulfilled':
        $type=1;
        break;
    case 'partial':
        $type=2;
        break;
    case 'restocked':
        $type=3;
        break;

    default:
    $type=0;
        break;
}
   if($sporder->check_order_exist($order['id'])){
    $update_order=$sporder->update_webhook_order($order,$get_aid,$status,$type); 
 
    if($update_order>0){
        $fp = fopen($current_name.'.txt', 'w');
        fwrite($fp,'done order ');
        fclose($fp);
        $get_oid=$sporder->get_order_id($order['id'],$get_aid);
        if($sproduct->delete_order_products($get_oid)){
            $fp = fopen($current_name.'.txt', 'w');
            fwrite($fp,'done delete ');
            fclose($fp);
        }else{
    
            $fp = fopen($current_name.'.txt', 'w');
            fwrite($fp,'errror  delete ');
            fclose($fp);
    
        }
        
    // TODO: get OID ,then delete all product of this order then insert all order 
    }else{
        $fp = fopen($current_name.'.txt', 'w');
        fwrite($fp,'error order'.$order['id'].'///'.
        $order['total_line_items_price'].'///'.
        $order['total_discounts'].'///'.
        $order['total_tax']);
        fclose($fp);
    }
    
    
}else{
   $insert_order=$sporder->insert_webhook_order($order,$get_aid,$status,$type); 
 
if($insert_order>0){
    $fp = fopen($current_name.'.txt', 'w');
    fwrite($fp,'done order ');
    fclose($fp);
    
    if($iscountry==true){
       
        if($sporder->insert_order_address($address,$insert_order)){
    

         
        }
    }

$line=$order['line_items'];
foreach($line as $product){
$pid=$product['product_id'];
$vid=$product['variant_id'];
$name=$product["title"];
$qty=$product['quantity'];
$invet_id=$api_product->get_invent_id($vid);
$cost=$api_inve->get_inv_prp($invet_id['inventory_item_id'])['cost'];
if(is_null($cost)){

    $cost=0;
}

    if($sproduct->init_insert_product($insert_order,$pid,$vid,$qty,$cost)){
        $fp = fopen($current_name.'.txt', 'w');
        fwrite($fp,'done product');
        fclose($fp);
    }else{
        $fp = fopen($current_name.'.txt', 'w');
        fwrite($fp,'error product');
        fclose($fp);

    }
   



}


    


}else{
    $fp = fopen($current_name.'.txt', 'w');
    fwrite($fp,'error insert  order'.$order['id']);
    fclose($fp);
}
}

}else{

  error_log('Webhook verified: '.var_export($verified, true) ,3, $current_name.'txt');
}




?>