<?php

class Profile_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserDetails()
    {
        $user = new stdClass();
        $user->fullName = $this->userObj->getFullNameConcat();
        $user->image = $this->userObj->getAvatar();
        $user->username = $this->userObj->getUsername();
        $date = new DateTime($this->userObj->getDate());
        $user->since = $date->format('M d, Y');
        return $user;
    }

    public function changeAvatar()
    {
        $config['upload_path'] = './documents/files/tmp';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['remove_spaces'] = true;
        $config['file_ext_tolower'] = true;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $error = array(
                'status' => 'error',
                'msg' => $this->upload->display_errors('', ''),
            );
            echo json_encode($error);
            exit;
        }
        $data = $this->upload->data();

        $config['source_image'] = $this->config->item('dataDir') . 'tmp/' . $data['file_name'];
        $config['new_image'] = $this->config->item('dataDir') . 'tmp/' . $data['raw_name'] . '.jpg';
        $config['maintain_ratio'] = true;
        $config['height'] = 200;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $img = file_get_contents($this->config->item('dataDir') . 'tmp/' . $data['raw_name'] . '.jpg');
        echo base64_encode($img);
    }

    public function saveAvatar()
    {
        $post = $this->input->post();
        $avatar = array(
            'avatar' => base64_decode($post['image']),
        );
        $this->userObj->saveAvatar($avatar);
    }
}
