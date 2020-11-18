<?php 


class DB_Report{
     

private $analytics;
private $isfound=false;
 
    function __construct() {


        require_once (dirname(__FILE__,2)).'/base.php';
        require_once (dirname(__FILE__,2)) . '/vendor/autoload.php';
        require_once  'DB_init.php';
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }
        
        $db = new DB_init();

        $client = new Google_Client();
        $client->setAuthConfig((dirname(__FILE__,2)) . '/ga/client_secrets.json');
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $client->setAccessType('offline');
        $client->setApprovalPrompt("consent");
        $client->setIncludeGrantedScopes(true);  

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
          // Set the access token on the client.
          $client->setAccessToken($_SESSION['access_token']);
        
          // Create an authorized analytics service object.
          $this->analytics = new Google_Service_Analytics($client);
          $this->isfound=true;
        } else {
          if($db->check_if_ga_exist()){
            $token=$db->get_ga_token()['token_code'];
            $client->setAccessToken(json_decode($token,TRUE));
            $this->analytics = new Google_Service_Analytics($client);
         $this->isfound=true;
          }

          
        }
  
    }

    // destructor
    function __destruct() {
        
    }

public  function get_analytics(){
if($this->isfound){
    return $this->analytics;
}
   return $this->isfound;
}
    
    
    
    

    
}

?>