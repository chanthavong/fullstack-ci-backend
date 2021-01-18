<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Book extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('books');
	}

	public function index_get()
	{

		$id = trim($this->get('id'));

		if ($id > 0) {
			$data = $this->books->get($id);
			$this->data['results'] = $data;
			$this->response($this->data);
		}

		$search = trim($this->get('search'));
		if ($search) {
			$wh["name LIKE '%$search%' OR description LIKE '%$search%'"] = null;
			$data = $this->books->get_many_by($wh);
			$this->data['results'] = $data;
			$this->response($this->data);
		}

		$data = $this->books->get_all();

		$this->data['results'] = $data;
		$this->response($this->data);
	}

	public function index_post($value='')
	{
		# create data 
		$val['name'] = trim($this->post('name'));
		$val['description'] = trim($this->post('description'));
		$val['tag'] = trim($this->post('tag'));
		$val['code'] = trim($this->post('code'));

		if (!$val['name'] || !$val['code']) {
			$this->data['status'] = false;
			$this->data['message'] = 'name or code not value !';
			$this->response($this->data,400);
		}

		$id = $this->books->insert($val);
		$this->data['message'] = 'insert new row success';
		$this->data['book'] = $this->books->get($id);
		$this->response($this->data,201);
	}

	public function index_put($value='')
	{
		
		$data = $this->put('book');

		$allowed = ['tag','description','code','name'];

		$id = trim($this->put('id'));
		
		if(!$id) {
			$this->data['message'] = 'id not value !';
			$this->response($this->data,400);
		}

		$book = array_filter(
			$data,
			function ($key) use ($allowed) {
				return in_array($key, $allowed);
			},
			ARRAY_FILTER_USE_KEY
		);

		if (!$book['name'] || !$book['code']) {
			$this->data['status'] = false;
			$this->data['message'] = 'name or code not value !';
			$this->response($this->data,400);
		}

		$id = trim($this->put('id'));

		$this->books->update($id,$book);
		$this->data['book'] = $this->books->get($id);
		$this->data['message'] = 'update data success';
		$this->response($this->data);

	}

	public function index_delete($id=0)
	{
		# delete data by id
		$this->data['book'] = $this->books->get($id);
		$this->books->delete($id);
		$this->data['message'] = 'delete success';
		$this->response($this->data);
	}

}
