<?php


require_once '../base.php';
require_once Root_DIR_API.'API_Order.php';
$api_order = new API_Order();
?>

<!-- UC4 ::part 1 -->
<?php

//'UC4 ::part 1 OUTPUT((('.$api_order->get_order_count('any').')))'


?>

<!-- UC5 :: part 1  -->
<?php


//'UC5 ::part 1 OUTPUT((('.$api_order->get_checkout_count('open').')))'


?>

<!-- UC5 :: part 1  -->
<?=$api_order->get_store_prp()?>



