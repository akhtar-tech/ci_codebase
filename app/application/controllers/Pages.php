<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Pages extends WEB_Controller
{

    function __construct()
    {

        parent::__construct(['instance' => 'dir_2']);

        $this->login_path = $this->sub_directory['link'] . 'auth/login';
        //$this->auth_check = FALSE;
        $this->infoKey = 'home_msg';
        $this->controller = 'pages/';
    }

    public function test()
    {
        /* var_dump('ENVIRONMENT => '.ENVIRONMENT);echo '<br />';
        var_dump('FCPATH => '.FCPATH);echo '<br />';
        var_dump('SELF => '.SELF);echo '<br />';
        var_dump('BASEPATH => '.BASEPATH);echo '<br />';
        var_dump('APPPATH => '.APPPATH);echo '<br />';
        var_dump('VIEWPATH => '.VIEWPATH);echo '<br />';
        var_dump('CI_VERSION => '.CI_VERSION);echo '<br />';
        var_dump('MB_ENABLED => '.MB_ENABLED);echo '<br />';
        var_dump('ICONV_ENABLED => '.ICONV_ENABLED);echo '<br />';
        var_dump('UTF8_ENABLED => '.UTF8_ENABLED);echo '<br />';
        var_dump('FILE_READ_MODE => '.FILE_READ_MODE);echo '<br />';
        var_dump('FILE_WRITE_MODE => '.FILE_WRITE_MODE);echo '<br />';
        var_dump('DIR_READ_MODE => '.DIR_READ_MODE);echo '<br />';
        var_dump('DIR_WRITE_MODE => '.DIR_WRITE_MODE);echo '<br />';
        var_dump('FOPEN_READ => '.FOPEN_READ);echo '<br />';
        var_dump('FOPEN_READ_WRITE => '.FOPEN_READ_WRITE);echo '<br />';
        var_dump('FOPEN_WRITE_CREATE_DESTRUCTIVE => '.FOPEN_WRITE_CREATE_DESTRUCTIVE);echo '<br />';
        var_dump('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE => '.FOPEN_READ_WRITE_CREATE_DESTRUCTIVE);echo '<br />';
        var_dump('FOPEN_WRITE_CREATE => '.FOPEN_WRITE_CREATE);echo '<br />';
        var_dump('FOPEN_READ_WRITE_CREATE => '.FOPEN_READ_WRITE_CREATE);echo '<br />';
        var_dump('FOPEN_WRITE_CREATE_STRICT => '.FOPEN_WRITE_CREATE_STRICT);echo '<br />';
        var_dump('FOPEN_READ_WRITE_CREATE_STRICT => '.FOPEN_READ_WRITE_CREATE_STRICT);echo '<br />';
        var_dump('SHOW_DEBUG_BACKTRACE => '.SHOW_DEBUG_BACKTRACE);echo '<br />';
        var_dump('EXIT_SUCCESS => '.EXIT_SUCCESS);echo '<br />';
        var_dump('EXIT_ERROR => '.EXIT_ERROR);echo '<br />';
        var_dump('EXIT_CONFIG => '.EXIT_CONFIG);echo '<br />';
        var_dump('EXIT_UNKNOWN_FILE => '.EXIT_UNKNOWN_FILE);echo '<br />';
        var_dump('EXIT_UNKNOWN_CLASS => '.EXIT_UNKNOWN_CLASS);echo '<br />';
        var_dump('EXIT_UNKNOWN_METHOD => '.EXIT_UNKNOWN_METHOD);echo '<br />';
        var_dump('EXIT_USER_INPUT => '.EXIT_USER_INPUT);echo '<br />';
        var_dump('EXIT_DATABASE => '.EXIT_DATABASE);echo '<br />';
        var_dump('EXIT__AUTO_MIN => '.EXIT__AUTO_MIN);echo '<br />';
        var_dump('EXIT__AUTO_MAX => '.EXIT__AUTO_MAX);echo '<br />'; */


        //        // Initialize a variable into domain name 
        // $domain1 = 'http://localhost/ci_codebase/pages/test'; 

        // // Function to get HTTP response code  
        // function get_http_response_code($domain1) { 
        //     $headers = get_headers($domain1); 
        //     return substr($headers[0], 9, 3); 
        // } 

        // // Function call  
        // $get_http_response_code = get_http_response_code($domain1); 

        // // Display the HTTP response code 
        // echo $get_http_response_code; 
    }

    public function layout($page = 'home')
    {

        $this->title = $page;
        $this->data = ['header' => ucwords($page)];
        $this->page_code = strtoupper($page);
        $this->view = $this->controller . $page;
        $this->auth_check = FALSE;
        $this->login_path = $this->sub_directory['link'] . 'auth/login';
        $this->isXHR = true;
        $data = $this->initialize();

        if ($this->page_code == 'HOME') {

            // $this->load->view($data['path'] . 'includes/header.php', $data);
            $this->load->view($data['path'] . $data['view'], $data);
            //$this->load->view($data['path'] . 'includes/footer.php', $data);

        } else {
            echo "Error in loading view!";
        }
    }


    public function feedback()
    {
        $this->load->model('feedback_model');
        #data initialization
        $this->title = 'Feedback';
        $this->page_code = 'FEEDBACK';
        $this->auth_check = FALSE;
        $this->data = ['header' => 'Feedback'];
        $this->view = $this->controller . 'feedback';
        $data = $this->initialize();

        $panel = TRUE;

        #model

        #validation rules
        $this->form_validation->set_data($this->input->post());

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone No.', 'trim|required|numeric|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('msg', 'Message', 'trim|required');


        if ($this->form_validation->run() === FALSE || $this->session->flashData('error')) {

            $data['form_error'] = $this->form_validation->error_array();
            #input
            if (!empty(validation_errors())) {
                $data['form_data'] = $this->input->post();
            }

            $this->load->view($data['path'] . 'includes/header.php', $data);
            $this->load->view($data['path'] . $data['view'], $data);
            $this->load->view($data['path'] . 'includes/footer.php', $data);
        } else {

            $obj = new Obj;

            $this->file_upload->files = $_FILES;

            $file1 = $this->file_upload->upload([
                'key' => 'file',
                'upload_path' => './data/feedback',
                'remote_upload_url' => $this->data_config['remote_upload_url']
            ]);

            if ($file1['status']) {
                $obj->setRequest('file', $file1['data']['upload_data']['file_name']);
            }

            $obj->setRequest('name', $this->input->post('name'));
            $obj->setRequest('email', $this->input->post('email'));
            $obj->setRequest('phone', $this->input->post('phone'));
            $obj->setRequest('msg', $this->input->post('msg'));
            $obj->setRequest('is_active', '1');
            $obj->setRequest('date_created', $this->util->date());

            #model
            $query = new Feedback_model();
            $query->create([
                'data' => $obj->getRequest()
            ]);

            $this->set_info($data['infoKey'], 'Your feedback has been submitted successfully.', 'success');

            if ($query->status() === TRUE) {
                redirect($data['link'] . 'feedback');
            } else {
                $this->session->set_flashData('error', TRUE);
                $this->set_info($data['infoKey'], 'Something went wrong !', 'danger');
                redirect($data['link'] . 'feedback');
            }
        }
    }

    public function advertise()
    {
        $this->load->model('advertise_model');
        #data initialization
        $this->title = 'Advertise';
        $this->page_code = 'ADVERTISE';
        $this->auth_check = FALSE;
        $this->data = ['header' => 'Advertise'];
        $this->view = $this->controller . 'advertise';
        $data = $this->initialize();

        $panel = TRUE;

        #model

        #validation rules
        $this->form_validation->set_data($this->input->post());

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone No.', 'trim|required|numeric|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('orgnization', 'Orgnization', 'trim|required');
        $this->form_validation->set_rules('website', 'Website', 'trim|required');


        if ($this->form_validation->run() === FALSE || $this->session->flashData('error')) {

            $data['form_error'] = $this->form_validation->error_array();
            #input
            if (!empty(validation_errors())) {
                $data['form_data'] = $this->input->post();
            }

            $this->load->view($data['path'] . 'includes/header.php', $data);
            $this->load->view($data['path'] . $data['view'], $data);
            $this->load->view($data['path'] . 'includes/footer.php', $data);
        } else {

            $obj = new Obj;

            $this->file_upload->files = $_FILES;

            $obj->setRequest('name', $this->input->post('name'));
            $obj->setRequest('email', $this->input->post('email'));
            $obj->setRequest('phone', $this->input->post('phone'));
            $obj->setRequest('designation', $this->input->post('designation'), TRUE);
            $obj->setRequest('orgnization', $this->input->post('orgnization'));
            $obj->setRequest('website', $this->input->post('website'));
            $obj->setRequest('location', $this->input->post('location'), TRUE);
            $obj->setRequest('is_active', '1');
            $obj->setRequest('date_created', $this->util->date());

            #model
            $query = new Advertise_model();
            $query->create([
                'data' => $obj->getRequest()
            ]);

            $this->set_info($data['infoKey'], 'Dear ' . $this->input->post('name') . ',\nWe will reply you within 24hours, on screening your profile.\nThank you', 'success');

            if ($query->status() === TRUE) {
                redirect($data['link'] . 'feedback');
            } else {
                $this->session->set_flashData('error', TRUE);
                $this->set_info($data['infoKey'], 'Something went wrong !', 'danger');
                redirect($data['link'] . 'feedback');
            }
        }
    }


    public function get_rank()
    {

        $this->load->model('users_model');
        $this->load->model('branch_model');
        $this->load->model('user_response_model');
        $this->load->model('user_response_record_model');


        #data initialization
        $this->title = 'Get Rank';
        $this->page_code = 'GET_RANK';
        $this->data = ['header' => 'Get Rank'];
        $this->auth_check = TRUE;
        $data = $this->initialize();

        $status = TRUE;

        $user = $this->users_model->get([
            'id' => get_user()['id']
        ]);

        $branch = $this->branch_model->get([
            'id' => $user->data(0)['branch_id'],
            'limit' => 1
        ]);

        $data['user']['branch_name'] = $branch->data(0)['name'];

        $user_reponse_record = $this->user_response_record_model->get([
            'where' => array(
                ['key' => 'user_id', 'value' => $user->data(0)['id']],
                ['key' => 'branch_id', 'value' => $user->data(0)['branch_id']],
                ['key' => 'is_active', 'value' => '1'],
            ),
            'limit' => 1
        ]);

        if (count($user_reponse_record->data(0))) {
            redirect($data['link'] . 'rank/list');
        }

        if (empty($this->input->post('upload_type')) || $this->input->post('upload_type') == "link") {
            $data['form_data']['active_tab'] = "link";
        } else {
            $data['form_data']['active_tab'] = "file";
        }

        if ($this->input->post('upload_type') == 'file') {

            $this->file_upload->files = $_FILES;

            $file1 = $this->file_upload->upload([
                'key' => 'file1',
                'allowed_types' => 'pdf',
                'upload_path' => './data/pdf/branch/' . url_string($branch->data(0)['name']) . '/',
                'max_size' => '20480',
                'file_name' => $user->data(0)['phone'] . "-" . url_string($user->data(0)['name']) . ".pdf",
                'remote_upload_url' => $this->data_config['remote_upload_url']
            ]);


            if ($file1['status']) {

                $pdf_data = $this->get_participant_data($file1['data']['upload_data']['full_path']);
                //debug($pdf_data);


                if ($pdf_data) {

                    $insert_pdf = $this->insert_user_response($pdf_data, $user->data(0));
                    if ($insert_pdf['status'] == TRUE) {
                        $err = $insert_pdf['data'];
                        $this->set_info($data['infoKey'], $err, 'success');
                        $this->current_user_rank($user->data(0)['branch_id'], $user->data(0)['id']);
                        redirect($data['link'] . 'rank/list');
                    } else {
                        $err = $insert_pdf['data'];
                        $this->set_info($data['infoKey'], $err, 'warning');

                        $this->load->view($data['path'] . 'includes/header.php', $data);
                        $this->load->view($data['path'] . 'rank/file-upload', $data);
                        $this->load->view($data['path'] . 'includes/footer.php', $data);
                    }
                } else {
                    $err = 'You are NOT uploading proper format (PDF) of Response Sheet.';
                    $this->set_info($data['infoKey'], $err, 'warning');

                    $this->load->view($data['path'] . 'includes/header.php', $data);
                    $this->load->view($data['path'] . 'rank/file-upload', $data);
                    $this->load->view($data['path'] . 'includes/footer.php', $data);
                }
            } else {
                //$err = (isset($file1['data']['error'])) ? strip_tags($file1['data']['error']) : 'You are NOT uploading proper format (PDF) of Response Sheet.';
                $err = 'You are NOT uploading proper format (PDF) of Response Sheet.';
                $this->set_info($data['infoKey'], $err, 'warning');

                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . 'rank/file-upload', $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            }
        } else if ($this->input->post('upload_type') == 'link') {

            $this->form_validation->set_data($this->input->post());
            $this->form_validation->set_rules('link', 'Link', 'trim|required');

            if ($this->form_validation->run() === FALSE || $this->session->flashData('error')) {

                $data['form_error'] = $this->form_validation->error_array();

                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . 'rank/file-upload', $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            } else {

                $file_name = $user->data(0)['phone'] . "-" . url_string($user->data(0)['name']) . ".html";
                $file_path = './data/html/branch/' . url_string($branch->data(0)['name']) . '/';
                if (is_dir($file_path) == false) {
                    // Create directory if it does not exist
                    mkdir($file_path, 0755);
                }
                $full_path = $file_path . $file_name;
                $pdf_uploaded = @copy($this->input->post('link'), $full_path);
                if ($pdf_uploaded) {


                    //$result = $this->html_decoder($full_path);

                    $pdf_data = $this->html_decoder($full_path);

                    if ($pdf_data) {
                        //unlink("data/pdf/" . $file_name);

                        if ($this->match_year(2019, $pdf_data['header']['data']) == FALSE) {
                            $err = 'Incorrect year session';
                            $this->set_info($data['infoKey'], $err, 'warning');

                            $status = FALSE;
                        }

                        if ($this->match_branch($pdf_data['header']['participant']['branch'], $user->data(0)) == FALSE) {
                            $err = 'Incorrect Branch';
                            $this->set_info($data['infoKey'], $err, 'warning');

                            $status = FALSE;
                        }

                        if ($status) {
                            $insert_pdf = $this->insert_user_response($pdf_data, $user->data(0), $this->input->post('link'));
                            if ($insert_pdf['status'] == TRUE) {
                                $err = $insert_pdf['data'];
                                $this->set_info($data['infoKey'], $err, 'success');
                                $this->current_user_rank($user->data(0)['branch_id'], $user->data(0)['id']);
                                redirect($data['link'] . 'rank/list');
                            } else {
                                $err = $insert_pdf['data'];
                                $this->set_info($data['infoKey'], $err, 'warning');

                                $this->load->view($data['path'] . 'includes/header.php', $data);
                                $this->load->view($data['path'] . 'rank/file-upload', $data);
                                $this->load->view($data['path'] . 'includes/footer.php', $data);
                            }
                        } else {
                            $this->load->view($data['path'] . 'includes/header.php', $data);
                            $this->load->view($data['path'] . 'rank/file-upload', $data);
                            $this->load->view($data['path'] . 'includes/footer.php', $data);
                        }
                    } else {
                        $err = 'You are NOT uploading proper format (PDF) of Response Sheet.';
                        $this->set_info($data['infoKey'], $err, 'warning');

                        $this->load->view($data['path'] . 'includes/header.php', $data);
                        $this->load->view($data['path'] . 'rank/file-upload', $data);
                        $this->load->view($data['path'] . 'includes/footer.php', $data);
                    }
                } else {
                    $err = 'You are NOT uploading proper format (PDF) of Response Sheet.';
                    $this->set_info($data['infoKey'], $err, 'warning');

                    $this->load->view($data['path'] . 'includes/header.php', $data);
                    $this->load->view($data['path'] . 'rank/file-upload', $data);
                    $this->load->view($data['path'] . 'includes/footer.php', $data);
                }
            }
        } else {
            $this->load->view($data['path'] . 'includes/header.php', $data);
            $this->load->view($data['path'] . 'rank/file-upload', $data);
            $this->load->view($data['path'] . 'includes/footer.php', $data);
        }
    }


    public function rank_list($page_count = 0)
    {
        $this->load->model('user_response_record_model');
        $this->load->model('users_model');
        $this->load->model('branch_model');
        $this->model = "user_response_model";
        $this->load->model($this->model);

        #data initialization
        $this->title = 'Rank List';
        $this->page_code = 'RANK_LIST';
        $this->auth_check = TRUE;
        $this->data = ['header' => 'Rank List'];
        $data = $this->initialize();

        $this->limit = 20;

        $user = $this->users_model->get([
            'id' => get_user()['id']
        ]);

        $branch = $this->branch_model->get([
            'id' => $user->data(0)['branch_id'],
            'limit' => 1
        ]);

        $user_reponse_record = $this->user_response_record_model->get([
            'where' => array(
                ['key' => 'user_id', 'value' => $user->data(0)['id']],
                ['key' => 'branch_id', 'value' => $user->data(0)['branch_id']],
                ['key' => 'is_active', 'value' => '1'],
            ),
            'limit' => 1
        ]);

        $data['branch_name'] = $branch->data(0)['name'];

        if (!$user_reponse_record->status()) {
            redirect($data['link'] . 'rank');
        }
        $data['section_list'] = NULL;
        $section_list = array(
            ['section_name' => 'general_aptitude'],
            ['section_name' => 'technical']
        );
        $data['branch_list'] = $this->branch_list();

        /*$section_list = $this->user_response_model->get([
            'where' => array(
                ['key' => 'user_id', 'value' => $user->data(0)['id']],
                ['key' => 'branch_id', 'value' => $user->data(0)['branch_id']],
            ),
            'select' => "DISTINCT section_name",
            'order' => "id asc"
        ])->data();*/


        $x = 0;
        foreach ($section_list as $section) {
            $data['section_list'][$x]['section_name'] = $section['section_name'];
            $data['section_list'][$x]['data'] = $this->users_rank(NULL, NULL, $user->data(0)['branch_id'], $user->data(0)['id'], $section['section_name'])[0];
            $x++;
        }

        $data['result_analysis_list'] = $this->result_analysis($user->data(0)['id']);

        #offset
        $this->offset = ((empty($page_count)) ? 0 : $this->limit * ($page_count - 1));

        $total_count = $this->users_rank(NULL, NULL, $user->data(0)['branch_id'], $user->data(0)['id'], NULL, TRUE);
        $total_count = ($total_count);

        $data['message'] = $branch->data(0)['msg'];
        if (!$total_count) {

            $this->set_info($data['infoKey'], $branch->data(0)['msg'], 'warning');
        }


        //$data['rows'] = $query->data();
        $data['rows'] = $this->users_rank($this->limit, $this->offset, $user->data(0)['branch_id'], $user->data(0)['id']);
        $data['user_count'] = $total_count;
        //debug($data['rows']);

        #pagination
        $this->load->library('pagination');

        $config['base_url'] = base_url() . $data['link'] . 'rank/list';
        $config['total_rows'] = $total_count;
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
        $data['total_rows'] = $total_count;
        $data['current_rows'] = (($data['limit'] + ($data['offset'])) > $data['total_rows']) ? $data['total_rows'] : ($data['limit'] + ($data['offset']));

        $this->load->view($data['path'] . 'includes/header.php', $data);
        $this->load->view($data['path'] . 'rank/list', $data);
        $this->load->view($data['path'] . 'includes/footer.php', $data);
    }

    public function clear_response_sheet()
    {
        $this->load->model('user_response_model');
        $this->load->model('user_response_record_model');
        $this->load->model('rank_list_model');

        #data initialization
        $this->title = 'Clear Response Sheet';
        $this->page_code = 'CLEAR_RESPONSE_SHEET';
        $this->auth_check = TRUE;
        $this->data = ['header' => 'Clear Response Sheet'];
        $data = $this->initialize();

        $query = new User_response_model();

        $query->delete([
            'where' => array(
                ['key' => 'user_id', 'value' => get_user()['id']]
            )
        ]);

        $query = new User_response_record_model();
        $query->delete([
            'where' => array(
                ['key' => 'user_id', 'value' => get_user()['id']]
            )
        ]);

        $query = new Rank_list_model();
        $query->delete([
            'where' => array(
                ['key' => 'user_id', 'value' => get_user()['id']]
            )
        ]);

        $this->set_info($data['infoKey'], 'Response Sheet has been cleared successfully', 'success');
        // redirect($data['link'] . 'rank');
    }


    public function send_mail()
    {

        $this->auth_check = FALSE;
        $data = $this->data->init();

        //$link = $this->input->post('link');
        #validation rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');

        if ($this->form_validation->run() === FALSE || $this->session->flashData('error')) {
            if (!empty(validation_errors())) {
                echo "<script>alert('Message not sent successfully');window.location='" . base_url() . "';</script>";
            } else {
                echo "<script>alert('Message not sent successfully');window.location='" . base_url() . "';</script>";
            }
        } else {

            $this->load->library('mailer');
            $this->mailer->config = $data['config']['email_config'];

            //$query = $this->{$this->properties->model_name}->create();
            //$this->properties->setInfo($data['infoKey'], 'Successfully Created !', 'success');

            $content = '<h1>This is a test body.</h1>';

            $mail = $this->mailer->sendMail('Subject', $content, ['<email>'], false);

            if ($mail['status'] == TRUE) {
                echo "<script>alert('Message sent successfully');window.location='" . base_url() . "';</script>";
            } else {
                echo "<script>alert('Message not sent successfully');window.history.back();</script>";
            }
        }
    }
}
