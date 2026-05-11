<?php
namespace app\admin\controller;

class RestaurantIncomeExpense extends BaseIncomeExpense {
    protected $tableName = 'restaurant_income_expense';
    protected $moduleTitle = '餐厅收支';
    protected $moduleName = '餐厅收支';
    protected $extraFields = [
        'restaurant_name' => ['label' => '餐厅名称', 'placeholder' => '请输入餐厅名称']
    ];
    protected $categoryPlaceholder = '如：食材、人工、租金等';
}
