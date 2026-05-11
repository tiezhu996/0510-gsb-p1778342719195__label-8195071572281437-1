<?php
namespace think;

class Response {
    protected $content;
    protected $type = 'html';
    protected $header = [];
    
    public static function create($data, $type = 'html') {
        $response = new self();
        $response->type = $type;
        if ($type === 'json') {
            $response->content = json_encode($data, JSON_UNESCAPED_UNICODE);
            $response->header['Content-Type'] = 'application/json; charset=utf-8';
        } else {
            $response->content = $data;
        }
        return $response;
    }
    
    public function header($name, $value) {
        $this->header[$name] = $value;
        return $this;
    }
    
    public function send() {
        foreach ($this->header as $name => $value) {
            header($name . ': ' . $value);
        }
        echo $this->content;
    }
    
    public static function redirect($url, $vars = [], $status = 302) {
        header('Location: ' . $url, true, $status);
        exit;
    }
}
