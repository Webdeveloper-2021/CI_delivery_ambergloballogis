<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('trackingnumbers_model');
		$this->load->model('stations_model');
		$this->load->model('customers_model');

		$this->username	= $this->session->userdata['amber_in']['username'];
		$this->level	= $this->session->userdata['amber_in']['level'];
		$this->name		= $this->session->userdata['amber_in']['name'];
		$this->userid	= $this->session->userdata['amber_in']['userid'];

		date_default_timezone_set('Asia/Kuala_Lumpur');
		$this->currenttime	= date("Y-m-d H:i:s");
		if($this->level == '0'){
			redirect('admin/dashboard');
		}elseif($this->level == '1'){
			redirect('station/dashboard');
		}elseif($this->level == '2'){
			redirect('driver/dashboard');
		}
	}
	
	public function index()
	{
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'dashboard';
		$maindata['page_title']		= 'dashboard';
		$maindata['board']			= $this->trackingnumbers_model->get_board();
		
		$this->load->view('customer/header', $maindata);
		$this->load->view('customer/dashboard', $maindata);
		$this->load->view('customer/footer', $maindata);
	}
}
