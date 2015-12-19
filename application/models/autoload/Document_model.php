<?php
Class Document_Model extends CI_Model {
	public $category;
	public $owner;
	public $createdDate;
	public $description;
	public $comment;
	public $status;
	public $resultLimit = 1;
	public $docTable = 'documents';
	public $department;
	public $defaultRights;
	public $viewUsers;
	public $readUsers;
	public $writeUsers;
	public $adminUsers;
	public $filesize;
	public $isLocked;
	public $location;
	public $modules;
	public $docId;
	public $name;
	public $thumbnail;

	public function __construct($id) {
		parent::__construct();
		$this->docId = $id;
		$this->loadData();
	}

	public function exists() {
		$query = $this->db->select()
			->where('id', $this->docId)
			->get($this->docTable);

		switch ($query->num_rows()) {
		case 1:

			return TRUE;
			break;

		case 0:

			return FALSE;
			break;

		default:$this->error = 'Non-unique';
			return $this->error;
			break;
		}
	}

	public function loadData() {
		$query = $this->db->select()
			->where('id', $this->docId)
			->get($this->docTable);

		if ($query->num_rows() == $this->resultLimit) {
			foreach ($query->result() as $row) {
				$this->category = $row->category;
				$this->owner = $row->owner;
				$this->createdDate = $row->created;
				$this->description = stripslashes($row->description);
				$this->comment = stripslashes($row->comment);
				$this->status = $row->status;
				$this->department = $row->department;
				$this->defaultRights = $row->default_rights;
				$this->location = $row->location;
				$this->modules = $row->modules;
				$this->name = $row->realname;
			}
		} else {
			$this->error = 'Non unique file id';
		}
		$this->isLocked = $this->status == -1;
	}

	public function updateData() {
		$data = array(
			'category' => $this->category,
			'owner' => $this->owner,
			'description' => $this->description,
			'comment' => $this->comment,
			'status' => $this->status,
			'department' => $this->department,
			'default_rights' => $this->defaultRights,
			'location' => $this->location,
		);
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $data);
	}

	/**
	 * return location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * return thumbnail url
	 */
	public function getThumbnail() {

		if (file_exists(FCPATH . $this->config->item('dataDir') . 'thumbnails/' . $this->getBaseName() . '.jpg')) {
			return base_url() . $this->config->item('dataDir') . 'thumbnails/' . $this->getBaseName() . '.jpg';
		} else {
			if ($this->isFileImage()) {
				return base_url() . $this->config->item('dataDir') . $this->getLocation();
			} else {
				return base_url() . 'assets/images/no-image-available.jpg';
			}

		}

	}

	/**
	 * return modules array
	 */
	public function getModules() {
		return json_decode($this->modules);
	}

	/**
	 * return file name with out extension, i.e. turn 'example.php' into 'example'
	 */
	public function getBaseName() {
		$file = $this->location;
		return pathinfo($file, PATHINFO_FILENAME);
	}

	/**
	 * return extension of document i.e. 'docx', 'pdf'
	 */
	public function getExt() {
		$file = $this->location;
		return pathinfo($file, PATHINFO_EXTENSION);
	}

	/**
	 * return this file's category id
	 * @return int
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * @param int $value
	 */
	public function setCategory($value) {
		$this->category = $value;
	}

	/**
	 * return this file's category name
	 * @return string
	 */
	public function getCategoryName() {
		$this->db->select('name');
		$this->db->where('id', $this->category);
		$query = $this->db->get('category');
		$row = $query->row();
		return $row->name;
	}

	/**
	 * return this file's category name
	 * @return string
	 */
	public function getDepartmentName() {
		$this->db->select('name');
		$this->db->where('id', $this->department);
		$query = $this->db->get('department');
		$row = $query->row();
		return $row->name;
	}

	public function getDepartmentColor() {
		$this->db->select('color');
		$this->db->where('id', $this->department);
		$query = $this->db->get('department');
		$row = $query->row();
		return $row->color;
	}
	/**
	 * return this file's revision history
	 * @return string
	 */
	public function getRevisionHistory($revision_id) {
		$query = $this->db->query("SELECT u.last_name, u.first_name,l.modified_on,l.note,	l.revision
		  FROM " . $this->db->dbprefix('log') . " l, " . $this->db->dbprefix('user') . " u
		WHERE	l.id = {$this->docId}
          AND  u.username = l.modified_by
		AND l.revision <= {$revision_id}
		  ORDER BY l.modified_on DESC");

		return $query;
	}

	/**
	 * get the current file versions information
	 */
	public function getCurrentRevision() {

		$query = $this->db->query("
          SELECT u.last_name, u.first_name,l.modified_on,l.note,l.revision
          FROM
           " . $this->db->dbprefix('log') . " l,
			" . $this->db->dbprefix('user') . " u
		WHERE	l.id = {$this->docId}
          AND  u.username = l.modified_by
          ORDER BY l.modified_on DESC");
		return $query;
	}

	/**
	 * return a boolean on whether the user ID $uid is the owner of this file
	 * @param int $uid
	 * @return bool
	 */
	public function isOwner($uid) {
		return ($this->getOwner() == $uid);
	}
	/**
	 * return the ID of the owner of this file
	 * @return int
	 */
	public function getOwner() {
		return $this->owner;
	}

	/**
	 * set the user_id of the file
	 * @param int $value
	 */
	public function setOwner($value) {
		$this->owner = $value;
	}

	/**
	 * return the username of the owner
	 * @return mixed
	 */
	public function getOwnerName() {
		$userObj = new User_Model($this->owner);
		return $userObj->getUserName();
	}

	/**
	 * return owner's full name in an array where index=0 corresponds to the last name
	 * and index=1 corresponds to the first name
	 * @return mixed
	 */
	public function getOwnerFullName() {
		$userObj = new User_Model($this->owner);
		return $userObj->getFullName();
	}

	/**
	 * return the owner's dept ID.  Often, this is also the department of the file.
	 * if the owner changes his/her department after he/she changes department, then
	 * the file's department will not be the same as it's owner's.
	 * @return string
	 */
	public function getOwnerDeptId() {
		$userObj = new User_Model($this->getOwner());
		return $userObj->getDeptId();
	}

	/**
	 * This function serve the same purpose as getOwnerDeptId() except that it returns
	 * the department name instead of department id
	 * @return string
	 */
	public function getOwnerDeptName() {
		$userObj = new User_Model($this->getOwner());
		return $userObj->getDeptName();
	}

	/**
	 * return file description
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $value
	 */
	public function setDescription($value) {
		$this->description = $value;
	}

	/**
	 * @return int
	 */
	public function getDefaultRights() {
		return $this->defaultRights;
	}

	/**
	 * @param int $value
	 */
	public function setDefaultRights($value) {
		$this->defaultRights = $value;
	}

	/**
	 * return file commnents
	 * @return mixed
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @param string $value
	 */
	public function setComment($value) {
		$this->comment = $value;
	}

	public function getError() {
		return $this->error;
	}

	/**
	 * return the status of the file
	 * @return int
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param int $status Status of file
	 */
	public function setStatus($status) {
		$data = array(
			'status' => $status,
		);
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $data);
	}

	/**
	 * return a User OBJ of the person who checked out this file
	 * @return User
	 */
	public function getCheckerOBJ() {
		$user = new User_Model($this->status);
		return $user;
	}

	/**
	 * return the department ID of the file
	 * @return int
	 */
	public function getDepartment() {
		return $this->department;
	}

	/**
	 * @param int $value
	 */
	public function setDepartment($value) {
		$this->department = $value;
	}

	/**
	 * return the date that the file was created
	 * @return string
	 */
	public function getCreatedDate() {
		return $this->createdDate;
	}

	/**
	 * return the latest modifying date on the file
	 * @return string
	 */
	public function getModifiedDate() {
		$this->db->select('modified_on');
		$this->db->order_by('modified_on', 'desc');
		$this->db->limit(1);
		$this->db->where('id', $this->docId);
		$query = $this->db->get('log');
		foreach ($query->result() as $result) {
			return $result->modified_on;
		}
	}
	/**
	 * get total number of revisions
	 * @return array
	 */
	public function getTotalRevisions() {
		$this->db->select();
		$this->db->where('id', $this->docId);
		$query = $this->db->get('log');

		return $query->result();
	}

	/**
	 * update the current revision to the next available number
	 */
	public function updateCurrentRevision($revisionNumber) {
		$data = array(
			'revision' => intval((intval($revisionNumber) - 1)),
		);
		$this->db->where('id', $this->docId);
		$this->db->where('revision', 'current');
		$this->db->update('log', $data);
	}

	/**
	 * insert a new revision for the current file
	 * @param string $userName , string $note
	 */
	public function insertNewRevision($userName, $note) {
		$data = array(
			'id' => $this->docId,
			'modified_on' => date('Y-m-d H:i:s'),
			'modified_by' => $userName,
			'note' => $note,
			'revision' => 'current',
		);
		$this->db->where('id', $this->docId);
		$this->db->update('log', $data);
	}

	/**
	 *finish checking in the file
	 * @param int $publishable , string $fileName
	 */
	public function checkIn($publishable, $fileName) {
		$data = array(
			'status' => 0,
			'publishable' => $publishable,
			'realname' => $fileName,
		);
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $data);
	}

	/**
	 * get information from the checked out file
	 * @param int $uid
	 */
	public function getCheckedOutFileInfo($uid) {
		$this->db->select('description,realname');
		$this->db->where('id', $this->docId);
		$this->db->where('status', $uid);
		$query = $this->db->get($this->docTable);
		foreach ($query->result() as $result) {
			$data = array(
				'description' => $result->description,
				'realname' => $result->realname,
			);
		}
		return $data;
	}

	/**
	 * set the modify rights to the current user
	 * @param int $uid
	 */
	public function modifyRights($uid) {
		$data = array('status' => $uid);
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $data);
	}

	/**
	 * Return the dept rights on this file for a given department
	 * @param int $dept_id
	 * @return int
	 */
	public function getDeptRights($deptId) {
		$this->db->select('rights');
		$this->db->where('fid', $this->docId);
		$this->db->where('dept_id', $deptId);
		$query = $this->db->get('dept_perms');
		foreach ($query->result() as $result) {
			$rights = $result->rights;
		}

		return $rights;
	}

	/**
	 * convert an array of user id into an array of user objects
	 * @param array $uid_array
	 * @return array
	 */
	public function toUserOBJs($uid_array) {
		$UserOBJ_array = array();
		for ($i = 0; $i < sizeof($uid_array); $i++) {
			$UserOBJ_array[$i] = new User_Model($uid_array[$i]);
		}
		return $UserOBJ_array;
	}

	/**
	 * Return a boolean on whether or not this file is publishable
	 * @return string
	 */
	public function isPublishable() {
		$this->db->select('publishable');
		$this->db->where('id', $this->docId);
		$query = $this->db->get($this->docTable);

		if ($query->num_rows() !== 1) {
			exit;
		}

		return $query->result();
	}

	/**
	 * @return bool
	 */
	public function isArchived() {
		$this->db->select('publishable');
		$this->db->where('id', $this->docId);
		$query = $this->db->get($this->docTable);

		if ($query->num_rows() !== 1) {
			echo ('DB error.  Unable to locate file id ' . $this->docId . ' in table ' . $this->db->dbprefix($this->docTable));
			exit;
		}

		return ($query->result() == 2);
	}

	/**
	 * This function sets the publishable field in the data table to $boolean
	 * @param bool $boolean
	 */
	public function Publishable($boolean = TRUE) {
		$data = array('publishable' => $boolean,
			'reviewer' => $this->session->id);
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $data);
	}

	/**
	 * return the user id of the reviewer
	 * @return int
	 */
	public function getReviewerID() {
		$this->db->select('reviewer');
		$this->db->where('id', $this->docId);
		$query = $this->db->get($this->docTable);
		foreach ($query->result() as $result) {
			$reviewer = $result->reviewer;
		}
		return $reviewer;
	}

	/**
	 * return the username of the reviewer
	 * @return bool
	 */
	public function getReviewerName() {
		$reviewerId = $this->getReviewerID();
		if (isset($reviewerId)) {
			$userObj = new User_Model($reviewerId);
			return $userObj->getFullName();
		}
		return false;
	}

	/**
	 * Set $comments into the reviewer comment field in the DB
	 * @param $comments
	 */
	public function setReviewerComments($comments) {
		$data = array('reviewer_comments' => $comments);
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $data);
	}

	/**
	 * Return the reviewers' comment toward this file
	 * @return string
	 */
	public function getReviewerComments() {
		$this->db->select('reviewer_comments');
		$this->db->where('id', $this->docId);
		$query = $this->db->get($this->docTable);
		foreach ($query->result() as $result) {
			$result = $result->reviewer_comments;
		}
		return $result;
	}

	/**
	 *Does not move the file, simply changes the publishable status to 2
	 */
	public function temp_delete() {
		$data = array('publishable' => 2);
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $data);
	}

	/**
	 *Set's the publishable status back to 0 the file will need to be approved again
	 */
	public function undelete() {
		$this->db->where('id', $this->docId);
		$data = array('publishable' => 0);
		$this->db->update($this->docTable, $data);
	}

	/**
	 * @return bool
	 */
	public function isLocked() {
		return $this->isLocked;
	}

	public function getRealName() {
		return $this->name;
	}

	public function changeName(array $name) {
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $name);
		return true;
	}

	public function changeLocation(array $location) {
		$this->db->where('id', $this->docId);
		$this->db->update($this->docTable, $location);
		return true;
	}

	public function isFileImage($file = NULL) {

		$filePath = $file ? $file : FCPATH . $this->config->item('dataDir') . $this->getLocation();
		return getimagesize($filePath) ? true : false;

	}

}
