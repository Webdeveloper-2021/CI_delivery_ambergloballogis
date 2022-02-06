<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';

require_once 'vendor/pusher/pusher-php-server/src/Pusher.php';
require_once 'vendor/pusher/pusher-php-server/src/PusherCrypto.php';
require_once 'vendor/pusher/pusher-php-server/src/PusherException.php';
require_once 'vendor/pusher/pusher-php-server/src/PusherInstance.php';
require_once 'vendor/pusher/pusher-php-server/src/Webhook.php';

class Pickup_request extends CI_Controller {

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
		}elseif($this->level == '1'){
			redirect('station/dashboard');
		}elseif($this->level == '2'){
			redirect('driver/dashboard');
		}
	}
	
	public function index()
	{
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'pickup_request';
		$maindata['page_title']		= 'pickup_request';
		$maindata['stations']		= $this->stations_model->get_all_stations($this->userid, $this->level);
		$maindata['statuses']		= $this->trackingnumbers_model->get_all_statuses();
		$maindata['customers']		= $this->customers_model->get_all_customers($this->userid, $this->level);
		$tmp						= $this->customers_model->get_customer($this->userid);
		$maindata['user_info']		= $tmp[0];
	
		//$maindata['requests']= $this->trackingnumbers_model->get_all_trackingnumbers_bycustomer($this->userid);
		
		$this->load->view('customer/header', $maindata);
		$this->load->view('customer/pickup_view', $maindata);
		$this->load->view('customer/footer', $maindata);
	}

	public function create() {
		
		$tracking_data['docket']				= $this->input->post('docket');
		$tracking_data['tracking_number']		= $this->input->post('tracking_number');
		$tracking_data['sender_station']		= $this->input->post('sender_station');
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

		//$status_data['status_id']				= $this->input->post('status_id');
		$status_data['status_id']				= 14;	//Pending Confirmation
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

			// send email to admin
		
		$this->load->library('Ah_Email', 'ah_email');
		
		$tracking_number = $tracking_data['tracking_number'];
		$title   = $tracking_number;
		$content  = 'Dear Admin<br/>';
		$content .= 'You received a '.$tracking_number.'.<br/>';
		$link =  base_url().'admin/Trackingnumbers/show_trackingnumber_detail?query='.$tracking_number;
		$content .= 'You may login to the system to find out more or <a href="'.$link.'">click here</a>.<br/>';
		$content .= 'From<br/>Notification.'; 

		$email_notice_onoff = $this->session->userdata('email_notice_onoff');
		if($email_notice_onoff == 1){
	         $this->ah_email->send('coreinfonet@gmail.com', 'demo', 
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
		  	  
		  $notice_data['dest_userid'] 	 = '2';//admin2
		  $notice_data['dest_userlevel'] = 0;
		  
		  $this->notifications_model->insert_notice_track($notice_data);  
				
				
		echo json_encode($res);
	}
	

}
