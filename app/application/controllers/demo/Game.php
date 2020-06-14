<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Game Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
Class Game extends WEB_Controller
{

    function __construct()
    {
        parent::__construct(['instance' => 'dir_1']);

        $this->login_path = $this->sub_directory['link'] . 'auth/login';
        $this->auth_check = TRUE;

        $this->infoKey = 'games_msg';
        $this->model = 'game_model';
        $this->controller = 'game/';

        #model declaration
        $this->load->model($this->model);
    }

    public function create()
    {
        show_404();
    }

    public function edit($id)
    {
        $this->load->model('game_item_model');

        #data initialization
        $this->title = 'Edit Game';
        $this->page_code = 'EDIT_GAME';
        $this->data = ['header' => 'Edit Game'];
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

        $row = $query->data(0);


        $data['sub_game'] = $this->game_item_model->get([
            'where' => array(
                ['key' => 'game_id', 'value' => $id]
            )
        ])->data();

        $data['game_type_list'] = $this->game_type_list();


        #validation rules
        $this->form_validation->set_data($this->input->post());
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('desp', 'Description', 'trim|required');
        $this->form_validation->set_rules('content_help', 'Help content', 'trim|required');
        $this->form_validation->set_rules('game_index', 'Game index', 'trim|required');
        $this->form_validation->set_rules('caption', 'Caption', 'trim|required');
        $this->form_validation->set_rules('points', 'Points', 'trim|required');

        if ($row['type'] == 1) {

        }

        if ($row['type'] == 2) {

        }

        if ($data['form_data']['name'] != $this->input->post('name')) {
            $this->form_validation->set_rules('name', 'Game Name', 'callback_check_name');
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

            if ($row['type'] == 1) {
                $data['main_form'] = $this->load->view($data['path'] . 'game/templates/main_form.php', $data, TRUE);
                $data['rating_content_form'] = $this->load->view($data['path'] . 'game/templates/rating_content_form.php', $data, TRUE);

                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . $data['view'], $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            } else if ($row['type'] == 2) {
                $data['main_form'] = $this->load->view($data['path'] . 'game/templates/main_form.php', $data, TRUE);
                $data['rating_content_form'] = $this->load->view($data['path'] . 'game/templates/rating_content_form.php', $data, TRUE);

                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . $data['view'], $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            } else {
                $panel = FALSE;
            }

            if ($panel == FALSE) {
                $this->set_info($data['infoKey'], 'This page having a problem loading !', 'danger');
                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view('notification/message.php', ['key' => $data['infoKey']]);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            }
        } else {
            $query = new $this->model;
            $query->trans_start(NULL);

            $obj = new Obj;
            #files upload

            $this->file_upload->files = $_FILES;

            $obj->setRequest('name', $this->input->post('name'));
            $obj->setRequest('desp', $this->input->post('desp'));
            $obj->setRequest('content_help', $this->input->post('content_help'));
            $obj->setRequest('game_index', $this->input->post('game_index'));
            $obj->setRequest('caption', $this->input->post('caption'));
            //$obj->setRequest('game_index', $this->input->post('game_index'));
            $obj->setRequest('is_active', $this->input->post('is_active'));
            $obj->setRequest('rating_content1', $this->input->post('rating_content1'));
            $obj->setRequest('rating_content2', $this->input->post('rating_content2'));
            $obj->setRequest('rating_content3', $this->input->post('rating_content3'));
            $obj->setRequest('points', $this->input->post('points'));


            #model
            $query->update([
                'id' => $id,
                'data' => $obj->getRequest()
            ]);


            if ($row['type'] == 1) {
                if (count($this->input->post('item_id'))) {

                    $x = 0;
                    foreach ($this->input->post('item_id') as $sub_game) {

                        $obj2 = new Obj;

                        $file1 = $this->file_upload->upload([
                            'key' => 'img1',
                            'index' => $x,
                            'upload_path' => './data/'.$data['path'].'game',
                            'remote_upload_url' => $this->data_config['remote_upload_url']
                        ]);

                        if ($file1['status']) {
                            $obj2->setRequest('image1', $file1['data']['upload_data']['file_name']);
                        }


                        $file2 = $this->file_upload->upload([
                            'key' => 'img2',
                            'index' => $x,
                            'upload_path' => './data/'.$data['path'].'game',
                            'remote_upload_url' => $this->data_config['remote_upload_url']
                        ]);

                        if ($file2['status']) {
                            $obj2->setRequest('image2', $file2['data']['upload_data']['file_name']);
                        }

                        $obj2->setRequest('answer', $this->input->post('answer')[$x], TRUE);
                        $obj2->setRequest('content1', $this->input->post('content1')[$x]);
                        $obj2->setRequest('content2', $this->input->post('content2')[$x]);
                        $obj2->setRequest('game_id', $id);


                        //var_dump($this->input->post('item_id')[$x]);die;

                        if (!empty($this->input->post('item_id')[$x])) {
                            $this->game_item_model->update([
                                'id' => $this->input->post('item_id')[$x],
                                'data' => $obj2->getRequest()
                            ]);
                        } else {
                            $obj2->setRequest('date', $this->util->date());
                            $this->game_item_model->create([
                                'data' => $obj2->getRequest()
                            ]);
                        }

                        $x = $x + 1;
                    }
                }

            }

            if ($row['type'] == 2) {
                if (count($this->input->post('item_id'))) {

                    $x = 0;
                    foreach ($this->input->post('item_id') as $sub_game) {

                        $obj2 = new Obj;

                        $file1 = $this->file_upload->upload([
                            'key' => 'img1',
                            'index' => $x,
                            'upload_path' => './data/'.$data['path'].'game',
                            'remote_upload_url' => $this->data_config['remote_upload_url']
                        ]);



                        if ($file1['status']) {
                            $obj2->setRequest('image1', $file1['data']['upload_data']['file_name']);
                        }


                        $obj2->setRequest('answer', $this->input->post('answer')[$x], TRUE);
                        $obj2->setRequest('content1', $this->input->post('content1')[$x]);

                        $obj2->setRequest('game_id', $id);


                        //var_dump($this->input->post('item_id')[$x]);die;

                        if (!empty($this->input->post('item_id')[$x])) {
                            $this->game_item_model->update([
                                'id' => $this->input->post('item_id')[$x],
                                'data' => $obj2->getRequest()
                            ]);
                        } else {
                            $obj2->setRequest('date', $this->util->date());
                            $this->game_item_model->create([
                                'data' => $obj2->getRequest()
                            ]);
                        }

                        $x = $x + 1;
                    }

                }

            }


            $query->trans_complete();
            if ($query->trans_status() === TRUE) {
                $this->set_info($data['infoKey'], 'Successfully Updated !', 'warning');
                redirect($data['link'] . $this->controller . 'list');
            } else {
                $this->session->set_flashData('error', TRUE);
                $this->set_info($data['infoKey'], $query->message(), 'danger');
                $this->edit($id);
            }
        }
    }

    public function lists($page_count = 0)
    {

        #data initialization
        $this->title = 'Game List';
        $this->page_code = 'GAME_LIST';
        $this->data = ['header' => 'Game List'];
        $this->view = $this->controller . 'list';
        $data = $this->initialize();

        #search rules
        $search_rules = array(
            'key' => $this->input->get('q'),
            'rules' => array(['key' => 'name', 'value' => 'both'])
        );

        $where = NULL;

        if ($this->input->get('from') || $this->input->get('to')) {
            $from = $this->input->get('from');
            $to = $this->input->get('to');
            if (empty($to)) {
                $to = $from;
            }
            if (empty($from)) {
                $from = $to;
            }
            $where[] = "DATE_FORMAT(date, '%Y-%m-%d') BETWEEN '" . $from . "' AND '" . $to . "'";
        }

        #offset	
        $this->offset = ((empty($page_count)) ? 0 : $this->limit * ($page_count - 1));

        #model
        $query = new $this->model;

        $query->get([
            'select' => ['id', 'name', 'is_active'],
            'limit' => $this->limit,
            'offset' => $this->offset,
            'like' => $search_rules,
            'where' => $where,
            'order' => array(['key' => 'id', 'value' => 'asc'])
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
        show_404();
    }

    public function delete($id)
    {
        show_404();
    }

    public function check_name($value)
    {

        $this->form_validation->set_message(
            'check_name', 'This Game is already exist. Please create another one'
        );
        $model = $this->{$this->model}->check_column_exist('name', $value);
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
