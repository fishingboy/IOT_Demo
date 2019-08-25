<?php

class Log_serv
{
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model("logs_model");
    }
    
    public function get()
    {
        $rows = $this->CI->logs_model->get();
        $rows = $this->convertLogs($rows);
        return $rows;
    }

    private function convertLogs($rows)
    {
        foreach ($rows as $i => $row) {
            $timer = new DateTime($row['created_at']);
            $rows[$i]['time'] = $timer->format("H:i:s");
        }

        return $rows;
    }
}