<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class UserDefinedFields extends CI_Controller
{
    public $uid;
    public $userObj;

    public function __construct()
    {
        parent::__construct();

        if ($this->session->logged_in) {
            $this->uid = $this->session->id;
            $this->load->model('Udf_functions_model', 'udf');
            $this->load->model('User_model', 'userObj');
            $this->userObj->setUser($this->session->id);
        } else {
            redirect('user_authentication');
        }
    }

    public function index()
    {
        if ($this->session->admin) {
            $data = array(
                'pageTitle' => 'User Defined Fields',
            );
            $this->load->view('templates/header', $data);
            $this->load->view('userdefined/userdefined_view');
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to view the UDF page.');
            redirect('home');
        }
    }

    public function add()
    {
        if ($this->session->admin) {
            $this->load->view('userdefined/add_userdefined_view');
        }
    }

    public function displayUdfsToDelete()
    {
        $data = array(
            'fields' => $this->udf->getAllUdfFields(),
        );
        $this->load->view('userdefined/delete_userdefined_view', $data);
    }

    public function delete()
    {
        $post = $this->input->post('id');
        $this->udf->udfFunctionsDeleteUdf($post);
    }

    public function createUdf()
    {
        $post = $this->input->post();
        $this->udf->udfFunctionsAddUdf($post);
    }
}
