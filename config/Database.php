<?php
 class Database{
   private $host = 'localhost';
   private $db_name = 'myblog';
   private $username = 'root';
   private $password = '1234';
   private $con;

   public function connect(){
     $this->con = null;

     try{
       $this->con = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);

       $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch(PDOException $e){
       echo 'Connection error: '.$e->getMessage();
     }

     return $this->con;
   }
 }
?>
