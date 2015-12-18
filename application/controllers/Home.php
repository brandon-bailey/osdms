<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Home extends CI_Controller {

	public function __construct() {

		parent::__construct();

		// Will function to ensure the application is installed in the future.
		/*if (file_exists(APPPATH . 'controllers\Install.php')) {
				redirect('install');
			}
		*/

		if ($this->session->logged_in) {
			$this->load->library('pagination');
			$this->load->model('Home_Model', 'home');
			$this->load->model('Global_functions', 'globalFunctions');
			$this->userObj->setUser($this->session->id);

		} else {
			redirect('user_authentication');
		}
	}

	public function index() {
		$offset = $this->uri->segment(2);
		$config['base_url'] = site_url();
		$config['per_page'] = 6;
		$config['uri_segment'] = 2;
		$results = $this->home->getFileList($config['per_page'], $offset);
		$resultList = json_decode($results['fileList']);
		$config['total_rows'] = $results['size'];
		$this->pagination->initialize($config);

		$data = array(
			'fileList' => $resultList,
			'reviewCount' => $this->getFilesNeedReview(),
			'rejectedFiles' => $this->getRejectedFiles(),
			'expiredFiles' => $this->getExpiredFiles(),
			'allUsers' => User_Model::getAllUsers(),
			'links' => $this->pagination->create_links(),
		);

		$this->load->view('templates/header', array('pageTitle' => 'Home'));

		$this->load->view('home_view', $data);
		$this->load->view('templates/footer');
	}

	public function getFilesNeedReview() {
		if ($this->session->admin) {
			return sizeof($this->userObj->getAllRevieweeIds());
		} elseif ($this->userObj->isReviewer()) {
			return sizeof($this->userObj->getRevieweeIds());
		} else {
			return FALSE;
		}
	}

	public function getRejectedFiles() {
		return $this->userObj->getRejectedFileIds();
	}

	public function getExpiredFiles() {
		return $this->userObj->getNumExpiredFiles();
	}

}
