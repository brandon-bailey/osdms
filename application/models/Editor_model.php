<?php

Class Editor_Model extends CI_Model {

	public function saveModuleChanges($data) {
		$this->load->helper('file');
		$modData = new Module_Model($data['module']);
		$category = $modData->getCategory();
		$location = $modData->getLocation();
		$baseName = $modData->getBaseName();

		if (!write_file($this->config->item('moduleDir') . $category . '/files/' . $location, $data['html'])) {
			$msg = array(
				'status' => 'error',
				'msg' => 'There was an error writing the update to the module to a file.',
			);
			echo json_encode($msg);
			exit;
		} else {
			$this->image->setBinary($this->config->item('image_binary'));
			$options = array(
				'format' => 'jpg',
				'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
				'load-error-handling' => 'skip',
			);
			$newImage = ($this->config->item('moduleDir') . $category . '/files/thumbnails/' . $baseName . '.jpg');
			$this->image->generateFromHtml($data['html'], $newImage, $options, TRUE);

			$config['source_image'] = $newImage;
			$config['maintain_ratio'] = TRUE;
			$config['height'] = 200;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$this->updateDocument($data['docId']);
			$msg = array(
				'status' => 'success',
				'msg' => 'We successfully created the new module, and inserted the data into the database.',
			);
			echo json_encode($msg);
		}
	}

	public function updateDocument($id) {
		$docObj = new Document_Model($id);
		$location = $docObj->getLocation();
		$baseName = $docObj->getBaseName();
		$html = $this->load->file(FCPATH . $this->config->item('dataDir') . $location, TRUE);

		$this->image->setBinary($this->config->item('image_binary'));
		$options = array(
			'format' => 'jpg',
			'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
			'load-error-handling' => 'skip',
		);
		$newImage = ($this->config->item('dataDir') . 'thumbnails/' . $baseName . '.jpg');
		$this->image->generateFromHtml($html, $newImage, $options, TRUE);

		$options = array(
			'viewport-size' => '1250',
			'load-error-handling' => 'skip',
		);
		$newPdf = ($this->config->item('dataDir') . 'pdf/' . $baseName . '.pdf');
		$this->pdf->setBinary($this->config->item('pdf_binary'));
		$this->pdf->generateFromHtml($html, $newPdf, $options, TRUE);

		$config['source_image'] = $newImage;
		$config['maintain_ratio'] = TRUE;
		$config['height'] = 200;
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();

	}

}
