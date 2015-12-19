<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Category extends CI_Controller
{

    public $uid;

    public function __construct()
    {
        parent::__construct();

        if ($this->session->logged_in) {
            $this->uid = $this->session->id;
            $this->load->model('category_model', 'category');
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
                'allCategories' => Category_Model::getAllCategories(),
            );
            $this->load->view('templates/header', array('pageTitle' => 'Category Settings'));
            $this->load->view('categories/category_view', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('home');
        }
    }

    public function addCategory()
    {
        $post = $this->input->post();
        if ($this->userObj->admin) {
            $this->load->view('categories/add_category_view');
        } else {
            $error = array(
                'status' => 'error',
                'msg' => 'You do not have permission to create a new category.',
            );
            echo json_encode($error);
            exit;
        }
    }

    public function createCategory()
    {
        if ($this->userObj->admin) {
            $post = $this->input->post();
            $this->category->createCategory($post);
        } else {
            $error = array(
                'status' => 'error',
                'msg' => 'You do not have permission to create a new category.',
            );
            echo json_encode($error);
            exit;
        }

    }

    public function displayCategoryToDelete()
    {
        $post = $this->input->post('id');
        $cat = $this->category->categoryDetails($post);
        $data = array(
            'deleteCategory' => $cat[0],
            'otherCategories' => Category_Model::getAllCategoriesExcept($post),
        );

        $this->load->view('categories/delete_category_view', $data);
    }

    public function deleteCategory()
    {
        $post = $this->input->post();

        if (!$this->userObj->admin) {
            $error = array(
                'status' => 'error',
                'msg' => 'You cannot delete this department.',
            );
            echo json_encode($error);
            exit;
        }
        Category_Model::deleteCategory($post['assignId'], $post['deleteId']);

    }

    public function displayCategory()
    {
        $post = $this->input->post();
        $cat = $this->category->categoryDetails($post['id']);
        $data = array(
            'categoryFiles' => $this->category->getFilesInCategory($post['id']),
            'categoryDetails' => $cat[0],
        );
        $this->load->view('categories/display_category_view', $data);
    }

    public function modifyCategory()
    {
        if ($this->userObj->admin) {
            $post = $this->input->post();
            $cat = $this->category->categoryDetails($post['id']);
            $data = array(
                'categoryDetails' => $cat[0],
            );
            $this->load->view('categories/modify_category_view', $data);
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to modify a category');
            redirect('home');
        }
    }

    public function saveCategoryModification()
    {
        if ($this->userObj->admin) {
            $post = $this->input->post();

            if (!$this->category->categoryNameExists($post['name'])) {
                $this->category->updateCategory($post);
                $msg = array(
                    'status' => 'success',
                    'msg' => 'You have successfully updated the ' . $post['name'] . ' category.',
                );
                echo json_encode($msg);
            } else {
                $error = array(
                    'status' => 'error',
                    'msg' => 'A department with that name already exists. Please choose a different name or keep the current name.',
                );
                echo json_encode($error);
                exit;
            }
        } else {
            $this->session->set_flashdata('error', 'You do not have permission to modify a department');
            redirect('home');
        }

    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('home', 'refresh');
    }
}
