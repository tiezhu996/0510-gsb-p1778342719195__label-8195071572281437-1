<?php
namespace app\admin\controller;

class DailyFinancial extends IncomeExpenseBase {
    protected $tableName = 'daily_financial';
    protected $extraField = '';
    protected $extraFieldLabel = '';
    protected $moduleName = 'daily_financial';
    protected $moduleLabel = '日常收支';
}
