<?php 





class API_Event{
      


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



 
 


  public function get_all_event(){

    $api_url="/admin/api/2020-10/events.json?limit=10&filter=Product,Order";
    $events=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
  
    $events=json_decode($events['response'],true);
    if(array_key_exists('errors',$events)){

        return null;
       }else{
    return $events['events'];
       }
  
  
  }

  public function get_all_event_verb($status,$verbs){

    $api_url="/admin/api/2020-10/events.json?filter=".$status."&verb=".$verbs;
    $events=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
  
    $events=json_decode($events['response'],true);
 
    return $events['events'];
  
  
  
  }


  
  public function get_single_order($event_id){

    $api_url="/admin/api/2020-10/events/".$event_id.".json";
    $event=shopify_call($this->token_code,$this->shop_url,$api_url,array(),'GET',array());
    $event=json_decode($event['response'],true);
    return $event['event'];
  
  
  
  }



}
?>