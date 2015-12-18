<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tobepublished extends CI_Controller {

	public $uid;
	
	 public function __construct()
	 {
	   parent::__construct();  
	   
		if($this->session->logged_in)
		{
			$this->uid = $this->session->id;
			$this->load->model('Tobepublished_model','published');
			$this->load->model('Accesslog_model');		
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
			if($this->userObj->isReviewer())
			{		
				 $results = $this->published->getFileList();
				 $data=array(
				 'fileList'=>json_decode($results),
				 'reviewCount'=>0,
				 'rejectedFiles'=>0,
				 'expiredFiles'=>0,
				 'allUsers'=>User_Model::getAllUsers(),
				 'trashCanTitle'=>'Reject this File',
				 'authorizeButtonTitle'=>'Approve This File'
				 );
				$this->load->view('templates/header',array('pageTitle'=>'To Be Published'));
				$this->load->view('home_view', $data);	
				$this->load->view('support/tobepublished_view');
				$this->load->view('templates/footer');		
			}
			else
			{
				redirect('home');
			}
	 }

 	public function processFile()
	{		
			$post = $this->input->post('selections');
			$submitType = $this->input->post('type');
				$this->db->select('id,first_name,last_name');
				$query = $this->db->get('user');				
					$data = array(
					'userInfo'=>$query->result(),
					'submitValue'=>$submitType,
					'checkBox'=>$post
					);	
				return $this->load->view('support/comment_form_view',$data);				
	}
	
	
	public function submitFile()
	{
		$post = $this->input->post('formData');
		$type = $this->input->post('type');
		$files = $this->input->post('files');
		parse_str($post, $form);
		
			$data=array(
			'form'=>$form,
			'files'=>$files
			);
	
		switch($type)
		{
			case 'authorize':
				echo $this->published->authorizeFile($data);
				break;
			case 'reject':
				echo $this->published->rejectFile($data);
				break;
			default:
				echo json_encode(array('status'=>'error','msg'=>'There was an error in your form submission.'));		
		}	
	}


}
