<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prefixset extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('stations_model');
		$this->username	= $this->session->userdata['amber_in']['username'];
		$this->level	= $this->session->userdata['amber_in']['level'];
		$this->name		= $this->session->userdata['amber_in']['name'];
		$this->userid	= $this->session->userdata['amber_in']['userid'];

		date_default_timezone_set('Asia/Kuala_Lumpur');
		if($this->level == '1'){
			redirect('station/dashboard');
		}elseif($this->level == '2'){
			redirect('driver/dashboard');
		}elseif($this->level == '3'){
			redirect('customer/dashboard');
		}
	}
	
	public function index()
	{
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'stations';
		$maindata['page_title']		= 'prefixset';
		$maindata['prefixsets']		= $this->stations_model->get_all_prefixsets();
		$maindata['stations']		= $this->stations_model->get_prefix_stations();
		
		$this->load->view('admin/header', $maindata);
		$this->load->view('admin/prefixset', $maindata);
		$this->load->view('admin/footer', $maindata);
	}
	
	public function create() {
		
		$data['name']			= $this->input->post('name');
		$data['station_id']		= $this->input->post('station_id');
		
		$res					= $this->stations_model->insert_prefixset($data);
				
		echo json_encode($res);
	}
	
	public function delete() {
		
		$id	= $this->input->post('id');
		$res= $this->stations_model->delete_prefixset($id);
		
		echo json_encode($res);
	}
	
	public function get_station() {
		
		$id	= $this->input->post('id');
		$res= $this->stations_model->get_station($id);
		
		echo json_encode($res);
	}
}
