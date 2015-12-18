# osdms
Open Source Document Management System

There is currently no working installation script.
This is under development. 
If you want to get going right away, you will need to create your database on your own.
Once the database exists, import the SQL file located at "/assets/database/dms_database.sql"

After importing the database tables, edit the configuration located at "/application/config/database.php"

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
This project relies on numerous other open source projects.

A quick shout out.

![PHPMailer](https://raw.github.com/PHPMailer/PHPMailer/master/examples/images/phpmailer.png)

[Bootstrap](http://getbootstrap.com "Twitter Bootstrap")

[![](http://tannerlinsley.com/memes/chartjs.gif)](http://www.chartjs.org/docs/)

[Snappy](https://github.com/KnpLabs/snappy "KnpLabs Snappy")

[DataTables](https://github.com/DataTables/DataTables)

[wkhtmltopdf and wkhtmltoimage](https://github.com/wkhtmltopdf/wkhtmltopdf)