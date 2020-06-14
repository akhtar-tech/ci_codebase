<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth_model Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Auth_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table = 'admin';
        $this->primary_key = 'id';
        $this->blacklist = array('password');
    }

    public function login($email, $password){

        //$this->db->where("BINARY email = '".$email."'", NULL, FALSE);
        //$this->db->where("BINARY password = '".$password."'", NULL, FALSE);
		$this->db->where('email', $email);
        $this->db->where('password', $password);
        $result = $this->db->get($this->table);

        if ($result->num_rows() == 1) {
            return $result->row(0);
        } else {
            return false;
        }
    }

}
