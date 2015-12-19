<?php

class Tobepublished_Model extends CI_Model
{

    public $email;

    public function __construct()
    {
        $this->email = new PHPMailer;
    }

    public function getFileList()
    {
        if ($this->session->admin) {
            $idArray = $this->userObj->getAllRevieweeIds();
        } else {
            $idArray = $this->userObj->getRevieweeIds();
        }
        $userPerms = new Userpermission_Model();
        $listOfFiles = $this->globalFunctions->listFiles($idArray, $userPerms, $this->config->item('dataDir'), true);

        if ($listOfFiles != -1) {
            return $listOfFiles;
        }
    }

    public function authorizeFile($data)
    {

        if (is_array($data['files'])) {
            foreach ($data['files'] as $file) {
                $checkBox[] = array('id' => $file);
            }
        } else {
            $checkBox[] = array('id' => $data['files']);
        }

        $reviewerComments = 'To= ' . $data['form']['to'] . ';Subject= ' . $data['form']['subject'] .
        ' ;Comments= ' . $data['form']['comments'];
        $date = date('M-d-Y H:i');
        $getFullName = $this->userObj->getFullName();
        $fullName = $getFullName[0] . ' ' . $getFullName[1];
        $reviewerEmail = $this->userObj->getEmailAddress();
        $reviewerPhone = $this->userObj->getPhoneNumber();
        $reviewerDept = $this->userObj->getDeptName();

        if ($this->session->admin) {
            $idArray = $this->userObj->getAllRevieweeIds();
        } else {
            $idArray = $this->userObj->getRevieweeIds();
        }

        foreach ($checkBox as $key => $value) {
            // Check to make sure the current file_id is in their list of reviewable ID's
            if (in_array($value, $idArray)) {

                $fileId = $value['id'];

                $newFileObj = new Document_Model($fileId);

                $newUserObj = new User_Model($newFileObj->getOwner());

                $mailTo = $newUserObj->getEmailAddress();
                $userName = $newUserObj->getFullName();
                $userFullName = $userName[0] . ' ' . $userName[1];
                $deptId = $newFileObj->getDepartment();

                // Build email for author notification
                if (isset($data['form']['sendToUsers'][0]) && in_array('owner', $data['form']['sendToUsers'])) {
                    // Lets unset this now so the new array will just be user_id's
                    $data['form']['sendToUsers'] = array_slice($data['form']['sendToUsers'], 1);

                    $emailData = array(
                        'reviewer' => $fullName,
                        'title' => 'Author',
                        'fileName' => $newFileObj->getRealName(),
                        'status' => 'Authorized',
                        'date' => date('l \t\h\e jS'),
                        'msg' => ' was accepted into the document repository.',
                        'email' => $reviewerEmail,
                        'siteName' => $this->config->item('site_name'),
                        'phoneNumber' => $reviewerPhone,
                        'department' => $reviewerDept,
                        'comments' => $data['form']['comments'],
                    );

                    $body = $this->load->view('emails/publish_file_email_view', $emailData, true);

                    $subject = $newFileObj->getRealName() . ' has been accepted by ' . $fullName;

                    $this->email->setFrom($reviewerEmail, $fullName);
                    $this->email->addAddress($mailTo, $userFullName);
                    $this->email->Subject = $subject;
                    $this->email->msgHTML($body);
                    $this->email->send();
                }

                $newFileObj->Publishable(1);
                $newFileObj->setReviewerComments($reviewerComments);
                AccessLog_Model::addLogEntry($fileId, 'Y');
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'You cannot alter this files status.'));
                exit;
            }
        }
        echo json_encode(array('status' => 'success', 'msg' => 'File Status successfully updated.'));
    }

    public function rejectFile($data)
    {
        if (is_array($data['files'])) {
            foreach ($data['files'] as $file) {
                $checkBox[] = array('id' => $file);
            }
        } else {
            $checkBox[] = array('id' => $data['files']);
        }

        $reviewerComments = 'To= ' . $data['form']['to'] . ';Subject= ' . $data['form']['subject'] .
         ' ;Comments= ' . $data['form']['comments'];
        $date = date('M-d-Y H:i');
        $fullName = $this->session->firstName . ' ' . $this->session->lastName;
        $reviewerEmail = $this->session->email;
        $reviewerPhone = $this->session->phone;
        $reviewerDept = $this->userObj->getDeptName();

        if ($this->session->admin) {
            $idArray = $this->userObj->getAllRevieweeIds();
        } else {
            $idArray = $this->userObj->getRevieweeIds();
        }

        foreach ($checkBox as $key => $value) {
            // Check to make sure the current file_id is in their list of reviewable ID's
            if (in_array($value, $idArray)) {
                $fileId = $value['id'];
                $newFileObj = new Document_Model($fileId);
                $newUserObj = new User_Model($newFileObj->getOwner());
                $mailTo = $newUserObj->getEmailAddress();
                $deptId = $newFileObj->getDepartment();

                if (isset($data['form']['sendToUsers'][0]) && in_array('owner', $data['form']['sendToUsers'])) {
                    $data['form']['sendToUsers'] = array_slice($data['form']['sendToUsers'], 1);
                    $emailData = array(
                        'reviewer' => $fullName,
                        'title' => 'Author',
                        'fileName' => $newFileObj->getRealName(),
                        'status' => 'Rejected',
                        'data' => date('l \t\h\e jS'),
                        'msg' => ' was rejected the document repository.',
                        'email' => $reviewerEmail,
                        'siteName' => $this->config->item('site_name'),
                        'phoneNumber' => $reviewerPhone,
                        'department' => $reviewerDept,
                        'comments' => $data['form']['comments'],
                    );

                    $body = $this->load->view('emails/publish_file_email_view', $emailData, true);
                    $subject = $newFileObj->getRealName() . ' has been rejected by ' . $fullName;

                    $this->email->setFrom($reviewerEmail, $fullName);
                    $this->email->addAddress($mailTo, $fullName);
                    $this->email->Subject = $subject;
                    $this->email->msgHTML($body);
                    $this->email->send();
                }
                $newFileObj->Publishable(-1);
                $newFileObj->setReviewerComments($reviewerComments);
                AccessLog_Model::addLogEntry($fileId, 'R');
                echo json_encode(array('status' => 'success', 'msg' => 'File Status successfully updated.'));
            } else {
                echo json_encode(array('status' => 'error', 'msg' => 'You cannot alter this files status.'));
                exit;
            }
        }

    }

    public function rejectedFileEmail()
    {

        $subject = 'This is a test';
        $message = '<p>This message has been sent for testing purposes.</p>';

        // Also, for getting full html you may use the following internal method:
        //$body = $this->email->full_html($subject, $message);

        $this->email->setFrom($this->config->item('site_email'));
        $this->email->addAddress('brandondanielbailey@gmail.com');
        $this->email->Subject = $subject;
        $this->email->msgHTML($body);
        $this->email->send();
        echo '<br />';
        echo $this->email->print_debugger();
        exit;
    }
}
