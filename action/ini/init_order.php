<?php

@ob_end_clean();

//Get base class
require_once (dirname(__FILE__,3)).'/base.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'API_Order.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'SP_Order.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'SP_Product.php';
$sporder=new SP_Order();
$sproduct=new SP_Product();
$neworder=new API_Order();
$get_order=$neworder->get_all_order('any');
$result='int: ';
$status=0;
$counter=0;
$line=array();
$size_order=sizeof($get_order);
foreach ($get_order as $order){

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
   if($status==3){


   
$line=$order['line_items'];
foreach($line as $product){
$pid=$product['product_id'];
$vid=$product['variant_id'];
$name=$product["title"];
$qty=$product['quantity'];
$oid=$order['id'];
if($sproduct->init_insert_product($oid,$pid,$vid,$qty)){
        
    }else{
    

    }
}


    
   }


  


if($sporder->insert_order($order,$status)){
 $counter+=1;
}else{
    $counter-=1;
    
}

}

if($size_order==$counter){

echo "1";
}else{

    echo "0";
}

