<?php

class Post extends Base
{
	protected $date_created;
	protected $content;
	protected $user;
		
	public function __construct() {
		parent::__construct('post');
	}
	
	public function create() {
    $bones = new Bones();

    $this->_id = $bones->couch->generateIDs(1)->body->uuids[0];
    $this->date_created = date('r');
    $this->user = User::currentUser();
    
    try {
      $bones->couch->put($this->_id, $this->to_json());
    }
    catch(SagCouchException $e) {
      $bones->error500($e);
    }
  }
	
}