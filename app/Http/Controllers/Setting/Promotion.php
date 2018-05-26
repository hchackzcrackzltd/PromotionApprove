<?php

namespace App\Http\Controllers\Setting;

use App\Model\Masterdata\Promotion as podb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Promotion extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Promotion.index',['data'=>podb::Other()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
        return view('Setting.Promotion.add');
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
        $request->validate(['promotion'=>'required|string']);
        podb::create(['name'=>$request->promotion,'createby'=>$request->user()->username,'inactive'=>0]);
        return redirect()->route('promotionmt.index')->with('success','Promotion Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Masterdata\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(podb $promotion)
    {
        return redirect()->route('promotionmt.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Masterdata\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(podb $promotion)
    {
        return redirect()->route('promotionmt.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Masterdata\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, podb $promotion)
    {
        return redirect()->route('promotionmt.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Masterdata\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(podb $promotionmt)
    {
      $this->authorize('setting',auth()->user()->Authorize_Main()->first());
      if ($promotionmt->inactive) {
        $promotionmt->update(['inactive'=>0,'updateby'=>Auth::user()->username]);
        return redirect()->route('promotionmt.index')->with('success','Promotion Active');
      }else {
        $promotionmt->update(['inactive'=>1,'updateby'=>Auth::user()->username]);
        return redirect()->route('promotionmt.index')->with('success','Promotion Inactive');
      }
    }
}
