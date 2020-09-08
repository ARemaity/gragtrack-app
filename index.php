<?php

require_once 'base.php';
//Get Reports class
require_once DIR_INC.'DB_init.php';
require_once DIR_INC.'functions.php';
$db = new DB_init();
$shopify=$_GET;
$shop_name=$shopify['shop'];

$check_exist=$db->check_if_store_exsit($shopify['shop']);
if(!$check_exist){

    header("Location:install.php?shop=".$shopify['shop']);
    
}else{


// in case session is not activated start it 
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    $token_code=$db->get_shop_token($shop_name)['token_code'];
    $_SESSION['shop_name']=$shop_name;
    $_SESSION['token_code']=$token_code;
    header("Location: ".DIR_ROOT."member/index.php");
 
}


?>