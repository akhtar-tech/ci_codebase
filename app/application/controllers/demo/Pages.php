<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pages Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Pages extends WEB_Controller
{

    function __construct()
    {
        parent::__construct(['instance' => 'dir_1']);

        $this->login_path = $this->sub_directory['link'] . 'auth/login';
        $this->auth_check = TRUE;
        $this->infoKey = 'users_msg';
        $this->model_name = 'users_model';
        $this->controller = 'pages/';

    }

    public function layout($page = 'dashboard')
    {

        #data initialization
        $this->title = $page;
        $this->data = ['header' => ucwords($page)];
        $this->page_code = strtoupper($page);
        $this->view = $this->controller . $page;
        $data = $this->initialize();

        $data['css'] = $this->load->view($data['path'] . 'includes/css.php', $data, TRUE);
        $data['script'] = $this->load->view($data['path'] . 'includes/script.php', $data, TRUE);
        $data['sidebar'] = $this->load->view($data['path'] . 'includes/nav.php', $data, TRUE);

        $this->load->view($data['path'] . 'includes/header.php', $data);
        $this->load->view($data['path'] . $data['view'], $data);
        $this->load->view($data['path'] . 'includes/footer.php', $data);

    }

}
