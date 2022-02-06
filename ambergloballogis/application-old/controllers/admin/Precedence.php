<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precedence extends CI_Controller {

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
		$maindata['parent_title']	= 'configuration';
		$maindata['page_title']		= 'precedence';
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses_desc();
		
		$this->load->view('admin/header', $maindata);
		$this->load->view('admin/precedence', $maindata);
		$this->load->view('admin/footer', $maindata);
	}
	
	public function save() {
		
		$id				= $this->input->post('id');
		$precedence		= $this->input->post('precedence');
		$res			= $this->trackingnumbers_model->update_precedence($id, $precedence);
		
		echo json_encode($res);
	}
}
