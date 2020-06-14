<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	/*
		*
		* MY_Input Class 
		* 
		* @author    Sandeep Kumar <ki.sandeep11@gmail.com> 
	*/
	class MY_Input extends CI_Input
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function put($index = NULL, $xss_clean = NULL)
		{
			if ($this->method() === 'put') {
				parse_str(file_get_contents("php://input"), $request);
				return $this->_fetch_from_array($request, $index, $xss_clean);
			} 
			else {
				return NULL;
			}
		}
		protected function _fetch_from_array(&$array, $index = NULL, $xss_clean = NULL)
	{

		is_bool($xss_clean) or $xss_clean = $this->_enable_xss;

		// If $index is NULL, it means that the whole $array is requested
		isset($index) or $index = array_keys($array);

		// allow fetching multiple keys at once
		if (is_array($index)) {
			$output = array();
			foreach ($index as $key) {
				$output[$key] = $this->_fetch_from_array($array, $key, $xss_clean);
			}

			return $output;
		}

		if (isset($array[$index])) {
			$value = escape_string($array[$index]);
		} elseif (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) // Does the index contain array notation
		{
			$value = $array;
			for ($i = 0; $i < $count; $i++) {
				$key = trim($matches[0][$i], '[]');
				if ($key === '') // Empty notation will return the value as array
				{
					break;
				}

				if (isset($value[$key])) {
					$value = escape_string($value[$key]);
				} else {
					return NULL;
				}
			}
		} else {
			return NULL;
		}

		return ($xss_clean === TRUE)
			? $this->security->xss_clean($value)
			: $value;
	}
	}
