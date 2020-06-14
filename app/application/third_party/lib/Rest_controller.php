<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
		*
		* Rest_controller Class 
		* 
		* @author Sandeep Kumar <ki.sandeep11@gmail.com> 
	*/
class Rest_controller
{

	protected $CI;
	public $auth_table;
	public $config;
	public $files;
	public $header;
	public $method;
	public $request = NULL;
	public $req;
	public $response = NULL;
	public $db = NULL;
	public $_get_args = [];
	public $_post_args = [];
	public $_put_args = [];
	public $_delete_args = [];
	public $_allow = TRUE;
	public $rest_enable = TRUE;
	public $auth = FALSE;

	public $_supported_formats = [
		'json' => 'application/json',
		'html' => 'text/html',
		'xml' => 'application/xml'
	];

	public $format = 'json';

	//Old contants
	const HTTP_OK = 200;
	const HTTP_CREATED = 201;
	const UNKNOWN_ERROR = 520;
	const HTTP_NOT_FOUND = 404;
	const HTTP_FORBIDDEN = 403;
	const HTTP_UNAUTHORIZED = 401;
	const HTTP_INTERNAL_SERVER_ERROR = 500;
	const HTTP_SERVICE_UNAVAILABLE = 503;
	const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;
	const HTTP_NOT_IMPLEMENTED = 501;
	const HTTP_BAD_REQUEST = 400;

	//New contants
	const CONTINUE                                   = 100;
	const SWITCHING_PROTOCOLS                        = 101;
	const PROCESSING                                 = 102;
	const OK                                         = 200;
	const CREATED                                    = 201;
	const ACCEPTED                                   = 202;
	const NON_AUTHORITATIVE_INFORMATION              = 203;
	const NO_CONTENT                                 = 204;
	const RESET_CONTENT                              = 205;
	const PARTIAL_CONTENT                            = 206;
	const MULTI_STATUS                               = 207;
	const ALREADY_REPORTED                           = 208;
	const IM_USED                                    = 226;
	const MULTIPLE_CHOICES                           = 300;
	const MOVED_PERMANENTLY                          = 301;
	const FOUND                                      = 302;
	const SEE_OTHER                                  = 303;
	const NOT_MODIFIED                               = 304;
	const USE_PROXY                                  = 305;
	const TEMPORARY_REDIRECT                         = 307;
	const PERMANENT_REDIRECT                         = 308;
	const BAD_REQUEST                                = 400;
	const UNAUTHORIZED                               = 401;
	const PAYMENT_REQUIRED                           = 402;
	const FORBIDDEN                                  = 403;
	const NOT_FOUND                                  = 404;
	const METHOD_NOT_ALLOWED                         = 405;
	const NOT_ACCEPTABLE                             = 406;
	const PROXY_AUTHENTICATION_REQUIRED              = 407;
	const REQUEST_TIMEOUT                            = 408;
	const CONFLICT                                   = 409;
	const GONE                                       = 410;
	const LENGTH_REQUIRED                            = 411;
	const PRECONDITION_FAILED                        = 412;
	const PAYLOAD_TOO_LARGE                          = 413;
	const REQUEST_URI_TOO_LONG                       = 414;
	const UNSUPPORTED_MEDIA_TYPE                     = 415;
	const REQUESTED_RANGE_NOT_SATISFIABLE            = 416;
	const EXPECTATION_FAILED                         = 417;
	const IM_A_TEAPOT                                = 418;
	const MISDIRECTED_REQUEST                        = 421;
	const UNPROCESSABLE_ENTITY                       = 422;
	const LOCKED                                     = 423;
	const FAILED_DEPENDENCY                          = 424;
	const UPGRADE_REQUIRED                           = 426;
	const PRECONDITION_REQUIRED                      = 428;
	const TOO_MANY_REQUESTS                          = 429;
	const REQUEST_HEADER_FIELDS_TOO_LARGE            = 431;
	const CONNECTION_CLOSED_WITHOUT_RESPONSE         = 444;
	const UNAVAILABLE_FOR_LEGAL_REASONS              = 451;
	const CLIENT_CLOSED_REQUEST                      = 499;
	const INTERNAL_SERVER_ERROR                      = 500;
	const NOT_IMPLEMENTED                            = 501;
	const BAD_GATEWAY                                = 502;
	const SERVICE_UNAVAILABLE                        = 503;
	const GATEWAY_TIMEOUT                            = 504;
	const HTTP_VERSION_NOT_SUPPORTED                 = 505;
	const VARIANT_ALSO_NEGOTIATES                    = 506;
	const INSUFFICIENT_STORAGE                       = 507;
	const LOOP_DETECTED                              = 508;
	const NOT_EXTENDED                               = 510;
	const NETWORK_AUTHENTICATION_REQUIRED            = 511;
	const NETWORK_CONNECT_TIMEOUT_ERROR              = 599;

