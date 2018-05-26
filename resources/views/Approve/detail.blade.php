@component('component.tab',['id'=>'detailmodel','nav'=>[[1,'detail','align-justify','Request'],[0,'approve','list-ol','Approval']]])
  @component('component.tab_content',['id'=>'detail','active'=>1])
    @component('component.card')
      @slot('title')
        <i class="fa fa-info"></i> Detail
      @endslot
      <div class="row">
        <div class="col-6">
          <label class="col-12 h6">Account/ห้าง,ร้านค้า</label>
          <p>{{$data->account_group}}</p>
        </div>
        <div class="col-6">
          <label class="col-12 h6">Branch/สาขา</label>
          @if ($data->account_id==='*')
            <p>All Branch</p>
          @else
            @foreach (json_decode($data->account_id) as $value2)
              <p>{{$customer->where('cardcode2',explode(',',$value2)[0])->where('company',explode(',',$value2)[1])->first()->keyword}}</p>
            @endforeach
          @endif
        </div>
        <div class="col-12">
          <label class="col-12 h6">Description/รายละเอียด</label>
          <p>{{$data->desc}}</p>
        </div>
        <div class="col-12">
          @component('component.table',['istfoot'=>0,'table_class'=>'text-center table-bordered'])
            @slot('thead')
              <tr class="table-info">
                <th>Expense/ค่าใช้จ่าย</th>
                <th>Amount/จำนวน</th>
              </tr>
            @endslot
              @forelse ($data->load(['Pro1','Pro1.descexp'])->Pro1 as $exvalue)
                <tr><td>{{$exvalue->descexp->name}}</td><td>{{$exvalue->value}}</td></tr>
              @empty
                <tr><td colspan="2">No Expense</td></tr>
              @endforelse
          @endcomponent
        </div>
        <div class="col-12">
          @component('component.table',['istfoot'=>true,'table_class'=>'text-center table-bordered'])
            @slot('thead')
              <tr class="table-primary">
                <th rowspan="2">Product Code</th>
                <th rowspan="2">Product</th>
                <th rowspan="2">Packing</th>
                <th rowspan="2">Promotion Type</th>
                <th rowspan="2">Cost ExVat</th>
                <th rowspan="2">Normal Price</th>
                <th rowspan="2">Promotion Price</th>
                <th rowspan="2">Discount %</th>
                <th colspan="2">Avg.Sales</th>
                <th colspan="2">Sales Forecast</th>
                <th rowspan="2">Growth %</th>
              </tr>
              <tr class="table-primary">
                <th>Pcs.</th>
                <th>Bath</th>
                <th>Pcs.</th>
                <th>Bath</th>
              </tr>
            @endslot
            @slot('tfoot')
              <tr>
                <th colspan="8">Total</th>
                <th id="gavgpcs">{{number_format($data->load('Pro2')->Pro2->sum('avgpcs'),config('app.number_precision'))}}</th>
                <th id="gavgbth">{{number_format($data->load('Pro2')->Pro2->sum('avgp'),config('app.number_precision'))}}</th>
                <th id="gsfcpcs">{{number_format($data->load('Pro2')->Pro2->sum('sfcpcs'),config('app.number_precision'))}}</th>
                <th id="gsfcbth">{{number_format($data->load('Pro2')->Pro2->sum('sfcp'),config('app.number_precision'))}}</th>
                <th id="gglowth">{{number_format((($data->load('Pro2')->Pro2->sum('sfcp')-$data->load('Pro2')->Pro2->sum('avgp'))/$data->load('Pro2')->Pro2->sum('avgp'))*100,config('app.number_precision'))}}</th>
              </tr>
            @endslot
            @forelse ($data->load(['Pro2','Pro2.descpro'])->Pro2->sortBy('seq') as $valuet1)
              <tr>
                <td>{{$valuet1->oitm_id}}</td>
                <td>{{$item->where('code2',$valuet1->oitm_id)->first()->name}}</td>
                <td>{{$item->where('code2',$valuet1->oitm_id)->first()->uom}}</td>
                <td>{{($valuet1->prom_id==1)?$valuet1->prom_etc:$valuet1->descpro->name}}</td>
                <td>{{number_format($valuet1->cost_price,config('app.number_precision'))}}</td><td>{{number_format($valuet1->normal_price,config('app.number_precision'))}}</td><td>{{number_format($valuet1->prom_price,config('app.number_precision'))}}</td>
                <td>{{number_format($valuet1->discount,config('app.number_precision'))}}</td>
                <td>{{number_format($valuet1->avgpcs,config('app.number_precision'))}}</td><td>{{number_format($valuet1->avgp,config('app.number_precision'))}}</td><td>{{number_format($valuet1->sfcpcs,config('app.number_precision'))}}</td><td>{{number_format($valuet1->sfcp,config('app.number_precision'))}}</td>
                <td>{{number_format($valuet1->growth,config('app.number_precision'))}}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5"><b>No Data</b></td>
              </tr>
            @endforelse
          @endcomponent
        </div>
        <div class="col-12">
          @component('component.table',['istfoot'=>true,'table_class'=>'text-center table-bordered'])
            @slot('thead')
              <tr class="table-primary">
                <th>Comp. (ต่อชิ้น)</th>
                <th>Est. (ขายออก) (ชิ้น)</th>
                <th>Total Compensate</th>
                <th>% To Sales</th>
                <th>Total Net Revenue</th>
                <th>Remark</th>
              </tr>
            @endslot
            @slot('tfoot')
              <tr>
                <th colspan="2">Other Expenses:</th>
                <th>{{number_format($data->load('Pro1')->Pro1->sum('value'),config('app.number_precision'))}}</th>
                @php
                  $expcal=$data->load('Pro1')->Pro1->sum('value');
                @endphp
                <th>{{($expcal>0)?number_format(($expcal/$data->load('Pro2')->Pro2->sum('sfcp'))*100,config('app.number_precision')):0}}</th>
              </tr>
              <tr>
                <th colspan="2">Total Expenses:</th>
                <th id="gtcomp">{{number_format(($data->load('Pro2')->Pro2->sum('tcomp')+$expcal),config('app.number_precision'))}}</th>
                <th id="gts">{{number_format((($data->load('Pro2')->Pro2->sum('tcomp')+$expcal)/(($data->load('Pro2')->Pro2->sum('sfcp')>0)?$data->load('Pro2')->Pro2->sum('sfcp'):1))*100,config('app.number_precision'))}}</th>
              </tr>
            @endslot
            @foreach ($data->load('Pro2')->Pro2->sortBy('seq') as $valuet2)
              <tr>
                <td>{{number_format($valuet2->comp,config('app.number_precision'))}}</td><td>{{number_format($valuet2->est,config('app.number_precision'))}}</td>
                <td>{{number_format($valuet2->tcomp,config('app.number_precision'))}}</td><td>{{number_format($valuet2->ts,config('app.number_precision'))}}</td>
                <td>{{number_format($valuet2->tn,config('app.number_precision'))}}</td><td>{{$valuet2->remark}}</td>
              </tr>
            @endforeach
          @endcomponent
        </div>
        <div class="col-12">
          <label class="col-12 h6">Remark/หมายเหตุ</label>
          <p>{{$data->remark}}</p>
        </div>
      </div>
    @endcomponent
  @endcomponent
  @component('component.tab_content',['id'=>'approve','active'=>0])
    @component('component.card')
      @slot('title')
        <i class="fa fa-list-ol"></i> Approvel
      @endslot
      <div class="row">
        <div class="col-12">
          @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
            @slot('thead')
              <tr>
                <th>Approvel</th><th>Status</th>
              </tr>
            @endslot
            <tr>
              <td>1</td><td>1</td>
            </tr>
          @endcomponent
        </div>
      </div>
    @endcomponent
  @endcomponent
@endcomponent
