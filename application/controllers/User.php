<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends CI_Controller
{

    var $uid;
    var $userObj;

    public function __construct()
    {
        parent::__construct();

        if ($this->session->logged_in) {
            $this->uid = $this->session->id;
            $this->load->model('AccessLog_model');
            $this->load->model('Department_model');
            $this->load->model('Reviewer_model');
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
                'allUsers' => User_Model::getAllUsers(),
            );
            $this->load->view('templates/header', array('pageTitle' => 'User Settings'));
            $this->load->view('user/user_view', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('home');
        }
    }

    public function addUser()
    {
        $this->load->view('templates/header', array('pageTitle' => 'Add User'));
        $this->load->view('user/add_user_view');
        $this->load->view('templates/footer');
    }

    public function createNewUser()
    {
        $post = $this->input->post();
        echo json_encode($post);
        $this->userObj->createNewUser($post);
    }

    public function deleteUserPick()
    {
        $data = array(
            'allUsers' => User_Model::getAllUsers(),
        );
        $this->load->view('templates/header', array('pageTitle' => 'Delete User'));
        $this->load->view('user/delete_user_view', $data);
    }

    public function deleteUser()
    {
        $post = $this->input->post('id');
        if ($post == $this->session->id) {
            $error = array(
                'status' => 'error',
                'msg' => 'You cannot delete yourself.',
            );
            echo json_encode($error);
            exit;
        }
        User_model::deleteUser($post);
        $msg = array(
            'status' => 'success',
            'msg' => 'Successfully delete user id: ' . $post,
        );
        echo json_encode($msg);
    }

    public function displayUser()
    {
        $post = $this->input->post('id');
        if (isset($post) && $post !== null) {
            $data = array(
                'userDetails' => User_Model::getAllUserDetails($post),
                'allDepts' => Department_Model::getAllDepartments(),
                'userReviewDepts' => Reviewer_Model::getDepartmentsForReviewer($post),
                'newUserObj' => new User_Model($post),
            );
            $this->load->view('user/display_user_view', $data);
        } else {
            $this->session->set_flashdata('error', 'There was an error opening the user page to display.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function modifyUser()
    {
        $post = $this->input->post();
        if (isset($post['id']) && $post['id'] !== null) {
            if ($this->session->admin == true) {
                $mode = 'enabled';
            } else {
                $mode = 'disabled';
            }

            if ($mode == 'disabled' && $post['id'] != $this->uid) {
                $error = array(
                    'status' => 'error',
                    'msg' => 'You do not have permission to edit this user.',
                );
                echo json_encode($error);
                exit;
            }
            $userForm = array(
                'name' => 'update',
                'id' => 'modifyUserForm',
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal',
            );
            $data = array(
                'userDetails' => User_Model::getAllUserDetails($post['id']),
                'allDepts' => Department_Model::getAllDepartments(),
                'userReviewDepts' => Reviewer_Model::getDepartmentsForReviewer($post['id']),
                'newUserObj' => new User_Model($post['id']),
                'mode' => $mode,
                'formDetails' => $userForm,
            );
            $this->load->view('user/modify_user_view', $data);
        } else {
            $this->session->set_flashdata('error', 'You attempted to access the profile page in an unauthorized manner.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function saveUserChanges()
    {
        if ($this->session->admin) {
            $post = $this->input->post();
            $this->userObj->processUserInformation($post);
        } elseif ($this->input->post('id') == $this->session->id) {
            $post = $this->input->post();
            $this->userObj->processUserInformation($post);
        } else {
            $this->session->set_flashdata('error', 'You are only authorized to change your personal profile.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
