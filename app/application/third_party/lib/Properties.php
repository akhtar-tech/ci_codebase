<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
		*
		* Properties Class 
		* 
		* @author Sandeep Kumar <ki.sandeep11@gmail.com> 
	*/

trait Properties
{
	public $data_config;
	public $footer_link;
	public $sub_directory;
	public $page_code = "DEFAULT";
	public $view;
	public $instance = "DEFAULT";
	public $auth_check = FALSE;
	public $login_path;
	public $root_path;
	public $data;
	public $isXHR;
	public $limit;
	public $user;
	public $title;
	public $infokey;
	public $path;
	public $link;
	public $user_type = 'DEFAULT';
	public $storage;
	public $project_code;
	/* public function __construct($params) {} */

	public function start($params = NULL)
	{
		$this->project_code = 'app_' . $this->config->config['project_code'] . '_';
		$this->data_config = $this->config->config;
		$this->set_instance($params['instance']);
		$this->isXHR = $this->input->is_ajax_request();
		if (isset($this->login_path)) {
			$this->login_path = $this->login_path;
		}
		$project_dir = ($this->data_config['root_dir']) ? $this->data_config['root_dir'] . '/' : '';
		$this->root_path = $_SERVER['DOCUMENT_ROOT'] . dirname('') . "/" . $project_dir;
		$this->limit = $this->data_config['list_limit'];
		if ($this->load->is_loaded('session')) {
			$this->storage = $this->session->load_userdata($this->instance);
		}
	}
	
	public function load_storage()
	{
		$this->storage = $this->session->load_userdata($this->project_code . $this->instance);
	}

	public function update_storage()
	{
		$this->session->set_userdata($this->project_code . $this->instance, $this->storage);
	}

	public function doctype($type)
	{
		if ($this->isXHR === FALSE) {
			echo doctype($type);
		}
	}

	public function set_instance($instance = NULL)
	{
		if ($instance == NULL) {
			$this->instance = 'DEFAULT';
			$this->sub_directory = array('link' => '', 'path' => '');
			$this->path = $this->sub_directory['path'];
			$this->link = $this->sub_directory['link'];
		} else {
			$this->instance = $instance;
			$this->sub_directory = $this->data_config['sub_directory'][$this->instance];
			$this->path = $this->sub_directory['path'];
			$this->link = $this->sub_directory['link'];
		}
	}

	public function base()
	{
		if ($this->page_code == NULL) {
			throw new Exception("page_code must be required !");
		}
		if ($this->sub_directory == NULL) {
			throw new Exception("Error: undefined property 'sub_directory'");
		}
		if ($this->title == NULL) {
			console("Notice: undefined property 'title'");
		}
		if ($this->view == NULL) {
			console("Notice: undefined property 'view'");
		}
		if ($this->instance === NULL) {
			throw new Exception("Error: undefined property 'instance'");
		}
		if ($this->auth_check !== FALSE) {
			if ($this->login_path === NULL) {
				throw new Exception("Error: undefined property 'login_path'");
			}
		}
		if ($this->page_code == NULL || $this->page_code == 'DEFAULT') {
			console("Notice: undefined property 'page_code'");
		}
		if (isset($this->config->config['doctype']) && !empty($this->config->config['doctype'])) {
			$this->doctype($this->config->config['doctype']);
		}
		$data = NULL;
		if (!empty(trim($this->view))) {
			if (!file_exists(APPPATH . 'views/' . $this->sub_directory['path'] . $this->view . '.php')) {
				console("Error: file doesn't exist " . APPPATH . 'views/' . $this->sub_directory['path'] . $this->view . '.php');
				show_404();
			}
		}
		$this->user = $this->checkAuth();
		$this->title = ucfirst($this->title);
		$this->data = $this->data;
		$this->page_code = $this->page_code;
		$this->infoKey = $this->infoKey;
	}

	private function checkAuth()
	{
		if ($this->auth_check === TRUE) {
			if (isset($this->session->userdata($this->project_code . $this->instance)['user']['logged_in']) && $this->session->userdata($this->project_code . $this->instance)['user']['logged_in'] === TRUE) {
				if ($this->page_code == "LOGIN") {
					redirect($this->data_config['base_url'] . $this->sub_directory['link']);
				}
				return (isset($this->session->userdata($this->project_code . $this->instance)['user'])) ? $this->session->userdata($this->project_code . $this->instance)['user'] : NULL;
			} else {
				if ($this->page_code != "LOGIN") {
					if ($this->login_path === FALSE) {
						return FALSE;
					} else {
						$this->storage['request_uri'] = base_url() . str_replace("/" . $this->config->config['project_dir'], '', $this->input->server('REQUEST_URI'));
						$this->update_storage();
						redirect($this->login_path);
					}
				}
			}
		} else {
			return (isset($this->session->userdata($this->project_code . $this->instance)['user'])) ? $this->session->userdata($this->project_code . $this->instance)['user'] : NULL;
		}
	}
	public function set_user(array $data)
	{
		$this->load_storage();
		$data['logged_in'] = TRUE;
		$this->storage['user'] = $data;
		$this->update_storage();
	}
	public function get_user()
	{
		return $this->session->userdata($this->project_code . $this->instance)['user'];
	}
	public function set_info($name, $msg, $type = "info")
	{
		$this->session->set_flashdata($name, array('msg' => $msg, 'type' => $type));
	}
	public function get_info($name)
	{
		$fdata = $this->session->flashdata($name);
		$this->session->unset_userdata($name);
		return ($fdata) ? $fdata : NULL;
	}
	public function __call($method, $arguments)
	{
		switch ($method) {
			case 'initialize':
				$this->base();
				return $this->init();
				break;

			case 'setInfo':
				$type = (isset($arguments[2])) ? $arguments[2] : 'info';
				$this->set_info($arguments[0], $arguments[1], $type);
				break;

			case 'getInfo':
				return $this->get_info($arguments[0]);
				break;
		}
	}
}
