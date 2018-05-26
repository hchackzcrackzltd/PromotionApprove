<?php

namespace App\Http\Controllers\Setting;

use App\Model\Masterdata\Expense as exdb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Expense extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Expense.index',['data'=>exdb::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Expense.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
      $request->validate(['express'=>'required|string']);
      exdb::create(['name'=>$request->express,'createby'=>$request->user()->username,'inactive'=>0]);
      return redirect()->route('expense.index')->with('success','Expense Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Masterdata\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(exdb $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Masterdata\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(exdb $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Masterdata\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, exdb $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Masterdata\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(exdb $expense)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
      if ($expense->inactive) {
        $expense->update(['inactive'=>0,'updateby'=>Auth::user()->username]);
        return redirect()->route('expense.index')->with('success','Expense Active');
      }else {
        $expense->update(['inactive'=>1,'updateby'=>Auth::user()->username]);
        return redirect()->route('expense.index')->with('success','Expense Inactive');
      }
    }
}
