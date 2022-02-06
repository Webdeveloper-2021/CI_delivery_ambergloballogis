<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadexcel extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if(!isset($this->session->userdata['amber_in'])){
			redirect('signin');
		}
		$this->load->model('trackingnumbers_model');
		$this->load->library('excel');

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
		$maindata['parent_title']	= 'trackingnumbers';
		$maindata['page_title']		= 'uploadexcel';
		
		$this->load->view('station/header', $maindata);
		$this->load->view('admin/uploadexcel', $maindata);
		$this->load->view('station/footer', $maindata);
	}
	
	function import1()
	{
		if(isset($_FILES["file1"]["name"]))
		{
			$path = $_FILES["file1"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$senderinfo = array();
			$receiverinfo = array();
			$trackingnumberinfo = array();
			$statusinfo = array();

			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$tracking_number		= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$docket					= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$sender_station			= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$receiver_station		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$status_id				= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$sender_username		= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$sender_email			= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$sender_password		= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$sender_name			= $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$sender_contact_number	= $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$sender_company			= $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$sender_country			= $worksheet->getCellByColumnAndRow(11, $row)->getValue();
					$sender_state			= $worksheet->getCellByColumnAndRow(12, $row)->getValue();
					$sender_city			= $worksheet->getCellByColumnAndRow(13, $row)->getValue();
					$sender_postcode		= $worksheet->getCellByColumnAndRow(14, $row)->getValue();
					$sender_address			= $worksheet->getCellByColumnAndRow(15, $row)->getValue();
					$receiver_username		= $worksheet->getCellByColumnAndRow(16, $row)->getValue();
					$receiver_email			= $worksheet->getCellByColumnAndRow(17, $row)->getValue();
					$receiver_password		= $worksheet->getCellByColumnAndRow(18, $row)->getValue();
					$receiver_name			= $worksheet->getCellByColumnAndRow(19, $row)->getValue();
					$receiver_contact_number= $worksheet->getCellByColumnAndRow(20, $row)->getValue();
					$receiver_company		= $worksheet->getCellByColumnAndRow(21, $row)->getValue();
					$receiver_country		= $worksheet->getCellByColumnAndRow(22, $row)->getValue();
					$receiver_state			= $worksheet->getCellByColumnAndRow(23, $row)->getValue();
					$receiver_city			= $worksheet->getCellByColumnAndRow(24, $row)->getValue();
					$receiver_postcode		= $worksheet->getCellByColumnAndRow(25, $row)->getValue();
					$receiver_address		= $worksheet->getCellByColumnAndRow(26, $row)->getValue();
					$size					= $worksheet->getCellByColumnAndRow(27, $row)->getValue();
					$weight					= $worksheet->getCellByColumnAndRow(28, $row)->getValue();
					$special_notes			= $worksheet->getCellByColumnAndRow(29, $row)->getValue();
					$content_description	= $worksheet->getCellByColumnAndRow(30, $row)->getValue();
					$location				= $worksheet->getCellByColumnAndRow(31, $row)->getValue();
					$parcel_type			= $worksheet->getCellByColumnAndRow(32, $row)->getValue();
					$date_stamp				= $worksheet->getCellByColumnAndRow(33, $row)->getValue();
					$remark					= $worksheet->getCellByColumnAndRow(34, $row)->getValue();
					$no_of_pieces			= $worksheet->getCellByColumnAndRow(35, $row)->getValue();

					$senderinfo[] = array(
						'username'		=>	$sender_username,
						'email'			=>	$sender_email,
						'password'		=>	$sender_password,
						'name'			=>	$sender_name,
						'contact_number'=>	$sender_contact_number,
						'company_name'	=>	$sender_company,
						'country'		=>	$sender_country,
						'state'			=>	$sender_state,
						'city'			=>	$sender_city,
						'post_code'		=>	$sender_postcode,
						'address'		=>	$sender_address
					);

					$receiverinfo[] = array(
						'username'		=>	$receiver_username,
						'email'			=>	$receiver_email,
						'password'		=>	$receiver_password,
						'name'			=>	$receiver_name,
						'contact_number'=>	$receiver_contact_number,
						'company_name'	=>	$receiver_company,
						'country'		=>	$receiver_country,
						'state'			=>	$receiver_state,
						'city'			=>	$receiver_city,
						'post_code'		=>	$receiver_postcode,
						'address'		=>	$receiver_address
					);

					$trackingnumberinfo[] = array(
						'tracking_number'		=>	$tracking_number,
						'docket'				=>	$docket,
						'size'					=>	$size,
						'weight'				=>	$weight,
						'sender_station'		=>	$sender_station,
						'receiver_station'		=>	$receiver_station,
						'no_of_pieces'			=>	$no_of_pieces,
						'content_description'	=>	$content_description,
						'special_notes'			=>	$special_notes,
						'parcel_type'			=>	$parcel_type
					);

					$statusinfo[] = array(
						'status_id'		=>	$status_id,
						'date_stamp'	=>	$this->fromExcelToLinux($date_stamp),
						'location'		=>	$location,
						'remark'		=>	$remark
					);
				}
			}
			$res	= $this->trackingnumbers_model->import_excel1($senderinfo, $receiverinfo, $trackingnumberinfo, $statusinfo);
			echo json_encode($res);
		}
	}

	function import()
	{
		$currenttime = $this->currenttime;
		if(isset($_FILES["file"]["name"]))
		{
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++)
				{
					$tracking_number	= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$status_id			= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$date_stamp			= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$location			= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$remark				= $worksheet->getCellByColumnAndRow(4, $row)->getValue();

					$statusinfo[] = array(
						'tracking_number'	=> $tracking_number,
						'status_id'			=> $status_id,
						'date_stamp'		=> $this->fromExcelToLinux($date_stamp),
						'remark'			=> $remark,
						'location'			=> $location,
						'created_at'		=> $currenttime,
						'creator_type'		=> $this->level,
						'created_by'		=> $this->userid
					);
				}
			}
			$res	= $this->trackingnumbers_model->import_excel($statusinfo);
			echo json_encode($res);
		}	
	}

	function fromExcelToLinux($excel_time) {
		$date1 = ($excel_time-25569)*86400;
		$date2 = date('Y-m-d', $date1);
		return strtotime($date2);
	}
}
