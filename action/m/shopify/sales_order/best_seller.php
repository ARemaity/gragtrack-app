<?php
$month=date("m");
require_once (dirname(__FILE__, 5)) . '/base.php';
require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'SP_product.php';


$newpr=new SP_Product();
$best_seller=$newpr->best_seller();





