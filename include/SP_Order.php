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
    
    /**
     * insert_order:insert order to order tbl with status and return last id inserted
     * @param  array $order_array
     * @param  int $status
     * @return int last id 
     */
public function insert_order($order_array,$status,$type){
        $has_refund=0;
        $istest=0;
        $include_tax=0;
        $total_ship=0;
        $customer_id=0;
        $total_refund=0;
        $trans=array();

        if(sizeof($order_array['refunds'])!= 0){ 
    $has_refund=1;


foreach($order_array['refunds'] as $refund){

    $trans=$refund['transactions'];

   
    
    }
    if(!is_null($trans)&&!empty($trans)){

        foreach($trans as $single){
            $total_refund=$single['amount'];
        }
        $trans=array();
    }
    
}
if($order_array['taxes_included']=='true'){
    $include_tax=1;

}
if($order_array['test']=='true'){
    $istest=1;

}
if(!empty($order_array['shipping_lines'])){

  $ship=$order_array['shipping_lines'];
  foreach ($ship as $one) {
     
      $total_ship=$one['price']-$one['discounted_price'];


}
} 
if(!empty($order_array['customer'])){

   $customer_id=$order_array['customer']['id'];
  } 
        $create = date('Y-m-d H:i:s', strtotime($order_array['created_at']));
        $update = date('Y-m-d H:i:s', strtotime($order_array['updated_at']));
        $stmt = $this->conn->prepare("INSERT INTO `sp_order`( `fk_AID`, `order_id`,`order_name`,`customer_id`, `total_line`, `total_discount`, `total_tax`, `total_ship`, `total_amount`,`total_refund`, `has_refund`, `tax_included`, `test`,`status`,`type`,`source_name`, `created_at`,`updated_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iisiddddddiiiiisss",
        $_SESSION['AID'],
        $order_array['id'],
        $order_array['name'],
        $customer_id,
        $order_array['total_line_items_price'],
        $order_array['total_discounts'],
        $order_array['total_tax'],
        $total_ship,
        $order_array['total_price'],
        $total_refund,
        $has_refund,
        $include_tax,
        $istest,
        $status,
        $type,
        $order_array['source_name'],
        $create,
        $update
        );
        
        $result = $stmt->execute();
        
        $last_id=$stmt->insert_id;
     
        
        if ($result) {
              
            return  $last_id;
            $stmt->close();
        } else {
          
        
           die("the error is ".$stmt->error);
           $stmt->close();
        }
        

    }



    public function insert_webhook_order($order_array,$aid,$status,$type){
        $has_refund=0;
        $istest=0;
        $include_tax=0;
        $total_ship=0;
$customer_id=0;
$total_refund=0;
$trans=array();

if( sizeof($order_array['refunds']) != 0 ){ 
    $has_refund=1;


foreach($order_array['refunds'] as $refund){

    $trans=$refund['transactions'];
    
    
    }
    $total_refund=$trans[0]['amount'];
}
if($order_array['taxes_included']=='true'){
    $include_tax=1;

}
if($order_array['test']=='true'){
    $istest=1;

}
if(!empty($order_array['shipping_lines'])){

  $ship=$order_array['shipping_lines'];
  foreach ($ship as $one) {
     
      $total_ship=$one['price']-$one['discounted_price'];


}
} if(!empty($order_array['customer'])){

    $customer_id=$order_array['customer']['id'];
   } 
        $create = date('Y-m-d H:i:s', strtotime($order_array['created_at']));
        $update = date('Y-m-d H:i:s', strtotime($order_array['updated_at']));
        $stmt = $this->conn->prepare("INSERT INTO `sp_order`( `fk_AID`, `order_id`,`order_name`,`customer_id`, `total_line`, `total_discount`, `total_tax`, `total_ship`, `total_amount`,`total_refund`, `has_refund`, `tax_included`, `test`,`status`,`type`,`source_name`, `created_at`,`updated_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iisiddddddiiiiisss",
        $aid,
        $order_array['id'],
        $order_array['name'],
        $customer_id,
        $order_array['total_line_items_price'],
        $order_array['total_discounts'],
        $order_array['total_tax'],
        $total_ship,
        $order_array['total_price'],
        $total_refund,
        $has_refund,
        $include_tax,
        $istest,
        $status,
        $type,
        $order_array['source_name'],
        $create,
        $update
        );
        
        $result = $stmt->execute();
        $last_id=$stmt->insert_id;
        $stmt->close();
        
        if ($result) {
              
            return  $last_id;
        
        } else {
          
        
            return 0;
        }
        

    }


    

    public function update_webhook_order($order_array,$aid,$status,$type) {
     
        $has_refund=0;
        $istest=0;
        $include_tax=0;
        $total_ship=0;
        $trans=array();
        $total_refund=0;

        if( sizeof($order_array['refunds']) != 0 ){ 
            $has_refund=1;
        
        
        foreach($order_array['refunds'] as $refund){
        
            $trans=$refund['transactions'];
            
            
            }
            $total_refund=$trans[0]['amount'];
        }
if($order_array['taxes_included']=='true'){
    $include_tax=1;

}
if($order_array['test']=='true'){
    $istest=1;

}
if(!empty($order_array['shipping_lines'])){

  $ship=$order_array['shipping_lines'];
  foreach ($ship as $one) {
     
      $total_ship=$one['price']-$one['discounted_price'];


}
} 
$update = date('Y-m-d H:i:s', strtotime($order_array['updated_at']));
        $stmt = $this->conn->prepare("UPDATE `sp_order` SET `total_line`=?,`total_discount`=?,`total_tax`=?,`total_ship`=?,`total_amount`=?,`total_refund`=?,`has_refund`=?,`tax_included`=?,`test`=?,`status`=?,`type`=?,`updated_at`=? WHERE fk_AID=? AND order_id=?");
        $stmt->bind_param("ddddddiiiiiii",

        $order_array['total_line_items_price'],
        $order_array['total_discounts'],
        $order_array['total_tax'],
        $total_ship,
        $order_array['total_price'],
        $total_refund,
        $has_refund,
        $include_tax,
        $istest,
        $status,
        $type,
        $update,
        $aid,
        $order_array['id']
        );
        
        $result = $stmt->execute();

        $stmt->close();
        if ($result) {
        return true;
        } else {
        return var_dump($result);
        }
        }

        
        /**
         * after finishing inserting to sp_product we sum up the (single cost*qty) for every order then insert it to the totol_cost
         *
         * @param  int $total_cost
         * @param  int $oid
         * @return bool true/false
         */
        public function update_total_cost($total_cost,$oid) {
     
            $stmt = $this->conn->prepare("UPDATE `sp_order` SET `total_cost`=? WHERE fk_AID=? AND OID=?");
            $stmt->bind_param("dii",
            $total_cost,
            $_SESSION['AID'],
            $oid
            );
            
            $result = $stmt->execute();
    
    
            if ($result) {
            return true;
            $stmt->close();
            } else {
                return $stmt->error;
                $stmt->close();
            }
            }
        

            public function update_webhook_total_cost($total_cost,$aid,$oid) {
     
                $stmt = $this->conn->prepare("UPDATE `sp_order` SET  `total_cost`=? WHERE fk_AID=? AND OID=?");
                $stmt->bind_param("dii",
                $total_cost,
                $aid,
                $oid
                );
                
                $result = $stmt->execute();
        
                $stmt->close();
                if ($result) {
                return true;
                } else {
                    return false;
                }
                }
        
    



    /**
     * get_mix_attr: get all orders Canceled, pending, and unpaid orders are included. Test and deleted orders are not included.
     *
     * @param  int $month
     * @return array orders
     */
    public function get_mix_attr(){

    $stmt = $this->conn->prepare("SELECT `OID`, `total_line`, `total_discount`, `total_tax`, `total_ship`, `total_amount`, `total_refund`,`has_refund`, `tax_included` FROM `sp_order` WHERE fk_AID = ? AND  test='0' ");
    $stmt->bind_param("i", $_SESSION['AID']);
if ($stmt->execute()) {			
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders; 
} else {
    return NULL;
}





    }    
    /**
     * sales_month only status PAID order are fetched as SALES 
     *
     * @param  int $year
     * @return array assoc
     */
    public function sales_month($year){
        // select MONTH(created_at) as mcreate ,sum(total_amount) from sp_order where created_at >= NOW() - INTERVAL 1 YEAR group by MONTH(created_at)
        $stmt = $this->conn->prepare("select MONTH(created_at) AS M,sum(total_amount) AS S from sp_order where YEAR(created_at)=? AND fk_AID = ? AND status=3 group by MONTH(created_at)");
        $stmt->bind_param("ii", $year,$this->aid);
    if ($stmt->execute()) {			
        $sales = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        return $sales; 
    } else {
        return NULL;
    }
    
    
    
    
    }
