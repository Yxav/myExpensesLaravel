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

Route::get('/reset-password', [AuthController::class, 'showForgetPassword'])->name('resetPassword');
Route::post('/reset-password-submit', [AuthController::class, 'submitRequestPasswordChange'])->name('resetPasswordSubmit');




Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'viewPageDash'])->name("dashboard");
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard.json");



    Route::get('expenses', [ExpenseController::class, 'viewPageExpenses'])->name("expenses");
    Route::get('expenses/all', [ExpenseController::class, 'index'])->name("allExpenses");


    Route::get('incomes', [IncomeController::class, 'viewPageIncomes'])->name("incomes");
    Route::get('goals', [GoalsController::class, 'viewPageGoals'])->name("goals");
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/expenses', [ExpenseController::class, 'store'])->name('store.expense');
    Route::get('/ha/expenses/month', [ExpenseController::class, 'index'])->name('index.expense');

    Route::post('/expenses/update', [ExpenseController::class, 'update'])->name('update.expense');
    Route::get('/expenses/{id}', [ExpenseController::class, 'show'])->name('expenses.show');
    Route::get('/expenses/delete/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::get('/invoice/expenses/{filepath}', [ExpenseController::class, 'displayInvoice'])->name('expenses.displayInvoice');



    Route::post('/incomes', [IncomeController::class, 'store'])->name('store.incomes');
    Route::post('/incomes/update', [IncomeController::class, 'update'])->name('update.income');
    Route::get('/incomes/{id}', [IncomeController::class, 'show'])->name('incomes.show');
    Route::get('/incomes/delete/{id}', [IncomeController::class, 'destroy'])->name('incomes.destroy');

    Route::post('/goals', [GoalsController::class, 'store'])->name('store.goals');
    Route::post('/goals/update', [GoalsController::class, 'update'])->name('update.goals');
    Route::get('/goals/{id}', [GoalsController::class, 'show'])->name('goals.show');
    Route::get('/json/goals', [GoalsController::class, 'indexJson'])->name('goals.json');
    Route::get('/goals/delete/{id}', [GoalsController::class, 'destroy'])->name('goals.destroy');






});


