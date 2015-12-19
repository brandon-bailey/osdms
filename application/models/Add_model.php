<?php

class Add_Model extends CI_Model
{


    public $email;

    public function __construct()
    {
        parent::__construct();

        $this->email = new PHPMailer;
        $this->load->model('Email_Model', 'emailModel');
    }
/*
| -------------------------------------------------------------------------
| loadData() function
| -------------------------------------------------------------------------
|
|   This function gathers the required information for submitting a new
|   document.
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|   To be completed...
|
|
 */
    public function loadData()
    {
        $currentUserDept = $this->session->department;

        //CHM - Pull in the sub-select values

        if (!$tName = $this->cache->get('udfFields')) {
            $query = $this->db->select('table_name')
                ->where('field_type', 4)
                ->get('udf');
            $tName = array();
            foreach ($query->result() as $data) {
                $explodeV = explode('_', $data->table_name);
                $tName[] = $explodeV[2];
                $i++;
            }

            $this->cache->save('udfFields', $tName, 600);
        }

        // We need to set a form value for the current user so that
        // they can be pre-selected on the form

        $availUsers = User_Model::getAllUsers();

        $usersArray = array();

        foreach ($availUsers as $availUser) {
            if ($availUser->id == $this->session->id) {
                $availUser->selected = 'checked';
            } else {
                $availUser->selected = '';
            }
            array_push($usersArray, $availUser);
        }

        // We need to set a form value for the current department so that
        // it can be pre-selected on the form

        $availDepartments = Department_Model::getAllDepartments();

        $departmentsArray = array();
        foreach ($availDepartments as $availDepartment) {
            if ($availDepartment->id == $currentUserDept) {
                $availDepartment->selected = 'checked';
            } else {
                $availDepartment->selected = '';
            }
            array_push($departmentsArray, $availDepartment);
        }

        $availCategories = Category_Model::getAllCategories();

        $catsArray = array();

        foreach ($availCategories as $availCategory) {
            array_push($catsArray, $availCategory);
        }
        //////Populate department perm list/////////////////
        $deptPermsArray = array();
        foreach ($departmentsArray as $dept) {
            $availDeptPerms = new stdClass();
            $availDeptPerms->name = $dept->name;
            $availDeptPerms->id = $dept->id;
            array_push($deptPermsArray, $availDeptPerms);
        }

        $data = array(
            'tName' => $tName,
            'availUsers' => $usersArray,
            'allDepartments' => $availDepartments,
            'deptPerms' => $departmentsArray,
            'availCategories' => $catsArray,
        );
        return json_encode($data);
    }
    /*
        | -------------------------------------------------------------------
        | addDocuments() functions
        | -------------------------------------------------------------------
        | This function processes the uploaded documents and
        |   then uploads their meta data to the database.
        |
        |
        | -------------------------------------------------------------------
        | EXPLANATION OF VARIABLES
        | -------------------------------------------------------------------
        |
        |   $fileInfo    The form data submitted by the ajax function
        |   To be completed...
        |
	*/

