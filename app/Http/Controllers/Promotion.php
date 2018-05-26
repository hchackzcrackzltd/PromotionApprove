<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\itemResource;
use App\Http\Resources\oitmResource;
use App\Http\Resources\customerCollection;
use App\Http\Resources\promotionCollection;
use App\Http\Resources\customersubCollection;
use App\Model\Masterdata\OITM;
use App\Model\Masterdata\OCRD;
use App\Model\Masterdata\OITM_SPP;
use App\Model\Masterdata\Promotion as prodb;
use App\Model\Masterdata\Employee;
use App\Model\Pro;
use App\Model\Pro1;
use App\Model\Pro2;
use App\Model\Pro_view;
use App\Model\Pro2_view;
use App\Http\Controllers\Approve;

class Promotion extends Controller
{
  private $appcreate;
  function __construct(Approve $value)
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
      $this->authorize('promotionview',auth()->user()->Authorize_Main()->first());
      return view('Promotion.status',['datareq'=>Pro_view::with('Pro2')->myrequest()->orderBy('created_at','desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
        return view('Promotion.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
        $this->validate($request,[
          'customer'=>'required|string|exists:OCRD,keyword2',
          'subcustomer'=>'required|array',
          'period'=>'required|string',
          'detail'=>'required|string',
          'exp.*.id'=>'required|integer',
          'exp.*.value'=>'required|numeric',
          'item'=>'required|json',
          'remark'=>'nullable|string'
        ]);
        $period=explode('/',$request->period);
        $data=Pro::create([
          'account_id'=>json_encode($request->subcustomer),'str_date'=>$period[0],'end_date'=>$period[1],
          'desc'=>$request->detail,'remark'=>$request->remark,'createby'=>$request->user()->username,'status'=>'NQ',
          'account_group'=>$request->customer
        ]);
        foreach ($request->exp as $value) {
          Pro1::create(['pro_id'=>$data->id,'exp_id'=>$value['id'],'value'=>$value['value']]);
        }
        foreach (json_decode($request->item) as $value) {
          Pro2::create([
            'pro_id'=>$data->id,'seq'=>$value->id,'oitm_id'=>$value->code,'uom'=>$value->uom,'prom_id'=>$value->pro,
            'cost_price'=>$value->cost,'normal_price'=>$value->normal,'prom_price'=>$value->prop,'discount'=>$value->disc,'avgpcs'=>$value->avgpcs,
            'avgp'=>$value->avgpp,'sfcpcs'=>$value->sfcp,'sfcp'=>$value->sfcpp,'growth'=>$value->grow,'comp'=>$value->comp,
            'est'=>$value->est,'tcomp'=>$value->tcomp,'ts'=>$value->ts,'tn'=>$value->tn,'remark'=>$value->remark,'prom_etc'=>$value->etc_pro
          ]);
        }
        $this->appcreate->create($data);
        return redirect()->route('promotion.index')->with('success','Promotion Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pro_view $promotion)
    {
      $this->authorize('promotionview',auth()->user()->Authorize_Main()->first());
        return view('Promotion.detail',['data'=>$promotion,'cust'=>OCRD::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pro $promotion)
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
        return view('Promotion.duplicate',['data'=>$promotion->load(['Pro2','Pro2.descpro','Pro1','Pro2_item'])]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pro $promotion)
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
      $this->authorize('delete',$promotion);
        $promotion->update(['status'=>'CN']);
        return redirect()->route('promotion.index')->with('success','Promotion Cancel');
    }

    public function itemresponse($req)
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
      if ($req==='*') {
        return new itemResource(OITM::selectRaw("code AS [id],keyword AS [text]")->get());
      }else {
          return new itemResource(OITM::selectRaw("code AS [id],keyword AS [text]")->where('keyword','LIKE',"%{$req}%")->get());
      }
    }

    public function itemdetailresponse($com,$req)
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
        if (OITM_SPP::where([['code','=',"{$req}"],['groupname','=',$com]])->count()) {
          return new oitmResource(OITM_SPP::where([['code','=',"{$req}"],['groupname','=',$com]])->first());
        }else {
          return new oitmResource(OITM::where('code','=',"{$req}")->first());
        }
    }

    public function customergroupresponse($req)
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
      $sc=Employee::findOrFail(auth()->user()->username);
      if ($req==='*') {
        return new customerCollection(OCRD::selectRaw("keyword2 as [id],keyword2 as [text]")->mysales($sc->salecode)->groupBy('keyword2')->get());
      }else {
        return new customerCollection(OCRD::selectRaw("keyword2 as [id],keyword2 as [text]")->where('keyword2','LIKE',"%{$req}%")->mysales($sc->salecode)->groupBy('keyword2')->get());
      }
    }

    public function customersubresponse($req)
    {
      $this->authorize('promotion',auth()->user()->Authorize_Main()->first());
      return new customersubCollection(OCRD::selectRaw("concat(cardcode,',',company) as [id],keyword as [text]")->where('keyword2','LIKE',"%{$req}%")->get());
    }
}
