<!-- get latset 5 order where status is 3: Paid  -->
<!-- fetch customer name ,country  and number of  product and calcualate the GROSS SALES  -->
<?php
@ob_end_clean();
require_once (dirname(__FILE__, 4)) . '/base.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'SP_Order.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'API_Order.php';
$neworder = new SP_Order();
$api = new API_Order();
$latest_order = $neworder->get_latest_order(5);

$response = array();
$order_array = array();

$counter = 0;
$order_num = 0;
$total=0;
$cid = 0;
$fname = 'null';
$lname = 'null';
$ccountry='null';
$length=0;

foreach ($latest_order as $order)
{
    $api_result = $api->get_single_order($order['order_id']);
 
    if (empty($api_result))
    {
       
        // the order api return empty for this ID;
        

    }
    else
    {

$length=count($api_result);

if($length<1){

echo 'empty';

}else{

         
    if(array_key_exists('line_items',$api_result)){

        foreach($api_result['line_items'] as $line){
    
            $order_num=$order_num+$line['quantity'];
    
        }
        
    }
    if(array_key_exists('customer',$api_result)){
    
        $carray=$api_result['customer'];
        $cid=$carray['id'];
        $fname=$carray['first_name'];
        $lname=$carray['last_name'];
        $ccountry=$carray['default_address']['country_name'];
    }
   
    $order_array[$counter]=array(


        'counter'=>$counter,
        'cid'=>$cid,
        'fname'=>$fname,
        'lname'=>$cid,
        'cn'=>$ccountry,
        'nbitem'=>$order_num,
        'total'=>$order['total_amount']

        

    );
    $order_num = 0;
    $total=0;
    $cid = 0;
    $fname = 'null';
    $lname = 'null';
    $ccountry='null';
}

        }
   
      $counter=$counter+1;
    }


    header('Content-Type: application/json');
    die(print_r(json_encode($order_array)));




