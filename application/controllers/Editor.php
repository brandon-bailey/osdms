<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editor extends CI_Controller {
	
	public $uid;
	
	 public function __construct()
	 {
		parent::__construct();	
		
		if($this->session->logged_in)
		{			
				$this->uid = $this->session->id;
				$this->load->model('department_model');
				$this->load->model('editor_model','editor');
				$this->load->model('category_model');
				$this->load->model('accesslog_model');
				$this->load->model('User_model','userObj');
				require_once(APPPATH.'models/Module_model.php');
				$this->userObj->setUser($this->session->id);				
		}
		else
		{
			redirect('user_authentication');
		}		
	 }
	 
	public function index()
	{
			$docId = $this->uri->segment(2);
			$docObj = new Document_Model($docId);
			$modules =$docObj->getModules();			
			if(!is_array($modules))
			{
				$location = FCPATH . $this->config->item('dataDir').$docObj->getLocation();
				if(is_file($location))
				{
					$data = array(		
						'id'=>$docId,
						'file' =>$location
						);	
					$this->load->view('editor/editor_view',$data);		
				}
				else
				{
						$this->session->set_flashdata('error', 'There was an error trying to open this file for editing.');
						redirect($_SERVER['HTTP_REFERER']);
				}
			}			
			
			$mods = array();
			foreach($modules as $mod)
			{
					$modObj = new Module_model($mod->id);
					$category = $modObj->getCategory();
					$loc = $modObj->getLocation();
					$location = FCPATH . $this->config->item('moduleDir') . $category . '/files/' . $loc;
					$mods[] = array(
						'id'=>$mod->id,
						'category'=>$category,
						'location'=>$location
						);
			}	
			$data = array(		
			'id'=>$docId,
			'modules' =>$mods
			);			
			$this->load->view('editor/editor_view',$data);		
	}
	
	public function saveChanges()
	{		
		$post = $this->input->post();
		$this->editor->saveModuleChanges($post);			
	}

}
