<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_authentication extends CI_Controller {
 
	public function __construct()
	{
		parent::__construct();  
		$this->load->library('form_validation');  
		$this->load->model('Login_database','login'); 
		$this->load->model('User_Model','userObj'); 
	}
 
	public function index()
	{
		$data=array('siteTitle'=>$this->config->item('site_title'));
		$this->load->view('login/login_form',$data);
	}
 
	public function userRegistrationShow() 
	{
		if($this->config->item('allow_signup')==TRUE)
		{
			$data=array('siteTitle'=>$this->config->item('site_title'));
			$this->load->view('login/registration_form',$data);
		}
		else
		{
			$this->session->set_flashdata('error', 'The site admin does not allow user signup.');
			redirect('home');
		} 
	}

	// Validate and store registration data in database
	public function newUserRegistration() 
	{
		if($this->config->item('allow_signup')==TRUE)
		{
		
			// Check validation for user input in SignUp form
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			$this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			
			if ($this->form_validation->run() == FALSE) 
			{
				$this->load->view('login/registration_form');
			} 
			else 
			{
				if($this->config->item('require_password_reset')==TRUE)
				{
						$password = User_Model::randomPassword();
				}
				elseif($this->config->item('require_password_reset')==FALSE)
				{
					$password =  password_hash($this->input->post('password'),PASSWORD_DEFAULT);
				}				
				$data = array(
						'username' => $this->input->post('username'),
						'email' => $this->input->post('email'),
						'phone'=>$this->input->post('phone'),
						'first_name'=>$this->input->post('firstName'),
						'last_name'=>$this->input->post('lastName'),
						'password' =>$password
					);
				
				$result = $this->login->registration_insert($data);
			
				if ($result == TRUE) 
				{
						$data['message_display'] = 'Registration Successful!';
						$this->load->view('login/login_form', $data);
				}
				else
				{
						$data['message_display'] = 'Username already exist!';
						$this->load->view('login/registration_form', $data);
				}
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'The site admin does not allow user signup.');
			redirect('home');
		}
			
	}

	public function passwordReset($data)
	{
		$this->load->view('login/password_reset_view',$data);
	}
	
	public function resetPassword()
	{		
		$post = $this->input->post();
		$resetP = User_Model::changePasswordStatic($post);
			if($resetP){
					$data = array(
					'message_display' => 'Password successfully reset'
					);		
				$this->load->view('login/login_form', $data);
			}			
	}
	
	public function resetTempPassword()
	{
			$id = $this->uri->segment(3);	
			$pass = $this->uri->segment(4);
			$confirm = $this->userObj->checkTempPass($id,$pass);
				if($confirm)
				{
					$this->userObj->setUser($id);
					$data = array(
					'username'=>$this->userObj->getUserName(),
					'oldPassword'=>$pass
					);
					$this->load->view('login/password_reset_view',$data);
				}
	}
 
 
	public function userLoginProcess()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if ($this->form_validation->run() == FALSE) 
		{
			if(isset($this->session->logged_in))
			{
				redirect('home');
			}
			else
			{
				$this->load->view('login/login_form');
			}
		} 
		else {
					$data = array( 
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password')
					);
		$result = $this->login->login($data);
		
		if ($result === TRUE) 
		{
			$username = $this->input->post('username');
			$result = $this->login->read_user_information($username);
				if ($result !== FALSE) 
				{
					// Add user data in session
					$this->session->set_userdata($result);
					redirect('home');
				}
		}
		else 
		{				
			$result = $this->login->checkForReset($data);
					if($result[0]->pw_reset_code==1)
					{						
						$this->passwordReset($data);
					}
					else
					{						
						$data = array(
						'error_message' => 'Invalid Username or Password'
						);	
						$this->load->view('login/login_form',$data);
					}
	
		}
	} 
 }
 
 // Logout from admin page
	public function logout() 
	{
		// Removing session data
			$sess_array = array(
				'username' => ''
			);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = 'Successful Logout';
		$this->load->view('login/login_form', $data);
	}
 
}
 
?>