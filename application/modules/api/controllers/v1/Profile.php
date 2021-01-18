<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';



class Profile extends REST_Controller {

	private $token;

	public function __construct()
	{
		parent::__construct();
		// check loged
		$this->token = $this->getToken();
		$this->load->model('users');
	}

	private function getMe()
	{
		$user = $this->users->get($this->token->id);
		$user->password = null;
		$this->data['user'] = $user;
	}

	public function index_get($value='')
	{
		$this->getMe();
		$this->response($this->data);
	}

	public function index_put()
	{
		// update profiile
		$user = array(
			'fullname'=>$this->put('fullname'),
			'phone'=>$this->put('phone')
		);

		if(!$user['fullname'] || !$user['phone']) {
			$this->response($this->data, 204);
		}

		$this->users->update($this->token->id,$user);

		$this->getMe();
		$this->response($this->data);
	}
}