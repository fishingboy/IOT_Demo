<?php

require_once('CITestCase.php');

class GithubTest extends CITestCase
{
    public function testExample()
    {
        $this->CI->load->library("github_serv");

        $response = $this->CI->github_serv->getStar();
        $this->assertIsArray($response);

        echo "<pre>response = " . print_r($response, true) . "</pre>\n";
    }
}