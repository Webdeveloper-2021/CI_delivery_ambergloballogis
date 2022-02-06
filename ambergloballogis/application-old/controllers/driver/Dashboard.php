<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		$this->currentdate	= date("Y-m-d");

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
		$maindata['parent_title']	= 'dashboard';
		$maindata['page_title']		= 'dashboard';
		$maindata['board']			= $this->trackingnumbers_model->get_board();
		
		$this->load->view('driver/header', $maindata);
		$this->load->view('driver/dashboard', $maindata);
		$this->load->view('driver/footer');
	}

	public function check() {
		
		$tracking_number	= $this->input->post('tracking_number');
		$res= $this->trackingnumbers_model->check_trackingnumber($tracking_number);
		
		echo json_encode($res);
	}

	public function create_status() {

		$status_data['tracking_number_id']	= $this->input->post('tracking_number_id');
		$status_data['status_id']			= $this->input->post('status_id');
		$status_data['date_stamp']			= strtotime($this->currentdate);
		$status_data['remark']				= $this->input->post('remark');
		$status_data['location']			= $this->input->post('location');
		$status_data['created_at']			= $this->currenttime;
		$status_data['creator_type']		= $this->level;
		$status_data['created_by']			= $this->userid;
		
		if($this->input->post('location') == ''){
			unset($status_data['location']);
		}

		if($this->input->post('remark') == ''){
			unset($status_data['remark']);
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
				$filepath = 'uploads/delivery/'.$filename;

				$resourceType = imagecreatefromjpeg($file);
				$imageLayer = $this->resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height);
				imagejpeg($imageLayer, $filepath);
				
				$status_data['image_path'] = $filename;
			}
		}
		
		$res	= $this->trackingnumbers_model->insert_trackingstatus($status_data, $this->name);
				
		echo json_encode($res);
	}

	function resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height) {
		$dst = imagecreatetruecolor( $new_width, $new_height );
		imagecopyresampled( $dst, $resourceType, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height );
		return $dst;
	}
	
}
