@extends('template.blank')

@section('title_page','Promotion Approval Form')

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[[route('Dashboard'),'Dashboard',null],[route('promotion.edit',['promotion'=>$data->id]),'Promotion Request','active']]])
  @endcomponent
@endsection

@section('card_title')
<h5><i class="fa fa-file"></i> Promotion Approval</h5>
@endsection

@section('content')
  <div class="row">
    <form id="mainform" action="{{route('promotion.store')}}" method="post">
      {{csrf_field()}}
    <div class="col-12 col-md-6 col-lg-5">
      <div class="form-group">
    <label for="account" class="col-form-label"><b>Account/ห้าง,ร้านค้า</b><i class="text-danger">*</i></label>
    <select class="form-control" id="customer" name="customer" required>
      <option selected disabled>Select Customer</option>
    </select>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-5">
    <div class="form-group">
  <label for="customersub" class="col-form-label"><b>Branch/สาขา</b><i class="text-danger">*</i></label>
  <select class="form-control" id="customersub" name="subcustomer[]" multiple="multiple" required></select>
  </div>
</div>
  <div class="col-12 col-md-6 col-lg-5">
    <div class="form-group">
  <label for="period" class="col-form-label"><b>Period/ระยะเวลา</b><i class="text-danger">*</i></label>
  <div class="input-group">
    <div class="input-group-prepend">
      <p class="input-group-text"><i class="fa fa-calendar"></i></p>
    </div>
    <input type="text" class="form-control" id="period" name="period" placeholder="Date Promotion" readonly required>
  </div>
  </div>
  </div>
  <div class="col-12">
    <div class="form-group">
  <label for="detail" class="col-form-label"><b>Description/รายละเอียดรายการ</b><i class="text-danger">*</i></label>
  <textarea name="detail" class="form-control" rows="4" id="detail" placeholder="Description/รายละเอียดรายการ" required></textarea>
  </div>
  </div>
  <div class="col-12">
    <b>Expenses/ค่าใช้จ่าย :</b><i class="text-danger">*(กรุณาใส่ 0 หากไม่มีค่าใช้จ่าย)</i>
    <div class="row">
      @foreach ($expense as $value)
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <div class="form-group">
      <label for="expen" class="col-form-label"><b>{{$value->name}}</b><i class="text-danger">*</i></label>
      <div class="input-group">
        <div class="input-group-prepend">
          <p class="input-group-text"><i class="fa fa-archive"></i></p>
        </div>
        <input type="text" class="d-none" name="exp[{{$loop->index}}][id]" value="{{$value->id}}">
        <input type="text" name="exp[{{$loop->index}}][value]" class="form-control mform expen" id="expen" value="{{$data->Pro1->where('exp_id',$value->id)->first()->value}}" placeholder="Insert Value" data-inputmask="'alias':'decimal'">
      </div>
      </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="col-12 btnact">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addmodel"><i class="fa fa-plus"></i> Add</button>
      <button type="button" class="btn btn-danger delete"><i class="fa fa-trash"></i> Delete</button>
    </div>
  </div>
  <div class="col-12">
    @component('component.table',['istfoot'=>true,'table_class'=>'text-center t1'])
      @slot('thead')
        <tr class="table-primary">
          <th rowspan="2"><input type="checkbox" name="selectall" value="1"/></th>
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
          <th colspan="9">Total</th>
          <th id="gavgpcs">{{$data->Pro2->sum('avgpcs')}}</th>
          <th id="gavgbth">{{$data->Pro2->sum('avgp')}}</th>
          <th id="gsfcpcs">{{$data->Pro2->sum('sfcpcs')}}</th>
          <th id="gsfcbth">{{$data->Pro2->sum('sfcp')}}</th>
          <th id="gglowth">{{number_format((($data->Pro2->sum('sfcp')-$data->Pro2->sum('avgp'))/$data->Pro2->sum('avgp'))*100,config('app.number_precision'))}}</th>
        </tr>
      @endslot
      @foreach ($data->Pro2->sortBy('seq') as  $t1)
        @php
          $itemt1=$item->where('code2',$t1->oitm_id)->first();
        @endphp
        <tr>
          <td><input type='checkbox' name='select' class='selected' value='{{$t1->seq}}'/></td><td>{{$t1->oitm_id}}</td><td>{{$itemt1->name}}</td><td>{{$itemt1->uom}}</td>
          <td>{{$t1->descpro->name}}</td><td>{{$t1->cost_price}}</td><td>{{$t1->normal_price}}</td><td>{{$t1->prom_price}}</td>
          <td>{{$t1->discount}}</td><td>{{$t1->avgpcs}}</td><td>{{$t1->avgp}}</td><td>{{$t1->sfcpcs}}</td><td>{{$t1->sfcp}}</td>
          <td>{{$t1->growth}}</td>
        </tr>
      @endforeach
    @endcomponent
  </div>
  <div class="col-12">
    @component('component.table',['istfoot'=>true,'table_class'=>'text-center t2'])
      @slot('thead')
        <tr class="table-primary">
          <th>#</th>
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
          <th colspan="3">Other Expenses:</th>
          <th id="caltotalexp">{{$data->Pro1->sum('value')}}</th>
          @php
            $expcal=$data->Pro1->sum('value');
          @endphp
          <th id="caltotalexp_sfcp">{{number_format(($expcal>0)?($expcal/$data->Pro2->sum('sfcp'))*100:0,config('app.number_precision'))}}</th>
        </tr>
        <tr>
          <th colspan="3">Total Expenses:</th>
          <th id="gtcomp">{{number_format(($data->Pro2->sum('tcomp')+$expcal),config('app.number_precision'))}}</th>
          <th id="gts">{{number_format((($data->Pro2->sum('tcomp')+$expcal)/(($data->Pro2->sum('sfcp')>0)?$data->Pro2->sum('sfcp'):1))*100,config('app.number_precision'))}}</th>
        </tr>
      @endslot
      @foreach ($data->Pro2->sortBy('seq') as  $t2)
        <tr>
          <td><i id='t2del{{$t2->seq}}'>-></i></td><td>{{$t2->comp}}</td><td>{{$t2->est}}</td><td>{{$t2->tcomp}}</td>
          <td>{{$t2->ts}}</td><td>{{$t2->tn}}</td><td>{{$t2->remark}}</td>
        </tr>
      @endforeach
    @endcomponent
  </div>
  <div class="col-12">
    <div class="form-group">
  <label for="remark" class="col-form-label"><b>Remark/หมายเหตุ</b></label>
  <textarea name="remark" class="form-control" rows="5" id="remark" placeholder="Remark/หมายเหต"></textarea>
  </div>
  <textarea name="item" class="d-none" required>{{$data->Pro2_item}}</textarea>
  </div>
  <div class="col-12 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="reset" class="btn btn-danger"><i class="fa fa-repeat"></i> <b>Reset</b></button>
      <button type="button" class="btn btn-success btnmainf"><i class="fa fa-save"></i> <b>Save</b></button>
    </div>
  </div>
  </form>
  </div>
  @component('component.model',['id'=>'addmodel'])
    @slot('title')
      <i class="fa fa-plus"></i> Add Item
    @endslot
    @slot('footer')
      <div class="btn-group text-right" role="group" aria-label="Basic example">
        <button type="reset" class="btn btn-danger" form="tableall"><i class="fa fa-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success" form="tableall"><i class="fa fa-plus"></i> Add</button>
      </div>
    @endslot
    @component('component.card')
      @slot('title')
        <b>Form</b>
      @endslot
      <form id="tableall" name="tableall">
        <div class="row">
          <div class="col-12">
              <fieldset class="form-group">
                <label for="productcode"><b>Product</b></label>
                  <select class="form-control" id="productcode" required>
                    <option selected disabled>Select Product</option>
                  </select>
              </fieldset>
          </div>
          <div class="col-12">
              <fieldset class="form-group">
                <label for="promotion"><b>Promotion</b></label>
                  <select class="form-control" id="promotion" required>
                    <option selected disabled>Select Promotion</option>
                    @foreach ($promotion as $value)
                      <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                  </select>
              </fieldset>
              <div class="col-12 collapse" id="etc_pro">
                <input type="text" class="form-control" name="etc_pro" placeholder="Spacify Promotion" required='false'>
              </div>
          </div>
          <div class="col-12 col-xl-6">
            <fieldset class="form-group">
              <label for="normalpr"><b>Normal Price</b></label>
              <div class="input-group">
                <input type="text" class="form-control" id="normalpr" data-inputmask="'alias':'decimal'" placeholder="0" required readonly>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fa fa-btc"></i>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-12 col-xl-6">
            <fieldset class="form-group">
              <label for="prop"><b>Promotion Price</b></label>
              <div class="input-group">
                <input type="text" class="form-control" id="prop" data-inputmask="'alias':'decimal'" placeholder="0" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="fa fa-btc"></i>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-12 col-md-4">
            <fieldset class="form-group">
              <label for="avgpcs"><b>Avg. Sales</b></label>
              <div class="input-group">
                <input type="text" class="form-control" id="avgpcs" data-inputmask="'alias':'decimal'" placeholder="0" required>
                <div class="input-group-append">
                  <div class="input-group-text uom">
                    ชิ้น
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-12 col-md-4">
            <fieldset class="form-group">
              <label for="salesf"><b>Sales Forecast</b></label>
              <div class="input-group">
                <input type="text" class="form-control" id="salesf" data-inputmask="'alias':'decimal'" placeholder="0" required>
                <div class="input-group-append">
                  <div class="input-group-text uom">
                    ชิ้น
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-12 col-md-4">
            <fieldset class="form-group">
              <label for="est"><b>Est. ขายออก</b></label>
              <div class="input-group">
                <input type="text" class="form-control" id="est" data-inputmask="'alias':'decimal'" placeholder="0" required>
                <div class="input-group-append">
                  <div class="input-group-text uom">
                    ชิ้น
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
          <div class="col-12 text-right">
            <button type="button" name="button" class="btn btn-primary convet" data-uommin="" data-uommax="" data-convert="0" data-state="1"><i class="fa fa-retweet"></i> Convert</button>
          </div>
          <div class="col-12">
            <fieldset class="form-group">
              <label for="remark"><b>Remark</b></label>
              <textarea name="remark" class="form-control" rows="3" id="remarkitm"></textarea>
            </fieldset>
          </div>
        </div>
      </form>
    @endcomponent
    <br>
    <div class="row">
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Cost ExVat</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="coste">0</h5>
            <h4>บาท</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Normal Price</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="norp">0</h5>
            <h4>บาท</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Discount</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="disc">0</h5>
            <h4>%</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Avg. Sales</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="avgsm">0</h5>
            <h4>บาท</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Sales Forecast</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="sfm">0</h5>
            <h4>บาท</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Growth</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="grow">0</h5>
            <h4>%</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Comp.</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="comp">0</h5>
            <h4>ต่อ<b class="uom">ชิ้น</b></h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Total Compensate</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="tcomp">0</h5>
            <h4>บาท</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>To Sales</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="tos">0</h5>
            <h4>%</h4>
          </div>
        @endcomponent
        <br>
      </div>
      <div class="col-12 col-md-6 col-xl-4">
        @component('component.card')
          @slot('title')
            <i class="fa fa-calculator"></i> <b>Total Net Revenue</b>
          @endslot
          <div class="col-12 text-center">
            <h5 id="tnr">0</h5>
            <h4>บาท</h4>
          </div>
        @endcomponent
        <br>
      </div>
    </div>
  @endcomponent
