<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		
		
		$this->load->model('notifications_model');
		$this->load->model('users_model');
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
		}elseif($this->level == '0'){
			redirect('admin/dashboard');
		}
	}
	
	public function index()
	{
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'notifications';
		$maindata['page_title']		= 'notifications';
			
		//$maindata['notice_tracks']= $this->notifications_model->get_notice_track(100);
		$maindata['notice_tracks']= $this->notifications_model->get_notice_track_ByUser($this->userid, $this->level,100);
		
		$this->load->view('customer/header', $maindata);
		$this->load->view('customer/notifications_view', $maindata);
		$this->load->view('customer/footer', $maindata);
	}
	public function get_notice_track()	 {
		$nCnt = '';
		if($this->input->post('nCnt'))
		{
			$nCnt = $this->input->post('nCnt');
		}		

		//$data = $this->notifications_model->get_notice_track($nCnt);
		$data = $this->notifications_model->get_notice_track_ByUser($this->userid, $this->level,$nCnt);
		
		$nLen = count($data);

		$ret_data['arr_data'] = $data;
		echo json_encode($ret_data);
	}
	
	public function getNoticeByTitle()	 {
		$title = '';
		if($this->input->post('title'))
		{
			$title = $this->input->post('title');
		}	
		$data = $this->notifications_model->getNoticeByTitle($title);
		
		$ret_data['arr_data'] = $data;
		echo json_encode($ret_data);
	}
	
	public function show_notice_tracks($nCnt=100){
		
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'notifications';
		$maindata['page_title']		= 'notifications';
	
		$maindata['notice_tracks']= $this->notifications_model->get_notice_track($nCnt);
		
		$this->load->view('customer/header', $maindata);
		$this->load->view('customer/notifications_view', $maindata);
		$this->load->view('customer/footer', $maindata);
	}
	
	public function show_notice_track_ById(){
		$id = $this->input->get('id');
		
		$maindata['username']		= $this->username;
		$maindata['name']			= $this->name;
		$maindata['parent_title']	= 'notifications';
		$maindata['page_title']		= 'notifications';
	
		$maindata['notice_tracks']= $this->notifications_model->getNoticeById($id);
		
		$this->load->view('customer/header', $maindata);
		$this->load->view('customer/notifications_view', $maindata);
		$this->load->view('customer/footer', $maindata);
	}
	
	public function delete_notice_track(){
		$title	= $this->input->post('title');
		$res= $this->notifications_model->delete_notice_track($title);		
		echo json_encode($res);	
	}
	 
}
