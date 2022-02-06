<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('drivers_model');

		date_default_timezone_set('Asia/Kuala_Lumpur');
		$this->currenttime	= date("Y-m-d H:i:s");
	}
	
	public function login() {
		
		$api_token	= $this->input->post('api_token');
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');

		if(isset($api_token)){
			if($api_token == 'logisticToken'){
				if(isset($username) && isset($password)){
					$res	= $this->drivers_model->login_driver($username, $password);
				}else{
					$res['status_code']	= 201;
					$res['message']		= "Missing Parameter";
				}
			}else{
				$res['status_code']	= 201;
				$res['message']		= "Api Token not Matched";
			}
		}else{
			$res['status_code']	= 201;
			$res['message']		= "Missing Api Token";
		}
				
		echo json_encode($res);
	}
	
	public function check_tracking() {
		
		$api_token	= $this->input->post('api_token');
		$tracking_number	= $this->input->post('tracking_number');

		if(isset($api_token)){
			if($api_token == 'logisticToken'){
				if(isset($tracking_number)){
					$res	= $this->drivers_model->check_tracking($tracking_number);
				}else{
					$res['status_code']	= 201;
					$res['message']		= "Missing Parameter";
				}
			}else{
				$res['status_code']	= 201;
				$res['message']		= "Api Token not Matched";
			}
		}else{
			$res['status_code']	= 201;
			$res['message']		= "Missing Api Token";
		}
				
		echo json_encode($res);
	}

	public function get_status() {
		
		$api_token	= $this->input->post('api_token');

		if(isset($api_token)){
			if($api_token == 'logisticToken'){
				$data	= $this->drivers_model->get_all_statuses();
				$res['status_code']	= 200;
				$res['message']		= "Successful";
				$res['data']		= $data;
			}else{
				$res['status_code']	= 201;
				$res['message']		= "Api Token not Matched";
			}
		}else{
			$res['status_code']	= 201;
			$res['message']		= "Missing Api Token";
		}
				
		echo json_encode($res);
	}

	public function deliver_response() {
		
		$data	= $this->input->post('data');
		$json_data = json_decode($data, true);

		$api_token = $json_data['api_token'];
		
		$tracking_number = $json_data['tracking_number'];
		$remark = $json_data['remark']; 
		$status_id = $json_data['status_id'];
		$driver_id = $json_data['driver_id'];

		if(isset($api_token)){
			if($api_token == 'logisticToken'){
				if (isset($tracking_number) && $status_id) {
					$tracking_number_id = $this->drivers_model->get_tracking_number_id($tracking_number);

					$status_data['tracking_number_id']	= $tracking_number_id;
					$status_data['status_id']			= $status_id;
					$status_data['date_stamp']			= strtotime(date('Y-m-d'));
					$status_data['remark']				= $remark;
					$status_data['created_at']			= $this->currenttime;
					$status_data['creator_type']		= '2';
					$status_data['created_by']			= $driver_id;

					$delivery_data['tracking_number_id']	= $tracking_number_id;
					$delivery_data['status_id']				= $status_id;
					$delivery_data['date_stamp']			= strtotime(date('Y-m-d'));
					$delivery_data['remark']				= $remark;
					$delivery_data['created_at']			= $this->currenttime;
					$delivery_data['driver_id']				= $driver_id;

					$this->load->library('upload');
					if(isset($_FILES['image'])){
						if($_FILES['image']['size'] > 0){
							$file = $_FILES["image"]['tmp_name'];
							$image_info = getimagesize($file);
							$image_width = $image_info[0];
							$image_height = $image_info[1];
							$uploadImageType = $image_info[2];
							$max_value = max($image_height, $image_width);
							$rate = 1;
							if(floor(150000 / $max_value) / 100 < 1) {
								$rate = floor(150000 / $max_value) / 100;
							}
						
							$filename = date('YmdHis').rand(0, 1000).'.jpg';
							$filepath = 'uploads/delivery/'.$filename;
							$status_data['image_path'] = $filename;
							$delivery_data['image_path'] = $filename;

							$res = $this->drivers_model->insert_delivery_status($status_data, $delivery_data);
							// $res['status_code']	= 200;
							// $res['message']		= "OK.";
						}else{
							$res['status_code']	= 201;
							$res['message']		= "Image did not uploaded.";
						}
					}else{
						$res['status_code']	= 201;
						$res['message']		= "Image did not uploaded.";
					}
				}else{
					$res['status_code']	= 201;
					$res['message']		= "Missing Tracking Number.";
				}
			}else{
				$res['status_code']	= 201;
				$res['message']		= "Api Token not Matched";
			}
		}else{
			$res['status_code']	= 201;
			$res['message']		= "Missing Api Token";
		}
				
		echo json_encode($res);
	}

}
