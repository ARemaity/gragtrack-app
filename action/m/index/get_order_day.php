<?php
$this_year=date("Y");
//Get base class
require_once (dirname(__FILE__,4)).'/base.php';
require_once  (dirname(__FILE__,4)).'/'.DIR_INC.'SP_Order.php';
$neworder=new SP_Order();
$days=$neworder->order_day();
$data=$neworder->get_all_days();



    foreach ($days as $day) {

 
        $data[$day['D']]=$day['T'];
        }





var_dump($data);



?>