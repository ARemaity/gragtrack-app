<?php 


class DB_logger{
     
   
    private $conn;
  

    // constructor
    function __construct() {


        require_once 'DB_Connect.php';   
         $db = new DB_Connect();
         $this->conn = $db->connect1();
         if (session_status() == PHP_SESSION_NONE) {
            session_start();
           }
          
      
             
      
      
  
    }

    // destructor
    function __destruct() {
        
    }
    public function insert_webhook_log($aid,$tag,$sub_tag,$id,$type){
        
        $now=gmdate('Y-m-d H:i:s T');
        $stmt = $this->conn->prepare("INSERT INTO `webhook_log`( `fk_AID`, `tag`, `sub_tag`, `Identifier`, `type`,`created_at`) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("issiis",
        $aid,$tag,$sub_tag,$id,$type,$now
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        if ($result) {
              
            return  true;
        
        } else {
          
        
            return false;
        }
        
        
        
            }
        
            public function get_webhook_log(){

                $stmt = $this->conn->prepare("SELECT  `tag`, `sub_tag`, `Identifier`, `type`, `status`, `created_at` FROM `webhook_log` WHERE fk_AID=? ORDER by WLID DESC  limit 10");
                $stmt->bind_param("i",$_SESSION['AID']);
            if ($stmt->execute()) {			
                $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
            
                return $orders; 
            } else {
                return NULL;
            }
            
            
        }          

}

?>