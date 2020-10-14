<?php

require_once "verify.php";

require(dirname(__FILE__,5)."/base.php");
require dirname(__FILE__,5)."/".DIR_INC."DB_init.php";
require dirname(__FILE__,5)."/".DIR_INC."DB_logger.php";

$init=new DB_init();
$logger=new DB_logger();
if($verified=='true'){

// Load variables
$webhook_content = NULL;

// Get webhook content from the POST
$webhook = fopen('php://input' , 'rb');
while (!feof($webhook)) {
  $webhook_content .= fread($webhook, 4096);
}
fclose($webhook);

// Decode Shopify POST
$webhook_content = json_decode($webhook_content, TRUE);

$get_aid=basename(dirname( dirname(__FILE__) ));
$loggers=$logger->insert_webhook_log($get_aid,'shop',$current_name,0,5);

$disable=$init->disable_status($get_aid);
if($disable){

  // TODO: send email return 
  
}
$fp = fopen('app_uninstalled.json', 'w');
fwrite($fp, json_encode($webhook_content));
fclose($fp);


}else{

  error_log('Webhook verified: '.var_export($verified, true) ,3, "app_uninstalled.txt");
}




?>