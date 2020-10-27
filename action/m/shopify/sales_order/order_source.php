<?php
$month=date("m");
require_once (dirname(__FILE__, 5)) . '/base.php';
require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'SP_Order.php';

$response=array();
$response['source']=array();
$response['isdata']=0;
$handler=array();
$apisource=0;
$newrorder=new SP_Order();
$getorder=$newrorder->get_source_order();
if(!is_null($getorder)){

    $response['isdata']=1;
    foreach($getorder as $order){

        if($order['source_name']!='web'&&$order['source_name']!='android'&&$order['source_name']!='iPhone'&&$order['source_name']!='pos'&&$order['source_name']!='shopify_draft_order'){
            $apisource+=$order['counts'];
        }else{
        $handler=array(
 'name'=>$order['source_name'],
  'nb'=>$order['counts']

        );
        array_push($response['source'],$handler);
    }
    }
    array_push($response['source'],array(
'name'=>'other',
'nb'=>$apisource

    ));

}else{
    $response['isdata']=0;
}
echo json_encode($response);




