<?php 





class API_Order{
     
     

private $token_code;
private $shop_url;

    // constructor
    function __construct() {    
        require_once '../base.php';
        require_once '../'.DIR_INC.'functions.php';
        require_once 'API_Config.php';

       
        $new_api = new API_Config();
        $this->token_code = $new_api->get_token_code();
        $this->shop_url = $new_api->get_shop_url();
    }

    // destructor
    function __destruct() {
        
    }


     
 
 /** link:https://shopify.dev/docs/admin-api/rest/reference/orders/order#count-2020-07
  * get_order_count
  *
  * @param  mixed $financial_status(
(default: any)
authorized: Count authorized orders.
pending: Count pending orders.
paid: Count paid orders.
refunded: Count refunded orders.
voided: Count voided orders.
any: Count orders of any financial status.)
  * @return $counts
  */
 public function get_order_count($financial_status ){

   $api_url="/admin/api/2020-07/orders/count.json?financial_status=".$financial_status;
   $counts=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
   $counts=json_decode($counts['response'],JSON_PRETTY_PRINT);
   return $counts;

 }
 
}


?>