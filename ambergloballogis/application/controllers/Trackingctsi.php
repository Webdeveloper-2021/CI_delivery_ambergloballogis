<?php
/* 
 ** controller: Signin Controller
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Trackingctsi extends CI_Controller {

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
			$tracking_number = $this->input->get('tracking_number');
			if(!isset($tracking_number) || $tracking_number == ''){
				redirect('home');
			}
			$data['tracking_number'] = $tracking_number;
			$data['trackings'] = $this->trackingnumbers_model->get_trackingdetail_bynumber($tracking_number);
			
			$this->load->view('tracking_ctsi', $data);
		}
	}
}
