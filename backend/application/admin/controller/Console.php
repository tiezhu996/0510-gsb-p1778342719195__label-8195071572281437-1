<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Console extends Controller {
    public function index() {
        $stats = [];
        
        $stats['restaurant_count'] = \think\Db::instance()->table('restaurant_income_expense')->count();
        $stats['accommodation_count'] = \think\Db::instance()->table('accommodation_income_expense')->count();
        $stats['daily_count'] = \think\Db::instance()->table('daily_financial')->count();
        $stats['employee_count'] = \think\Db::instance()->table('employee_salary')->count();
        
        $income = \think\Db::instance()->query("SELECT COALESCE(SUM(amount), 0) as total FROM fa_restaurant_income_expense WHERE type = 'income'");
        $expense = \think\Db::instance()->query("SELECT COALESCE(SUM(amount), 0) as total FROM fa_restaurant_income_expense WHERE type = 'expense'");
        $stats['restaurant_balance'] = $income[0]['total'] - $expense[0]['total'];
        
        $this->assign('stats', $stats);
        return $this->fetch();
    }
}
