<?php

require_once('CITestCase.php');

class LogsModelTest extends CITestCase
{
    private $humidity;
    private $celsius;

    public function setUp()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('logs_model');

        $this->humidity = 299;
        $this->celsius = -300;
    }

    public function tearDown()
    {
        $this->CI->db->delete("logs", ["celsius" => $this->celsius]);
    }

    public function testExample()
    {
        $id = $this->CI->logs_model->create([
            'humidity' => $this->humidity,
            'celsius' => $this->celsius,
        ]);
        $this->assertGreaterThan(0, $id);

        $row = $this->CI->db->from("logs")->where('id', $id)->get()->row_array();
        $this->assertEquals($this->humidity, $row['humidity']);
        $this->assertEquals($this->celsius, $row['celsius']);
    }
}