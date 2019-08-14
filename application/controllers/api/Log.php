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
        $this->load->library("Api_lib");
        $this->load->model('Logs_model');
    }

    public function write()
    {
        $celsius = $this->api_lib->getParam('celsius', 'required');
        $humidity = $this->api_lib->getParam('humidity', 'required');

        try {
            $this->Logs_model->create([
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
}