<?php

require_once 'base.php';
//Get Reports class
require_once DIR_INC.'DB_init.php';
require_once DIR_INC.'functions.php';
$db = new DB_init();

// Get our helper functions


// Set variables for our request
$api_key = "63c2fe83585200119d5aed905e2580a0";
$shared_secret = "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";
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];

$insert_shop=$db->insert_into_access_token($params['shop'],$access_token);

if($insert_shop!=0){

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	$_SESSION['AID']=$insert_shop;

	header("Location:https://" . $params['shop'] . "/admin/apps/grag_app");
	exit();
}
else{
	echo "<<There is Problem in Inserting Data>>";
}
} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}