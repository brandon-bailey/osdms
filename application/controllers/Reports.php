<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Reports extends CI_Controller
{

    public $uid;

    public function __construct()
    {
        parent::__construct();
        $this->uid = $this->session->id;
        $this->load->model('Reports_model', 'report');
        $this->load->model('User_model', 'userObj');
        $this->userObj->setUser($this->session->id);
    }

    public function index()
    {
        if ($this->session->logged_in) {
            if ($this->session->admin) {
                $this->load->view('templates/header', array('pageTitle' => 'Admin Reports'));
                $this->load->view('reports/reports_view');
                $this->load->view('templates/footer');
            } else {
                $this->session->set_flashdata('error', 'You do not have permission to view the reports page.');
                redirect('home');
            }
        } else {
            redirect('user_authentication');
        }
    }

    public function accessLog()
    {
        if ($this->session->admin) {
            $accessLog = $this->report->accessLogReport();

            if ($accessLog['status'] === 'error') {
                $data = array(
                    'error' => $accessLog,
                );
            } else {
                $data = array(
                    'accessLogArray' => $accessLog,
                );
            }

            $this->load->view('templates/header', array('pageTitle' => 'Access Log'));
            $this->load->view('reports/access_log_view', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to view the access log.');
            redirect('home');
        }
    }

    public function fileList()
    {
        if ($this->session->admin) {
            $this->load->view('templates/header', array('pageTitle' => 'File Export'));
            $this->load->view('reports/file_list_view');
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to view the file list page');
            redirect('home');
        }
    }

    public function downloadFile()
    {
        if ($this->session->admin) {
            $fileType = $this->input->post_get('type');
            $fileName = "file-report-" . date('Ymd') . '.' . $fileType;
            $data = $this->report->fileList($fileType);
            force_download($fileName, $data);
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to download these files');
            redirect('home');
        }
    }
}
