<?php
/* 
 ** controller: Signin Controller
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//load user model
		$this->load->model('users_model');
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
			$this->load->view('signin');
		}
		
	}
	
	public function user_login_process() {
		$data = array(
			'username'	=> $this->input->post('username'),
			'password'	=> $this->input->post('password')
		);
		
		$result_login = $this->users_model->login($data);
			
		if ($result_login['success'] == TRUE) {
			$username	= $this->input->post('username');
			$role		= $result_login['role'];
			$result		= $this->users_model->read_user_information($username, $role);
			//print_r($role.'-------------');
			if ($result != false) {
				$session_data = array(
					'username'	=> $result[0]->username,
					'name'		=> $result[0]->name,
					'userid' 	=> $result[0]->id,
					'level'		=> $result[0]->userrole
				);
				$this->session->set_userdata('amber_in', $session_data);
				
				$this->session->set_userdata('email_notice_onoff', 1);
								
				$res['success']	= 1;
			}else{
				$res['success']	= 0;
			}
		} else {
			$res['success']	= 2;
		}
		echo json_encode($res);
	}
	
	public function out() {

		$sess_array = array(
			'username' => ''
		);
		$this->session->unset_userdata('amber_in', $sess_array);
		
		$this->session->unset_userdata('email_notice_onoff', 0);
		redirect('signin');
	}
	
	public function change_notice_onoff(){
		$curStatus = $this->session->userdata('email_notice_onoff');
		if($curStatus == 1)
			$this->session->set_userdata('email_notice_onoff', 0);
		else
			$this->session->set_userdata('email_notice_onoff', 1);
		$res['result'] = 'success';
		$res['onoff'] = $this->session->userdata('email_notice_onoff');
		
		echo json_encode($res);
						
	}
}
