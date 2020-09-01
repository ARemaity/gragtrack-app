<?php 

session_start();

class API_Config{
     
     



    // constructor
    function __construct() {    
        
  
    }

    // destructor
    function __destruct() {
        
    }


     

 public function get_token_code(){
return $_SESSION['token_code'];

 }

 public function get_shop_url(){
    return $_SESSION['token_code'];
}
 
}


?>