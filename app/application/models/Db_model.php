<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Db_model Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class Db_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->blacklist = array('password');
    }

    public function login($email, $password)
    {

        $this->db->where("email", $email);
        $this->db->where("password", $password);
        $result = $this->db->get($this->table);

        if ($result->num_rows() == 1) {
            return $result->row(0);
        } else {
            return false;
        }
    }

    public function auth($column, $value)
    {
        $this->db->limit(1);
       // $this->db->where("BINARY " . $column . " = ", "'" . $value . "'", FALSE);
        $this->db->where($column, $value);
        $query = $this->db->get($this->table);
        $query_validator = $this->queryResult();

        if ($query_validator === TRUE) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}
