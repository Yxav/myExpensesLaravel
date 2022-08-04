<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GoalsController;




use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('/register', [AuthController::class, 'registration'])->name('register');
Route::post('/post-register', [AuthController::class, 'postRegistration'])->name('register.post');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'viewPageDash'])->name("dashboard");
    Route::get('expenses', [ExpenseController::class, 'viewPageExpenses'])->name("expenses");
    Route::get('incomes', [IncomeController::class, 'viewPageIncomes'])->name("incomes");
    Route::get('goals', [GoalsController::class, 'viewPageGoals'])->name("goals");
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});


