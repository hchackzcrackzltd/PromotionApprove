<?php

namespace App\Http\Controllers\Setting;

use App\Model\Masterdata\Approve;
use App\Model\Masterdata\Approve1;
use App\Model\Masterdata\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Approve as appact;

class Approveal extends Controller
{
    private $appcreate;
    function __construct(appact $value)
    {
        $this->appcreate=$value;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Approvel.index',['data'=>Approve::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Approvel.add');
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
        $request->validate(['list_name'=>'required|string','userall'=>'required|json'],[
          'list_name.required'=>'Please Spacify List Approve',
          'userall.required'=>'Please Add User For Approve'
        ]);
        if (count(json_decode($request->userall))) {
          $appp=Approve::create(['name'=>$request->list_name,'createby'=>$request->user()->username]);
          foreach (json_decode($request->userall) as $value) {
            $usname=Employee::findOrFail($value->user_id);
            $appp->approve1()->create([
              'approves_id'=>$appp->id,'seq'=>$value->seq,'user_id'=>$value->user_id,'line'=>$value->line,
              'name'=>$usname->fname_en." ".$usname->lname_en,
              'email'=>$usname->email_office
            ]);
          }
          return redirect()->route('approvelmt.index')->with('success','Approve List Added');
        }
        return back()->withErrors(['userall'=>'Error Get User Approve']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Masterdata\Approve  $approve
     * @return \Illuminate\Http\Response
     */
    public function show(Approve $approve)
    {
        return redirect()->route('approvelmt.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Masterdata\Approve  $approve
     * @return \Illuminate\Http\Response
     */
    public function edit(Approve $approvelmt)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Approvel.edit',['data'=>$approvelmt->load('approve1')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Masterdata\Approve  $approve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Approve $approvelmt)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
      $request->validate(['userall'=>'required|json'],[
        'userall.required'=>'Please Add User For Approve'
      ]);
      if (count(json_decode($request->userall))) {
        $approvelmt->update(['updateby'=>$request->user()->username]);
        Approve1::where('approves_id',$approvelmt->id)->delete();
        foreach (json_decode($request->userall) as $key=>$value) {
          $usname=Employee::findOrFail($value->user_id);
          Approve1::create([
            'approves_id'=>$approvelmt->id,'seq'=>$value->seq,'user_id'=>$value->user_id,'line'=>$key,
            'name'=>$usname->fname_en." ".$usname->lname_en,
            'email'=>$usname->email_office
          ]);
        }
        $this->appcreate->refactor($approvelmt);
        return redirect()->route('approvelmt.index')->with('success','Approve List Updated');
      }
      return back()->withErrors(['userall'=>'Error Get User Approve']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Masterdata\Approve  $approve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approve $approvelmt)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
      $approvelmt->update(['updateby'=>Auth::user()->username]);
      $approvelmt->approve1()->delete();
        $approvelmt->delete();
        return redirect()->route('approvelmt.index')->with('success','Approve List Deleted');
    }
}
