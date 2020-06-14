<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	/**
		* Function Helper
		*
		* @author    Sandeep Kumar <ki.sandeep11@gmail.com>
	*/
	if (!function_exists('debug')) {
		
		function debug($message = NULL)
		{
			if (!empty($message)) {
				echo "<pre>";
				print_r($message);
				echo "</pre>";
				die;
				} else {
				echo NULL;
			}
		}
		
	}

	if (!function_exists('escape_string')) {
		function escape_string($value)
		{
			$search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
			$replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
	
			return str_replace($search, $replace, $value);
		}
	}
	
	
	if (!function_exists('directory_info')) {
		function directory_info($source_dir, $directory_depth = 0, $hidden = FALSE)
		{
			if ($fp = @opendir($source_dir)) {
				$filedata = array();
				$new_depth = $directory_depth - 1;
				$source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
				
				$x = 0;
				while (FALSE !== ($file = readdir($fp))) {
					// Remove '.', '..', and hidden files [optional]
					if ($file === '.' OR $file === '..' OR ($hidden === FALSE && $file[0] === '.')) {
						continue;
					}
					
					is_dir($source_dir . $file) && $file .= DIRECTORY_SEPARATOR;
					
					if (($directory_depth < 1 OR $new_depth > 0) && is_dir($source_dir . $file)) {
						$filedata[$file]['data'] = directory_info($source_dir . $file, $new_depth, $hidden);
						$filedata[$file]['permission'] = substr(decoct(fileperms($source_dir)), -4);
						$filedata[$file]['type'] = "dir";
						} else {
						$filedata[$x]['data'] = $file;
						$filedata[$x]['permission'] = substr(decoct(fileperms($source_dir . $file)), -4);
						$filedata[$x]['type'] = pathinfo($file, PATHINFO_EXTENSION);
						//chmod($source_dir . $file,0755);
					}
					$x++;
				}
				
				closedir($fp);
				return $filedata;
			}
			
			return FALSE;
		}
	}
	
	if (!function_exists('console')) {
		
		function console($string = null)
		{
			
			if (ENVIRONMENT === 'development') {
				$CI = &get_instance();
				if ($string != null && $CI->config->config['debug'] === TRUE && $CI->isXHR == FALSE) {
					$d = json_encode($string);
					echo $cn = "<script>console.log(" . $d . ");</script>";
				}
			}
		}
		
	}
	
	if (!function_exists('alert')) {
		
		function alert($string = null)
		{
			if ($string != null) {
				$d = json_encode($string);
				echo "<script>alert(" . $d . ");</script>";
			}
		}
		
	}
	
	
	if (!function_exists('selected')) {
		
		function selected($p1, $p2)
		{
			if ($p1 == $p2) {
				echo 'selected';
			}
		}
		
	}
	if (!function_exists('get_info')) {
		
		function get_info($name)
		{
			$CI = &get_instance();
			$fdata = $CI->session->flashdata($name);
			$CI->session->unset_userdata($name);
			return ($fdata) ? $fdata : NULL;
		}
		
	}
	
	if (!function_exists('checked')) {
		
		function checked($p1, $p2)
		{
			if ($p1 == $p2) {
				echo 'checked';
			}
		}
		
	}
	
	if (!function_exists('abc')) {
		
		function abc($p2)
		{
			return (trim($p2) == NULL) ? $p2 : '';
		}
		
	}
	if (!function_exists('get_user')) {
		
		function get_user()
		{
			$CI = &get_instance();
			return @$CI->session->userdata($CI->project_code . $CI->instance)['user'];
		}
		
	}
	
	if (!function_exists('logger')) {
		
		function logger($type, $msg)
		{
			$debug = debug_backtrace(2);
			//debug($debug);
			log_message($type, $msg . " " . $debug[0]['file'] . " " . $debug[0]['line']);
		}
		
	}
	
	if (!function_exists('load_script_old')) {
		
		function load_script_old($controller = NULL, $method = NULL)
		{
			
			$CI = &get_instance();
			if (ENVIRONMENT === 'development' && $CI->config->config['debug'] === TRUE && !empty($controller) && !empty($method)) {
				echo "<script>console.log('[Class: " . $controller . ", Method: " . $method . "]');</script>";
			}
			//$root_path = $CI->root_path;
			$root_path = $CI->config->config['root_path'];
			$path = $CI->sub_directory['path'];
			$script_path = (isset($CI->config->config['script_path'])) ? $CI->config->config['script_path'] . "/" : "";
			if (gettype($controller) == 'array') {
				echo '<script>var base_url = "' . base_url() . '";</script>';
				foreach ($controller as $ct) {
					if (file_exists($root_path . $script_path . 'scripts/' . $path . $ct . '.js')) {
						echo '<script type="text/javascript" src="' . base_url() . $script_path . 'scripts/' . $path . $ct . '.js"></script>';
					}
				}
				} else if ($controller != NULL && $method != NULL) {
				
				if (file_exists($root_path . 'assets/scripts/' . $path . $controller . '.js')) {
					echo '<script type="text/javascript" src="' . base_url() . $script_path . 'scripts/' . $path . $controller . '.js"></script>';
				}
				if (file_exists($root_path . $script_path . 'scripts/' . $path . $controller . '/' . $method . '.js')) {
					echo '<script type="text/javascript" src="' . base_url() . $script_path . 'scripts/' . $path . $controller . '/' . $method . '.js"></script>';
				}
				} else if ($controller == NULL) {
				echo '<script>var base_url = "' . base_url() . '";</script>';
				if (file_exists($root_path . $script_path . 'scripts/' . $path . 'main.js')) {
					echo '<script type="text/javascript" src="' . base_url() . $script_path . 'scripts/' . $path . 'main.js"></script>';
				}
				} else {
				if (file_exists($root_path . $script_path . 'scripts/' . $path . $controller . '.js')) {
					echo '<script type="text/javascript" src="' . base_url() . $path . $script_path . 'scripts/' . $path . $controller . '.js"></script>';
				}
			}
		}
		
	}
	
	if (!function_exists('load_script')) {
		
		function load_script($controller = NULL, $method = NULL, array $vars = NULL, array $library = NULL)
		{
			$data = NULL;
			$CI = &get_instance();
			if (ENVIRONMENT === 'development' && $CI->config->config['debug'] === TRUE && !empty($controller) && !empty($method)) {
				echo "<script>console.warn('%c [Class: %c" . $controller . "%c, Method: %c" . $method . "%c]', 'color:orange', 'color:red;font-weight:bold', 'color:orange', 'color:red;font-weight:bold', 'color:orange');</script>";
			}
			//$root_path = $CI->root_path;
			$root_path = $CI->config->config['root_path'];
			$path = $CI->sub_directory['path'];
			$script_path = (isset($CI->config->config['script_path'])) ? $CI->config->config['script_path'] . "/" : "";
			
			if ($vars) {
				foreach ($vars as $key => $value) {
					$data['js_obj']['var'][$key] = $value;
				}
			}
			
			$data['js_obj']['var']['base_url'] = base_url();
			$data['js_obj']['var']['version'] = $CI->config->config['version'];
			
			if (file_exists($root_path . $script_path . 'scripts/lib.js')) {
				echo '<script type="text/javascript" src="' . base_url() . $script_path . 'scripts/lib.js"></script>';
			}
			
			if ($library) {
				foreach ($library as $ct) {
					if ($ct != 'lib' && file_exists($root_path . $script_path . 'scripts/' . $path . $ct . '.js')) {
						$data['js_obj']['url'][$ct] = base_url() . $script_path . 'scripts/' . $path . $ct . '.js';
						} else {
						//$data['js_obj']['url'][$ct] = base_url() . $script_path . 'scripts/' . $ct . '.js';
					}
				}
			}
			
			if ($controller != NULL && $method != NULL) {
				
				if (file_exists($root_path . $script_path . 'scripts/' . $path . 'main.js')) {
					$data['js_obj']['url']['main'] = base_url() . $script_path . 'scripts/' . $path . 'main.js';
				}
				if (file_exists($root_path . $script_path . 'scripts/' . $path . $controller . '.js')) {
					$data['js_obj']['url'][$controller] = base_url() . $script_path . 'scripts/' . $path . $controller . '.js';
				}
				if (file_exists($root_path . $script_path . 'scripts/' . $path . $controller . '/' . $method . '.js')) {
					$data['js_obj']['url'][$controller . '/' . $method] = base_url() . $script_path . 'scripts/' . $path . $controller . '/' . $method . '.js';
				}
				
				
				} else if ($controller != NULL) {
				if (file_exists($root_path . $script_path . 'scripts/' . $path . 'main.js')) {
					$data['js_obj']['url']['main'] = base_url() . $script_path . 'scripts/' . $path . 'main.js';
				}
				if (file_exists($root_path . $script_path . 'scripts/' . $path . $controller . '.js')) {
					$data['js_obj']['url'][$controller] = base_url() . $script_path . 'scripts/' . $path . $controller . '.js';
				}
				} else if ($controller == NULL) {
				if (file_exists($root_path . $script_path . 'scripts/' . $path . 'main.js')) {
					$data['js_obj']['url']['main'] = base_url() . $script_path . 'scripts/' . $path . 'main.js';
				}
			}
			
			echo '<script>js_obj = $.extend(js_obj, ' . json_encode($data['js_obj']['var']) . ');</script>';
			
			if (count(@$data['js_obj']['url'])) {
				foreach ($data['js_obj']['url'] as $key => $value) {
					echo '<script type="text/javascript" src="' . $value . '"></script>';
				}
			}
		}
	}
	
	if (!function_exists('media_url')) {
		
		function media_url()
		{
			$CI_config = &get_config();
			if ($CI_config['remote_upload'] == FALSE) {
				return $CI_config['local_media_path'];
				} else {
				return $CI_config['remote_media_path'];
			}
		}
		
	}
	
	if (!function_exists('url_string')) {
		
		function url_string($string)
		{
			return strtolower(preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-\']/', '-', $string)));
		}
		
	}
	
	if (!function_exists('format_number')) {
		
		function format_number($value, $format = TRUE)
		{
			if ($format == false) {
				return round((float)$value, 2);
			}
			return number_format(round((float)$value, 2), 2);
		}
		
	}
	
	if (!function_exists('get_percent')) {
		
		function get_percent($total_value, $obtained_value, $format = true)
		{
			
			if (!empty($total_value) && !empty($obtained_value)) {
				$final_value = (((float)$obtained_value / (float)$total_value) * 100);
				if ($format == false) {
					return round((float)$final_value, 2);
				}
				return number_format(round((float)$final_value, 2), 2);
				} else {
				return number_format(0, 2);
			}
		}
		
	}
	
	if (!function_exists('get_value')) {
		
		function get_value($value, $percent, $format = true)
		{
			
			if (!empty($value) && !empty($percent)) {
				$final_value = (((float)$value * (float)$percent) / 100);
				
				if ($format == false) {
					return round((float)$final_value, 2);
				}
				return number_format(round((float)$final_value, 2), 2);
				} else {
				return number_format(0, 2);
			}
		}
		
	}
	
	if (!function_exists('search_revisions')) {
		function search_revisions($dataArray = NULL, $search_value, $key_to_search) {
			// This function will search the revisions for a certain value
			// related to the associative key you are looking for.
			$keys = array();
			if($dataArray){
				foreach ($dataArray as $key => $cur_value) {
					if ($cur_value[$key_to_search] == $search_value) {
						$keys[] = $key;
					}
				}
			}
			
			return $keys;
		}
	}
	
	if (!function_exists('parse_camel_case')) {
		function parse_camel_case($str)
		{
			return preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,}/', ' $0', $str);
		}
	}
	if (!function_exists('camel_case_to_snake')) {
		function camel_case_to_snake($str)
		{
			preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
			$ret = $matches[0];
			foreach ($ret as &$match) {
				$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
			}
			return implode('_', $ret);
		}
	}
	
	if (!function_exists('id')) {
		function id($type = NULL)
		{
			$id = NULL;
			if ($type == NULL) {
				$id = NULL;
			}
			return $id;
		}
	}
	
	if (!function_exists('current_date')) {
		function current_date()
		{
			$CI = &get_instance();
			return $CI->config->config['date'];
		}
	}
	
	if (!function_exists('random_number')) {
		function random_number()
		{
			return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		}
	}
	
	if (!function_exists('encoded_random_number')) {
		function encoded_random_number()
		{
			return base64_encode(substr(hash('sha256', mt_rand() . microtime()), 0, 20));
		}
	}
	
?>