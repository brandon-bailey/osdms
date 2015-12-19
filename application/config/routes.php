<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['404_override'] = '';

$route['translate_uri_dashes'] = false;
//allows for the pagination settings to work properly
$route['home/(:any)'] = 'home';
//allow passing the file id as a uri segment instead of ugly get request
$route['checkin/checkfilein/(:any)'] = 'checkin/checkfilein';
$route['checkout/downloadfile/(:any)'] = 'checkout/downloadfile';
$route['delete/undeletefile/(:num)'] = 'delete/undeletefile';
$route['details/(:num)'] = 'details';
$route['details/editFileDetails/(:num)'] = 'details/editFileDetails';
$route['file/resubmit/(:num)'] = 'file/resubmit';
$route['editor/(:num)'] = 'editor';
$route['user_authentication/resettemppassword/(:any)'] = 'user_authentication/resettemppassword';
$route['document/(:num)'] = 'document';
