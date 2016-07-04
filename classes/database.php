<?php

class Database {
  private $dbHost;
  private $dbName;
  private $dbUser;
  private $dbPass;
  private $dbh;
  
  public function getSelect($query) {
    try {
      $results = $this->dbh->query($query);
      return $results;
    } 
    catch(Exception $exception) {
      echo $exception->getMessage();
    }
  }
  
  public function __construct($dbConfig) {
    $this->dbHost = $dbConfig['dbhost'];
    $this->dbName = $dbConfig['dbname'];
    $this->dbUser = $dbConfig['dbuser'];
    $this->dbPass = $dbConfig['dbpass'];
    
    try {
      $this->dbh = new PDO('mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPass);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $exception) {
      echo $exception->getMessage();
    }
  }
}

?>
















