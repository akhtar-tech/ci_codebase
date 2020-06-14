<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/*
		*
		* Obj Class 
		*
		* @author Sandeep Kumar <ki.sandeep11@gmail.com> 
	*/
	class Obj
	{
		private $request;
		public function __construct()
		{
			$this->request = new stdClass();
		}
		public function getRequest()
		{
			$request = $this->request;
			return (array) $request;
		}
		public function setRequest($key, $value, $notNull = FALSE)
		{
			if ($notNull && $value == null) {
				$this->request->$key = '';
				} else {
				$this->request->$key = $value;
			}
		}
	}		