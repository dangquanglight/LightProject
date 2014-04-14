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

// region DEVICE MANAGEMENT

// Teach-in status
define('STATUS_TAUGHT_IN', 1);
define('STATUS_PENDING_TEACH_IN', 0);

// Device state
define('DEVICE_STATE_CONTROLLER', 'controller');
define('DEVICE_STATE_CONTROLLED', 'controlled');
define('DEVICE_STATE_INPUT', 'input');

// endregion DEVICE MANAGEMENT

//region ACTION MANAGEMENT

// Action type
define('ACTION_TYPE_SCHEDULE', 0);
define('ACTION_TYPE_EVENT', 1);

// Action status
define('ACTION_ENABLE', 1);
define('ACTION_DISABLE', 0);

// Schedule days
define('ACTION_SCHEDULE_MONDAY', 0);
define('ACTION_SCHEDULE_TUESDAY', 1);
define('ACTION_SCHEDULE_WEDNESDAY', 2);
define('ACTION_SCHEDULE_THURSDAY', 3);
define('ACTION_SCHEDULE_FRIDAY', 4);
define('ACTION_SCHEDULE_SARTUDAY', 5);
define('ACTION_SCHEDULE_SUNDAY', 6);
define('ACTION_SCHEDULE_ALL_DAYS', 7);

//endregion ACTION MANAGEMENT


/* End of file constants.php */
/* Location: ./application/config/constants.php */