public function order_month($year){
    // select MONTH(created_at) as mcreate ,sum(total_amount) from sp_order where created_at >= NOW() - INTERVAL 1 YEAR group by MONTH(created_at)
    $stmt = $this->conn->prepare("select MONTH(created_at) AS M,sum(total_amount) AS S from sp_order where YEAR(created_at)=? AND fk_AID = ? group by MONTH(created_at)");
    $stmt->bind_param("ii", $year,$this->aid);
if ($stmt->execute()) {			
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders; 
} else {
    return NULL;
}




}


public function order_day(){

        $stmt = $this->conn->prepare("select DAYNAME(created_at) AS D,sum(total_amount) AS T from sp_order where  fk_AID = ? AND  created_at >= (CURDATE() - INTERVAL 7 DAY) group by DAYNAME(created_at)");
        $stmt->bind_param("i",$this->aid);
    if ($stmt->execute()) {			
        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        return $orders; 
    } else {
        return NULL;
    }
    
    
}

public function order_q($year){

    $stmt = $this->conn->prepare("SELECT SUM( CASE when QUARTER(sp_order.created_at) = 1 then sp_order.total_amount ELSE 0 END) AS q1,
    SUM( CASE when QUARTER(sp_order.created_at) = 2 then sp_order.total_amount ELSE 0 END) AS q2,
    SUM( CASE when QUARTER(sp_order.created_at) = 3 then sp_order.total_amount ELSE 0 END) AS q3,
    SUM( CASE when QUARTER(sp_order.created_at) = 4 then sp_order.total_amount ELSE 0 END) AS q4
    from sp_order
    where  fk_AID = ? AND YEAR(sp_order.created_at) =? 
    ");
    $stmt->bind_param("ii",$this->aid,$year);
if ($stmt->execute()) {			
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders; 
} else {
    return NULL;
}


}



public function past_month(){
    $months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
$transposed = array_slice($months, date('n'), 12, true) + array_slice($months, 0, date('n'), true);
$last8 = array_reverse(array_slice($transposed, -12, 12, true), true);

return $last8;
}



public function get_latest_order($latest_number){


    $stmt = $this->conn->prepare("SELECT order_id,total_amount,status from sp_order WHERE fk_AID=?    ORDER BY created_at DESC LIMIT ?");
    $stmt->bind_param("ii",$this->aid,$latest_number);
if ($stmt->execute()) {			
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders; 
} else {
    return NULL;
}

}



public function get_all_month(){
    
    $month = array(
        'Jan'=>0,
        'Mar'=>0,
        'Feb'=>0,
        'Apr'=>0,
        'May'=>0,
        'June'=>0,
        'Jul '=>0,
        'Aug'=>0,
        'Sep'=>0,
        'Oct'=>0,
        'Nov'=>0,
        'Dec'=>0
    );

    return $month;
    
}

public function get_all_days(){

    $dayNames = array(
        'Sunday'=>0,
        'Monday'=>0, 
        'Tuesday'=>0, 
        'Wednesday'=>0, 
        'Thursday'=>0, 
        'Friday'=>0, 
        'Saturday'=>0 
     );

     return  $dayNames;
}

      
    /**
     * get_order_id 
     *
     * @param  int $order_id
     * @param  int $aid
     * @return int OID OR NULL
     */
    public function get_order_id($order_id,$aid) {
        $stmt = $this->conn->prepare("SELECT  `OID` FROM sp_order WHERE `order_id`='$order_id' AND fk_AID='$aid' ");
        if ($stmt->execute()) {			
            $oid = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			return $oid; 
        } else {
            return NULL;
        }
    } 
    public function check_order_exist($order_id) {
        // check in case , they installed 
           $stmt = $this->conn->prepare("SELECT * FROM `sp_order` WHERE order_id='$order_id'");
         
           $result = $stmt->execute();
           $stmt->store_result(); //store_result() "binds" the last given answer to the statement-object for... reasons. Now we can use it!
   
           if ($stmt->num_rows >= "1") {
              return TRUE;
           }else{
               return FALSE;
               
           }
      
          
   }
   public function check_order($order_id) {
    // check in case , they installed 

       $aid=$_SESSION['AID'];
       $stmt = $this->conn->prepare("SELECT * FROM `sp_order` WHERE order_id='$order_id' AND fk_AID='$aid'");
     
       $result = $stmt->execute();
       $stmt->store_result();

       if ($stmt->num_rows >= "1") {
          return TRUE;
       }else{
           return FALSE;
           
       }

      
}

               /**
             * get_plan_att
             *
             * @param  int $pid PID of plan tbl 
             * @return array of plan attr
             */
            public function get_single_order($order_id){
                
                $stmt = $this->conn->prepare("SELECT * FROM `sp_order` WHERE order_id = ? AND fk_AID= ? ");
                $stmt->bind_param("ii",$order_id,$_SESSION['AID']);
                if ($stmt->execute()) {			
                    $single_order = $stmt->get_result()->fetch_assoc();
                    $stmt->close();
                    return $single_order; 
                } else {
                    return NULL;
                }

            }

            
        public function get_product_order($status,$type){

if(!is_null($status)){
    
if(!is_null($type)){
    $stmt = $this->conn->prepare("
    SELECT `OID`,`order_id`, `order_name`, `customer_id`,  `total_amount`, `type`, `status`, `created_at`         
     FROM sp_order
    WHERE  fk_AID= ? AND status= ? AND test = ? 

   group by `OID`
    
   order by `created_at`
    
      ");

      $stmt->bind_param("iii",$_SESSION['AID'],$status,$type);

}else{

    $stmt = $this->conn->prepare("
    SELECT `OID`,`order_id`, `order_name`, `customer_id`,  `total_amount`, `type`, `status`, `created_at`         
     FROM sp_order
    WHERE  fk_AID= ? AND status= ? 

   group by `OID`
    
   order by `created_at`
    
      ");

      $stmt->bind_param("ii",$_SESSION['AID'],$status);

}


}elseif(!is_null($type)){
    $stmt = $this->conn->prepare("
    SELECT `OID`,`order_id`, `order_name`, `customer_id`,  `total_amount`, `type`, `status`, `created_at`         
     FROM sp_order
    WHERE  fk_AID= ? AND  test = ? 

   group by `OID`
    
   order by `created_at`
    
      ");

      $stmt->bind_param("ii",$_SESSION['AID'],$type);

}else{
            $stmt = $this->conn->prepare("
            SELECT `OID`,`order_id`, `order_name`, `customer_id`,  `total_amount`, `type`, `status`, `created_at`         
             FROM sp_order
            WHERE  fk_AID= ? 

           group by `OID`
            
           order by `created_at`
            
              ");

              $stmt->bind_param("i",$_SESSION['AID']);

}
                  if ($stmt->execute()) {			
                      $sorder = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                      $stmt->close();
                  
                      return $sorder; 
                  } else {
                      return NULL;
                  }
          
                  }




 public function insert_order_address($address_array,$oid){
                   
                    $stmt = $this->conn->prepare("INSERT INTO `sp_order_address`(`fk_OID`, `latitude`, `longitude`, `country`, `country_code`, `province`) VALUES (?,?,?,?,?,?)");
                    $stmt->bind_param("iddsss",
                   $oid,
                   $address_array['latitude'],
                   $address_array['longitude'],
                   $address_array['country'],
                   $address_array['country_code'],
                   $address_array['province'],
                   
                    );
                    
                    $result = $stmt->execute();
                 
          
                    
                    if ($result) {
                          
                        return  true;
                        $stmt->close();
                    
                    } else {
                      
                    
                        die("Adding record failed: " .$stmt->error); 
                        $stmt->close();
                    }
                    
            
                }
            
              
                public function get_country_order(){
                    $stmt = $this->conn->prepare("SELECT COUNT(country_code) as counts ,country_code,country from sp_order_address INNER JOIN sp_order ON sp_order_address.fk_OID=sp_order.OID AND sp_order.fk_AID=?  GROUP BY country_code ORDER by COUNT(country_code)  ASC ");
                    $stmt->bind_param("i",$this->aid);
                if ($stmt->execute()) {			
                    $prs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $stmt->close();
                
                    return $prs; 
                } else {
                    return NULL;
                }
                }     


                public function get_source_order(){

                    $stmt = $this->conn->prepare("SELECT source_name,COUNT(source_name) as counts FROM `sp_order` WHERE fk_AID=? GROUP by source_name order by COUNT(source_name) DESC");
                    $stmt->bind_param("i", $_SESSION['AID']);
                if ($stmt->execute()) {			
                    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $stmt->close();
                
                    return $orders; 
                } else {
                    return NULL;
                }
                
                
                
                
                
                    } 


                    
                    
                
                    public function get_sales_today($date){

                        $stmt = $this->conn->prepare("SELECT COUNT(OID) as counts from sp_order WHERE status=3 AND fk_AID=? and created_at=?");
                        $stmt->bind_param("is", $_SESSION['AID'],$date);
                    if ($stmt->execute()) {			
                        $sales = $stmt->get_result()->fetch_assoc();
                        $stmt->close();
                    
                        return $sales; 
                    } else {
                        return NULL;
                    }
                    
                    
                    
                    
                    
                        } 


                        public function get_order_count(){

                            $stmt = $this->conn->prepare("SELECT COUNT(*) as counts FROM `sp_order` WHERE fk_AID = ?");
                            $stmt->bind_param("i", $_SESSION['AID']);
                        if ($stmt->execute()) {			
                            $corder = $stmt->get_result()->fetch_assoc();
                            $stmt->close();
                        
                            return $corder; 
                        } else {
                            return NULL;
                        }
                        
                        
                        
                        
                        
                            } 

                            public function get_last_order_id(){

                                $stmt = $this->conn->prepare("SELECT order_id as oid FROM `sp_order` WHERE fk_AID=? ORDER BY `sp_order`.`order_name` DESC LIMIT 1");
                                $stmt->bind_param("i", $_SESSION['AID']);
                            if ($stmt->execute()) {			
                                $corder = $stmt->get_result()->fetch_assoc();
                                $stmt->close();
                            
                                return $corder; 
                            } else {
                                return NULL;
                            }
                            
                            
                            
                            
                            
                                } 


                                public function get_sales_growth($month,$year){
                                   
                                    $stmt = $this->conn->prepare("SELECT sum(total_line) as lsum, sum(total_discount) as dsum, sum(total_refund) as rsum FROM sp_daily_order WHERE MONTH(date)=? AND YEAR(date)= ? AND  fk_AID=?");
                                    $stmt->bind_param("iii", $month,$year,$_SESSION['AID']);
                                if ($stmt->execute()) {			
                                    $orders = $stmt->get_result()->fetch_assoc();
                                    $stmt->close();
                                
                                    return $orders; 
                                } else {
                                    return NULL;
                                }
                                
                                
                                
                                
                                
                                    } 
              
          
}

?>