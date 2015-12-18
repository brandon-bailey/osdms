<?php

Class Checkin_Model extends CI_Model {

	public function getFileInfo() {
		$fileDataObj = new Document_Model($id);
		$result = $fileDataObj->getCheckedOutFileInfo($this->uid);
	}

	public function checkInFile(array $data = null) {
		$id = $data['formData']['id'];
		$fileDataObj = new Document_Model($id);
		$location = $fileDataObj->getLocation();

		if ($fileDataObj->getError() == '' && $fileDataObj->getStatus() == $this->uid) {
			//look to see how many revision are there
			$result = $fileDataObj->getTotalRevisions();
			$revisionNumber = count($result);

			// if revision dir not available, create it
			if (!is_dir($this->config->item('revisionDir'))) {
				if (!mkdir($this->config->item('revisionDir'), 0775)) {
					$error = array(
						'status' => 'error',
						'msg' => 'Could not create the Revision Directory',
					);
					echo json_encode($error);
					exit;
				}
			}

			//creates the revision directory folder for the specific file being revised
			if (!is_dir($this->config->item('revisionDir') . $id)) {
				if (!mkdir($this->config->item('revisionDir') . $id, 0775)) {
					$error = array(
						'status' => 'error',
						'msg' => 'Could not create the Revision Directory ' . $this->config->item('revisionDir') . $id,
					);
					echo json_encode($error);
					exit;
				}
			}

			//creates the revision directory pdf folder for the specific file being revised
			if (!is_dir($this->config->item('revisionDir') . $id . '/pdf')) {
				if (!mkdir($this->config->item('revisionDir') . $id . '/pdf', 0775)) {
					$error = array(
						'status' => 'error',
						'msg' => 'Could not create the Revision Directory ' . $this->config->item('revisionDir') . $id . '/pdf',
					);
					echo json_encode($error);
					exit;
				}
			}

			//creates the revision directory thumbnail folder for the specific file being revised
			if (!is_dir($this->config->item('revisionDir') . $id . '/thumbnails')) {
				if (!mkdir($this->config->item('revisionDir') . $id . '/thumbnails', 0775)) {
					$error = array(
						'status' => 'error',
						'msg' => 'Could not create the Revision Directory ' . $this->config->item('revisionDir') . $id . '/thumbnails',
					);
					echo json_encode($error);
					exit;
				}
			}

			$fileExt = $fileDataObj->getExt();
			$baseName = $fileDataObj->getBaseName();
			$fileName = $this->config->item('dataDir') . $location;
			$pdf = $this->config->item('dataDir') . 'pdf/' . $baseName . '.pdf';
			$thumb = $this->config->item('dataDir') . 'thumbnails/' . $baseName . '.png';
			$revPdf = $this->config->item('revisionDir') . $id . '/pdf/' . $id . '_' . ($revisionNumber - 1) . '.pdf';
			$revThumb = $this->config->item('revisionDir') . $id . '/thumbnails/' . $id . '_' . ($revisionNumber - 1) . '.png';

/*if there is a pdf copy the pdf to the appropriate
 *revision directory and then delete old pdf
 */
			if (file_exists($pdf)) {
				if (!copy($pdf, $revPdf)) {
					$error = array(
						'status' => 'error',
						'msg' => 'There was an error copying  ' . $pdf . ' to ' . $revPdf,
					);
					echo json_encode($error);
				} else {
					unlink($pdf);
				}
			}

/*if there is a thumbnail copy the thumbnail to the
 *appropriate revision directory and delete old thumbnail
 */
			if (file_exists($thumb)) {
				if (!copy($thumb, $revThumb)) {
					$error = array(
						'status' => 'error',
						'msg' => 'There was an error copying  ' . $thumb . ' to ' . $revThumb,
					);
					echo json_encode($error);
				} else {
					unlink($thumb);
				}
			}

			//read and close
			$fileHandler = fopen($fileName, "r");
			$fileContent = fread($fileHandler, filesize($fileName));
			fclose($fileHandler);

			//write and close
			$fileHandler = fopen($this->config->item('revisionDir') . $id . '/' . $id . '_' . ($revisionNumber - 1) . '.' . $fileExt, "w");
			fwrite($fileHandler, $fileContent);
			fclose($fileHandler);

			// all OK, proceed!
			$userName = $this->userObj->getUserName();

			//update revision log set the current revision to the next number
			$fileDataObj->updateCurrentRevision($revisionNumber);

			//add a new revision and set to current
			$fileDataObj->insertNewRevision($userName, $data['formData']['note']);

			//complete the file check in process
			$fileDataObj->checkIn($publishable, $data['fileData']['file_name']);

			// rename and save file
			if (!copy($data['fileData']['full_path'], $this->config->item('dataDir') . $location)) {
				$error = array(
					'status' => 'error',
					'msg' => 'We were unable to successfully copy the checked in file to the file directory',
				);
				echo json_encode($error);
			} else {
				unlink($data['fileData']['full_path']);
				$msg = array(
					'status' => 'success',
					'msg' => 'We successfully uploaded the checked in file, and create a revision directory for the previous version.',
				);
				echo json_encode($msg);
			}

			AccessLog_Model::addLogEntry($id, 'I');
		}

	}

}
