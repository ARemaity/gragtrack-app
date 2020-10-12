<?php


require (dirname(__FILE__,2)).'/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMPQ
{
    private $connection;
    private $queueName;
    private $channel;
    private $callback;
    private $exchange;
    private $consumer_tag;

    public function __construct($host, $port, $login, $password, $queueName,$exchange,$ctag)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $login, $password);
        $this->queueName = $queueName;
        $this->delayedQueueName = null;
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->exchange_declare($exchange,'direct',false,true,false);
        $this->channel->queue_bind($queueName,$exchange);
        $this->consumer_tag=$ctag;
        
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        if (!is_null($this->channel)) {
            $this->channel->close();
            $this->channel = null;
        }

        if (!is_null($this->connection)) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    public function produceWithDelay($data, $delay)
    {
        if (is_null($this->delayedQueueName))
        {
            $delayedQueueName = $this->queueName . '.delayed';

            $this->channel->queue_declare($delayedQueueName, false, true, false, false, false,
                new AMQPTable(array(
                    'x-dead-letter-exchange' => '',
                    'x-dead-letter-routing-key' => $this->queueName
                ))
            );

            $this->delayedQueueName = $delayedQueueName;
        }

        $msg = new AMQPMessage(
            $data,
            array(
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                'expiration' => $delay
            )
        );

        $this->channel->basic_publish($msg, '', $this->delayedQueueName);
    }

    public function produce($data)
    {
        $msg = new AMQPMessage(
            $data,
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,   'content_type'=>'application/json')
        );
        
        $this->channel->basic_publish($msg,$this->$exchange);
    }

    public function consume($callback)
    {
        $this->callback = $callback;

        $this->channel->basic_qos(null, 1, null);
        
      
        
        $this->channel->basic_consume($this->queueName, $this->consumer_tag, false, false, false, false, array($this, 'callback'));

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    public function callback($msg)
    {
        call_user_func_array(
            $this->callback,
            array($msg)
        );

        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }
}