<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	/**
		* Users Class
		*
		* @author    Sandeep Kumar <ki.sandeep11@gmail.com>
	*/
	class Users extends WEB_Controller
	{
		
		function __construct()
		{
			parent::__construct(['instance' => 'dir_1']);
			
			$this->login_path = $this->sub_directory['link'] . 'auth/login';
			$this->auth_check = TRUE;
			
			$this->infoKey = 'users_msg';
			$this->model = 'users_model';
			$this->controller = 'user/';
			
			#model declaration
			$this->load->model($this->model);
			$this->benchmark->mark('code_end');
			//$this->benchmark->mark('code_start');
			//echo $this->benchmark->elapsed_time('code_start', 'code_end');
		}
		
		public function create()
		{
			#data initialization
			$this->title = 'Create User';
			$this->page_code = 'CREATE_USER';
			$this->data = ['header' => 'Create User'];
			$this->view = $this->controller . 'create';
			$data = $this->initialize();
			
			$panel = TRUE;
			
			#model
			
			#validation rules
			$this->form_validation->set_data($this->input->post());
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required');
			$this->form_validation->set_rules('dl_no', 'Driving Licence', 'trim|required');
			
			if ($data['form_data']['mobile'] != $this->input->post('mobile')) {
				$this->form_validation->set_rules('mobile', 'Mobile', 'callback_check_mobile');
			}
			
			if ($this->form_validation->run() === FALSE || $this->session->flashData('error')) {
				
				$data['form_error'] = $this->form_validation->error_array();
				#input
				if (!empty(validation_errors())) {
					$data['form_data'] = $this->input->post();
				}
				
				#view
				$data['css'] = $this->load->view($data['path'] . 'includes/css.php', $data, TRUE);
				$data['script'] = $this->load->view($data['path'] . 'includes/script.php', $data, TRUE);
				$data['sidebar'] = $this->load->view($data['path'] . 'includes/nav.php', $data, TRUE);
				
				
				$this->load->view($data['path'] . 'includes/header.php', $data);
				$this->load->view($data['path'] . $data['view'], $data);
				$this->load->view($data['path'] . 'includes/footer.php', $data);
				
				
				if ($panel == FALSE) {
					$this->set_info($data['infoKey'], 'This page having a problem loading !', 'danger');
					$this->load->view($data['path'] . 'includes/header.php', $data);
					$this->load->view($data['path'] . 'notification/message.php', ['key' => $data['infoKey']]);
					$this->load->view($data['path'] . 'includes/footer.php', $data);
				}
				} else {
				
				$obj = new Obj;
				
				$this->file_upload->files = $_FILES;
				
				$obj->setRequest('name', $this->input->post('name'));
				$obj->setRequest('mobile', $this->input->post('mobile'));
				$obj->setRequest('dl_no', $this->input->post('dl_no'));
				$obj->setRequest('is_active', $this->input->post('is_active'));
				$obj->setRequest('date', $this->util->date());
				
				$file1 = $this->file_upload->upload([
				'key' => 'img1',
				'upload_path' => './data/'.$data['path'].'profile',
				'remote_upload_url' => $this->data_config['remote_upload_url']
				]);
				
				if ($file1['status']) {
					$obj->setRequest('image', $file1['data']['upload_data']['file_name']);
				}
				
				#model
				$query = new $this->model;
				$query->create([
                'id' => $id,
                'data' => $obj->getRequest()
				]);
				
				$this->set_info($data['infoKey'], 'Successfully Created !', 'success');
				
				if ($query->status() === TRUE) {
					redirect($data['link'] . $this->controller . 'list');
					} else {
					
					if ($query->message() == "NOT_UPDATED") {
						$this->set_info($data['infoKey'], 'Not Updated !', 'warning');
						redirect($data['link'] . $this->controller . 'list');
						} else {
						$this->session->set_flashData('error', TRUE);
						$this->set_info($data['infoKey'], 'Something went wrong !', 'danger');
						$this->edit($id);
					}
					
				}
			}
		}
		
		public function edit($id)
		{
			
			#data initialization
			$this->title = 'Edit User';
			$this->page_code = 'EDIT_USER';
			$this->data = ['header' => 'Edit User'];
			$this->view = $this->controller . 'edit';
			$data = $this->initialize();
			
			$panel = TRUE;
			
			#model
			$query = new $this->model;
			$query->get(['id' => $id]);
			
			if ($query->status() != TRUE) {
				$this->set_info($data['infoKey'], 'Data not found !', 'warning');
				redirect($data['link'] . $this->controller . 'list');
			}
			$data['form_data'] = $query->data(0);
			$data['id'] = $query->data(0)['id'];
			
			#validation rules
			$this->form_validation->set_data($this->input->post());
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required');
			$this->form_validation->set_rules('dl_no', 'Driving Licence', 'trim|required');
			
			if ($data['form_data']['mobile'] != $this->input->post('mobile')) {
				$this->form_validation->set_rules('mobile', 'Mobile', 'callback_check_mobile');
			}
			
			if ($this->form_validation->run() === FALSE || $this->session->flashData('error')) {
				
				$data['form_error'] = $this->form_validation->error_array();
				#input
				if (!empty(validation_errors())) {
					$data['form_data'] = $this->input->post();
				}
				
				#view
				$data['css'] = $this->load->view($data['path'] . 'includes/css.php', $data, TRUE);
				$data['script'] = $this->load->view($data['path'] . 'includes/script.php', $data, TRUE);
				$data['sidebar'] = $this->load->view($data['path'] . 'includes/nav.php', $data, TRUE);
				
				
				$this->load->view($data['path'] . 'includes/header.php', $data);
				$this->load->view($data['path'] . $data['view'], $data);
				$this->load->view($data['path'] . 'includes/footer.php', $data);
				
				
				if ($panel == FALSE) {
					$this->set_info($data['infoKey'], 'This page having a problem loading !', 'danger');
					$this->load->view($data['path'] . 'includes/header.php', $data);
					$this->load->view($data['path'] . 'notification/message.php', ['key' => $data['infoKey']]);
					$this->load->view($data['path'] . 'includes/footer.php', $data);
				}
				} else {
				
				$obj = new Obj;
				
				$this->file_upload->files = $_FILES;
				
				$obj->setRequest('name', $this->input->post('name'));
				$obj->setRequest('mobile', $this->input->post('mobile'));
				$obj->setRequest('dl_no', $this->input->post('dl_no'));
				$obj->setRequest('is_active', $this->input->post('is_active'));
				
				$file1 = $this->file_upload->upload([
				'key' => 'img1',
				'upload_path' => './data/'.$data['path'].'profile',
				'remote_upload_url' => $this->data_config['remote_upload_url']
				]);
				
				if ($file1['status']) {
					$obj->setRequest('image', $file1['data']['upload_data']['file_name']);
				}
				
				#model
				$query = new $this->model;
				$query->update([
                'id' => $id,
                'data' => $obj->getRequest()
				]);
				
				$this->set_info($data['infoKey'], 'Successfully Updated !', 'success');
				
				if ($query->status() === TRUE) {
					redirect($data['link'] . $this->controller . 'list');
					} else {
					
					if ($query->message() == "NOT_UPDATED") {
						$this->set_info($data['infoKey'], 'Not Updated !', 'warning');
						redirect($data['link'] . $this->controller . 'list');
						} else {
						$this->session->set_flashData('error', TRUE);
						$this->set_info($data['infoKey'], 'Something went wrong !', 'danger');
						$this->edit($id);
					}
					
				}
			}
		}
		
		public function lists($page_count = 0)
		{
			
			#data initialization
			$this->title = 'User List';
			$this->page_code = 'USER_LIST';
			$this->data = ['header' => 'User List'];
			$this->view = $this->controller . 'list';
			$data = $this->initialize();
			
			#search rules
			$search_rules = array(
            'key' => $this->input->get('q'),
            'rules' => array(['key' => 'name', 'value' => 'after'], ['key' => 'dl_no', 'value' => 'both'], ['key' => 'mobile', 'value' => 'both'])
			);
			
			$where = NULL;
			
			if ($this->input->get('from') || $this->input->get('to')) {
				$from = $this->input->get('from');
				$to = $this->input->get('to');
				if (empty($to)) {
					$to = $from;
				}
				$where[] = "DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '" . $from . "' AND '" . $to . "'";
			}
			
			#offset
			$this->offset = ((empty($page_count)) ? 0 : $this->limit * ($page_count - 1));
			
			#model
			$query = new $this->model;
			
			$query->get([
            'select' => ['id', 'name', 'mobile', 'dl_no', 'is_active', 'user_id'],
            'limit' => $this->limit,
            'offset' => $this->offset,
            'like' => $search_rules,
            'where' => $where,
			]);
			
			//echo $query->get_query();
			
			if ($query->status() === FALSE) {
				$this->set_info($data['infoKey'], 'Data not found !', 'warning');
			}
			
			$data['rows'] = $query->data();
			
			#pagination
			$this->load->library('pagination');
			
			$config['base_url'] = base_url() . $data['link'] . $this->view;
			$config['total_rows'] = $query->total_count();
			$config['per_page'] = $this->limit;
			$config['uri_segment'] = $this->uri_segment;
			$config['num_links'] = 3;
			$config['reuse_query_string'] = TRUE;
			$config['use_page_numbers'] = TRUE;
			$config['attributes'] = array('class' => 'pagination');
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:{}">';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tagl_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li class="page-item">';
			$config['prev_tagl_close'] = '</li>';
			$config['first_tag_open'] = '<li class="page-item">';
			$config['first_tagl_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item">';
			$config['last_tagl_close'] = '</a></li>';
			$config['attributes'] = array('class' => 'page-link');
			
			$this->pagination->initialize($config);
			
			$data['offset'] = $this->offset;
			$data['limit'] = $this->limit;
			$data['total_rows'] = $query->total_count();
			$data['current_rows'] = (($data['limit'] + ($data['offset'])) > $data['total_rows']) ? $data['total_rows'] : ($data['limit'] + ($data['offset']));
			
			$data['css'] = $this->load->view($data['path'] . 'includes/css.php', $data, TRUE);
			$data['script'] = $this->load->view($data['path'] . 'includes/script.php', $data, TRUE);
			$data['sidebar'] = $this->load->view($data['path'] . 'includes/nav.php', $data, TRUE);
			
			$this->load->view($data['path'] . 'includes/header.php', $data);
			$this->load->view($data['path'] . $data['view'], $data);
			$this->load->view($data['path'] . 'includes/footer.php', $data);
			
			
		}
		
		public function get($id)
		{
			#data initialization
			$this->title = 'User View';
			$this->page_code = 'USER_VIEW';
			$this->data = ['header' => 'User View'];
			$this->view = $this->controller . 'get';
			$data = $this->initialize();
			
			#model
			$query = new $this->model;
			$query->get([
			'id' => $id
			]);
			
			if ($query->status() != TRUE) {
				$this->set_info($data['infoKey'], 'Data not found !', 'warning');
				redirect($data['link'] . $this->controller . 'list');
			}
			$data['row'] = $query->data(0);
			$data['form_data'] = $query->data(0);
			
			#view
			$data['css'] = $this->load->view($data['path'] . 'includes/css.php', $data, TRUE);
			$data['script'] = $this->load->view($data['path'] . 'includes/script.php', $data, TRUE);
			$data['sidebar'] = $this->load->view($data['path'] . 'includes/nav.php', $data, TRUE);
			
			
			$this->load->view($data['path'] . 'includes/header.php', $data);
			$this->load->view($data['path'] . $data['view'], $data);
			$this->load->view($data['path'] . 'includes/footer.php', $data);
		}
		
		public function delete($id)
		{
			
			#data initialization
			/*
				$this->title = 'Delete Service';
				$this->page_code = 'DELETE_SERVICE';
				$this->data = ['header' => 'Delete Service'];
				$this->view = 'service/delete';
			*/
			$data = $this->initialize();
			$query = new $this->model;
			$query->delete(['id' => $id]);
			
			$this->set_info($data['infoKey'], 'Successfully Deleted !', 'danger');
			//redirect($this->sub_directory['link'] . 'service/list');
		}
		
		public function check_mobile($value)
		{
			
			$this->form_validation->set_message(
            'check_mobile', 'This Mobile is already exist. Please choose another one'
			);
			$model = $this->{$this->model}->check_column_exist('mobile', $value);
			if ($model) {
				return false;
				} else {
				return true;
			}
		}
		
		public function get_excel()
		{
			show_404();
			$this->load->library('php_excel');
			
			$this->isXHR = TRUE;
			$data = $this->initialize();
			
			
			$select = [
            "id",
            "name",
            "email",
            "image",
            "date_created",
            "is_active"
			];
			
			$excel_header = [
            'S No',
            'ID',
            'Name',
            'Email',
            'Image',
            'Date',
            'Active',
            'Remarks'
			];
			
			#search rules
			$search_rules = array(
            'key' => $this->input->get('q'),
            'rules' => array(['key' => 'name', 'value' => 'after'], ['key' => 'email', 'value' => 'both'])
			);
			
			$where = NULL;
			if ($this->input->get('from') || $this->input->get('to')) {
				$from = $this->input->get('from');
				$to = $this->input->get('to');
				if (empty($to)) {
					$to = $from;
				}
				$where = "DATE_FORMAT(date_created, '%Y-%m-%d') BETWEEN '" . $from . "' AND '" . $to . "'";
			}
			
			
			//$this->contact_us_model->debug = TRUE;
			$data = new $this->model;
			$data->get([
            'search_rules' => $search_rules,
            'where' => $where,
            'select' => $select
			]);
			
			$excel_data = array();
			$x = 0;
			foreach ($data->data() as $d) {
				
				$obj = new Obj;
				$obj->setRequest('s_no', ($x + 1));
				$obj->setRequest('id', $d['id']);
				$obj->setRequest('name', $d['name']);
				$obj->setRequest('email', $d['email']);
				if (!empty($d['image'])) {
					$obj->setRequest('image', media_url() . 'data/users/image/' . $d['image']);
					} else {
					$obj->setRequest('image', '');
				}
				
				$obj->setRequest('date', $d['date_created']);
				$obj->setRequest('active', $d['is_active']);
				$obj->setRequest('remarks', '');
				
				$excel_data[$x] = $obj->getRequest();
				$x++;
			}
			//debug($excel_data);die;
			$this->php_excel->createExcel('MIS', $excel_header, $excel_data, TRUE);
		}
		
		
	}
