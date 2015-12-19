<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Search extends CI_Controller
{
    public $uid;
    public $userObj;

    public function __construct()
    {
        parent::__construct();

        if ($this->session->logged_in) {
            $this->uid = $this->session->id;
            $this->load->model('search_model', 'search');
            $this->load->model('User_model', 'userObj');
            $this->userObj->setUser($this->session->id);
        } else {
            redirect('user_authentication');
        }
    }

    public function index()
    {
        $data = array(
            'pageTitle' => 'Search',
        );
        $this->load->view('templates/header', $data);
        $this->load->view('search/search_view');
        $this->load->view('templates/footer');
    }

    public function liveSearch()
    {
        $post = $this->input->post('search');
        $this->search->liveSearch($post);
    }
}
