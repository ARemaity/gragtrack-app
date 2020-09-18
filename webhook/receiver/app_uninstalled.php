<?php

require "verify.php";


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
$fp = fopen('app_uninstalled.json', 'w');
fwrite($fp, json_encode($webhook_content));
fclose($fp);


}else{

  error_log('Webhook verified: '.var_export($verified, true) ,3, "app_uninstalled.txt");
}




?>