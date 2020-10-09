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
$channel->queue_declare('shopify_queue', false, true, false, false);
$channel->exchange_declare($exchange,'direct',false,true,false);
$channel->queue_bind('shopify_queue',$exchange);


function process_message(AMQPMessage $message)
{

    
$data=$message->body;
$fo=fopen('data/data.json','w');
fwrite($fo,$data);


    $message->ack();
sleep(1);
    // if ($message->body === 'quit') {
    //     $message->getChannel()->basic_cancel($message->getConsumerTag());
    // }
}

$consumer_tag='fetch_order';
$channel->basic_consume($queue, $consumer_tag, false, false, false, false, 'process_message');

function shutdown($channel, $connection)
{
    $channel->close();
    $connection->close();
}

register_shutdown_function('shutdown', $channel, $connection);

// Loop as long as the channel has callbacks registered
while ($channel ->is_consuming()) {
    $channel->wait();
}