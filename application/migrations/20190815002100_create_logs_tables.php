<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_logs_tables extends CI_Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `logs` ( 
                  `id` INT NOT NULL AUTO_INCREMENT , 
                  `celsius` float COMMENT '攝氏溫度', 
                  `humidity` float COMMENT '濕度', 
                  `created_at` DATETIME NOT NULL , 
                  `updated_at` DATETIME NOT NULL , 
                  PRIMARY KEY (`id`)
              ) COMMENT = '記錄';";
        $this->db->query($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE `logs`";
        $this->db->query($sql);
    }

}