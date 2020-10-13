<?php

require_once "verify.php";

require(dirname(__FILE__,4)."/base.php");
require dirname(__FILE__,4)."/".DIR_INC."DB_init.php";


$init=new DB_init();

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
$webhook_content = json_decode($webhook_content, TRUE);
$current_name=basename(__FILE__, '.php'); 
$get_aid=basename(dirname( dirname(__FILE__) ));
/*




*/
//Get base class
require_once (dirname(__FILE__,4)) . '/' . DIR_INC . 'API_Product_variant.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'API_inverntoryitem.php';
require_once  (dirname(__FILE__,4)).'/'.DIR_INC.'SP_Order.php';
require_once  (dirname(__FILE__,4)).'/'.DIR_INC.'SP_Product.php';
$sporder=new SP_Order();
$sproduct=new SP_Product();
$api_inve=new API_inverntoryitem();
$api_product=new API_Product_variant();
$status=0;
$invet_id=0;
$line=array();

    switch ($webhook_content['financial_status']) {
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
   $insert_order=$sporder->insert_order($webhook_content,$status); 
 
if($insert_order>0){

    $counter+=1;
   if($status==3){


    
$line=$webhook_content['line_items'];
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
        
    }else{

    }
   



}


    
   }


}else{
$fp = fopen($current_name.'.json', 'w');
fwrite($fp, $webhook_content);
fclose($fp);
$fp = fopen($current_name.'.txt', 'w');
fwrite($fp,$insert_order);
fclose($fp);
}




/*




*/
// $fp = fopen($current_name.'.json', 'w');
// fwrite($fp, json_encode($webhook_content));
// fclose($fp);

}else{

  error_log('Webhook verified: '.var_export($verified, true) ,3, $current_name.'txt');
}




?>