<?php
Class Trackingnumbers_model extends CI_Model {
	
	public function get_all_trackingnumbers($userid, $level) {
		if($level == '0'){
			// $db_query	= "SELECT E.* FROM (SELECT A.id, A.tracking_number, A.docket, B.status_id, B.date_stamp, B.remark, B.location, B.image_path, C.name status_name, C.precedence, D.name sender_station, H.name receiver_station FROM tracking_numbers A LEFT JOIN tracking_status B ON (A.id = B.tracking_number_id) LEFT JOIN status C ON (B.status_id = C.id) LEFT JOIN stations D ON (A.sender_station = D.id) LEFT JOIN stations H ON (A.receiver_station = H.id)) E INNER JOIN (SELECT A.tracking_number_id, MIN(B.precedence) precedence FROM tracking_status A LEFT JOIN status B ON (A.status_id = B.id) GROUP BY A.tracking_number_id) F ON (E.id = F.tracking_number_id AND E.precedence = F.precedence) ORDER BY E.date_stamp DESC";
			$db_query	= "SELECT E.* FROM (SELECT A.id, A.tracking_number, A.docket, B.id tracking_number_id, B.status_id, B.date_stamp, B.remark, B.location, B.image_path, C.name status_name, C.precedence, D.name sender_station, H.name receiver_station FROM tracking_numbers A LEFT JOIN tracking_status B ON (A.id = B.tracking_number_id) LEFT JOIN status C ON (B.status_id = C.id) LEFT JOIN stations D ON (A.sender_station = D.id) LEFT JOIN stations H ON (A.receiver_station = H.id)) E WHERE E.tracking_number_id IN (SELECT MAX(A.id) FROM tracking_status A INNER JOIN (SELECT tracking_number_id, MAX(date_stamp) date_stamp FROM tracking_status GROUP BY tracking_number_id) B ON (A.tracking_number_id = B.tracking_number_id AND A.date_stamp = B.date_stamp) GROUP BY A.tracking_number_id) ORDER BY E.date_stamp DESC, E.precedence ASC";
		}else{
			// $db_query	= "SELECT E.* FROM (SELECT A.id, A.tracking_number, A.docket, B.status_id, B.date_stamp, B.remark, B.location, B.image_path, C.name status_name, C.precedence, D.name sender_station, H.name receiver_station FROM tracking_numbers A LEFT JOIN tracking_status B ON (A.id = B.tracking_number_id) LEFT JOIN status C ON (B.status_id = C.id) LEFT JOIN stations D ON (A.sender_station = D.id) LEFT JOIN stations H ON (A.receiver_station = H.id) WHERE A.created_by = ".$userid." and A.creator_type = '".$level."') E INNER JOIN (SELECT A.tracking_number_id, MIN(B.precedence) precedence FROM tracking_status A LEFT JOIN status B ON (A.status_id = B.id) GROUP BY A.tracking_number_id) F ON (E.id = F.tracking_number_id AND E.precedence = F.precedence) ORDER BY E.date_stamp DESC";
			$db_query	= "SELECT E.* FROM (SELECT A.id, A.tracking_number, A.docket, B.id tracking_number_id, B.status_id, B.date_stamp, B.remark, B.location, B.image_path, C.name status_name, C.precedence, D.name sender_station, H.name receiver_station FROM tracking_numbers A LEFT JOIN tracking_status B ON (A.id = B.tracking_number_id) LEFT JOIN status C ON (B.status_id = C.id) LEFT JOIN stations D ON (A.sender_station = D.id) LEFT JOIN stations H ON (A.receiver_station = H.id) WHERE (A.sender_station = ".$userid." OR A.receiver_station = ".$userid.") OR (A.created_by = ".$userid." and A.creator_type = '".$level."')) E WHERE E.tracking_number_id IN (SELECT MAX(A.id) FROM tracking_status A INNER JOIN (SELECT tracking_number_id, MAX(date_stamp) date_stamp FROM tracking_status GROUP BY tracking_number_id) B ON (A.tracking_number_id = B.tracking_number_id AND A.date_stamp = B.date_stamp) GROUP BY A.tracking_number_id) ORDER BY E.date_stamp DESC, E.precedence ASC";
		}
		
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function insert_trackingnumber($tracking_data, $status_data) {
		$query	= $this->db->get_where('tracking_numbers', array('tracking_number' => $tracking_data['tracking_number']));
		if ($query->num_rows() == 0) {
			$this->db->insert('tracking_numbers', $tracking_data);
			$insertid = $this->db->insert_id();
			if ($this->db->affected_rows() > 0) {
				$status_data['tracking_number_id'] = $insertid;
				$query	= $this->db->get_where('tracking_status', array('tracking_number_id' => $insertid, 'status_id' => $status_data['status_id']));
				if ($query->num_rows() == 0) {
					$this->db->insert('tracking_status', $status_data);
					$insertid1 = $this->db->insert_id();
					if ($this->db->affected_rows() > 0) {
						$res['success'] = 1;
						$res['id'] = $insertid;
						$db_query	= "SELECT A.*, B.name status_name FROM (SELECT * FROM tracking_status WHERE id = ".$insertid1.") A LEFT JOIN status B ON (A.status_id = B.id)";
						$query	= $this->db->query($db_query);
						$result = $query->result();
						$res['date_stamp'] = date('d M Y', $result[0]->date_stamp);
						$res['image_path'] = $result[0]->image_path;
						$res['remark'] = $result[0]->remark;
						$res['status_name'] = $result[0]->status_name;
					}else{
						$res['success'] = 0;
					}
				}else{
					$res['success'] = 2;
				}
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function get_trackingnumber($id) {
		$query	= $this->db->get_where('tracking_numbers', array('id' => $id));
		if ($query->num_rows() == 0) {
			return false;
		}else{
			return $query->result();
		}
		
	}
	
	public function update_trackingnumber($id, $data) {
		$query	= $this->db->get_where('tracking_numbers', array('id !=' => $id, 'tracking_number' => $data['tracking_number']));
		if ($query->num_rows() == 0) {
			$this->db->where(array('id' => $id));
			if($this->db->update('tracking_numbers', $data)){
				$res['success'] = 1;
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function delete_trackingnumber($id) {
		$this->db->where(array('id' => $id));
		if($this->db->delete('tracking_numbers')){
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

	public function get_all_statuses() {
		$db_query	= "select * from status";
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function get_all_statuses_desc() {
		$db_query	= "select * from status order by id desc";
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function get_trackingdetail($id) {
		$db_query	= "SELECT A.*, B.name status_name, H.name creator_name FROM tracking_status A LEFT JOIN status B ON (A.status_id = B.id) LEFT JOIN (SELECT '0' creator_type, id, NAME FROM admins UNION SELECT '1' creator_type, id, NAME FROM stations UNION SELECT '2' creator_type, id, NAME FROM drivers) H ON (A.creator_type = H.creator_type AND A.created_by = H.id) WHERE A.tracking_number_id = ".$id." AND A.is_active = 1 ORDER BY A.date_stamp DESC, A.id DESC";
		$query	= $this->db->query($db_query);
		
		$result = $query->result();
		$data = array();
		foreach($result as $row){
			$data[] = array(
				'id' => $row->id,
				'image_path'	=> $row->image_path,
				'status_name'	=> $row->status_name,
				'location'		=> $row->location,
				'creator_name'	=> $row->creator_name,
				'date_stamp'	=> date('d M Y', $row->date_stamp),
				'remark'		=> $row->remark
			);
		}
		return $data;
	}

	public function get_trackingstatus($id) {
		$query	= $this->db->get_where('tracking_status', array('id' => $id));
		if ($query->num_rows() == 0) {
			return false;
		}else{
			$result = $query->result();
			$data = array();
			foreach($result as $row){
				$data[] = array(
					'id' => $row->id,
					'status_id' => $row->status_id,
					'date_stamp' => date('Y-m-d', $row->date_stamp),
					'remark' => $row->remark
				);
			}
			return $data;
		}
		
	}

	public function insert_trackingstatus($status_data, $creator_name) {
		$query	= $this->db->get_where('tracking_status', array('tracking_number_id' => $status_data['tracking_number_id'], 'status_id' => $status_data['status_id']));
		if ($query->num_rows() == 0) {
			$this->db->insert('tracking_status', $status_data);
			$insertid = $this->db->insert_id();
			if ($this->db->affected_rows() > 0) {
				$query	= $this->db->get_where('tracking_status', array('id' => $insertid));
				$result = $query->result();

				$res['success'] = 1;
				$res['id'] = $insertid;
				$res['image_path'] = $result[0]->image_path;
				$res['creator_name'] = $creator_name;
				$res['date_stamp'] = date('d M Y', $result[0]->date_stamp);
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function update_trackingstatus($id, $status_data) {
		$query	= $this->db->get_where('tracking_status', array('id !=' => $id, 'tracking_number_id' => $status_data['tracking_number_id'], 'status_id' => $status_data['status_id']));
		if ($query->num_rows() == 0) {
			$this->db->where(array('id' => $id));
			if($this->db->update('tracking_status', $status_data)){
				$res['success'] = 1;
				$res['date_stamp'] = date('d M Y', $status_data['date_stamp']);
				$query	= $this->db->get_where('tracking_status', array('id' => $id));
				$result = $query->result();
				$res['image_path'] = $result[0]->image_path;
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function delete_trackingstatus($id, $tracking_number_id) {
		$this->db->where(array('id' => $id));
		if($this->db->delete('tracking_status')){
			$db_query	= "SELECT A.*, B.name status_name FROM tracking_status A LEFT JOIN status B ON (A.status_id = B.id) WHERE A.tracking_number_id = ".$tracking_number_id." AND A.is_active = 1 ORDER BY A.status_id ASC";
			$query	= $this->db->query($db_query);
			$result = $query->result();
			$data = array();
			foreach($result as $row){
				$data[] = array(
					'id' => $row->id,
					'status_name' => $row->status_name,
					'image_path' => $row->image_path,
					'date_stamp' => date('d M Y', $row->date_stamp),
					'remark' => $row->remark
				);
			}
			return $data;
		}else{
			return false;
		}
	}

	public function get_last_status($tracking_number_id) {
		$db_query	= "SELECT * FROM tracking_status WHERE tracking_number_id = ".$tracking_number_id." ORDER BY status_id DESC LIMIT 1";
		$query	= $this->db->query($db_query);
		
		if ($query->num_rows() == 0) {
			return false;
		}else{
			return $query->result();
		}
	}
	
	public function insert_status($data) {
		$query	= $this->db->get_where('status', array('name' => $data['name']));
		if ($query->num_rows() == 0) {
			$this->db->insert('status', $data);
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

	public function delete_status($id) {
		$this->db->where(array('id' => $id));
		if($this->db->delete('status')){
			return true;
		}else{
			return false;
		}
	}

	public function update_status1($id, $data) {
		$query	= $this->db->get_where('status', array('id !=' => $id, 'name' => $data['name']));
		if ($query->num_rows() == 0) {
			$this->db->where(array('id' => $id));
			if($this->db->update('status', $data)){
				$res['success'] = 1;
			}else{
				$res['success'] = 0;
			}
		}else{
			$res['success'] = 2;
		}
		return $res;
	}

	public function update_precedence($ids, $precedences) {
		$data = array();
		for($i = 0; $i < count($ids); $i++) {
			$data[] = array(
				'id' => $ids[$i],
				'precedence' => $precedences[$i]
			);
		}

		if($this->db->update_batch('status', $data, 'id')){
			return true;
		}else{
			return false;
		}
	}

	public function import_excel1($senderinfo, $receiverinfo, $trackingnumberinfo, $statusinfo) {
		if(count($senderinfo) == 0){
			return false;
		}else{
			foreach($senderinfo as $key => $senderinfos) {
				$username = $senderinfos['username'];
				$query = $this->db->get_where('customers', array('username' => $username));
				if($query->num_rows() > 0){
					$result = $query->result();
					$trackingnumberinfo[$key]['sender_id'] = $result[0]->id;
				}else{
					$senderinfos['password'] 		= md5($senderinfos['password']);
					$senderinfos['creator_type']	= $this->level;
					$senderinfos['created_by']		= $this->userid;
					$senderinfos['created_at']		= $this->currenttime;
					$this->db->insert('customers', $senderinfos);
					$insertid = $this->db->insert_id();
					$trackingnumberinfo[$key]['sender_id'] = $insertid;
				}
			}

			foreach($receiverinfo as $key => $receiverinfos) {
				$username = $receiverinfos['username'];
				$query = $this->db->get_where('customers', array('username' => $username));
				if($query->num_rows() > 0){
					$result = $query->result();
					$trackingnumberinfo[$key]['receiver_id'] = $result[0]->id;
				}else{
					$receiverinfos['password'] 		= md5($receiverinfos['password']);
					$receiverinfos['creator_type']	= $this->level;
					$receiverinfos['created_by']	= $this->userid;
					$receiverinfos['created_at']	= $this->currenttime;
					$this->db->insert('customers', $receiverinfos);
					$insertid = $this->db->insert_id();
					$trackingnumberinfo[$key]['receiver_id'] = $insertid;
				}
			}

			foreach($trackingnumberinfo as $key => $trackingnumberinfos) {
				$tracking_number = $trackingnumberinfos['tracking_number'];
				$query = $this->db->get_where('tracking_numbers', array('tracking_number' => $tracking_number));
				if($query->num_rows() > 0){
					$result = $query->result();
					$statusinfo[$key]['tracking_number_id'] = $result[0]->id;
				}else{
					$trackingnumberinfos['creator_type']= $this->level;
					$trackingnumberinfos['created_by']	= $this->userid;
					$trackingnumberinfos['created_at']	= $this->currenttime;
					$this->db->insert('tracking_numbers', $trackingnumberinfos);
					$insertid = $this->db->insert_id();
					$statusinfo[$key]['tracking_number_id'] = $insertid;
				}
			}

			foreach($statusinfo as $key => $statusinfos) {
				$tracking_number_id = $statusinfos['tracking_number_id'];
				$status_id = $statusinfos['status_id'];
				$query = $this->db->get_where('tracking_status', array('tracking_number_id' => $tracking_number_id, 'status_id' => $status_id));
				if($query->num_rows() == 0){
					$statusinfos['creator_type']= $this->level;
					$statusinfos['created_by']	= $this->userid;
					$statusinfos['created_at']	= $this->currenttime;
					$this->db->insert('tracking_status', $statusinfos);
				}
			}

			return true;
		}


	}

	public function import_excel($statusinfo) {

		foreach($statusinfo as $key => $statusinfos) {
			$tracking_number = $statusinfos['tracking_number'];
			$status_id = $statusinfos['status_id'];
			$query = $this->db->get_where('tracking_numbers', array('tracking_number' => $tracking_number));
			if($query->num_rows() > 0){
				$result = $query->result();
				$statusinfos['tracking_number_id'] = $result[0]->id;
				unset($statusinfos['tracking_number']);
				$tracking_number_id = $result[0]->id;
				$query = $this->db->get_where('tracking_status', array('tracking_number_id' => $tracking_number_id, 'status_id' => $status_id));
				if($query->num_rows() > 0){
					$result = $query->result();
					$id = $result[0]->id;
					$this->db->where(array('id' => $id));
					$this->db->update('tracking_status', $statusinfos);
				}else{
					$this->db->insert('tracking_status', $statusinfos);
				}
			}else{
				unset($statusinfo[$key]);
			}
		}

		if(count($statusinfo) == 0){
			return false;
		}else{
			return true;
		}
		
	}

	public function get_all_trackingnumbers_bycustomer($id) {
		$db_query	= "SELECT E.* FROM (SELECT A.id, A.tracking_number, A.docket, B.status_id, B.date_stamp, B.remark, B.location, B.image_path, C.name status_name, C.precedence, D.name sender_station, H.name receiver_station FROM (SELECT * FROM tracking_numbers WHERE sender_id = ".$id." OR receiver_id = ".$id.") A LEFT JOIN tracking_status B ON (A.id = B.tracking_number_id) LEFT JOIN status C ON (B.status_id = C.id) LEFT JOIN stations D ON (A.sender_station = D.id) LEFT JOIN stations H ON (A.receiver_station = H.id)) E INNER JOIN (SELECT A.tracking_number_id, MIN(B.precedence) precedence FROM tracking_status A LEFT JOIN status B ON (A.status_id = B.id) GROUP BY A.tracking_number_id) F ON (E.id = F.tracking_number_id AND E.precedence = F.precedence) ORDER BY E.date_stamp DESC";
		
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function check_trackingnumber($tracking_number) {
		$query	= $this->db->get_where('tracking_numbers', array('tracking_number' => $tracking_number));
		$result = $query->result();
		if ($query->num_rows() == 1) {
			$tracking_number_id = $result[0]->id;
			$db_query	= "SELECT * FROM tracking_status A LEFT JOIN status B ON (A.status_id = B.id) WHERE A.tracking_number_id = (SELECT id FROM tracking_numbers WHERE tracking_number = '".$tracking_number."') AND B.name = 'Delivered'";
			$query	= $this->db->query($db_query);
			
			if ($query->num_rows() == 0) {
				$db_query	= "SELECT * FROM status WHERE id NOT IN (SELECT status_id FROM tracking_status WHERE tracking_number_id = (SELECT id FROM tracking_numbers WHERE tracking_number = '".$tracking_number."')) ORDER BY precedence DESC";
				$query	= $this->db->query($db_query);
				$result = $query->result();
				$data = [];
				foreach($result as $row) {
					$data[] = array(
						'id'	=> $row->id,
						'name'	=> $row->name
					);
				}
				$res['success'] = 1;
				$res['data'] = $data;
				$res['tracking_number_id'] = $tracking_number_id;
			}else{
				$res['success'] = 2;
			}
		}else{
			$res['success'] = 0;
		}

		return $res;
	}

	public function get_trackingdetail_bynumber($tracking_number) {
		$db_query	= "SELECT A.*, B.name status_name, B.precedence FROM tracking_status A LEFT JOIN status B ON (A.status_id = B.id) WHERE A.tracking_number_id = (SELECT id FROM tracking_numbers WHERE tracking_number = '".$tracking_number."') AND A.is_active = 1 ORDER BY A.date_stamp DESC, A.id DESC";
		$query	= $this->db->query($db_query);
		
		$result = $query->result();
		$data = array();
		foreach($result as $row){
			$data[] = array(
				'id' => $row->id,
				'image_path' => $row->image_path,
				'status_name' => $row->status_name,
				'location' => $row->location,
				'precedence' => $row->precedence,
				'date_stamp' => date('d M Y', $row->date_stamp),
				'remark' => $row->remark
			);
		}
		return $data;
	}

	public function get_tracking_number_id($tracking_number) {
		$query	= $this->db->get_where('tracking_numbers', array('tracking_number' => $tracking_number));
		$result = $query->result();
		if ($query->num_rows() == 0) {
			return false;
		}else{
			return $result[0]->id;
		}
	}

	public function get_report1($start_time, $end_time, $creator_type, $created_by) {
		if($creator_type == '0') {
			$db_query	= "SELECT A.created_at mainfest_date, A.tracking_number, A.docket, B.city sender_city, C.city receiver_city, D.name receiver_station_name, A.parcel_type, A.weight, A.no_of_pieces, B.name sender_name, B.company_name sender_company, C.name receiver_name, C.company_name receiver_company FROM (SELECT * FROM tracking_numbers WHERE created_at BETWEEN '".$start_time."' AND '".$end_time."') A LEFT JOIN customers B ON (A.sender_id = B.id) LEFT JOIN customers C ON (A.receiver_id = C.id) LEFT JOIN stations D ON (A.receiver_station = D.id) ORDER BY A.created_at ASC, B.city ASC";
		}else{
			$db_query	= "SELECT A.created_at mainfest_date, A.tracking_number, A.docket, B.city sender_city, C.city receiver_city, D.name receiver_station_name, A.parcel_type, A.weight, A.no_of_pieces, B.name sender_name, B.company_name sender_company, C.name receiver_name, C.company_name receiver_company FROM (SELECT * FROM tracking_numbers WHERE created_at BETWEEN '".$start_time."' AND '".$end_time."' AND ((sender_station = ".$created_by." OR receiver_station = ".$created_by.") OR (creator_type = '".$creator_type."' AND created_by = ".$created_by."))) A LEFT JOIN customers B ON (A.sender_id = B.id) LEFT JOIN customers C ON (A.receiver_id = C.id) LEFT JOIN stations D ON (A.receiver_station = D.id) ORDER BY A.created_at ASC, B.city ASC";
		}
		
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function get_report2($start_time, $end_time, $creator_type, $created_by) {
		if($creator_type == '0') {
			$db_query	= "SELECT E.* FROM (SELECT A.created_at mainfest_date, A.tracking_number, concat(D.city, ' - ', D.country) track_location, A.weight, A.no_of_pieces, A.parcel_type, B.id tracking_number_id, B.date_stamp, B.remark, B.location, C.name status_name, H.name creator_name FROM (SELECT * FROM tracking_numbers WHERE created_at BETWEEN '".$start_time."' AND '".$end_time."') A LEFT JOIN tracking_status B ON (A.id = B.tracking_number_id) LEFT JOIN status C ON (B.status_id = C.id) LEFT JOIN customers D ON (A.sender_id = D.id) LEFT JOIN (SELECT '0' creator_type, id, name FROM admins UNION SELECT '1' creator_type, id, name FROM stations UNION SELECT '2' creator_type, id, name FROM drivers) H ON (B.creator_type = H.creator_type AND B.created_by = H.id)) E WHERE E.tracking_number_id IN (SELECT MAX(A.id) FROM tracking_status A INNER JOIN (SELECT tracking_number_id, MAX(date_stamp) date_stamp FROM tracking_status GROUP BY tracking_number_id) B ON (A.tracking_number_id = B.tracking_number_id AND A.date_stamp = B.date_stamp) GROUP BY A.tracking_number_id) AND E.status_name != 'Delivered' ORDER BY E.mainfest_date ASC, E.track_location ASC";
		}else{
			$db_query	= "SELECT E.* FROM (SELECT A.created_at mainfest_date, A.tracking_number, concat(D.city, ' - ', D.country) track_location, A.weight, A.no_of_pieces, A.parcel_type, B.id tracking_number_id, B.date_stamp, B.remark, B.location, C.name status_name, H.name creator_name FROM (SELECT * FROM tracking_numbers WHERE created_at BETWEEN '".$start_time."' AND '".$end_time."' AND ((sender_station = ".$created_by." OR receiver_station = ".$created_by.") OR (creator_type = '".$creator_type."' AND created_by = ".$created_by."))) A LEFT JOIN tracking_status B ON (A.id = B.tracking_number_id) LEFT JOIN status C ON (B.status_id = C.id) LEFT JOIN customers D ON (A.sender_id = D.id) LEFT JOIN (SELECT '0' creator_type, id, name FROM admins UNION SELECT '1' creator_type, id, name FROM stations UNION SELECT '2' creator_type, id, name FROM drivers) H ON (B.creator_type = H.creator_type AND B.created_by = H.id)) E WHERE E.tracking_number_id IN (SELECT MAX(A.id) FROM tracking_status A INNER JOIN (SELECT tracking_number_id, MAX(date_stamp) date_stamp FROM tracking_status GROUP BY tracking_number_id) B ON (A.tracking_number_id = B.tracking_number_id AND A.date_stamp = B.date_stamp) GROUP BY A.tracking_number_id) AND E.status_name != 'Delivered' ORDER BY E.mainfest_date ASC, E.track_location ASC";
		}
		
		$query	= $this->db->query($db_query);
		
		return $query->result();
	}

	public function get_report3($start_time, $end_time, $creator_type, $created_by) {
		if($creator_type == '0') {
			$db_query	= "SELECT A.id, A.created_at mainfest_date, A.tracking_number, A.docket, A.weight, A.no_of_pieces, A.parcel_type, D.name from_station, H.name to_station FROM (SELECT * FROM tracking_numbers WHERE created_at BETWEEN '".$start_time."' AND '".$end_time."') A LEFT JOIN stations D ON (A.sender_station = D.id) LEFT JOIN stations H ON (A.receiver_station = H.id) ORDER BY A.created_at ASC, D.name ASC";
		}else{
			$db_query	= "SELECT A.id, A.created_at mainfest_date, A.tracking_number, A.docket, A.weight, A.no_of_pieces, A.parcel_type, D.name from_station, H.name to_station FROM (SELECT * FROM tracking_numbers WHERE created_at BETWEEN '".$start_time."' AND '".$end_time."' AND ((sender_station = ".$created_by." OR receiver_station = ".$created_by.") OR (creator_type = '".$creator_type."' AND created_by = ".$created_by."))) A LEFT JOIN stations D ON (A.sender_station = D.id) LEFT JOIN stations H ON (A.receiver_station = H.id) ORDER BY A.created_at ASC, D.name ASC";
		}
		
		$query	= $this->db->query($db_query);
		$result = $query->result();
		$data = array();
		foreach($result as $row) {
			$tracking_number_id = $row->id;
			$db_query	= "SELECT A.*, B.name status_name FROM (SELECT * FROM tracking_status WHERE tracking_number_id = ".$tracking_number_id.") A LEFT JOIN status B ON (A.status_id = B.id) ORDER BY A.date_stamp ASC, A.id ASC LIMIT 1";
			$query	= $this->db->query($db_query);
			$result_first = $query->result();

			$db_query	= "SELECT A.*, B.name status_name, C.name creator_name FROM (SELECT * FROM tracking_status WHERE tracking_number_id = ".$tracking_number_id.") A LEFT JOIN status B ON (A.status_id = B.id) LEFT JOIN (SELECT '0' creator_type, id, name FROM admins UNION SELECT '1' creator_type, id, name FROM stations UNION SELECT '2' creator_type, id, name FROM drivers) C ON (A.creator_type = C.creator_type AND A.created_by = C.id) ORDER BY A.date_stamp DESC, A.id DESC LIMIT 1";
			$query	= $this->db->query($db_query);
			$result_last = $query->result();

			$data[] = array(
				'mainfest_date'		=> $row->mainfest_date,
				'docket'			=> $row->docket,
				'from_station'		=> $row->from_station,
				'to_station'		=> $row->to_station,
				'weight'			=> $row->weight,
				'no_of_pieces'		=> $row->no_of_pieces,
				'parcel_type'		=> $row->parcel_type,
				'tracking_number'	=> $row->tracking_number,
				'first_event'		=> $result_first[0]->status_name,
				'first_event_remark'=> $result_first[0]->remark,
				'first_event_date'	=> date('d M Y', $result_first[0]->date_stamp),
				'ofd_date'			=> date('d M Y', $result_last[0]->date_stamp),
				'creator_name'		=> $result_last[0]->creator_name
			);

		}
		return $data;
	}

	public function get_board() {
		$db_query	= "SELECT * FROM board WHERE id = 1";
		$query	= $this->db->query($db_query);
		$result = $query->result();

		return $result[0]->board_description;
	}

	public function update_board($data) {
		$this->db->where(array('id' => 1));
		if($this->db->update('board', $data)){
			$res['success'] = 1;
		}else{
			$res['success'] = 0;
		}

		return $res;
	}
}
?>