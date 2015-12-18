<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Knp\Snappy\Pdf;
use Knp\Snappy\Image;

class Add extends CI_Controller {
	

	 public function __construct()
	 {	
		parent::__construct();    
		
		if($this->session->logged_in)
		{	
			$this->load->helper('security');
			$this->load->model('Reviewer_Model','reviewer');
			$this->load->model('Add_Model','add');
			$this->load->model('Department_Model');
			$this->load->model('Category_Model');
			$this->load->model('Accesslog_Model');
			$this->userObj->setUser($this->session->id);
		}
		else
		{
			redirect('user_authentication');
		} 
	 }

	public function index()
	{		
		if($this->session->canAdd)
		{
			$results = $this->add->loadData();
			$addForm = array(
			'name'=>'main',
			'id'=>'addDocForm',
			'enctype'=>'multipart/form-data',
			'class'=>'form-horizontal'
			);
			$data=array(
			'pageTitle'=>'Add Document',
			'addDocumentData'=>json_decode($results),
			'formDetails'=>$addForm
			);
			$this->load->view('templates/header',$data);
			$this->load->view('add_view');
			$this->load->view('templates/footer');
		}
		else
		{
			$this->session->set_flashdata('error', 'You do not have permission to add files.');
			redirect('home');
		}
	}
	
	public function doUploadAjax()
    {
		if($this->session->canAdd)
		{					
				$this->load->library('upload');	
				//if there are any errors uploading the file, return
				//an error message and do not insert into the database
				
			  if (!$this->upload->do_multi_upload('userfile'))
				{
					$error = array(
					'status'=>'error',
					'msg' => $this->upload->display_errors('','')
					);  		
					echo json_encode($error);
					exit;
				}   // else lets gather all of the important information 
					// about the file, and pass it to the model for inserting
					// to the database
				else {			
					$data = $this->upload->get_multi_upload_data();
				
						foreach($data as $dat)
						{
								$fileData[]=array(
									'originalName'=>$dat['orig_name'],
									'newName'=>$dat['file_name'],
									'rawName'=>$dat['raw_name'],
									'fileExt'=>$dat['file_ext']
								);
						}				
					$fileInfo = array(
						'formData'=> $this->input->post(),
						'fileData'=>$fileData
					);				
					echo $this->add->addDocuments($fileInfo);	
				}		
		}
		else
		{
				$error = array(
					'status'=>'error',
					'msg' => 'You do not have authorization to upload files.'
					);  		
				echo json_encode($error);
				exit;
		}
	}
}
