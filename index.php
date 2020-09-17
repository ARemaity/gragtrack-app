<?php
require_once 'base.php';

// in case session is not activated start it 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// TODO: in future we must get the the shop url and get data based on it 


if(isset($_SESSION['fromtk'])&&$_SESSION['fromtk']==1){
    $_SESSION['fromtk']=0;
    session_unset($_SESSION['fromtk']);
    header("Location:".DIR_ROOT."init.php");
exit();


}

require_once DIR_INC.'functions.php';
require_once DIR_INC.'DB_init.php';

$db = new DB_init();

 // save shop name to session
$_SESSION['shop_name']=$_GET['shop'];
   
$check_exist=$db->check_if_store_exsit($_GET['shop']);

if(!$check_exist){
    
    header("Location:install.php?shop=".$_GET['shop']);
    
}else{

    $isactive=$db->get_shop_status($_SESSION['shop_name']);

    if($isactive==0){

    //    TODO: redirect to return_page


    }else{

  


    $get_aid=$db->get_access_ID($_GET['shop'])['AID'];
    $_SESSION['AID']=$get_aid;
    $get_setup=$db->get_setup($_SESSION['AID'])['setup_level'];
    require_once DIR_INC.'WH_CRUD.php';
    $new_wh=new WH_CRUD();
    // echo $new_wh->List_wh();
    // echo $new_wh->update_single_wh('924884533408','https://b4fe218a0965.ngrok.io/gragtrack2/webhook/receive.php');
    // header("Location:".DIR_ROOT."webhook/create_webhook.php");
//    header("Location:".DIR_ROOT."webhook/list_webhook.php");
   // header("Location:".DIR_ROOT."webhook/delete_webhook.php");
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