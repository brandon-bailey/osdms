<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Install extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Install_Model', 'install');
    }

    public function index()
    {

        $this->load->view('install/header', array('pageTitle' => 'Install'));
        $this->load->view('install/install_view');
        $this->load->view('templates/footer');
    }

    public function createUser()
    {
        $data = $this->input->post();
        $this->install->createNewUser($data);
    }

    public function modifyDatabase()
    {
        $data = $this->input->post();
        $this->install->modifyDatabase($data);
    }
}
