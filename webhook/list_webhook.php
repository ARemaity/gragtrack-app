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

// Run API call to modify the product
$counts=shopify_call($token,$shop,'/admin/api/2020-07/webhooks.json',array(),'GET',array());

$counts=json_decode($counts['response']);

var_export($counts);
//924865265824
?>
