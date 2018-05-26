<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Authorize as atdb;
use App\Model\Authorize_Main;
use App\Model\Masterdata\Employee;

class Authorize extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Authorize.index',['data'=>Authorize_Main::with('authorize')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Authorize.add');
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
        $request->validate([
          'username'=>'required|unique:authorize__mains,username',
          'type'=>'required|in:0,1',
          'salescode'=>'required|exists:sales,SlpCode',
          'apvlist'=>'required|exists:approves,id',
          'role.*'=>'required|in:0,1'
        ],[
          'username.unique'=>'User Existing'
        ]);
        $data=Authorize_Main::create(['username'=>$request->username,'isadmin'=>$request->type,'approve_id'=>$request->apvlist]);
        foreach ($request->role as $key => $value) {
          atdb::create(['authorize_id'=>$data->id,'funct_id'=>$key,'permit'=>$value]);
        }
        Employee::find($request->username)->update(['salecode'=>$request->salescode]);
        return redirect()->route('authorize.index')->with('success','User Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('authorize.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Authorize_Main $authorize)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Authorize.edit',['data'=>$authorize->load('authorize')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Authorize_Main $authorize)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
      $request->validate([
        'type'=>'required|in:0,1',
        'salescode'=>'required|exists:sales,SlpCode',
        'role.*'=>'required|in:0,1'
      ]);
      $authorize->update(['isadmin'=>$request->type,'approve_id'=>$request->apvlist]);
      foreach ($request->role as $key => $value) {
        atdb::where([['authorize_id',$authorize->id],['funct_id',$key]])->update(['permit'=>$value]);
      }
      Employee::find($authorize->username)->update(['salecode'=>$request->salescode]);
      return redirect()->route('authorize.index')->with('success','User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authorize_Main $authorize)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
      $authorize->authorize()->delete();
      $authorize->delete();
      return redirect()->route('authorize.index')->with('success','Delete Updated');
    }
}
