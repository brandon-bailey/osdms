<?php

class Pdf_Model extends CI_Model {
	public $pdf;
	public function __construct() {
		parent::__construct();
		$this->pdf = new \Knp\Snappy\Pdf($this->config->item('pdf_binary'));
	}

	public function newPdf($docId) {

		$documentObj = new Document_Model($docId);

		$fileExt = $documentObj->getExt();

		//The obfuscated file name, stored in the location column
		$docName = $documentObj->getLocation();

		//The docName without the file extention
		$baseName = $documentObj->getBaseName();

		switch ($fileExt) {

		case 'html':
		case 'php':
		case 'htm':
			$html = $this->load->file(FCPATH . $this->config->item('dataDir') . $docName, TRUE);
			$newPdf = (FCPATH . $this->config->item('dataDir') . 'pdf/' . $baseName . '.pdf');

			$options = array(
				'viewport-size' => '1250',
				'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
				'load-error-handling' => 'skip',
			);

			$this->pdf->generateFromHtml($html, $newPdf, $options, TRUE);

			$msg = array(
				'status' => 'success',
				'msg' => 'Successfully created a new pdf of your file.',
			);
			echo json_encode($msg);
			break;
		case 'png':
		case 'jpg':
		case 'gif':
		case 'tif':
		case 'bmp':
			$html = '<html><body><div class="container"><img class="img-responsive" src=" ' . FCPATH . $this->config->item('dataDir') . $docName . ' "></div></body></html>';
			$newPdf = (FCPATH . $this->config->item('dataDir') . 'pdf/' . $baseName . '.pdf');

			$options = array(
				'viewport-size' => '1250',
				'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
				'load-error-handling' => 'skip',
			);
			$this->pdf->generateFromHtml($html, $newPdf, $options, TRUE);

			$msg = array(
				'status' => 'success',
				'msg' => 'Successfully created a new pdf of your file.',
			);
			echo json_encode($msg);
			break;
		default:
			$msg = array(
				'status' => 'error',
				'msg' => 'This filetype is currently not supported for making pdfs.',
			);
			echo json_encode($msg);
			break;
		}
	}

}