<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trackingstatus extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('trackingnumbers_model');
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
		$maindata['parent_title']	= 'configuration';
		$maindata['page_title']		= 'trackingstatus';
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses_desc();
		
		$this->load->view('admin/header', $maindata);
		$this->load->view('admin/trackingstatus', $maindata);
		$this->load->view('admin/footer', $maindata);
	}
	
	public function create() {
		$data['name']			= $this->input->post('name');
		$data['created_at']		= $this->currenttime;
		$res					= $this->trackingnumbers_model->insert_status($data);
				
		echo json_encode($res);
	}
	
	public function delete() {
		
		$id	= $this->input->post('id');
		$res= $this->trackingnumbers_model->delete_status($id);
		
		echo json_encode($res);
	}
	
	public function update() {
		
		$id				= $this->input->post('id');
		$data['name']	= $this->input->post('name');
		$res			= $this->trackingnumbers_model->update_status1($id, $data);
		
		echo json_encode($res);
	}
}
