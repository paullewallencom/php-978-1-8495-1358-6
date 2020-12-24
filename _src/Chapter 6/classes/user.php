<?php

class User extends Base
{
	protected $name;
	protected $email;
	protected $full_name;
  protected $salt;
  protected $password_sha;
  protected $roles;
	
	public function __construct()
	{
		parent::__construct('user'); 
	}
	
  public function signup($username, $password) {
    $bones = new Bones();
    $bones->couch->setDatabase('_users');
    $bones->couch->login(ADMIN_USER, ADMIN_PASSWORD);

    $this->roles = array();
    $this->name = preg_replace('/[^a-z0-9-]/', '', strtolower($username));
    $this->_id = 'org.couchdb.user:' . $this->name;
    $this->salt = $bones->couch->generateIDs(1)->body->uuids[0];
    $this->password_sha = sha1($password . $this->salt);

    try {
      $bones->couch->put($this->_id, $this->to_json());
    } catch(SagCouchException $e) {
      if($e->getCode() == "409") {
        $bones->set('error', 'A user with this name already exists.');
        $bones->render('user/signup');
        exit;
      }
    }
  }
  
  public function login($password) {
    $bones = new Bones();
    $bones->couch->setDatabase('_users');
    
    try {
      $bones->couch->login($this->name, $password, Sag::$AUTH_COOKIE);
      session_start();
      $_SESSION['username'] = $bones->couch->getSession()->body->userCtx->name;
      session_write_close();
    } catch(sagCouchException $e) {
      if ($e->getCode() == "401") {
        $bones->set('error', 'Incorrect login credentials.');
        $bones->render('user/login');
        exit;
      }
    }
  }
  
  public static function logout() {
    $bones = new Bones();
    $bones->couch->login(null, null);
    session_start();
    session_destroy();
  }
  
  public static function currentUser() {
    session_start();
    return $_SESSION['username'];
    session_write_close();
  }
  
  public static function isAuthenticated() {
    if (self::currentUser()) {
      return true;
    } else {
      return false;
    }
  }
	
}