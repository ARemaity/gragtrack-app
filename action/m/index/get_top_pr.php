<?php
$this_year=date("Y");
//Get base class
require_once (dirname(__FILE__,4)).'/base.php';
require_once  (dirname(__FILE__,4)).'/'.DIR_INC.'SP_Product.php';
$newpr=new SP_Product();
$tops=$newpr->get_top_five();
$count="111: ";
foreach ($tops as $top) {

    foreach ($top as $key => $value) {
       if($key=='count'){

        $count.=$value."  ,";
       }
    }
  
}

echo $count;
?>