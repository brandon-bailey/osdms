# osdms
Open Source Document Management System

Document Management System that uses the Model View Controller (MVC) framework.

## Features
The final intent of this project will be to have a self hosted "Dropbox" or "Google Drive" type service.

- Upload files through the web browser.
- Control who can access these files.
- Keep track of any changes and store a backup of the documents.
- Drag and drop file builder that allows for dynamic document building.
- These documents are then stored as their original source, and a PDF version for portability.

## Installation and Loading
### More to come on this

There is currently no working installation script.
This is under development. 
If you want to get going right away, you will need to create your database on your own.
Once the database exists, import the SQL file located at 
["/assets/database/dms_database.sql"](https://github.com/brandon-bailey/osdms/blob/master/assets/database/dms_database.sql)

After importing the database tables, edit the configuration located at 
["/application/config/database.php"](https://github.com/brandon-bailey/osdms/blob/master/application/config/database.php)

The settings that will need changed to match your configuration are shown below.

```php
$db['default'] = array(
	'dsn' => '',
	'hostname' => 'localhost',
	'username' => 'USERNAME',
	'password' => 'PASSWORD',
	'database' => 'dms_database',
	'dbdriver' => 'mysqli',
	'dbprefix' => 'dms_',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'latin1',
	'dbcollat' => 'latin1_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
);
```

There are numerous other default settings that should be changed depending on your system, and your preferences.

These configuration options can be found 
["/application/config/custom.php"](https://github.com/brandon-bailey/osdms/blob/master/application/config/custom.php)

```php
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

```



## License

This software is distributed under The MIT License (MIT)


## Shout Out

This project relies on numerous other open source projects.


![PHPMailer](https://raw.github.com/PHPMailer/PHPMailer/master/examples/images/phpmailer.png)

![Bootstrap](https://avatars3.githubusercontent.com/u/2918581?v=3&s=200 "Twitter Bootstrap")

[![](http://tannerlinsley.com/memes/chartjs.gif)](http://www.chartjs.org/docs/)

[Snappy](https://github.com/KnpLabs/snappy "KnpLabs Snappy")

[DataTables](https://github.com/DataTables/DataTables)

[wkhtmltopdf and wkhtmltoimage](https://github.com/wkhtmltopdf/wkhtmltopdf)

There are more, this will be updated over time