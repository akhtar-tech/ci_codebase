<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	/**
		* Users_model Class
		*
		* @author    Sandeep Kumar <ki.sandeep11@gmail.com>
	*/
	class User_model extends MY_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->table = 'users';
			$this->primary_key = 'id';
		}
		
	}
