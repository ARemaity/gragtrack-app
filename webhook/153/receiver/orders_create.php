<?php

require_once "verify.php";

require(dirname(__FILE__,4)."/base.php");
require dirname(__FILE__,4)."/".DIR_INC."DB_init.php";


$init=new DB_init();

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
$current_name=basename(__FILE__, '.php'); 
$get_aid=basename(dirname( dirname(__FILE__) ));
$fp = fopen($current_name.'.json', 'w');
fwrite($fp, json_encode($webhook_content));
fclose($fp);

}else{

  error_log('Webhook verified: '.var_export($verified, true) ,3, $current_name.'txt');
}




?>