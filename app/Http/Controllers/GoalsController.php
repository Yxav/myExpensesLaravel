<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class GoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Goal::where('user_id', auth()->user()->id)->get();
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJson()
    {
        return Goal::where('user_id', auth()->user()->id)->get()->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPageGoals()
    {
        $goals = $this->index();
        return view('goals', compact('goals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goal = new Goal();
        $goal->short_name = $request->short_name;
        $goal->amount = $request->amount;
        $goal->actual_balance = request()->actual_balance;
        $goal->date_operation = request()->date_operation;
        $goal->user_id = $request->user()->id;
        $goal->save();
        return response()->json([
            "message" => "goal created",
            "id" => $goal->id
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
        return Goal::where('id', $id)->get()->toJson();

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
    public function update(Request $request)
    {
        $id = $request->id;
        if(Goal::where('id', $id)->exists()){
            $goal = Goal::find($id);
            $goal->short_name = is_null($request->short_name) ? $goal->short_name : $request->short_name;
            $goal->amount = is_null($request->amount) ? $goal->amount : $request->amount;
            if($request->deposit){
                $goal->actual_balance = ($request->deposit + $goal->actual_balance);
            } else {
                $goal->actual_balance = is_null($request->actual_balance) ? $goal->actual_balance : $request->actual_balance;
            }
            $goal->date_operation = is_null($request->date_operation) ? $goal->date_operation : $request->date_operation;
            $goal->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "goal not found"
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
        return Goal::destroy($id);
    }
}
