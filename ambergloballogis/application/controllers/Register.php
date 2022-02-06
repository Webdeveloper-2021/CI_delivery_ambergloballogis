<?php
/* 
 ** controller: Register Controller
*/
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//load user model
		$this->load->model('users_model');
		$this->load->model('customers_model');

		date_default_timezone_set('Asia/Kuala_Lumpur');
		$this->currenttime	= date("Y-m-d H:i:s");
		$this->level	= 3;
		$this->userid	= 5;
	}

	public function index()
	{
		if (isset($this->session->userdata['amber_in'])) {
			if ($this->session->userdata['amber_in']['level'] == '0') {
				redirect('admin/dashboard');
			} elseif ($this->session->userdata['amber_in']['level'] == '1') {
				redirect('station/dashboard');
			} elseif ($this->session->userdata['amber_in']['level'] == '2') {
				redirect('driver/dashboard');
			} elseif ($this->session->userdata['amber_in']['level'] == '3') {
				redirect('customer/dashboard');
			}
		} else {
			$this->load->view('register');
		}
	}

	public function create()
	{

		$data['username']		= $this->input->post('username');
		$data['email']			= $this->input->post('email');
		$data['password']		= $this->input->post('password');
		$data['contact_number']	= $this->input->post('contact_number');
		$data['name']			= ucwords(strtolower($this->input->post('name')));
		$data['company_name']	= ucfirst($this->input->post('company'));
		$data['country']		= ucfirst($this->input->post('country'));
		$data['state']			= ucwords(strtolower($this->input->post('state')));
		$data['city']			= ucwords(strtolower($this->input->post('city')));
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= ucwords(strtolower($this->input->post('address')));
		$data['creator_type']	= $this->level;
		$data['created_by']		= $this->userid;
		$data['created_at']		= $this->currenttime;

		$res					= $this->customers_model->insert_customer($data);

		echo json_encode($res);
	}
}
