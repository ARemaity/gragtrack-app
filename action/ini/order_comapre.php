<?php

// this function to compare between the order count api vs count row sp_order
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

@ob_end_clean();
//Get base class
require_once (dirname(__FILE__,3)).'/base.php';
//Get Reports class
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'API_Order.php';
require_once  (dirname(__FILE__,3)).'/'.DIR_INC.'SP_Order.php';
$newapi=new API_Order();
$newsp=new SP_Order();
$count=$newapi->get_order_count('any');


?>