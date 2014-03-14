<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('PAGE_SIZE_DEFAULT', 20);
/* SQL */
define('DB_DATE_FORMAT', '%m/%d/%Y');
define('DB_DATE_TIME_FORMAT', '%m/%d/%Y %H:%i:%s');

define('FTP_IMAGES_ROOT', 'c:/wamp/ftp/');

/* MODULES */

define('MODULE_DEVICES', 1);
define('MODULE_EMAIL_CONFIG', 2);
define('MODULE_USERS', 3);
define('MODULE_ROLES', 4);
define('MODULE_MENU', 5);
define('MODULE_CMS', 6);
define('MODULE_HOME', 8);
define('MODULE_EMAIL_TEMPLATE', 9);
define('MODULE_SITES', 10);
define('MODULE_ZONES', 11);
define('MODULE_DEVICE_TYPES', 12);
define('MODULE_TYPES', 13);
define('MODULE_SUB_TYPES', 14);
define('MODULE_SITE_SETTING', 15);
define('MODULE_ORGANISATION', 16);
define('MODULE_ANALYZE', 17);
define('MODULE_MEASUREMENTS', 18);
define('MODULE_EVENTS', 20);
define('MODULE_ALARMS', 22);
define('MODULE_UNITS', 24);

define('MODULE_TYPE_VIEW', 1);
define('MODULE_TYPE_ADD', 2);
define('MODULE_TYPE_UPDATE', 3);
define('MODULE_TYPE_DELETE', 4);

define('AJAX_NOT_ENOUGH_PRIVILEGE', -1220);
define('AJAX_NOT_LOGIN', -1221);

define('SEPARATER_FORMULAR_VALUE', '^`^');
define('FTP_ROOT', '/home/vsftpd/');

/* LANGUAGES */

define('EN', 'en');
define('FI', 'fi');
define('KR', 'kr');

/** UPLOAD **/
define('UPLOAD_DIR', 'uploads');
define('CHANNEL_UPLOAD_DIR', UPLOAD_DIR . '/channels/');

/* End of file constants.php */
/* Location: ./application/config/constants.php */