<?php 


class SP_Order{
     
    private $conn;
    private $store_prp;
    private $aid;
    // constructor
    function __construct() {


        require_once 'DB_Connect.php';   
         $db = new DB_Connect();
         $this->conn = $db->connect1();
         // in case session is not activated start it 
       if (session_status() == PHP_SESSION_NONE) {
        session_start();
       }
       $this->aid=$_SESSION['AID'];
    }

    // destructor
    function __destruct() {
        
    }

    public function insert_order($order_array,$status){

     
        $create = date('Y-m-d', strtotime($order_array['created_at']));
        $stmt = $this->conn->prepare("INSERT INTO `sp_order`(`fk_AID`, `order_id`, `total_amount`,`status`, `created_at`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iiiis",
        $_SESSION['AID'],
        $order_array['id'],
        $order_array['total_price'],
        $status,
        $create
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        if ($result) {
              
            return  true;
        
        } else {
          
        
            return false;
        }
        

    }

    // public function update_order(){


    // }

    // public function get_order(){


    // }
    // public function delete_order(){


    // }

  
}

?>