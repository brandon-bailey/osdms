<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['home/(:any)'] = 'home';	//allows for the pagination settings to work properly
$route['checkin/checkfilein/(:any)'] = 'checkin/checkfilein'; //allow passing the file id as a uri segment instead of ugly get request
$route['checkout/downloadfile/(:any)'] = 'checkout/downloadfile';
$route['delete/undeletefile/(:num)'] = 'delete/undeletefile';
$route['details/(:num)'] = 'details';
$route['file/resubmit/(:num)'] = 'files/resubmit';
$route['editor/(:num)'] = 'editor';
$route['user_authentication/resettemppassword/(:any)'] = 'user_authentication/resettemppassword';
$route['document/(:num)'] = 'document';