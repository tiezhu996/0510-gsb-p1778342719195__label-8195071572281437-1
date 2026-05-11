<?php
namespace app\admin\controller;

use think\Controller;

class IncomeExpenseBase extends Controller {
    protected $tableName = '';
    protected $extraField = '';
    protected $extraFieldLabel = '';
    protected $moduleName = '';
    protected $moduleLabel = '';

    public function index() {
        $list = \think\Db::instance()->table($this->tableName)->order('id', 'desc')->select();
        $this->assign('list', $list);
        $this->assign('config', $this->getConfig());
        return $this->fetch('income_expense_common/index');
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

            if ($this->extraField) {
                $data[$this->extraField] = $this->request->param($this->extraField);
            }

            $this->beforeAdd($data);

            \think\Db::instance()->table($this->tableName)->insert($data);
            $this->success('添加成功', url('index'));
        }
        $this->assign('config', $this->getConfig());
        return $this->fetch('income_expense_common/form');
    }

    protected function beforeAdd(&$data) {
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

            if ($this->extraField) {
                $data[$this->extraField] = $this->request->param($this->extraField);
            }

            \think\Db::instance()->table($this->tableName)->where('id', $id)->update($data);
            $this->success('更新成功', url('index'));
        }
        $row = \think\Db::instance()->table($this->tableName)->find($id);
        $this->assign('row', $row);
        $this->assign('config', $this->getConfig());
        return $this->fetch('income_expense_common/form');
    }

    public function delete($id = 0) {
        \think\Db::instance()->table($this->tableName)->where('id', $id)->delete();
        $this->success('删除成功', url('index'));
    }

    protected function getConfig() {
        return [
            'table_name' => $this->tableName,
            'extra_field' => $this->extraField,
            'extra_field_label' => $this->extraFieldLabel,
            'module_name' => $this->moduleName,
            'module_label' => $this->moduleLabel
        ];
    }
}
