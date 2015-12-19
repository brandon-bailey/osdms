<?php

class Image_Model extends CI_Model
{
    public $image;
    public function __construct()
    {
        parent::__construct();
        $this->image = new \Knp\Snappy\Image($this->config->item('image_binary'));
    }

    public function newThumbnail($docId)
    {

        $documentObj = new Document_Model($docId);

        $fileExt = $documentObj->getExt();

        //The obfuscated file name, stored in the location column
        $docName = $documentObj->getLocation();

        //The docName without the file extention
        $baseName = $documentObj->getBaseName();

        switch ($fileExt) {

            case 'pdf':
                $url = base_url() . $this->config->item('dataDir') . $docName;
                $newImage = ($this->config->item('dataDir') . 'thumbnails/' . $baseName . '.jpg');

                if (extension_loaded('imagick')) {
                    //create a thumbnail from the screenshot
                    $thumb = new Imagick($url . [0]);
                    $thumb->thumbnailImage(400, 0);
                    $thumb->writeImage($newImage);
                    $msg = array(
                    'status' => 'success',
                    'msg' => 'Thumbnail was successfully created.',
                    );
                    echo json_encode($msg);
                } else {
                    $msg = array(
                    'status' => 'error',
                    'msg' => 'You must have ImageMagick installed to convert a pdf to thumbnail image.',
                    );
                    echo json_encode($msg);
                }
                break;
            case 'html':
            case 'php':
            case 'htm':
                //create PDF from HTML
                $html = $this->load->file(FCPATH . $this->config->item('dataDir') . $docName, true);

                //create thumbnail from HTML
                $options = array(
                'format' => 'jpg',
                'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
                'load-error-handling' => 'skip',
                );

                $newImage = ($this->config->item('dataDir') . 'thumbnails/' . $baseName . '.jpg');
                $this->image->generateFromHtml($html, $newImage, $options, true);
                $msg = array(
                'status' => 'success',
                'msg' => 'Successfully created a thumbnail of your file.',
                );
                echo json_encode($msg);
                break;
            case 'png':
            case 'jpg':
                $config['source_image'] = $this->config->item('dataDir') . $docName;
                $config['new_image'] = $this->config->item('dataDir') . 'thumbnails/' . $docName;
                $config['maintain_ratio'] = true;
                $config['height'] = 200;
                $this->load->library('image_lib', $config);

                if (!$this->image_lib->resize()) {
                    $msg = array(
                    'status' => 'error',
                    'msg' => 'There was an error trying to resize the image.',
                    );
                    echo json_encode($msg);
                } else {
                    $msg = array(
                    'status' => 'success',
                    'msg' => 'Successfully created a thumbnail of your image.',
                    );
                    echo json_encode($msg);
                }
                break;
            default:
                $msg = array(
                'status' => 'error',
                'msg' => 'This filetype is currently not supported for making thumbnails.',
                );
                echo json_encode($msg);
                break;
        }
    }
}
