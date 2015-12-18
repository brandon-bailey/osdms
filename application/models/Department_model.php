<?php  
  class Department_model extends CI_Model
    {    

		private static $db;
		private static $cache;	
		
		public function __construct() 
		{
				parent::__construct();
				self::$cache = &get_instance()->cache;
				self::$db = &get_instance()->db;
		}	
		
		public static function setDepartmentColor($id,$color)
		{	
			$data = array('color'=>$color);
			self::$db->where('id',$id);
			self::$db->update('department',$data);
		}
		
        /**
         * Function: getAllDepartments
         * Get a list of department names and ids sorted by name
         *
         * @param PDO $pdo
         * @returns array
         */
        public static function getAllDepartments()
        {
			if ( ! $departmentListArray = self::$cache->get('allDepartments'))
			{
				$query = self::$db->select('id, name')
							->order_by('name')
					->get('department');
				$departmentListArray = $query->result();
			
				self::$cache->save('allDepartments', $departmentListArray, 1200);
			}					
            return $departmentListArray;
        }
		
		
        /**
         * Function: getDepartmentById
         * Get a specific department
         *
         * @param PDO $pdo
         * @returns array
         */
        public static function getDepartmentById($id)
        {
			self::$db->select('id,name,color');
			self::$db->where('id',$id);
			$query = self::$db->get('department');			
			return $query->result();
        }
		
        public static function getDepartmentByName($department)
        {
			self::$db->select('id');
			self::$db->where('name',$department);
			$query = self::$db->get('department');			
			return $query->result();
        }		
		
        public static function doesDeptNameExist($department)
        {
			self::$db->select('name');
			self::$db->where('name',$department);
			$query = self::$db->get('department');
			if($query->num_rows()==0)
			{
				return FALSE;				
			}
			else{
				return TRUE;
			}		
        }		
		
		public static function doesDeptColorExist($color)
		{
			self::$db->select('color');
			self::$db->where('color',$color);
			$query = self::$db->get('department');			
			if($query->num_rows()==0)
			{
				return FALSE;				
			}
			else{
				return TRUE;
			}			
		}
		
        public static function getAllDepartmentsExcept($id)
        {
			self::$db->select('id,name');
			self::$db->where('id !=',$id);
			self::$db->order_by('name');
			$query = self::$db->get('department');			
			return $query->result();
        }	
		
        public static function getAllUsersByDepartment($id)
        {
			$query =self::$db->query("
			SELECT dept.id,u.first_name,u.last_name
			FROM
				" . self::$db->dbprefix('department') ." dept,
				" . self::$db->dbprefix('user') ." u
			WHERE dept.id = $id AND u.department = {$id}");
			return $query->result();
        }			
		
        public static function checkDepartmentName($id,$name)
        {
			self::$db->select('name');
			self::$db->where('name',$name);
			self::$db->where('id !=',$id);
			$query = self::$db->get('department');
			if($query->num_rows()==0)
			{
				return FALSE;				
			}
			else
			{
				return TRUE;
			}	
        }	
		
		public static function checkDepartmentColor($id,$color)
        {
			self::$db->select();
			self::$db->where('color',$color);
			self::$db->where('id !=',$id);
			$query = self::$db->get('department');			
			if($query->num_rows()==0)
			{
				return FALSE;				
			}
			else
			{
				return TRUE;
			}	
        }
		
        public static function createNewDepartment($department,$color)
        {
			$data = array(
			'name'=>$department,
			'color'=>$color
			);
			self::$db->insert('department',$data);
        }	
		
        public static function getDeptDefaultRights()
        {
			self::$db->select('id,default_rights');
			$query = self::$db->get('documents');
			return $query;
        }			
		
        public static function updateDepartmentName($id,$name)
        {
			$data = array(
			'name'=>$name
			);
			self::$db->where('id',$id);		
			self::$db->update('department',$data);
        }
        /**
         * Function: updateDepartment
         * Update a specific department
		 *
		 *@param $info -> array of dept info
         * 
         */		
		
		public static function updateDepartment($info)
		{
			self::$db->where('id',$info['id']);		
			self::$db->update('department',$info);			
		}
		
        public static function setDeptPerms($fid,$deptId,$rights)
        {
			$data = array(
			'fid'=>$fid,
			'dept_id'=>$deptId,
			'rights'=>$rights
			);		
			self::$db->insert('dept_perms',$data);		
        }
		
        public static function deleteDepartment($assignedId,$id)
        {
			
				$data = array(
				'department'=>$assignedId				
				);
				self::$db->where('department',$id);
				self::$db->update('documents',$data);
				
				self::$db->where('department',$id);
				self::$db->update('user',$data);

				$data = array(
				'dept_id'=>$assignedId
				);
				self::$db->where('dept_id',$id);
				self::$db->update('dept_perms',$data);

				
				self::$db->where('dept_id',$id);
				self::$db->update('dept_reviewer',$data);

				self::$db->where('id',$id);
				self::$db->delete('department');


        }			

        }