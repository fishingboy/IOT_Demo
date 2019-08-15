<?php

require_once('CITestCase.php');

class ReadLogTest extends CITestCase
{
    public function setUp()
    {
        $this->CI = & get_instance();
        $this->CI->load->library('log_serv');
        $this->CI->load->model('Logs_model');

        $this->CI->logs_model->create([
            'humidity' => 123,
            'celsius' => 100,
        ]);
        $this->CI->logs_model->create([
            'humidity' => 456,
            'celsius' => 200,
        ]);
    }

    public function tearDown()
    {
        $this->CI->db->delete("logs", ["humidity" => 123]);
        $this->CI->db->delete("logs", ["humidity" => 456]);
    }

    public function testExample()
    {
        $response = $this->CI->log_serv->get();
        $this->assertIsArray($response);
        $this->assertGreaterThan(0, count($response));
    }
}