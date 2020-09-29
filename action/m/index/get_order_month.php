<?php
$this_year=date("Y");
//Get base class
require_once (dirname(__FILE__,4)).'/base.php';
require_once  (dirname(__FILE__,4)).'/'.DIR_INC.'SP_Order.php';
$neworder=new SP_Order();
$months=$neworder->order_month($this_year);
$data=$neworder->get_all_month();



foreach ($months as $month) {

    $monthName = date('M', mktime(0, 0, 0,$month['M'], 10));
$data[$monthName]=$month['S'];



}



$final="data=[";
foreach($data as $key=> $value){


    if($key!='Dec'){

        $final.=$value.',';
    }else{
        $final.=$value.']';
    }
}
echo $final;

?>