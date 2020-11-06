<?php

// this function to compare between the order count api vs count row sp_order
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

@ob_end_clean();
//Get base class
require_once (dirname(__FILE__,3)).'/base.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'API_Order.php';
require_once (dirname(__FILE__, 3)) . '/' . DIR_INC . 'API_Product_variant.php';
require_once (dirname(__FILE__, 3)) . '/' . DIR_INC . 'API_inverntoryitem.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'SP_Order.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'SP_Product.php';
$sporder=new SP_Order();
$sproduct=new SP_Product();
$neworder=new API_Order();
$api_inve=new API_inverntoryitem();
$api_product=new API_Product_variant();
$count_api=$neworder->get_order_count('any');
$count_db=$sporder->get_order_count()['counts'];

if($count_api===$count_db){
echo '1';
}else{
$get_last=$sporder->get_last_order_id()['oid'];

$fetch_after=$neworder->get_order_after($get_last);
if(!is_null($fetch_after)){
//  ///////////////////

// ///////////////

}

}


?>