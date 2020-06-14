<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Session Class
 *
 * @author    Sandeep Kumar <ki.sandeep11@gmail.com>
 */
class MY_Session extends CI_Session
{
    public function __construct()
    {
        parent::__construct();
    }

    public function load_userdata($instance)
    {
        return $this->userdata($instance);
    }
}