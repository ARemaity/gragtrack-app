<?php


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require_once (dirname(__FILE__,2)).'/base.php';
require_once (dirname(__FILE__,2)).'/'.DIR_INC.'DB_init.php';
require_once (dirname(__FILE__,2)) . '/vendor/autoload.php';
$db = new DB_init();
$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/client_secrets.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/gragtrack2/ga/callback.php');
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

// Handle authorization flow from the server.
if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  if(isset($_SESSION['access_token'])){
    $insert_client=$db->insert_into_ga_token(json_encode($_SESSION['access_token']));
    if($insert_client){
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gragtrack2/ga/';
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }
  }
  
 
}

