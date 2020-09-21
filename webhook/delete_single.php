

<?php


require("../base.php");
require "../".DIR_INC."DB_webhook.php";
require "../".DIR_INC."WH_CRUD.php";

if(isset($_GET['id'])){
$wh=new WH_CRUD();
$db_wh=new DB_webhook();
$delete=$wh->delete_wh($_GET['id']);
echo var_export($delete);
}
?>