<?php

// FOR TEST "implemneted in index.php directly"///
$this_year=date("Y");
//Get base class
require_once (dirname(__FILE__,4)).'/base.php';
require_once  (dirname(__FILE__,4)).'/'.DIR_INC.'SP_Order.php';
$neworder=new SP_Order();
$qs=$neworder->order_q($this_year);
$data_q=array();
   
$q_value=" [";
foreach($qs[0] as $key=> $value){


    if($key!='q4'){

        $q_value.=$value.',';
    }else{
        $q_value.=$value.']';
    }
}





// var_dump($qs);

echo $q_value;
?>