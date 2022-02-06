<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';

require_once 'vendor/pusher/pusher-php-server/src/Pusher.php';
require_once 'vendor/pusher/pusher-php-server/src/PusherCrypto.php';
require_once 'vendor/pusher/pusher-php-server/src/PusherException.php';
require_once 'vendor/pusher/pusher-php-server/src/PusherInstance.php';
require_once 'vendor/pusher/pusher-php-server/src/Webhook.php';

class Trackingnumbers extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('trackingnumbers_model');
		$this->load->model('stations_model');
		$this->load->model('customers_model');
		$this->load->model('notifications_model');
		$this->load->model('users_model');

		$this->username	= $this->session->userdata['amber_in']['username'];
		$this->level	= $this->session->userdata['amber_in']['level'];
		$this->name		= $this->session->userdata['amber_in']['name'];
		$this->userid	= $this->session->userdata['amber_in']['userid'];

		date_default_timezone_set('Asia/Kuala_Lumpur');
		$this->currenttime	= date("Y-m-d H:i:s");
		if($this->level == '0'){
			redirect('admin/dashboard');
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
		$maindata['level']			= $this->level;
		$maindata['userid']			= $this->userid;
		$maindata['parent_title']	= 'trackingnumbers';
		$maindata['page_title']		= 'trackingnumbers';
		$maindata['trackingnumbers']= $this->trackingnumbers_model->get_all_trackingnumbers($this->userid, $this->level);
		$maindata['stations']		= $this->stations_model->get_all_stations1();
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses();
		//$maindata['customers']		= $this->customers_model->get_all_customers($this->userid, $this->level);
		$maindata['customers']		= $this->customers_model->get_customer_list();
		
		$this->load->view('station/header', $maindata);
		$this->load->view('station/trackingnumbers', $maindata);
		$this->load->view('station/footer', $maindata);
	}

	public function view()
	{
		$id	= $this->input->get('id');
		if(!isset($id) || $id == ''){
			redirect('station/trackingnumbers');
		}
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['level']			= $this->level;
		$maindata['userid']			= $this->userid;
		$maindata['parent_title']	= 'trackingnumbers';
		$maindata['page_title']		= 'trackingnumber_view';
		$maindata['trackings']		= $this->trackingnumbers_model->get_trackingdetail($id);
		$trackinginfo				= $this->trackingnumbers_model->get_trackingnumber($id);
		$maindata['tracking_number']= $trackinginfo[0]->tracking_number;
		$maindata['tracking_number_id']= $trackinginfo[0]->id;
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses();

		$this->load->view('station/header', $maindata);
		$this->load->view('admin/trackingnumber_view', $maindata);
		$this->load->view('station/footer', $maindata);
	}

	public function get_trackingdetail() {
		
		$id	= $this->input->post('id');
		$res= $this->trackingnumbers_model->get_trackingdetail($id);
		
		echo json_encode($res);
	}
	
	public function create() {
		
		$tracking_data['docket']				= $this->input->post('docket');
		$tracking_data['tracking_number']		= $this->input->post('tracking_number');
		$tracking_data['sender_station']		= $this->userid;
		$tracking_data['receiver_station']		= $this->input->post('receiver_station');
		$tracking_data['size']					= $this->input->post('size');
		$tracking_data['weight']				= $this->input->post('weight');
		$tracking_data['no_of_pieces']			= $this->input->post('no_of_pieces');
		$tracking_data['parcel_type']			= $this->input->post('parcel_type');
		$tracking_data['special_notes']			= $this->input->post('special_notes');
		$tracking_data['content_description']	= $this->input->post('content_description');
		$tracking_data['sender_id']				= $this->input->post('sender_id');
		$tracking_data['receiver_id']			= $this->input->post('receiver_id');
		$tracking_data['created_at']			= $this->currenttime;
		$tracking_data['creator_type']			= $this->level;
		$tracking_data['created_by']			= $this->userid;

		$status_data['status_id']				= $this->input->post('status_id');
		$status_data['date_stamp']				= strtotime($this->input->post('date_stamp'));
		$status_data['remark']					= $this->input->post('remark');
		$status_data['location']				= $this->input->post('location');
		$status_data['created_at']				= $this->currenttime;
		$status_data['creator_type']			= $this->level;
		$status_data['created_by']				= $this->userid;
		

		if($this->input->post('size') == ''){
			unset($tracking_data['size']);
		}
		if($this->input->post('weight') == ''){
			unset($tracking_data['weight']);
		}
		if($this->input->post('no_of_pieces') == ''){
			unset($tracking_data['no_of_pieces']);
		}
		if($this->input->post('special_notes') == ''){
			unset($tracking_data['special_notes']);
		}
		if($this->input->post('content_description') == ''){
			unset($tracking_data['content_description']);
		}
		if($this->input->post('remark') == ''){
			unset($status_data['remark']);
		}

		// $this->load->library('upload');
		// if(isset($_FILES['image_path'])){
		// 	if($_FILES['image_path']['size'] > 0){
		// 		$config = array(
		// 			'upload_path' => "./uploads/delivery/",
		// 			'allowed_types' => "jpg|png|jpeg",
		// 			'overwrite' => TRUE,
		// 			'max_size' => "2048000",
		// 			'max_height' => "1025",
		// 			'max_width' => "2059",
		// 			'file_name' => date('YmdHis').rand(0, 1000)
		// 		);

		// 		$this->upload->initialize($config);
		// 		if($this->upload->do_upload('image_path')){
		// 			$status_data['image_path'] = $this->upload->file_name;
		// 		}
		// 	}
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
				$filepath = 'uploads/delivery/'.$filename;

				$resourceType = imagecreatefromjpeg($file);
				$imageLayer = $this->resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height);
				imagejpeg($imageLayer, $filepath);
				
				$status_data['image_path'] = $filename;
			}
		}
		
		$res	= $this->trackingnumbers_model->insert_trackingnumber($tracking_data, $status_data);


		$sender_station_info = $this->stations_model->get_station($tracking_data['sender_station']);
		$station_name 	= $sender_station_info[0]->name;
		$station_email 	= $sender_station_info[0]->primary_email;
		$station_userid = $sender_station_info[0]->id;
		$station_level  = 1;
		
			// send email to admin
		
		$this->load->library('Ah_Email', 'ah_email');
		
		$tracking_number = $tracking_data['tracking_number'];
		$title   = $tracking_number;
		$content  = 'Dear Admin<br/>';
		$content .= 'You received a '.$tracking_number.'.<br/>';
