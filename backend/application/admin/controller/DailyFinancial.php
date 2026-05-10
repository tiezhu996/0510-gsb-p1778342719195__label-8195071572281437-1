<?php
namespace app\admin\controller;

use think\Controller;

class DailyFinancial extends Controller {
    public function index() {
        $list = \think\Db::instance()->table('daily_financial')->order('id', 'desc')->select();
        $this->assign('list', $list);
        return $this->fetch();
    }
    
    public function add() {
        if ($this->request->isPost()) {
            $data = [
                'type' => $this->request->param('type'),
                'amount' => $this->request->param('amount'),
                'category' => $this->request->param('category'),
                'description' => $this->request->param('description'),
                'date' => $this->request->param('date'),
                'createtime' => time()
            ];
            \think\Db::instance()->table('daily_financial')->insert($data);
            $this->success('添加成功', url('index'));
        }
        return $this->fetch();
    }
    
    public function edit($id = 0) {
        if ($this->request->isPost()) {
            $data = [
                'type' => $this->request->param('type'),
                'amount' => $this->request->param('amount'),
                'category' => $this->request->param('category'),
                'description' => $this->request->param('description'),
                'date' => $this->request->param('date')
            ];
            \think\Db::instance()->table('daily_financial')->where('id', $id)->update($data);
            $this->success('更新成功', url('index'));
        }
        $row = \think\Db::instance()->table('daily_financial')->find($id);
        $this->assign('row', $row);
        return $this->fetch();
    }
    
    public function delete($id = 0) {
        \think\Db::instance()->table('daily_financial')->where('id', $id)->delete();
        $this->success('删除成功', url('index'));
    }
}
