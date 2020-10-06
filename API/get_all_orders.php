<?php

require_once (dirname(__FILE__,2)).'/base.php';
require_once  (dirname(__FILE__,2)).'/'.DIR_INC.'API_Order.php';
$neworder=new API_Order();

$get_all=$neworder->get_all_order('any');


if(empty($get_all)){
echo "empty";


}else{


    foreach($get_all as $order){


        if(!empty($order['shipping_lines'])){

            $ship=$order['shipping_lines'];
            echo var_export($ship);
            echo '///////';



        }

        if(!empty($order['refund'])){


       
        }

        echo 
        $order['id']."id  ".
        $order['total_price']."total_price   ".
        $order['total_tax']."total_tax   ".
        $order['taxes_included']."taxes_included  ".
        $order['total_discounts']."total_discounts  ".
        $order['total_line_items_price']."total_line_items_price  ".
        $order['total_tip_received']."total_tip_received  ".
        $order['total_line_items_price']."total_line_items_price  ".
        $order['total_price']."total_price  ";
        
    }
}
?>