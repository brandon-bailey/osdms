<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller {
		
	 public function __construct()
	 {	
		parent::__construct();   
		
			if($this->session->logged_in)
			{
					$key = $this->config->item('pusher_key');
					$secret = $this->config->item('pusher_secret');
					$app_id = $this->config->item('pusher_appid'); 
					$debug = TRUE;
					$host = base_url();
					$port = '4567';
					$timeout = 5;						
			}		
			else
			{
				redirect('user_authentication');
			} 
	 }
	 
	
	public function newNotification()
	{
		$post = $this->input->post();
		$channel = $post['action'];
		$message = $post['msg'];
		$type=$post['type'];
		$pusher = new Pusher($key, $secret, $app_id, $debug, $host, $port,$timeout);
		$pusher->trigger($channel,$type, array('message' => $message) );
				
	}

}
