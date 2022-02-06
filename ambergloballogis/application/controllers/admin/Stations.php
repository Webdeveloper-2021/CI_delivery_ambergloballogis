<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stations extends CI_Controller {

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
		$this->currenttime	= date("Y-m-d H:i:s");
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
		$maindata['page_title']		= 'stations';
		$maindata['stations']		= $this->stations_model->get_all_stations($this->userid, $this->level);
		
		$this->load->view('admin/header', $maindata);
		$this->load->view('admin/stations', $maindata);
		$this->load->view('admin/footer', $maindata);
	}
	
	public function create() {
		
		$data['username']		= $this->input->post('username');
		$data['primary_email']	= $this->input->post('primary_email');
		$data['secondary_email']= $this->input->post('secondary_email');
		$data['password']		= $this->input->post('password');
		$data['contact_number']	= $this->input->post('contact_number');
		$data['name']			= ucwords(strtolower($this->input->post('name')));
		$data['country']		= ucfirst($this->input->post('country'));
		$data['state']			= ucwords(strtolower($this->input->post('state')));
		$data['city']			= ucwords(strtolower($this->input->post('city')));
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= ucwords(strtolower($this->input->post('address')));
		$data['creator_type']	= $this->level;
		$data['created_by']		= $this->userid;
		$data['created_at']		= $this->currenttime;
		
		$res					= $this->stations_model->insert_station($data);
				
		echo json_encode($res);
	}
	
	public function delete() {
		
		$id	= $this->input->post('id');
		$res= $this->stations_model->delete_station($id);
		
		echo json_encode($res);
	}
	
	public function update() {
		$id	= $this->input->post('id');
		
		$data['username']		= $this->input->post('username');
		$data['primary_email']	= $this->input->post('primary_email');
		$data['secondary_email']= $this->input->post('secondary_email');
		$data['password']		= $this->input->post('password');
		$data['contact_number']	= $this->input->post('contact_number');
		$data['name']			= ucwords(strtolower($this->input->post('name')));
		$data['country']		= ucfirst($this->input->post('country'));
		$data['state']			= ucwords(strtolower($this->input->post('state')));
		$data['city']			= ucwords(strtolower($this->input->post('city')));
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= ucwords(strtolower($this->input->post('address')));
		// $data['creator_type']	= $this->level;
		// $data['created_by']		= $this->userid;
		// $data['created_at']		= $this->currenttime;
		
		$res					= $this->stations_model->update_station($id, $data);
		
		echo json_encode($res);
	}
	
	public function get_station() {
		
		$id	= $this->input->post('id');
		$res= $this->stations_model->get_station($id);
		
		echo json_encode($res);
	}
}
