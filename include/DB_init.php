<?php 


class DB_init{
     
     private $new_order;
    private $conn;
    private $store_prp;
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';   
            // connect to DB 
         $db = new DB_Connect();
         $this->conn = $db->connect();
             // api order 
      
      
  
    }

    // destructor
    function __destruct() {
        
    }

    /**
     *  
     *
     *  new shop to access_token tbl.
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
            $url = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $url; 
        } else {
            return NULL;
        }
    } 


    
    /**
     * get_access_ID
     *
     * @param  mixed $shop_url
     * @return int 
     */
    public function get_access_ID($shop_url) {
        $stmt = $this->conn->prepare("SELECT  `AID` FROM access_token WHERE `shop_url`='$shop_url' ");
        if ($stmt->execute()) {			
            $aid = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $aid; 
        } else {
            return NULL;
        }
    } 


    
    /**
     * get_shop_plan
     *
     * @param  mixed $aid
     * @return string
     */
    public function get_shop_plan($aid) {
        $stmt = $this->conn->prepare("SELECT  `shop_plan_name` as plan  FROM store_prp WHERE `FK_AID`='$aid' ");
        if ($stmt->execute()) {			
            $plan = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return var_export($plan); 
        } else {
            return NULL;
        }
    }    
    
    
    /**
     * insert_store_prp
     * comment:get store_prp from api store and insert it to store_prp tbl 
     *
     * @param  mixed $get_store_prp<array>
     * @return boolean
     */
    public function insert_store_prp($get_store_prp){
$stmt = $this->conn->prepare("INSERT INTO `store_prp`(`FK_AID`, `shop_id`, `shop_name`, `shop_city`, `shop_domain`, `shop_address`, `shop_country`, `shop_source`, `shop_created_at`, `shop_plan_name`, `shop_setup_required`, `shop_timezone`, `owner_email`, `owner_phone`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("iissssssssisss",
$_SESSION['AID'],
$get_store_prp['id'],
$get_store_prp['name'],
$get_store_prp['city'],
$get_store_prp['domain'],
$get_store_prp['address1'],
$get_store_prp['country'],
$get_store_prp['source'],
$get_store_prp['created_at'],
$get_store_prp['plan_name'],
$get_store_prp['setup_required'],
$get_store_prp['iana_timezone'],
$get_store_prp['email'],
$get_store_prp['phone']
);

$result = $stmt->execute();
$stmt->close();

if ($result) {
      
    return  true;

} else {
  

    return false;
}



    }

    
    /**
     * update_setup 
     * @param int $id
     * argument_option $id: 
      (0):only access token,
     (1): 0 + store_prp, 
     (2):1+ account 
     * @param int $aid from session
     * 
     * @return boolean
     */
    public function update_setup($id,$aid) {
       
       
        $stmt = $this->conn->prepare("UPDATE access_token  SET `setup_level`=? WHERE `AID` =  ?");


$stmt->bind_param("ii",$id,$aid);
$result = $stmt->execute();
$stmt->close();
// check for successful store
if ($result) {
return true;
} else {
return false;
}
}


    
    /**
     * get_setup level from tbl access_token
     * @param int $aid
     *
     * @return int
     */
  
    public function get_setup($aid) {
        $stmt = $this->conn->prepare("SELECT  `setup_level` FROM access_token WHERE `AID`='$aid' ");
        if ($stmt->execute()) {			
            $setup = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $setup; 
        } else {
            return NULL;
        }
    } 


 
}


?>