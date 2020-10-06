<?php 





class API_refund{
      


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

    public function get_single_refund($order_id){

        $api_url="/admin/api/2020-07/orders/".$order_id."./refunds.json";
        $refunds=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
        $refunds=json_decode($refunds['response'],true);
        return $refunds['order'];
      
    } 
      

}
?>