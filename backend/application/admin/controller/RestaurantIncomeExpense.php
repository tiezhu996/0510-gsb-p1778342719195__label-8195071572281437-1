<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class RestaurantIncomeExpense extends Controller {
    public function index() {
        $list = \think\Db::instance()->table('restaurant_income_expense')->order('id', 'desc')->select();
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
                'restaurant_name' => $this->request->param('restaurant_name'),
                'date' => $this->request->param('date'),
                'createtime' => time()
            ];
            file_put_contents('/tmp/controller_debug.log', "Data: " . print_r($data, true) . "\n", FILE_APPEND);
            \think\Db::instance()->table('restaurant_income_expense')->insert($data);
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
                'restaurant_name' => $this->request->param('restaurant_name'),
                'date' => $this->request->param('date')
            ];
            \think\Db::instance()->table('restaurant_income_expense')->where('id', $id)->update($data);
            $this->success('更新成功', url('index'));
        }
        $row = \think\Db::instance()->table('restaurant_income_expense')->find($id);
        $this->assign('row', $row);
        return $this->fetch();
    }
    
    public function delete($id = 0) {
        \think\Db::instance()->table('restaurant_income_expense')->where('id', $id)->delete();
        $this->success('删除成功', url('index'));
    }
}
