<?php

use Knp\Snappy\Image;
use Knp\Snappy\Pdf;

class Builder_Model extends CI_Model
{

    public function saveDocument($data)
    {
        $this->load->helper('file');
        $docNameNew = uniqid('', true);
        $docName = $docNameNew . '.php';
        //add slashes to file path
        $path = addslashes(FCPATH);
        $header = '<?php include("' . $path . $this->config->item('dataDir') . 'includes/header.php"); ?>';
        $footer = '<?php include("' . $path . $this->config->item('dataDir') . 'includes/footer.php"); ?>';

        if (!write_file($this->config->item('dataDir') . $docName, $header, 'w')) {
            $msg = array(
                'status' => 'error',
                'msg' => 'There was an error writing the new document to a file.',
            );
            echo json_encode($msg);
            exit;
        }
        foreach ($data['modules'] as $module) {
            $modData = new Module_Model($module);
            $location = $modData->getLocation();
            $cat = $modData->getCategory();

            //make sure we can load the module data successfully before creating a bogus file
            if ($location != '' && $cat != '') {
                $innerHtml = '<?php include("' . $path . $this->config->item('moduleDir') . $cat .
                 '/files/' . $location . '") ?>';
                if (!write_file($this->config->item('dataDir') . $docName, $innerHtml, 'a')) {
                    $msg = array(
                        'status' => 'error',
                        'msg' => 'There was an error writing the new document to a file.',
                    );
                    echo json_encode($msg);
                    exit;
                }
            } else {
                $msg = array(
                    'status' => 'error',
                    'msg' => 'There was an error loading the modules location and category information.',
                );
                echo json_encode($msg);
                exit;
            }
        }

        if (!write_file($this->config->item('dataDir') . $docName, $footer, 'a')) {
            $msg = array(
                'status' => 'error',
                'msg' => 'There was an error writing the new document to a file.',
            );
            echo json_encode($msg);
            exit;
        }
        $pdf = new Pdf($this->config->item('pdf_binary'));
        $image = new Image($this->config->item('image_binary'));

        $options = array(
            'format' => 'jpg',
            'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
            'load-error-handling' => 'skip',
        );
        $html = $this->load->file(FCPATH . $this->config->item('dataDir') . $docName, true);
        $newImage = ($this->config->item('dataDir') . 'thumbnails/' . $docNameNew . '.jpg');
        $image->generateFromHtml($html, $newImage, $options, true);

        $fileName = str_replace(' ', '-', strtolower($data['fileName']));
        $newPdf = ($this->config->item('dataDir') . 'pdf/' . $docNameNew . '.pdf');
        $options = array(
            'viewport-size' => '1250',
            'load-error-handling' => 'skip',
        );

        $pdf->generateFromHtml($html, $newPdf, $options, true);

        $config['source_image'] = $newImage;
        $config['maintain_ratio'] = true;
        $config['height'] = 200;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();

        if (isset($data['department']) && $data['department'] !== '') {
            $department = $data['department'];
        } else {
            $department = $this->session->department;
        }

        $modules = array();

        foreach ($data['modules'] as $module) {
            $modules[] = array(
                'id' => $module,
            );
        }

        $document = array(
            'category' => $data['category'],
            'owner' => $this->session->id,
            'realname' => $fileName . '.php',
            'created' => date('Y-m-d H:i:s'),
            'description' => $data['description'],
            'status' => 0,
            'department' => $department,
            'publishable' => 0,
            'location' => $docName,
            'modules' => json_encode($modules),
        );

        $this->db->insert('documents', $document);
        $fileId = $this->db->insert_id();

        $data = array(
            'fid' => $fileId,
            'dept_id' => $department,
            'rights' => 1,
        );

        $this->db->insert('dept_perms', $data);
        $data = array(
            'fid' => $fileId,
            'uid' => $this->session->id,
            'rights' => 4,
        );

        $this->db->insert('user_perms', $data);

        $data = array(
            'id' => $fileId,
            'modified_on' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->username,
            'note' => 'Initial Import',
            'revision' => 'current',
        );

        $this->db->insert('log', $data);
        $msg = array(
            'status' => 'success',
            'msg' => 'We successfully created the new document, and inserted the data into the database.',
        );

        echo json_encode($msg);
    }

