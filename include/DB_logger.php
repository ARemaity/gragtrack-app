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

            
                $stmt = $this->conn->prepare("INSERT INTO `webhook_log`( `fk_AID`, `tag`, `sub_tag`, `Identifier`, `type`) VALUES (?,?,?,?,?)");
                $stmt->bind_param("i,s,s,i,i",$aid,$tag,$sub_tag,$id,$type);
                $result = $stmt->execute();
                $stmt->close();
                
                        if ($result) {
                            
                            return  true;
                
                       } else {
                  
                
                              return false;
                      }
                        
                 }
                    

}

?>