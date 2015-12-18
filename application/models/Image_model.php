<?php

class Image_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$image = new \Knp\Snappy\Image($this->config->item('image_binary'));
	}

	public function newThumbnail($docId) {

		$documentObj = new Document_Model($docId);
		$fileExt = $documentObj->getExt();
		$docName = $documentObj->getLocation();
		switch ($fileExt) {
		case '.html':
		case '.php':
		case '.htm':
			//create PDF from HTML
			$html = $this->load->file(FCPATH . $this->config->item('dataDir') . $file['newName'], TRUE);
			$newPdf = ($this->config->item('dataDir') . 'pdf/' . $file['rawName'] . '.pdf');
			$options = array(
				'viewport-size' => '1250',
				'load-error-handling' => 'skip',
			);

			$pdf->generateFromHtml($html, $newPdf, $options, TRUE);

			//create thumbnail from HTML
			$options = array(
				'format' => 'jpg',
				'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
				'load-error-handling' => 'skip',
			);

			$newImage = ($this->config->item('dataDir') . 'thumbnails/' . $file['rawName'] . '.jpg');
			$image->generateFromHtml($html, $newImage, $options, TRUE);
			break;
		case '.png':
		case '.jpg':
			$config['source_image'] = $this->config->item('dataDir') . $file['newName'];
			$config['new_image'] = $this->config->item('dataDir') . 'thumbnails/' . $file['newName'];
			$config['maintain_ratio'] = TRUE;
			$config['height'] = 200;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			break;
		default:
			break;
		}
	}

}