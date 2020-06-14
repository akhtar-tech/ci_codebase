<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Auth extends WEB_Controller
{

    function __construct()
    {
        parent::__construct(['instance' => 'dir_2']);

        #global path declaration
        $this->login_path = $this->sub_directory['link'] . 'auth/login';
        $this->auth_check = TRUE;

        $this->infoKey = 'login_msg';
        $this->model = 'users_model';
        $this->controller = 'auth/';

        #model declaration
        $this->load->model($this->model);
        
        //$this->load_storage();
    }

    public function logout($flag = NULL)
    {
        //$this->output->delete_cache();

        $this->title = 'logout';
        $this->page_code = 'LOGOUT';
        $this->data = ['header' => 'Logout'];
        $this->auth_check = FALSE;
        $data = $this->initialize();

        $this->session->unset_userdata($this->project_code . $this->instance);

        if ($flag == 'all') {
            $this->session->sess_destroy();
            redirect($this->sub_directory['link'] . 'auth/login');
        } else {

            redirect($this->sub_directory['link'] . 'auth/login');
        }

    }

    public function login()
    {

        $model_name = $this->model;

        #data initialization
        $this->title = 'login';
        $this->page_code = 'LOGIN';
        $this->data = array('header' => 'Login');
        $this->view = $this->controller . 'login';
        $data = $this->initialize();

        $this->load_storage();

        $data['referer'] = (isset($this->storage['request_uri'])) ? $this->storage['request_uri'] : $this->sub_directory['link'];
        //debug($this->input->post());
        #data validation
        $this->form_validation->set_data($this->input->post());
        $this->form_validation->set_rules('phone', 'Mobile', 'trim|required|numeric|min_length[10]|max_length[10]|callback_check_login_mobile');

        if ($this->input->post('hash')) {
            $this->form_validation->set_rules('otp', 'OTP', 'trim|required|numeric|callback_check_login_otp[' . json_encode($this->input->post()) . ']');
        }

        $data['form_data'] = $this->input->post();


        $mobile = $this->input->post('phone');
        $password = $this->input->post('otp');
        $hash = $this->input->post('hash');

        if ($this->form_validation->run() === FALSE) {
            $data['form_error'] = $this->form_validation->error_array();
            if (!empty(validation_errors())) {
                $this->setInfo('login_msg', 'Invalid Login', 'danger');
            }

            if (!empty($mobile) && !empty($hash)) {
                $data['form_data']['hash'] = $this->util->random_number();

                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . $this->controller . "verify-otp", $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            } else {
                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . $data['view'], $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            }
        } else {

            //$referer = $this->input->post('referer');

            if (!empty($mobile) && !empty($password) && !empty($hash)) {

                $user = $this->{$this->model}->login($mobile, $password);

                if ($user) {

                    $user_data = array(
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name,
                        'phone' => $user->phone,
                        'branch_id' => $user->branch_id,
                    );

                    $this->set_user($user_data);

            

                    $otp = $this->util->random_number();
                    $obj1 = new Obj;
                    $obj1->setRequest('password', $otp);
                    $obj1->setRequest('otp_time', $this->util->date());
                    $obj1->setRequest('otp_count', 0);
                    $this->users_model->update([
                        'where' => array(
                            ['key' => 'phone', 'value' => $mobile]
                        ),
                        'data' => $obj1->getRequest()
                    ]);
                    if($this->storage['user']){
                        $this->setInfo('login_success_msg', 'You are logged in successfully', 'success');
                    }
                    else{
                        $this->setInfo('login_success_msg', 'Login Failed', 'danger');
                    }

                    redirect(base_url().'rank');
                } else {

                    $this->setInfo('login_msg', 'Invalid Login', 'danger');
                    $this->load->view($data['path'] . 'includes/header.php', $data);
                    $this->load->view($data['path'] . $data['view'], $data);
                    $this->load->view($data['path'] . 'includes/footer.php', $data);
                    //redirect($this->sub_directory['link'] . 'auth/login');
                }

            } else if (!empty($mobile)) {
                $otp = rand(111111, 999999);

                $otp_msg = "Use OTP ".$otp." to Login at\n\n".base_url()."\n\nto Check expected GATE Score after Uploading (PDF) copy of Response Sheet generated from Google Chrome.";
                $sms_data = $this->send_sms($mobile, $otp_msg);


                $obj1 = new Obj;
                $obj1->setRequest('password', $otp);
                $obj1->setRequest('otp_time', $this->util->date());

                $this->users_model->update([
                    'where' => array(
                        ['key' => 'phone', 'value' => $mobile]
                    ),
                    'data' => $obj1->getRequest()
                ]);
                $data['form_data']['hash'] = $this->util->random_number();
                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . $this->controller . "verify-otp", $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            } else {

            }

        }
    }


    public function register()
    {
        if (@get_user()['logged_in'] == TRUE) {
            redirect(base_url());
        }
        #data initialization
        $this->title = 'User Registration';
        $this->page_code = 'USER_REGISTRATION';
        $this->data = ['header' => 'User Registration'];
        $this->view = $this->controller . 'register';
        $this->auth_check = FALSE;
        $data = $this->initialize();

        #model
        $data['branch_list'] = $this->branch_list();

        $query2 = new Users_model();
        //$query2->query("select id from users where phone='".$this->input->post('phone')."' and email_otp!='' and mobile_otp!='' LIMIT 1");
        $query2->query("select id,is_active,email_otp,mobile_otp,email,phone,branch_id,name from users where phone='" . $this->input->post('phone') . "' LIMIT 1");

        if (count($query2->data()) && empty($this->input->post('hash'))) {

            if ($query2->data(0)['is_active'] == "0" && !empty($query2->data(0)['mobile_otp']) && !empty($query2->data(0)['email_otp'])) {
                //$data['form_data'] = $this->input->post();

                $mobile_otp = rand(111111, 999999);
                $email_otp = rand(111111, 999999);
                $otp_msg = "Use OTP ".$mobile_otp." to Login at\n\n".base_url()."\n\nto Check expected GATE Score after Uploading (PDF) copy of Response Sheet generated from Google Chrome.";
                $otp_msg_email = "Use " . $email_otp . " OTP to login for your expected score." . base_url();
                $sms_data = $this->send_sms($this->input->post('phone'), $otp_msg);
                $email_data = $this->send_email($this->input->post('email'), $otp_msg_email);

                $obj3 = new Obj;
               // $obj3->setRequest('email_otp', $email_otp);
                $obj3->setRequest('mobile_otp', $mobile_otp);
                $obj3->setRequest('email', $this->input->post('email'));
                $obj3->setRequest('name', $this->input->post('name'));
                $obj3->setRequest('branch_id', $this->input->post('branch'));


                $this->users_model->update([
                    'id' => $query2->data(0)['id'],
                    'data' => $obj3->getRequest()
                ]);

                $query3 = new Users_model();
                $query3->get([
                    'select' => ['id','name','email','phone','is_active','email_otp','mobile_otp','branch_id'],
                    'id' => $query2->data(0)['id']
                ]);

                $data['form_data'] = $query3->data(0);
                $data['form_data']['branch'] = $query3->data(0)['branch_id'];
                //$data['form_data']['email_otp'] = $query2->data(0)['email_otp'];
                $data['form_data']['hash'] = $this->util->random_number();
                unset($data['form_data']['mobile_otp']);
                //unset($data['form_data']['email_otp']);



                $this->load->view($data['path'] . 'includes/header.php', $data);
                $this->load->view($data['path'] . $data['view'], $data);
                $this->load->view($data['path'] . 'includes/footer.php', $data);
            } else {
                $this->session->set_flashData('error', TRUE);
                $this->set_info($data['infoKey'], 'You are already registered. Please login !', 'warning');
                redirect($data['link'] . "auth/login");
            }


        } else {
            #validation rules
            $this->form_validation->set_data($this->input->post());

            $this->form_validation->set_rules('name', 'Name', 'trim|required|regex_match[/^[a-zA-Z_ ]+$/]');
            $this->form_validation->set_rules('phone', 'Mobile No.', 'trim|required|numeric|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');


            if (empty($this->input->post('hash'))) {
                $this->form_validation->set_rules('phone', 'Mobile No.', 'trim|required|numeric|min_length[10]|max_length[10]|callback_check_mobile_exist');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email_exist');
                $this->form_validation->set_rules('branch', 'Branch', 'trim|required');
                //$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'trim|required|min_length[8]|matches[password]');
            } else {
                $this->form_validation->set_rules('mobile_otp', 'Mobile OTP', 'callback_check_mobile_otp[' . json_encode($this->input->post()) . ']');
                $this->form_validation->set_rules('email_otp', 'Email OTP', 'callback_check_email_otp[' . json_encode($this->input->post()) . ']');
            }

            $data['referer'] = (isset($this->storage['request_uri'])) ? $this->storage['request_uri'] : $this->sub_directory['link'];

            /*if (@$data['form_data']['phone'] != $this->input->post('phone')) {
                $this->form_validation->set_rules('phone', 'Mobile', 'callback_check_mobile');
            }*/

            if ($this->form_validation->run() === FALSE || $this->session->flashData('error')) {

                $data['form_error'] = $this->form_validation->error_array();
                #input
                if (!empty(validation_errors())) {
                    $data['form_data'] = $this->input->post();
                }

                #view
                #$data['css'] = $this->load->view($data['path'] . 'includes/css.php', $data, TRUE);
                #$data['script'] = $this->load->view($data['path'] . 'includes/script.php', $data, TRUE);


                if (!empty($this->input->post('hash'))) {
                    $data['form_data'] = $this->input->post();

                    $data['form_data']['hash'] = $this->util->random_number();
                    $this->load->view($data['path'] . 'includes/header.php', $data);
                    $this->load->view($data['path'] . $data['view'], $data);
                    $this->load->view($data['path'] . 'includes/footer.php', $data);
                } else {


                    $this->load->view($data['path'] . 'includes/header.php', $data);
                    $this->load->view($data['path'] . $data['view'], $data);
                    $this->load->view($data['path'] . 'includes/footer.php', $data);


                }

            } else {

                if (empty($this->input->post('hash')) && empty($this->input->post('mobile_otp')) && empty($this->input->post('email_otp'))) {
                    $otp = $this->util->random_number();
                    $obj = new Obj;

                    $obj->setRequest('name', $this->input->post('name'));
                    $obj->setRequest('phone', $this->input->post('phone'));
                    $obj->setRequest('email', $this->input->post('email'));
                    $obj->setRequest('branch_id', $this->input->post('branch'));
                    $obj->setRequest('otp_time', $this->util->date());
                    $obj->setRequest('password', $otp);
                    $obj->setRequest('is_active', '0');
                    $obj->setRequest('date_created', $this->util->date());

                    /* $file1 = $this->file_upload->upload([
                        'key' => 'img1',
                        'upload_path' => './data/'.$data['path'].'profile',
                        'remote_upload_url' => $this->data_config['remote_upload_url']
                        ]);

                        if ($file1['status']) {
                        $obj->setRequest('image', $file1['data']['upload_data']['file_name']);
                    } */

                    #model
                    $query = new $this->model;
                    $query->create([
                        'data' => $obj->getRequest()
                    ]);

                    $this->set_info($data['infoKey'], 'Dear User,\nYou have been successfully registered with www.checkgaterank.com.\nPlease enter OTP received at your mobile number.\n(Next Step : Upload your response Sheet) ', 'success');

                    if ($query->status() === TRUE) {


                        $data['form_data'] = $this->input->post();
                        $data['form_data']['hash'] = $this->util->random_number();


                        $mobile_otp = rand(111111, 999999);
                        $email_otp = rand(111111, 999999);
                        $otp_msg = "Use OTP ".$mobile_otp." to Login at\n\n".base_url()."\n\nto Check expected GATE Score after Uploading (PDF) copy of Response Sheet generated from Google Chrome.";
                        $otp_msg_email = "Use " . $email_otp . " OTP to login for your expected score." . base_url();
                        $sms_data = $this->send_sms($this->input->post('phone'), $otp_msg);
                        $email_data = $this->send_email($this->input->post('email'), $otp_msg_email);

                        $obj1 = new Obj;
                        $obj1->setRequest('mobile_otp', $mobile_otp);
                        $obj1->setRequest('email_otp', $email_otp);
                        $this->users_model->update([
                            'id' => $query->id(),
                            'data' => $obj1->getRequest()
                        ]);

                        $data['form_data']['email_otp'] = $email_otp;
                        $this->load->view($data['path'] . 'includes/header.php', $data);
                        $this->load->view($data['path'] . $data['view'], $data);
                        $this->load->view($data['path'] . 'includes/footer.php', $data);

                    } else {

                        $this->session->set_flashData('error', TRUE);
                        $this->set_info($data['infoKey'], 'Something went wrong !', 'danger');
                        $this->register();


                    }
                } else {

                    $check_user = new Users_model();
                    $check_user->get([
                        'where' => array(
                            ['key' => 'is_active', 'value' => '0'],
                            ['key' => 'mobile_otp', 'value' => $this->input->post('mobile_otp')],
                            ['key' => 'email_otp', 'value' => $this->input->post('email_otp')],
                            ['key' => 'phone', 'value' => $this->input->post('phone')],
                            ['key' => 'email', 'value' => $this->input->post('email')]
                        ),
                        'limit' => 1,
                        'select' => ['id']
                    ]);

                    if ($check_user->status()) {
                        $otp = $this->util->random_number();
                        $obj1 = new Obj;
                        $obj1->setRequest('mobile_otp', '', TRUE);
                        $obj1->setRequest('email_otp', '', TRUE);
                        $obj1->setRequest('otp_time', $this->util->date());
                        $obj1->setRequest('otp_count', 0);
                        $obj1->setRequest('is_active', '1');
                        $obj1->setRequest('password', $otp);
                        $query1 = new Users_model();
                        $query1->update([
                            'where' => array(
                                ['key' => 'phone', 'value' => $this->input->post('phone')]
                            ),
                            'data' => $obj1->getRequest()
                        ]);

                        $user = $this->{$this->model}->login($this->input->post('phone'), $otp);

                        if ($user) {

                            $user_data = array(
                                'id' => $user->id,
                                'email' => $user->email,
                                'name' => $user->name,
                                'phone' => $user->phone
                            );

                            $this->set_user($user_data);

                            $this->setInfo('login_msg', 'You are logged in', 'success');

                            redirect($data['referer']);
                        } else {
                            $this->session->set_flashData('error', TRUE);
                            $this->set_info($data['infoKey'], 'Invalid Login !', 'danger');
                            $this->register();
                        }
                    } else {
                        $this->session->set_flashData('error', TRUE);
                        $this->set_info($data['infoKey'], 'Invalid Login !', 'danger');
                        $this->register();
                    }

                    //redirect($data['link'] . $this->controller . 'login');
                }
            }
        }


    }

    public function check_login_otp($value1, $value2)
    {
        $value2 = json_decode($value2, TRUE);
        $this->form_validation->set_message(
            'check_login_otp', 'Invalid OTP'
        );

        $this->load->model('users_model');
        $query = new Users_model();
        $query->get([
            'select' => ['id'],
            'where' => array(
                ['key' => 'phone', 'value' => $value2['phone']],
                ['key' => 'password', 'value' => $value2['otp']],
            )
        ]);
        if ($query->status()) {
            return true;
        } else {
            return false;
        }
    }

    public function check_mobile_otp($value1, $value2)
    {
        $value2 = json_decode($value2, TRUE);
        $this->form_validation->set_message(
            'check_mobile_otp', 'Please enter correct OTP'
        );

        $this->load->model('users_model');
        $query = new Users_model();
        $query->get([
            'select' => ['id'],
            'where' => array(
                ['key' => 'phone', 'value' => $value2['phone']],
                ['key' => 'mobile_otp', 'value' => $value2['mobile_otp']],
            )
        ]);
        if ($query->status()) {
            return true;
        } else {
            return false;
        }
    }

    public function check_email_otp($value1, $value2)
    {
        $value2 = json_decode($value2, TRUE);
        $this->form_validation->set_message(
            'check_email_otp', 'Invalid email OTP'
        );

        $this->load->model('users_model');
        $query = new Users_model();
        $query->get([
            'select' => ['id'],
            'where' => array(
                ['key' => 'phone', 'value' => $value2['phone']],
                ['key' => 'email_otp', 'value' => $value2['email_otp']],
            )
        ]);
        if ($query->status()) {
            return true;
        } else {
            return false;
        }
    }

    public function check_login_mobile($value)
    {
        $this->load->model('users_model');
        $this->form_validation->set_message(
            'check_login_mobile', 'Invalid mobile no.'
        );

        $query = new Users_model();
        $query->get([
            'select' => ['id'],
            'limit' => 1,
            'where' => array(
                ['key' => 'is_active', 'value' => '1'],
                ['key' => 'phone', 'value' => $value]
            )
        ]);
        if ($query->status()) {
            return true;
        } else {
            return false;
        }
    }

    public function check_mobile_exist($email)
    {

        $this->form_validation->set_message(
            'check_mobile_exist', 'This Mobile No. is already exist.'
        );

        if ($this->users_model->check_column_exist('phone', $email)) {
            return false;
        } else {
            return true;
        }
    }

    public function check_email_exist($email)
    {

        $this->form_validation->set_message(
            'check_email_exist', 'This Email is already exist.'
        );

        if ($this->users_model->check_column_exist('email', $email)) {
            return false;
        } else {
            return true;
        }
    }

}
