<?php


define('SHOPIFY_APP_SECRET', "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");
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);

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
$fp = fopen('result.json', 'w');
fwrite($fp, json_encode($webhook_content));
fclose($fp);


}else{

  error_log('Webhook verified: '.var_export($verified, true) ,3, "result.txt");
}


function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}

?>