<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIncomes(Request $request){
        if($request->start_date && $request->final_date ){
            $start_date = Carbon::parse($request->start_date);
            $final_date = Carbon::parse($request->final_date);

            if($final_date->greaterThan($start_date) || $final_date->isSameDay($start_date)){
                $expenses = Expense::where('user_id', auth()->user()->id)->whereBetween('date_operation', [$start_date, $final_date])->get();
            } else{
                $expenses = Expense::where('user_id', auth()->user()->id)->latest()->get();
            }
        } else{
            $expenses = Expense::where('user_id', auth()->user()->id)->latest()->get();
        }
        return $expenses->toJson();
    }

    /**
     * Calculate total expenses from month;
     *
     * @return \Illuminate\Http\Response
     */
    public function calculateTotalExpenses()
    {
        return Expense::where('user_id', auth()->user()->id)
                    ->where('date_operation', '>', Carbon::now()->subDays(30))
                    ->sum('amount');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPageExpenses()
    {
        return view('expenses');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = new Expense;
        if ($request->hasFile('file')) {

            $request->validate([
                'image' => 'mimes:jpeg,bmp,png'
            ]);

            $request->file->store('expenses', 'public');
            $expense->file_path = $request->file->hashName();
        }
        $expense->short_name = $request->short_name;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        $expense->date_operation = request()->date_operation;
        $expense->user_id = $request->user()->id;
        $expense->save();
        return response()->json([
            "message" => "Expense created",
            "id" => $expense->id
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Expense::where('id', $id)->get()->toJson();
    }

    /**
     * Show the invoice file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function displayInvoice($filepath)
    {
        $path = storage_path('app/public/expenses'.$filepath);
        return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        if(Expense::where('id', $id)->exists()){
            $expense = Expense::find($id);
            $expense->short_name = is_null($request->short_name) ? $expense->short_name : $request->short_name;
            $expense->amount = is_null($request->amount) ? $expense->amount : $request->amount;
            $expense->description = is_null($request->description) ? $expense->description : $request->description;
            if ($request->hasFile('file')) {

                $request->validate([
                    'image' => 'mimes:jpeg,bmp,png'
                ]);

                $request->file->store('expenses', 'public');
                $expense->file_path = $request->file->hashName();
            }
            $expense->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Expense not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Expense::destroy($id);
    }
}
