<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	
	 public function __construct()
	 {	
		parent::__construct();   
		
			if($this->session->logged_in)
			{			
				$this->load->model('Admin_model','admin');
				$this->userObj->setUser($this->session->id);
			}		
			else{
				redirect('user_authentication');
			} 
	 }

	public function index()
	{
			if($this->session->admin)
			{
				$data=array(
				'pageTitle'=>'Admin' 
				);
				$this->load->view('templates/header',$data);
				$this->load->view('admin_view');	
				$this->load->view('templates/footer');
				
			}
			else
			{
				$this->session->set_flashdata('error', 'You do not have permission to view the admin page.');
				redirect('home');
			}
	}
 
	public function settings()
	{
		if($this->session->admin)
		{		
			$data=array(
			'pageTitle'=>'Settings'
			);
			$this->load->view('templates/header',$data);
			$this->load->view('admin/settings_view');	
			$this->load->view('templates/footer');
		}		
		else
		{
			$this->session->set_flashdata('error', 'You do not have permission to view the admin settings page.');
			redirect('home');
		} 		
	}
	
	public function editSettings()
	{
		if($this->session->admin)
		{			
			$this->load->model('settings_model','settings');			
				$data=array(
				'pageTitle'=>'Edit Settings'
				);		
			$this->load->view('templates/header',$data);
			$this->load->view('admin/edit_settings_view' , array('settings'=>$this->settings->loadSettings('custom')));
			$this->load->view('templates/footer');
		}		
		else
		{
			$this->session->set_flashdata('error', 'You do not have permission to edit the admin settings.');
			redirect('home');
		} 	
	}
	
	public function saveSettings()
	{
		if($this->session->admin)
		{		
			$data = $this->input->post();
			$this->load->model('settings_model');
			$this->settings_model->save($data);	
		}		
		else
		{
			$this->session->set_flashdata('error', 'You do not have permission to edit the admin settings.');
			redirect('home');
		} 			
	}

}
