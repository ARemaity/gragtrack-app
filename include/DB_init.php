<?php 


class DB_init{
     
     private $new_order;
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

    /**
     *  
     *
     *  new shop to access_token tbl.
     * 
     * 
     * */
    public function insert_into_access_token($shop_url,$token_code) {
                                   
        $stmt = $this->conn->prepare("INSERT INTO `access_token`(`AID`, `shop_url`, `token_code`, `install_time`) VALUES (NULL,'$shop_url','$token_code',NULL)");
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
     // check in case , they installed 
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
     *
     * @param  string  $shop_url
     * @return array ['token_code']
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

    public function update_shop_token($shop_url,$token) {
        $stmt = $this->conn->prepare("UPDATE access_token  SET `token_code`=?  WHERE `shop_url` =  ?");
        $stmt->bind_param("ss",$token,$shop_url);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
        return true;
        } else {
        return false;
        }
        }

    /**
     * Get tokn code of speceific shop from access_token tbl
     *
     * @param  string  $shop_url
     * @return array ['token_code']
     */
    public function get_shop_status($shop_url) {
        $stmt = $this->conn->prepare("SELECT  `isactive` FROM access_token WHERE `shop_url`=? ");
        $stmt->bind_param("s",$shop_url);
        if ($stmt->execute()) {			
            $st = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $st; 
        } else {
            return NULL;
        }
    } 


    
    /**
     * get_access_ID
     *
     * @param  string  $shop_url
     * @return array  array['AID']
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
     * @param  int  $aid
     * @return array array['plan']
     */
    public function get_shop_plan($aid) {
        $stmt = $this->conn->prepare("SELECT  `shop_plan_name` as plan,`shop_currency` as currency,`shop_timezone` as tmz  FROM store_prp WHERE `FK_AID`='$aid' ");
        if ($stmt->execute()) {			
            $plan = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $plan; 
        } else {
            return NULL;
        }
    }    
    
    public function disable_status($store_aid) {
        $stmt = $this->conn->prepare("UPDATE access_token  SET `isactive`='0' WHERE `AID` =  ?");
        $stmt->bind_param("i",$store_aid);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
        return true;
        } else {
        return false;
        }
        }


        public function enable_status($shop_url) {
            $stmt = $this->conn->prepare("UPDATE access_token  SET `isactive`='1' WHERE `shop_url` =  ?");
            $stmt->bind_param("s",$shop_url);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
            return true;
            } else {
            return false;
            }
            }
    /**
     * insert_store_prp
     * comment:get store_prp from api store and insert it to store_prp tbl 
     *
     * @param  array $get_store_prp
     * @return boolean
     */
