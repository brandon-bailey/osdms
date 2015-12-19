<?php if (! defined('BASEPATH')) {

    exit('No direct script access allowed');
}
  
class Events extends CI_Controller
{
     
    public $uid;
    public $userObj;
    public $admin;
    
    public function __construct()
    {
        parent::__construct();
        
        if ($this->session->logged_in) {
            $this->uid = $this->session->userdata['logged_in']['id'];
            $this->load->model('builder_model', 'builder');
            $this->load->model('category_model');
            $this->load->model('department_model');
            $this->load->model('User_model', 'userObj');
            require_once(APPPATH.'models/module_model.php');
            $this->userObj->setUser($this->uid);
        } else {
            redirect('user_authentication');
        }
    }
     
    public function index($data == null)
    {
                header('Content-Type: text/event-stream');
                header('Cache-Control: no-cache');
        if ($data !== null) {
                echo 'data: '.$data;
        }
    }
    
    public function sendData($msg)
    {
        echo "data: ".$msg;
        ob_flush();
        flush();
    }
}
