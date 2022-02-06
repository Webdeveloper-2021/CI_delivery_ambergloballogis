<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('users_model');
		$this->username	= $this->session->userdata['amber_in']['username'];
		$this->level	= $this->session->userdata['amber_in']['level'];
		$this->name		= $this->session->userdata['amber_in']['name'];
		$this->userid	= $this->session->userdata['amber_in']['userid'];

		date_default_timezone_set('Asia/Kuala_Lumpur');
		$this->currenttime	= date("Y-m-d H:i:s");
		if($this->level == '1'){
			redirect('station/dashboard');
		}elseif($this->level == '0'){
			redirect('admin/dashboard');
		}elseif($this->level == '3'){
			redirect('customer/dashboard');
		}
	}
	
	public function index()
	{
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'profile';
		$maindata['page_title']		= 'profile';
		$maindata['userinfo']		= $this->users_model->get_userinfo($this->userid, $this->level);
		
		$this->load->view('driver/header', $maindata);
		$this->load->view('driver/profile', $maindata);
		$this->load->view('driver/footer', $maindata);
	}
	
	public function update_pass() {
		$oldpwd	= $this->input->post('oldpwd');
		$newpwd	= $this->input->post('newpwd');
		
		$res = $this->users_model->update_password($this->userid, $oldpwd, $newpwd, 'drivers');
		echo json_encode($res);
	}

	public function update_profile() {
		$data['username']		= $this->input->post('username');
		$data['name']			= $this->input->post('name');
		$data['email']			= $this->input->post('email');
		$data['contact_number']	= $this->input->post('contact_number');
		$data['vehicle_number']	= $this->input->post('vehicle_number');
		$data['vehicle_type']	= $this->input->post('vehicle_type');
		$data['zone']			= $this->input->post('zone');
		$data['country']		= $this->input->post('country');
		$data['state']			= $this->input->post('state');
		$data['city']			= $this->input->post('city');
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= $this->input->post('address');
		
		$res = $this->users_model->update_profile($this->userid, $data, $this->level);
		echo json_encode($res);
	}
}
