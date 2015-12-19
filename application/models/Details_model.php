<?php

Class Details_Model extends CI_Model {

	public function getFileDetails() {

		if (strchr($this->requestId, '_')) {
			list($this->requestId, $revisionId) = explode('_', $this->requestId);
			$fileSize = $this->globalFunctions->displayFilesize($this->config->item('revisionDir') . $this->requestId . '/' . $this->requestId . '_' . $revisionId);
		}
		$fileDataObj = new Document_Model($this->requestId);
		$archived = $fileDataObj->isArchived();
		$publishable = $fileDataObj->isPublishable();
		$this->globalFunctions->checkUserPermission($this->requestId, $this->config->item('VIEW_RIGHT'), $fileDataObj);
		$userPermsObj = new User_Perms_Model();
		$userPermissionObj = new Userpermission_Model();
		$userObj = new User_Model($fileDataObj->getOwner());
		// display details - calls the parent function in functions.php
		$ownerId = $fileDataObj->getOwner();
		$category = $fileDataObj->getCategoryName();
		$ownerFullName = $fileDataObj->getOwnerFullName();
		$owner = $ownerFullName[1] . ', ' . $ownerFullName[0];
		$realName = $fileDataObj->getRealName();
		$created = $fileDataObj->getCreatedDate();
		$description = $fileDataObj->getDescription();
		$comment = $fileDataObj->getComment();
		$status = $fileDataObj->getStatus();
		$reviewer = $fileDataObj->getReviewerName();
		$location = $fileDataObj->getLocation();
		$fileExt = $fileDataObj->getExt();
		$file = $fileDataObj->getBaseName();
		$thumbnail = $fileDataObj->getThumbnail();
		$lmimetype = File_Model::mime_by_ext($fileExt);
		$viewFileLink = $this->config->item('dataDir') . $location;
		$historyLink = 'history/' . $this->requestId;
		$viewInBrowser = NULL;
		$fileUnderReview = (($publishable == -1) ? TRUE : FALSE);
		$editFileLink = NULL;

		if ($status == 0 && !$publishable && $userPermsObj->canView($this->requestId)) {
			$fileUnlocked = TRUE;
		} else {
			$fileUnlocked = FALSE;
		}

		if ($status > 0) {
			// status != 0 -> file checked out to another user. status = uid of the check-out person
			// query to find out who...
			$checkoutPersonObj = $fileDataObj->getCheckerOBJ();
			$fullName = $checkoutPersonObj->getFullName();
		}

		switch ($fileExt) {
		case 'html':
		case 'php':
			$viewInBrowser = base_url() . $this->config->item('dataDir') . 'pdf/' . $file . '.pdf';
			break;
		case 'pdf':
			$viewInBrowser = base_url() . $this->config->item('dataDir') . $location;
			break;
		case 'doc':
		case 'docx':
			$viewInBrowser = base_url() . $this->config->item('dataDir') . $file . '.pdf';
			break;
		}

		//Get the information for the files revision history
		if (!empty($revisionId)) {
			$historyResult = $fileDataObj->getRevisionHistory($revisionId);
		} else {
			$historyResult = $fileDataObj->getCurrentRevision();
		}

//get the number of revisions.
		$rows = $historyResult->num_rows();

		(array) $fileHistory = NULL;

		foreach ($historyResult->result() as $row) {
			$revision = $row->revision;

			if (is_file($this->config->item('revisionDir') . $this->requestId . '/' . $this->requestId . "_$revision" . '.' . $fileExt)) {
				$revision = '<a href="details/' . $this->requestId . "_$revision" . '"><div class="revision">' . ($revision + 1) . '</div></a>';
			}
			$fileHistory[] = array(
				'lastName' => $row->last_name,
				'firstName' => $row->first_name,
				'modifiedOn' => $row->modified_on,
				'note' => $row->note,
				'revision' => $revision,
			);
		}

		if (!is_array($fileHistory)) {
			$fileHistory[] = array(
				'lastName' => 'Info',
				'firstName' => 'No ',
				'modifiedOn' => 'No Info',
				'note' => 'No Info',
				'revision' => 'No Info',
			);
			$revision = '?';
		}

		// Lets figure out which buttons to show
		if ($status == 0 OR ($status == -1 && $fileDataObj->isOwner($this->session->id))) {
			// check if user has modify rights
			if ($userPermissionObj->getAuthority($this->requestId, $fileDataObj) >= $this->config->item('WRITE_RIGHT') && !isset($revisionId) && !$archived) {
				// if so, display link for checkout
				$checkOutLink = site_url() . 'checkout/downloadfile/' . $this->requestId;
				$accessRight = 'modify';

				switch ($fileExt) {
				case 'php':
				case 'html':
				case 'htm':
					$editFileLink = site_url() . 'editor/' . $this->requestId;
					break;
				default:
					break;
				}
			}
			if ($userPermissionObj->getAuthority($this->requestId, $fileDataObj) >= $this->config->item('ADMIN_RIGHT') && !@isset($revisionId) && !$archived) {

				if (!$archived) {
					$deleteLink = 1;
				} else {
					$deleteLink = 0;
				}
				$editLink = site_url() . 'edit/' . $this->requestId;
			}
		}

		// corrections
		if ($description == '') {
			$description = 'No description available.';
		}

		if ($comment == '') {
			$comment = 'No author comments available.';
		}

		if ($archived) {
			$fileName = $this->config->item('revisionDir') . $location;
			$fileSize = $this->globalFunctions->displayFilesize($fileName);
		} else {
			$fileName = $this->config->item('dataDir') . $location;
			if (!isset($fileSize)) {
				$fileSize = $this->globalFunctions->displayFilesize($fileName);
			}
		}
		$fileDetail = array(
			'fileUnlocked' => $fileUnlocked,
			'realName' => $realName,
			'category' => $category,
			'fileSize' => $fileSize,
			'created' => $this->globalFunctions->fixDate($created),
			'ownerEmail' => $userObj->getEmailAddress(),
			'owner' => $owner,
			'ownerFullname' => $owner,
			'description' => wordwrap($description, 50, '<br />'),
			'comment' => wordwrap($comment, 50, '<br />'),
			'revision' => $revision,
			'fileUnderReview' => $fileUnderReview,
			'reviewer' => $reviewer,
			'status' => $status,
			'location' => $location,
			'fileInfo' => $lmimetype,
			'file' => $file,
			'ext' => $fileExt,
			'checkOutLink' => $checkOutLink,
			'editLink' => $editLink,
			'editFileLink' => $editFileLink,
			'accessRight' => $accessRight,
			'fileHistory' => $fileHistory,
			'deleteLink' => $deleteLink,
			'viewInBrowser' => $viewInBrowser,
			'thumbnail' => $thumbnail,
		);

		return json_encode($fileDetail);
	}

}
