<?php 

//America/New_York

class DB_init{
     
     private $new_order;
    private $conn;
    private $store_prp;
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';   
        require_once 'API_Order.php';
            // connect to DB 
            $db = new DB_Connect();
            $this->conn = $db->connect();
            // api order 
        $this->new_order=new API_Order();
      
  
    }

    // destructor
    function __destruct() {
        
    }

    /**
     *  
     *
     * C. new shop to access_token tbl.
     * 
     * 
     * */
    public function insert_into_access_token($shop_url,$token_code) {
                                   
        $stmt = $this->conn->prepare("INSERT INTO `access_token`(`AID`, `shop_url`, `token_code`, `access_time`) VALUES (NULL,'$shop_url','$token_code',NULL)");
        $result = $stmt->execute();
        $last_id=$stmt->insert_id;
        $stmt->close();
    // check for successful store
    if ($result) {
        return $last_id;
    } else {
        return $last_id;
    }
}


    /**
     *  
     * check if shop exist 
     * */
    public function check_if_store_exsit($shop_url) {
                                   
        $stmt = $this->conn->prepare("SELECT * FROM `access_token` WHERE shop_url='$shop_url'");
      
        $result = $stmt->execute();
        $stmt->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it!

        if ($stmt->num_rows >= "1") {
return TRUE;
        }else{
            return FALSE;
            
        }
   
       
}
   /**
     * Get tokn code of speceific shop from access_token tbl
     */
    public function get_shop_token($shop_url) {
        $stmt = $this->conn->prepare("SELECT  `token_code` FROM access_token WHERE `shop_url`='$shop_url' ");
        if ($stmt->execute()) {			
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $user; 
        } else {
            return NULL;
        }
    } 

    public function get_store_prp(){
        
    $get_store_prp= $this->new_order->get_store_prp();





    }


 
}


?>