<?php

// TODO this only by fixed month current vs prievous 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

@ob_end_clean();
$date = new DateTime("now", new DateTimeZone($_SESSION['tmz']));
$currentm=$date->format('m');
$currenty=$date->format('m');
$date->modify('-1 month');
$prem=$date->format('m');
$prey=$date->format('m');
require_once (dirname(__FILE__, 5)) . '/base.php';
require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'SP_Order.php';
$line=0;
$refund=0;
$discount=0;
$line1=0;
$refund1=0;
$discount1=0;
$netsale=0;
$netsale1=0;
$response=array();
$response['isdata']=0;
$handler=array();
$newrorder=new SP_Order();
$total_growth=0;
$getgrowth1=$newrorder->get_sales_growth($currentm,$currenty);
$getgrowth2=$newrorder->get_sales_growth($prem,$prey);
if(is_null($getgrowth1)&&is_null($getgrowth2)){

    $response['isdata']=0;



}else{
    $response['isdata']=1;


    $netsale=$getgrowth1['lsum']-$getgrowth1['dsum']-$getgrowth1['rsum'];
    $netsale1=$getgrowth2['lsum']-$getgrowth2['dsum']-$getgrowth2['rsum'];
    if($netsale1<=0){
        $total_growth=($netsale-$netsale1)/100;
    }else{
        $total_growth=($netsale-$netsale1)/$netsale1*100;
    }

}
echo json_encode($total_growth);


