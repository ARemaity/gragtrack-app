<?php


require_once (dirname(__FILE__,2)).'/base.php';
require_once (dirname(__FILE__,2)).'/'.DIR_INC.'DB_init.php';
require_once (dirname(__FILE__,2)) . '/vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
	session_start();
  }
  

function getGoogleClient() {
	$client = getOauth2Client();
	if ($client->isAccessTokenExpired()) {
		$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
		file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
	}
return $client;
}




function buildClient(){
	
	$client = new Google_Client();
	$client->setAccessType("offline");        // offline access.  Will result in a refresh token
	$client->setIncludeGrantedScopes(true);   // incremental auth
	$client->setAuthConfig(__DIR__ . '/client_secrets.json');
	$client->addScope(array(Google_Service_Analytics::ANALYTICS_READONLY, Google_Service_Analytics::ANALYTICS));
	$client->setRedirectUri(getRedirectUri());
	//$client->setRedirectUri((isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $folder. '/oauth2callback.php');	
	return $client;
}


function getRedirectUri(){

	//Building Redirect URI
	$url = $_SERVER['REQUEST_URI'];                    //returns the current URL
	if(strrpos($url, '?') > 0)
	$url = substr($url, 0, strrpos($url, '?') );  // Removing any parameters.
	$folder = substr($url, 0, strrpos($url, '/') );   // Removeing current file.
	return (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . '/gragtrack2/ga3/callbackn.php';
}



function getOauth2Client() {
	try {
		$newdb=new DB_init();
		$client = buildClient();
		$tkns;
		$isfound=false;
		// Set the refresh token on the client.	
		if (isset($_SESSION['refresh_token']) && $_SESSION['refresh_token']) {
			$client->refreshToken($_SESSION['refresh_token']);
		}else{

			if($newdb->check_if_ga_exist()){
				$isfound=true;
				$tkns=$newdb->get_ga_token();
				$refresh_token=$tkns['refresh_token'];
				$client->refreshToken($refresh_token);
				$_SESSION['refresh_token']=$refresh_token;
			}

		}
		
		// If the user has already authorized this app then get an access token
		// else redirect to ask the user to authorize access to Google Analytics.
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			
			// Set the access token on the client.
			$client->setAccessToken($_SESSION['access_token']);					
			
			// Refresh the access token if it's expired.
			if ($client->isAccessTokenExpired()) {				
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
				$client->setAccessToken($client->getAccessToken());	
				$_SESSION['access_token'] = $client->getAccessToken();				
			}			
			return $client;	
		} else  if($isfound){
			$access_token=$tkns['access_code'];
			$client->setAccessToken($access_token);					
		
			// Refresh the access token if it's expired.
			if ($client->isAccessTokenExpired()) {				
				$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
				$client->setAccessToken($client->getAccessToken());	
				$_SESSION['access_token'] = $client->getAccessToken();				
			}			
			return $client;	


		}else{ 
					
			// We do not have access request access.
			header('Location: ' . filter_var( $client->getRedirectUri(), FILTER_SANITIZE_URL));
		}
	} catch (Exception $e) {
		print "An error occurred: " . $e->getMessage();
	}
}
?>