<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Upload Configuration settings
| -------------------------------------------------------------------------
|
*/
$config['upload_path'] = './documents/files/';
$config['allowed_types'] = 'gif|jpg|png|php|html|pdf|doc|docx|odt|odp|ods|csv|xml|xls|xlsx|ppt|mp3|mp4|wma';
$config['encrypt_name'] = TRUE;
$config['remove_spaces']=TRUE;
$config['file_ext_tolower'] = TRUE;
