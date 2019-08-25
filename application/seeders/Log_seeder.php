<?php defined('BASEPATH') OR exit('No direct script access allowed');

use fishingboy\ci_seeder\CI_Seeder_base;

class Log_seeder extends CI_Seeder_base
{
    /**
     * 執行順序 (大的排前面)
     * @var integer
     */
    public $priority = 100;

    /**
     * 塞資料
     * @return integer 新增資料筆數
     */
    public function run()
    {
        $this->CI->db->insert("logs", [
            'celsius' => 11,
            'humidity' => 22,
        ]);
        return 1;
    }
}
