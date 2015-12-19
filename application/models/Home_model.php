<?php

Class Home_Model extends CI_Model {

	public function getFileList($limit = NULL, $offset = NULL) {
		$userPerms = new Userpermission_Model();

		$fileIdArray = $userPerms->getViewableFileIds($limit, $offset);

		//$fullIdArray = $userPerms->getViewableFileIds($limit);

		$fileList = $this->globalFunctions->listFiles($fileIdArray, $userPerms, $this->config->item('dataDir'), FALSE);

		$size = count($fileIdArray);
		$data = array(
			'size' => $size,
			'fileList' => $fileList,
		);
		return $data;
	}

}