    public function saveModule($data)
    {
        $this->load->helper('file');
        $docNameNew = uniqid('', true);
        $docName = $docNameNew . '.php';
        $category = $data['category'];

        if (!write_file($this->config->item('moduleDir') . $category . '/files/' . $docName, $data['html'])) {
            $msg = array(
                'status' => 'error',
                'msg' => 'There was an error writing the new module to a file.',
            );
            echo json_encode($msg);
            exit;
        } else {
            $image = new Image($this->config->item('image_binary'));

            $options = array(
                'format' => 'jpg',
                'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
                'load-error-handling' => 'skip',
            );
            $newImage = ($this->config->item('moduleDir') . $category . '/files/thumbnails/' . $docNameNew . '.jpg');
            $image->generateFromHtml($data['html'], $newImage, $options, true);

            $config['source_image'] = $newImage;
            $config['maintain_ratio'] = true;
            $config['height'] = 200;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $module = array(
                'category' => $category,
                'owner' => $this->session->id,
                'description' => $data['description'],
                'created' => date('Y-m-d H:i:s'),
                'publishable' => 1,
                'location' => $docName,
            );
            $this->db->insert('modules', $module);

            $msg = array(
                'status' => 'success',
                'msg' => 'We successfully created the new module, and inserted the data into the database.',
            );
            echo json_encode($msg);
        }
    }

    public function getUnpublishedModules()
    {
        if (!$unpublishedModules = $this->cache->get('unpublishedModules')) {
            $query = $this->db->select()
                ->where('owner', $this->session->id)
                ->where('publishable', -1)
                ->get('modules');

            $unpublishedModules = array();
            foreach ($query->result() as $row) {
                $modData = new Module_Model($row->id);
                $loc = $modData->getLocation();
                $file = $modData->getBaseName();
                $category = $modData->getCategory();
                $thumbnail = $this->checkThumbnail($category, $file);
                $unpublishedModules[] = array(
                    'id' => $row->id,
                    'owner' => $modData->getOwner(),
                    'fileLink' => $this->config->item('moduleDir') . $category . '/files/' . $loc,
                    'description' => $modData->getDescription(),
                    'thumbnail' => $thumbnail,
                );
            }

            $this->cache->save('unpublishedModules', $unpublishedModules, 600);

        }

        return json_encode($unpublishedModules);
    }

    public function getDraftModules()
    {
        $query = $this->db->select()
            ->where('owner', $this->session->id)
            ->where('publishable', 0)
            ->get('modules');
        $data = array();
        foreach ($query->result() as $row) {
            $modData = new Module_Model($row->id);
            $loc = $modData->getLocation();
            $file = $modData->getBaseName();
            $category = $modData->getCategory();
            $thumbnail = $this->checkThumbnail($category, $file);
            $data[] = array(
                'id' => $row->id,
                'owner' => $modData->getOwner(),
                'fileLink' => $this->config->item('moduleDir') . $category . '/files/' . $loc,
                'description' => $modData->getDescription(),
                'thumbnail' => $thumbnail,
            );
        }
        return json_encode($data);
    }

    public function checkThumbnail($category, $file)
    {
        if (is_file($this->config->item('moduleDir') . $category . '/files/thumbnails/' . $file . '.jpg')) {
            return base_url() . $this->config->item('moduleDir') . $category . '/files/thumbnails/' . $file . '.jpg';
        } elseif (is_file($this->config->item('moduleDir') . $category . '/files/thumbnails/' . $file . '.png')) {
            return base_url() . $this->config->item('moduleDir') . $category . '/files/thumbnails/' . $file . '.png';
        } else {
            return base_url() . 'assets/images/no-image-available.jpg';
        }
    }

    public function getModules($category)
    {
        $query = $this->db->select()
            ->where('category', $category)
            ->where('publishable', 1)
            ->get('modules');
        $data = array();
        foreach ($query->result() as $row) {
            $modData = new Module_Model($row->id);
            $loc = $modData->getLocation();
            $file = $modData->getBaseName();
            $thumbnail = $this->checkThumbnail($category, $file);

            $data[] = array(
                'id' => $row->id,
                'owner' => $modData->getOwner(),
                'fileLink' => $this->config->item('moduleDir') . $category . '/files/' . $loc,
                'description' => $modData->getDescription(),
                'thumbnail' => $thumbnail,
            );
        }
        return json_encode($data);
    }

    public function insertNewProject($data)
    {
        $pName = $data['projectName'];
        if ($pName) {
            $query = $this->db->select('name')
                ->where('name', $pName)
                ->get('project');

            if ($query->num_rows() > 0) {
                $msg = array(
                    'status' => 'error',
                    'msg' => 'The project name ' . $pName . ' already exists.',
                );
                echo json_encode($msg);
            } else {
                $data = array(
                    'name' => $pName,
                    'date' => date('Y-m-d H:i:s'),
                );

                $this->db->insert('project', $data);

                if ($this->db->affected_rows() == 1) {
                    $msg = array(
                        'status' => 'success',
                        'msg' => 'Succesfully created the new project ' . $pName,
                    );

                    echo json_encode($msg);
                }

            }
        }

    }
}
