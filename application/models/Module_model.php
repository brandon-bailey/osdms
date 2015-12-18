<?php
class Module_Model extends CI_Model {
	public $category;
	public $owner;
	public $created_date;
	public $description;
	public $publishable;
	public $location;
	public $status;
	public $id;
	public $result_limit;

	function __construct($id) {
		parent::__construct();
		$this->id = $id;
		$this->result_limit = 1;
		$this->tablename = 'modules';
		$this->loadData();
	}

	/**
	 * Return a boolean whether this file exists
	 * @return bool|string
	 */
	public function exists() {
		$query = $this->db->select()
			->where('id', $this->id)
			->get($this->tablename);
		switch ($query->num_rows()) {
		case 1:
			return TRUE;
			break;
		case 0:
			return FALSE;
			break;
		default:
			$this->error = 'Non-unique';
			return $this->error;
			break;
		}
	}

	/**
	 * This is a more complex version of base class's loadData.
	 * This function loads up all the fields in data table
	 */
	public function loadData() {
		$query = $this->db->select()
			->where('id', $this->id)
			->get($this->tablename);

		if ($query->num_rows() == $this->result_limit) {
			foreach ($query->result() as $row) {
				$this->category = $row->category;
				$this->owner = $row->owner;
				$this->created_date = $row->created;
				$this->description = stripslashes($row->description);
				$this->publishable = $row->publishable;
				$this->location = $row->location;
			}
		} else {
			$this->error = 'Non unique file id';
		}
		$this->isLocked = $this->status == -1;
	}

	/**
	 * Update the dynamic values of the file
	 */
	public function updateData() {
		$data = array(
			'category' => $this->category,
			'owner' => $this->owner,
			'description' => $this->description,
			'publishable' => $this->status,
			'location' => $this->location,
		);
		$this->db->where('id', $this->id);
		$this->db->update($this->tablename, $data);
	}

	/**
	 * return location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * return file name with out extension, i.e. turn 'example.php' into 'example'
	 */
	public function getBaseName() {
		$file = $this->location;
		return pathinfo($file, PATHINFO_FILENAME);
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
		return $userObj->getName();
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
	 * return the status of the file
	 * @return int
	 */
	public function getStatus() {
		return $this->publishable;
	}

	/**
	 * @param int $status Status of file
	 */
	public function setStatus($publishable) {
		$this->db->set('publishable', $publishable)
			->where('id', $this->id)
			->update($this->tablename);

	}

	/**
	 * return the date that the file was created
	 * @return string
	 */
	public function getCreatedDate() {
		return $this->created_date;
	}

	public function archiveModule() {
		$status = '-1';
		$this->setStatus($status);
		$cat = $this->category;
		$location = $this->location;
		fmove(ABSPATH . 'modules/custom/' . $cat . '/files/' . $location, ABSPATH . 'modules/custom/' . $cat . '/archiveDir/' . $location);
	}

	public function unArchiveModule($status) {
		$this->setStatus($status);
		$cat = $this->category;
		$location = $this->location;
		fmove(ABSPATH . 'modules/custom/' . $cat . '/archiveDir/' . $location, ABSPATH . 'modules/custom/' . $cat . '/files/' . $location);
	}

}