<?php

@ob_end_clean();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['AID'])):
    if(isset($_POST)&&isset($_POST['get_json'])):
//Get base class
require_once (dirname(__FILE__,5)).'/base.php';
require_once  (dirname(__FILE__,5)).'/'.DIR_INC.'API_Order.php';

$newapi=new API_Order();
$get_checkout=$newapi->get_checkout_list();
var_dump($get_checkout);
$response=array();


$response['isdata']=0;
$response['data']=array();
if(!is_null($get_checkout)){
    $response['isdata']=1;
    $customer=null;
    foreach($get_checkout as $checkout){
        $customer_id='null';
        $name='no name';
        $email='no email';

        if(!empty($checkout['customer'])){


            $customer_id=$checkout['customer']['id'];
        }
        if(!empty($checkout['email'])){
            $email=$checkout['email'];
        }
        if(!empty($checkout['shipping_address'])){


           $name=$checkout['shipping_address']['first_name'].' '.$checkout['shipping_address']['last_name'];
        }
$data=array(
'id'=> $checkout['id'],
'cart_name'=> $checkout['name'],
'link'=> $checkout['abandoned_checkout_url'],
'email'=> $email,
'total_price'=> $checkout['total_price'],
'created_at'=> date('Y-m-d H:i:s', strtotime($checkout['created_at'])),
'name'=> $name,
'customer_id'=>$customer_id


);


array_push($response['data'],$data);

    }
    if($response['isdata']==1){


        $PATH2_json='user/'.$_SESSION['AID'].'/json/';  
        $path=(dirname(__FILE__,5)).'/webhook/'.$PATH2_json.'abond_cart.json';  
 $fp = fopen($path, 'w');
 if($fp){
fwrite($fp, json_encode($response));
fclose($fp);
echo "1";
 }
// success
    }
}
endif;
endif;
?>