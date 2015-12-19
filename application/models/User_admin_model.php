<?php

class User_Admin_Model extends CI_Model
{


    public function createNewUser($formData)
    {
        if (!$this->userObj->isAdmin()) {
            echo json_encode(array('status' => 'error', 'msg' => 'You do not have permission to create a new user.'));
            exit;
        }
        // Check to make sure user does not already exist
        $userExists = User_model::exists($formData['username']);

        // If the above statement returns more than 0 rows, the user exists, so display error
        if ($userExists > 0) {
            echo json_encode(array('status' => 'error', 'msg' => 'A user with that name already exists.'));
            exit;
        } else {
            $phonenumber = @$formData['phone'];
            if (!isset($formData['canAdd'])) {
                $formData['canAdd'] = 0;
            }
            if (!isset($formData['canCheckin'])) {
                $formData['canCheckin'] = 0;
            }
            $userArray = array(
                'username' => $formData['username'],
                'password' => User_Model::randomPassword(),
                'department' => $formData['department'],
                'phone' => $phonenumber,
                'email' => $formData['email'],
                'last_name' => $formData['last_name'],
                'first_name' => $formData['first_name'],
                'can_add' => $formData['canAdd'],
                'can_checkin' => $formData['canCheckin'],
                'pw_reset_code' => 1,
            );
            $userId = User_Model::createUser($userArray);

            if (!isset($formData['admin'])) {
                $formData['admin'] = '0';
            }

            $adminArray = array(
                'id' => $userId,
                'admin' => $formData['admin'],
            );

            //Sets the correct admin settings for the new user
            User_Model::newUserAdmin($adminArray);

            if (isset($formData['departmentReview'])) {
                for ($i = 0; $i < sizeof($formData['departmentReview']); $i++) {
                    $deptId = $formData['departmentReview'][$i];
                    $deptArray = array(
                        'dept_id' => $deptId,
                        'user_id' => $userId);
                    //sets the reviewer status for the new user
                    User_model::newUserReviewer($deptArray);
                }
            }
/*
// mail user telling him/her that his/her account has been created.
$newUserObj = new User($userId, $pdo);
$date = date('M-d-Y H:i');
$getFullName = $this->userObj->getFullName();
$fullName = $getFullName[0].' '.$getFullName[1];
$getNewFullName = $newUserObj->getFullName();
$newUserFullName = $getNewFullName[0].' '.$getNewFullName[1];

$body= (file_get_contents('templates/emails/user-email-template.html'));
$body = str_replace('$fullName', $newUserFullName, $body);
$body = str_replace('$userName', $newUserObj->getName(), $body);

$body = str_replace('$base_url', $base_url, $body);
$body = str_replace('$msg','Your Document Management account was created by '. $fullName . ' on ' . $date , $body);
$body = str_replace('$date', $date, $body);
$body = str_replace('$email', $this->userObj->getEmailAddress(), $body);
$body = str_replace('$siteName', msg('email_automated_document_messenger'), $body);
$body = str_replace('$phoneNumber', $this->userObj->getPhoneNumber(), $body);
$body = str_replace('$creator', $fullName, $body);

if($GLOBALS['CONFIG']['authen'] == 'mysql')
{
$body = str_replace('$password', $_POST['password'], $body);
}

$mail = new PHPMailer;
$mail->isSendmail();
$mail->setFrom($this->userObj->getEmailAddress(), $fullName);
$mail->Subject = msg('message_account_created_add_user');
$mail->msgHTML($body);
$mail->addAddress($newUserObj->getEmailAddress() ,  $newUserFullName);
if (!$mail->send()) {
echo "Mailer Error: " . $mail->ErrorInfo;
break;
} else {
echo "Message sent!";
}
 */
        }

    }
}