//		$link =  base_url().'admin/Trackingnumbers/get_search?query='.$tracking_number;
		$link =  base_url().'admin/Trackingnumbers/show_trackingnumber_detail?query='.$tracking_number;
//		$link =  base_url().'admin/Trackingnumbers';
		$content .= 'You may login to the system to find out more or <a href="'.$link.'">click here</a>.<br/>';
		$content .= 'From<br/>Notification.'; 

		$email_notice_onoff = $this->session->userdata('email_notice_onoff');
		if($email_notice_onoff == 1){
	         $this->ah_email->send($station_email, 'demo', 
	         //$this->ah_email->send('coreinfonet@gmail.com', 'demo', 
//	         $this->ah_email->send('noreply@ambergloballogistics.com', 'demo', 
					         array(
					            'username'  => $this->username,
					            'message'   => $content,
					            'mailtype'  => 'text'
					        	),
					         array('subject'    => $title));      
		}
   	
       	//Notification
       	$options = array(
		    'cluster' => 'eu',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    '0c8237974ab4bd669688',
		    '5cb5af1f77e8e460645e',
		    '1148721',
		    $options
		  );
 		 
 		  $sender_data 		= $this->users_model->get_userinfo($tracking_data['sender_id'], 3);
		  $receiver_data 	= $this->users_model->get_userinfo($tracking_data['receiver_id'], 3);
		  
		  $data['message'] 			= $title.'<br/>'.$content;
		  $data['tracking_data'] 	= $tracking_data;
		  $data['status_data'] 		= $status_data;
		  $data['sender_data'] 		= $sender_data[0];
		  $data['receiver_data'] 	= $receiver_data[0];
		  
		  $data['dest_userid'] = 'admin';
		  $data['dest_userlevel'] = 0;
		  
