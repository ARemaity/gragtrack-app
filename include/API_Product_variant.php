<?php 





class API_Product_variant{
      


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

    public function get_variant_prp($variant_id){

        $api_url="/admin/api/2020-10/variants/".$variant_id.".json?fields=title,aa";
        $variant=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
        $variant=json_decode($variant['response'],true);
       if(array_key_exists('errors',$variant)){

        return null;
       }else{

        return $variant['variant'];
       }
      
    } 
        
    /**
     * get variant price and image Id
     *
     * @param  mixed $variant_id
     * @return void
     */
    public function get_variant_prp2($variant_id){

        $api_url="/admin/api/2020-10/variants/".$variant_id.".json?fields=price,aa,image_id,aa,title,aa";
        $variant=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
        $variant=json_decode($variant['response'],true);
       if(array_key_exists('errors',$variant)){

        return null;
       }else{

        return $variant['variant'];
       }
      
    } 
    public function get_invent_id($variant_id){

        $api_url="/admin/api/2020-10/variants/".$variant_id.".json?fields=inventory_item_id,aa,price,aa";
        $variant=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
        $variant=json_decode($variant['response'],true);
       if(array_key_exists('errors',$variant)){

        return null;
       }else{

        return $variant['variant'];
       }
      
    }    

}
?>