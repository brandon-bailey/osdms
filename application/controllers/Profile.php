<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
	
	public $uid;
	
	 public function __construct()
	 {	
			parent::__construct(); 
 			
			if($this->session->logged_in)
			{	
				$this->uid = $this->session->id;				
				$this->load->model('details_model','details');
				$this->load->model('global_functions','globalFunctions');
				$this->load->model('profile_model','profile');
				$this->load->model('User_model','userObj');
				$this->load->helper('file');
				$this->userObj->setUser($this->session->id);
			}
			else
			{
				redirect('user_authentication');
			}
	 }

	 public function index()
	 {		 
			 $data=array(
			 'pageTitle'=>'Profile',
			 'userDetails'=>$this->profile->getUserDetails()			 
			 );
			 $this->load->view('templates/header',array('pageTitle'=>'Profile'));
			 $this->load->view('user/profile_view', $data);
			 $this->load->view('templates/footer');	
	 }	 
	 
	 public function saveAvatar()
	 {
		$this->profile->saveAvatar();	 
		delete_files($this->config->item('docTmpDir'));
	 }
	 
	 public function deleteAvatar()
	 {
		echo base64_encode($this->userObj->getAvatar()); 
		delete_files($this->config->item('docTmpDir'));
	 }	 
	 
	 public function changeAvatar()
	 {
			$this->profile->changeAvatar();
	 }

}
