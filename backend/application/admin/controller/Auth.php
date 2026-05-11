<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Auth extends Controller {
    public function login() {
        if ($this->request->isPost()) {
            $username = $this->request->param('username');
            $password = $this->request->param('password');
            
            $admin = \think\Db::instance()->table('admin')->where('username', $username)->find();
            
            if ($admin && $admin['password'] === md5($password . $admin['salt'])) {
                session('admin_id', $admin['id']);
                session('admin_name', $admin['username']);
                
                $isAjax = $this->request->isAjax();
                if ($isAjax || !isset($_SERVER['HTTP_USER_AGENT'])) {
                    $this->success('登录成功', url('console/index'));
                } else {
                    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><script>location.href="/admin/console/index";</script></head><body>登录成功，跳转中...</body></html>';
                    exit;
                }
            } else {
                $isAjax = $this->request->isAjax();
                if ($isAjax || !isset($_SERVER['HTTP_USER_AGENT'])) {
                    $this->error('用户名或密码错误');
                } else {
                    echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><script>alert("用户名或密码错误");history.back();</script></head><body></body></html>';
                    exit;
                }
            }
        }
        return $this->fetch();
    }
    
    public function logout() {
        session(null);
        $isAjax = $this->request->isAjax();
        if ($isAjax || !isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->success('退出成功', url('auth/login'));
        } else {
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><script>location.href="/admin/auth/login";</script></head><body>退出成功，跳转中...</body></html>';
            exit;
        }
    }
}
