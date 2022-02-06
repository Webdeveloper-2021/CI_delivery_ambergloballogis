<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drivers extends CI_Controller {

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
		$maindata['page_title']		= 'drivers';
		$maindata['drivers']		= $this->drivers_model->get_all_drivers($this->userid, $this->level);
		
		$this->load->view('admin/header', $maindata);
		$this->load->view('admin/drivers', $maindata);
		$this->load->view('admin/footer', $maindata);
	}
	
	public function create() {
		
		$data['username']		= $this->input->post('username');
		$data['email']			= $this->input->post('email');
		$data['password']		= $this->input->post('password');
		$data['contact_number']	= $this->input->post('contact_number');
		$data['name']			= ucwords(strtolower($this->input->post('name')));
		$data['zone']			= $this->input->post('zone');
		$data['vehicle_number']	= $this->input->post('vehicle_number');
		$data['vehicle_type']	= $this->input->post('vehicle_type');
		$data['country']		= ucfirst($this->input->post('country'));
		$data['state']			= ucwords(strtolower($this->input->post('state')));
		$data['city']			= ucwords(strtolower($this->input->post('city')));
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= ucwords(strtolower($this->input->post('address')));
		// $image_path				= $this->input->post('image_path');
		$data['creator_type']	= $this->level;
		$data['created_by']		= $this->userid;
		$data['created_at']		= $this->currenttime;

		if($this->input->post('vehicle_type') == ''){
			unset($data['vehicle_type']);
		}

		// if($image_path != ''){
		// 	$img = str_replace('data:image/png;base64,', '', $image_path);
		// 	$img = str_replace(' ', '+', $img);
		// 	$imagedata = base64_decode($img);
		// 	$filename = date('YmdHis').rand(0, 1000).'.png';
		// 	$file = 'uploads/drivers/'.$filename;
			
		// 	file_put_contents($file, $imagedata);
		// 	$data['image_path'] = $filename;
		// }
		$this->load->library('upload');
		if(isset($_FILES['image_path'])){
			if($_FILES['image_path']['size'] > 0){
				$file = $_FILES["image_path"]['tmp_name'];
				$image_info = getimagesize($file);
				$image_width = $image_info[0];
				$image_height = $image_info[1];
				$uploadImageType = $image_info[2];
				$max_value = max($image_height, $image_width);
				$rate = 1;
				if(floor(150000 / $max_value) / 100 < 1) {
					$rate = floor(150000 / $max_value) / 100;
				}
				$new_height = $image_height * $rate;
				$new_width = $image_width * $rate;
				$filename = date('YmdHis').rand(0, 1000).'.jpg';
				$filepath = 'uploads/drivers/'.$filename;

				$resourceType = imagecreatefromjpeg($file);
				$imageLayer = $this->resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height);
				imagejpeg($imageLayer, $filepath);
				
				$data['image_path'] = $filename;
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
		$data['name']			= ucwords(strtolower($this->input->post('name')));
		$data['zone']			= $this->input->post('zone');
		$data['vehicle_number']	= $this->input->post('vehicle_number');
		$data['vehicle_type']	= $this->input->post('vehicle_type');
		$data['country']		= ucfirst($this->input->post('country'));
		$data['state']			= ucwords(strtolower($this->input->post('state')));
		$data['city']			= ucwords(strtolower($this->input->post('city')));
		$data['post_code']		= $this->input->post('post_code');
		$data['address']		= ucwords(strtolower($this->input->post('address')));
		// $data['creator_type']	= $this->level;
		// $data['created_by']		= $this->userid;
		// $data['created_at']		= $this->currenttime;

		if($this->input->post('vehicle_type') == ''){
			unset($data['vehicle_type']);
		}
		$this->load->library('upload');
		if(isset($_FILES['image_path'])){
			if($_FILES['image_path']['size'] > 0){
				$file = $_FILES["image_path"]['tmp_name'];
				$image_info = getimagesize($file);
				$image_width = $image_info[0];
				$image_height = $image_info[1];
				$uploadImageType = $image_info[2];
				$max_value = max($image_height, $image_width);
				$rate = 1;
				if(floor(150000 / $max_value) / 100 < 1) {
					$rate = floor(150000 / $max_value) / 100;
				}
				$new_height = $image_height * $rate;
				$new_width = $image_width * $rate;
				$filename = date('YmdHis').rand(0, 1000).'.jpg';
				$filepath = 'uploads/drivers/'.$filename;

				$resourceType = imagecreatefromjpeg($file);
				$imageLayer = $this->resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height);
				imagejpeg($imageLayer, $filepath);
				
				$data['image_path'] = $filename;
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

	public function update_status() {
		
		$id	= $this->input->post('id');
		$status	= $this->input->post('status');
		$res= $this->drivers_model->update_status($id, $status);
		
		echo json_encode($res);
	}

	public function get_deliveryrequest() {
		
		$id	= $this->input->post('id');
		$res= $this->drivers_model->get_deliveryrequest($id);
		
		echo json_encode($res);
	}

	function resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height) {
		$dst = imagecreatetruecolor( $new_width, $new_height );
		imagecopyresampled( $dst, $resourceType, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height );
		return $dst;
	}
}
