<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Api extends API_Controller
{
    private $blacklist;
    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('db_model');

        $this->auth = $this->rest->auth();
        $this->blacklist = array();
    }

    public function check_image($value1, $value2)
    {
        $value2 = json_decode($value2, TRUE);

        if ($value1) {
            $this->form_validation->set_message(
                'check_image', 'The Image field is required.'
            );
        }
        // print_r(@$value2['file']['error']);die;
        if (isset($value2[@array_keys($value2)[0]]['error']) && empty($value2['file']['error'])) {
            return true;
        } else {
            return false;
        }
    }

    public function upload($table, $id)
    {

        if ((isset($this->config->config['rest_image_upload']) && $this->config->config['rest_image_upload'] === FALSE)) {
            $obj = new Obj;
            $obj->setRequest('data', NULL);
            $obj->setRequest('msg', 'API_NOT_IMPLEMENTED');
            $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_IMPLEMENTED);
        }

        $this->rest->init('POST');
        $data = new Db_model;

        if ($this->input->post('key')) {
            $key = $this->input->post('key');
        } else {
            $key = "id";
        }

        $data->table = $table;


        if (!$data->check_table($table)) {

            $obj = new Obj;
            $obj->setRequest('data', NULL);
            $obj->setRequest('msg', 'UNKNOWN_RESOURCE');
            $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_FOUND);
        }

        if (!$data->check_field("{$key}", $table)) {
            $obj = new Obj;
            $obj->setRequest('data', "Invalid key");
            $obj->setRequest('msg', 'UNKNOWN_RESOURCE');
            $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_FOUND);
        }

        $data->get([
            'select' => ['id'],
            'where' => array(['key' => $key, 'value' => $id])
        ]);

        if (!$data->status()) {

            $obj = new Obj;
            $obj->setRequest('data', "Invalid id");
            $obj->setRequest('msg', 'NOT_FOUND');
            $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_FOUND);
        }

        $this->rest->request = ["image" => TRUE, "path" => $this->input->post('path')];
        $rules = [
            [
                'field' => 'image',
                'label' => 'Image',
                'rules' => 'required|callback_check_image[' . json_encode($_FILES) . ']'
                // 'errors' => ['required' => 'You must provide a Name.']
            ],
            [
                'field' => 'path',
                'label' => 'Path',
                'rules' => 'required'
                // 'errors' => ['required' => 'You must provide a Name.']
            ]
        ];
        $this->rest->validation($rules);

        $this->file_upload->files = $_FILES;
        $image_key = array_keys($_FILES)[0];

        $file1 = $this->file_upload->upload([
            'key' => $image_key,
            'upload_path' => $this->input->post('path'),
            'remote_upload_url' => $this->config->config['remote_upload_url']
        ]);

        if ($file1['status']) {


            $data->update([
                'data' => ["{$image_key}" => $file1['data']['upload_data']['file_name']],
                'where' => array(['key' => $key, 'value' => $id])
            ]);
        }

        if ($file1['status'] && $data->status()) {
            $file_data = array(
                'file_name' => $file1['data']['upload_data']['file_name'],
                'file_type' => $file1['data']['upload_data']['file_type'],
                'full_path' => media_url() . $this->input->post('path') . "/" . $file1['data']['upload_data']['file_name'],
                'client_name' => $file1['data']['upload_data']['client_name'],
                'file_ext' => $file1['data']['upload_data']['file_ext'],
                'file_size' => $file1['data']['upload_data']['file_size'],
                'is_image' => $file1['data']['upload_data']['is_image'],
                'image_width' => $file1['data']['upload_data']['image_width'],
                'image_height' => $file1['data']['upload_data']['image_height'],
                'image_type' => $file1['data']['upload_data']['image_type']
            );
            $obj = new Obj;
            $obj->setRequest('data', $file_data);
            $obj->setRequest('msg', "File has been successfully uploaded");
            $this->rest->response($obj->getRequest(), Rest::HTTP_OK);
        } else {
            $obj = new Obj;
            $obj->setRequest('data', NULL);
            $obj->setRequest('msg', 'INTERNAL_SERVER_ERROR');
            $this->rest->response($obj->getRequest(), Rest::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function index($table = NULL, $id = NULL)
    {
        if ((isset($this->config->config['rest_automation']) && $this->config->config['rest_automation'] === FALSE)) {
            $obj = new Obj;
            $obj->setRequest('data', NULL);
            $obj->setRequest('msg', 'API_NOT_IMPLEMENTED');
            $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_IMPLEMENTED);
        }

        $request_method = $this->rest->method;
        $auth = $this->rest->auth();

        if ($table === NULL) {

            $response['response'] = array('data' => 'select a table: http://host_name/api/rest/<resource_name>');

            $obj = new Obj;
            $obj->setRequest('data', $response['response']);
            $obj->setRequest('msg', 'RESOURCE_NAME_REQUIRED');
            $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_FOUND);
        }

        $data = new Db_model;
        $data->table = $table;
        $data->blacklist = $this->blacklist;

        if (!$data->check_table($table)) {
            $response['response'] = array('data' => 'select a table: http://host_name/api/rest/<resource_name>');

            $obj = new Obj;
            $obj->setRequest('data', NULL);
            $obj->setRequest('msg', 'UNKNOWN_RESOURCE');
            $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_FOUND);
        }

        if ($request_method === 'get' || $request_method === 'GET') {

            $limit = $this->input->get('limit');
            $offset = $this->input->get('offset');
            if (!$limit) {
                $limit = 100;
            }
            //var_dump($this->rest->header['HTTP_SELECT']);die;
            $select = NULL;
            if (@$this->rest->header['HTTP_SELECT']) {
                $select = $this->rest->header['HTTP_SELECT'];
            }

            $where = NULL;
            if (@$this->rest->header['HTTP_WHERE']) {
                $where = $this->rest->header['HTTP_WHERE'];
            }
            $orders = NULL;
            if (@$this->rest->header['HTTP_ORDER']) {
                $orders = $this->rest->header['HTTP_ORDER'];
            }

            $query = NULL;
            if (@$this->rest->header['HTTP_QUERY']) {
                $query = $this->rest->header['HTTP_QUERY'];
            }
            $query = json_decode($query, TRUE);
            //print_r($query);die;
            if (isset($query['select'])) {
                $select = $query['select'];
            }
            if (isset($query['where'])) {
                $where = $query['where'];
            }
            if (isset($query['order'])) {
                $orders = $query['order'];
            }
            $search = NULL;
            if (isset($query['search'])) {
                $search = $query['search'];
            }
            $like = NULL;
            if (isset($query['like'])) {
                $like = $query['like'];
            }

            if (isset($query['limit'])) {
                $limit = $query['limit'];
            }
            if (isset($query['offset'])) {
                $offset = $query['offset'];
            }


            //$search = array('key' => 'sa', 'rules' => ['name' => 'after', 'cert_no' => 'both']);
            //print_r($search);die;

            $data->get([
                'id' => $id,
                'limit' => $limit,
                'offset' => $offset,
                'like' => $like,
                'search_rules' => $search,
                'where' => $where,
                'select' => $select,
                'order' => $orders
            ]);

            if ($data->status() === TRUE) {
                $obj = new Obj;
                $obj->setRequest('data', $data->data());
                $obj->setRequest('total_count', $data->total_count());
                $obj->setRequest('msg', $data->message());
                $this->rest->response($obj->getRequest(), Rest::HTTP_OK);
            } else if ($data->status() === FALSE) {
                $obj = new Obj;
                $obj->setRequest('data', $data->error());
                $obj->setRequest('msg', $data->message());
                $this->rest->response($obj->getRequest(), Rest::HTTP_BAD_REQUEST);
            } else {
                $obj = new Obj;
                $obj->setRequest('data', $data->data());
                $obj->setRequest('msg', $data->message());
                $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_FOUND);
            }
        }
        if ($request_method === 'post' || $request_method === 'POST') {
            $request = $this->input->post();


            $data->create([
                'data' => $request
            ]);


            if ($data->status() === TRUE) {
                $obj = new Obj;
                $obj->setRequest('data', $data->id());
                $obj->setRequest('msg', 'SUCCESS');
                $this->rest->response($obj->getRequest(), Rest::HTTP_CREATED);
            } else if ($data->status() === FALSE) {
                $obj = new Obj;
                $obj->setRequest('data', $data->error());
                $obj->setRequest('msg', $data->message());
                $this->rest->response($obj->getRequest(), Rest::HTTP_BAD_REQUEST);
            } else {
                $obj = new Obj;
                $obj->setRequest('data', $data->data());
                $obj->setRequest('msg', $data->message());
                $this->rest->response($obj->getRequest(), Rest::HTTP_FORBIDDEN);
            }

        }
        if ($request_method === 'put' || $request_method === 'PUT') {

            $request = $this->input->put();

            if ($id) {

                $data->update([
                    'id' => $id,
                    'data' => $request
                ]);


                if ($data->status() === TRUE) {
                    $obj = new Obj;
                    $obj->setRequest('data', $data->id());
                    $obj->setRequest('msg', 'SUCCESS');
                    $this->rest->response($obj->getRequest(), Rest::HTTP_OK);
                } else if ($data->status() === FALSE) {
                    $obj = new Obj;
                    $obj->setRequest('data', $data->error());
                    $obj->setRequest('msg', $data->message());
                    $this->rest->response($obj->getRequest(), Rest::HTTP_BAD_REQUEST);
                } else {
                    $obj = new Obj;
                    $obj->setRequest('data', $data->data());
                    $obj->setRequest('msg', $data->message());
                    $this->rest->response($obj->getRequest(), Rest::HTTP_FORBIDDEN);
                }

            } else {
                $obj = new Obj;
                $obj->setRequest('data', NULL);
                $obj->setRequest('msg', 'NOT_FOUND');
                $this->rest->response($obj->getRequest(), Rest::HTTP_NOT_FOUND);
            }

        }
        if ($request_method === 'delete' || $request_method === 'DELETE') {
            if ($id) {

                $data->delete([
                    'id' => $id
                ]);


                if ($data->status() === TRUE) {
                    $obj = new Obj;
                    $obj->setRequest('data', $data->id());
                    $obj->setRequest('msg', 'SUCCESS');
                    $this->rest->response($obj->getRequest(), Rest::HTTP_OK);
                } else if ($data->status() === FALSE) {
                    $obj = new Obj;
                    $obj->setRequest('data', $data->error());
                    $obj->setRequest('msg', $data->message());
                    $this->rest->response($obj->getRequest(), Rest::HTTP_BAD_REQUEST);
                } else {
                    $obj = new Obj;
                    $obj->setRequest('data', $data->data());
                    $obj->setRequest('msg', $data->message());
                    $this->rest->response($obj->getRequest(), Rest::HTTP_FORBIDDEN);
                }
            } else {
                $obj = new Obj;
                $obj->setRequest('data', NULL);
                $obj->setRequest('msg', 'ID_REQUIRED');
                $this->rest->response($obj->getRequest(), Rest::HTTP_FORBIDDEN);

            }
        }

    }
}