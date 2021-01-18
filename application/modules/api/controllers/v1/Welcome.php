<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Welcome extends REST_Controller {

	public function index_get()
	{
		$this->data['message'] = 'API Version 1.0';
		$this->data['data'] = 'run from /Application/modules/api/controllers/v1/welcome.php';
		$this->response($this->data);
	}

	public function index_post($value='')
	{
		// code...
		$this->data['message'] = 'test post method';
		$this->response($this->data);
	}

}
