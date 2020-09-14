<?php

class WH_CRUD{

private $shared_tk;
private $private_tk;
private $store;
function __construct() {

  require_once 'DB_manage.php';
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
  
  $this->store=$_SESSION['shop_name'];
  $new_manage = new DB_manage($this->store);
  $this->shared_tk="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";
   $this->private_tk =  $new_manage->get_shop_token();

}

// destructor
function __destruct() {
    

}


private function get_prtivate_tk(){


  return $this->private_tk;

}
public function List_wh(){


  $counts=shopify_call($this->private_tk, $this->store,'/admin/api/2020-07/webhooks.json',array(),'GET',array());

  $counts=json_decode($counts['response']);
  
 return  var_export($counts);


}
public function Verify_wh(){




}


public function delete_wh(){



    
}

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
  $order_create_webhook = shopify_call($this->private_tk, $this->store, "/admin/api/2020-07/webhooks.json", $webhook_data, 'POST',$query);
  
  // Storage response
 return  var_dump($order_create_webhook['response']);
    
}

public function get_single_wh($id){


  $single=shopify_call($this->private_tk, $this->store,'/admin/api/2020-07/webhooks/'.$id.'.json',array(),'GET',array());

  $single=json_decode($single['response']);
  
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

  $order_create_webhook = shopify_call($this->private_tk, $this->store, "/admin/api/2020-07/webhooks/".$id.".json", $webhook_data, 'PUT',$query);

  $order_create_webhook=json_decode($order_create_webhook['response']);
  
 return  var_export($order_create_webhook);
    
}


}

?>