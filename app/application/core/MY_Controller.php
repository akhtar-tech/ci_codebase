<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	spl_autoload_register(function ($resource) {
		if (file_exists(APPPATH . '/third_party/lib/' . $resource . '.php')) {
			require_once APPPATH . '/third_party/lib/' . $resource . '.php';
		}
	});
	
	/**
		* MY_Controller Class
		*
		* @author    Sandeep Kumar <ki.sandeep11@gmail.com>
	*/
	//require_once APPPATH . 'third_party/lib/Properties.php';
	
	class MY_Controller extends CI_Controller
	{
		public $data;

		public function __construct($params = NULL)
		{
			parent::__construct($params);
		}
		
		public function convert($size)
		{
			$unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
			return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
		}
		
		public function debug()
		{
			
			
		}
		
		public function session_gc()
		{
			$this->load->model('db_model');
			$sql = new Db_model();
			$sql->query("delete from ci_sessions where timestamp < (UNIX_TIMESTAMP(NOW()) - 3600*12)");
		}
	}
	
	class WEB_Controller extends MY_Controller
	{
		#trait
		use Properties;
		
		public function __construct($params)
		{
			
			parent::__construct($params);
			
			#load services and libraries
			//$this->load->library('session');
			$this->load->library('file_upload');
			$this->load->library('obj');
			$this->id_type = NULL;
			$this->start($params);
			
			if ($this->data_config['profiler_debug'] && !$this->input->is_ajax_request()) {
				$this->output->enable_profiler(TRUE);
			}
			
		}
		
		protected function init()
		{
			
			$data = NULL;
			
			$data['form_data'] = NULL;
			$data['id'] = NULL;
			$data['offset'] = NULL;
			$data['limit'] = NULL;
			$data['total_rows'] = NULL;
			$data['css'] = NULL;
			$data['script'] = NULL;
			$data['total_rows'] = NULL;
			$data['form_error'] = NULL;
			$data['current_rows'] = NULL;
			$data['id_type'] = $this->id_type;
			
			$data['controller'] = @$this->controller;
			$data['view'] = $this->view;
			$data['config'] = array(
            'site_name' => $this->data_config['site_name'],
            'footer_name' => $this->data_config['footer_name'],
            'footer_link' => $this->data_config['footer_link'],
            'sub_directory' => $this->data_config['sub_directory'],
            'base_url' => $this->data_config['base_url'],
			);
			$data['user'] = $this->user;
			$data['title'] = $this->title;
			$data['data'] = $this->data;
			$data['page_code'] = $this->page_code;
			$data['infoKey'] = $this->infoKey;
			$data['path'] = $this->path;
			$data['link'] = $this->link;
			
			/***************** custom code *****************/
			if ($this->instance == 'default') {
				
			}
			
			if ($this->instance == 'dir_1') {
				$this->uri_segment = 4;
				$this->limit = 10;
				
			}
			
			if ($this->instance == 'dir_2') {
				$this->uri_segment = 3;
			}
			/***************** end custom code *****************/
			return $data;
		}
		
		public function read_excel()
		{
			$this->load->library('php_excel');
			$this->php_excel->load("data/excel/FILE-15487651284506.xlsx");
			$excel_list = $this->php_excel->getSheetData($this->php_excel->getSheetName()[1]);
			$x = 0;
			foreach ($excel_list as $excel) {
				if ($x != 0) {
					debug($excel);
				}
				$x++;
			}
		}
			
		protected function change_db_charset()
		{
			$arr = FALSE;
			$tables = $this->db->list_tables();
			$this->load->model('db_model');
			foreach ($tables as $table) {
				$this->db_model->query("ALTER TABLE " . $table . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci");
				$arr = TRUE;
			}
			return $arr;
		}
		
	
		public function check_name($value)
		{
			
			$this->form_validation->set_message(
            'check_name', 'This Branch is already exist. Please choose another one'
			);
			$model = $this->{$this->model}->check_column_exist('name', $value);
			if ($model) {
				return false;
				} else {
				return true;
			}
		}
	}
	
	class API_Controller extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->library('rest');
			$this->load->library('obj');
			$this->load->library('file_upload');
		}
	}	