<?php
namespace app\admin\controller;

class DailyFinancial extends BaseIncomeExpense {
    protected $tableName = 'daily_financial';
    protected $moduleTitle = '财务日常';
    protected $moduleName = '日常收支';
    protected $extraFields = [];
    protected $categoryPlaceholder = '如：办公用品、交通费等';
    protected $showDescriptionInList = true;
}
