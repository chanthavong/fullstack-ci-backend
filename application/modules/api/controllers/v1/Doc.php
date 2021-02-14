<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Doc extends REST_Controller {

	private $user = null;

	public function __construct()
	{
		parent::__construct();
		// check user loged
		$this->user =  $this->getToken();
		// load model
		$this->load->model('docs');
	}

	public function index_get()
	{

		
		$id  = $this->get('id');
		if($id > 0) {
			$this->data['doc'] = $this->docs->get($id);
			$this->response($this->data);
		}

		$this->data['count_all'] = $this->docs->count_all();

		$search = $this->get('search');

		
		if($search) {
			$this->db->like('title', $search);
			$this->db->or_like('description', $search);
		}

		$limit = $this->get('limit') ?? 10;
		$offset = $this->get('offset') ?? 0;
		$this->docs->limit($limit,$offset);
		$this->data['docs'] = $this->docs->get_all();
		$this->response($this->data);
		
	}

	public function index_post()
	{
		$this->load->helper('string');
		$val = $this->post('doc');
		$val['user_id'] = $this->user->id;

		$val['doc_link'] = random_string('alnum',20);

		$id = $this->docs->insert($val);

		$this->data['doc'] = $this->docs->get($id);
		$this->data['message'] = 'add new doc success';
		$this->response($this->data,201);
	}

	public function index_put()
	{
		// for update
		$id = $this->put('id');
		$val = $this->put('doc');

		if($id > 0) {
			$this->docs->update($id,$val);
			$this->data['message'] = 'updated';
			$this->data['doc'] = $this->docs->get($id);
			$this->response($this->data);
		}

		$this->data['message'] ='No id';
		$this->response($this->data,400);
	}

	public function index_delete($id=0)
	{
		
		if($id > 0){
			$this->data['message'] ='delete';
			$this->data['doc'] = $this->docs->get($id);
			$this->docs->delete($id);
			$this->response($this->data);
		}

		$this->data['message'] ='No id';
		$this->response($this->data,400);
	}

}