public function insert_store_prp($get_store_prp){
$stmt = $this->conn->prepare("INSERT INTO `store_prp`(`FK_AID`, `shop_id`, `shop_name`, `shop_city`, `shop_domain`, `shop_address`, `shop_country`,  `shop_currency`, `shop_money_format`, `shop_created_at`, `shop_plan_name`, `shop_setup_required`, `shop_timezone`, `owner_email`, `owner_phone`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("iissssssssissss",
$_SESSION["AID"],
$get_store_prp['id'],
$get_store_prp['name'],
$get_store_prp['city'],
$get_store_prp['domain'],
$get_store_prp['address1'],
$get_store_prp['country'],
$get_store_prp['currency'],
$get_store_prp['money_format'],
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

    

    public function get_shop_timezone(){
       $aid= $_SESSION["AID"];

        $stmt = $this->conn->prepare("SELECT  `shop_timezone` as timezone  FROM store_prp WHERE `FK_AID`='$aid' ");
        if ($stmt->execute()) {			
            $tmz = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $tmz; 
        } else {
            return NULL;
        }


    }
    
    public function get_shop_prp(){
        $aid= $_SESSION["AID"];
 
         $stmt = $this->conn->prepare("SELECT  `shop_address` as saddress ,`shop_name` as sname  FROM store_prp WHERE `FK_AID`='$aid' ");
         if ($stmt->execute()) {			
             $tmz = $stmt->get_result()->fetch_assoc();
             $stmt->close();
             return $tmz; 
         } else {
             return NULL;
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
    public function update_setup($id) {
$stmt = $this->conn->prepare("UPDATE access_token  SET `setup_level`=? WHERE `AID` =  ?");
$stmt->bind_param("ii",$id,$_SESSION["AID"]);
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

    
    /**
     * insert into account tbl 
     * cost must be checked before processing this fcn
     * if cost if 0 continue else my be redirected to insert in transaction page and tbl 
     *
     * @param  int $plan
     * @param  int $iscap
     * @param  int $created_date
     * @param  int $expired_date
     *  
     * @return bool
     */
    public function insert_into_account($plan,$iscap,$created_date,$expired_date){
// by default 
    
        $stmt = $this->conn->prepare("INSERT INTO `account`(`fk_AID`, `fk_PID`, `created_at`, `expired_date`, `is_capable`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iissi",$_SESSION["AID"],$plan,$created_date,$expired_date,$iscap);
        $result = $stmt->execute();
        $stmt->close();
        
                if ($result) {
                    
                    return  true;
        
               } else {
          
        
                      return false;
              }
                
         }
            
            /**
             * get_plan_att
             *
             * @param  int $pid PID of plan tbl 
             * @return array of plan attr
             */
            public function get_plan_att($pid){
                
                $stmt = $this->conn->prepare("SELECT `cost`,`duration`,`type` FROM `plan` WHERE PID = ?");
                $stmt->bind_param("i",$pid);
                if ($stmt->execute()) {			
                    $plan_cost = $stmt->get_result()->fetch_assoc();
                    $stmt->close();
                    return $plan_cost; 
                } else {
                    return NULL;
                }

            }
    /**
             * get_plan_att
             *
             * @param  int $pid PID of plan tbl 
             * @return array of plan attr
             */
            public function get_account_att($aid){
                
                $stmt = $this->conn->prepare("SELECT * FROM `account` WHERE fk_AID = ?");
                $stmt->bind_param("i",$aid);
                if ($stmt->execute()) {			
                    $account = $stmt->get_result()->fetch_assoc();
                    $stmt->close();
                    return $account; 
                } else {
                    return NULL;
                }

            }
/**
             * get_plan_shop_type
             *
             * @param  int $aid FK_AID of account tbl 
             * @return array of plan attr
             */
            public function get_shop_plan_type($aid){
                
                $stmt = $this->conn->prepare("SELECT `type` FROM `plan` LEFT JOIN account ON account.fk_PID=plan.PID AND account.fk_AID = ? ");
                $stmt->bind_param("i",$aid);
                if ($stmt->execute()) {			
                    $plan_cost = $stmt->get_result()->fetch_assoc();
                    $stmt->close();
                    return $plan_cost; 
                } else {
                    return NULL;
                }

            }

            


          
          /**
           * getIPAddress
           *
           * @return mixed $ip
           */
          public   function getIPAddress() {  
                //whether ip is from the share internet  
                 if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                            $ip = $_SERVER['HTTP_CLIENT_IP'];  
                    }  
                //whether ip is from the proxy  
                elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
                 }  
            //whether ip is from the remote address  
                else{  
                         $ip = $_SERVER['REMOTE_ADDR'];  
                 }  
                 return $ip;  
            }  


/**
 * get_difference between 2 date
 *
 * @param  int $start
 * @param  int $end
 * @return int $day
 */
public function get_difference($start,$end){

    $start_date=new DateTime($start);
    $end_date=new DateTime($end);
    $interval = date_diff($start_date, $end_date); 

    // printing result in days format 
    return $interval->format('%R%a'); 
}
            
 
public function insert__login_log($aid,$ip,$country){

 
$stmt = $this->conn->prepare("INSERT INTO `login_log`( `fk_AID`, `ip_address`, `country`) VALUES (?,?,?)");
$stmt->bind_param("iss",
$aid,
$ip,
$country
);

$result = $stmt->execute();
$stmt->close();

if ($result) {
      
    return  true;

} else {
  

    return false;
}


}

// /////////ga init part

    /**
     *  
     *
     *  new shop to access_token tbl.
     * 
     * 
     * */
    public function insert_into_ga_token($token_code) {
                                   
        $stmt = $this->conn->prepare("INSERT INTO `ga_token`(`GID`, `fk_AID`, `token_code`, `install_time`) VALUES (NULL,'1',?,NULL)");
        // $stmt->bind_param("is",$_SESSION['AID'],$token_code);
           $stmt->bind_param("s",$token_code);
        $result = $stmt->execute();
        
        $last_id=$stmt->insert_id;
        $stmt->close();
    // check for successful store
    if ($result) {
        return $last_id;
    } else {
        return 0;
    }
}
    /**
     *  
     * check if shop exist 
     * */
    public function check_if_ga_exist() {
        // check in case , they installed 
           $stmt = $this->conn->prepare("SELECT * FROM `ga_token` WHERE fk_AID='1'");
        //    $stmt->bind_param("i",$_SESSION['AID']);
           $result = $stmt->execute();
           $stmt->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it!
   
           if ($stmt->num_rows >= "1") {
              return TRUE;
           }else{
               return FALSE;
               
           }
      
          
   }
   public function get_ga_token() {
    $stmt = $this->conn->prepare("SELECT  `token_code` FROM ga_token WHERE fk_AID='1'");
    // $stmt->bind_param("i",$_SESSION['AID']);
    if ($stmt->execute()) {			
        $url = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $url; 
    } else {
        return NULL;
    }
} 


}

?>