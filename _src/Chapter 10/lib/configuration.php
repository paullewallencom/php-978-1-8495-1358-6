<?php 

class Configuration {

  public $db_server = '127.0.0.1';
  public $db_port = '5984';
  public $db_database = 'verge';
  public $db_admin_user = 'tim';
  public $db_admin_password = 'test';
	
  public function __get($property) {
    if (getenv($property)) {
      return getenv($property);
    } else {
      return $this->$property;
    }
  }
  
}