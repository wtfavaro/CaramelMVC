<?php

// All the database classes are encapsulated in the Database Namespace
// All queries come through here (easier to prevent injections) as there
// should be no rogue queries.

// Database can be required as $carmdb wherever necessary
// $carm has root access to all databases. As data sensitivity increases,
// this will need to be done more carefully.

Namespace Database;

Use \PDO;

class Core {

  public $connection;             // The PDO object
  public $prepare;                // Inherits from the CarmPrepare class
  public $debug = FALSE;          // Make true to see visible exceptions

  public function __construct(){
    $this->connection = new PDO("mysql:host=" . MYSQL_HOST . ";", MYSQL_USER, MYSQL_PASSWORD);
    $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $this->prepare = new CarmPrepare($this->connection);

    if($this->debug === TRUE){
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
  }

  // The select method returns an instance of the \Database\Select class
  public function select($tableName){
    $selectobject = new Select($tableName);
    return $selectobject;
  }

  // The query method performs a traditional query.
  public function insert($string){
    $sth = $this->connection->query($string);
    return $sth;
  }

  // A raw traditional query
  public function perform($string){
    $sth = $this->connection->query($string);

    if($sth)
      return $sth->fetchAll();
    else
      return false;
  }

}

class CarmPrepare {
  public $connection;

  public function __construct(&$conn){
    $this->connection = &$conn;
  }

  // All prepared inserts can use this
  // $query - String using ? for params
  // $data - Array of all params in order that represent ?
  public function insert($query, $data){
    $stmt = $this->connection->prepare($query);
    return $stmt->execute($data);
  }

  public function select($query, $data){
    $stmt = $this->connection->prepare($query);
    $stmt->execute($data);
    $results = $stmt->fetchAll();

    if(isset($results[0])){
      return $results;
    } else {
      return false;
    }
  }

  public function update($query, $data){
    $stmt = $this->connection->prepare($query);
    return $stmt->execute($data);
  }

  public function match($query, $data){
    $stmt = $this->connection->prepare($query);
    $stmt->execute($data);
    $results = $stmt->fetchAll();

    if(isset($results[0])){
      return true;
    } else {
      return false;
    }
  }
}
