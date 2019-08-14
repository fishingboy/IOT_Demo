<?php

require_once('CITestCase.php');

class ExampleTest extends CITestCase
{
    public function setUp()
    {
        $this->CI = & get_instance();
        $this->CI->load->helper('email');

        // 新增 db 資料
    }

    public function tearDown()
    {
        // 移除 db 資料
    }

    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testEmailValidation()
    {
         $this->assertFalse(valid_email('test#testcom'));
    }
}