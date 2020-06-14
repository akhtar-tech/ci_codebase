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
        parent::__construct(['instance' => 'dir_1']);

        #global path declaration
        $this->login_path = $this->sub_directory['link'] . 'auth/login';
        $this->auth_check = TRUE;

        $this->infoKey = 'login_msg';
        $this->model_name = 'auth_model';
        $this->controller = 'auth/';

        #model declaration
        $this->load->model($this->model_name);
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
        }else{
			
			redirect($this->sub_directory['link'] . 'auth/login');
		}

    }

    public function login()
    {

        $model_name = $this->model_name;

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
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email_exist');
        $data['form_data'] = $this->input->post();

        if ($this->form_validation->run() === FALSE) {
            $data['form_error'] = $this->form_validation->error_array();
            if (!empty(validation_errors())) {
                $this->setInfo('login_msg', 'Invalid Login', 'danger');
            }
            $this->load->view($data['path'] . $data['view'], $data);
        } else {

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            //$referer = $this->input->post('referer');
			
            $user = $this->$model_name->login($email, $password);

            if ($user) {

                $user_data = array(
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'image' => $user->image
                );

                $this->set_user($user_data);

                $this->setInfo('login_msg', 'You are logged in', 'success');
				
                redirect($data['referer']);
            } else {

                $this->setInfo('login_msg', 'Invalid Login', 'danger');
                $this->load->view($data['path'] . $data['view'], $data);
                //redirect($this->sub_directory['link'] . 'auth/login');
            }
        }
    }

    public function check_email_exist($email)
    {

        $this->form_validation->set_message(
            'check_email_exist', 'That email is taken. Please choose another one'
        );

        if ($this->auth_model->check_column_exist('email', $email)) {
            return true;
        } else {
            return false;
        }
    }

    public function register()
    {

    }

}
