<?php
namespace app\admin\controller;

use think\Controller;

class EmployeeSalary extends Controller {
    public function index() {
        $list = \think\Db::instance()->table('employee_salary')->order('id', 'desc')->select();
        $this->assign('list', $list);
        return $this->fetch();
    }
    
    public function add() {
        if ($this->request->isPost()) {
            $base = (float)$this->request->param('base_salary');
            $bonus = (float)$this->request->param('bonus');
            $deduction = (float)$this->request->param('deduction');
            $total = $base + $bonus - $deduction;
            
            $month = $this->request->param('month');
            if ($month && strlen($month) == 7) {
                $month = $month . '-01';
            }
            
            $data = [
                'employee_name' => $this->request->param('employee_name'),
                'department' => $this->request->param('department'),
                'position' => $this->request->param('position'),
                'base_salary' => $base,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'total_salary' => $total,
                'month' => $month,
                'createtime' => time()
            ];
            \think\Db::instance()->table('employee_salary')->insert($data);
            $this->success('添加成功', url('index'));
        }
        return $this->fetch();
    }
    
    public function edit($id = 0) {
        if ($this->request->isPost()) {
            $base = (float)$this->request->param('base_salary');
            $bonus = (float)$this->request->param('bonus');
            $deduction = (float)$this->request->param('deduction');
            $total = $base + $bonus - $deduction;
            
            $month = $this->request->param('month');
            if ($month && strlen($month) == 7) {
                $month = $month . '-01';
            }
            
            $data = [
                'employee_name' => $this->request->param('employee_name'),
                'department' => $this->request->param('department'),
                'position' => $this->request->param('position'),
                'base_salary' => $base,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'total_salary' => $total,
                'month' => $month
            ];
            \think\Db::instance()->table('employee_salary')->where('id', $id)->update($data);
            $this->success('更新成功', url('index'));
        }
        $row = \think\Db::instance()->table('employee_salary')->find($id);
        if ($row && $row['month']) {
            $row['month'] = substr($row['month'], 0, 7);
        }
        $this->assign('row', $row);
        return $this->fetch();
    }
    
    public function delete($id = 0) {
        \think\Db::instance()->table('employee_salary')->where('id', $id)->delete();
        $this->success('删除成功', url('index'));
    }
}
