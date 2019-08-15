<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library("log_serv");
    }

    public function index()
    {
        $rows = $this->log_serv->get();
        $this->load->view("list", [
            'rows' => $rows
        ]);
    }
}
