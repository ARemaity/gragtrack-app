<?php 


class SP_Product{
     
     private $new_product;
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


    // init : get aid from session where for webhook must inserted in the args 
    public function init_insert_product($pid,$count){

        $stmt = $this->conn->prepare("INSERT INTO `sp_product`(`fk_AID`, `product_id`, `count`) VALUES (?,?,?)");
        $stmt->bind_param("iii",
        $this->aid,
        $pid,
        $count
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        if ($result) {
              
            return  true;
        
        } else {
          
        
            return false;
        }
        

    }


    public function init_check($pid){
      $query = "SELECT * FROM `sp_product` WHERE `product_id`=? AND `fk_AID` = ?";
      if($stmt = $this->conn->prepare($query))
      {
        $stmt->bind_param("ii",$pid,$this->aid);
          if($stmt->execute())
          {

              $stmt->store_result();
              $stmt->fetch();          
              if($stmt->num_rows > 0)
              {
                  return true;
              }
              return false;
          }
          return false;
      }
      return false;

    }

        /**
     * Get tokn code of speceific shop from access_token tbl
     *
     * @param  string  $shop_url
     * @return array ['token_code']
     */
    public function init_get_count($pid) {
        $stmt = $this->conn->prepare("SELECT `count` FROM sp_product WHERE `fk_AID`= ? AND `product_id`= ?");
        $stmt->bind_param("ii",$this->aid,$pid);
        if ($stmt->execute()) {			
            $url = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $url; 
        } else {
            return NULL;
        }
    } 


    public function init_update_count($pid,$count) {
        $stmt = $this->conn->prepare("UPDATE sp_product  SET `count`=?  WHERE `product_id` =  ? AND `fk_AID` = ? ");
        $stmt->bind_param("iii",$count,$pid,$this->aid);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
        return true;
        } else {
        return false;
        }
        }

  
}

?>