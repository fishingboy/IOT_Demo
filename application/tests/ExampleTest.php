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

    public function testLoadModel()
    {
        $this->CI->load->model("users_model");
        $this->assertInstanceOf('CI_Model', $this->CI->users_model, 'Model was loaded correctly');

        $table = $this->CI->users_model->getTable();
        $this->assertEquals("users", $table);
    }

    public function testLoadLibrary()
    {
        $this->CI->load->library("User_serv");
        $this->assertEquals('object', gettype($this->CI->user_serv), 'Library was loaded correctly');

    }

    public function testUserServGetProfile()
    {
        $this->CI->load->library("User_serv");
        $user = $this->CI->user_serv->getProfile(1);
        $this->assertArrayHasKey("id", $user);
        $this->assertArrayHasKey("adj_code", $user);
    }
}