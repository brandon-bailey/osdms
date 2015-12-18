<?php
/*
udf_functions.php - adds user defined functions
*/
class Udf_Functions_Model extends CI_Model
    {
		
	public function getAllUdfFields()
	{
		$query = $this->db->select('id, display_name')
								->get('udf');
		return $query->result_object();
	}
	
	public function getUdfData($id)
	{
		$query = $this->db->select()
								->where('id',$id)
								->get('udf');
		return $query->result_object();
	}	

    public function udfFunctionsAddUdf($post)
    {

        if(empty($post['udfName']))
        {
			$this->session->set_flashdata('error', 'The UDF Name cannot be blank.');
			redirect($_SERVER['HTTP_REFERER']);
			exit;
        }

        if(empty($post['displayName']))
        {
			$this->session->set_flashdata('error', 'The UDF Display Name cannot be blank.');
			redirect($_SERVER['HTTP_REFERER']);
            exit;
        }     
		
        $tableName = str_replace(' ', '', 'udftbl_' . strtolower($post['udfName']));
		
        if(!preg_match('/^\w+$/', $tableName))
        {          
			$this->session->set_flashdata('error', 'Invalid Name: (A-Z 0-9 Only)');
			redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
			
		$this->load->dbforge();		
		
        // Check for duplicate table name
		$query = $this->db->select()
								->where('table_name',$tableName)
								->get('udf');		
		
        if ($query->num_rows() === 0)
        {
            if ($post['udfType'] == 1 || $post['udfType'] == 2)
            {
				//Start the transaction in order to easily rollback in case of errors
				$this->db->trans_begin();
				
                // First we add a new column in the data table
				$fields = array(
						$tableName => array(
						'type' => 'int',
						'AFTER'=>'category'
						)
					);
				$this->dbforge->add_column('documents', $fields);
				
                if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();				
                    $this->session->set_flashdata('error', 'There was a problem with altering the database');
					redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }		
				$fields = array(
							'id' => array(
									'type' => 'INT',
									'unique' => TRUE,
									'unsigned' => TRUE,
									'auto_increment' => TRUE
							),
							'value' => array(
									'type' => 'VARCHAR',
									'constraint' => '64',
							)						
					);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('id',TRUE);
				$attributes = array(
				'ENGINE' => 'InnoDB',
				'COLLATE'=>'utf8_unicode_ci'
				);				
				$this->dbforge->create_table($tableName, TRUE, $attributes);				

                 if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();                             
                    $this->session->set_flashdata('error', 'There was a problem with creating the new database table.');
					redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }
                // And finally, add an entry into the udf table

				$data = array(
				'table_name'=>$tableName,
				'display_name'=>$post['displayName'],
				'field_type'=>$post['udfType']
				);
				$this->db->insert('udf',$data);
			
                if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();						
                    $this->session->set_flashdata('error', 'There was a problem with inserting new udf field into the udf table.');
					redirect($_SERVER['HTTP_REFERER']);
                    exit;					
                }
				else
				{
						$msg = array(
						'status'=>'success',
						'msg'=>'Successfully created the new user defined field.'
						);
						echo json_encode($msg);					
					$this->db->trans_commit();
				}
            }
			elseif ($post['udfType'] == 4)
			{
				$this->db->trans_begin();
				
                // They have chosen Select list of Radio list                
                $primaryTableName = "{$tableName}_primary";
				$secondaryTableName = "{$tableName}_secondary";
				
				$query = $this->db->select('table_name')
												->where('table_name',$primaryTableName)
												->get('udf');
			
                if($query->num_rows() === 0)
				{
                // First we add a new column in the data table
					$fields = array(
							$primaryTableName => array(
								'type' => 'int',
								'AFTER'=>'category'
							),
							$secondaryTableName =>array(
							'type' => 'int',
							'AFTER'=>$primaryTableName
							)
					);				
					$this->dbforge->add_column('documents', $fields);

                    if ($this->db->trans_status() === FALSE)
					{
                        $this->db->trans_rollback();						
						$this->session->set_flashdata('error', 'There was a problem with creating new columns in the documents table.');
						redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }					
					$fields = array(
							'id' => array(
									'type' => 'INT',
									'unique' => TRUE,
									'unsigned' => TRUE,
									'auto_increment' => TRUE
							),
							'value' => array(
									'type' => 'VARCHAR',
									'constraint' => '64',
							)						
					);
				$this->dbforge->add_field($fields);
				$attributes = array(
				'ENGINE' => 'InnoDB',
				'COLLATE'=>'utf8_unicode_ci'
				);				
				$this->dbforge->create_table($primaryTableName, TRUE, $attributes);				

                    if ($this->db->trans_status() === FALSE)
					{
                        $this->db->trans_rollback();						
						$this->session->set_flashdata('error', 'There was a problem with creating the new primary table in the database.');
						redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }
					
					$fields = array(
							'id' => array(
									'type' => 'INT',
									'unique' => TRUE,
									'unsigned' => TRUE,
									'auto_increment' => TRUE
							),
							'value' => array(
									'type' => 'VARCHAR',
									'constraint' => '64',
							),
							'pr_id'=>array(
										'type'=>'INT'
							)
					);
				$this->dbforge->add_field($fields);
				$attributes = array(
				'ENGINE' => 'InnoDB',
				'COLLATE'=>'utf8_unicode_ci'
				);				
				$this->dbforge->create_table($secondaryTableName, TRUE, $attributes);						
						
					
                    if ($this->db->trans_status() === FALSE)
					{
                        $this->db->trans_rollback();						
						$this->session->set_flashdata('error', 'There was a problem with creating the new secondary table in the database.');
						redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }			
					$data = array(
							'table_name'=>$tableName,
							'display_name'=>$post['displayName'],
							'field_type'=>$post['udfType']
							);
						
					$this->db->insert('udf',$data);

                    if ($this->db->trans_status() === FALSE)
					{
                        $this->db->trans_rollback();	
						$this->session->set_flashdata('error', 'There was a problem with inserting the updates into the udf table.');
						redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }
					else
					{
							$msg = array(
							'status'=>'success',
							'msg'=>'Successfully created the new user defined field.'
							);
							echo json_encode($msg);
						$this->db->trans_commit();
					}
                } else {
                    $this->session->set_flashdata('error', 'That UDF name is already in use.');
					redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }
			} 
			elseif ($post['udfType'] == 3)
			{
				//start the transaction
				$this->db->trans_begin();
				
                // First we add a new column in the data table
				$fields = array(
						$tableName => array(
						'type' => 'varchar',
						'CONSTRAINT'=>'255',
						'AFTER'=>'category'
						)
					);
				$this->dbforge->add_column('documents', $fields);
				
                if ($this->db->trans_status() === FALSE)
				{
                    $this->db->trans_rollback();	
                    $this->session->set_flashdata('error', 'There was a problem altering the documents table');
					redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }

					$data = array(
							'table_name'=>$tableName,
							'display_name'=>$post['displayName'],
							'field_type'=>$post['udfType']
							);
						
				$this->db->insert('udf',$data);
			
                if ($this->db->trans_status() === FALSE)
				{
                    $this->db->trans_rollback();	                                
                    $this->session->set_flashdata('error', 'There was a problem adding the new data to the UDF table.');
					redirect($_SERVER['HTTP_REFERER']);
                    exit;
                }
				else
				{
					$msg = array(
					'status'=>'success',
					'msg'=>'Successfully created the new user defined field.'
					);
					echo json_encode($msg);
					$this->db->trans_commit();
				}
            }
        } 
        else
        {
           $this->session->set_flashdata('error', 'That UDF name is already in use.');
					redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    public function udfFunctionsDeleteUdf($id)
    {		
		$data = $this->getUdfData($id);
		$this->load->dbforge();		

        // If we are deleting a sub-select, we have two entries to delete
        // , a _primary, and a _secondary
        if(isset($data[0]->field_type) && $data[0]->field_type == 4)
		{

            foreach (array('primary', 'secondary') as $loop) 
			{				
				$this->db->trans_start();				
				
				$this->db->where('id',$data[0]->id)
								->delete('udf');

				$this->dbforge->drop_column('documents',"{$data[0]->table_name}_{$loop}");

                $this->dbforge->drop_table("{$data[0]->table_name}_{$loop}",TRUE);
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					$msg = array(
					'status'=>'error',
					'msg'=>'There was an error trying to delete user defined field, no changes were made.'
					);					
				}
				else{
					$msg = array(
					'status'=>'success',
					'msg'=>'Successfully deleted the user defined field and all of its database tables.'
					);
									
				}
            }
			echo json_encode($msg);	
        } else {
			$this->db->trans_start();
			
			$this->db->where('id',$data[0]->id)
								->delete('udf');
			
			$this->dbforge->drop_column('documents',$data[0]->table_name);

            $this->dbforge->drop_table($data[0]->table_name,TRUE);			
			
			$this->db->trans_complete();
			
				if ($this->db->trans_status() === FALSE)
				{
					$msg = array(
					'status'=>'error',
					'msg'=>'There was an error trying to delete user defined field, no changes were made.'
					);
					echo json_encode($msg);
				}
				else{
					$msg = array(
					'status'=>'success',
					'msg'=>'Successfully deleted the user defined field and all of its database tables.'
					);
					echo json_encode($msg);					
				}
			
        }
		
    }

    public function udfFunctionsSearchOptions()
    {

        $query = "SELECT table_name,field_type,display_name FROM {$GLOBALS['CONFIG']['db_prefix']}udf ORDER BY id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row)
        {
            echo '<option value="'.$row[2].'">'.$row[2].'</option>';
        }
    }

    /**
     * Perform search on UDF fields
     * @param string $where
     * @param string $query_pre
     * @param string $query
     * @param stting $equate
     * @param string $keyword
     * @return array
     */
    public function udfFunctionsSearch($where, $query_pre, $query, $equate, $keyword)
    {
        $lookup_query = "SELECT table_name,field_type FROM {$GLOBALS['CONFIG']['db_prefix']}udf WHERE display_name = :display_name ";
        $stmt = $pdo->prepare($lookup_query);
        $stmt->execute(array(
            ':display_name' => $where
        ));
        $row = $stmt->fetch();

        if ($row[1] == 1 || $row[1] == 2 || $row[1] == 4)
        {
            $query_pre .= ', ' . $row[0];
            $query .= $row[0] . '.value' . $equate . '\'' . $keyword . '\'';
            $query .= ' AND d.' . $row[0] . ' = ' . $row[0] . '.id';
        }
        elseif ($row[1] == 3)
        {           
            $query .= $row[0] . $equate . '\'' . $keyword . '\'';
        }

        return array($query_pre,$query);
    }
}