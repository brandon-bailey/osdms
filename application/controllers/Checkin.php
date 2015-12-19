<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Checkin extends CI_Controller
{

    public $uid;
    public $fileDataObj;

    public function __construct()
    {
        parent::__construct();

        if ($this->session->logged_in) {
            $this->load->library('pagination');
            $this->uid = $this->session->id;
            $this->load->model('checkin_model', 'checkin');
            $this->load->model('accesslog_model');
            $this->load->model('User_model', 'userObj');
            $this->load->model('Global_functions', 'globalFunctions');
            $this->userObj->setUser($this->session->id);

            if ($this->uri->segment(3) !== null) {
                $this->fileDataObj = new Document_Model($this->uri->segment(3));
            }
        } else {
            redirect('user_authentication');
        }
    }

    public function index()
    {
        if ($this->session->canCheckIn) {
            if ($this->session->admin) {
                $result = $this->userObj->getAdminCheckedOutFiles();
            } else {
                $result = $this->userObj->getUserCheckedOutFiles();
            }
            $count = count($result);
            $data = array(
                'checkedOut' => $result,
                'count' => $count,
            );
            $this->load->view('templates/header', array('pageTitle' => 'Check In'));
            $this->load->view('checkin_view', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to check in files');
            redirect('home');
        }

    }

    public function checkFileIn()
    {
        if ($this->session->canCheckIn) {
            $result = $this->fileDataObj->getCheckedOutFileInfo($this->uid);
            $count = count($result);

            if ($count <= 0) {
                $this->session->set_flashdata('error', 'Check In Failed, No results were found in the database, this file may have already been checked in.');
                redirect($_SERVER['HTTP_REFERRER']);
            }
            $this->load->view('templates/header', array('pageTitle' => 'Check In'));
            $this->load->view('checkin_form_view', array('fileInfo' => $result));
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to check in files.');
            redirect('home');
        }
    }

    public function doUploadAjax()
    {
        $post = $this->input->post();
        $fileDataObj = new Document_Model($post['id']);
        $location = $fileDataObj->getLocation();
        $this->load->library('upload');
        $config['upload_path'] = $this->config->item('dataDir') . 'tmp';
        $config['allowed_types'] = 'gif|jpg|png|php|html|pdf|doc|docx|odt|odp|ods|csv|xml|xls|xlsx|ppt';
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array(
                'status' => 'error',
                'msg' => $this->upload->display_errors('', ''),
            );
            echo json_encode($error);
            exit;
        } else {
            $data = $this->upload->data();

            $fileInfo = array(
                'formData' => $post,
                'fileData' => $data,
            );
            $this->checkin->checkInFile($fileInfo);
        }
    }
}
