<?php

require_once(APPPATH .'tests/CITestCase.php');

class ApiExampleTest extends CITestCase
{
    private $user_id;
    private $zuvio_id;
    private $api_token;

    public function setUp()
    {
        $this->CI = & get_instance();
        $this->CI->load->helper('email');

        // 新增 db 資料
        $user = $this->CI->db->from("users")
            ->where("zuvio_email", "test200@leo-kuo.com")
            ->get()->row_array();

        $this->user_id = $user['id'];
        $this->zuvio_id = $user['zuvio_id'];
        $this->api_token = $this->CI->api_lib->getRemoteToken($this->zuvio_id, "forum");
    }

    public function tearDown()
    {
        // 移除 db 資料
    }

    public function testExampleApi()
    {
        $response = $this->CI->api_lib->curlSSOApi("forum", "api/user", [
            "user_id"   => $this->user_id,
            "api_token" => $this->api_token,
        ]);

        $this->outputApiResponse($response);
        $this->assertIsArray($response);
        $this->assertArrayHasKey('adj_code', $response);
        $this->assertArrayHasKey('sex_code', $response);
    }
}