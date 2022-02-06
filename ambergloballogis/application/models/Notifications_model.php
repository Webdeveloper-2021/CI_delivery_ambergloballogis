<?php

Class Notifications_model extends CI_Model {
	

	public function insert_notice_track($notice_data) {
		$res = $this->db->insert('notice_track', $notice_data);
		return $res;
	}
	
	public function get_notice_track($nCnt) {
		$db_query	= "SELECT * FROM notice_track ORDER BY id DESC LIMIT ".$nCnt;
		$query	= $this->db->query($db_query);
		$result = $query->result_array();
		return $result;
	}
	
	public function get_notice_track_ByUser($userid, $level, $nCnt) {
		$db_query	= "SELECT * FROM notice_track WHERE dest_userid=$userid AND dest_userlevel=$level ORDER BY id DESC LIMIT ".$nCnt;
		$query	= $this->db->query($db_query);
		$result = $query->result_array();
		return $result;
	}
	
	public function getNoticeByTitle($title) {
		$data = array(
			'read_status' => 1
		);
		$this->db->where('title', $title);
		$this->db->update('notice_track',$data);
		
		$this->db->select('*');
		$this->db->from('notice_track');
		$this->db->where('title', $title);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	
	public function getNoticeById($id) {
		$this->db->select('*');
		$this->db->from('notice_track');
		$this->db->where('id', $id);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		//$result = $query->row_array();
		$result = $query->result_array();
		return $result;
	}
	
	
	public function getNoticeByUser($userid, $level) {
		//SELECT * FROM notice_track WHERE dest_userid=2 AND dest_userlevel=0
		$this->db->select('*');
		$this->db->from('notice_track');
		$this->db->where('dest_userid', 	$userid);
		$this->db->where('dest_userlevel', 	$level);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		//$result = $query->row_array();
		$result = $query->result_array();
		return $result;
	}
	
	public function delete_notice_track($title) {
		$this->db->where(array('title' => $title));
		if($this->db->delete('notice_track')){
			return true;
		}else{
			return false;
		}

	}

}
?>