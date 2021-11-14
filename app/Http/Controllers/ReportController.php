<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\Setting;

class ReportController extends Controller
{
    public function index()
    {
      return view('admin.report.index', [
        'title' => 'Laporan',
        'setting' => Setting::first()
        ]);
    }
    
    public function data($start, $end)
    {
      $startdate = strtotime($start);
      $enddate = strtotime($end);
      $total_earning = 0;
      $data = [];
      $no = 1;
      $sum_sale = 0;
      $sum_purchase = 0;
      $sum_expense = 0;
      
      while($startdate <= $enddate) {
        $date = date('Y-m-d', $startdate);
        
        $total_sale = Sale::where('created_at', 'LIKE', "%$date%")->sum('paid');
        
        $total_purchase = Purchase::where('created_at', 'LIKE', "%$date%")->sum('paid');
        
        $total_expense = Expense::where('created_at', 'LIKE', "%$date%")->sum('nominal');
        
        $total_earning = $total_sale - $total_purchase - $total_expense;
        
        $row = [];
        $row['DT_RowIndex'] = $no++;
        $row['sale'] = 'Rp ' . number_format($total_sale, 0, ',', '.');
        $row['purchase'] = 'Rp' . number_format($total_purchase, 0, ',', '.');
        $row['expense'] = 'Rp ' . number_format($total_expense, 0, ',', '.');
        $row['earning'] = 'Rp ' . number_format($total_earning, 0, ',', '.');
        $row['date'] = date('d-m-Y', $startdate);
        
        $data[] = $row;
        
        $startdate = strtotime('+1 day', $startdate);
      }

      return $data;
    }
    
    public function getReport($start, $end) 
    {
      return datatables()
        ->of($this->data($start, $end))
        ->make(true);
    }
    
    public function print($startdate, $enddate)
    {
      $data = $this->data($startdate, $enddate);

      return view('admin.report.print', [
        'data' => $data,
        'startdate' => $startdate,
        'enddate' => $enddate
      ]);
    }
    
}
