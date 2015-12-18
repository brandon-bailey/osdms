<?php 
    class Category_model extends CI_Model
    {
		private static $db;	
		private static $cache;
		public function __construct() 
		{				
				parent::__construct();
				self::$cache = &get_instance()->cache;
				self::$db = &get_instance()->db;
		}	
		
		public function categoryDetails($id)
		{
			$query = $this->db->select('id,name')
										->where('id',$id)
										->get('category');
									
			return $query->result_object();			
		}
		
		
		public function getFilesInCategory($id)
		{
			 $query = $this->db->select('id, realname')
											->where('category',$id)
										->get('documents');
				return $query->result_object();			
		}
		
		public function categoryNameExists($name)
		{
			$query = $this->db->select('name')
										->where('name',$name)
										->get('category');
				if($query->num_rows() > 0)
				{
						return TRUE;
				}
				else{
					return FALSE;
				}
		}
		
		public function updateCategory($info)
		{
			$this->db->where('id',$info['id']);		
			$this->db->update('category',$info);	
		}
				
		public function createCategory($post)
		{
			$query = $this->db->select()
										->where($post)
										->get('category');
			if($query->num_rows() > 0)
			{
				$error = array(
				'status'=>'error',
				'msg'=>'A category with that name already exists.'
				);
			echo json_encode($error);
			exit;
			}
			else{							
				$this->db->insert('category',$post);
					$msg = array(
						'status'=>'success',
						'msg'=>'Successfully created a new category.'
						);
				echo json_encode($msg);
			}			
		}
		
		public static function getAllCategoriesExcept($id)
        {
            // query to get a list of available users
			self::$db->select('id, name');
			self::$db->where('id !=',$id);
			self::$db->order_by('name');
			$query = self::$db->get('category');
            foreach($query->result() as $row) {
                $categoryListArray[] = $row;
            }
            return $categoryListArray;
        }	
		
        /**
         * getAllCategories - Returns an array of all the categories
         * @returns array
         */		 
		 
        public static function getAllCategories()
        {			
			if ( ! $categoryListArray = self::$cache->get('allCategories'))
			{
				self::$db->select('id, name');
				self::$db->order_by('name');
				$query = self::$db->get('category');
				foreach($query->result() as $row) 
				{
					$categoryListArray[] = $row;
				}				
				self::$cache->save('allCategories', $categoryListArray, 1200);
			}
            return $categoryListArray;
        }		
		
        public static function deleteCategory($assignedId,$id)
        {			
				$data = array(
				'category'=>$assignedId				
				);
				self::$db->where('category',$id);
				self::$db->update('documents',$data);

				self::$db->where('id',$id);
				self::$db->delete('category');

				$msg = array(
						'status'=>'success',
						'msg'=>'Successfully deleted category.'
						);					
				echo json_encode($msg);

        }			

    }

