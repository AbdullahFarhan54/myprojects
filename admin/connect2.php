<?php 
class connect{

  public $connect;
  private $host = "localhost";
  private $username = 'root';
  private $password = '';
  private     $database = 'shopping';
  function __construct()
  {
       $this->database_connect();
  }
  public function database_connect()
  {
       $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        mysqli_set_charset( $this->connect,"utf8");
  }
  public function execute_query($query)
  {
       return mysqli_query($this->connect, $query);
  }


}



 ?>
