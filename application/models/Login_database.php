<?php

Class Login_Database extends CI_Model {

// Insert registration data in database
	public function registration_insert($data) {
		// Query to check whether username already exist or not
		$query = $this->db->select()
			->where('username', $data['username'])
			->limit(1)
			->get('user');

		if ($query->num_rows() == 0) {
			if ($this->config->item('require_password_reset') == TRUE) {
				$this->db->set('pw_reset_code', 1);
			}
			// Query to insert data in database
			$this->db->insert('user', $data);

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

	// Read data using username and password
	public function login($data) {
		$query = $this->db->select()
			->where('username', $data['username'])
			->limit(1)
			->get('user');

		if ($query->num_rows() == 1) {
			foreach ($query->result() as $result) {
				$hash = $result->password;
			}
			if (password_verify($data['password'], $hash)) {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

	public function checkForReset($data) {
		$query = $this->db->select('pw_reset_code')
			->where('password', $data['password'])
			->where('username', $data['username'])
			->get('user');
		foreach ($query->result() as $result) {
			return $result->pw_reset_code;
		}

	}

	// Read data from database to show data in admin page
	public function read_user_information($username) {
		$query = $this->db->select('id')
			->where('username', $username)
			->limit(1)
			->get('user');

		if ($query->num_rows() == 1) {
			foreach ($query->result() as $row) {
				$this->userObj->setUser($row->id);
				return $this->userObj->getSessionInformation();
			}
		} else {
			return FALSE;
		}
	}

}

?>