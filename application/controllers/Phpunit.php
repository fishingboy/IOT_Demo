<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * phpunit 的啟動 controller
 */
class Phpunit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
    }
}
