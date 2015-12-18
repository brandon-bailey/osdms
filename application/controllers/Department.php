<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department extends CI_Controller {

	public $uid;

	 public function __construct()
	 {
	   parent::__construct();   
	   
		if($this->session->logged_in)
		{
				$this->uid = $this->session->id;
				$this->load->model('department_model');
				$this->load->model('User_model','userObj');
				$this->userObj->setUser($this->session->id);			
		}
		else
		{
			redirect('user_authentication');
		} 
	 }
 
	 public function index()
	 {
		if($this->session->admin)
		{	
			 $data=array(		
			 'allDepartments'=>Department_Model::getAllDepartments()
			 );
			$this->load->view('templates/header',array('pageTitle'=>'Department Settings'));
			$this->load->view('department/department_view', $data);		
			$this->load->view('templates/footer');		
		}
		else
		{
			$this->session->set_flashdata('error', 'You do not have permission to view the departments admin page');
			redirect('home');
		}

	}
 
	public function addDepartment()
	{		
			
		if($this->session->admin)
		{
			$this->load->view('department/add_department_view');	
		}
		else
		{
		$this->session->set_flashdata('error', 'You do not have permission to view this page');
		redirect('home');
		}
	}
	
	public function createDepartment()
	{
		if($this->session->admin)
		{
			$post = $this->input->post();	
			$nameExists = Department_Model::doesDeptNameExist($post['name']);
			$colorExists = Department_Model::doesDeptColorExist($post['color']);
				if($nameExists){
						$error = array(
							'status'=>'error',
							'msg'=>'A department with that name already exists. Please choose a different name.'
							);
						echo json_encode($error);
						exit;
				}elseif($colorExists){
					$error = array(
							'status'=>'error',
							'msg'=>'A department with that color already exists. Please pick another color.'
							);
						echo json_encode($error);
						exit;
				}
				else{
					Department_Model::createNewDepartment($post['name'],$post['color']);
					$msg = array(
							'status'=>'success',
							'msg'=>'You have successfully created the '.$post['name'].' department.'
							);
					echo json_encode($msg);
				}	
		}
		else{
				$this->session->set_flashdata('error', 'You do not have permission to add a department');
				redirect('home');
		}
	}
	
	public function getAllDepartmentsExcept()
	{
		$post = $this->input->post();
		$departments = Department_Model::getAllDepartmentsExcept($post['id']);
		$currentDept = Department_Model::getDepartmentById($post['id']);
		$data = array(
		'assignDept'=>$departments,
		'currentDept'=>$currentDept[0]		
		);
		$this->load->view('department/delete_department_view',$data);		
	}
	
	public function deleteDepartment()
	{
		$post = $this->input->post();		
		if(!$this->session->admin)
		{
			$error = array(
			'status'=>'error',
			'msg'=>'You cannot delete this department.'
			);
			echo json_encode($error);
			exit;
		}
		Department_Model::deleteDepartment($post['assignId'],$post['deleteId']);		
			$msg = array(
			'status'=>'success',
			'msg'=>'Successfully deleted department '. $post['deleteId']
			);		
		echo json_encode($msg);
	}
	
	public function displayDepartment()
	{
		$post = $this->input->post();		
		$data =array(		
		 'deptDetails'=>Department_Model::getDepartmentById($post['id']),
		 'deptUsers'=> Department_Model::getAllUsersByDepartment($post['id'])
		 );			
		$this->load->view('department/display_department_view',$data);
	}
	
	public function modifyDepartment()
	{
		if($this->session->admin)
		{
			$post = $this->input->post();		
			$data =array(		
			'deptDetails'=>Department_Model::getDepartmentById($post['id'])
			);			
			$this->load->view('department/modify_department_view',$data);
		}
		else
		{
				$this->session->set_flashdata('error', 'You do not have permission to modify a department');
				redirect('home');
		}
	}
	
	public function saveDepartmentModification()
	{
		if($this->session->admin)
		{
				$post = $this->input->post();	
				$nameExists = Department_Model::checkDepartmentName($post['id'],$post['name']);
				$colorExists = Department_Model::checkDepartmentColor($post['id'],$post['color']);
					if($nameExists){
							$error = array(
								'status'=>'error',
								'msg'=>'A department with that name already exists. Please choose a different name or keep the current name.'
								);
							echo json_encode($error);
							exit;
					}elseif($colorExists){
						$error = array(
								'status'=>'error',
								'msg'=>'A department with that color already exists. Please pick another color, or keep your current one.'
								);
							echo json_encode($error);
							exit;
					}
					else{
						Department_model::updateDepartment($post);
						$msg = array(
								'status'=>'success',
								'msg'=>'You have successfully updated the '.$post['name'].' department.'
								);
						echo json_encode($msg);
					}	
			}
		else{
				$this->session->set_flashdata('error', 'You do not have permission to modify a department');
				redirect('home');
		}
		
	}
}