    public function addDocuments($fileInfo)
    {

        $pdf = new \Knp\Snappy\Pdf($this->config->item('pdf_binary'));
        $image = new \Knp\Snappy\Image($this->config->item('image_binary'));

        $userP = array($fileInfo['formData']['user_permission']);
        $deptP = array($fileInfo['formData']['department_permission']);

        if ($this->session->admin && isset($fileInfo['formData']['file_department'])) {
            $currentUserDept = $fileInfo['formData']['file_department'];
        } else {
            $currentUserDept = $this->session->department;
        }

        if ($this->session->admin && isset($fileInfo['formData']['file_owner'])) {
            $ownerId = $fileInfo['formData']['file_owner'];
        } else {
            $ownerId = $this->session->id;
        }

        foreach ($fileInfo['fileData'] as $file) {
            $dbData = array(
                'category' => $fileInfo['formData']['category'],
                'owner' => $ownerId,
                'realname' => $file['originalName'],
                'created' => date('Y-m-d H:i:s'),
                'description' => strip_tags($fileInfo['formData']['description']),
                'comment' => strip_tags($fileInfo['formData']['comment']),
                'status' => 0,
                'department' => $currentUserDept,
                'default_rights' => 0,
                'publishable' => 0,
                'location' => $file['newName'],
            );
            $this->db->insert('documents', $dbData);
            $fileId = $this->db->insert_id();

            foreach ($userP as $userO) {
                foreach ($userO as $u => $p) {
                    $userPermsData = array(
                        'fid' => $fileId,
                        'uid' => $u,
                        'rights' => $p,
                    );
                    $this->db->insert('user_perms', $userPermsData);
                }
            }

            foreach ($deptP as $deptO) {
                foreach ($deptO as $dId => $p) {
                    $deptData = array(
                        'fid' => $fileId,
                        'rights' => $p,
                        'dept_id' => $dId,
                    );
                    $this->db->insert('dept_perms', $deptData);
                }
            }

            $userName = $this->session->username;
            // Add a file history entry
            $data = array(
                'id' => $fileId,
                'modified_on' => date('Y-m-d H:i:s'),
                'modified_by' => $userName,
                'note' => 'Initial Import',
                'revision' => 'current',
            );
            $this->db->insert('log', $data);

            Accesslog_Model::addLogEntry($fileId, 'A');

            switch ($file['fileExt']) {
                case '.html':
                case '.php':
                case '.htm':
                    //create PDF from HTML
                    $html = $this->load->file(FCPATH . $this->config->item('dataDir') . $file['newName'], true);
                    $newPdf = ($this->config->item('dataDir') . 'pdf/' . $file['rawName'] . '.pdf');

                    $options = array(
                    'viewport-size' => '1250',
                    'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
                    'load-error-handling' => 'skip',
                    );

                    $pdf->generateFromHtml($html, $newPdf, $options, true);

                    //create thumbnail from HTML
                    $options = array(
                    'format' => 'jpg',
                    'user-style-sheet' => FCPATH . 'assets/css/bootstrap.css',
                    'load-error-handling' => 'skip',
                    );

                    $newImage = ($this->config->item('dataDir') . 'thumbnails/' . $file['rawName'] . '.jpg');
                    $image->generateFromHtml($html, $newImage, $options, true);
                    break;
                case '.png':
                case '.jpg':
                    $config['source_image'] = $this->config->item('dataDir') . $file['newName'];
                    $config['new_image'] = $this->config->item('dataDir') . 'thumbnails/' . $file['newName'];
                    $config['maintain_ratio'] = true;
                    $config['height'] = 200;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    break;
                default:
                    break;
            }
            $this->emailPeople($fileId);
        }
        $msg = array(
            'status' => 'success',
            'msg' => 'All files were successfully uploaded.',
        );
        return json_encode($msg);
    }

    public function emailPeople($id)
    {
        $fileObj = new Document_Model($id);
        /**
         * Send out email notifications to reviewers
         */
        $fullName = $this->session->firstName . ' ' . $this->session->lastName;
        $from = $this->session->email;
        $phone = $this->session->phone;
        $department = $fileObj->getDepartment();
        $departmentName = Department_Model::getDepartmentById($department);
        $reviewerList = $this->reviewer->getReviewersForDepartment($department) ?
        $this->reviewer->getReviewersForDepartment($department) : null;
        $userList = null;
        $emailList = null;

        if (null !== $reviewerList) {
            $userList = $this->emailModel->getEmailUserObj($reviewerList) ?
             $this->emailModel->getEmailUserObj($reviewerList) : null;
        }

        if (null !== $userList) {
            $emailList = $this->emailModel->getEmailList($userList) ?
            $this->emailModel->getEmailList($userList) : null;
        }

        $newArray = array();
        $usedEmails = array();

        if (null !== $emailList) {

            foreach ($emailList as $email) {
                if (!in_array($email['email'], $usedEmails)) {
                    $usedEmails[] = $email['email'];
                    $newArray[] = $email;
                }
            }
            $emailList = $newArray;
            unset($newArray, $usedEmails);
            $comment = $fileObj->getComment();
            if ($comment === '') {
                $comment = 'No Comments.';
            }

            $date = date('M-d-Y H:i');

            $emailData = array(
                'uploader' => $fullName,
                'title' => 'Reviewer',
                'fileName' => $fileObj->getRealName(),
                'status' => 'Pending',
                'date' => date('l \t\h\e jS'),
                'msg' => 'was submitted into the document repository by',
                'email' => $from,
                'phoneNumber' => $phone,
                'department' => $departmentName[0]->name,
                'comment' => $comment,
            );

            $body = $this->load->view('emails/new_file_submission', $emailData, true);
            $subject = $fileObj->getRealName() . ' has been submitted by ' . $fullName;
            foreach ($emailList as $email) {
                if ($email['email'] != '' && $email['fullname'] != '') {

                    $this->email->from($from, $fullName);
                    $this->email->to($email['email'], $email['fullname']);
                    $this->email->subject = $subject;
                    $this->email->message($body);
                    $this->email->send();
                }
            }
        }
    }
}
