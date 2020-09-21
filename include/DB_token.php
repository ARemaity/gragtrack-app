<?php 

// this class can be access after verifying that the shop exsit in access_token table otherwise the init of the constructor will corrupt 

// HACK: this class provide tk for API_Order // WH_CRUD

// TODO: change name to token class
class DB_token{
     
    private $new_order;
    private $conn;
    private $store_prp;
    private $tk;
    // constructor
    function __construct($shop_url) {
        require_once 'DB_Connect.php';   
         $db = new DB_Connect();
         $this->conn = $db->connect();
         $stmt = $this->conn->prepare("SELECT  `token_code` FROM access_token WHERE `shop_url`='$shop_url' ");
         if ($stmt->execute()) {			
             $url = $stmt->get_result()->fetch_assoc();
             $this->tk=$url['token_code'];
             $stmt->close();
            
         }
      
  
    }

    // destructor
    function __destruct() {
        
    }



   /**
     * return private tk var
     */
    public function get_shop_token() {
       return $this->tk;
    } 



    
   


    
 


 
}


?>