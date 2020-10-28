<?php
// in case session is not activated start it 

if(isset($_POST)&&isset($_POST['get_st'])){



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once (dirname(__FILE__, 5)) . '/base.php';
require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'SP_Order.php';

$response=array();
$response['isdata']=0;
$handler=array();
$apisource=0;
$newrorder=new SP_Order();
$date = new DateTime("now", new DateTimeZone($_SESSION['tmz']));
$current=$date->format('Y-m-d');
$getorder=$newrorder->get_sales_today($current);
if(!is_null($getorder)){

    $response['isdata']=1;
    $response['data']=$getorder['counts'];
   
}else{
    $response['isdata']=0;
}
echo json_encode($response);




}