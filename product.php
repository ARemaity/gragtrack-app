<?php

$products=shopify_call($token_code,$shop_name,"/admin/api/2020-07/products.json",array(),'GET',array());

$products=json_decode($products['response'],JSON_PRETTY_PRINT);
?>