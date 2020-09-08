<?php 





class API_Order{
     


private $token_code;
private $shop_url;
private $new_api;
    // constructor
    function __construct() {    
        require_once 'functions.php';
        require_once 'API_Config.php';

        $this->new_api = new API_Config();
        $this->token_code =  $this->new_api->get_token_code();
        $this->shop_url = $this->new_api->get_shop_url();
       
      }
    

    // destructor
    function __destruct() {
        
    }


     
 
 /** link:https://shopify.dev/docs/admin-api/rest/reference/orders/order#count-2020-07
  * get_order_count
  *
  * @param  mixed $financial_status
  * @return $counts
  */
 public function get_order_count($financial_status ){

   $api_url="/admin/api/2020-07/orders/count.json?financial_status=".$financial_status;
   $counts=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());

   $counts=json_decode($counts['response']);
   foreach ($counts as $count) {
  
return $count;
  

   }



 }


 public function get_checkout_count($status){

  $api_url="/admin/api/2020-07/checkouts/count.json";
  $counts=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());

  $counts=json_decode($counts['response']);
  foreach ($counts as $count) {
 
return $count;
 

  }



}
 
     
public function get_store_prp(){
$store_arr=array();
  $api_url="/admin/api/2020-07/shop.json";
  $counts=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
  $store_prp=json_decode($counts['response'],true);
  return $store_prp['shop'];


}

}
?>