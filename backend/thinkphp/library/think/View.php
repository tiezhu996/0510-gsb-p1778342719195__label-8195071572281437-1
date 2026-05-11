<?php
namespace think;

class View {
    protected $vars = [];
    protected $replace = [];
    
    public static function instance() {
        return new self();
    }
    
    public function assign($name, $value = '') {
        if (is_array($name)) {
            $this->vars = array_merge($this->vars, $name);
        } else {
            $this->vars[$name] = $value;
        }
        return $this;
    }
    
    public function fetch($template = '', $vars = [], $replace = []) {
        $vars = array_merge($this->vars, $vars);
        $replace = array_merge($this->replace, $replace);
        
        if (empty($template)) {
            $request = Request::instance();
            $controller = $request->controller();
            $action = strtolower($request->action());
            
            // Convert CamelCase to snake_case
            $controllerSnake = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $controller));
            
            $template = $controllerSnake . '/' . $action;
        }
        
        $basePath = defined('APP_PATH') ? APP_PATH : '/var/www/html/application/';
        $file = $basePath . 'admin/view/' . str_replace('.', '/', $template) . '.html';
        if (!is_file($file)) {
            $file = $basePath . 'admin/view/' . $template . '.html';
        }
        
        if (is_file($file)) {
            extract($vars);
            ob_start();
            include $file;
            $content = ob_get_clean();
            $content = str_replace(array_keys($replace), array_values($replace), $content);
            return $content;
        }
        return '';
    }
}
