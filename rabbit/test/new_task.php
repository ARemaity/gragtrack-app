<?php

require (dirname(__FILE__,2)).'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host='hummingbird-01.rmq.cloudamqp.com';
$user='ockjazzb';
$password='vLxL4qkoxrZ74aHmQJstSnLjW9pHboG2';
$port='5672';
$vhost='ockjazzb';
// this to setup the connection
$connection = new AMQPStreamConnection($host, $port,$user, $password,$vhost);
$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);
// to setup the data 
$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}

// this to setup the data into the message with delivery persistent
$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);

// to setup  basic publish to the queue
$channel->basic_publish($msg, '', 'task_queue');

echo ' [x] Sent ', $data, "\n";

$channel->close();
$connection->close();
?>
