<?php 





class API_Product{
      


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

    public function get_pr_prp($product_id){

        $api_url="/admin/api/2020-10/products/".$product_id.".json?fields=title,aa";
        $product=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
        $product=json_decode($product['response'],true);
       if(array_key_exists('errors',$product)){

        return null;
       }else{

        return $product['product'];
       }
      
    } 
      

      

}
?>