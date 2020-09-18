<?php 


class DB_webhook{
     
  
    private $conn;
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
        $this->aid=$_SESSION['AID'];
            
    }

    // destructor
    function __destruct() {
        
    }

   


public function update_weebhook(){



}


public function create_weebhook($response_arr){
                                   
  
$created = date('Y-m-d H:i:s', strtotime($response_arr['created_at']));
$updated = date('Y-m-d H:i:s', strtotime($response_arr['updated_at']));
$stmt = $this->conn->prepare("INSERT INTO `webhook`( `fk_AID`, `id`, `topic`, `created_at`, `update_at`) VALUES (?,?,?,?,?");
$stmt->bind_param("iisss",
$this->aid,
$response_arr['id'],
$response_arr['topic'],
$created,
$updated,
);

$result = $stmt->execute();
$stmt->close();

if ($result) {
      
    return  true;

} else {
  

    return false;
}

}


public function delete_weebhook(){


    
}


public function show_weebhook_shop(){


    
}
            
        

 
}


?>