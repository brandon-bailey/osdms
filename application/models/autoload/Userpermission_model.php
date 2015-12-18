<?php

Class Userpermission_Model extends CI_Model {
	// public $userObj;
	public $userPermsObj;
	public $deptPermsObj;

	public function __construct() {
		parent::__construct();
		$this->userPermsObj = new User_Perms_Model($this->session->id);
		$this->deptPermsObj = new Dept_Perms_Model($this->session->department);
	}

	/**
	 * return an array of all the Allowed files ( right >= view_right) ID
	 * @param bool $limit
	 * @return array
	 */
	public function getAllowedFileIds($limit, $offset = NULL) {
		$viewableArray = $this->getViewableFileIds($limit, $offset);
		$readableArray = $this->getReadableFileIds($limit, $offset);
		$writeableArray = $this->getWriteableFileIds($limit, $offset);
		$adminableArray = $this->getAdminableFileIds($limit, $offset);
		$resultArray = array_values(array_unique(array_merge($viewableArray, $readableArray, $writeableArray, $adminableArray)));
		return $resultArray;
	}

	/**
	 * return an array of all the Allowed files ( right >= view_right) object
	 * @param bool $limit
	 * @return array
	 */
	public function getAllowedFileOBJs($limit = TRUE, $offset = NULL) {
		return $this->convertToFileDataOBJ($this->getAllowedFileIds($limit, $offset));
	}

	/**
	 * @param bool $limit
	 * @return array
	 */
	public function getViewableFileIds($limit = NULL, $offset = NULL) {
		//These 2 below takes half of the execution time for this function
		$uP = ($this->userPermsObj->getCurrentViewOnly($limit, $offset));
		$dP = ($this->deptPermsObj->getCurrentViewOnly($limit, $offset));

		if ($offset !== NULL) {
			$offset = 'OFFSET ' . $offset;
		} else {
			$offset = '';
		}
		if ($limit !== NULL) {
			$limit = 'LIMIT ' . $limit;
		} else {
			$limit = '';
		}
		$array = $this->db->query("
              SELECT
                up.fid as id
              FROM
               " . $this->db->dbprefix('documents') . " d,
               " . $this->db->dbprefix('user_perms') . " up
              WHERE
                (
		up.uid = {$this->session->id}
				  AND d.id = up.fid
		AND up.rights < {$this->config->item('VIEW_RIGHT')}
				  AND d.publishable = 1
				  )
		{$limit} {$offset}
            ");

		$array = $array->result_array();

		if (is_array($array) && is_array($dP)) {
			$totalListing = array_merge($dP, $array);
			$newArray = array();
			$usedFiles = array();

			foreach ($totalListing AS $line) {
				if (!in_array($line['id'], $usedFiles)) {
					$usedFiles[] = $line['id'];
					$newArray[] = $line;
				}
			}
			$dP = $newArray;
			unset($newArray, $usedFiles);
		}

		if (is_array($dP) && is_array($uP)) {
			$totalListing = array_merge($uP, $dP);
			$newArray = array();
			$usedFiles = array();

			foreach ($totalListing AS $line) {
				if (!in_array($line['id'], $usedFiles)) {
					$usedFiles[] = $line['id'];
					$newArray[] = $line;
				}
			}
			$dP = $newArray;
			unset($newArray, $usedFiles);
			return $dP;
		}
	}

	/**
	 * return an array of all the Allowed files ( right >= view_right) OBJ
	 * @param bool $limit
	 * @return array
	 */
	public function getViewableFileOBJs($limit = TRUE, $offset = NULL) {
		return $this->convertToFileDataOBJ($this->getViewableFileIds($limit, $offset));
	}

	/**
	 * return an array of all the Allowed files ( right >= read_right) ID
	 * @param bool $limit
	 * @return array
	 */
	public function getReadableFileIds($limit = TRUE, $offset = NULL) {
		$userPermsFileArray = $this->userPermsObj->getCurrentReadRight($limit, $offset);
		$deptPermsFileArray = $this->deptPermsObj->getCurrentReadRight($limit, $offset);
		$publishedFileArray = $this->userObj->getPublishedData(1);
		$resultArray = array_values(array_unique(array_merge($publishedFileArray, $userPermsFileArray, $deptPermsFileArray)));
		return $resultArray;
	}

	/**
	 * return an array of all the Allowed files ( right >= read_right) OBJ
	 * @param bool $limit
	 * @return array
	 */
	public function getReadableFileOBJs($limit = TRUE, $offset = NULL) {
		return $this->convertToFileDataOBJ($this->getReadableFileIds($limit, $offset));
	}

	/**
	 * return an array of all the Allowed files ( right >= write_right) ID
	 * @param bool $limit
	 * @return array
	 */
	public function getWriteableFileIds($limit = TRUE, $offset = NULL) {
		$userPermsFileArray = $this->userPermsObj->getCurrentWriteRight($limit, $offset);
		$deptPermsFileArray = $this->deptPermsObj->getCurrentWriteRight($limit, $offset);
		$publishedFileArray = $this->userObj->getPublishedData(1);
		$resultArray = array_values(array_unique(array_merge($publishedFileArray, $userPermsFileArray, $deptPermsFileArray)));
		return $resultArray;
	}

	/**
	 * return an array of all the Allowed files ( right >= write_right) ID
	 * @param bool $limit
	 * @return array
	 */
	public function getWriteableFileOBJs($limit = TRUE, $offset = NULL) {
		return $this->convertToFileDataOBJ($this->getWriteableFileIds($limit, $offset));
	}

	/**
	 * return an array of all the Allowed files ( right >= admin_right) ID
	 * @param bool $limit
	 * @return array
	 */
	public function getAdminableFileIds($limit = TRUE, $offset = NULL) {
		$userPermsFileArray = $this->userPermsObj->getCurrentAdminRight($limit, $offset);
		$deptPermsFileArray = $this->deptPermsObj->getCurrentAdminRight($limit, $offset);
		$publishedFileArray = $this->userObj->getPublishedData(1);
		$resultArray = array_values(array_unique(array_merge($publishedFileArray, $userPermsFileArray, $deptPermsFileArray)));
		return $resultArray;
	}

	/**
	 * return an array of all the Allowed files ( right >= admin_right) OBJ
	 * @param bool $limit
	 * @return array
	 */
	public function getAdminableFileOBJs($limit = TRUE, $offset = NULL) {
		return $this->convertToFileDataOBJ($this->getAdminableFileIds($limit, $offset));
	}

	/**
	 * getAuthority
	 * Return the authority that this user have on file data_id
	 * by combining and prioritizing user and department right
	 * @param int $data_id
	 * @return int
	 */
	public function getAuthority($dataId, $fileData) {
		$dataId = (int) $dataId;
		// $fileData = new Document_model($dataId);

		if ($this->session->admin OR $this->userObj->isReviewerForFile($dataId)) {
			return $this->config->item('ADMIN_RIGHT');
		}

		if ($fileData->isOwner($this->uid) && $fileData->isLocked()) {
			return $this->config->item('WRITE_RIGHT');
		}

		$userPermissions = $this->userPermsObj->getPermission($dataId);
		$departmentPermissions = $this->deptPermsObj->getPermission($dataId);

		if ($userPermissions >= $this->config->item('NONE_RIGHT') and $userPermissions <= $this->config->item('ADMIN_RIGHT')) {
			return $userPermissions;
		} else {
			return $departmentPermissions;
		}
	}

}
