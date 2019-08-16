<?php

require_once(APPPATH .'tests/CITestCase.php');

class RandomApiTest extends CITestCase
{
    private $domain;

    public function setUp()
    {
        $this->CI = & get_instance();
        $this->CI->load->library("api_lib");

        $this->domain = "iot.local";
    }

    public function tearDown()
    {
        // 移除 db 資料
    }

    public function testWriteApi()
    {
        $api_url = "http://$this->domain/api/log/write";
        $response = $this->CI->api_lib->curlPost($api_url, [
            'celsius' => rand(0, 300) / 10,
            'humidity' => rand(30, 1000) / 10,
        ]);

        $this->outputApiResponse($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('status', $response);
//        $this->assertArrayHasKey('sex_code', $response);
    }
}