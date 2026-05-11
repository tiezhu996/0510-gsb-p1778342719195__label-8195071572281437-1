<?php
namespace app\admin\controller;

use think\Controller;

class BaseIncomeExpense extends Controller {
    protected $tableName = '';
    protected $moduleTitle = '';
    protected $moduleName = '';
    protected $extraFields = [];
    protected $categoryPlaceholder = '';
    protected $showDescriptionInList = false;

    protected function getCommonFields() {
        return ['type', 'amount', 'category', 'description', 'date'];
    }

    protected function getInsertFields() {
        return array_merge($this->getCommonFields(), array_keys($this->extraFields));
    }

    protected function getUpdateFields() {
        return array_merge($this->getCommonFields(), array_keys($this->extraFields));
    }

    protected function collectData($fields) {
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $this->request->param($field);
        }
        return $data;
    }

    protected function getControllerPath() {
        $class = get_class($this);
        $short = substr(strrchr($class, '\\'), 1);
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $short));
    }

    public function index() {
        $list = \think\Db::instance()->table($this->tableName)->order('id', 'desc')->select();
        $this->assign('list', $list);
        $this->assign('moduleTitle', $this->moduleTitle);
        $this->assign('moduleName', $this->moduleName);
        $this->assign('tableName', $this->tableName);
        $this->assign('controllerPath', $this->getControllerPath());
        $this->assign('extraFields', $this->extraFields);
        $this->assign('showDescriptionInList', $this->showDescriptionInList);
        return $this->fetch('base_income_expense/index');
    }

    public function add() {
        if ($this->request->isPost()) {
            $data = $this->collectData($this->getInsertFields());
            $data['createtime'] = time();
            \think\Db::instance()->table($this->tableName)->insert($data);
            $this->success('添加成功', url('index'));
        }
        $this->assign('moduleTitle', $this->moduleTitle);
        $this->assign('moduleName', $this->moduleName);
        $this->assign('tableName', $this->tableName);
        $this->assign('controllerPath', $this->getControllerPath());
        $this->assign('extraFields', $this->extraFields);
        $this->assign('categoryPlaceholder', $this->categoryPlaceholder);
        return $this->fetch('base_income_expense/add');
    }

    public function edit($id = 0) {
        if ($this->request->isPost()) {
            $data = $this->collectData($this->getUpdateFields());
            \think\Db::instance()->table($this->tableName)->where('id', $id)->update($data);
            $this->success('更新成功', url('index'));
        }
        $row = \think\Db::instance()->table($this->tableName)->find($id);
        $this->assign('row', $row);
        $this->assign('moduleTitle', $this->moduleTitle);
        $this->assign('moduleName', $this->moduleName);
        $this->assign('tableName', $this->tableName);
        $this->assign('controllerPath', $this->getControllerPath());
        $this->assign('extraFields', $this->extraFields);
        $this->assign('categoryPlaceholder', $this->categoryPlaceholder);
        return $this->fetch('base_income_expense/edit');
    }

    public function delete($id = 0) {
        \think\Db::instance()->table($this->tableName)->where('id', $id)->delete();
        $this->success('删除成功', url('index'));
    }
}
