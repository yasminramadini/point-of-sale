<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');

Route::post('/register/store', [AuthController::class, 'register_store'])->name('register.store');

Route::post('/login/store', [AuthController::class, 'login_store'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('/categories', CategoryController::class);
    
    Route::get('/data_categories', [CategoryController::class, 'data']);
    
    Route::resource('/products', ProductController::class);
    
    Route::get('/data_products', [ProductController::class, 'data']);
    
    Route::post('/delete_all_products', [ProductController::class, 'delete_all_products']);
    
    Route::post('/print_barcode', [ProductController::class, 'print_barcode']);
    
    Route::resource('/members', MemberController::class);
    
    Route::get('/data_members', [MemberController::class, 'data']);
    
    Route::post('/delete_all_members', [MemberController::class, 'delete_all_members']);
    
    Route::post('/print_card', [MemberController::class, 'print_card']);
    
    Route::resource('/suppliers', SupplierController::class);
    
    Route::get('/data_suppliers', [SupplierController::class,'data']);
    
    Route::resource('/expenses', ExpenseController::class);
    
    Route::get('/data_expenses', [ExpenseController::class, 'data']);
});