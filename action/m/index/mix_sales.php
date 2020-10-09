<?php
#loop through all order for this month get: 
  #line_item_total=( product price x quantity (before taxes, shipping, discounts, and returns))
  #total discounts,total refund........
if(isset($_POST)&&$_POST['get_mix']==1){
@ob_end_clean();
//$month=date("M");
$month=9;
require_once (dirname(__FILE__, 4)) . '/base.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'SP_Order.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'SP_product.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'API_inverntoryitem.php';

$neworder=new SP_Order();
$newproduct=new SP_Product();
$api_inve=new API_inverntoryitem();
$response = array();
// only get order (get all status except(4,5))
$morder=$neworder->get_mix_attr($month);

$gross_sales=0;
$discounts=0;
$ship=0;
$line=0;
$total=0;
$taxes=0;
$net_sales=0;
$trefund=0;
$qtys=0;
$costs=0;
if(!empty($morder)){
// if canceled or test dont process crafted by the qery no need to recheck 
foreach ($morder as $order) {

  // TODO:we must get the refunds later on;

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
$get_cost=$api_inve->get_inv_prp($product['variant_id']);
if(!is_null($api_inve->get_inv_prp($product['variant_id']))){
$costs=$cost+$get_cost['cost'];

}
  }
}
 


}
}
$gross_sales=$line;
$net_sales=$gross_sales-$discounts;
$total_sales=($gross_sales-$discounts)+($taxes+$ship);
$gross_margin=($net_sales-$costs/$net_sales)*100;

$response=array(

'grosale'=>$gross_sales,
'net_sales'=>$net_sales,
'total_sales'=>$total_sales,
'net_qty'=>$qtys,
'costs'=>$costs


);

header('Content-Type: application/json');
echo json_encode($response);






}

