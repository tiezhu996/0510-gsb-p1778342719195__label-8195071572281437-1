<?php
namespace app\admin\controller;

class AccommodationIncomeExpense extends IncomeExpenseBase {
    protected $tableName = 'accommodation_income_expense';
    protected $extraField = 'property_name';
    protected $extraFieldLabel = '物业名称';
    protected $moduleName = 'accommodation_income_expense';
    protected $moduleLabel = '住宿收支';
}
