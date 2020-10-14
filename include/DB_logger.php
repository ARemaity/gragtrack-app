<?php 


class DB_logger{
     
   
    private $conn;
  

    // constructor
    function __construct() {


        require_once 'DB_Connect.php';   
         $db = new DB_Connect();
         $this->conn = $db->connect();
  
      
             
      
      
  
    }

    // destructor
    function __destruct() {
        
    }
    public function insert_webhook_log($aid,$tag,$sub_tag,$id,$type){

            // TODO: ERROR: 
//Fatal error: Uncaught Error: Call to a member function bind_param() on bool in C:\xampp\htdocs\gragtrack2\include\DB_logger.php:33 Stack trace: #0 C:\xampp\htdocs\gragtrack2\index.php(58): DB_logger->insert_webhook_log(166, 'index', 'test', 0, 5) #1 {main} thrown in C:\xampp\htdocs\gragtrack2\include\DB_logger.php on line 33
                $stmt = $this->conn->prepare("INSERT INTO `webhook_log`( `fk_AID`, `tag`, `sub_tag`, `Identifier`, `type`) VALUES (?,?,?,?,?)");
                $bind_it=$stmt->bind_param("sssss",$aid,$tag,$sub_tag,$id,$type);
                $stmt->close();
                
                        if ($result) {
                            
                            return  true;
                
                       } else {
                  
                
                              return  $stmt->error;
                      }
                        
                 }
                    

}

?>