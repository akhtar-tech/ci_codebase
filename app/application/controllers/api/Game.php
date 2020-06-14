<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Game API Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Game extends API_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_game()
    {
        $auth = $this->rest->auth();

        $this->rest->init('POST');
//logger('error', json_encode($this->input->post()));
        $this->rest->request = $this->input->post();
        $rules = [
            [
                'field' => 'userkey',
                'label' => 'Userkey',
                'rules' => 'trim|required|callback_check_userkey'
                // 'errors' => ['required' => 'You must provide a Name.']
            ]
        ];
        $this->rest->validation($rules);
        // print_r($this->putLog('test'));

        $this->load->model('game_model');
        $this->load->model('game_item_model');

        $game_id = $this->next_game($this->input->post('userkey'));

        $check = $this->game_model->check_column_exist('id', $game_id);

        if ($check) {
            $game = new Game_model;
            $game->get([
                'select' => ['id', 'name', 'desp', 'content_help', 'type', 'points', 'game_index'],
                'id' => $game_id
            ]);

            $data['game'] = $game->data(0);

            $sub_game = new Game_item_model;

            if ($game->data(0)['type'] == 1) {
                $sub_game->get([
                    'select' => [
                        'id',
                        'CONCAT("' . media_url() . '", "data/game/", image1) AS image1',
                        'CONCAT("' . media_url() . '", "data/game/", image2) AS image2',
                        'content1',
                        'content2',
                        'answer'
                    ],
                    'where' => array(['key' => 'game_id', 'value' => $game_id])
                ]);

                $data['game']['sub_game'] = $sub_game->data();
            }
            if ($game->data(0)['type'] == 2) {
                $sub_game->get([
                    'select' => [
                        'id',
                        'CONCAT("' . media_url() . '", "data/game/", image1) AS image1',
                        'content1',
                        'answer'
                    ],
                    'where' => array(['key' => 'game_id', 'value' => $game_id])
                ]);

                $data['game']['sub_game'] = $sub_game->data();
            }


            $obj1 = new Obj;
            $obj1->setRequest('data', $data);
            $obj1->setRequest('msg', 'success');
            $this->rest->response($obj1->getRequest(), Rest::HTTP_OK);
        } else {
            $obj1 = new Obj;
            $obj1->setRequest('data', NULL);
            $obj1->setRequest('msg', 'not found');
            $this->rest->response($obj1->getRequest(), Rest::HTTP_NOT_FOUND);
        }
    }

    public function set_game()
    {
        $auth = $this->rest->auth();
        $data = $this->rest->init('POST');
        $data['response'] = NULL;
        $data['error'] = NULL;

        //debug($data['config']['date']);die;
        //logger('error', json_encode($this->input->post()));
        $this->rest->request = $this->input->post();
        $rules = [
            [
                'field' => 'userkey',
                'label' => 'Userkey',
                'rules' => 'required|callback_check_userkey'
                // 'errors' => ['required' => 'You must provide a Name.']
            ],
            [
                'field' => 'game_id',
                'label' => 'GameID',
                'rules' => 'required|numeric|callback_check_game_id[' . json_encode($this->input->post()) . ']|callback_is_valid_game[' . json_encode($this->input->post()) . ']'
                // 'errors' => ['required' => 'You must provide a Name.']
            ],
            [
                'field' => 'game_data',
                'label' => 'Game Data',
                'rules' => 'required'
                // 'errors' => ['required' => 'You must provide a Name.']
            ]
        ];
        $this->rest->validation($rules);


        #models
        $this->load->model('users_model');
        $this->load->model('game_model');
        $this->load->model('game_item_model');
        $this->load->model('game_data_model');
        $this->load->model('quiz_answer_model');

        $requested_game_data = json_decode($this->input->post('game_data'), TRUE);
        $game_id = $this->input->post('game_id');
        $userkey = $this->input->post('userkey');
        $points = 0;

        $user = new Users_model;
        $user->get([
            'where' => array(
                ['key' => 'userkey', 'value' => $userkey]
            )
        ]);
        $user_data = $user->data(0);

        $game = new Game_model;
        $game->get(['id' => $game_id]);
        $game_data = $game->data(0);

        $sub_data_inc = NULL;

        if (count($requested_game_data)) {
            foreach ($requested_game_data as $item) {
                $obj1 = new Obj;

                /* $sub_game = new Game_item_model;
                 $sub_game->get([
                     'id' => $item['sub_game_id']
                 ]);
                 $sub_game_data = $sub_game->data(); */

                $check_game_item = new Game_item_model;
                $check_game_item->get([
                    'select' => ['id'],
                    'limit' => 1,
                    'where' => array(
                        ['key' => 'game_id', 'value' => $this->input->post('game_id')],
                        ['key' => 'id', 'value' => $item['sub_game_id']]
                    )
                ]);


                $obj1->setRequest('userkey', $this->input->post('userkey'));
                $obj1->setRequest('game_id', $this->input->post('game_id'));
                $obj1->setRequest('sub_game_id', $item['sub_game_id']);

                $obj1->setRequest('date', $this->util->date());

                if ($check_game_item->status() == TRUE) {

                    if ($game_data['points'] >= $item['points']) {
                        $points += $item['points'];
                        $obj1->setRequest('points', $item['points']);
                    } else {
                        $points += $game_data['points'];
                        $obj1->setRequest('points', $game_data['points']);
                    }

                    $query = new Game_data_model;
                    $query->create([
                        'data' => $obj1->getRequest()
                    ]);
                    $sub_data_inc++;
                }
            }
        }

        if (!empty($points)) {
            $obj2 = new Obj;
            $obj2->setRequest('userkey', $this->input->post('userkey'));
            $obj2->setRequest('quiz_id', $this->input->post('game_id'));
            $obj2->setRequest('answer', $this->input->post('game_data'));
            $obj2->setRequest('date', $this->util->date());
            $obj2->setRequest('points', $points);

            $query2 = new Quiz_answer_model;
            $query2->create([
                'data' => $obj2->getRequest()
            ]);
        }

        $data['response']['points'] = (string)$points;
        if ($points <= 20) {

            $data['response']['rating_share'] = FALSE;
            $data['response']['rating_star'] = (string)0;
            $data['response']['rating_content'] = $game_data['rating_content1'];
        }
        if ($points >= 30 && $points <= 40) {

            $data['response']['rating_share'] = FALSE;
            $data['response']['rating_star'] = (string)1;
            $data['response']['rating_content'] = $game_data['rating_content2'];
        }
        if ($points >= 50) {

            $data['response']['rating_share'] = TRUE;
            $data['response']['rating_star'] = (string)3;
            $data['response']['rating_content'] = $game_data['rating_content3'];
        }

        if ($sub_data_inc == NULL) {
            $data['error'][] = "invalid game_data !";
        }

        if (count($data['error'])) {
            $obj1 = new Obj;
            $obj1->setRequest('data', $data['error']);
            $obj1->setRequest('msg', 'failed');
            $this->rest->response($obj1->getRequest(), Rest::HTTP_FORBIDDEN);
        } else {
            $obj1 = new Obj;
            $obj1->setRequest('data', $data['response']);
            $obj1->setRequest('msg', 'success');
            $this->rest->response($obj1->getRequest(), Rest::HTTP_OK);
        }
    }
}
