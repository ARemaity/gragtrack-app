<?php
require_once 'base.php';

// in case session is not activated start it 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// TODO: in future we must get the the shop url and get data based on it 

if(isset($_SESSION['fromtk'])){
if($_SESSION['fromtk']==1){
    session_unset($_SESSION['fromtk']);
    header("Location:".DIR_ROOT."init.php");

}

}
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
    $get_aid=$db->get_access_ID($shopify['shop'])['AID'];
    $_SESSION['AID']=$get_aid;
    $_SESSION['token_code']=$token_code;
    $get_setup=$db->get_setup($_SESSION['AID'])['setup_level'];

    
/*

if setup level 1  store_prp   is inserted go to init(welcome+pricing)

if setup level 2 store_prp/account tbl   is inserted go to index dashboard

*/

if($get_setup==1){
    header("Location:".DIR_ROOT."init.php");
}elseif($get_setup==2){
    header("Location:".DIR_ROOT."member/");


}else{
    //header("Location:".DIR_ROOT."error.php");
echo "error:index.php:61";
}
   
 
}


?>