//		  $data['message'] = 'hello world';
		//  $pusher->trigger('my-channel', 'my-event', $data);
		  $pusher->trigger('my-app-development', 'my-event', $data);
		  
		  $notice_data['title'] 		= $title;
		  $notice_data['content'] 		= $content;
		  $notice_data['user_id'] 		= $this->userid;
		  $notice_data['track_num_id'] 	= $tracking_number;
		  $notice_data['created_at'] 	= $this->currenttime;
		  $notice_data['link'] 			= $link;
		  $notice_data['read_status'] 	= 0;
		  
		  $notice_data['sender_name'] 			= $sender_data[0]->name;
		  $notice_data['sender_email'] 			= $sender_data[0]->email;
		  $notice_data['sender_contact_num'] 	= $sender_data[0]->contact_number;
		  $notice_data['sender_address_type'] 	= $sender_data[0]->address;
		  $notice_data['sender_office'] 		= '';
		  $notice_data['sender_address'] 		= $sender_data[0]->address;
		  $notice_data['sender_postcode'] 		= $sender_data[0]->post_code;
		  $notice_data['sender_city'] 			= $sender_data[0]->city;
		  $notice_data['sender_state'] 			= $sender_data[0]->state;
		  $notice_data['sender_country'] 		= $sender_data[0]->country;
		  
		  $notice_data['receiver_name'] 	= $receiver_data[0]->name;
		  $notice_data['receiver_company'] 	= $receiver_data[0]->company_name;
		  $notice_data['receiver_address'] 	= $receiver_data[0]->address;
		  $notice_data['receiver_postcode'] = $receiver_data[0]->post_code;
		  $notice_data['receiver_city'] 	= $receiver_data[0]->city;
		  $notice_data['receiver_state'] 	= $receiver_data[0]->state;
		  $notice_data['receiver_country'] 	= $receiver_data[0]->country;
		  
		  $parcel_type = $tracking_data['parcel_type'];
		  switch($parcel_type){
		  	case 1:
		  		$parcel_type = 'Parcel'; break;
		  	case 2:
		  		$parcel_type = 'Document'; break;
		  	case 3:
		  		$parcel_type = 'Heavy Shipment'; break;		  	
		  }
		  
		  $notice_data['parcel_type'] 			= $parcel_type;
		  $notice_data['content_description'] 	= $tracking_data['content_description'];
		  
		  $notice_data['dest_userid'] = '2';//admin2
		  $notice_data['dest_userlevel'] = 0;
		  
		  $this->notifications_model->insert_notice_track($notice_data);
		  
				
		echo json_encode($res);
	}
	
	public function delete() {
		
		$id	= $this->input->post('id');
		$res= $this->trackingnumbers_model->delete_trackingnumber($id);
		
		echo json_encode($res);
	}
	
	public function update() {
		$id	= $this->input->post('id');
		
		$tracking_data['docket']				= $this->input->post('docket');
		$tracking_data['tracking_number']		= $this->input->post('tracking_number');
		$tracking_data['sender_station']		= $this->userid;
		$tracking_data['receiver_station']		= $this->input->post('receiver_station');
		$tracking_data['size']					= $this->input->post('size');
		$tracking_data['weight']				= $this->input->post('weight');
		$tracking_data['no_of_pieces']			= $this->input->post('no_of_pieces');
		$tracking_data['parcel_type']			= $this->input->post('parcel_type');
		$tracking_data['special_notes']			= $this->input->post('special_notes');
		$tracking_data['content_description']	= $this->input->post('content_description');
		$tracking_data['sender_id']				= $this->input->post('sender_id');
		$tracking_data['receiver_id']			= $this->input->post('receiver_id');
		// $tracking_data['created_at']			= $this->currenttime;
		// $tracking_data['creator_type']			= $this->level;
		// $tracking_data['created_by']			= $this->userid;

		if($this->input->post('size') == ''){
			unset($tracking_data['size']);
		}
		if($this->input->post('weight') == ''){
			unset($tracking_data['weight']);
		}
		if($this->input->post('no_of_pieces') == ''){
			unset($tracking_data['no_of_pieces']);
		}
		if($this->input->post('special_notes') == ''){
			unset($tracking_data['special_notes']);
		}
		if($this->input->post('content_description') == ''){
			unset($tracking_data['content_description']);
		}
		
		$res	= $this->trackingnumbers_model->update_trackingnumber($id, $tracking_data);
		
		echo json_encode($res);
	}
	
	public function get_trackingnumber() {
		
		$id	= $this->input->post('id');
		$res= $this->trackingnumbers_model->get_trackingnumber($id);
		
		echo json_encode($res);
	}

	public function get_trackingstatus() {
		
		$id	= $this->input->post('id');
		$res= $this->trackingnumbers_model->get_trackingstatus($id);
		
		echo json_encode($res);
	}

	public function create_status() {

		$status_data['tracking_number_id']	= $this->input->post('tracking_number_id');
		$status_data['status_id']			= $this->input->post('status_id');
		$status_data['date_stamp']			= strtotime($this->input->post('date_stamp'));
		$status_data['remark']				= $this->input->post('remark');
		$status_data['location']			= $this->input->post('location');
		$status_data['created_at']			= $this->currenttime;
		$status_data['creator_type']		= $this->level;
		$status_data['created_by']			= $this->userid;
		// $image_path								= $this->input->post('image_path');
		
		if($this->input->post('remark') == ''){
			unset($status_data['remark']);
		}

		// if($image_path != ''){
		// 	$img = str_replace('data:image/png;base64,', '', $image_path);
		// 	$img = str_replace(' ', '+', $img);
		// 	$imagedata = base64_decode($img);
		// 	$filename = date('YmdHis').rand(0, 1000).'.png';
		// 	$file = 'uploads/delivery/'.$filename;
			
		// 	file_put_contents($file, $imagedata);
		// 	$status_data['image_path'] = $filename;
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
				$filepath = 'uploads/delivery/'.$filename;

				$resourceType = imagecreatefromjpeg($file);
				$imageLayer = $this->resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height);
				imagejpeg($imageLayer, $filepath);
				
				$status_data['image_path'] = $filename;
			}
		}
		
		$res	= $this->trackingnumbers_model->insert_trackingstatus($status_data, $this->name);
		
		
			
		$tracking_data 	= $this->trackingnumbers_model->get_trackingnumber($status_data['tracking_number_id']);
		$tracking_data 	= $tracking_data[0];
		$sender_id 		= $tracking_data->sender_id;
		$sender_info 	= $this->customers_model->get_customer($sender_id);
		$sender_email	= $sender_info[0]->email;
		$sender_name	= $sender_info[0]->name;

				// send email to admin
		
		$this->load->library('Ah_Email', 'ah_email');
		
		$tracking_number = $tracking_data->tracking_number;
		$title   = $tracking_number;
		$content  = 'Dear '.$sender_name.'<br/>';
		$content .= 'You received a '.$tracking_number.'.<br/>';
		$link =  base_url().'customer/Trackingnumbers/show_trackingnumber_detail?query='.$tracking_number;
		$content .= 'You may login to the system to find out more or <a href="'.$link.'">click here</a>.<br/>';
		$content .= 'From<br/>Notification.'; 

		$email_notice_onoff = $this->session->userdata('email_notice_onoff');
		if($email_notice_onoff == 1){
	         $this->ah_email->send($sender_email, 'demo', 
	         
	         //$this->ah_email->send('coreinfonet@gmail.com', 'demo', 
//	         $this->ah_email->send('noreply@ambergloballogistics.com', 'demo', 
					         array(
					            'username'  => $this->username,
					            'message'   => $content,
					            'mailtype'  => 'text'
					        	),
					         array('subject'    => $title));      
		}
   	
       	//Notification
       	$options = array(
		    'cluster' => 'eu',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    '0c8237974ab4bd669688',
		    '5cb5af1f77e8e460645e',
		    '1148721',
		    $options
		  );
 		 
 		  $sender_data 		= $this->users_model->get_userinfo($tracking_data->sender_id, 3);
		  $receiver_data 	= $this->users_model->get_userinfo($tracking_data->receiver_id, 3);
		  
		  $data['message'] 			= $title.'<br/>'.$content;
		  $data['tracking_data'] 	= $tracking_data;
		  $data['status_data'] 		= $status_data;
		  $data['sender_data'] 		= $sender_data[0];
		  $data['receiver_data'] 	= $receiver_data[0];
		  
		  $data['dest_userid'] = $sender_id;
		  $data['dest_userlevel'] = 3;
	
		  $pusher->trigger('my-app-development', 'my-event', $data);
		  
		  $notice_data['title'] 		= $title;
		  $notice_data['content'] 		= $content;
		  $notice_data['user_id'] 		= $this->userid;
		  $notice_data['track_num_id'] 	= $tracking_number;
		  $notice_data['created_at'] 	= $this->currenttime;
		  $notice_data['link'] 			= $link;
		  $notice_data['read_status'] 	= 0;
		  
		  $notice_data['sender_name'] 			= $sender_data[0]->name;
		  $notice_data['sender_email'] 			= $sender_data[0]->email;
		  $notice_data['sender_contact_num'] 	= $sender_data[0]->contact_number;
		  $notice_data['sender_address_type'] 	= $sender_data[0]->address;
		  $notice_data['sender_office'] 		= '';
		  $notice_data['sender_address'] 		= $sender_data[0]->address;
		  $notice_data['sender_postcode'] 		= $sender_data[0]->post_code;
		  $notice_data['sender_city'] 			= $sender_data[0]->city;
		  $notice_data['sender_state'] 			= $sender_data[0]->state;
		  $notice_data['sender_country'] 		= $sender_data[0]->country;
		  
		  $notice_data['receiver_name'] 	= $receiver_data[0]->name;
		  $notice_data['receiver_company'] 	= $receiver_data[0]->company_name;
		  $notice_data['receiver_address'] 	= $receiver_data[0]->address;
		  $notice_data['receiver_postcode'] = $receiver_data[0]->post_code;
		  $notice_data['receiver_city'] 	= $receiver_data[0]->city;
		  $notice_data['receiver_state'] 	= $receiver_data[0]->state;
		  $notice_data['receiver_country'] 	= $receiver_data[0]->country;
		  
		  $parcel_type = $tracking_data->parcel_type;
		  switch($parcel_type){
		  	case 1:
		  		$parcel_type = 'Parcel'; break;
		  	case 2:
		  		$parcel_type = 'Document'; break;
		  	case 3:
		  		$parcel_type = 'Heavy Shipment'; break;		  	
		  }
		  
		  $notice_data['parcel_type'] 			= $parcel_type;
		  $notice_data['content_description'] 	= $tracking_data->content_description;
		  
		  $notice_data['dest_userid'] = $sender_id;//admin2
		  $notice_data['dest_userlevel'] = 3;
		  
		  $this->notifications_model->insert_notice_track($notice_data);
		  
	
				
		echo json_encode($res);
	}

	public function update_status() {

		$id									= $this->input->post('id');
		$status_data['tracking_number_id']	= $this->input->post('tracking_number_id');
		$status_data['status_id']			= $this->input->post('status_id');
		$status_data['date_stamp']			= strtotime($this->input->post('date_stamp'));
		$status_data['remark']				= $this->input->post('remark');
		$status_data['location']			= $this->input->post('location');
		// $status_data['created_at']			= $this->currenttime;
		// $status_data['creator_type']		= $this->level;
		// $status_data['created_by']			= $this->userid;
		// $image_path					= $this->input->post('image_path');
		
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
		$res	= $this->trackingnumbers_model->update_trackingstatus($id, $status_data);
		
		$tracking_data 	= $this->trackingnumbers_model->get_trackingnumber($status_data['tracking_number_id']);
		$tracking_data 	= $tracking_data[0];
		$sender_id 		= $tracking_data->sender_id;
		$sender_info 	= $this->customers_model->get_customer($sender_id);
		$sender_email	= $sender_info[0]->email;
		$sender_name	= $sender_info[0]->name;
		
				// send email to admin
		
		$this->load->library('Ah_Email', 'ah_email');
		
		$tracking_number = $tracking_data->tracking_number;
		$title   = $tracking_number;
		$content  = 'Dear '.$sender_name.'<br/>';
		$content .= 'You received a '.$tracking_number.'.<br/>';
		$link =  base_url().'customer/Trackingnumbers/show_trackingnumber_detail?query='.$tracking_number;
		$content .= 'You may login to the system to find out more or <a href="'.$link.'">click here</a>.<br/>';
		$content .= 'From<br/>Notification.'; 

		$email_notice_onoff = $this->session->userdata('email_notice_onoff');
		if($email_notice_onoff == 1){
	         $this->ah_email->send($sender_email, 'demo', 
	         //$this->ah_email->send('coreinfonet@gmail.com', 'demo', 
//	         $this->ah_email->send('noreply@ambergloballogistics.com', 'demo', 
					         array(
					            'username'  => $this->username,
					            'message'   => $content,
					            'mailtype'  => 'text'
					        	),
					         array('subject'    => $title));      
		}
   	
       	//Notification
       	$options = array(
		    'cluster' => 'eu',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    '0c8237974ab4bd669688',
		    '5cb5af1f77e8e460645e',
		    '1148721',
		    $options
		  );
 		 
 		  $sender_data 		= $this->users_model->get_userinfo($tracking_data->sender_id, 3);
		  $receiver_data 	= $this->users_model->get_userinfo($tracking_data->receiver_id, 3);
		  
		  $data['message'] 			= $title.'<br/>'.$content;
		  $data['tracking_data'] 	= $tracking_data;
		  $data['status_data'] 		= $status_data;
		  $data['sender_data'] 		= $sender_data[0];
		  $data['receiver_data'] 	= $receiver_data[0];
		  
		  $data['dest_userid'] = $sender_id;
		  $data['dest_userlevel'] = 3;
	
		  $pusher->trigger('my-app-development', 'my-event', $data);
		  
		  $notice_data['title'] 		= $title;
		  $notice_data['content'] 		= $content;
		  $notice_data['user_id'] 		= $this->userid;
		  $notice_data['track_num_id'] 	= $tracking_number;
		  $notice_data['created_at'] 	= $this->currenttime;
		  $notice_data['link'] 			= $link;
		  $notice_data['read_status'] 	= 0;
		  
		  $notice_data['sender_name'] 			= $sender_data[0]->name;
		  $notice_data['sender_email'] 			= $sender_data[0]->email;
		  $notice_data['sender_contact_num'] 	= $sender_data[0]->contact_number;
		  $notice_data['sender_address_type'] 	= $sender_data[0]->address;
		  $notice_data['sender_office'] 		= '';
		  $notice_data['sender_address'] 		= $sender_data[0]->address;
		  $notice_data['sender_postcode'] 		= $sender_data[0]->post_code;
		  $notice_data['sender_city'] 			= $sender_data[0]->city;
		  $notice_data['sender_state'] 			= $sender_data[0]->state;
		  $notice_data['sender_country'] 		= $sender_data[0]->country;
		  
		  $notice_data['receiver_name'] 	= $receiver_data[0]->name;
		  $notice_data['receiver_company'] 	= $receiver_data[0]->company_name;
		  $notice_data['receiver_address'] 	= $receiver_data[0]->address;
		  $notice_data['receiver_postcode'] = $receiver_data[0]->post_code;
		  $notice_data['receiver_city'] 	= $receiver_data[0]->city;
		  $notice_data['receiver_state'] 	= $receiver_data[0]->state;
		  $notice_data['receiver_country'] 	= $receiver_data[0]->country;
		  
		  $parcel_type = $tracking_data->parcel_type;
		  switch($parcel_type){
		  	case 1:
		  		$parcel_type = 'Parcel'; break;
		  	case 2:
		  		$parcel_type = 'Document'; break;
		  	case 3:
		  		$parcel_type = 'Heavy Shipment'; break;		  	
		  }
		  
		  $notice_data['parcel_type'] 			= $parcel_type;
		  $notice_data['content_description'] 	= $tracking_data->content_description;
		  
		  $notice_data['dest_userid'] = $sender_id;//admin2
		  $notice_data['dest_userlevel'] = 3;
		  
		  $this->notifications_model->insert_notice_track($notice_data);
		  
	
		
				
		echo json_encode($res);
	}

	function resizeImage($resourceType, $image_width, $image_height, $new_width, $new_height) {
		$dst = imagecreatetruecolor( $new_width, $new_height );
		imagecopyresampled( $dst, $resourceType, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height );
		return $dst;
	}

	public function delete_status() {
		
		$id	= $this->input->post('id');
		$tracking_number_id	= $this->input->post('tracking_number_id');
		$res= $this->trackingnumbers_model->delete_trackingstatus($id, $tracking_number_id);
		
		echo json_encode($res);
	}

	public function get_last_status() {
		
		$id	= $this->input->post('id');
		$res = $this->trackingnumbers_model->get_last_status($id);
		
		echo json_encode($res);
	}

	public function pdfexport() {
		$id	= $this->input->get('id');
		if(!isset($id) || $id == ''){
			redirect('admin/trackingnumbers');
		}

		$trackinginfo = $this->trackingnumbers_model->get_trackingnumber($id);
		$station_id = $trackinginfo[0]->station_id;
		//$station_id = $trackinginfo[0]->sender_station;
		$sender_id = $trackinginfo[0]->sender_id;
		$receiver_id = $trackinginfo[0]->receiver_id;
		$tracking_number = $trackinginfo[0]->tracking_number;
		$stationinfo = $this->stations_model->get_station($station_id);
		$senderinfo = $this->customers_model->get_customer($sender_id);
		$receiverinfo = $this->customers_model->get_customer($receiver_id);
		$tracking_number_prefix = $stationinfo[0]->name.'-'.$tracking_number;
		$statusinfo = $this->trackingnumbers_model->get_last_status($id);
		if($statusinfo === false){
			$date_stamp = '';
		}else{
			$date_stamp = date('d M Y', $statusinfo[0]->date_stamp);
		}

		$parcel_type = '';
		if($trackinginfo[0]->parcel_type == 1){
			$parcel_type = 'Parcel';
		}elseif($trackinginfo[0]->parcel_type == 2){
			$parcel_type = 'Document';
		}else{
			$parcel_type = 'Heavy Shipment';
		}

		include 'application/libraries/phpqrcode/qrlib.php'; 
		  
		$path = 'uploads/qr/'; 
		$file = $path."qr.png"; 
			
		$ecc = 'L';
		$pixel_Size = 10; 
			
		// Generates QR Code and Stores it in directory given 
		QRcode::png($tracking_number, $file, $ecc, $pixel_Size);

		$html = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title>PDF Generate</title>
				<style>
				@page {
					margin: 0mm 10mm 0mm 10mm;
				}
				th,td,tr {
					border:1px solid black;
					border-collapse:collapse;
				  }
				  
				  table {
					border:1px solid black;
					border-collapse:collapse;
					table-layout: fixed;
					
				  }
				  
				  td {
					font-family:Arial;
					font-size:14px;
					overflow:hidden;
					word-wrap: break-word;
					word-break: break-all;
				  }
				  
			</style>
			</head>
			<body>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="'.base_url().'assets/img/amber/amberlogic.JPG" style="hight:10px; width: 540px;">
			<table cellspacing="0" cellpadding="0" width="729" id="printablessArea">
				<tbody>
					<tr>
						<td width="20" height="20" style="background-color: #000000; color: #ffffff; text-align: center;">1</td>
						<td width="550" colspan="4">&nbsp;Account Number:</td>
						<td width="159" rowspan="6" valign="top">
							<table width="100%" height="100%" style="table-layout: fixed;">
								<tr>
									<td colspan="2" valign="top" style="text-align: center;"  height="50">
									Customer Reference<br>
									&nbsp;<br>
									</td>
								</td>
								<tr>
									<td width="20" style="background-color: #000000; color: #ffffff; text-align: center;">5</td>
									<td>&nbsp;Service Type</td>
								</td>
								<tr>
									<td colspan="2" style="text-align: center;"  height="30">
									&nbsp;'.$parcel_type.'<br>
									</td>
								</td>
								<tr>
									<td width="20" style="background-color: #000000; color: #ffffff; text-align: center;">6</td>
									<td>&nbsp;Declared Value</td>
								</td>
								<tr>
									<td colspan="2" height="70">
									&nbsp;<br>
									&nbsp;<br>
									&nbsp;<br>
									</td>
								</td>
								<tr>
									<td colspan="2" valign="top" height="110">
									&nbsp;&nbsp;&nbsp;Special Instructions
									&nbsp;<br>
									'.$this->fun_cutstring($trackinginfo[0]->special_notes, 20).'
									</td>
								</td>
								<tr>
									<td width="20" style="background-color: #000000; color: #ffffff; text-align: center;">7</td>
									<td>&nbsp;Size&nbsp;&nbsp;'.$trackinginfo[0]->size.'</td>
								</td>
								<tr>
									<td colspan="2">&nbsp;Weight(kg)&nbsp;&nbsp;'.$trackinginfo[0]->weight.'</td>
								</td>
								<tr>
									<td colspan="2">&nbsp;Dimension&nbsp;&nbsp;</td>
								</td>
								<tr>
									<td colspan="2">&nbsp;Pieces&nbsp;&nbsp;'.$trackinginfo[0]->no_of_pieces.'</td>
								</td>
								<tr>
									<td colspan="2" valign="top" height="86">
									&nbsp;Vol&Charged Weight
									&nbsp;<br>
									</td>
								</td>
							</table>
						</td>
					</tr>
					<tr>
						<td width="20" height="20" style="background-color: #000000; color: #ffffff; text-align: center;">2</td>
						<td width="540" colspan="4">&nbsp;Sender</td>
					</tr>
					<tr>
						<td width="20" rowspan="2">&nbsp;</td>
						<td width="190" rowspan="2" valign="top">
						&nbsp;'.$senderinfo[0]->name.'<br>
						&nbsp;'.$senderinfo[0]->company_name.'<br>
						'.$this->fun_cutstring($senderinfo[0]->address, 25).'<br>
						'.$this->fun_cutstring($senderinfo[0]->city.','.$senderinfo[0]->state.','.$senderinfo[0]->post_code, 25).'<br>
						&nbsp;'.$senderinfo[0]->country.'<br>
						&nbsp;<br>
						&nbsp;Contact: '.$senderinfo[0]->contact_number.'<br>
						</td>
						<td width="150" rowspan="2" valign="top">Sender\'s Signature
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;Date: '.$date_stamp.'<br>
						&nbsp;<br>
						</td>
						<td width="20" valign="top" style="background-color: #000000; color: #ffffff; text-align: center;">4</td>
						<td width="190" valign="top" height="20" style="text-align: center;">
						&nbsp;Content Descriptions
						</td>
					</tr>
					<tr>
						<td width="190" height="180" colspan="2" valign="top">
						'.$this->fun_cutstring($trackinginfo[0]->content_description, 27).'
						</td>
					</tr>
					<tr>
						<td width="20" height="20" style="background-color: #000000; color: #ffffff; text-align: center;">3</td>
						<td width="550" colspan="4">&nbsp;Receiver</td>
					</tr>
					<tr>
						<td width="20" height="200">&nbsp;</td>
						<td width="190" valign="top">
						&nbsp;'.$receiverinfo[0]->name.'<br>
						&nbsp;'.$receiverinfo[0]->company_name.'<br>
						'.$this->fun_cutstring($receiverinfo[0]->address, 25).'<br>
						'.$this->fun_cutstring($receiverinfo[0]->city.','.$receiverinfo[0]->state.','.$receiverinfo[0]->post_code, 25).'<br>
						&nbsp;'.$receiverinfo[0]->country.'<br>
						&nbsp;<br>
						&nbsp;Contact: '.$receiverinfo[0]->contact_number.'<br>
						</td>
						<td width="150" valign="top">&nbsp;Receiver\'s Signature
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;Date:<br>
						&nbsp;<br>
						&nbsp;<br>
						</td>
						<td width="210" colspan="2" valign="top" style="text-align: center;">
						<img src="'.base_url().'barcode.php?codetype=Code128&size=60&text='.$tracking_number.'&print=true" width="200px" height="100px" style="padding-top:10px"><br>
						<img src="'.base_url().$file.'" style="width: 100px;"/>
						</td>
					</tr>
				</tbody>
			</table>
			<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="'.base_url().'assets/img/amber/amberlogic.JPG" style="hight:10px; width: 540px;">
			<table cellspacing="0" cellpadding="0" width="729" id="printablessArea">
				<tbody>
					<tr>
						<td width="20" height="20" style="background-color: #000000; color: #ffffff; text-align: center;">1</td>
						<td width="550" colspan="4">&nbsp;Account Number:</td>
						<td width="159" rowspan="6" valign="top">
							<table width="100%" height="100%" style="table-layout: fixed;">
								<tr>
									<td colspan="2" valign="top" style="text-align: center;"  height="50">
									Customer Reference<br>
									&nbsp;<br>
									</td>
								</td>
								<tr>
									<td width="20" style="background-color: #000000; color: #ffffff; text-align: center;">5</td>
									<td>&nbsp;Service Type</td>
								</td>
								<tr>
									<td colspan="2" style="text-align: center;"  height="30">
									&nbsp;'.$parcel_type.'<br>
									</td>
								</td>
								<tr>
									<td width="20" style="background-color: #000000; color: #ffffff; text-align: center;">6</td>
									<td>&nbsp;Declared Value</td>
								</td>
								<tr>
									<td colspan="2" height="70">
									&nbsp;<br>
									&nbsp;<br>
									&nbsp;<br>
									</td>
								</td>
								<tr>
									<td colspan="2" valign="top" height="110">
									&nbsp;&nbsp;&nbsp;Special Instructions
									&nbsp;<br>
									'.$this->fun_cutstring($trackinginfo[0]->special_notes, 20).'
									</td>
								</td>
								<tr>
									<td width="20" style="background-color: #000000; color: #ffffff; text-align: center;">7</td>
									<td>&nbsp;Size&nbsp;&nbsp;'.$trackinginfo[0]->size.'</td>
								</td>
								<tr>
									<td colspan="2">&nbsp;Weight(kg)&nbsp;&nbsp;'.$trackinginfo[0]->weight.'</td>
								</td>
								<tr>
									<td colspan="2">&nbsp;Dimension&nbsp;&nbsp;</td>
								</td>
								<tr>
									<td colspan="2">&nbsp;Pieces&nbsp;&nbsp;'.$trackinginfo[0]->no_of_pieces.'</td>
								</td>
								<tr>
									<td colspan="2" valign="top" height="86">
									&nbsp;Vol&Charged Weight
									&nbsp;<br>
									</td>
								</td>
							</table>
						</td>
					</tr>
					<tr>
						<td width="20" height="20" style="background-color: #000000; color: #ffffff; text-align: center;">2</td>
						<td width="540" colspan="4">&nbsp;Sender</td>
					</tr>
					<tr>
						<td width="20" rowspan="2">&nbsp;</td>
						<td width="190" rowspan="2" valign="top">
						&nbsp;'.$senderinfo[0]->name.'<br>
						&nbsp;'.$senderinfo[0]->company_name.'<br>
						'.$this->fun_cutstring($senderinfo[0]->address, 25).'<br>
						'.$this->fun_cutstring($senderinfo[0]->city.','.$senderinfo[0]->state.','.$senderinfo[0]->post_code, 25).'<br>
						&nbsp;'.$senderinfo[0]->country.'<br>
						&nbsp;<br>
						&nbsp;Contact: '.$senderinfo[0]->contact_number.'<br>
						</td>
						<td width="150" rowspan="2" valign="top">Sender\'s Signature
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;Date: '.$date_stamp.'<br>
						&nbsp;<br>
						</td>
						<td width="20" valign="top" style="background-color: #000000; color: #ffffff; text-align: center;">4</td>
						<td width="190" valign="top" height="20" style="text-align: center;">
						&nbsp;Content Descriptions
						</td>
					</tr>
					<tr>
						<td width="190" height="180" colspan="2" valign="top">
						'.$this->fun_cutstring($trackinginfo[0]->content_description, 27).'
						</td>
					</tr>
					<tr>
						<td width="20" height="20" style="background-color: #000000; color: #ffffff; text-align: center;">3</td>
						<td width="550" colspan="4">&nbsp;Receiver</td>
					</tr>
					<tr>
						<td width="20" height="200">&nbsp;</td>
						<td width="190" valign="top">
						&nbsp;'.$receiverinfo[0]->name.'<br>
						&nbsp;'.$receiverinfo[0]->company_name.'<br>
						'.$this->fun_cutstring($receiverinfo[0]->address, 25).'<br>
						'.$this->fun_cutstring($receiverinfo[0]->city.','.$receiverinfo[0]->state.','.$receiverinfo[0]->post_code, 25).'<br>
						&nbsp;'.$receiverinfo[0]->country.'<br>
						&nbsp;<br>
						&nbsp;Contact: '.$receiverinfo[0]->contact_number.'<br>
						</td>
						<td width="150" valign="top">&nbsp;Receiver\'s Signature
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;<br>
						&nbsp;Date:<br>
						&nbsp;<br>
						&nbsp;<br>
						</td>
						<td width="210" colspan="2" valign="top" style="text-align: center;">
						<img src="'.base_url().'barcode.php?codetype=Code128&size=60&text='.$tracking_number.'&print=true" width="200px" height="100px" style="padding-top:10px">
						<img src="'.base_url().$file.'" style="width: 100px;"/>
						</td>
					</tr>
				</tbody>
			</table>

			</body>
			</html>';
		// print_r($html);
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
	
	public function pdfexport1() {
		$id	= $this->input->get('id');
		if(!isset($id) || $id == ''){
			redirect('station/trackingnumbers');
		}

		$trackinginfo = $this->trackingnumbers_model->get_trackingnumber($id);
		$station_id = $trackinginfo[0]->station_id;
		$sender_id = $trackinginfo[0]->sender_id;
		$receiver_id = $trackinginfo[0]->receiver_id;
		$tracking_number = $trackinginfo[0]->tracking_number;
		$stationinfo = $this->stations_model->get_station($station_id);
		$senderinfo = $this->customers_model->get_customer($sender_id);
		$receiverinfo = $this->customers_model->get_customer($receiver_id);
		$tracking_number_prefix = $stationinfo[0]->name.'-'.$tracking_number;
		$statusinfo = $this->trackingnumbers_model->get_last_status($id);
		if($statusinfo === false){
			$date_stamp = '';
		}else{
			$date_stamp = date('d M Y', $statusinfo[0]->date_stamp);
		}

		$parcel_type = '';
		if($trackinginfo[0]->parcel_type == 1){
			$parcel_type = 'Parcel';
		}elseif($trackinginfo[0]->parcel_type == 2){
			$parcel_type = 'Document';
		}else{
			$parcel_type = 'Heavy Shipment';
		}

		include 'application/libraries/phpqrcode/qrlib.php'; 
		  
		$path = 'uploads/qr/'; 
		$file = $path."qr.png"; 
			
		$ecc = 'L';
		$pixel_Size = 10; 
			
		// Generates QR Code and Stores it in directory given 
		QRcode::png($tracking_number, $file, $ecc, $pixel_Size);

		$html = '<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title>PDF Generate</title>
				<style>
				@page {
					margin: 0mm 2mm 0mm 2mm;
				}
				th,td,tr {
					border:1px solid black;
					border-collapse:collapse;
				  }
				  
				  table {
					border:1px solid black;
					border-collapse:collapse;
					table-layout: fixed;
					
				  }
				  
				  td {
					font-family:Arial;
					font-size:10px;
					overflow:hidden;
					word-wrap: break-word;
					word-break: break-all;
				  }
				  
			</style>
			</head>
			<body>
			<img src="'.base_url().'assets/img/amber/amberlogic.JPG" style="hight:10px; width: 300px;">
			<table cellspacing="0" cellpadding="0" width="300" id="printablessArea">
				<tbody>
					<tr>
						<td colspan="2" width="120" height="15">&nbsp;1. Account Number</td>
						<td width="180"></td>
					</tr>
					<tr>
						<td colspan="3" height="15">&nbsp;2. Sender</td>
					</tr>
					<tr>
						<td colspan="3" height="70" valign="top">
							&nbsp;'.$senderinfo[0]->name.'<br>
							&nbsp;'.$senderinfo[0]->company_name.'<br>
							&nbsp;'.$senderinfo[0]->address.'<br>
							&nbsp;'.$senderinfo[0]->city.','.$senderinfo[0]->state.','.$senderinfo[0]->post_code.'&nbsp;'.$senderinfo[0]->country.'<br>
							&nbsp;Contact: '.$senderinfo[0]->contact_number.'<br>
							&nbsp;Date:&nbsp;'.$date_stamp.'
						</td>
					</tr>
					<tr>
						<td colspan="3" height="15">&nbsp;3. Receiver</td>
					</tr>
					<tr>
						<td colspan="3" height="60" valign="top">
							&nbsp;'.$receiverinfo[0]->name.'<br>
							&nbsp;'.$receiverinfo[0]->company_name.'<br>
							&nbsp;'.$receiverinfo[0]->address.'<br>
							&nbsp;'.$receiverinfo[0]->city.','.$receiverinfo[0]->state.','.$receiverinfo[0]->post_code.'&nbsp;'.$receiverinfo[0]->country.'<br>
							&nbsp;Contact: '.$receiverinfo[0]->contact_number.'<br>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<img src="'.base_url().'barcode.php?codetype=Code128&size=70&text='.$tracking_number.'&print=true" width="200px" height="70px" style="padding-top:10px">
							<img src="'.base_url().$file.'" style="width: 75px; float: right"/>
						</td>
					</tr>
					<tr>
						<td colspan="3" height="25" valign="top">
							&nbsp;4. Content Description<br>
							'.$trackinginfo[0]->content_description.'
						</td>
					</tr>
					<tr>
						<td colspan="3" height="15">&nbsp;Customer Reference</td>
					</tr>
					<tr>
						<td colspan="2" width="120" height="15">&nbsp;Service Type</td>
						<td width="180">&nbsp;'.$parcel_type.'</td>
					</tr>
					<tr>
						<td colspan="2" width="120" height="15">&nbsp;Declared Value</td>
						<td width="180"></td>
					</tr>
					<tr>
						<td colspan="3" height="40" valign="top">
							&nbsp;Special Instructions<br>
							&nbsp;'.$trackinginfo[0]->special_notes.'
						</td>
					</tr>
					<tr>
						<td colspan="2" width="120" height="15">&nbsp;Size&nbsp;&nbsp;'.$trackinginfo[0]->size.'</td>
						<td width="180" rowspan="5" valign="top">
							&nbsp;Receiver\'s Signature<br>
							&nbsp;<br>
							&nbsp;<br>
							&nbsp;<br>
							&nbsp;<br>
							&nbsp;<br>
							&nbsp;Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/<br>
						</td>
					</tr>
					<tr>
						<td width="60" height="15">&nbsp;Weight</td>
						<td width="60">&nbsp;'.$trackinginfo[0]->weight.'</td>
					</tr>
					<tr>
						<td width="60" height="15">&nbsp;Dimension</td>
						<td width="60"></td>
					</tr>
					<tr>
						<td width="60" height="15">&nbsp;Pieces</td>
						<td width="60">&nbsp;'.$trackinginfo[0]->no_of_pieces.'</td>
					</tr>
					<tr>
						<td colspan="2" width="120" height="30" valign="top">&nbsp;Vol&Charged Weight</td>
					</tr>
				</tbody>
			</table>

			</body>
			</html>';

		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [76, 130]]);
		$mpdf->WriteHTML($html);

		$mpdf->Output();
	}
	
	function fun_cutstring($str, $num) {
		$length	= strlen($str);
		if($length == 0) {
			return '';
		}else{
			$cnt	= floor($length / $num);
			$last	= $length % $num;
			
			$result	= '';
			if($cnt > 0){
				for($i = 0; $i < $cnt; $i++){
					$result .= '&nbsp;'.substr($str, $i * $num, $num).'<br>';
				}
				if($last > 0){
					$result .= '&nbsp;'.substr($str, $cnt * $num, $last);
				}
			}else{
				if($last > 0){
					$result .= '&nbsp;'.substr($str, 0, $last);
				}
			}
			
			return $result;
		}
	}
	
	public function get_search()	 {
		$output = '';
		$query = '';
		if($this->input->post('query'))
		{
			$query = $this->input->post('query');
		}
//		$data = $this->trackingnumbers_model->fetch_data($this->userid, $this->level, $query);
		$data = $this->trackingnumbers_model->get_search_data($this->userid, $this->level, $query);
		$nLen = count($data);

		$ret_data['arr_data'] = $data;
		echo json_encode($ret_data);
	}
	
	public function show_trackingnumber_detail()	 {		
		
		if($this->input->get('query'))
		{
			$query = $this->input->get('query');
		}
				
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['level']			= $this->level;
		$maindata['userid']			= $this->userid;
		$maindata['parent_title']	= 'trackingnumbers';
		$maindata['page_title']		= 'trackingnumbers';
		
		$maindata['trackingnumbers']= $this->trackingnumbers_model->get_search_data($this->userid, $this->level, $query);

		$maindata['stations']		= $this->stations_model->get_all_stations($this->userid, $this->level);
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses();
		$maindata['customers']		= $this->customers_model->get_all_customers($this->userid, $this->level);
		
		$this->load->view('station/header', $maindata);
		$this->load->view('station/trackingnumbers', $maindata);
		$this->load->view('station/footer', $maindata);
	}
	
	public function add_trackingnumber()
	{
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['level']			= $this->level;
		$maindata['userid']			= $this->userid;
		
		$maindata['parent_title']	= 'trackingnumbers';
		$maindata['page_title']		= 'add_trackingnumber';
		$maindata['trackingnumbers']= $this->trackingnumbers_model->get_all_trackingnumbers($this->userid, $this->level);
		//$maindata['stations']		= $this->stations_model->get_all_stations($this->userid, $this->level);
		$maindata['stations']		= $this->stations_model->get_all_stations1();
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses();
		$maindata['customers']		= $this->customers_model->get_all_customers($this->userid, $this->level);
		
		$this->load->view('station/header', $maindata);
		$this->load->view('station/trackingnumber_add', $maindata);
		$this->load->view('station/footer', $maindata);
		
		
	}

	public function getTrackingnumbers_pickup()
	{			
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['level']			= $this->level;
		$maindata['userid']			= $this->userid;
		$maindata['parent_title']	= 'trackingnumbers';
		$maindata['page_title']		= 'getTrackingnumbers_pickup';
		// $maindata['trackingnumbers']= $this->trackingnumbers_model->get_all_trackingnumbers($this->userid, $this->level);
		$maindata['trackingnumbers']= $this->trackingnumbers_model->get_trackingnumbers_pickup($this->userid, $this->level);
		$maindata['stations']		= $this->stations_model->get_all_stations1();
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses();
		$maindata['customers']		= $this->customers_model->get_all_customers($this->userid, $this->level);
		
		$this->load->view('station/header', $maindata);
		$this->load->view('station/trackingnumbers', $maindata);
		$this->load->view('station/footer', $maindata);
	}
}
