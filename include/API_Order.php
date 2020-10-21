<?php 





class API_Order{
      


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


     
 
 /** link:https://shopify.dev/docs/admin-api/rest/reference/orders/order#count-2020-10
  * get_order_count
  *
  * @param  mixed $financial_status
  * @return  array $counts
  */
 public function get_order_count($financial_status ){

   $api_url="/admin/api/2020-10/orders/count.json?financial_status=".$financial_status;
   $counts=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());

   $counts=json_decode($counts['response']);
   foreach ($counts as $count) {
  
return $count;
  

   }



 }

 
 /**
  * get_checkout_count
  *
  * @param  string $status
  * @return array $count
  */
 public function get_checkout_count($status){

  $api_url="/admin/api/2020-10/checkouts/count.json";
  $counts=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());

  $counts=json_decode($counts['response'],true);
  foreach ($counts as $count) {
 
return $count;
 

  }



}
 
 


  public function get_all_order($status){

    $api_url="/admin/api/2020-10/orders.json?status=".$status;
    $orders=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
  
    $orders=json_decode($orders['response'],true);
 
    return $orders['orders'];
  
  
  
  }

  
  public function get_single_order($order_id){

    $api_url="/admin/api/2020-10/orders/".$order_id.".json?fields=customer,aa,line_items,aa";
    $orders=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
    $orders=json_decode($orders['response'],true);
    return $orders['order'];
  
  
  
  }


/**
 * get_address_to_order
 *
 * @param  int $order_id
 * @return void
 */
public function get_order_address($order_id){

  $api_url="/admin/api/2020-10/orders/".$order_id.".json?fields=shipping_address,aa";
  $orders=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
  $orders=json_decode($orders['response'],true);
  return $orders['order'];
}
  public function get_store_prp(){
  $api_url="/admin/api/2020-10/shop.json";
  $counts=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
  $store_prp=json_decode($counts['response'],true);
  return $store_prp['shop'];


}

}
?>