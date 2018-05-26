<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Approve_List;
use App\Model\Pro;
use App\Model\Masterdata\emp_proapp;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Approve;
use App\Mail\reject;
use Illuminate\Support\Facades\Mail;

class Approve_Act extends Controller
{
  private $approve_act;
  function __construct(Approve $approve_act)
  {
    $this->approve_act=$approve_act;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('approve',auth()->user()->Authorize_Main()->first());
        return view('Approve.index',['datareq'=>Approve_List::with(['pro','pro.Pro2'])->listapprove()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, Pro $approve)
    {
      $this->authorize('approve',auth()->user()->Authorize_Main()->first());
      $this->authorize('update',$approve->list_approve()->myapprove()->first());
        $this->approve_act->currentapp($approve);
        return redirect()->route('approve.index')->with('success','Request Approved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pro $approve,Request $request)
    {
      $this->authorize('approve',auth()->user()->Authorize_Main()->first());
      $this->authorize('delete',$approve->list_approve()->myapprove()->first());
        $request->validate(['cnreason'=>'nullable|string'],['cnreason.required'=>'Please Insert Reason For Reject']);
        $approve->list_approve()->where('user_id',Auth::user()->username)->update(['remark'=>$request->cnreason]);
        $approve->update(['status'=>'CN']);
        Mail::to(emp_proapp::findOrFail($approve->createby))->send(new reject($approve));
        return redirect()->route('approve.index')->with('success','Promotion has reject');
    }
}
