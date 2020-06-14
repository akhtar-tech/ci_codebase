<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/*
		*
		* MY_Log Class 
		* 
		* @author    Sandeep Kumar <ki.sandeep11@gmail.com>
	*/
	class MY_Log extends CI_Log
	{
		public function __construct()
		{
			parent::__construct();
		}
		protected $_levels = array('ERROR' => 1, 'DEBUG' => 2, 'INFO' => 3, 'ALL' => 4, 'MESSAGE' => 5);
	}
