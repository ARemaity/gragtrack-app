<?php 


class DB_Report{
     

    private $conn;
    private $store_prp;
    private $aid;
    // constructor
    function __construct() {


        require_once 'DB_Connect.php';   
         $db = new DB_Connect();
         $this->conn = $db->connect();
         // in case session is not activated start it 
       if (session_status() == PHP_SESSION_NONE) {
        session_start();
       }
      
             
      
      
  
    }

    // destructor
    function __destruct() {
        
    }


    public function get_net_profit(){



    }

    public function get_order_nb(){


    }

    public function get_abandoned_checkouts(){

    }
    
    
    

    
}

?>