<?php

include('ds.php');
@ob_end_clean();
include("src/geoip.inc");
$gi = geoip_open("src/dbip4.dat", GEOIP_STANDARD);
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
require_once DIR_INC.'DB_logger.php';
$db = new DB_init();
$logger = new DB_logger();
$ip =$db-> getIPAddress();  
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
    $store_prp=$db->get_shop_plan($_SESSION['AID']);
    $_SESSION['currency']=$store_prp['currency'];
    $_SESSION['tmz']=$store_prp['tmz'];
    // TODO: insert to login 
    // echo __DIR__; //should be '/main_web_folder/';
//  header("Location:webhook/startup_hooks.php");
    // header("Location:webhook/show_all.php");
    // header("Location:webhook/delete_single.php?id=931096199328");
    //  header("Location:action/ini/init_order.php");
    //   header("Location:action/ini/init_webhook.php");
    //  header("Location:action/m/index/get_order_month.php");
    //  header("Location:action/m/index/get_order_day.php");
    //   header("Location:action/m/index/get_order_q.php");
    //   header("Location:action/m/index/get_top_pr.php");
        // header("Location:action/m/index/latest_orders.php");
/*
// HACK:
if setup level 1  store_prp   is inserted go to init(welcome+pricing)

if setup level 2 store_prp/account tbl   is inserted go to index dashboard

*/

if($get_setup==1){
    header("Location:".DIR_ROOT."init.php");
}elseif($get_setup==2){


    // TODO: CHECK expired date 
    $account_attr=$db->get_account_att($_SESSION['AID']);
    $created=$account_attr['created_at'];
    $expired=$account_attr['expired_date'];
    
    if($db->get_difference($created,$expired)<=0){
        header("Location:".DIR_ROOT."expire.php");
      
    }else{


    // these to get country var from ip 
    $country="";
    if($ip=="::1"){
 
     $country="localhost";
 
    }else{
 
      $country=geoip_country_name_by_addr($gi, $ip);
    }

    if($db->insert__login_log($_SESSION['AID'],$ip,$country)){
    switch ($db->get_shop_plan_type($_SESSION['AID'])) {
        case "1":
            header("Location:".DIR_ROOT."member/");
          break;
        case "2":
            header("Location:".DIR_ROOT."advance/");
          break;
        case "3":
            header("Location:".DIR_ROOT."enterprise/");
          break;
        default:
        header("Location:".DIR_ROOT."member/");
      }

    }else{

        echo "error:index.php:117";
    }
}



}else{
 
echo "error:index.php:122   ";
}
   
 

    }
  

   

 
    
 
}
