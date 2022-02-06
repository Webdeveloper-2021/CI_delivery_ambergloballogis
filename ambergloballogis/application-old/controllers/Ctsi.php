<?php
/* 
 ** controller: Signin Controller
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctsi extends CI_Controller {

	public function __construct() {
		parent::__construct();

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
			$this->load->view('ctsi');
		}
		
	}
}
