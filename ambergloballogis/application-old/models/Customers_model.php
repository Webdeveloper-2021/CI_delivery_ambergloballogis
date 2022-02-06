<?php
Class Customers_model extends CI_Model {
	
	public function get_all_customers($userid, $level) {
		if($level == '0'){
			$db_query	= "select * from customers";
// 			$db_query	= "select * from customers limit 1000";
		}else{
			$db_query	= "select * from customers where created_by = ".$userid." and creator_type = '".$level."'";
// 			$db_query	= "select * from customers where created_by = ".$userid." and creator_type = '".$level."' limit 1000";
		}
		
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}
	
	
	public function get_customers_limit($userid, $level) {
		if($level == '0'){
			$db_query	= "select * from customers ORDER BY id DESC limit 1000";
		}else{
			$db_query	= "select * from customers where created_by = ".$userid." and creator_type = '".$level."' ORDER BY id DESC limit 1000";
		}
		$query	= $this->db->query($db_query);
		return $query->result();
	}
	
	public function get_search_data($userid, $level, $search) {

		if($level == '0'){
			//$db_query	= "select * from customers";
			$db_query	= "select * from customers ";
			//$db_query	.=" WHERE username LIKE '%$search%' OR email LIKE '%$search%' OR contact_number LIKE '%$search%' OR country = '$search' OR state='$search' OR city='$search' OR post_code='$search' OR address LIKE '%$search%'";
			$db_query	.=" WHERE username LIKE '%$search%' OR email LIKE '%$search%' OR contact_number LIKE '%$search%' OR address LIKE '%$search%' limit 1000 ";
		}else{
			$db_query	= "select * from customers where created_by = ".$userid." and creator_type = '".$level."'";
			//$db_query	.=" AND (username LIKE '%$search%' OR email LIKE '%$search%' OR contact_number LIKE '%$search%' OR country = '$search' OR state='$search' OR city='$search' OR post_code='$search' OR address LIKE '%$search%')";
			$db_query	.=" AND (username LIKE '%$search%' OR email LIKE '%$search%' OR contact_number LIKE '%$search%' OR address LIKE '%$search%') limit 1000";
		}
		$query	= $this->db->query($db_query);
		return $query->result();
	}



	public function insert_customer($data) {
		$db_query	= "select * from (select username from admins union select username from stations union select username from drivers union select username from customers) A where A.username = ?";
		$query	= $this->db->query($db_query, array($data['username']));

		if ($query->num_rows() == 0) {
			$data['password'] = md5($data['password']);
			$this->db->insert('customers', $data);
			$insertid = $this->db->insert_id();
			if ($this->db->affected_rows() > 0) {
				$res['success'] = 1;
				$res['id'] = $insertid;
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function get_customer($id) {
		$query	= $this->db->get_where('customers', array('id' => $id));
		if ($query->num_rows() == 0) {
			return false;
		}else{
			return $query->result();
		}
		
	}
	
	public function update_customer($id, $data) {
		$db_query	= "SELECT * FROM (SELECT id, username FROM admins UNION SELECT id, username FROM stations UNION SELECT id, username FROM drivers UNION SELECT id, username FROM customers) A WHERE A.id != ".$id." AND A.username = '".$data['username']."'";
		$query	= $this->db->query($db_query);
		
		if ($query->num_rows() == 0) {
			if($data['password'] != '**********'){
				$data['password'] = md5($data['password']);
			}else{
				unset($data['password']);
			}
			$this->db->where(array('id' => $id));
			if($this->db->update('customers', $data)){
				$res['success'] = 1;
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function delete_customer($id) {
		$this->db->where(array('id' => $id));
		if($this->db->delete('customers')){
			return true;
		}else{
			return false;
		}
	}
	
}
?>