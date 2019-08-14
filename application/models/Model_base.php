<?php
/**
 * Model 的基礎類別
 */
abstract class Model_base extends CI_Model
{
    /**
     * CI 實體
     * @var object
     */
    protected $CI;

    /**
     * 資料表
     * @var string
     */
    protected $table;

    /**
     * 主 key
     * @var string
     */
    protected $key = 'id';

    /**
     * 建構子
     */
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->library("api_lib");
    }

    public function findBy()
    {
        $args = func_get_args();
        $this->_find($args);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    protected function _find($args)
    {
//        $args = func_get_args();
        if (count($args) === 1) {
            if (is_array($args[0])) {
                foreach ($args[0] as $key => $value) {
                    $this->db->where($key, $value);
                }
            }
        }
        if (count($args) === 2) {
            $this->db->where($args[0], $args[1]);
        }

        if ($this->db->field_exists('status', $this->table)) {
            $this->db->where('status', 'on');
        }
    }

    /**
     * 新增資料
     * @param  array $params 欄位參數
     * @return boolean      是否成功
     * @throws Exception
     */
    public function create($params)
    {
        // 重設 query
        $this->db->reset_query();

        // MODEL 自訂檢查
        if ( ! $this->verifyBeforeCreate($params)) {
            throw new Exception("資料檢查失敗!");;
        }

        // 新增/修改時間用 now()
        if ($this->db->field_exists('created_at', $this->table) && ! isset($params['created_at'])) {
            $this->db->set('created_at', 'NOW()', false);
        }
        if ($this->db->field_exists('updated_at', $this->table) && ! isset($params['updated_at'])) {
            $this->db->set('updated_at', 'NOW()', false);
        }

        // 處理時間欄位的 now()
        $params = $this->convertNowFields($params);


        // 新增
        $ret = $this->db->insert($this->table, $params);

        if ( ! $ret) {
            throw new Exception("新增資料表資料 {$this->table}' 失敗!");
        }

        $id = ($ret) ? $this->db->insert_id() : false;

        // 新增完資料的動作
        if ($id) {
            $this->afterCreate($id);
        }

        return $id;
    }

    /**
     * 更新資料
     * @param  integer $id 流水號
     * @param  array $params 欄位資料
     * @return boolean        更新是否成功
     * @throws Exception
     */
    public function update($id, $params)
    {
        // 重設 query
        $this->db->reset_query();

        // 修改時間用 now()
        if ($this->db->field_exists('updated_at', $this->table)) {
            $this->db->set('updated_at', 'NOW()', false);
        }

        // 處理時間欄位的 now()
        $params = $this->convertNowFields($params);

        // MODEL 自訂檢查
        if ( ! $this->verifyBeforeUpdate($params)) {
            throw new Exception("資料檢查失敗!");
        }

        // 更新
        $ret = $this->db->where($this->key, $id)->update($this->table, $params);
        if ( ! $ret) {
            throw new Exception("更新資料表 {$this->table}.{$this->_key}='{$id}' 失敗!");
        }

        return ($ret) ? intval($id) : false;
    }

    /**
     * 更新資料
     * @param $conditions
     * @param  array $params 欄位資料
     * @return boolean        更新是否成功
     * @throws Exception
     */
    public function updateWhere($conditions, $params)
    {
        // 重設 query
        $this->db->reset_query();

        // 修改時間用 now()
        if ($this->db->field_exists('updated_at', $this->table)) {
            $this->db->set('updated_at', 'NOW()', false);
        }

        // 處理時間欄位的 now()
        $params = $this->convertNowFields($params);

        // MODEL 自訂檢查
        if ( ! $this->verifyBeforeUpdate($params)) {
            throw new Exception("資料檢查失敗!");
        }

        // 更新
        $ret = "";
        foreach ($conditions as $key => $val) {
            $ret = $this->db->where($key, $val);
        }

        $ret = $ret->update($this->table, $params);
        if ( ! $ret) {
            throw new Exception("更新資料表 {$this->table}.conditions = " . print_r($conditions, true) . " 失敗!");
        }

        return ($ret) ? true : false;
    }

    /**
     * 轉換 now 欄位
     * @param  array $data 新增/更新資料
     * @return array
     */
    protected function convertNowFields($data)
    {
        // 處理時間欄位的 now()
        foreach ($data as $key => $value) {
            if (strtoupper($value) === 'NOW()') {
                $this->db->set($key, 'NOW()', false);
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * 做參數驗證
     * @param  array  $params  參數驗證
     * @param  array $rules    驗證規則
     * @return boolean         是否通過驗證
     */
    protected function verifyParams($params, $rules)
    {
        // 重整結構
        $api_rules = [];
        foreach ($rules as $key => $rule) {
            $api_rules[$key] = ["rules" => $rule]; 
        }

        // 參數驗證
        $tree = debug_backtrace();
        $call_name = "{$tree[1]['class']}::{$tree[1]['function']} ";
        $status = $this->CI->api_lib->validationArrayParam($call_name, $params, [
            "type"  => "key_array",
            "array" => $api_rules
        ]);
        return $status;
    }

    /**
     * 新增資料的驗證
     */
    protected function verifyBeforeCreate( & $params)
    {
        return TRUE;
    }

    /**
     * 更新資料的驗證
     */
    protected function verifyBeforeUpdate( & $params)
    {
        return TRUE;
    }

    /**
     * 建立資料後額外做動作
     * @param $id
     * @return bool
     */
    protected function afterCreate($id) {
        return True;
    }

    /**
     * 刪除資料的驗證
     */
    protected function verifyBeforeDelete( & $params)
    {
        return TRUE;
    }

    /**
     * 刪除資料
     * @param  array $params 欄位參數
     * @return boolean      是否成功
     */
    public function delete_where($params)
    {
        // 重設 query
        $this->db->reset_query();
        $this->db->set('created_at', 'NOW()', false);

        // MODEL 自訂檢查
        if ( ! $this->verifyBeforeDelete($params)) {
            return false;
        }

        // 刪除
        $this->db->delete($this->table, $params);
        return ($this->db->affected_rows()) ? true : false;
    }
}
