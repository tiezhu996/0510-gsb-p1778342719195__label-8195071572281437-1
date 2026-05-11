<?php
namespace think;

class Db {
    protected static $instance;
    protected $pdo;
    protected $config;
    
    public static function instance() {
        file_put_contents('/tmp/db_debug.log', "instance() called\n", FILE_APPEND);
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->config = Config::get('database');
        
        $dsn = "mysql:host={$this->config['hostname']};port={$this->config['hostport']};dbname={$this->config['database']};charset={$this->config['charset']}";
        
        try {
            $this->pdo = new \PDO($dsn, $this->config['username'], $this->config['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $this->config['charset']
            ]);
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    public function table($table) {
        return new Query($this->pdo, $table, $this->config['prefix']);
    }
    
    public function query($sql, $bind = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function execute($sql, $bind = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($bind);
    }
}

class Query {
    protected $pdo;
    protected $table;
    protected $prefix;
    protected $where = [];
    protected $bind = [];
    protected $order = '';
    
    public function __construct($pdo, $table, $prefix = '') {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->prefix = $prefix;
    }
    
    public function where($field, $value = null) {
        if (is_array($field)) {
            foreach ($field as $k => $v) {
                $this->where[] = "`{$k}` = ?";
                $this->bind[] = $v;
            }
        } else {
            $this->where[] = "`{$field}` = ?";
            $this->bind[] = $value;
        }
        return $this;
    }
    
    public function order($field, $direction = 'ASC') {
        $this->order = "`{$field}` " . strtoupper($direction);
        return $this;
    }
    
    public function find($id = null) {
        $sql = "SELECT * FROM `{$this->prefix}{$this->table}`";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        } elseif ($id) {
            $sql .= " WHERE id = ?";
            $this->bind[] = $id;
        }
        $sql .= " LIMIT 1";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bind);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public function select() {
        $sql = "SELECT * FROM `{$this->prefix}{$this->table}`";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        if (!empty($this->order)) {
            $sql .= " ORDER BY " . $this->order;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bind);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function insert($data) {
        file_put_contents('/tmp/db_debug.log', "insert() called\n", FILE_APPEND);
        $fields = implode(', ', array_map(function($f) { return "`{$f}`"; }, array_keys($data)));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO `{$this->prefix}{$this->table}` ({$fields}) VALUES ({$placeholders})";
        file_put_contents('/tmp/db_debug.log', "SQL: $sql\n", FILE_APPEND);
        file_put_contents('/tmp/db_debug.log', "Data: " . print_r(array_values($data), true) . "\n", FILE_APPEND);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $this->pdo->lastInsertId();
    }
    
    public function update($data) {
        $sets = implode(', ', array_map(function($f) { return "`{$f}` = ?"; }, array_keys($data)));
        $sql = "UPDATE `{$this->prefix}{$this->table}` SET {$sets}";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_merge(array_values($data), $this->bind));
    }
    
    public function delete() {
        $sql = "DELETE FROM `{$this->prefix}{$this->table}`";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->bind);
    }
    
    public function count() {
        $sql = "SELECT COUNT(*) as cnt FROM `{$this->prefix}{$this->table}`";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bind);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['cnt'];
    }
}
