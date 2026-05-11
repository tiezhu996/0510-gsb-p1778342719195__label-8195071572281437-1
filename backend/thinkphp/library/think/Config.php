<?php
namespace think;

class Config {
    protected static $config = [];
    
    public static function init() {
        $dbConfig = require APP_PATH . '../config/database.php';
        self::$config = array_merge(self::$config, $dbConfig);
    }
    
    public static function get($name = null, $default = null) {
        if (is_null($name)) {
            return self::$config;
        }
        $name = strtolower($name);
        return isset(self::$config[$name]) ? self::$config[$name] : $default;
    }
    
    public static function set($config) {
        self::$config = array_merge(self::$config, $config);
    }
}
