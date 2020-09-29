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

    public function insert_order($order_array,$status){

     
        $create = date('Y-m-d', strtotime($order_array['created_at']));
        $stmt = $this->conn->prepare("INSERT INTO `sp_order`(`fk_AID`, `order_id`, `total_amount`,`status`, `created_at`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iiiis",
        $_SESSION['AID'],
        $order_array['id'],
        $order_array['total_price'],
        $status,
        $create
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        if ($result) {
              
            return  true;
        
        } else {
          
        
            return false;
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

public function get_all_q(){

    $dayNames = array(
        'q1'=>0,
        'q2'=>0, 
        'q3'=>0, 
        'q4'=>0
       
     );

     return  $dayNames;
}
  
  
}

?>