	// protected $http_status = [
	// 	100 => self::CONTINUE,
	// 	101 => self::SWITCHING_PROTOCOLS,
	// 	102 => self::PROCESSING,
	// 	200 => self::OK,
	// 	201 => self::CREATED,
	// 	202 => self::ACCEPTED,
	// 	203 => self::NON_AUTHORITATIVE_INFORMATION,
	// 	204 => self::NO_CONTENT,
	// 	205 => self::RESET_CONTENT,
	// 	206 => self::PARTIAL_CONTENT,
	// 	207 => self::MULTI_STATUS,
	// 	208 => self::ALREADY_REPORTED,
	// 	226 => self::IM_USED,
	// 	300 => self::MULTIPLE_CHOICES,
	// 	301 => self::MOVED_PERMANENTLY,
	// 	302 => self::FOUND,
	// 	303 => self::SEE_OTHER,
	// 	304 => self::NOT_MODIFIED,
	// 	305 => self::USE_PROXY,
	// 	307 => self::TEMPORARY_REDIRECT,
	// 	308 => self::PERMANENT_REDIRECT,
	// 	400 => self::BAD_REQUEST,
	// 	401 => self::UNAUTHORIZED,
	// 	402 => self::PAYMENT_REQUIRED,
	// 	403 => self::FORBIDDEN,
	// 	404 => self::NOT_FOUND,
	// 	405 => self::METHOD_NOT_ALLOWED,
	// 	406 => self::NOT_ACCEPTABLE,
	// 	407 => self::PROXY_AUTHENTICATION_REQUIRED,
	// 	408 => self::REQUEST_TIMEOUT,
	// 	409 => self::CONFLICT,
	// 	410 => self::GONE,
	// 	411 => self::LENGTH_REQUIRED,
	// 	412 => self::PRECONDITION_FAILED,
	// 	413 => self::PAYLOAD_TOO_LARGE,
	// 	414 => self::REQUEST_URI_TOO_LONG,
	// 	415 => self::UNSUPPORTED_MEDIA_TYPE,
	// 	416 => self::REQUESTED_RANGE_NOT_SATISFIABLE,
	// 	417 => self::EXPECTATION_FAILED,
	// 	418 => self::IM_A_TEAPOT,
	// 	421 => self::MISDIRECTED_REQUEST,
	// 	422 => self::UNPROCESSABLE_ENTITY,
	// 	423 => self::LOCKED,
	// 	424 => self::FAILED_DEPENDENCY,
	// 	426 => self::UPGRADE_REQUIRED,
	// 	428 => self::PRECONDITION_REQUIRED,
	// 	429 => self::TOO_MANY_REQUESTS,
	// 	431 => self::REQUEST_HEADER_FIELDS_TOO_LARGE,
	// 	444 => self::CONNECTION_CLOSED_WITHOUT_RESPONSE,
	// 	451 => self::UNAVAILABLE_FOR_LEGAL_REASONS,
	// 	499 => self::CLIENT_CLOSED_REQUEST,
	// 	500 => self::INTERNAL_SERVER_ERROR,
	// 	501 => self::NOT_IMPLEMENTED,
	// 	502 => self::BAD_GATEWAY,
	// 	503 => self::SERVICE_UNAVAILABLE,
	// 	504 => self::GATEWAY_TIMEOUT,
	// 	505 => self::HTTP_VERSION_NOT_SUPPORTED,
	// 	506 => self::VARIANT_ALSO_NEGOTIATES,
	// 	507 => self::INSUFFICIENT_STORAGE,
	// 	508 => self::LOOP_DETECTED,
	// 	510 => self::NOT_EXTENDED,
	// 	511 => self::NETWORK_AUTHENTICATION_REQUIRED,
	// 	599 => self::NETWORK_CONNECT_TIMEOUT_ERROR,
	// ];


