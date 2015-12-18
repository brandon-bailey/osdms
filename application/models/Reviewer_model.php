<?php
/*
Reviewer_class.php - relates reviewers
*/
class Reviewer_Model extends CI_Model
{	
	private static $db;
	
    public function __construct()
    {
		 self::$db = &get_instance()->db;	
    }
	
    public function getReviewersForDepartment($deptId)
    {
		$query = $this->db->select('user_id as dr')
								->where('dept_id',$deptId)
								->get('dept_reviewer');
	  
        if ($query->num_rows() < 1) {
            return false;
        }       
        return $query->result_object();
    }
        /**
         * Function: getDepartmentsForReviewer
         * Get a list of dept ids and user ids that a specfic user has review authority for
         *
         * @param $userId
         * @returns array
         */
	
    public static function getDepartmentsForReviewer($userId)
    {
		$query = self::$db->select('dept_id,user_id')
						->where('user_id',$userId)
						->get('dept_reviewer');	
        return $query->result();
    }	
	
    public static function deleteReviewer($userId)
    {
			$data = array(
				'user_id' => $userId
				);
			self::$db->delete('dept_reviewer',$data);    
    }	
	
    public static function newReviewer($reviewerArray)
    {
		self::$db->set($reviewerArray);
		self::$db->insert('dept_reviewer');
    }	

}
