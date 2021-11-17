<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Product;
use App\Models\Member;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Purchase;

class DashboardController extends Controller
{
  public function index()
  {
    $startdate = strtotime(date('Y-m-01'));
    $enddate = strtotime(date('Y-m-d'));
    $date = [];
    $earning = [];
    $total_earning = 0;
    $total_expense = 0;
    $earnPerDay = [];
    
    while($startdate < $enddate) {
      $tanggal = date('Y-m-d', $startdate);
      
      $sale = Sale::where('created_at', 'LIKE', "%$tanggal%")->sum('paid');
      $expense = Expense::where('created_at', 'LIKE', "%$tanggal%")->sum('nominal');
      $purchase = Purchase::where('created_at', 'LIKE', "%$tanggal%")->sum('paid');
      
      $total_earning += $sale;
      $total_expense += $purchase + $expense;
      
      $earnPerDay[] = [
        'date' => date('d', $startdate),
        'sale' => $total_earning,
        'expense' => $total_expense
        ];
      
      $startdate = strtotime('+1 day', $startdate);
    }
    
    if(Gate::allows('admin')) {
    return view('admin.dashboard.index', [
      'title' => 'Dashboard',
      'category' => Category::count(),
      'product' => Product::count(),
      'member' => Member::count(),
      'supplier' => Supplier::count(),
      'earning' => $earnPerDay
      ]);
    } else {
      return view('user.dashboard.index', [
        'title' => 'Dashboard'
        ]);
    }
  }
  
}
