<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class User extends WEB_Controller
{

	function __construct()
	{
		parent::__construct(['instance' => 'dir_1']);

		$this->login_path = $this->sub_directory['link'] . 'auth/login';
		$this->auth_check = TRUE;

		$this->infoKey = 'user_msg';
		$this->model = 'user_model';
		$this->controller = 'user/';

		#model declaration
		$this->load->model($this->model);

		//$this->benchmark->mark('code_start');
		//$this->benchmark->mark('code_end');
		//echo $this->benchmark->elapsed_time('code_start', 'code_end');
		
	}

	public function create()
	{
		#data initialization
		$this->title = 'Create Branch';
		$this->page_code = 'CREATE_BRANCH';
		$this->data = ['header' => 'Create Branch'];
		$this->view = $this->controller . 'create';
		$data = $this->initialize();
		

		$panel = TRUE;

		#model

		#validation rules
		$this->form_validation->set_data($this->input->post());
		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($data['form_data']['name'] != $this->input->post('name')) {
			$this->form_validation->set_rules('branch', 'Branch', 'callback_check_name');
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

			$image_help = $this->file_upload->upload([
				'key' => 'file',
				'upload_path' => './data/user/',
				//'remote_upload_url' => $this->data_config['remote_upload_url']
			]);

			if ($image_help['status']) {
				$obj->setRequest('file', $image_help['data']['upload_data']['file_name']);
			}

			$obj->setRequest('name', $this->input->post('name'));
			$obj->setRequest('msg', $this->input->post('msg'), TRUE);
			$obj->setRequest('is_active', $this->input->post('is_active'));
			$obj->setRequest('date_created', current_date());

			#model
			$query = new $this->model;
			$query->create([
				'data' => $obj->getRequest()
			]);

			$this->set_info($data['infoKey'], 'Successfully Created !', 'success');

			if ($query->status() === TRUE) {
				redirect($data['link'] . $this->controller . 'list');
			} else {
				$this->session->set_flashData('error', TRUE);
				$this->set_info($data['infoKey'], 'Something went wrong !', 'danger');
				$this->create();
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


		if ($data['form_data']['name'] != $this->input->post('name')) {
			$this->form_validation->set_rules('name', 'Name', 'callback_check_name');
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

			$file = $this->file_upload->upload([
				'key' => 'file',
				'upload_path' => './data/user/',
				'remote_upload_url' => $this->data_config['remote_upload_url']
			]);

			if ($file['status']) {
				$obj->setRequest('file', $file['data']['upload_data']['file_name']);
			}


			$obj->setRequest('name', $this->input->post('name'));
			$obj->setRequest('msg', $this->input->post('msg'), TRUE);
			$obj->setRequest('date_modified', current_date());
			$obj->setRequest('is_active', $this->input->post('is_active'));

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

		$this->load->model('db_model');
		#data initialization
		$this->title = 'Branch List';
		$this->page_code = 'BRANCH_LIST';
		$this->data = ['header' => 'Branch List'];
		$this->view = $this->controller . 'list';
		$data = $this->initialize();


		#search rules
		$search_rules = array(
			'key' => $this->input->get('q'),
			'rules' => array(
				['key' => 'name', 'value' => 'both'],
				['key' => 'id', 'value' => 'none'],

			)
		);

		$where = NULL;

		if ($this->input->get('from') || $this->input->get('to')) {
			$from = $this->input->get('from');
			$to = $this->input->get('to');
			if (empty($to)) {
				$to = $from;
			}
			$where[] = "DATE_FORMAT(date_created, '%Y-%m-%d') BETWEEN '" . $from . "' AND '" . $to . "'";
		}

		#offset
		$this->offset = ((empty($page_count)) ? 0 : $this->limit * ($page_count - 1));

		#model
		$query = new $this->model;

		$query->get([
			'select' => [
				'id',
				'name',
				'is_active'
			],
			'limit' => $this->limit,
			'offset' => $this->offset,
			'like' => $search_rules,
			'where' => $where,
			'order' => 'name asc'
		]);

		// echo $query->get_query();

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


	public function get_excel()
	{
		$this->load->library('php_excel');
		$this->load->model('user_model');
		$excel_header = [
			's_no',
			'name',
			'id',
			'is_active',
		];

		$excel_data = array();

		$data_list = $this->user_model->get()->data();

		if ($data_list) {
			$x = 0;
			foreach ($data_list as $d) {

				$obj = new Obj;
				$obj->setRequest('s_no', (string) ($x + 1));
				$obj->setRequest('name', $d['name']);
				$obj->setRequest('id', $d['id']);
				$obj->setRequest('is_active', $d['is_active']);


				$excel_data[$x] = $obj->getRequest();
				$x++;
			}
		}

		//debug(json_encode($excel_data));die;
		$this->php_excel->createExcel('Branch Report', $excel_header, $excel_data);
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
}
