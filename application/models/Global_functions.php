<?php
 class Global_functions extends CI_Model{
	 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
	}
	 
	 public function listFiles($fileIdArray, $userPermsObj, $d = NULL , $showCheckBox = FALSE, $rejectpage = FALSE)
	{
		
		if(sizeof($fileIdArray) == 0 OR !isset($fileIdArray[0]))
		{
			return -1;
		}
		
		foreach($fileIdArray as $fileid)
		{	
		if(is_array($fileid))
		{
			foreach($fileid as $file)
			{		
			$fileObj = new Document_model($file);
			$userAccessLevel = $userPermsObj->getAuthority($file,$fileObj);
			$description = $fileObj->getDescription();
			
			if ($fileObj->getStatus() == 0 && $userAccessLevel >= $this->config->item('VIEW_RIGHT'))
			{
				$lock = FALSE;
			}
			else
			{
				$lock = TRUE;
			}
			
			if ($description == '')
			{
				$description = 'No description available';
			}

			$createdDate = $this->fixDate($fileObj->getCreatedDate());
			
			if ($fileObj->getModifiedDate())
			{
				$modifiedDate = $this->fixDate($fileObj->getModifiedDate());
			}
			else 
			{
				$modifiedDate = $createdDate;
			}
			
			$fullNameArray = $fileObj->getOwnerFullName();
			$ownerName = $fullNameArray[1] . ', ' . $fullNameArray[0];
			$deptName = $fileObj->getDepartmentName();
			$realName = $fileObj->getRealname();
			$location = $fileObj->getLocation();	
			$fileExt = $fileObj->getExt();		
			$uniqueName=$fileObj->getBaseName();
			$deleteLink = $fileObj->isArchived();
			

			//Get the file size in bytes.
			if($deleteLink)
			{
				$fileSize = $this->displayFilesize($this->config->item('archiveDir'). $location);
			}
			else
			{
				$fileSize = $this->displayFilesize($this->config->item('dataDir') . $location);
			}

			
			if ($userAccessLevel >= $this->config->item('READ_RIGHT'))
			{          
				$viewLink = $this->config->item('dataDir') . $location;
			}
			else
			{
				$viewLink = 'none';
			}

			$detailsLink = site_url() . 'details/' . $file;
			$read = array($this->config->item('READ_RIGHT'), 'r');
			$write = array($this->config->item('WRITE_RIGHT'), 'w');
			$admin = array($this->config->item('ADMIN_RIGHT'), 'a');
			$rights = array($read, $write, $admin);
			
			$index_found = -1;

			for($i = sizeof($rights)-1; $i>=0; $i--)
			{
				if($userAccessLevel==$rights[$i][0])
				{
					$index_found = $i;
					$i = 0;
				}
			}

			//Found the user right, now bold every below it.  For those that matches, make them different.
			for($i = $index_found; $i>=0; $i--)
			{
				$rights[$i][1]=$rights[$i][1];
			}
			
			//For everything above it, blank out
			for($i = $index_found+1; $i<sizeof($rights); $i++)
			{
				$rights[$i][1] = '-';
			}
			$fileListArr[] = array(
					'id'=>$file,
					'viewLink'=>$viewLink,
					'detailsLink'=>$detailsLink,
					'fileName'=>$realName,
					'description'=>$description,
					'rights'=>$rights,
					'createdDate'=>$createdDate,
					'modifiedDate'=>$modifiedDate,
					'ownerName'=>$ownerName,
					'deptName'=>$deptName,
					'fileSize'=>$fileSize,
					'lock'=>$lock,				
					'fileInfo' => get_mime_by_extension($fileExt),
					'showCheckbox'=>$showCheckBox,
					'rejectPage'=>$rejectpage,
					'location'=>$location,
					'uniqueName'=>$uniqueName,
					'ext'=>$fileExt,
					'deleteLink'=>$deleteLink
			);
				}
			}
		}
		$limitReached = FALSE;
		
		if(count($fileListArr) >= 500) 
		{
			$limitReached = TRUE;
		}
		return json_encode($fileListArr);	   	     
	}
	
	function displayFilesize($file)
	{	
		if(is_file($file))
		{
			$kb=1024;
			$mb=1048576;
			$gb=1073741824;
			$tb=1099511627776;

			$size = filesize($file);

			if($size < $kb)
			{
				return $size.' B';
			}
			elseif($size < $mb)
			{
				return round($size/$kb,2).' KB';
			}
			elseif($size < $gb)
			{
				return round($size/$mb,2).' MB';
			}
			elseif($size < $tb)
			{
				return round($size/$gb,2).' GB';
			}
			else
			{
				return round($size/$tb,2).' TB';
			}
		}
		else
		{
			return 'X';
		}
	}

		public function fixDate($val)
		{
			//split it up into components
			if( $val != 0 )
			{
				$arr = explode(' ', $val);
				$timearr = explode(':', $arr[1]);
				$datearr = explode('-', $arr[0]);
				// create a timestamp with mktime(), format it with date()
				return date('d M Y (H:i)', mktime($timearr[0], $timearr[1], $timearr[2], $datearr[1], $datearr[2], $datearr[0]));
			}
			else
			{
				return 0;
			}
		}

	public function checkUserPermission($fileId, $permittableRight, $obj)
	{
		if(!$this->session->admin && $this->userObj->getAuthority($fileId, $obj) < $permittableRight)
		{
			echo 'Unable to find file.' . "\n";      
			exit;
		}
	}
}

