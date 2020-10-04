<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Image;
use File;
use DateTime;

use App\Model\Tables\Expense;
use App\Model\Tables\Branch;
use App\Model\Views\MonthlyExpense;
use App\Model\Views\MonthlySales;
use App\Model\Views\PopulerProducts;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $now_date = Carbon::now();
        $annual_sales = MonthlySales::where('branch_id', Auth::user()->branch_id)->sum('total_sales');
        $monthly_sales = MonthlySales::where('branch_id', Auth::user()->branch_id)->where('month', $now_date->month)->sum('total_sales');
        $monthly_expense = MonthlyExpense::where('branch_id', Auth::user()->branch_id)->where('month', $now_date->month)->sum('total_expense');

        $sales_overview = DB::table('view_monthly_sales')
            ->select('year', 'month', DB::raw('sum(total_sales) as total_sales'))
            ->where('branch_id', Auth::user()->branch_id)
            ->groupBy('year', 'month')
            ->get();
        $expense_overview =  DB::table('view_monthly_expense')
            ->select('year', 'month', DB::raw('sum(total_expense) as total_expense'))
            ->where('branch_id', Auth::user()->branch_id)
            ->groupBy('year', 'month')
            ->get();
        $month_name = [];
        $month_number = [];
        $month_sales = [];
        $month_expense = [];
        foreach($sales_overview as $data){
            $dateObj   = DateTime::createFromFormat('!m', $data->month);
            array_push($month_name, $dateObj->format('F'));
            array_push($month_number, $data->month);
            array_push($month_sales, (int)$data->total_sales);
        }
        for($i = 0; $i < count($month_number); $i++){
            $month_expense_total = 0;
            foreach($expense_overview as $data){
                if($month_number[$i] == $data->month){
                    $month_expense_total = (int)$data->total_expense;
                }
            }
            array_push($month_expense, $month_expense_total);
        }

        $popular_products = PopulerProducts::skip(0)->take(10)->get();
        $product_name = [];
        $product_sales_qty = [];
        foreach($popular_products as $data){
            array_push($product_sales_qty, (int)$data->sales_qty);
            array_push($product_name, $data->product_name_popular);
        }
        $data = array(
            "annual_sales" => $annual_sales,
            "monthly_sales" => $monthly_sales,
            "monthly_expense" => $monthly_expense,
            "month_name" => $month_name,
            "month_sales" => $month_sales,
            "month_expense" => $month_expense,
            "product_name" => $product_name,
            "product_sales_qty" => $product_sales_qty,
        );
        return view('dashboard.index')->with('data', $data);
    }
}
