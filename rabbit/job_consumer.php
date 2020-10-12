<?php
require_once 'test/AMPQ.php';
$host='hummingbird-01.rmq.cloudamqp.com';
$login='ockjazzb';
$password='vLxL4qkoxrZ74aHmQJstSnLjW9pHboG2';
$port='5672';
$vhost='ockjazzb';
$exchange='shopify_exchange';
$queue='shopify_queue';
$ctag='fetch_order';
$newmq=new AMPQ($host, $port, $login, $password, $queue,$exchange,$ctag);

$consume=$newmq->consume();
?>

