<?php

class Database
{
  private $host = "localhost";
  private $username = "root";
  private $password = "";
  private $dbName = "movie_recommend";

  public $conn;

  public function getConnection()
  {
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbName);

    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }

    return $this->conn;
  }
}
