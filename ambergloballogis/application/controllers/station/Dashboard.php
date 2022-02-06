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

		$this->load->library('excel');
		
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
		$maindata['parent_title']	= 'dashboard';
		$maindata['page_title']		= 'dashboard';
		$maindata['board']			= $this->trackingnumbers_model->get_board();
		
		$this->load->view('station/header', $maindata);
		$this->load->view('station/dashboard', $maindata);
		$this->load->view('station/footer');
	}

	public function output()
	{
		$report_type		= $this->input->get('report_type');
		$custom_ranges		= $this->input->get('custom_ranges');
		if(!isset($report_type) || $report_type == '' || !isset($custom_ranges) || $custom_ranges == ''){
			redirect('dashboard');
		}

		$custom_range = explode(' - ', $custom_ranges);
		$start_str = strtotime($custom_range[0]);
		$end_str = strtotime($custom_range[1]);
		$start = date_format(date_create($custom_range[0]), 'Y-m-d');
		$end = date_format(date_create($custom_range[1]), 'Y-m-d');
		$start_time = $start.' 00:00:00';
		$end_time = $end.' 23:59:59';

		if($report_type == 1){
			$result = $this->trackingnumbers_model->get_report1($start_time, $end_time, $this->level, $this->userid);
			$table_columns = array("Mainfest Date", "Tracking Number", "Docket#", "From Location", "To Location", "To Station", "Service Type", "Weight(kg)", "No. Of Items", "Sender Name", "Sender Company", "Receiver Name", "Receiver Company");
		}elseif($report_type == 2){
			$result = $this->trackingnumbers_model->get_report2($start_time, $end_time, $this->level, $this->userid);
			$table_columns = array("Mainfest Date", "Track Location", "Tracking Number", "Weight(kg)", "No. Of Items", "Service Type", "Last Track Note", "Last Track Activity", "Last Updated by", "Last Location");
		}else{
			$result = $this->trackingnumbers_model->get_report3($start_time, $end_time, $this->level, $this->userid);
			$table_columns = array("Mainfest Date", "Docket#", "From Station", "To Station", "Weight(kg)", "Service Type", "No. Of Items", "First Event", "First Event Date", "First Event Remark", "Tracking Number", "OFD Date", "Creator Name");
		}
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('worksheet');

		$column = 0;
		foreach($table_columns as $field)
		{
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$excel_row = 2;
		if($report_type == 1){
			foreach($result as $row) {
				if($row->parcel_type == 1){
					$parcel_type = 'Parcel';
				}elseif($row->parcel_type == 2){
					$parcel_type = 'Document';
				}else{
					$parcel_type = 'Heavy Shipment';
				}

				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->mainfest_date);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->tracking_number);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->docket);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->sender_city);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->receiver_city);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->receiver_station_name);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $parcel_type);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->weight);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->no_of_pieces);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->sender_name);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->sender_company);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->receiver_name);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->receiver_company);
				$excel_row++;
			}
			
			$filename='mainfest_report_'.date('d_m_Y').'.xls'; //save our workbook as this file name

		}elseif($report_type == 2){
			foreach($result as $row) {
				if($row->parcel_type == 1){
					$parcel_type = 'Parcel';
				}elseif($row->parcel_type == 2){
					$parcel_type = 'Document';
				}else{
					$parcel_type = 'Heavy Shipment';
				}

				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->mainfest_date);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->track_location);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->tracking_number);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->weight);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->no_of_pieces);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $parcel_type);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->remark);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->status_name);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->creator_name);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->location);
				$excel_row++;
			}
			
			$filename='arrived_at_hub_nonofdpod_report_'.date('d_m_Y').'.xls'; //save our workbook as this file name
		}else{
			foreach($result as $row) {
				if($row['parcel_type'] == 1){
					$parcel_type = 'Parcel';
				}elseif($row['parcel_type'] == 2){
					$parcel_type = 'Document';
				}else{
					$parcel_type = 'Heavy Shipment';
				}

				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['mainfest_date']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['docket']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['from_station']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['to_station']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['weight']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $parcel_type);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['no_of_pieces']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['first_event']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row['first_event_date']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row['first_event_remark']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row['tracking_number']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row['ofd_date']);
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row['creator_name']);
				$excel_row++;
			}
			
			$filename='shortlanded_inbound_non_arrivedhubvsOFD_'.date('d_m_Y').'.xls'; //save our workbook as this file name
		}
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
	
}
