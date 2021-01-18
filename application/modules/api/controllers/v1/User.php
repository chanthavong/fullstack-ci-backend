<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users');
	}

	public function index_get()
	{
		$limit = $this->get('limit') ?? 10;
		$offset = $this->get('offset') ?? 0;
		$this->users->limit($limit,$offset);
		$this->data['users'] = $this->users->get_all();
		$this->response($this->data);
	}

	public function index_post()
	{
		$val = array(
			'fullname'=>$this->post('fullname'),
			'email'=>$this->post('email'),
			'phone'=>$this->post('phone'),
			'password'=>$this->post('password')
		);

		if(strlen($val['password']) < 8) {
			$this->data['message'] = 'password min legnth';
			$this->response($this->data,400);
		}

		if(!$val['email']) {
			$this->data['message'] = 'email empty';
			$this->response($this->data,400);
		}

		// check email
		$row = $this->users->get_by(['email'=>$val['email']]);
		if($row) {
			$this->data['message'] = 'user ready exit';
			$this->response($this->data,400);
		}else{
			$val['password'] = password_hash($val['password'], PASSWORD_DEFAULT);
			$this->data['message'] = 'success';
			$id = $this->users->insert($val);
			$this->data['user'] = $this->users->get($id);
			$this->response($this->data,201);
		}
	}

	public function index_put()
	{
		# update
		$data = $this->put('user');

		$allowed = ['fullname','email','password','phone'];

		$id = trim($this->put('id'));
		
		if(!$id) {
			$this->data['message'] = 'id not value !';
			$this->response($this->data,400);
		}

		$user = array_filter(
			$data,
			function ($key) use ($allowed) {
				return in_array($key, $allowed);
			},
			ARRAY_FILTER_USE_KEY
		);
		
		if (array_key_exists('password',$user)) {
			// encode password
			if(strlen($user['password']) > 7) {
				$user['password'] = password_hash($user['password'],PASSWORD_DEFAULT);
			}
		}

		$this->data['user'] = $this->users->get($id);
		$this->response($this->data);
	}

	public function changeEmail_put()
	{
	}

	public function index_delete($id)
	{
		# delete
	}

}
