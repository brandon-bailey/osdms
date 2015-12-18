<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Details extends CI_Controller {

	public $requestId;
	
	 public function __construct()
	 {	
		parent::__construct();   
		
		if($this->session->logged_in)
		{	
			$this->load->model('Details_model','details');
			$this->load->model('Global_functions','globalFunctions');
			$this->load->helper('file');		
			$this->userObj->setUser($this->session->id);
			$this->requestId = $this->uri->segment(2);
		}
		else
		{
			redirect('user_authentication');
		}
	 }

	 public function index()
	 {	
			 $results = $this->details->getFileDetails();
			 $data=array(
			 'pageTitle'=>'File Details',
			 'fileDetail'=>json_decode($results)
			 );
			 $this->load->view('templates/header',$data);
			$this->load->view('details_view', $data);
			$this->load->view('templates/footer');
	 }

}
