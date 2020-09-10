<?php

// Set variables for our request
$shop = "demo-shop";
$token = "SWplI7gKAckAlF9QfAvv9yrI3grYsSkw";
$query = array(
  "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
);

// Webhook content, including the URL to POST to
$webhook_data = array(
  'webhook' =>
  array(
    'topic' => 'orders/create',
    'address' => 'http://requestb.in/19ze0i11',
    'format' => 'json'
  )
);


// Run API call to modify the product
$order_create_webhook = shopify_call($token, $shop, "/admin/products/" . $product_id . ".json", $modify_data, 'POST',$query);

// Storage response
var_dump( $order_create_webhook['response']);

?>