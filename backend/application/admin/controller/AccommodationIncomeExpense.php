<?php
namespace app\admin\controller;

class AccommodationIncomeExpense extends BaseIncomeExpense {
    protected $tableName = 'accommodation_income_expense';
    protected $moduleTitle = '住宿收支';
    protected $moduleName = '住宿收支';
    protected $extraFields = [
        'property_name' => ['label' => '物业名称', 'placeholder' => '请输入物业名称']
    ];
    protected $categoryPlaceholder = '如：水电、维修、租金等';
}