	public $http_status_codes = [
		self::HTTP_OK 									 => 'OK',
		self::HTTP_CREATED 								 => 'CREATED',
		self::HTTP_UNAUTHORIZED 						 => 'UNAUTHORIZED',
		self::HTTP_FORBIDDEN 							 => 'FORBIDDEN',
		self::HTTP_NOT_FOUND 							 => 'NOT_FOUND',
		self::HTTP_INTERNAL_SERVER_ERROR 				 => 'INTERNAL_SERVER_ERROR',
		self::UNKNOWN_ERROR 							 => 'UNKNOWN_ERROR',
		self::HTTP_NOT_IMPLEMENTED 						 => 'NOT_IMPLEMENTED',
		self::METHOD_NOT_ALLOWED 						 => 'METHOD_NOT_ALLOWED',
		self::HTTP_BAD_REQUEST 							 => 'HTTP_BAD_REQUEST',
		self::CONTINUE                                   => 'CONTINUE',
		self::SWITCHING_PROTOCOLS                        => 'SWITCHING_PROTOCOLS',
		self::PROCESSING                                 => 'PROCESSING',
		self::OK                                         => 'OK',
		self::CREATED                                    => 'CREATED',
		self::ACCEPTED                                   => 'ACCEPTED',
		self::NON_AUTHORITATIVE_INFORMATION              => 'NON_AUTHORITATIVE_INFORMATION',
		self::NO_CONTENT                                 => 'NO_CONTENT',
		self::RESET_CONTENT                              => 'RESET_CONTENT',
		self::PARTIAL_CONTENT                            => 'PARTIAL_CONTENT',
		self::MULTI_STATUS                               => 'MULTI_STATUS',
		self::ALREADY_REPORTED                           => 'ALREADY_REPORTED',
		self::IM_USED                                    => 'IM_USED',
		self::MULTIPLE_CHOICES                           => 'MULTIPLE_CHOICES',
		self::MOVED_PERMANENTLY                          => 'MOVED_PERMANENTLY',
		self::FOUND                                      => 'FOUND',
		self::SEE_OTHER                                  => 'SEE_OTHER',
		self::NOT_MODIFIED                               => 'NOT_MODIFIED',
		self::USE_PROXY                                  => 'USE_PROXY',
		self::TEMPORARY_REDIRECT                         => 'TEMPORARY_REDIRECT',
		self::PERMANENT_REDIRECT                         => 'PERMANENT_REDIRECT',
		self::BAD_REQUEST                                => 'BAD_REQUEST',
		self::UNAUTHORIZED                               => 'UNAUTHORIZED',
		self::PAYMENT_REQUIRED                           => 'PAYMENT_REQUIRED',
		self::FORBIDDEN                                  => 'FORBIDDEN',
		self::NOT_FOUND                                  => 'NOT_FOUND',
		self::METHOD_NOT_ALLOWED                         => 'METHOD_NOT_ALLOWED',
		self::NOT_ACCEPTABLE                             => 'NOT_ACCEPTABLE',
		self::PROXY_AUTHENTICATION_REQUIRED              => 'PROXY_AUTHENTICATION_REQUIRED',
		self::REQUEST_TIMEOUT                            => 'REQUEST_TIMEOUT',
		self::CONFLICT                                   => 'CONFLICT',
		self::GONE                                       => 'GONE',
		self::LENGTH_REQUIRED                            => 'LENGTH_REQUIRED',
		self::PRECONDITION_FAILED                        => 'PRECONDITION_FAILED',
		self::PAYLOAD_TOO_LARGE                          => 'PAYLOAD_TOO_LARGE',
		self::REQUEST_URI_TOO_LONG                       => 'REQUEST_URI_TOO_LONG',
		self::UNSUPPORTED_MEDIA_TYPE                     => 'UNSUPPORTED_MEDIA_TYPE',
		self::REQUESTED_RANGE_NOT_SATISFIABLE            => 'REQUESTED_RANGE_NOT_SATISFIABLE',
		self::EXPECTATION_FAILED                         => 'EXPECTATION_FAILED',
		self::IM_A_TEAPOT                                => 'IM_A_TEAPOT',
		self::MISDIRECTED_REQUEST                        => 'MISDIRECTED_REQUEST',
		self::UNPROCESSABLE_ENTITY                       => 'UNPROCESSABLE_ENTITY',
		self::LOCKED                                     => 'LOCKED',
		self::FAILED_DEPENDENCY                          => 'FAILED_DEPENDENCY',
		self::UPGRADE_REQUIRED                           => 'UPGRADE_REQUIRED',
		self::PRECONDITION_REQUIRED                      => 'PRECONDITION_REQUIRED',
		self::TOO_MANY_REQUESTS                          => 'TOO_MANY_REQUESTS',
		self::REQUEST_HEADER_FIELDS_TOO_LARGE            => 'REQUEST_HEADER_FIELDS_TOO_LARGE',
		self::CONNECTION_CLOSED_WITHOUT_RESPONSE         => 'CONNECTION_CLOSED_WITHOUT_RESPONSE',
		self::UNAVAILABLE_FOR_LEGAL_REASONS              => 'UNAVAILABLE_FOR_LEGAL_REASONS',
		self::CLIENT_CLOSED_REQUEST                      => 'CLIENT_CLOSED_REQUEST',
		self::INTERNAL_SERVER_ERROR                      => 'INTERNAL_SERVER_ERROR',
		self::NOT_IMPLEMENTED                            => 'NOT_IMPLEMENTED',
		self::BAD_GATEWAY                                => 'BAD_GATEWAY',
		self::SERVICE_UNAVAILABLE                        => 'SERVICE_UNAVAILABLE',
		self::GATEWAY_TIMEOUT                            => 'GATEWAY_TIMEOUT',
		self::HTTP_VERSION_NOT_SUPPORTED                 => 'HTTP_VERSION_NOT_SUPPORTED',
		self::VARIANT_ALSO_NEGOTIATES                    => 'VARIANT_ALSO_NEGOTIATES',
		self::INSUFFICIENT_STORAGE                       => 'INSUFFICIENT_STORAGE',
		self::LOOP_DETECTED                              => 'LOOP_DETECTED',
		self::NOT_EXTENDED                               => 'NOT_EXTENDED',
		self::NETWORK_AUTHENTICATION_REQUIRED            => 'NETWORK_AUTHENTICATION_REQUIRED',
		self::NETWORK_CONNECT_TIMEOUT_ERROR              => 'NETWORK_CONNECT_TIMEOUT_ERROR',
	];


