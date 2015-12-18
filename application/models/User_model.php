<?php
Class User_Model extends CI_Model {
	public $root_id;
	public $table_name = 'user';
	public $id;
	public $username;
	public $first_name;
	public $last_name;
	public $userEmail;
	public $phone;
	public $department;
	public $pw_reset_code;
	public $can_add;
	public $can_checkin;
	public $name;
	public $avatar;
	public $date;
	public $admin;

	private static $db;
	private static $cache;

	public function __construct($id = NULL) {
		parent::__construct();
		self::$db = &get_instance()->db;
		self::$cache = &get_instance()->cache;
		$this->setUser($id);
		$this->root_id = $this->config->item('root_id');
		$this->result_limit = 1;
	}

	public function setUser($id) {
		$this->id = $id;

		if ($id !== NULL) {
			$this->getDetails();
		}
	}

	public function getDetails($return = FALSE) {
		$results = $this->db->select()
			->where('id', $this->id)
			->get($this->table_name);

		foreach ($results->result() as $result) {
			$this->id = $result->id;
			$this->username = $result->username;
			$this->department = $result->department;
			$this->phone = $result->phone;
			$this->userEmail = $result->email;
			$this->last_name = $result->last_name;
			$this->first_name = $result->first_name;
			$this->pw_reset_code = $result->pw_reset_code;
			$this->can_add = $result->can_add;
			$this->can_checkin = $result->can_checkin;
			$this->avatar = $result->avatar;
			$this->date = $result->date;
		}

	}

	public function getSessionInformation() {
		$sessionData = array(
			'id' => $this->id,
			'username' => $this->username,
			'email' => $this->userEmail,
			'department' => $this->department,
			'phone' => $this->phone,
			'firstName' => $this->first_name,
			'lastName' => $this->last_name,
			'admin' => $this->isAdmin(),
			'canAdd' => $this->can_add,
			'canCheckIn' => $this->can_checkin,
			'logged_in' => TRUE,
		);
		return $sessionData;
	}

	/**
	 * Return department name for current user
	 * @return string
	 */
	public function getDeptName() {
		$query = $this->db->select('name')
			->where('id', $this->department)
			->get('department');
		foreach ($query->result() as $row) {
			return $row->name;
		}
	}

	/**
	 * Return random password for first time
	 * @return string
	 */
	public static function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	/**
	 * Return sign up date
	 * @return string
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Return department ID for current user
	 * @return string
	 */
	public function getDeptId() {
		return $this->department;
	}

	/**
	 * Return ID for current user
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Return image of user avatar
	 * @return string
	 */
	public function getAvatar() {
		if ($this->avatar !== '' && $this->avatar !== NULL && $this->avatar !== 0) {
			return $this->avatar;
		} else {
			$avatar = file_get_contents(base_url() . 'assets/images/avatar.jpg');
			return $avatar;
		}
	}

	/**
	 * Insert new user avatar
	 * @param $avatar array('avatar'=> base64_decoded(image))
	 */
	public function saveAvatar($avatar) {
		$this->db->update($this->tablename, $avatar);
		$msg = array(
			'status' => 'success',
			'msg' => 'Successfully Updated the User avatar',
		);
	}

	/**
	 * Return an array of publishable documents
	 * @return array
	 * @param object $publishable
	 */
	function getPublishedData($publishable) {
		$dataPublished = array();
		$index = 0;
		$query = $this->db->query("SELECT d.id
              FROM " . $this->db->dbprefix('documents') . "  d,
			  " . $this->db->dbprefix('user') . " u
              WHERE  d.owner = $this->session->id
              AND u.id = d.owner
              AND d.publishable = $publishable ");

		foreach ($query->result() as $row) {
			$dataPublished[$index] = $row;
			$index++;
		}
		return $dataPublished;
	}

	/**
	 * Check whether user from object has Admin rights
	 * @return Boolean
	 */
	public function isAdmin() {
		if ($this->isRoot()) {
			return TRUE;
		}
		$query = $this->db->select('admin')
			->where('id', $this->id)
			->get('admin');

		if ($query->num_rows() === 0) {
			return FALSE;
		}
		foreach ($query->result() as $row) {
			return $row->admin;
		}
	}

	/**
	 * Check whether user from object is root
	 * @return bool
	 */
	public function isRoot() {
		return ($this->root_id == $this->getId());
	}

	/**
	 * @return boolean
	 */
	public function canAdd() {
		if ($this->admin) {
			return TRUE;
		}
		if ($this->can_add) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @return boolean
	 */
	public function canCheckIn() {
		if ($this->admin) {
			return TRUE;
		}
		if ($this->can_checkin) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		$query = $this->db->select('password')
			->where('id', $this->id)
			->get('user');
		if ($query->num_rows() !== 1) {
			$msg = array('status' => 'error',
				'msg' => 'We could not find the password for id: ' . $this->id,
			);
			return json_encode($msg);
			exit;
		}
		return $query->row();
	}

	/**
	 * @param string $nonEncryptedPassword
	 * @return bool
	 */
	public function changePassword($nonEncryptedPassword) {
		$pass = array('password' => password_hash($nonEncryptedPassword, PASSWORD_DEFAULT));
		$this->db->where('id', $this->id)
			->update('user', $pass);
		return TRUE;
	}

	/**
	 * @param array $passArr contains username and newpassword , old password
	 * @return bool
	 */
	public static function changePasswordStatic($passArr) {
		$pass = array(
			'password' => password_hash($passArr['password'], PASSWORD_DEFAULT),
			'pw_reset_code' => NULL,
			'date' => date('Y-m-d H:i:s'),
		);

		self::$db->where('username', $passArr['username'])
			->where('password', $passArr['oldPassword'])
			->update('user', $pass);
		return TRUE;
	}

	/**
	 * @param string $non_encrypted_password
	 * @return bool
	 */
	public function validatePassword($nonEncryptedPassword) {
		$this->db->select('password');
		$this->db->where('id', $this->id);
		$query = $this->db->get('user');
		foreach ($query->result() as $row) {
			$hash = $row->password;
		}
		if (password_verify($nonEncryptedPassword, $hash)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/**
	 * @param string $new_name
	 * @return bool
	 */
	public function changeName($newName) {
		$this->db->set('username', $newName)
			->where('id', $this->id)
			->update($this->tablename);
		return TRUE;
	}

	/**
	 *   Determine if the current user is a reviewer or not
	 *   @return boolean
	 */
	public function isReviewer() {
		// If they are an admin, they can review
		if ($this->session->admin) {
			return TRUE;
		}

		$query = $this->db->select()
			->where('user_id', $this->id)
			->get('dept_reviewer');

		if ($query->num_rows() !== 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Determine if the current user is a reviewer for a specific ID
	 * @param int $file_id
	 * @return boolean
	 */
	public function isReviewerForFile($fileId) {
		$query = $this->db->query("SELECT d.id
                      FROM
                           " . $this->db->dbprefix('documents') . " as d,
                          " . $this->db->dbprefix('dept_reviewer') . " as dr
                      WHERE
                            dr.dept_id = d.department AND
                            dr.user_id = {$this->id} AND
                            d.department = dr.dept_id AND
                            d.id = {$fileId}");
		if ($query->num_rows() < 1) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * this functions assume that you are an admin thus allowing you to review all departments
	 * @return array
	 */
	public function getAllRevieweeIds() {
		if ($this->session->admin) {
			$this->db->select('id');
			$this->db->where('publishable', 0);
			$query = $this->db->get('documents');
			return $query->result_array();
		}
	}

	/**
	 * getRevieweeIds - Return an array of files that need reviewing under this person
	 * @return array
	 */
	public function getRevieweeIds() {
		if ($this->isReviewer()) {
			// Which departments can this user review?
			$result = $this->db->select('dept_id')
				->where('user_id', $this->id)
				->get('dept_reviewer');
			$numDepts = $result->num_rows();
			// Build the query

			$this->db->select('id');
			$index = 0;
			foreach ($result->result() as $row) {
				$dept = $row->dept_id;
				if ($index != $numDepts - 1) {
					$this->db->where('department', $dept);
				} else {
					$this->db->where('department', $dept);
				}
				$index++;
			}
			$this->db->where('publishable', 0);
			$query = $this->db->get('documents');
			$fileData = array();
			$numFiles = $query->num_rows();
			foreach ($query->result() as $row) {
				$fileData[] = array('id' => $row->id);
			}
			return $fileData;
		}
	}

	/**
	 * @return array
	 */
	public function getAllRejectedFileIds() {
		$query = $this->db->select('id')
			->where('publishable', '-1')
			->get('documents');
		return $query->result_array();
	}

	/**
	 * @return array
	 */
	public function getRejectedFileIds() {
		$query = $this->db->select('id')
			->where('publishable', '-1')
			->where('owner', $this->id)
			->get('documents');
		return $query->result_array();
	}

	/**
	 * @return array
	 */
	public function getExpiredFileIds() {
		$query = $this->db->select('id')
			->where('status', '-1')
			->where('owner', $this->id)
			->get('documents');
		$numFiles = $query->num_rows();
		foreach ($query->result() as $row) {
			$fileData = array(
				'id' => $row->id,
				'total' => $numFiles,
			);
		}
		return $fileData;
	}

	/**
	 * @return int
	 */
	public function getNumExpiredFiles() {
		$query = $this->db->select('id')
			->where('status', '-1')
			->where('owner', $this->id)
			->get('documents');
		return $query->num_rows();
	}

	/**
	 * @return mixed
	 */
	public function getEmailAddress() {
		return $this->userEmail;
	}

	/**
	 * @return mixed
	 */
	public function getPhoneNumber() {
		return $this->phone;
	}

	/**
	 * /Return full name mainly used for email templates
	 * @return mixed
	 */
	public function getFullNameConcat() {
		return $this->first_name . ' ' . $this->last_name;
	}

	/**
	 * /Return full name array where array[0]=firstname and array[1]=lastname
	 * @return mixed
	 */
	public function getFullName() {
		$full_name[0] = $this->first_name;
		$full_name[1] = $this->last_name;

		return $full_name;
	}

	/**
	 * Return username of current user
	 * @return mixed
	 */
	public function getUserName() {
		return $this->username;
	}

	/**
	 * Return list of checked out files to root
	 * @return array
	 */
	public function getCheckedOutFiles() {
		if ($this->isRoot()) {
			$this->db->select('id');
			$this->db->where('status >', '0');
			$this->db->where('owner', $this->id);
			$query = $this->db->get('documents');
			return $query->result_object();
		}
	}

	/**
	 * Return list of checked out files to root
	 * @return array
	 */
	public function getAdminCheckedOutFiles() {
		if ($this->session->admin) {
			$this->db->select();
			$this->db->where('status', $this->id);
			$query = $this->db->get('documents');
			return $query->result_object();
		}
	}

	/**
	 * Return list of checked out files to current user
	 * @return array object
	 */
	public function getUserCheckedOutFiles() {
		$query = $this->db->query("SELECT
				d.id,u.last_name, u.first_name,	d.realname, d.created,d.description,d.status,d.location
				FROM " . $this->db->dbprefix('documents') . " as d,
				" . $this->db->dbprefix('user') . " as u
				WHERE d.status = $this->id
				AND d.owner = u.id");

		return $query->result_object();
	}

	public function processUserInformation($post) {
		$newUserObj = new User_Model($post['id']);

		if (($post['id'] !== $this->session->id) && !$this->session->admin) {
			$error = array(
				'status' => 'error',
				'msg' => 'You do not have permission to edit this user.',
			);
			echo json_encode($error);
			exit;
		}
		if (!isset($post['admin']) OR $post['admin'] == '') {
			$post['admin'] = '0';
		}
		if (!isset($post['can_add']) OR $post['can_add'] == '') {
			$post['can_add'] = '0';
		}
		if (!isset($post['can_checkin']) OR $post['can_checkin'] == '') {
			$post['can_checkin'] = '0';
		}
		// UPDATE admin info
		if ($this->admin) {
			$adminArray = array(
				'admin' => $post['admin'],
				'id' => $post['id']);
			self::updateAdmin($adminArray);
		}
		// UPDATE into user

		if ($this->session->admin) {
			$this->db->set('username', $post['username']);
			$this->db->set('can_add', $post['can_add']);
			$this->db->set('can_checkin', $post['can_checkin']);
		}
		if (!empty($post['password'])) {
			$this->db->set('password', password_hash($post['password'], PASSWORD_DEFAULT));
		}
		if ($newUserObj->isAdmin()) {
			if (isset($post['department'])) {
				$this->db->set('department', $post['department']);
			}
		}
		if (isset($post['phonenumber'])) {
			$this->db->set('phone', $post['phone']);
		}
		if (isset($post['email'])) {
			$this->db->set('email', $post['email']);
		}
		if (isset($post['last_name'])) {
			$this->db->set('last_name', $post['last_name']);
		}
		if (isset($post['first_name'])) {
			$this->db->set('first_name', $post['first_name']);
		}
		$this->db->where('id', $post['id']);
		$this->db->update('user');

		if ($this->session->admin) {
			Reviewer_Model::deleteReviewer($post['id']);
			if (isset($post['department_review'])) {
				for ($i = 0; $i < sizeof($post['department_review']); $i++) {
					$reviewerArray = array(
						'dept_id' => $post['department_review'][$i],
						'user_id' => $post['id'],
					);
					Reviewer_Model::newReviewer($reviewerArray);
				}
			}
		}
		$msg = array(
			'status' => 'success',
			'msg' => 'You have successfully updated this users profile.',
		);
		echo json_encode($msg);
	}

	/**
	 * Create a new User
	 * @return last insert id
	 */
	public static function createUser($userArray) {
		self::$db->insert('user', $userArray);
		return self::$db->insert_id();
	}

	public function checkTempPass($id, $pass) {
		$query = $this->db->select()
			->where('id', $id)
			->where('password', $pass)
			->where('pw_reset_code', 1)
			->get($this->table_name);

		if ($query->num_rows() === 1) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function createNewUser($data) {
		if (!$this->session->admin) {
			$msg = array(
				'status' => 'error',
				'msg' => 'You do not have permission to add a new user.',
			);
			echo json_encode($msg);
			exit;
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$msg = array(
				'status' => 'error',
				'msg' => validation_errors('', ''),
			);
			echo json_encode($msg);
			exit;
		}
		//check if user exists already
		$query = $this->db->select()
			->where('username', $this->input->post('username'))
			->or_where('email', $this->input->post('email'))
			->limit(1)
			->get('user');

		if ($query->num_rows() !== 0) {
			$msg = array(
				'status' => 'error',
				'msg' => 'The chosen username or email already exist.',
			);
			echo json_encode($msg);
			exit;
		}
		//done checking if user exists

		$data = array(
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'department' => $this->input->post('department'),
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'password' => self::randomPassword(),
			'last_pw_reset' => date('Y-m-d H:i:s'),
		);

		$this->db->set('pw_reset_code', 1);

		// Query to insert data in database
		$this->db->insert('user', $data);

		if ($this->db->affected_rows() === 1) {
			$this->emailNewUser($data, $this->db->insert_id());

			$msg = array(
				'status' => 'success',
				'msg' => 'Successfully created the new user.',
			);
			echo json_encode($msg);
			exit;
		}

		// end insert new user
	}

	/**
	 * update User
	 * @return none
	 */
	public static function updateUser($query, $params) {
		self::$db->insert('user', $params);
	}

	/**
	 * set new User admin settings
	 */
	public static function newUserAdmin($adminArray) {
		self::$db->insert('admin', $adminArray);
	}

	/**
	 * update admin settings
	 */
	public static function updateAdmin($adminArray) {
		$query = self::$db->select('id')
			->where('id', $adminArray['id'])
			->get('admin');
		if ($query->num_rows() == 0) {
			self::$db->update('admin', $adminArray);
		} else {
			self::$db->where('id', $adminArray['id']);
			self::$db->update('admin', $adminArray);
		}

	}

	/**
	 * checks if the user name already exists
	 *@return int for rowCount
	 */
	public static function exists($username) {
		$query = self::$db->select('username')
			->where('username', $username)
			->get('user');
		return $query->num_rows();
	}

	public static function newUserReviewer($deptArray) {
		self::$db->insert('dept_reviewer', $deptArray);
	}
	/**
	 * gets the first and last name of the user to be deleted
	 *@return array of results
	 */
	public static function getUserDetails($id) {
		$query = self::$db->select('id,first_name,last_name')
			->where('id', $id)
			->get('user');
		return $query->result();
	}

	/**
	 * gets the first and last name of all users
	 *@return array of results
	 */
	public static function getAllUserDetails($id) {
		$query = self::$db->select()
			->where('id', $id)
			->get('user');
		return $query->row();
	}

	public static function deleteUser($id) {
		$tables = array('admin', 'user');
		self::$db->delete($tables, array('id' => $id));

		self::$db->delete('user_perms', array('uid' => $id));

		self::$db->where('id', $id);
		self::$db->set('owner', 0);
		self::$db->update('documents');
	}

	/**
	 * getAllUsers - Returns an array of all the active users
	 * @param $pdo
	 * @return array
	 */
	public static function getAllUsers() {
		if (!$userList = self::$cache->get('allUsers')) {
			$query = self::$db->select('id,username,last_name,first_name')
				->order_by('last_name')
				->get('user');
			$userList = $query->result_object();
			self::$cache->save('allUsers', $userList, 1200);
		}
		return $userList;
	}

	/**
	 * emailNewUser - sends an email to the newly created user
	 * @param (array) $data, $id = new users id
	 * structure of array -
	 * 'username', 'email', 'phone', 'department', 'first_name', 'last_name',
	 * 'password'
	 *
	 * @return array
	 */
	public function emailNewUser($data, $id) {
		$this->load->library('email');
		$fullName = $this->session->firstName . ' ' . $this->session->lastName;
		$resetLink = site_url() . 'user_authentication/resettemppassword/' . $id . '/' . $data['password'];

		$emailData = array(
			'newUser' => $data['first_name'] . ' ' . $data['last_name'],
			'username' => $data['username'],
			'password' => $data['password'],
			'creator' => $fullName,
			'date' => date('l \t\h\e jS'),
			'msg' => 'created an account for you on ' . $this->config->item('site_title') . '.',
			'email' => $this->session->email,
			'phoneNumber' => $this->session->phone,
			'department' => $this->department,
			'id' => $id,
			'link' => $resetLink,
		);

		$body = $this->load->view('emails/new_user_compiled', $emailData, TRUE);
		$subject = 'Your new account has been created for ' . $this->config->item('site_title');

		$result = $this->email
			->from($this->session->email, $fullName)
			->to($data['email'], $data['first_name'] . ' ' . $data['last_name'])
			->subject($subject)
			->message($body)
			->send();

	}

}
?>