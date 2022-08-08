<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 50; $i++) {
            $income = new Expense();
            $income->short_name = "expense" . $i;
            $income->amount = $i * 100;
            $income->description = "expense" . $i;
            $income->date_operation = now();
            $income->user_id = 1;
            $income->save();
        }
    }
}
