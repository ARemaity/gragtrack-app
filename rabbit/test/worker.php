<?php

require (dirname(__FILE__,2)).'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


$host='hummingbird-01.rmq.cloudamqp.com';
$user='ockjazzb';
$password='vLxL4qkoxrZ74aHmQJstSnLjW9pHboG2';
$port='5672';
$vhost='ockjazzb';

$connection = new AMQPStreamConnection($host, $port,$user, $password,$vhost);
$channel = $connection->channel();
// decalre queue with fourth one to false to TURN ON THE ACK 
$channel->queue_declare('task_queue', false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";
// at callback we reived and sleep 1 second for every (.) then send ACK to the PUBLISHER    that we received IT 
$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>