<?php

require_once('CITestCase.php');

class LogsModelTest extends CITestCase
{
    public function setUp()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('Logs_model');
    }

    public function tearDown()
    {
        // 移除 db 資料
    }

    public function testExample()
    {
        $humidity = 299;
        $celsius = -300;
        $id = $this->CI->Logs_model->create([
            'humidity' => $humidity,
            'celsius' => $celsius,
        ]);
        $this->assertGreaterThan(0, $id);

        $row = $this->CI->db->from("logs")->where('id', $id)->get()->row_array();
        $this->assertEquals($humidity, $row['humidity']);
        $this->assertEquals($celsius, $row['celsius']);
    }
}