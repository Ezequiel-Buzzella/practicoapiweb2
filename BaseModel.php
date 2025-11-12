<?php
  include "config.php";
class BaseModel
{
  protected $db;

  function __construct()
  {
$this->db = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8", MYSQL_USER, MYSQL_PASSWORD);
    $this->_deploy();
  }

  private function _deploy(){
    $query = $this->db->query("SHOW TABLES");
    $tables = $query->fetchAll();
    if(count($tables)==0){
      $sql = file_get_contents(__DIR__ . '/db.sql');
      $this->db->exec($sql);
    }
  }

}
