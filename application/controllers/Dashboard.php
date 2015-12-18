<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	 public function __construct()
	 {	
			parent::__construct();   
		
			if($this->session->logged_in)
			{
					$this->load->model('dashboard_model','dashboard');
					$this->load->model('chart_model','chart');	
					$this->userObj->setUser($this->session->id);
			}
			else
			{
				$this->session->set_flashdata('error', 'You must login before viewing this website.');
				redirect('user_authentication');
			} 
	 }
	 
	 public function index()
	 {
			if($this->session->admin)
			{			
				$data=array(
					'pageTitle'=>'Dashboard'
					);
				$this->load->view('templates/header',$data);
				$this->load->view('dashboard/dashboard_view');	
				$this->load->view('templates/footer');
			}
			else
			{
				$this->session->set_flashdata('error', 'You do not have permission to view the dashboard');
				redirect('home');
			}
	 }
	 
	 public function fileCount()
	{
		$this->chart->fileCount();			
	}
	 
	 public function fileCountStatus()
	{
		$this->chart->fileCountStatus();			
	}	 
	
	public function fileCountDept()
	{
		$this->chart->fileCountDept();	
	}
	
	public function fileCountCategory()
	{
		$this->chart->fileCountCategory();		
	}


}
