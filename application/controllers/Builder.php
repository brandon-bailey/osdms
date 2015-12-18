<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Builder extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if ($this->session->logged_in) {
			$this->load->model('builder_model', 'builder');
			$this->load->model('category_model');
			$this->load->model('department_model');
			$this->userObj->setUser($this->session->id);
			require_once APPPATH . 'models/Module_model.php';
		} else {
			redirect('user_authentication');
		}
	}

	public function module() {
		$data = array(
			'pageTitle' => 'Module Builder',
			'bodyClass' => 'edit',
			'builder' => 'module',
		);
		$this->load->view('templates/header', $data);
		$this->load->view('builder/inner_navbar_view');
		$this->load->view('builder/module_builder_view');
		$this->load->view('templates/footer');
	}

	public function document() {
		$allDepartments = Department_Model::getAllDepartments();

		$data = array(
			'pageTitle' => 'Document Builder',
			'bodyClass' => 'edit',
			'builder' => 'document',
			'headerModules' => json_decode($this->builder->getModules('header')),
			'bodyModules' => json_decode($this->builder->getModules('body')),
			'footerModules' => json_decode($this->builder->getModules('footer')),
			'draftModules' => json_decode($this->builder->getDraftModules()),
			'unpublishedModules' => json_decode($this->builder->getUnpublishedModules()),
			'allCategories' => Category_Model::getAllCategories(),
			'allDepartments' => Department_Model::getAllDepartments(),
		);
		$this->load->view('templates/header', $data);
		$this->load->view('builder/inner_navbar_view');
		$this->load->view('builder/document_builder_view');
		$this->load->view('templates/footer');
	}

	public function createProject() {
		$data = array(
			'pageTitle' => 'Document Builder',
		);

		$this->load->view('templates/header', $data);
		$this->load->view('builder/create_project_view');
		$this->load->view('templates/footer');

	}

	public function insertNewProject() {
		$post = $this->input->post();
		//echo json_encode($post);
		if ($post) {
			$this->builder->insertNewProject($post);
		}

	}

	public function saveModule() {
		$this->builder->saveModule($this->input->post());
	}

	public function saveDocument() {
		$this->builder->saveDocument($this->input->post());
	}

}
