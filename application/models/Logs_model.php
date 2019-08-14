<?php

include_once (__DIR__ . "/Model_base.php");

/**
 * Model 的基礎類別
 */
class Logs_model extends Model_base
{
    /**
     * 資料表
     * @var string
     */
    protected $table = "logs";

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