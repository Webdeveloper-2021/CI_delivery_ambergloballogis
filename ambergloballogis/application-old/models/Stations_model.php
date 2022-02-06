<?php
Class Stations_model extends CI_Model {
	
	public function get_all_stations($userid, $level) {
		if($level == '0'){
			$db_query	= "select * from stations";
		}else{
			$db_query	= "select * from stations where created_by = ".$userid." and creator_type = '".$level."'";
		}
		
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function insert_station($data) {
		$db_query	= "select * from (select username from admins union select username from stations union select username from drivers union select username from customers) A where A.username = ?";
		$query	= $this->db->query($db_query, array($data['username']));
		
		if ($query->num_rows() == 0) {
			$data['password'] = md5($data['password']);
			$this->db->insert('stations', $data);
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

	public function get_station($id) {
		$query	= $this->db->get_where('stations', array('id' => $id));
		if ($query->num_rows() == 0) {
			return false;
		}else{
			return $query->result();
		}
		
	}
	
	public function update_station($id, $data) {
		$db_query	= "SELECT * FROM (SELECT id, username FROM admins UNION SELECT id, username FROM stations UNION SELECT id, username FROM drivers UNION SELECT id, username FROM customers) A WHERE A.id != ".$id." AND A.username = '".$data['username']."'";
		$query	= $this->db->query($db_query);

		if ($query->num_rows() == 0) {
			if($data['password'] != '**********'){
				$data['password'] = md5($data['password']);
			}else{
				unset($data['password']);
			}
			$this->db->where(array('id' => $id));
			if($this->db->update('stations', $data)){
				$res['success'] = 1;
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function delete_station($id) {
		$this->db->where(array('id' => $id));
		if($this->db->delete('stations')){
			return true;
		}else{
			return false;
		}
	}

	public function get_all_prefixsets() {
		$db_query	= "SELECT A.id, B.name prefix_name, A.name station_name FROM stations A LEFT JOIN station_prefix B ON (A.id = B.station_id)";
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function get_prefix_stations() {
		$db_query	= "SELECT id, name FROM stations WHERE id NOT IN (SELECT station_id FROM station_prefix WHERE name IS NOT NULL)";
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function insert_prefixset($data) {
		$query	= $this->db->get_where('station_prefix', array('name' => $data['name']));
		if ($query->num_rows() == 0) {
			$this->db->insert('station_prefix', $data);
			if ($this->db->affected_rows() > 0) {
				$res['success'] = 1;
				$db_query	= "SELECT A.id, B.name prefix_name, A.name station_name FROM stations A LEFT JOIN station_prefix B ON (A.id = B.station_id)";
				$query	= $this->db->query($db_query);
				$res['data'] = $query->result();
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function delete_prefixset($id) {
		$this->db->where(array('station_id' => $id));
		if($this->db->delete('station_prefix')){
			return true;
		}else{
			return false;
		}
	}

	public function get_all_stations1() {
		$db_query	= "select * from stations";
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}
	
}
?>