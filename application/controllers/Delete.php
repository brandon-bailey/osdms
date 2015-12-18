<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delete extends CI_Controller {

	public $uid;
		
	 public function __construct()
	 {
		parent::__construct(); 
		
		if($this->session->logged_in)
		{
			$this->uid = $this->session->id;
			$this->load->model('delete_model','delete');
			$this->load->model('accesslog_model');
			$this->load->model('User_model','userObj');
			$this->userObj->setUser($this->session->uid);
		}
		else{
			redirect('user_authentication');
		} 
	 }
	 
	 public function index()
	 {
			if($this->session->admin)
			{				
				$this->load->view('templates/header',array('pageTitle'=>'Delete Document'));					
				$this->load->view('templates/footer');		
			}
			else{
				redirect('home');
			}
	 }

	public function deleteFile()
	{
		$fileId = $this->uri->segment(3);
		$fileDataObj = new Document_Model($fileId);		
		if($this->session->admin)
		{
			echo $this->delete->deleteFile($fileId);
			exit;
		}
		elseif($fileDataObj->isOwner($this->session->id))
		{
			echo $this->delete->deleteFile($fileId);
			exit;
		}
		else
		{
			$this->session->set_flashdata('error', 'You can not delete this file.');
			redirect($_SERVER['HTTP_REFERRER']);
		}		
	}
	
	public function unDeleteFile()
	{
		$fileId = $this->uri->segment(3);
		$fileDataObj = new Document_Model($fileId);		
		if($this->session->admin)
		{
			$this->delete->unDeleteFile($fileId);
		}
		elseif($fileDataObj->isOwner($this->session->id))
		{
			$this->delete->unDeleteFile($fileId);
		}
		else
		{
			$this->session->set_flashdata('error', 'You can not un-delete this file.');
			redirect($_SERVER['HTTP_REFERRER']);
		}		
	} 

}
