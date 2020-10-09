<?php

require (dirname(__FILE__,2)).'/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$faker = Faker\Factory::create();
$host='hummingbird-01.rmq.cloudamqp.com';
$user='ockjazzb';
$password='vLxL4qkoxrZ74aHmQJstSnLjW9pHboG2';
$port='5672';
$vhost='ockjazzb';
$exchange='shopify_exchange';
$queue='shopify_queue';
$connection = new AMQPStreamConnection($host, $port,$user, $password,$vhost);
$channel = $connection->channel();
$counter=0;
$channel->queue_declare($queue, false, true, false, false);
$channel->exchange_declare($exchange,'direct',false,true,false);
$channel->queue_bind($queue,$exchange);
$handler=array();
$message_array=array();
while($counter<100){

    $handler=array(


        'name'=>$faker->name,
        'email'=>$faker->email


    );

    array_push($message_array,$handler);
    $counter+=1;
}


$data=json_encode($message_array);
// this to setup the data into the message with delivery persistent
$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,   'content_type'=>'application/json')
);


// to setup  basic publish to the queue
$channel->basic_publish($msg,$exchange);

echo ' [x] Sent ', $data, "\n";
$channel->close();
$connection->close();
?>
