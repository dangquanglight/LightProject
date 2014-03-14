<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

#USER MANAGEMENT
$url_home = "fsadfzerrwez_";

/** SITES **/
$url_controller = $url_home . 'sites/';
$route['sites'] = $url_controller . "sites";
$route['add-site'] = $url_controller . "add_site";
$route['edit-site/(:any)'] = $url_controller . "add_site/$1";

/** ZONES **/
$url_controller = $url_home . 'zones/';
$route['zones'] = $url_controller . "zones";
$route['add-zone'] = $url_controller . "add_zone";
$route['edit-zone/(:any)'] = $url_controller . "add_zone/$1";
$route['zone-layout/(:num)/(:any)'] = $url_controller . "layout/$1";
$route['upload-zone-layout/(:num)'] = $url_controller . "upload_zone_layout/$1";
$route['update-device-position'] =  $url_controller . "update_device_position";
$route['update-device-color'] =  $url_controller . "update_device_color";
$route['update-disable-alarm-minutes'] =  $url_controller . "update_disable_alarm_minutes";
$route['minutes-disabled-remaining'] =  $url_controller . "get_minutes_disabled_remaining";
$route['enable-alarm'] =  $url_controller . "enable_alarm";
/** TYPES **/
$url_controller = $url_home . 'types/';
$route['types'] = $url_controller . "types";
$route['add-type'] = $url_controller . "add_type";
$route['edit-type/(:any)'] = $url_controller . "add_type/$1";

/** SUB TYPES **/
$url_controller = $url_home . 'sub_types/';
$route['sub-types'] = $url_controller . "sub_types";
$route['add-sub-type'] = $url_controller . "add_sub_type";
$route['edit-sub-type/(:any)'] = $url_controller . "add_sub_type/$1";
$route['units-by-sub-types/(:num)'] = $url_controller . 'get_units_by_sub_types/$1';

/** DEVICES **/
$url_controller = $url_home . 'devices/';
$route['devices'] = $url_controller . "devices";
$route['add-device'] = $url_controller . "add_device";
$route['edit-device/(:num)'] = $url_controller . "add_device/$1";
$route['ajax-devices-in-zone/(:num)'] = $url_controller . "ajax_devices_in_zone/$1";
$route['ajax-devices-by-type-in-zone/(:num)/(:num)'] = $url_controller . "ajax_devices_by_type_in_zone/$1/$2";

/** HOME USER **/
$url_controller = 'home_user/';
$route['login'] = $url_controller . "login";
$route['user-login'] = $url_controller . 'user_login';
$route['logout'] = $url_controller . "logout";
$route['account-disabled'] = $url_controller . "account_disabled";
$route['not-enough-privilege'] = $url_controller . "not_enough_privilege";
$route['profile'] = $url_controller . "profile";
$route['change-password'] = $url_controller . "change_password";
$route['register'] = $url_controller . "register";
$route['need-activate-account'] = $url_controller . "need_activate_account";
$route['register-completed'] = $url_controller . "register_completed";
$route['activate/(:any)'] = $url_controller . "activate/$1";
$route['disable-register'] = $url_controller . "disable_register/$1";

/** EMAIL CONFIG **/
$url_controller = $url_home . 'email_config/';
$route['email-config'] = $url_controller . "config";

/** SITE SETTING **/
$url_controller = $url_home . 'site_setting/';
$route['setting'] = $url_controller . "setting";

/** USERS **/
$url_controller = $url_home . 'users/';
$route['users'] = $url_controller . "users";
$route['add-user'] = $url_controller . "add_user";
$route['edit-user/(:num)'] = $url_controller . "add_user/$1";
$route['reset-password/(:num)'] = $url_controller . "reset_password/$1";

/** ROLES **/
$url_controller = $url_home . 'roles/';
$route['roles'] = $url_controller . "roles";
$route['add-role'] = $url_controller . "add_role";
$route['edit-role/(:num)'] = $url_controller . "add_role/$1";

/** DEVICE TYPES **/
$url_controller = $url_home . 'device_types/';
$route['device-types'] = $url_controller . "device_types";
$route['add-device-type'] = $url_controller . "add_device_type";
$route['edit-device-type/(:num)'] = $url_controller . "add_device_type/$1";

/** MENU **/
$url_controller = $url_home . 'menu/';
$route['menu'] = $url_controller . "menu";
$route['add-menu'] = $url_controller . "add_menu";
$route['edit-menu/(:num)'] = $url_controller . "add_menu/$1";

/** SUBMENU **/
$url_controller = $url_home . 'menu/';
$route['submenu'] = $url_controller . "submenu";
$route['submenu/(:num)'] = $url_controller . "submenu/$1";
$route['add-submenu'] = $url_controller . "add_submenu";
$route['edit-submenu/(:num)'] = $url_controller . "add_submenu/$1";

/** UNITS **/
$url_controller = $url_home . 'units/';
$route['units'] = $url_controller . "units";
$route['add-unit'] = $url_controller . "add_unit";
$route['edit-unit/(:num)'] = $url_controller . "add_unit/$1";

