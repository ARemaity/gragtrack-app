
<?php
@ob_end_clean();
if(isset($_POST)){
   $type=null;
   $status=null;
if(isset($_POST['query'])){
    $query=$_POST['query'];
    if (is_array($query)&&!empty($query)) {
        extract($query);
        
     }
}

require_once (dirname(__FILE__, 4)) . '/base.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'SP_Order.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'API_Order.php';
$neworder = new SP_Order();
$api = new API_Order();
$get_order = $neworder->get_product_order();


$response = array();

// $response['meta']=array(

//     'page'=>1,
//     'pages'	=>1,
//     'perpage'=>100,
//     'total'=>68,
//     'sort'=>"asc",
//     'field'	=>"Type"

// );
$order_name='null';
$created_at='0000-00-00';
$status='null';
$type=0;
$customer_name='no name';
$total=0.0;
if(!is_null($get_order)){

     foreach($get_order as $order){

        


     }
}

    header('Content-Type: application/json');
    echo json_encode($order_array);



}
