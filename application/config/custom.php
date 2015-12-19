<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['pdf_binary'] = APPPATH . 'third_party/wkhtmlto/windows/wkhtmltopdf.exe';

$config['image_binary'] = APPPATH . 'third_party/wkhtmlto/windows/wkhtmltoimage.exe';

$config['primary_cache'] = 'dummy';

$config['backup_cache'] = 'dummy';

$config['application_name'] = 'Open Source Document Management System';

$config['description'] = 'Open Source Document Management System developed by Brandon Bailey';

$config['site_email'] = 'admin@example.com';

$config['site_logo'] = 'assets/images/logo-32.png';

$config['generator'] = 'Document Management System';

$config['site_title'] = 'Document Management System';

$config['dataDir'] = 'documents/files/';

$config['moduleDir'] = 'documents/modules/';

$config['revisionDir'] = 'documents/files/revisionDir/';

$config['archiveDir'] = 'documents/files/archiveDir/';

$config['docTmpDir'] = 'documents/files/tmp/';

$config['allow_signup'] = 0;

$config['authen'] = 'mysql';

$config['authorization'] = '1';

$config['require_password_reset'] = 0;
