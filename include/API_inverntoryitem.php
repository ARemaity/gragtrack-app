<?php 





class API_inverntoryitem{
      


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

    public function get_inv_prp($variant_id){

        $api_url="/admin/api/2020-10/inventory_items/".$variant_id.".json";
        $inventory=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
        $inventory=json_decode($inventory['response'],true);
       if(array_key_exists('errors',$inventory)){

        return null;
       }else{

        return $inventory['inventory_item'];
       }
      
    } 
      

}
?>