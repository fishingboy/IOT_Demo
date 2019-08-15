<?php

class Log_serv
{
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model("logs_model");
    }
    
    public function get()
    {
        return $this->CI->logs_model->get();
    }
}