<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
  public function index()
  {
    return view('admin.dashboard.index', [
      'title' => 'Dashboard'
      ]);
  }
}
