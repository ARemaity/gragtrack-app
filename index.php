<?php

include('ds.php');
require_once 'base.php';

// in case session is not activated start it 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// TODO: in future we must get the the shop url and get data based on it 


if(isset($_SESSION['fromtk'])&&$_SESSION['fromtk']==1){
    $_SESSION['fromtk']=0;
    unset($_SESSION['fromtk']);
    header("Location:".DIR_ROOT."init.php");
exit();


}

require_once DIR_INC.'functions.php';
require_once DIR_INC.'DB_init.php';

$db = new DB_init();

 // save shop name to session
$_SESSION['shop_name']=$_GET['shop'];
   
$check_exist=$db->check_if_store_exsit($_SESSION['shop_name']);

if(!$check_exist){
    
    header("Location:install.php?shop=".$_SESSION['shop_name']);
    
}else{

    $isactive=$db->get_shop_status($_SESSION['shop_name']);

    if($isactive['isactive']==0){


        header("Location:reinstall.php?shop=".$_SESSION['shop_name']);
        // we must update token 

    //    TODO: redirect to return_page


    }else{

    $get_aid=$db->get_access_ID($_GET['shop'])['AID'];
    $_SESSION['AID']=$get_aid;
    $get_setup=$db->get_setup($_SESSION['AID'])['setup_level'];
    // echo __DIR__; //should be '/main_web_folder/';
    // // header("Location:webhook/app_uninstalled.php");
    // header("Location:webhook/show_all.php");
    // header("Location:webhook/delete_single.php?id=931096199328");
/*
// HACK:
if setup level 1  store_prp   is inserted go to init(welcome+pricing)

if setup level 2 store_prp/account tbl   is inserted go to index dashboard

*/

if($get_setup==1){
    header("Location:".DIR_ROOT."init.php");
}elseif($get_setup==2){
    header("Location:".DIR_ROOT."member/");
// TODO :check is capable : 0 to memeber 1 | to advance


}else{
    //header("Location:".DIR_ROOT."error.php");
echo "error:index.php:61   ".$_SESSION['AID'];
}
   
 
}

}
?>