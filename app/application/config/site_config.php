<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Calcutta');
$config['site_name'] = 'CI CODEBASE';
$config['root_dir'] = 'ci_codebase';
$config['footer_link'] = '#';
$config['footer_name'] = 'Sandeep Kumar';
$config['script_path'] = 'app';
$config['site_url'] = @$_SERVER['SERVER_NAME'] . ((@$_SERVER['SERVER_PORT'] != 80 && @$_SERVER['SERVER_PORT'] != 443) ? ":" . @$_SERVER['SERVER_PORT'] : '');
$config['site_port'] = @$_SERVER['SERVER_PORT'];
$config['project_code'] = "001";
$config['version'] = "0.0.1";

$config['remote_upload'] = FALSE;
$config['image_quality'] = 60;
$config['debug'] = TRUE;
$config['profiler_debug'] = FALSE;
$config['doctype'] = '';

$config['sub_directory'] = array(
	'dir_1' => array('path' => 'admin/', 'link' => 'admin/'),    			//path configuration for demo
	'dir_2' => array('path' => '', 'link' => ''),                	//path configuration for frontend panel
	'dir_3' => array('path' => 'api/', 'link' => 'api/'),       	//path configuration for apis

);
$config['login_url'] = $config['sub_directory']['dir_1']['link'] . 'auth/login';
$config['list_limit'] = 5;

$config['date'] = date("Y-m-d H:i:s");

$config['db'] = array(
	'dsn' => 'mysql:host=localhost;port=3306;dbname=ci_codebase',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'ci_codebase',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$config['email_config'] = array(
	'host' => 'mail.domain.com',
	'username' => 'info@domain.com',
	'password' => '********',
	'from' => 'info@domain.com',
	'default_recipient' => array('info@domain.com'), //info@domain.com
	'from_name' => 'postman',
	'auth' => true,
	'port' => '587',
	'smtpsecure' => 'tls'
);

$config['protocol'] = is_https() ? "https://" : "http://";
$config['project_dir'] = ($config['root_dir']) ? $config['root_dir'] . '/' : '';
$config['host'] = $config['site_url'];

$config['remote_media_path'] = "http://localhost/cdn/";
$config['local_media_path'] = $config['protocol'] . $config['host'] . "/" . $config['project_dir'];
$config['remote_upload_url'] = "http://localhost/cdn/upload.php";
$config['root_path'] = $_SERVER['DOCUMENT_ROOT'] . "/" . $config['project_dir'];

$config['remote_upload'] = FALSE;
//$config['allowed_hosts'] = [$config['site_url']];

//$config['base_url'] = $protocol.$config['site_url'].'/'.$project_dir;

$config['allowed_hosts'] = array(
	'localhost',
	'127.0.0.1',
	$config['site_url']
);

if (is_cli()) {
	$config['base_url'] = '';
} else if (stristr($config['host'], "localhost") !== FALSE || (stristr($config['host'], '192.168.') !== FALSE) || (stristr($config['host'], '127.0.0') !== FALSE)) {
	$config['base_url'] = in_array($config['host'], $config['allowed_hosts']) ? $config['protocol'] . $config['host'] . "/" . $config['project_dir'] : '';
	if (empty($config['base_url'])) {
		header('HTTP/1.1 404 NOT FOUND');
		header("Content-Type: application/json");
		echo json_encode(array(
			'data' => NULL,
			'msg' => 'UNKNOWN_HOSTNAME'
		));
		die();
	}
} else {
	$config['base_url'] = in_array($config['host'], $config['allowed_hosts']) ? $config['protocol'] . $config['host'] . "/" . $config['project_dir'] : '';
	if (empty($config['base_url'])) {
		header('HTTP/1.1 404 NOT FOUND');
		header("Content-Type: application/json");
		echo json_encode(array(
			'data' => NULL,
			'msg' => 'UNKNOWN_HOSTNAME'
		));
		die();
	}
}
