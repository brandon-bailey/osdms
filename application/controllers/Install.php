<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Install extends CI_Controller {

	public function __construct() {
		parent::__construct();

	}

	public function index() {

		$this->load->view('install/header', array('pageTitle' => 'Install'));
		$this->load->view('install/install_view');
		$this->load->view('templates/footer');
	}

	public function userSettings() {
		$data = $this->input->post();
		echo json_encode($data);
	}

}
