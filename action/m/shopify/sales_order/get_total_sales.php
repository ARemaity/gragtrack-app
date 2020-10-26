<?php
$month=date("m");
require_once (dirname(__FILE__, 5)) . '/base.php';
require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'SP_Order.php';
require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'SP_product.php';

$neworder=new SP_Order();
$newproduct=new SP_Product();
$response = array();
$response['nb_sales']=array();
// get all order except the test order (paid parti4ally refund all are calculated);
$morder=$neworder->get_mix_attr($month);
$discounts=0;
$total_sales=0;
$ship=0;
$line=0;
$taxes=0;
$total=0;
$trefund=0;
$qtys=0;
$costs=0;

if(!empty($morder)){
// if canceled or test dont process crafted by the qery no need to recheck 
foreach ($morder as $order) {

  if($order['has_refund']==1){
  $trefund=$order['total_refund'];
  }
  // TODO:we must get the refunds later on;(DONE)

$line=$line+$order['total_line'];

$ship=$ship+$order['total_ship'];

$discounts=$discounts+$order['total_discount'];

$taxes=$taxes+$order['total_tax'];

$total=$total+$order['total_amount'];

// HACK: According to shopify comminity line_item_total add to it tax if has_tax is 'true' then we must subtract the value from it 
if($order['tax_included']!=0){
  $line=$line-$order['total_taxes'];
}
$getpr=$newproduct->get_product_order($order['OID']);
if(!empty($getpr)){

  foreach ($getpr as $product) {

    $qtys=$qtys+$product['qty'];

$costs=$costs+$product['single_cost'];

}
  }

 


}

 $total_sales=($line-$discounts-$trefund)+($taxes+$ship);

}