/** CMS **/
$url_controller = $url_home . 'cms/';
$route['cms'] = $url_controller . "cms";
$route['add-cms'] = $url_controller . "add_cms";
$route['edit-cms/(:any)'] = $url_controller . "add_cms/$1";

/** EMAIL TEMPLATE **/
$url_controller = $url_home . 'email_templates/';
$route['email-templates'] = $url_controller . "email_templates";
$route['add-email-template'] = $url_controller . "add_email_template";
$route['edit-email-template/(:any)'] = $url_controller . "add_email_template/$1";

/** LINKS **/
$url_controller = $url_home . 'email_schedules/';
$route['email-schedules'] = $url_controller . "email_schedules";
$route['add-email-schedule'] = $url_controller . "add_email_schedule";
$route['edit-email-schedule/(:any)'] = $url_controller . "add_email_schedule/$1";

/** LINKS **/
$url_controller = $url_home . 'organisation/';
$route['organisation'] = $url_controller . "organisation";
$route['organisation-chart-data'] = $url_controller . "organisation_chart_data";

/** PDF **/
/*
$url_controller = $url_home . 'pdf/';
$route['pdf'] = $url_controller . "pdf";
$route['pdf-graphs'] = $url_controller . "pdf_graphs";
*/

/** MEASUREMENT **/
$url_controller = $url_home . 'measurements/';
$route['measurements'] = $url_controller . "measurements";
$route['import-rand-data'] = $url_controller . "import_rand_data";
$route['latest-value'] = $url_controller . "get_lastest_data";
$route['set-latest-value'] = $url_controller . "set_lastest_data";
$route['measurement-info/(:any)/(:num)'] = $url_controller . "measurement_info/$1/$2";
$route['cal-median-by-date/(:any)/(:any)/(:any)/(:any)/(:any)'] = $url_controller . "cal_median_by_date/$1/$2/$3/$4/$5";
$route['status-info/(:any)/(:num)'] = $url_controller . "status_info/$1/$2";
$route['measurements-graph/(:any)/(:any)'] = $url_controller . "measurements_graph/$1/$2";
$route['measurements-group-columns-chart/(:num)/(:num)'] = $url_controller . "measurements_group_columns_chart/$1/$2";
$route['import-measurements'] = $url_controller . "import";
$route['send-measurement'] = $url_controller . "send_measurement";
$route['image-device/(:num)'] = $url_controller . "image_device/$1";

/** EVENTS **/
$url_controller = $url_home . 'events/';
$route['events'] = $url_controller . "events/";
$route['add-event'] = $url_controller . "add_event";
$route['edit-event/(:num)'] = $url_controller . "add_event/$1";

/** EVENTS SCHEDULE **/
$url_controller = $url_home . 'events_schedule/';
$route['events-schedule'] = $url_controller . "events/";
$route['add-event-schedule'] = $url_controller . "add_event";
$route['edit-event-schedule/(:num)'] = $url_controller . "add_event/$1";
$route['check-events-schedule'] = $url_controller . 'check_events_schedule';
$route['setup-event/(:num)'] = $url_controller . 'setup_event/$1';
$route['enable-all-events'] = $url_controller . 'enable_all_events/$1';

/** MEASUREMENT **/
$url_controller = 'home/';
$route['home-details/(:num)'] = $url_controller . "home_details/$1";

/** ANALYZE **/
$url_controller = $url_home . 'analyze/';
$route['analyze'] = $url_controller . "index";
$route['analyze-details/(:num)/(:any)'] = $url_controller . "analyze_details/$1";
$route['stream/(:num)/(:any)'] = $url_controller . "analyze_stream/$1";
$route['stream-info/(:num)'] = $url_controller . 'stream_info/$1';
$route['analyze-status/(:num)/(:any)'] = $url_controller . "analyze_status/$1";
#$route['stream-info/(:num)'] = $url_controller . 'stream_info/$1';
$route['analyze-devices/(:any)/(:any)'] = $url_controller . "analyze_devices/$1/$2";

/** LOGS **/
$url_controller = $url_home . 'event_logs/';
$route['logs/(:num)'] = $url_controller . "logs/$1";

/** ALARMS **/
$url_controller = $url_home . 'alarms/';
$route['alarms-info'] = $url_controller . "alarms_info";

/** ALARMS HISTORY **/
$url_controller = $url_home . 'alarms_history/';
$route['alarms-history'] = $url_controller . "alarms_history";

/** FETCHING **/
$url_controller = $url_home . 'fetching/';
$route['fetch-camera'] = $url_controller . "fetch_camera";

/** FAVORITE **/
$url_controller = $url_home . 'favorites_menu/';
$route['favorite-menu'] = $url_controller . "tracking";

/** DEFAULT **/
$route['default_controller'] = "home/introduce";
$route['404_override'] = '';

//ERRORS
$errors_url = "errors/";
$route['404.htm'] = $errors_url . "error_404";
//$route['404.htm'] = "devices";


/* End of file routes.php */
/* Location: ./application/config/routes.php */