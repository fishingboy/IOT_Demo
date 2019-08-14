<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['api_dev/article/(:num)'] = 'api_dev/article/index/$1';
$route['api/article/(:num)'] = "api/article/index/$1";
$route['api/article/(:num)'] = "api/article/index/$1";

$route['api_dev/article/(:num)/reply'] = 'api_dev/article/reply/$1';
$route['api/article/(:num)/reply'] = 'api/article/reply/$1';
$route['api/reply/(:num)'] = "api/reply/index/$1";
$route['api_dev/user/(:num)/article'] = 'api_dev/user/article/$1';
$route['api/user/(:num)/article'] = 'api/user/article/$1';
$route['api/user/(:num)/introArticle'] = 'api/user/introArticle/$1';
$route['api_dev/user/(:num)/favorite_article'] = 'api_dev/user/favorite_article/$1';
$route['api/user/(:num)/favorite_article'] = 'api/user/favorite_article/$1';

$route['api/article/(:num)/abstract'] = "api/article/abstract/$1";

$route['api/notify/(:num)/mark_readed'] = "api/notify/mark_readed/$1";

$route['api_dev/channel/(:num)/message'] = "api_dev/channel/message/$1";

$route['api/channel/(:num)/message'] = "api/channel/message/$1";
$route['api/v2/channel/(:num)/message'] = "api/v2/channel/message/$1";

$route['api/channel/(:num)/message_review'] = "api/channel/message_review/$1";

$route['api_dev/channel/(:num)'] = "api_dev/channel/index/$1";
$route['api/channel/(:num)'] = "api/channel/index/$1";

$route['api_dev/channel/(:num)/read'] = "api_dev/channel/read/$1";
$route['api/channel/(:num)/read'] = "api/channel/read/$1";
$route['api/channel/(:num)/left_match'] = "api/channel/left_match/$1";
$route['api/channel/(:num)/setNotify'] = "api/channel/setNotify/$1";

$route['api/campaign/(:num)/evaluation'] = "api/campaign/evaluation/$1";
$route['api/campaign/(:num)/evaluation_answer'] = "api/campaign/evaluation_answer/$1";
$route['api/campaign/(:num)/signup'] = "api/campaign/signup/$1";

$route['api/match/(:num)'] = 'api/match/index/$1';
$route['api/friend_request/(:num)/(:num)'] = 'api/friend_request/index/$1/$2';
$route['api/user/(:num)/unlockArea/(:num)'] = 'api/user/unlockArea/$1/$2';
$route['api/user/(:num)/area/(:num)'] = 'api/user/area/$1/$2';
$route['api/user/(:num)/areas'] = 'api/user/areas/$1';
$route['api/area/(:num)'] = 'api/area/index/$1';
$route['api/user/(:num)/unban'] = 'api/user/unban/$1';
$route['api/user/(:num)/is_bucket'] = 'api/user/is_bucket/$1';

/* chatbot */
$route['api/chatbot/message/push'] = 'api/chatbot/message_push';
//$route['api/chatbot_menu/(:num)/button'] = 'api/chatbot_menu/button/$1';
//$route['api/chatbot_menu/(:num)/button/(:num)/response'] = 'api/chatbot_menu/response/$1/$2';

$route['api/intro/(:num)'] = 'api/intro/index/$1';


/**
 * 解不明原因打到 api/AAAAAAAAA 的 bug ，之後要拿掉
 * @author Leo.Kuo
 */ 
$route['api/AAAAAAAAAA/index'] = "api/article/index";
$route['api/AAAAAAAAAA'] = "api/article/index";


