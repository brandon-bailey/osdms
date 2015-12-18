<?php

Class Delete_Model extends CI_Model {

	public function deleteFile($fileId) {
		$this->load->helper('file');
		$fileDataObj = new Document_Model($fileId);

		$userPermObj = new User_Perms_Model($this->session->id);

		// all ok, proceed!
		if (!is_dir($this->config->item('archiveDir'))) {
			// Make sure directory is writeable
			if (!mkdir($this->config->item('archiveDir'), 0775)) {
				$error = array(
					'status' => 'error',
					'msg' => 'We could not create the Archive Directory',
				);
				return json_encode($error);
				exit;
			}
		}
		if ($userPermObj->canAdmin($fileId)) {
			$location = $fileDataObj->getLocation();
			$baseName = $fileDataObj->getBaseName();
			$ext = $fileDataObj->getExt();
			$fileDataObj->temp_delete();

			$fileContent = file_get_contents($this->config->item('dataDir') . $location);
			if (!write_file($this->config->item('archiveDir') . $location, $fileContent)) {
				$error = array(
					'status' => 'error',
					'msg' => 'Unable to create the archived file.',
				);
				return json_encode($error);
				exit;
			} else {
				unlink($this->config->item('dataDir') . $location);
			}
		} else {
			$error = array(
				'status' => 'error',
				'msg' => 'You do not have admin priviledges for this file.',
			);
			return json_encode($error);
			exit;
		}
		AccessLog_model::addLogEntry($fileId, 'X');
		$msg = array(
			'status' => 'success',
			'msg' => 'File was successfully archived',
		);
		return json_encode($msg);
	}

	public function unDeleteFile($fileId = NULL) {
		if (isset($fileId) && $fileId !== NULL) {
			$this->load->helper('file');
			$fileObj = new Document_Model($fileId);
			$fileObj->undelete();
			$location = $fileObj->getLocation();
			$fileContent = file_get_contents($this->config->item('archiveDir') . $location);

			if (!write_file($this->config->item('dataDir') . $location, $fileContent)) {
				$error = array(
					'status' => 'error',
					'msg' => 'There was a problem moving the file back to the main directory.',
				);
				return json_encode($error);
			} else {
				unlink($this->config->item('archiveDir') . $location);
				$msg = array(
					'status' => 'success',
					'msg' => 'This file was successfully restored to the primary directory.',
				);
				return json_encode($error);
			}
		} else {
			$error = array(
				'status' => 'error',
				'msg' => 'You must pass a valid file id number in order to un-delete it.',
			);
			return json_encode($error);
		}
	}

	public function permDeleteFiles($fileId) {
		$this->load->helper('file');
		$userPermObj = new User_Perms_Model($this->session->id);

		if (!$userPermObj->userObj->isRoot()) {
			$error = array(
				'status' => 'error',
				'msg' => 'You do not have permission to delete this file',
			);
			return json_encode($error);
			exit;
		}
		// all ok, proceed!
		if (isset($fileId)) {
			if ($userPermObj->canAdmin($fileId)) {
				$fileObj = new Document_Model($fileId);
				$location = $fileObj->getLocation();

				// delete from db
				$data = array('id' => $fileId);
				$this->db->delete('documents', $data);
				$this->db->delete('log', $data);

				$data = array('fid' => $fileId);
				$this->db->delete('dept_perms', $data);
				$this->db->delete('user_perms', $data);
				$realName = $fileObj->getBaseName();

				$ext = $fileObj->getExt();

				if (is_file($this->config->item('archiveDir') . $location)) {
					unlink($this->config->item('archiveDir') . $location);
				}

				if (is_file($this->config->item('dataDir') . 'pdf/' . $realName . '.pdf')) {
					unlink($this->config->item('dataDir') . 'pdf/' . $realName . '.pdf');
				}

				if (is_file($this->config->item('dataDir') . 'thumbnails/' . $realName . '.png')) {
					unlink($this->config->item('dataDir') . 'thumbnails/' . $realName . '.png');
				}
				if ($ext == 'docx') {
					if (is_file($this->config->item('archiveDir') . $realName . '.odt')) {
						unlink($this->config->item('archiveDir') . $realName . '.odt');
					}
					if (is_file($this->config->item('archiveDir') . $realName . '.html')) {
						unlink($this->config->item('archiveDir') . $realName . '.html');
					}
				}

				if (is_dir($this->config->item('revisionDir') . $fileId . '/')) {
					delete_files($this->config->item('revisionDir') . $fileId . '/', TRUE);
				}
				return true;
			}
		}
		return false;
	}

	public function getArchivedFiles() {
		$query = $this->db->select('id')
			->where('publishable', 2)
			->get('documents');
		$userPerms = new Userpermission_Model($this->uid);
		$listStatus = $this->globalFunctions->listFiles($query->result_array(), $userPerms, $this->config->item('archiveDir'), TRUE);
		if ($listStatus !== -1) {
			return $listStatus;
		}
	}

	public function getRejectedFiles() {
		if ($this->session->admin) {
			$fileIdArray = $this->userObj->getAllRejectedFileIds();
		} else {
			$fileIdArray = $this->userObj->getRejectedFileIds();
		}

		$userPerms = new Userpermission_Model();
		$listStatus = $this->globalFunctions->listFiles($fileIdArray, $userPerms, $this->config->item('dataDir'), TRUE);

		if ($listStatus !== -1) {
			return $listStatus;
		}
	}

}
