<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Checkout extends CI_Controller {

	public $uid;
	public $fileDataObj;
	
	 public function __construct()
	 {
			parent::__construct();  
	   
	   		if($this->session->logged_in)
			{
				$this->uid = $this->session->id;
				$this->load->model('accesslog_model');	
				$this->load->helper('file','download');
				$this->load->model('User_model','userObj');
				$this->userObj->setUser($this->session->id);
			}
			else
			{			
				$this->session->set_flashdata('error', 'You must sign in.');
				redirect('user_authentication');
			}
			
	 }


	public function downloadFile()
	{
			$fileId = $this->uri->segment(3);
			$this->fileDataObj = new Document_Model($fileId);
			if ($this->fileDataObj->getError() != NULL OR $this->fileDataObj->getStatus() > 0  OR $this->fileDataObj->isArchived())
			{
					$this->session->set_flashdata('error', 'There was an error downloading that file.');
					redirect($_SERVER['HTTP_REFERRER']);
					exit;
			}
			$fileName = $this->config->item('dataDir').$this->fileDataObj->getLocation();	
			$this->fileDataObj->modifyRights($this->uid);
			AccessLog_Model::addLogEntry($fileId, 'O');
			AccessLog_Model::addLogEntry($fileId, 'D');
			if(file_exists($fileName))
			{
				header('Cache-control: private');
				header ('Content-Type: ' . get_mime_by_extension($fileName));
				header ('Content-Disposition: attachment; filename="' . $this->fileDataObj->getRealName() . '"');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');				
				readfile($fileName);        

			}	

	} 

}
