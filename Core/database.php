<?php 
 class Database{
    //specifying your own database credentials
     private $host="173.249.50.121:3306";
     private $username="ffever";
     private $dbname="vts_listener";
     private $password="Xz6q%4o3";
     public $conn;
     public function getConnection(){
         $this->conn=null;
         try{
             $this->conn= new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);//connection string        
         }catch(PDOException $exception){
             echo "Connection Error: ".$exception->getMessage();
         }
         return $this->conn;
     }
 }
 ?>