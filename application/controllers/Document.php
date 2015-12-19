<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Document extends CI_Controller
{

    public $uid;
    public $docId;

    public function __construct()
    {
        parent::__construct();
        $this->docId = $this->uri->segment(2);

    }

    public function index()
    {
        $docObj = new Document_Model($this->docId);
        $location = $docObj->getLocation();
        $fileExt = $docObj->getExt();
        $baseName = $docObj->getBaseName();

        switch ($fileExt) {
            case 'html':
            case 'php':
                $url = base_url() . $this->config->item('dataDir') . 'pdf/' . $baseName . '.pdf';
                break;

            case 'doc':
            case 'docx':
                $url = base_url() . $this->config->item('dataDir') . $baseName . '.odt';
                break;

            case 'pdf':
                $url = base_url() . $this->config->item('dataDir') . $location;
                break;
        }
        header('Location:' . base_url() . 'assets/js/viewer#' . $url);
    }
}
