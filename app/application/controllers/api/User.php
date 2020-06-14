<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User API Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class User extends API_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('rest');
        $this->load->library('obj');
        $this->load->library('util');
        $this->load->library('user_data');
    }

    public function register()
    {

        $this->load->model('users_model');
        $this->load->model('user_answer_model');
        $this->load->model('media_model');
        $this->load->model('media_download_model');
        $this->load->model('rating_model');

        $data = $this->rest->init('POST');
        //$this->rest->auth();

        $this->rest->request = $this->input->post();
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required'
                // 'errors' => ['required' => 'You must provide a Name.']
            ],
            [
                'field' => 'dl_no',
                'label' => 'Driving Licence Number',
                'rules' => 'trim|required'
                // 'errors' => ['required' => 'You must provide a Name.']
            ],
            [
                'field' => 'mobile_no',
                'label' => 'Mobile Number',
                'rules' => 'trim|required|numeric|min_length[10]|max_length[10]'
                // 'errors' => ['required' => 'You must provide a Name.']
            ]
        ];
        $this->rest->validation($rules);

        // print_r($this->putLog('test'));

        $user = new Users_model;
        $user->get([
            'where' => array(
                ['key' => 'dl_no', 'value' => $this->input->post('dl_no')],
                ['key' => 'mobile', 'value' => $this->input->post('mobile_no')]
            )
        ]);

        if ($user->status() != TRUE) {


            $response = NULL;
            $userkey = $this->user_data->getUserKey();
            $reff_key = $this->user_data->getReferralKey();
            $check_reff_key = '';
            $check_reff = new Users_model;
            if ($this->input->post('referral_key')) {


                $check_reff->get([
                    'where' => array(
                        ['key' => 'user_referral_key', 'value' => $this->input->post('referral_key')]
                    )
                ]);

                $check_reff_key = ($check_reff->status() == TRUE) ? $check_reff->data(0)['user_referral_key'] : '';
            }

            $rules = [
                [
                    'field' => 'dl_no',
                    'label' => 'Driving Licence Number',
                    'rules' => 'trim|required|callback_check_dl_no'
                    // 'errors' => ['required' => 'You must provide a Name.']
                ],
                [
                    'field' => 'mobile_no',
                    'label' => 'Mobile Number',
                    'rules' => 'trim|required|numeric|min_length[10]|max_length[10]|callback_check_mobile_no'
                    // 'errors' => ['required' => 'You must provide a Name.']
                ]
            ];
            $this->rest->validation($rules);

            $obj1 = new Obj;

            $obj1->setRequest('name', $this->input->post('name'));
            $obj1->setRequest('user_id', $this->user_data->getId(2, 2));
            $obj1->setRequest('user_referral_key', $reff_key);
            $obj1->setRequest('applied_referral_key', $check_reff_key, TRUE);
            $obj1->setRequest('userkey', $userkey);
            $obj1->setRequest('mobile', $this->input->post('mobile_no'));
            $obj1->setRequest('dl_no', $this->input->post('dl_no'));
            $obj1->setRequest('auth_key', $this->util->encoded_random_number());
            $obj1->setRequest('is_active', 1);
            $obj1->setRequest('date', $this->util->date());

            $usr = new Users_model;
            $response = $obj1->getRequest();
            $usr->create([
                'data' => $response
            ]);


            if ($usr->status() == TRUE) {
                $obj2 = new Obj;
                $obj2->setRequest('userkey', $userkey);
                $obj2->setRequest('quiz_id', 0);
                $obj2->setRequest('date', $this->util->date());
                $obj2->setRequest('points', 10);

                $response1 = $obj2->getRequest();
                $this->user_answer_model->create([
                    'data' => $response1
                ]);

                $rows = new Users_model;
                $rows->get([
                    'id' => $usr->id()
                ]);

                if ($check_reff->status() == TRUE) {
                    $obj3 = new Obj;
                    $obj3->setRequest('userkey', $check_reff->data(0)['userkey']);
                    $obj3->setRequest('quiz_id', 0);
                    $obj3->setRequest('date', $this->util->date());
                    $obj3->setRequest('points', 10);

                    $response2 = $obj3->getRequest();
                    $this->user_answer_model->create([
                        'data' => $response2
                    ]);


                    $obj4 = new Obj;
                    $obj4->setRequest('userkey', $userkey);
                    $obj4->setRequest('quiz_id', 0);
                    $obj4->setRequest('date', $this->util->date());
                    $obj4->setRequest('points', 10);

                    $response3 = $obj4->getRequest();
                    $this->user_answer_model->create([
                        'data' => $response3
                    ]);
                }

                $quize_answers = new User_answer_model;
                $quize_answers->get([
                    'where' => array(['key' => 'userkey', 'value' => $userkey])
                ]);
                if ($quize_answers->status() == TRUE) {

                    $points = 0;
                    foreach ($quize_answers->data() as $quize_answer) {
                        $points = $points + $quize_answer['points'];
                        $length = 4;
                        $points_length = 4 - strlen($points);
                        $zero = '';
                        for ($i = 0; $i < $points_length; $i++) {
                            $zero .= '0';
                        }
                    }
                    $points = $zero . $points;
                } else {
                    $points = '0000';
                }

                $media = null;


                $medias = new Media_model;
                $medias->get([
                    'where' => array(['key' => 'active', 'value' => 'Active'])
                ]);

                if ($medias->status() == TRUE) {

                    //incompleted....

                    $md = new Media_download_model;
                    $md->get([
                        'where' => array(
                            ['key' => 'media_id', 'value' => $medias->data(0)['id']],
                            ['key' => 'userkey', 'value' => $userkey]
                        )
                    ]);
                    //$md = get_row($conn, "select * from media_download where media_id='{$medias[0]['id']}' and userkey='$userkey'");
                    if ($md->status() != TRUE) {
                        $media = $medias->data(0)['id'];
                    }
                }


                $init_rating = new Rating_model;
                $init_rating->get([
                    'where' => array(['key' => 'userkey', 'value' => $userkey])
                ]);
                //$init_rating = get_row($conn, "select * from rating where userkey='$userkey'");
                if ($init_rating->status() == TRUE) {
                    $rating_init = true;
                } else {
                    $rating_init = false;
                }


                $response = $rows->data(0);
                $response['user_image'] = base_url() . "data/profile/" . $rows->data(0)['image'];
                $response['media'] = $media;
                $response['rating_init'] = $rating_init;
                $response['points'] = $points;
                $response['auth_key'] = $rows->data(0)['auth_key'];

                $obj5 = new Obj;
                $obj5->setRequest('data', $response);
                $obj5->setRequest('msg', 'successfully registered');
                $this->rest->response($obj5->getRequest(), Rest::HTTP_OK);
            } else {


                $obj5 = new Obj;
                $obj5->setRequest('data', $response);
                $obj5->setRequest('msg', 'failed');
                $this->rest->response($obj5->getRequest(), Rest::HTTP_FORBIDDEN);
            }
        } else {

            //user login process...
            $rows = new Users_model;
            $rows->get([
                'id' => $user->data(0)['id']
            ]);
            $userkey = $user->data(0)['userkey'];

            $quize_answers = new User_answer_model;
            $quize_answers->get([
                'where' => array(['key' => 'userkey', 'value' => $userkey])
            ]);
            if ($quize_answers->status() == TRUE) {

                $points = 0;
                foreach ($quize_answers->data() as $quize_answer) {
                    $points = $points + $quize_answer['points'];
                    $length = 4;
                    $points_length = 4 - strlen($points);
                    $zero = '';
                    for ($i = 0; $i < $points_length; $i++) {
                        $zero .= '0';
                    }
                }
                $points = $zero . $points;
            } else {
                $points = '0000';
            }

            $media = null;


            $medias = new Media_model;
            $medias->get([
                'where' => array(['key' => 'active', 'value' => 'Active'])
            ]);

            if ($medias->status() == TRUE) {

                //incompleted....

                $md = new Media_download_model;
                $md->get([
                    'where' => array(
                        ['key' => 'media_id', 'value' => $medias->data(0)['id']],
                        ['key' => 'userkey', 'value' => $userkey]
                    )
                ]);
                //$md = get_row($conn, "select * from media_download where media_id='{$medias[0]['id']}' and userkey='$userkey'");
                if ($md->status() != TRUE) {
                    $media = $medias->data(0)['id'];
                }
            }

            $init_rating = new Rating_model;
            $init_rating->get([
                'where' => array(['key' => 'userkey', 'value' => $userkey])
            ]);
            //$init_rating = get_row($conn, "select * from rating where userkey='$userkey'");
            if ($init_rating->status() == TRUE) {
                $rating_init = true;
            } else {
                $rating_init = false;
            }

            $response = $rows->data(0);
            $response['user_image'] = base_url() . "data/profile/" . $rows->data(0)['image'];
            $response['media'] = $media;
            $response['rating_init'] = $rating_init;
            $response['points'] = $points;
            $response['auth_key'] = $rows->data(0)['auth_key'];

            $obj5 = new Obj;
            $obj5->setRequest('data', $response);
            $obj5->setRequest('msg', 'successfully login');
            $this->rest->response($obj5->getRequest(), Rest::HTTP_OK);
        }
    }

    public function get()
    {
        $auth = $this->rest->auth();
        $data = $this->rest->init('POST');

        $this->load->model('users_model');
        $this->load->model('user_answer_model');
        $this->load->model('media_model');
        $this->load->model('media_download_model');
        $this->load->model('rating_model');

        $this->rest->request = $this->input->post();
        $rules = [
            [
                'field' => 'userkey',
                'label' => 'Userkey',
                'rules' => 'required|callback_check_userkey'
                // 'errors' => ['required' => 'You must provide a Name.']
            ]
        ];
        $this->rest->validation($rules);


        //user login process...
        $rows = new Users_model;
        $rows->get([
            'where' => array(['key' => 'userkey', 'value' => $this->input->post('userkey')])
        ]);
        $userkey = $this->input->post('userkey');

        $quize_answers = new User_answer_model;
        $quize_answers->get([
            'where' => array(['key' => 'userkey', 'value' => $userkey])
        ]);
        if ($quize_answers->status() == TRUE) {

            $points = 0;
            foreach ($quize_answers->data() as $quize_answer) {
                $points = $points + $quize_answer['points'];
                $length = 4;
                $points_length = 4 - strlen($points);
                $zero = '';
                for ($i = 0; $i < $points_length; $i++) {
                    $zero .= '0';
                }
            }
            $points = $zero . $points;
        } else {
            $points = '0000';
        }

        $media = null;


        $medias = new Media_model;
        $medias->get([
            'where' => array(['key' => 'active', 'value' => 'Active'])
        ]);

        if ($medias->status() == TRUE) {

            //incompleted....

            $md = new Media_download_model;
            $md->get([
                'where' => array(
                    ['key' => 'media_id', 'value' => $medias->data(0)['id']],
                    ['key' => 'userkey', 'value' => $userkey]
                )
            ]);
            //$md = get_row($conn, "select * from media_download where media_id='{$medias[0]['id']}' and userkey='$userkey'");
            if ($md->status() != TRUE) {
                $media = $medias->data(0)['id'];
            }
        }

        $init_rating = new Rating_model;
        $init_rating->get([
            'where' => array(['key' => 'userkey', 'value' => $userkey])
        ]);
        //$init_rating = get_row($conn, "select * from rating where userkey='$userkey'");
        if ($init_rating->status() == TRUE) {
            $rating_init = true;
        } else {
            $rating_init = false;
        }

        $response = $rows->data(0);
        $response['user_image'] = base_url() . "data/profile/" . $rows->data(0)['image'];
        $response['media'] = $media;
        $response['rating_init'] = $rating_init;
        $response['points'] = $points;
        $response['auth_key'] = $rows->data(0)['auth_key'];

        $obj5 = new Obj;
        $obj5->setRequest('data', $response);
        $obj5->setRequest('msg', 'successfully login');
        $this->rest->response($obj5->getRequest(), Rest::HTTP_OK);
    }
}
