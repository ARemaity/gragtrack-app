<?php
require_once 'ds.php';
// in case session is not activated start it 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// TODO: in future we must get the the shop url and get data based on it 
require_once 'base.php';
require_once DIR_INC.'DB_init.php';
require_once DIR_INC.'functions.php';
$db = new DB_init();
$shopify=$_GET;

 // save shop name to session
$_SESSION['shop_name']=$shopify['shop'];
   
$check_exist=$db->check_if_store_exsit($shopify['shop']);





if(!$check_exist){
    
    header("Location:install.php?shop=".$shopify['shop']);
    
}else{

    $token_code=$db->get_shop_token($shopify['shop'])['token_code'];
    $get_aid=$db->get_access_ID($shopify['shop']);
	$_SESSION['AID']=$get_aid;
    $_SESSION['token_code']=$token_code;
    header("Location: ".DIR_ROOT."member/index.php");
 
}


?>