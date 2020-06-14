<?php 
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	$config['rest_enable'] = TRUE;
	$config['rest_debug'] = TRUE;
	$config['rest_enable_auth'] = TRUE;
	$config['rest_automation'] = TRUE;
	$config['rest_image_upload'] = TRUE;
	$config['rest_enable_logging'] = FALSE;
	$config['rest_database_group'] = 'default';
	$config['rest_auth_table'] = 'admin';
	$config['rest_auth_key'] = 'auth_key';
	