

<?php



require(dirname(__FILE__,2)."/base.php");

require dirname(__FILE__,2)."/".DIR_INC."WH_CRUD.php";

// if(isset($_POST['register'])){
$wh=new WH_CRUD();

$list=$wh->List_wh();
//$insert_wh=$db_wh->create_weebhook($regsiter);
echo var_export($list);
// }
?>