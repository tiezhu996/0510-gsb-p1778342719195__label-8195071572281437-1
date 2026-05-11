<?php
namespace app\admin\controller;

class AccommodationIncomeExpense extends BaseIncomeExpense {
    protected $tableName = 'accommodation_income_expense';
    protected $extraFields = ['property_name'];
}
