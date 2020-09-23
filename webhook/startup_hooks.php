

<?php
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['submitted']=0;
require("../base.php");
require "../".DIR_INC."DB_webhook.php";
require "../".DIR_INC."WH_CRUD.php";

if(isset($_POST['register'])){
$wh=new WH_CRUD();
$db_wh=new DB_webhook();
$result=array();
$message="";
$hook_msg="";
$app_uninstalled=$wh->register_wh("app/uninstalled","https://42fa47623411.ngrok.io/gragtrack2/webhook/receiver/app_uninstalled.php");
if($app_uninstalled){
    $shop_update=$wh->register_wh("shop/update"," https://42fa47623411.ngrok.io/gragtrack2/webhook/receiver/shop_update.php");
    if($shop_update){
        $domain_create=$wh->register_wh("domains/create","https://42fa47623411.ngrok.io/gragtrack2/webhook/receiver/domains_create.php");
        if($domain_create){
            $domain_update=$wh->register_wh("domains/update","https://42fa47623411.ngrok.io/gragtrack2/webhook/receiver/domains_update.php");

            if($domain_update){

                $domain_destroy=$wh->register_wh("domains/destroy","https://42fa47623411.ngrok.io/gragtrack2/webhook/receiver/domains_destroy.php");
                   if($domain_destroy){
                        array_push($result,[$shop_update,$domain_create,$domain_update,$domain_destroy]);
                                }else{
                                    
                   $message.=$domain_destroy;
                                }
            }else{

                $message.=$domain_update; 
            }
        }else{
            $message.=$domain_create; 

        }
    }else{

        $message.=$shop_update; 
    }
}else{
    $message.=$app_uninstalled;
}




if(!empty($result)){
    
foreach ($result as $value) {
    
    if($db_wh->create_weebhook($value)){

        $message.="true";
    }else{

        $message.="false";
    }
    
    }

    echo $message;
}else{
    echo "false";
}
// $orders_transaction;
// $orders_paid;
// $orders_updated;




}
?>