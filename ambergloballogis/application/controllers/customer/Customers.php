<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('customers_model');
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
		//	redirect('customer/dashboard');
		}
	}
	
	public function index()
	{
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'customers';
		$maindata['page_title']		= 'customers';
		$maindata['customers']		= $this->customers_model->get_all_customers($this->userid, $this->level);
		
		$this->load->view('customer/header', $maindata);
		$this->load->view('customer/customers', $maindata);
		$this->load->view('customer/footer', $maindata);
	}
	
	public function create() {
		
		//$data['username']		= $this->input->post('username');
		$customer_maxid = $this->customers_model->get_customers_count() + 1;
		$data['username']		= "customer_".$customer_maxid;
		
		$data['email']			= $this->input->post('email');
		//$data['password']		= $this->input->post('password');
		$data['password']		= "customer123";
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
	
	public function delete() {
		
		$id	= $this->input->post('id');
		$res= $this->customers_model->delete_customer($id);
		
		echo json_encode($res);
	}
	
	public function update() {
		$id	= $this->input->post('id');
		
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
		// $data['creator_type']	= $this->level;
		// $data['created_by']		= $this->userid;
		// $data['created_at']		= $this->currenttime;
		
		$res					= $this->customers_model->update_customer($id, $data);
		
		echo json_encode($res);
	}
	
	public function get_customer() {
		
		$id	= $this->input->post('id');
		$res= $this->customers_model->get_customer($id);
		
		echo json_encode($res);
	}
	
}
