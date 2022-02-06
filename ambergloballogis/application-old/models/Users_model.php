<?php
Class Users_model extends CI_Model {

	public function register($data, $account) {
		if($account == 'freelancer'){
			$tbl	= 'freelancers';
		}elseif($account == 'owner'){
			$tbl	= 'owners';
		}
		$condition = "useremail = '".$data['useremail']."'";
		$this->db->select('useremail');
		$this->db->from('owners');
		$this->db->where($condition);
		$query1 = $this->db->get_compiled_select();
		
		$this->db->select('useremail');
		$this->db->from('freelancers');
		$this->db->where($condition);
		$query2 = $this->db->get_compiled_select();
		
		$query = $this->db->query($query1 . ' UNION ' . $query2);
		if ($query->num_rows() == 0) {
			$check_city	= $this->check_city($data);
			if($check_city){
				if($account == 'owner'){
					if($data['token'] != ''){
						$query	= $this->db->get_where('owners', array('invitationcode' => $data['token']), 1);
						$result	= $query->result();
						if ($query->num_rows() == 1) {
							$data['referid']	= $result[0]->id;
						}
					}
					unset($data['token']);
				}
				$options = [
					'cost' => 12
				];
				$data['userpwd'] = password_hash($data['userpwd'], PASSWORD_BCRYPT, $options);
				$this->db->insert($tbl, $data);
				$insertid = $this->db->insert_id();
				if ($this->db->affected_rows() > 0) {
					$res['msgid']	= 1;
					$res['id']		= $insertid;
				}else{
					$res['msgid']	= 0;
				}
			}else{
				$res['msgid']	= 3;
			}
		} else {
			$res['msgid']	= 2;
		}
		
		return $res;
	}

	public function login($data) {
		
		$db_query	= "select * from (select username, password, '0' userrole from admins union select username, password, '1' userrole from stations union select username, password, '2' userrole from drivers union select username, password, '3' userrole from customers) A where A.username = ?";
		
		$query	= $this->db->query($db_query, array($data['username']));
		$result	= $query->result();

		if ($query->num_rows() == 1) {
			if(md5($data['password']) == $result[0]->password) {
				$param['success']	= true;
				$param['role']		= $result[0]->userrole;
			}else{
				$param['success']	= false;
			}

			// if(password_verify($data['password'], $result[0]->password)){
			// 	$param['success']	= true;
			// 	$param['role']		= $result[0]->userrole;
			// }else{
			// 	$param['success']	= false;
			// }
		} else {
			$param['success']	= false;
		}
		
		return $param;
	}

	public function read_user_information($username, $role) {
		
		if($role == '0'){
			$tbl_name	= 'admins';
		}elseif($role == '1'){
			$tbl_name	= 'stations';
		}elseif($role == '2'){
			$tbl_name	= 'drivers';
		}elseif($role == '3'){
			$tbl_name	= 'customers';
		}
		
		$db_query	= "select *, ".$role." userrole from ".$tbl_name." where username = '".$username."'";
		$query	= $this->db->query($db_query);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function update_profile($id, $data, $role) {
		if($role == '0'){
			$tbl_name	= 'admins';
		}elseif($role == '1'){
			$tbl_name	= 'stations';
		}elseif($role == '2'){
			$tbl_name	= 'drivers';
		}elseif($role == '3'){
			$tbl_name	= 'customers';
		}
		
		$this->db->where(array('id' => $id));
		if($this->db->update($tbl_name, $data)){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_userinfo($id, $role) {
		
		if($role == '0'){
			$tbl_name	= 'admins';
		}elseif($role == '1'){
			$tbl_name	= 'stations';
		}elseif($role == '2'){
			$tbl_name	= 'drivers';
		}elseif($role == '3'){
			$tbl_name	= 'customers';
		}
		
		$query	= $this->db->get_where($tbl_name, array('id' => $id), 1);

		if ($query->num_rows() == 1) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function update_password($id, $oldpwd, $newpwd, $tbl){
		
		$query	= $this->db->get_where($tbl, array('id' => $id), 1);

		if ($query->num_rows() == 1) {
			$result	= $query->result();
			$oldpwd_hash	= md5($oldpwd);
			if(md5($oldpwd) == $result[0]->password){
				$data['password'] = md5($newpwd);
				$this->db->where(array('id' => $id));
				if($this->db->update($tbl, $data)){
					$param['success']	= 1;
				}else{
					$param['success']	= 2;
				}
			}else{
				$param['success']	= 3;
			}
		} else {
			$param['success']	= 4;
		}
		
		return $param;
	}
	
}
?>