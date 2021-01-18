<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';



class Auth extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->config('jwt');
	}

	public function index_get()
	{
		$data['status'] = true;
		$data['message'] = 'success';

		$data['id'] = 1;
		$data['token'] = AUTHORIZATION::generateToken($data);

		$this->response($data);
	}

	public function index_post()
	{
		$this->load->model('users');
		$email = $this->post('email');
		$pwd = $this->post('password');


		if(!$email) {
			$this->data['message'] = 'email not found';
			$this->response($this->data,204);
		}

		if(!$pwd) {
			$this->data['message'] = 'password not found';
			$this->response($this->data,204);
		}

		$row = $this->users->get_by(['email'=>$email]);

		if($row) {
			if($row->block==false) {
				if(password_verify($pwd, $row->password)) {
					$data['id'] = $row->id;
					$data['email'] = $row->email;
					$data['fullname'] = $row->fullname;

					$this->data['user'] = $data;
					$this->data['token'] = AUTHORIZATION::generateToken($data);
					$this->response($this->data);
				}else{
					$this->data['message'] = 'password or not found';
					$this->response($this->data, REST_Controller::HTTP_UNAUTHORIZED);
				}
			}else{
				$this->data['message'] = 'user is blocked';
				$this->response($this->data, REST_Controller::HTTP_UNAUTHORIZED);
			}
		}else{
			$this->data['message'] = 'password or email not found';
			$this->response($this->data, REST_Controller::HTTP_UNAUTHORIZED);
		}

	}

}

/* End of file Auth.php */
/* Location: ./application/modules/api/v1/controllers/Auth.php */