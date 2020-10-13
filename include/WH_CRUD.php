<?php

class WH_CRUD{

private $shared_tk;
private $private_tk;
private $store;
function __construct() {
  require_once 'functions.php';
  require_once 'DB_token.php';
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
  $this->store=$_SESSION['shop_name'];
  $new_manage = new DB_token($this->store);
  $this->shared_tk='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';
   $this->private_tk =  $new_manage->get_shop_token();

}

// destructor
function __destruct() {
    

}


/**
 * List_wh for specific shop
 *
 * @return array response
 */
public function List_wh(){


  $counts=shopify_call($this->private_tk, $this->store,'/admin/api/2020-10/webhooks.json',array(),'GET',array());

  $counts=json_decode($counts['response'],true);
  
 return  $counts['webhooks'];


}


public function delete_wh($id){



  $delete=shopify_call($this->private_tk, $this->store,'/admin/api/2020-10/webhooks/'.$id.'.json',array(),'DELETE',array());

  $delete=json_decode($delete['response'],true);
  
 return  $delete;
    
}

/**
 * register_wh through post request
 *
 * @param  string  $topic
 * @param  string  $address
 * @return array $response
 */
public function register_wh($topic,$address){


  $query = array(
    "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
  );
  
  // Webhook content, including the URL to POST to
  $webhook_data = array(
    'webhook' =>
    array(
      'topic' =>$topic,
      'address' => $address,
      'format' => 'json'
    )
  );
  
  
  // Run API call to modify the product
  $order_create_webhook = shopify_call($this->private_tk, $this->store, "/admin/api/2020-10/webhooks.json", $webhook_data, 'POST',$query);

  $order_create_webhook=json_decode($order_create_webhook['response'],true);
  return $order_create_webhook['webhook'];
    
}

/**
 * get_single_wh 
 *
 * @param  int $id
 * @return array $response
 */
public function get_single_wh($id){


  $single=shopify_call($this->private_tk, $this->store,'/admin/api/2020-10/webhooks/'.$id.'.json',array(),'GET',array());

  $single=json_decode($single['response'],true);
  
 return  var_export($single);
    
}

public function update_single_wh($id,$address){
  $query = array(
    "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
  );
  
  // Webhook content, including the URL to POST to
  $webhook_data = array(
    'webhook' =>
    array(
      'id' =>$id,
      'address' => $address,
     
    )
  );

  $order_create_webhook = shopify_call($this->private_tk, $this->store, "/admin/api/2020-10/webhooks/".$id.".json", $webhook_data, 'PUT',$query);

  $order_create_webhook=json_decode($order_create_webhook['response'],true);
  
 return $order_create_webhook['webhook'];
    
}


}

?>