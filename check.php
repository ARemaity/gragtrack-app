<?php

require_once 'base.php';
//Get Reports class
require_once DIR_INC.'DB_Manage.php';
require_once DIR_INC.'functions.php';
$db = new DB_Manage();
$get_token="";
$shopify=$_GET;
$shop_name=$shopify['shop'];

$check_exist=$db->check_if_store_exsit($shopify['shop']);
if(!$check_exist){

    header("Location:install.php?shop=".$shopify['shop']);
    
}else{
    $token_code=$db->get_shop_token($shopify['shop'])['token_code'];
 
}


?>