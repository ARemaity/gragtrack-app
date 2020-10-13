<?php
    // Producer P
    namespace MyObjSummary\rabbitMQ;
    require 'BaseMQ.php';
    class ProductMQ extends BaseMQ
    {
        Private $routes = ['hello','word']; // routing key
    
        /**
         * ProductMQ constructor.
         * @throws \AMQPConnectionException
         */
        public function __construct()
        {
           parent::__construct();
        }
    
      
        public function run()
        {
            // Channel
            $channel = $this->channel();
            // Creating Switch Objects
            $ex = $this->exchange();
            // Message content
            $message = 'product message '.rand(1,99999);
            // Start a business
            $channel->startTransaction();
            $sendEd = true ;
            foreach ($this->routes as $route) {
                $sendEd = $ex->publish($message, $route) ;
                echo "Send Message:".$sendEd."\n";
            }
            if(!$sendEd) {
                $channel->rollbackTransaction();
            }
            $channel -> commitTransaction ();
            $this->close();
            die ;
        }
    }
    try{
        (new ProductMQ())->run();
    }catch (\Exception $exception){
        var_dump($exception->getMessage()) ;
    }