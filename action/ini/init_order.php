<?php

@ob_end_clean();

//Get base class
require_once (dirname(__FILE__,3)).'/base.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'API_Order.php';
require_once (dirname(__FILE__, 3)) . '/' . DIR_INC . 'API_Product_variant.php';
require_once (dirname(__FILE__, 3)) . '/' . DIR_INC . 'API_inverntoryitem.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'SP_Order.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'SP_Product.php';
$sporder=new SP_Order();
$sproduct=new SP_Product();
$neworder=new API_Order();
$api_inve=new API_inverntoryitem();
$api_product=new API_Product_variant();
$get_order=$neworder->get_all_order('any');
$result='int: ';
$status=0;
$type=0;
$counter=0;
$invet_id=0;
$address=array();
$iscountry=false;
$line=array();
$size_order=sizeof($get_order);
foreach ($get_order as $order){
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
   $insert_order=$sporder->insert_order($order,$status,$type); 
 
if($insert_order>0){

    $counter+=1;
   if($status==3){


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

        
        
    }



}


    
   }


}else{

    $counter-=1;

}

}

if($size_order==$counter){

echo "1";
}else{

    echo "0";
}

