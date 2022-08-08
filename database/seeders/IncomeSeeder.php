<?php

namespace Database\Seeders;

use App\Models\Income;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for ($i=0; $i < 50; $i++) {
        $income = new Income();
        $income->short_name = "teste" . $i;
        $income->amount = $i * 100;
        $income->description = "teste" . $i;
        $income->date_operation = now();
        $income->user_id = 1;
        $income->save();
    }
    }
}
