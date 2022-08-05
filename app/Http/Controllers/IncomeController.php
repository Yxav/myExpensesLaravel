<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Income::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPageIncomes()
    {
        $incomes = $this->index();
        $total = $this->calculateTotalIncomes();

        return view('incomes', compact('incomes', 'total'));
    }

     /**
     * Calculate total expenses from month;
     *
     * @return \Illuminate\Http\Response
     */
    public function calculateTotalIncomes()
    {
        return Income::where('user_id', auth()->user()->id)
                    ->where('date_operation', '>', Carbon::now()->subDays(30))
                    ->sum('amount');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $income = new Income();
        if ($request->hasFile('file')) {

            $request->validate([
                'image' => 'mimes:jpeg,bmp,png'
            ]);

            $request->file->store('incomes', 'public');
            $income->file_path = $request->file->hashName();
        }
        $income->short_name = $request->short_name;
        $income->amount = $request->amount;
        $income->description = $request->description;
        $income->date_operation = request()->date_operation;
        $income->user_id = $request->user()->id;
        $income->save();
        return response()->json([
            "message" => "Income created",
            "id" => $income->id
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
        return Income::where('id', $id)->get()->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $request->id;
        if(Income::where('id', $id)->exists()){
            $income = Income::find($id);
            $income->short_name = is_null($request->short_name) ? $income->short_name : $request->short_name;
            $income->amount = is_null($request->amount) ? $income->amount : $request->amount;
            $income->description = is_null($request->description) ? $income->description : $request->description;
            $income->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Income not found"
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
        return Income::destroy($id);

    }
}
