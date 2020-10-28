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
    public function init_insert_product($oid,$pid,$vid,$qty,$cost){

        $stmt = $this->conn->prepare("INSERT INTO `sp_product`(`fk_OID`,  `product_id`,`variant_id`, `qty`,`single_cost`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iiiii",
        $oid,
        $pid,
        $vid,
        $qty,
        $cost
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


        public function get_top_five(){
            $stmt = $this->conn->prepare("SELECT product_id,variant_id,sum(qty) as counts from sp_product INNER JOIN sp_order ON sp_product.fk_OID=sp_order.OID AND sp_order.fk_AID=? GROUP by product_id ORDER BY SUM(qty) DESC LIMIT 5");
            $stmt->bind_param("i",$this->aid);
        if ($stmt->execute()) {			
            $prs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        
            return $prs; 
        } else {
            return NULL;
        }
        }

        public function best_seller(){
            $stmt = $this->conn->prepare("SELECT product_id,variant_id,sum(qty) as counts from sp_product INNER JOIN sp_order ON sp_product.fk_OID=sp_order.OID AND sp_order.fk_AID=? AND sp_order.status=3  GROUP by variant_id ORDER BY SUM(qty) DESC LIMIT 5");
            $stmt->bind_param("i",$this->aid);
        if ($stmt->execute()) {			
            $prs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        
            return $prs; 
        } else {
            return NULL;
        }
        }

  


        public function get_product_order($oid){


  $stmt = $this->conn->prepare("
  SELECT variant_id,qty,single_cost 
  
  from sp_product 
  
  INNER JOIN sp_order

  ON sp_product.fk_OID=sp_order.OID

  WHERE sp_product.fk_OID = ? AND sp_order.fk_AID = ?

  
    ");
            $stmt->bind_param("ii",$oid,$this->aid);
        if ($stmt->execute()) {			
            $prs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        
            return $prs; 
        } else {
            return NULL;
        }

        }

        public function get_product_order2($oid){


            $stmt = $this->conn->prepare("
            SELECT product_id,variant_id,count(qty) as qty 
            
            from sp_product 
            
            INNER JOIN sp_order
          
            ON sp_product.fk_OID=sp_order.OID
          
            WHERE sp_product.fk_OID = ? AND sp_order.fk_AID = ?

          group by `product_id`
            
              ");
              $stmt->bind_param("ii",$oid,$this->aid);
                  if ($stmt->execute()) {			
                      $prs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                      $stmt->close();
                  
                      return $prs; 
                  } else {
                      return NULL;
                  }
          
                  }
          

        public function delete_order_products($oid) {
            $stmt = $this->conn->prepare("DELETE FROM `sp_product` WHERE fk_OID = ? ");
            $stmt->bind_param("i",$oid);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
            return true;
            } else {
            return false;
            }
            }

          
        public function get_all_order($oid){


            $stmt = $this->conn->prepare("
            SELECT `OID`,`order_id`, `order_name`, `customer_id`,  `total_amount`, `test`, `status`, `created_at`,count(
                SELECT  * 
            
            from sp_product 
            
            INNER JOIN sp_order
          
            ON sp_product.fk_OID=sp_order.OID
          
            WHERE sp_product.fk_OID = 11 

         
                )AS QTYS            
            
            WHERE sp_order.OID = 11

           group by `OID`
            
              ");
              $stmt->bind_param("ii",$oid,$this->aid);
                  if ($stmt->execute()) {			
                      $prs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                      $stmt->close();
                  
                      return $prs; 
                  } else {
                      return NULL;
                  }
          
                  }  

}

?>