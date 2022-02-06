<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deliveryrequest extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('drivers_model');
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
		$maindata['parent_title']	= 'drivers';
		$maindata['page_title']		= 'deliveryrequest';
		$maindata['deliveryrequests']		= $this->drivers_model->get_all_deliveryrequests();
		
		$this->load->view('admin/header', $maindata);
		$this->load->view('admin/deliveryrequest', $maindata);
		$this->load->view('admin/footer', $maindata);
	}
	
	public function create() {
		
		$data['username']		= $this->input->post('username');
		$data['email']			= $this->input->post('email');
		$data['password']		= $this->input->post('password');
		$data['contact_number']	= $this->input->post('contact_number');
		$data['name']			= $this->input->post('name');
		$data['zone']			= $this->input->post('zone');
		$data['vehicle_number']	= $this->input->post('vehicle_number');
		$data['vehicle_type']	= $this->input->post('vehicle_type');
		$data['country']		= $this->input->post('country');
		$data['state']			= $this->input->post('state');
		$data['city']			= $this->input->post('city');
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= $this->input->post('address');
		$data['creator_type']	= $this->level;
		$data['created_by']		= $this->userid;
		$data['created_at']		= $this->currenttime;

		if($this->input->post('vehicle_type') == ''){
			unset($data['vehicle_type']);
		}
		$this->load->library('upload');
		if(isset($_FILES['image_path'])){
			if($_FILES['image_path']['size'] > 0){
				$config = array(
					'upload_path' => "./uploads/drivers/",
					'allowed_types' => "gif|jpg|png|jpeg",
					'overwrite' => TRUE,
					'max_size' => "2048000",
					'max_height' => "1025",
					'max_width' => "2059",
					'file_name' => date('YmdHis').rand(0, 1000)
				);

				$this->upload->initialize($config);
				if($this->upload->do_upload('image_path')){
					$data['image_path'] = $this->upload->file_name;
				}
			}
		}
		
		$res					= $this->drivers_model->insert_driver($data);
				
		echo json_encode($res);
	}
	
	public function delete() {
		
		$id	= $this->input->post('id');
		$res= $this->drivers_model->delete_driver($id);
		
		echo json_encode($res);
	}
	
	public function update() {
		$id	= $this->input->post('id');
		
		$data['username']		= $this->input->post('username');
		$data['email']			= $this->input->post('email');
		$data['password']		= $this->input->post('password');
		$data['contact_number']	= $this->input->post('contact_number');
		$data['name']			= $this->input->post('name');
		$data['zone']			= $this->input->post('zone');
		$data['vehicle_number']	= $this->input->post('vehicle_number');
		$data['vehicle_type']	= $this->input->post('vehicle_type');
		$data['country']		= $this->input->post('country');
		$data['state']			= $this->input->post('state');
		$data['city']			= $this->input->post('city');
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= $this->input->post('address');
		$data['creator_type']	= $this->level;
		$data['created_by']		= $this->userid;
		$data['created_at']		= $this->currenttime;

		if($this->input->post('vehicle_type') == ''){
			unset($data['vehicle_type']);
		}
		$this->load->library('upload');
		if(isset($_FILES['image_path'])){
			if($_FILES['image_path']['size'] > 0){
				$config = array(
					'upload_path' => "./uploads/drivers/",
					'allowed_types' => "gif|jpg|png|jpeg",
					'overwrite' => TRUE,
					'max_size' => "2048000",
					'max_height' => "1025",
					'max_width' => "2059",
					'file_name' => date('YmdHis').rand(0, 1000)
				);

				$this->upload->initialize($config);
				if($this->upload->do_upload('image_path')){
					$data['image_path'] = $this->upload->file_name;
				}
			}
		}
		
		$res					= $this->drivers_model->update_driver($id, $data);
		
		echo json_encode($res);
	}
	
	public function get_driver() {
		
		$id	= $this->input->post('id');
		$res= $this->drivers_model->get_driver($id);
		
		echo json_encode($res);
	}
}
