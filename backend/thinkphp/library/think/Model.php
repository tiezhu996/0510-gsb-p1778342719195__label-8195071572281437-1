<?php
namespace think;

class Model {
    protected $name;
    protected $pk = 'id';
    protected $data = [];
    protected $db;
    
    public function __construct($name = '') {
        $this->name = $name;
        $this->db = Db::instance();
    }
    
    public static function instance($name = '') {
        return new self($name);
    }
    
    public function __get($name) {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
    
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    
    public function save() {
        $data = $this->data;
        if (isset($data[$this->pk])) {
            return $this->db->table($this->name)->where($this->pk, $data[$this->pk])->update($data);
        } else {
            $data['createtime'] = time();
            return $this->db->table($this->name)->insert($data);
        }
    }
    
    public static function all($where = []) {
        $instance = new static();
        $result = $instance->db->table($instance->name)->where($where)->select();
        $list = [];
        foreach ($result as $row) {
            $model = new static($instance->name);
            $model->data = $row;
            $list[] = $model;
        }
        return $list;
    }
    
    public static function get($id) {
        $instance = new static();
        $row = $instance->db->table($instance->name)->find($id);
        if ($row) {
            $model = new static($instance->name);
            $model->data = $row;
            return $model;
        }
        return null;
    }
    
    public static function delete($id) {
        $instance = new static();
        return $instance->db->table($instance->name)->where($instance->pk, $id)->delete();
    }
}
