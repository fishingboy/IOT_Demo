<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 後台 API
 */
class Log extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library("api_lib");
        $this->load->library('log_serv');
        $this->load->model('logs_model');
    }

    public function write()
    {
        $celsius = $this->api_lib->getParam('celsius', 'required');
        $humidity = $this->api_lib->getParam('humidity', 'required');

        try {
            $this->logs_model->create([
                'celsius' => $celsius,
                'humidity' => $humidity,
            ]);
        } catch (Exception $e) {
            $this->api_lib->outputError($e->getMessage());
        }

        $this->api_lib->output([
            "status" => true,
            'celsius' => $celsius,
            'humidity' => $humidity,
        ]);
    }

    public function read()
    {
        $rows = [];
        try {
            $rows = $this->log_serv->get();
        } catch (Exception $e) {
            $this->api_lib->outputError($e->getMessage());
        }

        $this->api_lib->output([
            "status" => true,
            'rows' => $rows,
        ]);
    }
}