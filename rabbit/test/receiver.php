<?php

require (dirname(__FILE__,2)).'/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


$host='hummingbird-01.rmq.cloudamqp.com';
$user='ockjazzb';
$password='vLxL4qkoxrZ74aHmQJstSnLjW9pHboG2';
$port='5672';
$vhost='ockjazzb';

$connection = new AMQPStreamConnection($host, $port,$user, $password,$vhost);
$channel = $connection->channel();
$channel->queue_declare('hello1', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback=function ($msg){

echo 'x recieved',$msg->body,"\n";
};

$channel->basic_consume('hello1', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}