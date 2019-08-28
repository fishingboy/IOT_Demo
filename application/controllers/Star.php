<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Star extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library("github_serv");
    }

    public function index($user = "fishingboy")
    {
        $data = $this->github_serv->getStar($user);

        $this->load->view("star", [
            'user' => $user,
            'data' => $data,
        ]);
    }
}
