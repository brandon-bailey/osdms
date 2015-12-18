<?php
Class Chart_Model extends CI_Model {

	public function listFiles($fileIdArray, $userPermsObj, $dataDir, $showCheckBox = FALSE, $rejectpage = FALSE) {
		if (sizeof($fileIdArray) == 0 OR !isset($fileIdArray[0])) {
			echo '<div class="row"><i class="fa fa-exclamation-triangle fa-2x"></i>No Files Found</div>';
			return -1;
		}
		foreach ($fileIdArray as $fileid) {
			if (is_array($fileid)) {
				foreach ($fileid as $file) {

					$fileObj = new Document_Model($file);
					$createdDate = $this->globalFunctions->fixDate($fileObj->getCreatedDate());
					$deptName = $fileObj->getDepartmentName();
					$realName = $fileObj->getRealname();
					$location = $fileObj->getLocation();
					$fileExt = $fileObj->getExt();

					//Get the file size in bytes.
					$fileSize = $this->globalFunctions->displayFilesize($dataDir . $location);

					$size = array('B', 'MB', 'KB', 'K', 'GB', 'M');
					$repSize = ('');
					$fileSizeNoStr = str_ireplace($size, $repSize, $fileSize);

					$fileListArr[] = array(
						'id' => $file,
						'fileName' => $realName,
						'createdDate' => $createdDate,
						'deptName' => $deptName,
						'fileSize' => $fileSizeNoStr,
						'rejectPage' => $rejectpage,
						'location' => $location,
						'ext' => $fileExt,
					);
				}
			}
		}
		return json_encode($fileListArr);
	}

	/**
	 *Counts the number of files uploaded by date
	 */
	public function fileCount() {
		$this->db->select('DATE(created) as date, COUNT(*) as cnt');
		$this->db->group_by('date');
		$this->db->order_by('date', 'desc');
		$this->db->limit(5);
		$query = $this->db->get('documents');

		if ($query->num_rows() > 0) {
			$files = array();
			foreach ($query->result() as $row) {
				$files[] = array(
					'date' => $row->date,
					'count' => $row->cnt,
				);
			}
			echo json_encode($files);
		} else {
			$msg = array(
				'status' => 'error',
				'msg' => 'There were no files to gather data on.',
			);
			echo json_encode($msg);
			exit;
		}
	}

	/**
	 *Counts the number of files by status
	 */
	public function fileCountStatus() {
		$this->db->select('id,publishable,COUNT(*) as cnt');
		$this->db->group_by('publishable');
		$query = $this->db->get('documents');

		if ($query->num_rows() > 0) {
			$status = array();
			foreach ($query->result() as $row) {
				switch ($row->publishable) {
				case "-1":
					$statcode = "Rejected";
					break;
				case "0":
					$statcode = "Pending Review";
					break;
				case "1":
					$statcode = "Active";
					break;
				case "2":
					$statcode = "Archived";
					break;
				default:
					$statcode = "Undefined";
					break;
				}
				$status[] = array(
					'status' => $statcode,
					'count' => $row->cnt,
				);
			}
			echo json_encode($status);
		} else {
			$msg = array(
				'status' => 'error',
				'msg' => 'There were no files to gather data on.',
			);

			echo json_encode($msg);
			exit;
		}
	}

	/**
	 *Counts the number of files uploaded by department
	 */
	public function fileCountDept() {
		$this->db->select('id,department,COUNT(*) as cnt');
		$this->db->group_by('department');
		$query = $this->db->get('documents');

		if ($query->num_rows() > 0) {
			$dept = array();
			foreach ($query->result() as $row) {
				$fileObj = new Document_Model($row->id);
				$department = $fileObj->getDepartmentName();
				$dept[] = array(
					'department' => $department,
					'count' => $row->cnt,
				);
			}
			echo json_encode($dept);
		} else {
			$msg = array(
				'status' => 'error',
				'msg' => 'There were no files to gather data on.',
			);
			echo json_encode($msg);
			exit;
		}
	}

	/**
	 *Get number of files by category
	 */
	public function fileCountCategory() {
		$this->db->select('id,category,COUNT(*) as cnt');
		$this->db->group_by('category');
		$query = $this->db->get('documents');
		if ($query->num_rows() > 0) {
			$cat = array();
			foreach ($query->result() as $row) {
				$fileObj = new Document_Model($row->id);
				$category = $fileObj->getCategoryName();

				$cat[] = array(
					'category' => $category,
					'count' => $row->cnt,
				);
			}
			echo json_encode($cat);
		} else {
			$msg = array(
				'status' => 'error',
				'msg' => 'There were no files to gather data on.',
			);

			echo json_encode($msg);
			exit;
		}

	}

	/**
	 *Get number of files by user
	 */
	public function fileCountOwner() {
		$this->db->select('id,owner,COUNT(*) as cnt');
		$this->db->group_by('owner');
		$query = $this->db->get('documents');

		if ($query->num_rows() > 0) {
			$own = array();
			foreach ($query->result() as $row) {
				$fileObj = new Document_Model($row->id);
				$owner = $fileObj->getOwnerName();
				$own[] = array(
					'owner' => $owner,
					'count' => $row->cnt,
				);
			}
			echo json_encode($own);
		} else {
			$msg = array(
				'status' => 'error',
				'msg' => 'There were no files to gather data on.',
			);

			echo json_encode($msg);
			exit;
		}
	}

}