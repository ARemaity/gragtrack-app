<?php
class DB_Connect {
    private $conn;
    private $conn1;
    private $conn2;
    
    // Connecting to database
    public function connect() {
        require_once 'Config.php';    
        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
        mysqli_set_charset( $this->conn,'utf8');
        // return database handler
        return $this->conn;
    }

      // Connecting to database
      public function connect1() {
        require_once 'Config.php';    
        // Connecting to mysql database
        $this->conn1 = new mysqli(DB_HOST1, DB_USER1, DB_PASSWORD1, DB_DATABASE1);
        mysqli_set_charset( $this->conn1,'utf8');
        // return database handler
        return $this->conn1;
    }
        // Connecting to database
        public function connect2() {
            require_once 'Config.php';    
            // Connecting to mysql database
            $this->conn2 = new mysqli(DB_HOST2, DB_USER2, DB_PASSWORD2, DB_DATABASE2);
            mysqli_set_charset( $this->conn2,'utf8');
            // return database handler
            return $this->conn2;
        }
}
?>