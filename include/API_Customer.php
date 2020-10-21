<?php 





class API_Customer{
      


private $token_code;
private $shop_url;

    // constructor
    function __construct() {    
      require_once 'functions.php';
      require_once 'DB_token.php';
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      $this->shop_url=$_SESSION['shop_name'];
      // HACK: to make on call to get tk , its init in constructor and get by getter fcn 
      $new_manage = new DB_token($this->shop_url);
      $this->token_code =  $new_manage->get_shop_token();
       
      }
    

    // destructor
    function __destruct() {
        
    }


     
 



 public function get_single_c($id){
    $api_url="/admin/api/2020-10/customers/".$id.".json";
    $customer=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
    $customer=json_decode($customer['response']);
    return $customer['customer'];
 }
 
 public function get_customer_address($id){
   $api_url="/admin/api/2020-10/customers/".$id.".json";
   $customer=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
   $customer=json_decode($customer['response']);
   return $customer['customer'];
}


}
?>