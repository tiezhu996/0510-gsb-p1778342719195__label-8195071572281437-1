<?php
namespace think;

class Controller {
    protected $request;
    protected $view;
    protected $config;
    
    public function __construct(Request $request = null) {
        $this->request = $request ?: Request::instance();
        $this->view = new View();
        $this->config = Config::get();
    }
    
    protected function success($msg = '', $url = null, $data = '') {
        $isAjax = $this->request->isAjax();
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        
        if ($isAjax || empty($userAgent)) {
            $this->result(['code' => 1, 'msg' => $msg, 'data' => $data, 'url' => $url], 'json');
        } else {
            $redirectUrl = $url ?: 'javascript:history.back()';
            $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>操作成功</title></head><body>';
            $html .= '<script>alert("' . addslashes($msg) . '");location.href="' . $redirectUrl . '";</script>';
            $html .= '</body></html>';
            echo $html;
            exit;
        }
    }
    
    protected function error($msg = '', $url = null) {
        $isAjax = $this->request->isAjax();
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        
        if ($isAjax || empty($userAgent)) {
            $this->result(['code' => 0, 'msg' => $msg, 'url' => $url], 'json');
        } else {
            $redirectUrl = $url ?: 'javascript:history.back()';
            $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>操作失败</title></head><body>';
            $html .= '<script>alert("' . addslashes($msg) . '");location.href="' . $redirectUrl . '";</script>';
            $html .= '</body></html>';
            echo $html;
            exit;
        }
    }
    
    protected function result($data, $type = 'json') {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        $response = Response::create($data, $type);
        $response->send();
        exit;
    }
    
    protected function fetch($template = '', $vars = [], $replace = []) {
        return $this->view->fetch($template, $vars, $replace);
    }
    
    protected function assign($name, $value = '') {
        $this->view->assign($name, $value);
        return $this;
    }
}