@endsection

@section('script')
  $(function(){
    var num_percis={{config('app.number_precision')}},
    total={cost:0,normal:0,prop:0,discount:0,avgs:0,sfc:0,growth:0,comp:0,tcomp:0,ts:0,tn:0,uom:null,uom2:null,conv:0,state:1,name:null},
    item=JSON.parse($('textarea[name=item]').val()),gtotal={avgpcs:0,avgbth:0,sfcpcs:0,sfcbth:0,glowth:0,tcomp:0,ts:0},totalexp={{$data->Pro1->sum('value')}};
    setTimeout(function() {
      $('body').addClass('sidenav-toggled');
    },1500);
    var cust=$('#customer').select2({
       placeholder:'Select Customer',
       ajax: {
         url: function (params) {
           return '../getcustomer/'+params.term;
         },
   processResults: function (data) {
     return {
       results: data.data
     };
   },data:function(data){
     return {};
   }
 },minimumInputLength: 1,width:'100%'
});
var cusb=$('#customersub').select2({
   placeholder:'Select Branch',width:'100%'
});
cust.on('select2:select', function(event) {
  cusb.select2('destroy');
  $('#customersub').empty();
  $.get('../getcustomersub/'+cust.val()).done(function(data) {
    $('#customersub').append("<option value='*'>All Branch</option>");
    $.each(data.data,function(index, el) {
      $('#customersub').append("<option value='"+el.id+"'>"+el.text+"</option>");
    });
  });
  cusb.select2({placeholder:'Select Branch',width:'100%'});
});
$("#period").daterangepicker({
  minDate: moment().subtract(2, 'years'),
  callback: function (startDate, endDate, period) {
    $(this).val(startDate.format('YYYY-MM-DD') + '/' + endDate.format('YYYY-MM-DD'));
  }
});
     var mf=$('#mainform').parsley();
     inputmask().mask($('.mform'));
    var t1=$('.t1').DataTable({
      paging: false,
      searching:false,
      columnDefs: [{ orderable: false, targets: 0 }]
    });
    var t2=$('.t2').DataTable({
      paging: false,
      searching:false
    });
    $('#gtcomp').on('cal', function(event) {
      var exp=0;
      $('.expen').each(function(index, el) {
        exp+=parseFloat($(el).val());
      });
      $('#caltotalexp').text(_.round((exp>0)?exp:0,num_percis));
      totalexp=exp;
    });
    $('#gavgpcs').on('cal', function(event) {
      var exp=totalexp>0?totalexp:0;
      $.each(item,function(index, el) {
        $('#gavgpcs').text(gtotal.avgpcs+=parseInt(el.avgpcs));
        $('#gavgbth').text(_.round(gtotal.avgbth+=parseFloat(el.avgpp),num_percis));
        $('#gsfcpcs').text(gtotal.sfcpcs+=parseInt(el.sfcp));
        $('#gsfcbth').text(_.round(gtotal.sfcbth+=parseFloat(el.sfcpp),num_percis));
        gtotal.tcomp+=parseFloat(el.tcomp);
      });
      $('#gtcomp').text(_.round(gtotal.tcomp+=parseFloat(exp),num_percis));
      $('#gts').text(_.round((gtotal.sfcbth>0)?((gtotal.tcomp/gtotal.sfcbth)*100):0,num_percis));
      $('#gglowth').text(_.round(((gtotal.sfcbth-gtotal.avgbth)/gtotal.avgbth)*100,num_percis));
      $('#caltotalexp_sfcp').text(_.round((gtotal.sfcbth>0)?((exp/gtotal.sfcbth)*100):0,num_percis));
      if (item.length<1) {
        $('#gavgpcs,#gavgbth,#gsfcpcs,#gsfcbth,#gglowth,#gtcomp,#gts').text(0);
      }
      gtotal={avgpcs:0,avgbth:0,sfcpcs:0,sfcbth:0,glowth:0,tcomp:0,ts:0};
    });
    $('.expen').on('keyup', function(event) {
      $('#gtcomp').trigger('cal');
      $('#gavgpcs').trigger('cal');
    });
    $('#mainform').on('reset', function(event) {
      mf.reset();
      t1.rows('tr').remove().draw();
      t2.rows('tr').remove().draw();
      $('#customer').val(null).trigger('change');
    });
    $('#tableall').on('submit', function(event) {
      event.preventDefault();
    });
    inputmask().mask($('#tableall input'));
    var validate=$('#tableall').parsley().on('form:success', function(event) {
      $('textarea[name=item]').empty();
      var row=t1.rows()[0].length;
      item.push({id:row,code:$('#productcode').val(),uom:(total.state===0)?total.uom:total.uom2,pro:$('#promotion').val(),
      cost:total.cost,normal:total.normal,prop:$('#prop').val(),etc_pro:$('input[name=etc_pro]').val(),disc:total.discount,avgpcs:$('#avgpcs').val(),avgpp:total.avgs,
      sfcp:$('#salesf').val(),sfcpp:total.sfc,grow:total.growth,comp:total.comp,est:$('#est').val(),tcomp:total.tcomp,ts:total.ts,tn:total.tn,remark:$('#remarkitm').val()});
      $('textarea[name=item]').val(JSON.stringify(item));
      t1.row.add(["<input type='checkbox' name='select' class='selected' value='"+row+"'/>",$('#productcode').val(),total.name,(total.state===0)?total.uom:total.uom2,
      ($('#promotion').val()==1)?$('input[name=etc_pro]').val():$("#promotion option[value="+$('#promotion').val()+"]").text(),total.cost,total.normal,$('#prop').val(),total.discount,$('#avgpcs').val(),total.avgs,$('#salesf').val(),total.sfc,total.growth]).draw();
      t2.row.add(["<i id='t2del"+row+"'>-></i>",total.comp,$('#est').val(),total.tcomp,total.ts,total.tn,$('#remarkitm').val()]).draw();
      t1.columns.adjust().draw();
      t2.columns.adjust().draw();
      $('#gavgpcs').trigger('cal');
      $('#tableall').trigger('clear');
    });
    $('.delete').on('click', function(event) {
      $('.selected:checked').each(function(index, el) {
        var id=$(el).val();
        t2.row($("#t2del"+id).parentsUntil('tr')).remove().draw();
        t1.row($(el).parentsUntil('tr')).remove().draw();
        item=_.remove(item,function(data){
          return data.id!=id;
        });
        $('textarea[name=item]').val(JSON.stringify(item));
      });
      $('input[name=selectall]').prop('checked', false);
      t1.columns.adjust().draw();
      t2.columns.adjust().draw();
      $('#gavgpcs').trigger('cal');
    });
    $('input[name=selectall]').on('change', function(event) {
      if ($(this).prop('checked')) {
      $('.selected').prop('checked', true);
    }else {
      $('.selected').prop('checked',false);
    }
    });
    $('#prop').on('cal',function(event,data){
      var prop=parseFloat(data);
      if(total.normal>0&&prop>0){
        total.discount=_.round(((total.normal-prop)/total.normal)*100,num_percis);
        $('#disc').text(total.discount);
      }else{
        total.discount=0;
        $('#disc').text(0);
      }
    });
    $('#avgpcs').on('cal',function(event,data) {
      var avg=parseFloat(data);
      if(total.cost>0&&avg>0){
        total.avgs=_.round(total.cost*avg,num_percis);
        $('#avgsm').text(total.avgs);
      }else{
        total.avgs=0;
        $('#avgsm').text(0);
      }
    });
    $('#salesf').on('cal',function(event,data) {
      var saf=parseFloat(data);
      if(total.cost>0&&saf>0){
        total.sfc=_.round(total.cost*saf,num_percis);
        $('#sfm').text(total.sfc);
      }else{
        total.sfc=0;
        $('#sfm').text(0);
      }
    });
    $('#grow').on('cal', function(event) {
      if(total.sfc>0&&total.avgs>0){
        total.growth=_.round(((total.sfc-total.avgs)/total.avgs)*100,num_percis);
        $('#grow').text(total.growth);
      }else {
        total.growth=0;
        $('#grow').text(0);
      }
    });
    $('#comp').on('cal', function(event) {
      var prop=parseFloat($('#prop').val());
      if (total.normal>0&&prop>0) {
        total.comp=_.round(total.normal-prop,num_percis);
      $('#comp').text(total.comp);
      }else {
        total.comp=0;
        $('#comp').text(0);
      }
    });
    $('#tos').on('cal', function(event) {
      if (total.sfc>0&&total.tcomp>0) {
        total.ts=_.round((total.tcomp/total.sfc)*100,num_percis);
        $('#tos').text(total.ts);
      }else {
        total.ts=0;
        $('#tos').text(0);
      }
    });
    $('#est').on('cal', function(event,data) {
      var est=parseFloat(data);
      if (total.comp>0&&est>0) {
        total.tcomp=_.round(total.comp*est,num_percis);
        $('#tcomp').text(total.tcomp);
      }else {
        total.tcomp=0;
        $('#tcomp').text(0);
      }
    });
    $('#tnr').on('cal', function(event) {
      if (total.cost>0&&total.comp>0) {
        total.tn=_.round(total.cost-total.comp,num_percis);
        $('#tnr').text(total.tn);
      }else {
        total.tn=0;
        $('#tnr').text(0);
      }
    });
    $('#tnr').on('all', function(event) {
      $('#prop').trigger('cal',$('#prop').val());
      $('#avgpcs').trigger('cal',$('#avgpcs').val());
      $('#salesf').trigger('cal',$('#salesf').val());
      $('#grow').trigger('cal');
      $('#comp').trigger('cal');
      $('#est').trigger('cal',$('#est').val());
      $('#tos').trigger('cal');
      $('#tnr').trigger('cal');
      $('#norp').text(total.normal);
    });
    $('#productcode').select2({
       placeholder:'Select Product',
       ajax: {
         url: function (params) {
           return '../searchitem/'+params.term;
         },
   processResults: function (data) {
     return {
       results: data.data
     };
   },data:function(data){
     return {};
   }
 },minimumInputLength: 1,width:'100%'
     });
     $('#promotion').select2({placeholder:'Select Promotion',width:'100%'});
     $('#promotion').on('select2:select', function(event) {
       if (event.target.value==1) {
        $('#etc_pro').collapse('show');
        $('#etc_pro input').prop('required', true);
      }else {
        $('#etc_pro').collapse('hide');
        $('#etc_pro input').prop('required', false);
      }
     });
     $('#productcode').on('select2:select',function(event){
       $('#normalpr').val(0);
      $.get('../getitemdetail/'+cust.val()+'/'+event.target.value).done(function(data){
        var cost=0,prop=$('#prop').val();
        total.normal=(parseFloat($('#normalpr').val())>0)?_.round(parseFloat($('#normalpr').val()),num_percis):_.round(data.data.normal,num_percis);
        total.cost=_.round(data.data.cost,num_percis);
        $('#coste').text(total.cost);
        $('#norp').text(total.normal);
        $('.uom').text(data.data.uom2);
        total.uom=data.data.uom;
        total.uom2=data.data.uom2;
        total.conv=data.data.conv;
        total.name=data.data.name;
        $('#normalpr').val(total.normal);
        $('#tnr').trigger('all');
      }).fail(function(){
        console.error("Error Ajax");
      });
  });
  $('#prop').on('keyup',function(event){
  $('#tnr').trigger('all');
  });
  $('#avgpcs').on('keyup', function(event) {
    $('#tnr').trigger('all');
  });
  $('#salesf').on('keyup', function(event) {
    $('#tnr').trigger('all');
  });
  $('#est').on('keyup', function(event) {
    $('#tnr').trigger('all');
  });
  $('#normalpr').on('keyup', function(event) {
    total.normal=(parseFloat(event.target.value)>0)?_.round(parseFloat(event.target.value),num_percis):0;
    $('#tnr').trigger('all');
  });
  $('.convet').on('click', function(event) {
    if ($('#productcode').val().length==0) {
      return false;
    }
    var avgpcs=parseFloat($('#avgpcs').val()),salesf=parseFloat($('#salesf').val()),est=parseFloat($('#est').val());
    if (total.state===0) {
      $('.uom').text(total.uom2);
      /*$('#avgpcs').val(parseInt((avgpcs>0)?avgpcs*total.conv:0));
      $('#salesf').val(parseInt((salesf>0)?salesf*total.conv:0));
      $('#est').val(parseInt((est>0)?est*total.conv:0));
      if (total.conv>0) {
        total.cost=_.round(total.cost/total.conv,num_percis);
        total.normal=_.round(total.normal/total.conv,num_percis);
        $('#tnr').trigger('all');
        $('#coste').text(total.cost);
        $('#norp').text(total.normal);
      }*/
      total.state=1;
    }else {
      $('.uom').text(total.uom);
      /*$('#avgpcs').val(parseInt((avgpcs>0)?avgpcs/total.conv:0));
      $('#salesf').val(parseInt((salesf>0)?salesf/total.conv:0));
      $('#est').val(parseInt((est>0)?est/total.conv:0));
      if (total.conv>0) {
        total.cost=_.round(total.cost*total.conv,num_percis);
        total.normal=_.round(total.normal*total.conv,num_percis);
        $('#tnr').trigger('all');
        $('#coste').text(total.cost);
        $('#norp').text(total.normal);
      }*/
      total.state=0;
    }
  });
  $('.btnmainf').on('click', function(event) {
    swal({
  title: 'Are you sure?',
  text: "You Want To Submit Request For Approve",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes to submit'
}).then((result) => {
  if (result.value) {
    $('#mainform').trigger('submit');
  }
});
  });
  $('#tableall').on('clear', function(event) {
    validate.reset();
    $('#productcode,#promotion').val(null).trigger('change');
    $('#tableall').trigger('reset');
    total={cost:0,normal:0,prop:0,discount:0,avgs:0,sfc:0,growth:0,comp:0,tcomp:0,ts:0,tn:0,uom:null,uom2:null,conv:0,state:1,name:null};
    $('#tnr').trigger('all');
    $('#coste').text(0);
    $('#norp').text(0);
    $('.uom').text('ชิ้น');
    $('#normalpr').val(0);
    $('#addmodel').modal('hide');
  });
});
@endsection
