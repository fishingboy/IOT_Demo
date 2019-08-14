<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 後台 API
 */
class Log extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Api_lib");
        $this->load->library("Logs_model");
    }

    public function write()
    {
        $celsius = $this->api_lib->getParam('celsius', 'required');
        $humidity = $this->api_lib->getParam('humidity', 'required');

        $id = $this->Logs_model->create([
            'celsius' => $celsius,
            'humidity' => $humidity,
        ]);

        if ( ! $id) {

        }
    }
}