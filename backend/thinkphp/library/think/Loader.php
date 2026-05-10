<?php
namespace think;

class Loader {
    protected static $instance = [];
    
    public static function register() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }
    
    public static function autoload($class) {
        $class = str_replace('\\', '/', $class);
        $file = APP_PATH . $class . '.php';
        if (is_file($file)) {
            include $file;
            return true;
        }
        return false;
    }
    
    public static function controller($name, $layer = 'controller', $appendSuffix = false) {
        $layer = $layer ?: 'controller';
        $app = APP_NAME ?: '';
        $class = $app . '\\' . $layer . '\\' . $name;
        if (class_exists($class)) {
            return self::instance($class);
        }
        return null;
    }
    
    public static function instance($class, $new = false) {
        $guid = $class . ($new ? spl_object_hash($new) : '');
        if (isset(self::$instance[$guid])) {
            return self::$instance[$guid];
        }
        if (class_exists($class)) {
            self::$instance[$guid] = new $class();
            return self::$instance[$guid];
        }
        throw new \Exception('class not exists: ' . $class);
    }
}
