<!-- get latset 5 order where status is 3: Paid  -->
<!-- fetch customer name ,country  and number of  product and calcualate the GROSS SALES  -->
<?php
@ob_end_clean();
require_once (dirname(__FILE__, 4)) . '/base.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'SP_Order.php';
$neworder = new SP_Order();
$latest_order = $neworder->get_latest_order(5);
$response = array();

echo json_encode($order_array);




