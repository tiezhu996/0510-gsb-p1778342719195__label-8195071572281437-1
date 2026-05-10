<?php
namespace app\admin\controller;

class RestaurantIncomeExpense extends IncomeExpenseBase {
    protected $tableName = 'restaurant_income_expense';
    protected $extraField = 'restaurant_name';
    protected $extraFieldLabel = '餐厅名称';
    protected $moduleName = 'restaurant_income_expense';
    protected $moduleLabel = '餐厅收支';

    protected function beforeAdd(&$data) {
        file_put_contents('/tmp/controller_debug.log', "Data: " . print_r($data, true) . "\n", FILE_APPEND);
    }
}
