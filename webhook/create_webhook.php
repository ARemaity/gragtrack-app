<?php
// in case session is not activated start it 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once '../base.php';
require_once '../'.DIR_INC.'functions.php';

// Set variables for our request
$shop = $_SESSION['shop_name'];
$token = $_SESSION['token_code'];
$query = array(
  "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
);

// Webhook content, including the URL to POST to
$webhook_data = array(
  'webhook' =>
  array(
    'topic' => 'orders/create',
    'address' => 'https://76fa1564c1ff.ngrok.io/gragtrack2/webhook/receive.php',
    'format' => 'json'
  )
);


// Run API call to modify the product
$order_create_webhook = shopify_call($token, $shop, "/admin/api/2020-07/webhooks.json", $webhook_data, 'POST',$query);

// Storage response
var_dump($order_create_webhook['response']);

?>
