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
public function insert_order($order_array,$status){
        $has_refund=0;
        $istest=0;
        $include_tax=0;
        $total_ship=0;
        $customer_id=0;

if(!empty($order_array['refunds'])){
    $has_refund=1;


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
        $stmt = $this->conn->prepare("INSERT INTO `sp_order`( `fk_AID`, `order_id`,`customer_id`, `total_line`, `total_discount`, `total_tax`, `total_ship`, `total_amount`, `has_refund`, `tax_included`, `test`,`status`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiidddddiiiis",
        $_SESSION['AID'],
        $order_array['id'],
        $customer_id,
        $order_array['total_line_items_price'],
        $order_array['total_discounts'],
        $order_array['total_tax'],
        $total_ship,
        $order_array['total_price'],
        $has_refund,
        $include_tax,
        $istest,
        $status,
        $create
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



    public function insert_webhook_order($order_array,$aid,$status){
        $has_refund=0;
        $istest=0;
        $include_tax=0;
        $total_ship=0;
$customer_id=0;
if(!empty($order_array['refunds'])){
    $has_refund=1;


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
        $stmt = $this->conn->prepare("INSERT INTO `sp_order`( `fk_AID`, `order_id`,`customer_id`, `total_line`, `total_discount`, `total_tax`, `total_ship`, `total_amount`, `has_refund`, `tax_included`, `test`,`status`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("iiidddddiiiis",
        $aid,
        $order_array['id'],
        $customer_id,
        $order_array['total_line_items_price'],
        $order_array['total_discounts'],
        $order_array['total_tax'],
        $total_ship,
        $order_array['total_price'],
        $has_refund,
        $include_tax,
        $istest,
        $status,
        $create
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


    

    public function update_webhook_order($order_array,$aid,$status) {
     
        $has_refund=0;
        $istest=0;
        $include_tax=0;
        $total_ship=0;

if(!empty($order_array['refunds'])){
    $has_refund=1;


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
 
        $stmt = $this->conn->prepare("UPDATE `sp_order` SET `total_line`=?,`total_discount`=?,`total_tax`=?,`total_ship`=?,`total_amount`=?,`has_refund`=?,`tax_included`=?,`test`=?,`status`=? WHERE fk_AID=? AND order_id=?");
        $stmt->bind_param("dddddiiiiii",

        $order_array['total_line_items_price'],
        $order_array['total_discounts'],
        $order_array['total_tax'],
        $total_ship,
        $order_array['total_price'],
        $has_refund,
        $include_tax,
        $istest,
        $status,
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
     * get_mix_attr: get all orders Canceled, pending, and unpaid orders are included. Test and deleted orders are not included.
     *
     * @param  int $month
     * @return array orders
     */
    public function get_mix_attr($month){

    $stmt = $this->conn->prepare("SELECT `OID`, `total_line`, `total_discount`, `total_tax`, `total_ship`, `total_amount`, `has_refund`, `tax_included` FROM `sp_order` WHERE fk_AID = ?  AND MONTH(created_at) = ? AND status != '4' AND status != '5' AND test='0' ");
    $stmt->bind_param("ii", $_SESSION['AID'],$month);
if ($stmt->execute()) {			
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $orders; 
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

}

?>