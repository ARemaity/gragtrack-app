<?php



require_once (dirname(__FILE__,2)).'/base.php';
require_once (dirname(__FILE__,2)) . '/vendor/autoload.php';
require_once __DIR__ . '/oauthn.php';
$newdb=new DB_init();
if (session_status() == PHP_SESSION_NONE) {
	session_start();
  }
// Handle authorization flow from the server.
if (! isset($_GET['code'])) {
	$client = buildClient();
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
	$client = buildClient();
	$client->authenticate($_GET['code']); // Exchange the authencation code for a refresh token and access token.
	// Add access token and refresh token to seession.
	$_SESSION['access_token'] = $client->getAccessToken();
	$_SESSION['refresh_token'] = $client->getRefreshToken();

  if(isset($_SESSION['access_token'])&&isset($_SESSION['refresh_token'])){
    $insert_client=$newdb->insert_into_ga_token(json_encode($_SESSION['access_token']),$_SESSION['refresh_token']);
    if($insert_client){
	$redirect_uri = str_replace("callbackn.php",'index.php',$client->getRedirectUri()); 	
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

	}


  }

}
?>