	//public function start($config = 'api_config')
	public function __construct($config = 'api_config')
	{
		header("Access-Control-Allow-Origin: *");
		$this->_setHeader();
		$this->method = @$this->header['REQUEST_METHOD'];
		$this->CI = &get_instance();
		$this->preflight_checks();
		$this->req = new stdClass();
		$this->get_local_config($config);
	
		if ($this->config->item('rest_auth_table')) {
			$this->auth_table = $this->config->item('rest_auth_table');
		}
		if ($this->config->item('rest_database_group') && ($this->config->item('rest_enable_auth') || $this->config->item('rest_enable_logging'))) {
			$this->CI->load->model('db_model');
		}
		if ((isset($this->config->config['rest_enable']) && $this->config->config['rest_enable'] === FALSE)) {
			$data = array('data' => NULL, 'msg' => 'API_NOT_IMPLEMENTED');
			$this->setData($data, self::HTTP_NOT_IMPLEMENTED);
			exit();
		}
		$this->CI->form_validation->rest_validation = TRUE;
	}

	public function get_local_config($config_file)
	{
		if (file_exists(APPPATH . "config/" . $config_file . ".php")) {
			$config = array();
			include(APPPATH . "config/" . $config_file . ".php");
			foreach ($config as $key => $value) {
				$this->CI->config->set_item($key, $value);
			}
			$this->config = $this->CI->config;
		}
		$this->CI->load->config($config_file, FALSE, TRUE);
	}

