<?php

use fishingboy\ci_model_base\CI_Model_base;

include_once (__DIR__ . "/Model_base.php");

/**
 * Model 的基礎類別
 */
class Logs_model extends CI_Model_base
{
    /**
     * 資料表
     * @var string
     */
    protected $table = "logs";

    public function get()
    {
        return $this->CI->db->from("logs")
            ->limit(30)
            ->order_by("id", "DESC")
            ->get()->result_array();
    }

    /**
     * 新增資料的驗證
     */
    protected function verifyBeforeCreate( & $params)
    {
        return true;
    }

    /**
     * 更新資料的驗證
     */
    protected function verifyBeforeUpdate( & $params)
    {
        return true;
    }
}
