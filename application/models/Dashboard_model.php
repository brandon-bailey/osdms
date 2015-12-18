<?php

Class Dashboard_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->model('global_functions', 'globalFunctions');
	}

	public function drawDashboard() {
		$userPerms = new Userpermission_Model($this->uid);
		$fileIdArray = $userPerms->getViewableFileIds(TRUE);

		if ($fileIdArray !== NULL) {
			$chartData = $this->chart->listFiles($fileIdArray, $userPerms, $this->config->item('dataDir'), FALSE);
		} else {
			$chartData = NULL;
		}
		$fileCount = $this->chart->fileCount();
		$fileCountCategory = $this->chart->fileCountCategory();
		$fileCountOwner = $this->chart->fileCountOwner();
		$fileCountDept = $this->chart->fileCountDept();
		$fileCountStatus = $this->chart->fileCountStatus();

		$docChartData[] = array(
			'chartData' => $chartData,
			'fileCount' => $fileCount,
			'fileCountCategory' => $fileCountCategory,
			'fileCountOwner' => $fileCountOwner,
			'fileCountDept' => $fileCountDept,
			'fileCountStatus' => $fileCountStatus,
		);

		return json_encode($docChartData, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

	}

}
