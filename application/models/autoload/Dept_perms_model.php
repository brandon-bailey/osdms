<?php

class Dept_Perms_Model extends CI_Model {

	public $fid;
	public $rights;
	public $error;
	public $chosenMode;
	public $errorFlag = FALSE;
	public $userMode = 0;
	public $fileMode = 1;

	/**
	 * @param bool $limit
	 * @return array
	 */
	public function getCurrentViewOnly($limit = TRUE, $offset = NULL) {
		return $this->loadDataUserPerm($this->config->item('VIEW_RIGHT'), $limit, $offset);
	}

	/**
	 * @param bool $limit
	 * @return array
	 */
	public function getCurrentNoneRight($limit = TRUE, $offset = NULL) {
		return $this->loadDataUserPerm($this->config->item('NONE_RIGHT'), $limit, $offset);
	}

	/**
	 * @param bool $limit
	 * @return array
	 */
	public function getCurrentReadRight($limit = TRUE, $offset = NULL) {
		return $this->loadDataUserPerm($this->config->item('READ_RIGHT'), $limit, $offset);
	}

	/**
	 * @param bool $limit
	 * @return array
	 */
	public function getCurrentWriteRight($limit = TRUE, $offset = NULL) {
		return $this->loadDataUserPerm($this->config->item('WRITE_RIGHT'), $limit, $offset);
	}

	/**
	 * @param bool $limit
	 * @return array
	 */
	public function getCurrentAdminRight($limit = TRUE, $offset = NULL) {
		return $this->loadDataUserPerm($this->config->item('ADMIN_RIGHT'), $limit, $offset);
	}

	/**
	 * Return a list of files that the department that this OBJ represents has authority >= than $right
	 * @param int $right
	 * @param bool $limit
	 * @return array
	 */
	public function loadDataUserPerm($right, $limit = NULL, $offset = NULL) {
		if ($offset != NULL) {
			$offset = 'OFFSET ' . $offset;
		} else {
			$offset = '';
		}
		if ($limit != NULL) {
			$limit = 'LIMIT ' . $limit;
		} else {
			$limit = '';
		}

		$query = $this->db->query("SELECT deptperms.fid as id
                    FROM
                        " . $this->db->dbprefix('documents') . " as documents,
                      " . $this->db->dbprefix('dept_perms') . " as deptperms
                    WHERE
							deptperms.rights >= {$right}
                    AND
							deptperms.dept_id = {$this->session->department}
                    AND
                            documents.id=deptperms.fid
                    AND
                            documents.publishable=1
			{$limit} {$offset}
							");

		return $query->result_array();
	}

	/**
	 * return a boolean on whether or not this department
	 * has view right to the file whose ID is $dataId*
	 * @param int $dataId
	 * @return bool
	 */
	public function canView($dataId) {
		$filedata = new Document_Model($dataId);

		//check  to see if this department doesn't have a forbidden right or
		//if this file is publishable
		if (!$this->isForbidden($dataId) and $filedata->isPublishable()) {
			// return whether or not this deptartment can view the file
			if ($this->canDept($dataId, $this->config->item('VIEW_RIGHT'))) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		return FALSE;
	}

	/**
	 * return a boolean on whether or not this department
	 * has read right to the file whose ID is $dataId
	 * @param int $dataId
	 * @return bool
	 */
	public function canRead($dataId) {
		$filedata = new Document_Model($dataId);

		//check  to see if this department doesn't have a forbidden right or
		//if this file is publishable
		if (!$this->isForbidden($dataId) OR !$filedata->isPublishable()) {
			// return whether or not this deptartment can read the file
			if ($this->canDept($dataId, $this->config->item('READ_RIGHT')) OR !$filedata->isPublishable($dataId)) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		return FALSE;
	}

	/**
	 * return a boolean on whether or not this department
	 * has modify right to the file whose ID is $dataId
	 * @param int $dataId
	 * @return bool
	 */
	public function canWrite($dataId) {
		$filedata = new Document_Model($dataId);

		//check  to see if this department doesn't have a forbidden right or
		//if this file is publishable
		if (!$this->isForbidden($dataId) OR !$filedata->isPublishable()) {
			// return whether or not this deptartment can modify the file
			if ($this->canDept($dataId, $this->config->item('WRITE_RIGHT'))) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		return FALSE;
	}

	/**
	 * return a boolean on whether or not this department
	 * has admin right to the file whose ID is $dataId
	 * @param int $dataId
	 * @return bool
	 */
	public function canAdmin($dataId) {
		$filedata = new Document_Model($dataId);

		//check  to see if this department doesn't have a forbidden right or
		//if this file is publishable
		if (!$this->isForbidden($dataId) or !$filedata->isPublishable()) {
			// return whether or not this deptartment can admin the file
			if ($this->canDept($dataId, $this->config->item('ADMIN_RIGHT'))) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		return FALSE;

	}

	/**
	 * Return a boolean on whether or not this department has forbidden right to the file whose ID is $dataId
	 * @param int $dataId
	 * @return bool
	 */
	public function isForbidden($dataId) {
		$this->error_flag = TRUE; // reset flag

		$this->db->select('rights');
		$this->db->where('dept_id', $this->session->department);
		$this->db->where('fid', $dataId);
		$query = $this->db->get('dept_perms');

		if ($query->num_rows() == 1) {
			if ($query['rights'] == $this->config->item('FORBIDDEN_RIGHT')) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			$this->error = "Non-unique database entry found in $this->db->dbprefix('dept_perms')";
			$this->error_flag = FALSE;
			return FALSE;
		}
	}

	/**
	 * return a bool on whether or not this department has $right
	 * right on file with data id of $dataId
	 * @param int $dataId
	 * @param int $right
	 * @return bool
	 */
	public function canDept($dataId, $right) {
		$this->db->select();
		$this->db->where('dept_id', $this->session->department);
		$this->db->where('rights', $right);
		$query = $this->db->get('dept_perms');

		$numResults = $query->num_rows();
		switch ($numResults) {
		case 1:return TRUE;
			break;
		case 0:return FALSE;
			break;
		default:$this->error = 'non-unique uid: ' . $this->session->department;
			break;
		}
	}

	/**
	 * Return the numeric permission setting of this department for the file with ID number $dataId
	 * @param int $dataId
	 * @return int|string
	 */
	public function getPermission($dataId) {
		$this->db->select('rights');
		$this->db->where('dept_id', $this->session->department);
		$this->db->where('fid', $dataId);
		$query = $this->db->get('dept_perms');

		$numResults = $query->num_rows();
		if ($numResults == 1) {
			$permission = $query->result_array();
			return $permission;
		} else if ($numResults == 0) {
			return FALSE;
		} else {
			return 'Non-unique error';
		}
	}
}