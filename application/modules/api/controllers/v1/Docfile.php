<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Docfile extends REST_Controller {

	private $user = null;

	public function __construct()
	{
		parent::__construct();
		// check user loged
		$this->user =  $this->getToken();
		// load model
		$this->load->model('docfiles');
	}

	public function index_get()
	{

		$docId = (int) $this->get('doc_id');
		if($docId > 0) {
			$this->load->model('docs');
			$this->data['doc'] = $this->docs->get($docId);

			$wh = ['doc_id'=>$docId];
			$this->data['docfiles'] = $this->docfiles->get_many_by($wh);
			$this->response($this->data);
		}

		$limit = $this->get('limit') ?? 10;
		$offset = $this->get('offset') ?? 0;
		$this->docfiles->limit($limit,$offset);
		$this->data['docfiles'] = $this->docfiles->get_all();
		$this->response($this->data);
	}

	public function index_post()
	{
	
		$path = 'uploads/'.date('Y/m/d');

		if(!is_dir($path)) {
			mkdir($path,0777,true);
		}

		$config['upload_path'] = $path;
		$config['file_name'] = 'n_'.date('Ymdhis').'-'.uniqid();

		 // $config['upload_path'] = './uploads/';
		 $config['allowed_types'] = '*'; // 'doc|pdf|svg|png';
		// $config['max_size']  = '100';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		 if($this->post('doc_id') < 1){
		 	$this->data['message'] = 'not doc id';
		 	$this->response($this->data,400);
		 }
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('file')){

			$this->data['error'] = $this->upload->display_errors();
			$this->response($this->data,400);
		}
		else{
			$this->load->helper('string');
			$file = $this->upload->data();
			$this->data['file'] =  $file;
			$val['file_name2'] = $file['client_name'];
			$val['file_name'] = $path.'/'.$file['file_name'];
			$val['file_link'] =  random_string('alnum',30);
			$val['file_type'] = $file['file_type'];
			$val['doc_id'] = $this->post('doc_id');
			$this->data['val'] = $val;
			$this->docfiles->insert($val);
		}

		$this->response($this->data);
	}

	public function index_delete($id=0)
	{
		$row  = $this->docfiles->get($id);
		if($row) {
			$this->data['file'] = $row;
			// deelete file
			if(file_exists($row->file_name)) {
				unlink($row->file_name);
				// delete recode
				$this->docfiles->delete($id);
			}
			$this->data['message'] = 'deleted';
			$this->response($this->data);
		}

		$this->data['message'] = 'no file';
		$this->response($this->data,400);
	}
}






