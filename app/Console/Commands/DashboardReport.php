<?php

namespace App\Console\Commands;

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Models\Dashboard;
use App\Models\Income;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;




class DashboardReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $users = User::all();

        foreach ($users as $user){
            $dashboard = new Dashboard();
            $dashboard->month = Carbon::now()->month;
            $dashboard->year = Carbon::now()->year;
            $incomes = $user->incomes;
            $expenses = $user->expenses;
            $expensesThisMonth = $expenses->filter(function($obj) {
                $date = new DateTime($obj->date_operation);
                return $date->format("m") == Carbon::now()->month - 1;
            });
            $incomesThisMonth = $incomes->filter(function($obj) {
                $date = new DateTime($obj->date_operation);
                return $date->format("m") == Carbon::now()->month - 1;
            });
            $dashboard->incomes = $incomesThisMonth->sum('amount');
            $dashboard->expenses = $expensesThisMonth->sum('amount');
            $dashboard->user_id = $user->id;
            $dashboard->save();
        }
        return 0;
    }
}
