<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Test extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->config('jwt');
	}

	public function index_get()
	{
		# create token example
		$data['status'] = true;
		$data['message'] = 'success';

		$data['id'] = 1;
		$data['token'] = AUTHORIZATION::generateToken($data);

		$this->response($data);
	}

	public function index_post()
	{
		# example token data response
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			if ($decodedToken != false) {
				$this->response($decodedToken, REST_Controller::HTTP_OK);
			}
		}

		$this->response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

	}

	public function check_get($value='')
	{
		$headers = $this->input->request_headers();
		$decodedToken = $this->getToken();
		$data  = array('header'=>$headers,'data'=>$decodedToken);
		$this->response($data);
	}
}