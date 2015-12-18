<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class File extends CI_Controller {

	public $uid;

	 public function __construct()
	 {
		parent::__construct();   
		if($this->session->logged_in)
		{
			$this->uid = $this->session->id;
			$this->load->model('delete_model','delete');		
			$this->load->model('Global_functions','globalFunctions');
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
			$this->load->view('templates/header',array('pageTitle'=>'File Settings'));
			$this->load->view('file/file_view');		
			$this->load->view('templates/footer');		
		}
		else
		{
			$this->session->set_flashdata('error', 'You do not have permission to view the Admin Files Pages');
			redirect('home');
		}
	} 
	 
	 public function deleteFiles()
	{
			$fileId = $this->uri->segment(3);	
			if($this->session->admin)
			{	
				if($fileId !== NULL)
				{
					$this->delete->permDeleteFiles($fileId);		
				}
				else
				{
					$error = array(
						'status'=>'error',
						'msg'=>'No file ID was passed'
					);	
					echo json_encode($error);
				}
			}
			else
			{
				$error = array(
					'status'=>'error',
					'msg'=>'You do not have permission to permanently delete this file.'
				);	
				echo json_encode($error);
			}
	}

	 public function archiveList()
	{		
		$resultList = $this->delete->getArchivedFiles();
			 	 $data=array(		
					'fileList'=>json_decode($resultList),
					 'allUsers'=>User_Model::getAllUsers(),
					 'trashCanTitle'=>'Permanently Delete File',
					 'authorizeButtonTitle'=>'Undelete This File, will send file back for approval'
					);
	 	 $this->load->view('templates/header',array('pageTitle'=>'Archived Files'));
		$this->load->view('home_view', $data);
		$this->load->view('file/delete_view');
		$this->load->view('templates/footer');	
	}
	
	public function showRejects()
	{
			$resultList = $this->delete->getRejectedFiles();
			$data=array(		
			'fileList'=>json_decode($resultList),
			'trashCanTitle'=>'Archive this File',
			'authorizeButtonTitle'=>'Resubmit for review'
			);		
		$this->load->view('templates/header',array('pageTitle'=>'Rejected Files'));
		$this->load->view('home_view', $data);
		$this->load->view('file/rejects_view');
		$this->load->view('templates/footer');
	}
	
	public function checkedOutFiles()
	{
		$fileIdArray = $this->userObj->getCheckedOutFiles();		
		$userPermObj = new Userpermission_Model();
		$listStatus = $this->globalFunctions->listFiles($fileIdArray, $userPermObj, $this->config->item('dataDir'), TRUE, TRUE);			
			$data=array(		
			'fileList'=>json_decode($listStatus),
			'trashCanTitle'=>'Archive this File',
			'authorizeButtonTitle'=>'Resubmit for review'
			);		
		$this->load->view('templates/header',array('pageTitle'=>'Checked Out Files'));
		$this->load->view('home_view', $data);
		$this->load->view('templates/footer');
	}	
	
	public function reSubmit()
	{
			$fileId = $this->uri->segment(3);
			
			if(isset($fileId))
			{
				$fileObj = new Document_Model($fileId);
				$fileObj->Publishable(0);		
			}
			
		$msg = array(
				'status'=>'success',
				'msg'=>'File was successfully resubmitted for review'
		);	
		echo json_encode($msg);
	}

}
