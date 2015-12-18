<?php
	
	class Email_Model extends CI_Model
	{
		
		/**
		 * @param int $deptId
		 *Get all emails for the passed in department
		 */
		public function getDeptEmails($deptId)
		{
			$query = $this->db->select('first_name, last_name, email')
											->where('department',$deptId)
											->get('user');
			return $query->result_object();
		}

		/*
		*Send email to everyone
		*/
		public function getAllEmail()
		{
			$query = $this->db->select('first_name, last_name, email')
											->get('user');
			return $query->result_object();			
		}
		
		public function getEmailUserObj($userArray)
		{
			foreach($userArray as $user)
			{
				if((sizeof($user) > 0)) {
					$objArray[] = new User_model($user->dr);
				}
			}    
			if(count($objArray) > 0) {
				return $objArray;
			}
		}

		public function getEmailList($userArray)
		{
			 foreach($userArray as $user)
			{				
				$list[] = array(
				'email' => $user->getEmailAddress() ,
				'fullname' => $user->getFullNameConcat() 
				); 	
			}	
				return $list;	
		}

	}