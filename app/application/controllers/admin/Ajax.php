<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * AJAX Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Ajax extends WEB_Controller
{

    function __construct()
    {
        parent::__construct(['instance' => 'dir_1']);
        $this->controller = "ajax/";
        $this->infoKey = "ajax_msg";
    }

    public function remove_box(){
        $this->load->model('game_item_model');
        $data = $this->initialize();

        $id = $this->input->post('id');

        $query = new Game_item_model;
        $query->delete(['id' => $id]);

        $this->set_info($data['infoKey'], 'Successfully Deleted !', 'danger');
        //redirect($this->sub_directory['link'] . 'service/list');
    }

    public function game_form(){
        #input
        $type = $this->input->post('type');

        #data initialization
        $this->view = 'game/templates/game' . $type;
        $data = $this->initialize();

        $data['css'] = $this->load->view($data['path'] . 'includes/css.php', $data, TRUE);
        $data['script'] = $this->load->view($data['path'] . 'includes/script.php', $data, TRUE);

        $this->load->view($data['path'] . $data['view'], $data);
    }

}
