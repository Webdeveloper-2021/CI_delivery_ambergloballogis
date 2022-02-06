<?php
Class Drivers_model extends CI_Model {
	
	public function get_all_drivers($userid, $level) {
		if($level == '0'){
			$db_query	= "select * from drivers";
		}else{
			$db_query	= "select * from drivers where created_by = ".$userid." and creator_type = '".$level."'";
		}

		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function insert_driver($data) {
		$db_query	= "select * from (select username from admins union select username from stations union select username from drivers union select username from customers) A where A.username = ?";
		$query	= $this->db->query($db_query, array($data['username']));

		if ($query->num_rows() == 0) {
			$data['password'] = md5($data['password']);
			$this->db->insert('drivers', $data);
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

	public function get_driver($id) {
		$query	= $this->db->get_where('drivers', array('id' => $id));
		if ($query->num_rows() == 0) {
			return false;
		}else{
			return $query->result();
		}
		
	}
	
	public function update_driver($id, $data) {
		$db_query	= "SELECT * FROM (SELECT id, username FROM admins UNION SELECT id, username FROM stations UNION SELECT id, username FROM drivers UNION SELECT id, username FROM customers) A WHERE A.id != ".$id." AND A.username = '".$data['username']."'";
		$query	= $this->db->query($db_query);
		
		if ($query->num_rows() == 0) {
			if($data['password'] != '**********'){
				$data['password'] = md5($data['password']);
			}else{
				unset($data['password']);
			}
			$this->db->where(array('id' => $id));
			if($this->db->update('drivers', $data)){
				$res['success'] = 1;
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function delete_driver($id) {
		$this->db->where(array('id' => $id));
		if($this->db->delete('drivers')){
			return true;
		}else{
			return false;
		}
	}

	public function get_all_deliveryrequests() {
		$db_query	= "SELECT A.*, B.tracking_number, C.name driver_name, D.name status_name FROM driver_requests A LEFT JOIN tracking_numbers B ON (A.tracking_number_id = B.id) LEFT JOIN drivers C ON (A.driver_id = C.id) LEFT JOIN status D ON (A.status_id = D.id)";
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function update_status($id, $status) {
		if($status == 'confirm'){
			$data['deliver_status'] = 2;
		}else{
			$data['deliver_status'] = 3;
		}

		$this->db->where(array('id' => $id));
		if($this->db->update('driver_requests', $data)){
			return true;
		}else{
			return false;
		}
	}

	public function get_deliveryrequest($id) {
		$query	= $this->db->get_where('driver_requests', array('id' => $id));
		if ($query->num_rows() == 0) {
			return false;
		}else{
			$result = $query->result();
			return $result[0]->image_path;
		}
		
	}

	public function login_driver($username, $password) {
		$query	= $this->db->get_where('drivers', array('username' => $username));
		$data = $query->result();
		if ($query->num_rows() > 0) {
			if($data[0]->password == md5($password)){
				$res['status_code']	= 200;
				$res['message']		= "Successful Login.";
				$res['data']		= $data[0];
			}else{
				$res['status_code']	= 201;
				$res['message']		= "Username or Password Error.";
			}
		}else{
			$res['status_code']	= 201;
			$res['message']		= "The user does not exist.";
		}
		
		return $res;
	}

	public function check_tracking($tracking_number) {
		$query	= $this->db->get_where('tracking_numbers', array('tracking_number' => $tracking_number));
		if ($query->num_rows() == 1) {
			$result = $query->result();
			$tracking_number_id = $result[0]->id;

			$db_query	= "select * from tracking_status A left join status B on (A.status_id = B.id) where A.tracking_number_id = ".$tracking_number_id." and B.name = 'Delivered'";
			$query	= $this->db->query($db_query);
			if ($query->num_rows() == 1) {
				$res['status_code']	= 201;
				$res['message']		= "Product already delivered!";
			}else{
				$db_query	= "select * from status where id = (select status_id from tracking_status where tracking_number_id = ".$tracking_number_id." order by created_at desc, id desc limit 1)";
				$query	= $this->db->query($db_query);
				$result = $query->result();

				$data = new stdClass();
				$data->tracking_number	= $tracking_number;
				$data->status_id		= $result[0]->id;
				$data->status_name		= $result[0]->name;

				$res['status_code']	= 200;
				$res['message']		= "Successful";
				$res['data']		= $data;
			}
		}else{
			$res['status_code']	= 201;
			$res['message']		= "Invalid Tracking Number.";
		}

		return $res;
	}

	public function get_all_statuses() {
		$db_query	= "select * from status";
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}
	
	public function get_tracking_number_id($tracking_number) {
		$query	= $this->db->get_where('tracking_numbers', array('tracking_number' => $tracking_number));
		$result = $query->result();
		$tracking_number_id = $result[0]->id;

		return $tracking_number_id;
	}

	public function insert_delivery_status($status_data, $delivery_data) {
		$query	= $this->db->get_where('tracking_status', array('tracking_number_id' => $status_data['tracking_number_id'], 'status_id' => $status_data['status_id']));
		$result = $query->result();
		if ($query->num_rows() > 0) {
			$res['status_code']	= 201;
			$res['message']		= "The tracking status is already exist.";
		}else{
			$this->db->insert('tracking_status', $status_data);
			if ($this->db->affected_rows() > 0) {
				$this->db->insert('driver_requests', $delivery_data);
				if ($this->db->affected_rows() > 0) {
					$res['status_code']	= 200;
					$res['message']		= "Successful";
				}else{
					$res['status_code']	= 201;
					$res['message']		= "Failed Upload.";
				}
			}else{
				$res['status_code']	= 201;
				$res['message']		= "Failed Upload.";
			}
		}

		return $res;
	}
}
?>