<?php 



class API_Config  {
     
    private $tk;
    private $store;


    // constructor
    function __construct() {    
        require_once 'DB_manage.php';
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->store=$_SESSION['shop_name'];
        // HACK: to make on call to get tk , its init in constructor and get by getter fcn 
        $new_manage = new DB_manage($this->store);
        $this->tk =  $new_manage->get_shop_token();
    
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


public function set_shop($shops){
    $this->shop=$shops;

}

public function set_token($tks){
    $this->tk=$tks;

}

}


?>