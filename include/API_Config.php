<?php 



class API_Config{
     
    private $tk;
    private $store;
    private $AID;
    private $SID;   


    // constructor
    function __construct() {    
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->tk=$_SESSION['token_code'];
        $this->store=$_SESSION['shop_name'];
        $this->AID=$_SESSION['AID'];
    }

    // destructor
    function __destruct() {
        
    }


     

 public function get_token_code(){
 return $this->tk;

 }

 public function get_shop_url(){
    return $this->store;
}
public function get_access_ID(){
    return $this->AID;
}
}


?>