<?php
namespace app\admin\controller;

class RestaurantIncomeExpense extends BaseIncomeExpense {
    protected $tableName = 'restaurant_income_expense';
    protected $extraFields = ['restaurant_name'];
}
