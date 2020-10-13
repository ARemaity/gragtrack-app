<?php
define('SHOPIFY_APP_SECRET', "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");

$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');


function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}

$verified = verify_webhook($data, $hmac_header);


?>