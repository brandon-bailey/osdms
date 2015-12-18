<?php
Class Reports_model extends CI_Model {
 
	public function __construct()
	{
		parent::__construct();   
		 $this->lang->load('access_log', 'english');
	}
	
	public function accessLogReport()
	{
		$query = $this->db->query("SELECT 
            a.*,
            d.realname,
            u.username
          FROM 
            " . $this->db->dbprefix('access_log')." a
          INNER JOIN 
            " .$this->db->dbprefix('documents') ." AS d ON a.file_id = d.id
          INNER JOIN 
            ".$this->db->dbprefix('user')." AS u ON a.user_id = u.id
        ");
	
		if($query->num_rows() === 0)
		{
			$msg = array('status'=>'error',
			'msg'=>'There are no results for the access log.'
			);
			return $msg;
			exit;
		}
	
		$actionsArray = array(
			"A" =>$this->lang->line('accesslog_file_added'),
			"B" => $this->lang->line('accesslog_reserved'),
			"C" => $this->lang->line('accesslog_reserved'),
			"V" => $this->lang->line('accesslog_file_viewed'), 
			"D" => $this->lang->line('accesslog_file_downloaded'), 
			"M" => $this->lang->line('accesslog_file_modified'), 
			"I" => $this->lang->line('accesslog_file_checked_in'), 
			"O" =>$this->lang->line('accesslog_file_checked_out'), 
			"X" => $this->lang->line('accesslog_file_deleted'), 
			"Y" => $this->lang->line('accesslog_file_authorized'), 
			"R" => $this->lang->line('accesslog_file_rejected')
		);
	
		foreach($query->result() as $row) {
			$detailsLink = base_url().'index.php/details/' . $row->file_id;
			$accessLogArray[] = array(
				'user_id' => $row->user_id,
				'file_id' => $row->file_id,
				'user_name' => $row->username,
				'realname' => $row->realname,
				'action' => $actionsArray[$row->action],
				'details_link' => $detailsLink,
				'timestamp' => $row->timestamp
			);
		}	
		return $accessLogArray;
	}
		
	public function fileList($fileType)
	{
		$this->load->helper('download');
		$this->load->dbutil();			
		$query = $this->db->query("SELECT 
					" . $this->db->dbprefix('documents').".realname,
					" . $this->db->dbprefix('documents').".description,
					" . $this->db->dbprefix('documents').".publishable,
					" . $this->db->dbprefix('documents').".status,    
					" . $this->db->dbprefix('documents').".id,
					" . $this->db->dbprefix('user').".username,
					" . $this->db->dbprefix('log').".revision,
					CASE " . $this->db->dbprefix('documents').".publishable
						WHEN -1 THEN 'Rejected'
						WHEN 0 THEN 'Un-approved'
						WHEN 1 THEN 'Active'
						WHEN 2 THEN 'Archived'
						WHEN -2 THEN 'Deleted'
					END AS 'Publishing Status',
					CASE " . $this->db->dbprefix('documents').".status
						WHEN 1 THEN 'Checked Out'
						WHEN 0 THEN 'Not Checked Out'
					END AS 'Check-Out Status'
				  FROM 
					" . $this->db->dbprefix('documents')." 
				  LEFT JOIN " . $this->db->dbprefix('user')."
					ON " . $this->db->dbprefix('user').".id = " . $this->db->dbprefix('documents').".owner
				  LEFT JOIN " . $this->db->dbprefix('log')."
					  ON " . $this->db->dbprefix('log').".id = " . $this->db->dbprefix('documents').".id
						ORDER BY id
						");  
					
			switch($fileType){				
				case 'csv':
					return $this->dbutil->csv_from_result($query);
					break;
				case 'xml':
					$config = array (
						'root'          => 'document_list',
						'element'       => 'document',
						'newline'       => "\n",
						'tab'           => "\t"
					);					
					return $this->dbutil->xml_from_result($query,$config);
					break;	
		
			}
			
	}
}