	public function preflight_checks()
	{
		if (is_php('5.4') === FALSE) {
			throw new Exception('Using PHP v' . PHP_VERSION . ', though PHP v5.4 or greater is required');
		}
		if (explode('.', CI_VERSION, 2)[0] < 3) {
			throw new Exception('REST Server requires CodeIgniter 3.x');
		}
	}
	public function _httpStatus($data)
	{
		header('HTTP/1.1 ' . $data . ' ' . $this->http_status_codes[$data]);
	}
	public function _setFormat($data)
	{
		header('Content-Type: ' . $this->_supported_formats[$data]);
	}
	public function response($data, $header = NULL, $format = NULL)
	{
		if ($header == NULL) {
			$header = self::HTTP_OK;
		}
		if ($this->format == 'json' || $format == NULL) {
			$this->_httpStatus($header);
			$this->_setFormat($this->format);
			echo json_encode($data);
			exit();
		} else {
			$data = array('data' => NULL, 'msg' => 'UNKNOWN_ERROR');
			ob_start();
			$this->setData($data, self::UNKNOWN_ERROR);
			exit();
		}
	}
	public function _setHeader()
	{
		$this->header = $_SERVER;
	}
	public function auth($table = NULL, $key = NULL)
	{
		if (!$table) {
			$table = $this->config->item('rest_auth_table');
		}
		if (!$key) {
			$key = $this->config->item('rest_auth_key');
		}

		$this->auth = TRUE;
		$api_key = (isset($this->header['HTTP_X_API_KEY'])) ? trim($this->header['HTTP_X_API_KEY']) : '';
		if ($this->auth === TRUE && $this->config->item('rest_enable_auth')) {
			if (!empty($api_key)) {
				$this->CI->db_model->table = $table;
				$check = $this->CI->db_model->auth($key, $api_key);
				if (!$check) {
					$this->setData(['data' => $this->CI->db_model->db_error, 'msg' => 'INVALID_AUTH'], self::HTTP_UNAUTHORIZED);
				} else {
					return $check;
				}
			} else {
				$this->setData(['data' => NULL, 'msg' => 'EMPTY_OR_INVALID_KEY'], self::HTTP_UNAUTHORIZED);
			}
		}
	}
	public function validation(array $rules, $return = NULL)
	{
		if (count($rules) > 0) {
			$this->CI->form_validation->set_data((array) $this->request);
			$this->CI->form_validation->set_rules($rules);
			if ($this->CI->form_validation->run() === FALSE) {
				if ($return === TRUE) {
					return ['data' => $this->CI->form_validation->error_array(), 'msg' => 'FORBIDDEN'];
				} else {
					$this->setData(['data' => $this->CI->form_validation->error_array(), 'msg' => 'FORBIDDEN'], self::HTTP_FORBIDDEN);
				}
			}
		} else {
			$this->setData(['data' => $this->CI->form_validation->error_array(), 'msg' => 'EMPTY_REQUEST'], self::HTTP_FORBIDDEN);
		}
	}
	public function setData($data, $header = NULL, $format = NULL)
	{
		$this->response($data, $header, $format);
	}
	public function init($method)
	{
		if ($this->method != strtoupper($method) && $this->method != strtolower($method)) {
			$this->setData(
				['data' => "Request must be of the type " . $method . ", " . $this->method . " given", 'msg' => 'METHOD_NOT_ALLOWED'],
				self::METHOD_NOT_ALLOWED
			);
		}
		return array('config' => $this->config->config);
	}
}
