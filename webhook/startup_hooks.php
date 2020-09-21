

<?php


require("../base.php");
require "../".DIR_INC."DB_webhook.php";
require "../".DIR_INC."WH_CRUD.php";

if(isset($_POST['register'])){
$wh=new WH_CRUD();
$db_wh=new DB_webhook();
$app_uninstalled=$wh->register_wh("app/uninstalled"," https://b7c796a36a5f.ngrok.io/gragtrack2/webhook/receiver/app_uninstalled.php");



$insert_wh=$db_wh->create_weebhook($app_uninstalled);


}
?>