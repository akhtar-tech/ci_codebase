<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'config/site_config.php';
$dir_1 = $config['sub_directory']['dir_1']; //backend
$dir_2 = $config['sub_directory']['dir_2']; //frontend
$dir_3 = $config['sub_directory']['dir_3']; //api

$route['default_controller'] = $dir_2['path'] . 'pages/layout';

$route[str_replace('/', '', $dir_3['link'])] = $dir_3['path'] . 'api/index';

/* * * routes for admin panel * * */
$route[str_replace('/', '', $dir_1['link'])] = $dir_1['path'] . 'pages/layout';
$route[$dir_1['link'] . '(:any)'] = $dir_1['path'] . 'pages/layout/$1';

#auth                                             
$route[$dir_1['link'] . 'auth/login'] = $dir_1['path'] . 'auth/login';
$route[$dir_1['link'] . 'auth/logout'] = $dir_1['path'] . 'auth/logout';
$route[$dir_1['link'] . 'auth/logout/all'] = $dir_1['path'] . 'auth/logout/all';

#branch
$route[$dir_1['link'] . 'user/list'] = $dir_1['path'] . 'user/lists';
$route[$dir_1['link'] . 'user/list/(:num)'] = $dir_1['path'] . 'user/lists/$1';
$route[$dir_1['link'] . 'user/get/(:num)'] = $dir_1['path'] . 'user/get/$1';
$route[$dir_1['link'] . 'user/edit/(:num)'] = $dir_1['path'] . 'user/edit/$1';
$route[$dir_1['link'] . 'user/delete/(:num)'] = $dir_1['path'] . 'user/delete/$1';
$route[$dir_1['link'] . 'user/create'] = $dir_1['path'] . 'user/create';
$route[$dir_1['link'] . 'user/get_excel'] = $dir_1['path'] . 'user/get_excel';
$route[$dir_1['link'] . 'user/report/(:num)'] = $dir_1['path'] . 'user/branch_report/$1';
$route[$dir_1['link'] . 'user/invalid-submission-report/(:num)'] = $dir_1['path'] . 'user/invalid_submission_report/$1';

#ajax
#$route[$dir_1['link'] . 'ajax/game/game_form'] = $dir_1['path'] . 'ajax/game_form';
#$route[$dir_1['link'] . 'ajax/remove_box'] = $dir_1['path'] . 'ajax/remove_box';

#custom-api
$route[$dir_3['link'] . 'game/get'] = $dir_3['path'] . 'game/get_game';
$route[$dir_3['link'] . 'game/set'] = $dir_3['path'] . 'game/set_game';
$route[$dir_3['link'] . 'user/register'] = $dir_3['path'] . 'user/register';
$route[$dir_3['link'] . 'user/get'] = $dir_3['path'] . 'user/get';

#rest api
$route[$dir_3['link'] . 'rest'] = $dir_3['path'] . 'api/index';
$route[$dir_3['link'] . 'rest/file/upload/(:any)/(:any)'] = $dir_3['path'] . 'api/upload/$1/$2';
$route[$dir_3['link'] . 'rest/(:any)'] = $dir_3['path'] . 'api/index/$1';
$route[$dir_3['link'] . 'rest/(:any)/(:any)'] = $dir_3['path'] . 'api/index/$1/$2';

/* * * default route ** */

#payment
#$route[$dir_2['link'].'payment/success'] = $dir_2['path'].'cart/success';
#$route[$dir_2['link'].'payment/failure'] = $dir_2['path'].'cart/failure';

/* * * routes for frontend * * */

$route[$dir_2['link'] . '(:any)'] = $dir_2['path'] . 'pages/layout/$1';

#default
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
