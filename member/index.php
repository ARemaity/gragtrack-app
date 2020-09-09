<?php


require_once '../base.php';
require_once '../'.DIR_INC.'API_Order.php';
require_once '../'.DIR_INC.'DB_init.php';
$api_order = new API_Order();
$conf_init=new DB_init();
?>

<!-- UC4 ::part 1 -->
<?php

echo 'UC4 ::part 1 OUTPUT((('.$api_order->get_order_count('any').')))'


?>

<!-- UC5 :: part 1  -->
<?php


echo 'UC5 ::part 1 OUTPUT((('.$api_order->get_checkout_count('open').')))'


?>
<!-- UC5 :: part 1  -->



