<?php
/* 
 ** controller: Signin Controller
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//load user model
		$this->load->model('trackingnumbers_model');
	}
	
	public function index()
	{
		if(isset($this->session->userdata['amber_in'])){
			if($this->session->userdata['amber_in']['level'] == '0'){
				redirect('admin/dashboard');
			}elseif($this->session->userdata['amber_in']['level'] == '1'){
				redirect('station/dashboard');
			}elseif($this->session->userdata['amber_in']['level'] == '2'){
				redirect('driver/dashboard');
			}elseif($this->session->userdata['amber_in']['level'] == '3'){
				redirect('customer/dashboard');
			}
		}else{
			$this->load->view('home');
		}
		
	}
	
	public function get_trackingdetail() {
		$id	= $this->input->post('id');
		
		$res = $this->trackingnumbers_model->get_trackingdetail_bynumber($id);
		echo json_encode($res);
	}
}
