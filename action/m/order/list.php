
<?php
@ob_end_clean();
if(isset($_POST)){
   $Type=null;
   $Status=null;
   $query='';
   $queryst=0;
   $get_order=array();
if(isset($_POST['query'])){
    $response = array();
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
$get_order = $neworder->get_product_order($Status,$Type);
$count=0;
$type=0;
$handler=array();
$response['meta']=array();

$response['data']=array();


if(!is_null($get_order)){

     foreach($get_order as $order){

        $handler=array(

'Oid'=>$order['OID'],
'Order_name'=>$order['order_name'],
'Customer_id'=>$order['customer_id'],
'Total_amount'=>$order['total_amount'],
'Type'=>$order['type'],
'Status'=>$order['status'],
'Created_at'=>$order['created_at']


        );
array_push($response['data'],$handler);

$count=$count+1;
     }
}


$response['meta']=array(

    'page'=>1,
    'pages'	=>1,
    'perpage'=>-1,
    'total'=>$count,
    'sort'=>"asc",
    'field'	=>"Oid"

);
    header('Content-Type: application/json');
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS' );
header( 'Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description' );
    echo json_encode($response);



}
