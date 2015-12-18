<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This option is operating system dependent, if running on windows
// do not change this option. If running on a linux system, change this
// option to APPPATH . 'third_party/wkhtmlto/wkhtmltopdf' and
// APPPATH . 'third_party/wkhtmlto/wkhtmltoimage' respectively
$config['pdf_binary'] = APPPATH . 'third_party/wkhtmlto/windows/wkhtmltopdf.exe';

$config['image_binary'] = APPPATH . 'third_party/wkhtmlto/windows/wkhtmltoimage.exe';

// The default cache is set to dummy, which means it does not cache.
// If you are running redis, simply change this to redis. memcached => memcached.
// other options include apc, file, or database. The backup cache can be set to
// any of these options as well.
$config['primary_cache'] = 'dummy';

$config['backup_cache'] = 'dummy';

$config['application_name'] = 'Open Source Document Management System';

$config['description'] = 'Open Source Document Management System developed by Brandon Bailey';

// This email is used in some of the default system emails that are sent out.
$config['site_email'] = 'admin@example.com';

// Change this logo to whatever your heart desires.
$config['site_logo'] = 'assets/images/logo-32.png';

$config['generator'] = 'Document Management System';

$config['site_title'] = 'Document Management System';

// I would advise against messing with these options, but
// I will leave that decision upto you.
//######################################################
$config['dataDir'] = 'documents/files/';

$config['moduleDir'] = 'documents/modules/';

$config['revisionDir'] = 'documents/files/revisionDir/';

$config['archiveDir'] = 'documents/files/archiveDir/';

$config['docTmpDir'] = 'documents/files/tmp/';
//######################################################

// This will enable or disable the sign up prompt on the front screen
$config['allow_signup'] = 0;

// Currently I have only implemented the mysql user login,
// future plans will involve oauth, ldap, etc.
$config['authen'] = 'mysql';

$config['authorization'] = '1';

// Should the user be able to create their own password on signup,
// or do you want to send them an email with a link to create a new
// one.
$config['require_password_reset'] = 0;