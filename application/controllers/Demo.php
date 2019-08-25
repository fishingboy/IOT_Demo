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

        // 反過來排
        $chart_rows = $rows;
        usort($chart_rows, function ($a, $b) {
            return $a <=> $b;
        });

        $this->load->view("list", [
            'rows' => $rows,
            'chart_rows' => $chart_rows,
        ]);
    }
}
