@extends('template.blank')

@section('title_page','Approve')

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[[route('Dashboard'),'Dashboard',null],[route('approve.index'),'Approve','active']]])
  @endcomponent
@endsection

@section('card_title')
<h5><i class="fa fa-check"></i> Approve</h5>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      @component('component.card')
        @slot('title')
          <i class="fa fa-search"></i> Request Wait For Approve
        @endslot
        @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
          @slot('thead')
            <tr class="text-center table-warning">
              <th>Date</th>
              <th>Customer Group</th>
              <th>Customer</th>
              <th>Promotion</th>
              <th>Period</th>
              <th>Menu</th>
            </tr>
          @endslot
          @foreach ($datareq->where('status',1) as $value)
            @if ($value->pro->status<>'CN')
            <tr>
              <td>{{$value->pro->created_at}}</td><td>{{$value->pro->account_group}}</td>
              <td>
                @foreach (json_decode($value->pro->account_id) as $cusin)
                  @if ($cusin<>'*')
                    @php
                      $cusay=explode(',',$cusin);
                    @endphp
                    {{$customer->where('cardcode2',$cusay[0])->where('company',$cusay[1])->first()->cardname}}<br>
                  @else
                    All Branch
                  @endif
                @endforeach
              </td>
              <td>
                @foreach ($value->pro->Pro2->groupBy('pro') as $key => $value2)
                  <p>{{$key}}</p>
                @endforeach
              </td><td>{{$value->pro->str_date}}-{{$value->pro->end_date}}</td>
              <td>
                <form action="{{route('approve.update',['approve'=>$value->pro->id])}}" method="post" id="approve_req_{{$value->pro->id}}">{{csrf_field()}}{{method_field('PATCH')}}</form>
                <div class="btn-group" role="group" aria-label="Menu">
                <button type="button" class="btn btn-primary shdt" data-id="{{$value->pro->id}}" title="See More Detail" data-toggle="modal" data-target="#detail"><i class="fa fa-search"></i></button>
                <button type="submit" class="btn btn-success" title="Approve Request" data-toggle="tooltip" form="approve_req_{{$value->pro->id}}"><i class="fa fa-check"></i></button>
                <button type="button" class="btn btn-danger cnbtn" title="Cancle" data-link="{{route('approve.destroy',['approve'=>$value->pro->id])}}" data-toggle="modal" data-target="#cnmodal"><i class="fa fa-ban"></i></button>
              </div></td>
            </tr>
            @endif
          @endforeach
        @endcomponent
      @endcomponent
    </div>
    <div class="col-12">
      @component('component.card')
        @slot('title')
          <i class="fa fa-check"></i> Request Approved
        @endslot
        @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
          @slot('thead')
            <tr class="text-center table-success">
              <th>Date</th>
              <th>Customer Group</th>
              <th>Customer</th>
              <th>Promotion</th>
              <th>Period</th>
              <th>Menu</th>
            </tr>
          @endslot
          @foreach ($datareq->whereIn('status', [2,3]) as $value)
            @if ($value->pro->status<>'CN')
            <tr>
              <td>{{$value->pro->created_at}}</td><td>{{$value->pro->account_group}}</td>
              <td>
                @foreach (json_decode($value->pro->account_id) as $cusin)
                  @if ($cusin<>'*')
                    @php
                      $cusay=explode(',',$cusin);
                    @endphp
                    {{$customer->where('cardcode2',$cusay[0])->where('company',$cusay[1])->first()->cardname}}<br>
                  @else
                    All Branch
                  @endif
                @endforeach
              </td>
              <td>
                @foreach ($value->pro->Pro2->groupBy('pro') as $key => $value2)
                  <p>{{$key}}</p>
                @endforeach
              </td><td>{{$value->pro->str_date}}-{{$value->pro->end_date}}</td>
              <td>
                <button type="button" class="btn btn-primary shdt" data-id="{{$value->pro->id}}" title="See More Detail" data-toggle="modal" data-target="#detail"><i class="fa fa-search"></i></button>
              </div></td>
            </tr>
          @endif
          @endforeach
        @endcomponent
      @endcomponent
      @component('component.model',['id'=>'detail','footer'=>null])
        @slot('title')
          <i class="fa fa-search"></i> Detail Request
        @endslot
        <div class="con_detail"><div style="height:443px"></div></div>
      @endcomponent
      @component('component.model',['id'=>'cnmodal','footer'=>null])
        @slot('title')
          <i class="fa fa-comments"></i> Reason for reject
        @endslot
        <form id="fncn" action="" method="post">
          {{csrf_field()}}
          {{method_field('DELETE')}}
          <div class="row">
            <div class="col-12">
              <fieldset class="form-group">
                <label for="rea">Reason:</label>
                <textarea name="cnreason" class="form-control" id="rea" placeholder="Reason for reject"></textarea>
              </fieldset>
            </div>
            <div class="col-12 text-right">
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="reset" class="btn btn-default" title="Reset Form" data-toggle='tooltip'><i class="fa fa-repeat"></i> Reset</button>
                <button type="submit" class="btn btn-danger" title="Reject This Request" data-toggle='tooltip'><i class="fa fa-ban"></i> Reject</button>
              </div>
            </div>
          </div>
        </form>
      @endcomponent
    </div>
  </div>
@endsection

@section('script')
  var wtconf={
effect : 'facebook',
text : 'Wait A Minune',
bg : 'rgba(255,255,255,0.7)',
color : '#000',
textPos : 'vertical'
}
  $('.table').DataTable();
  $('.shdt').on('click', function(event) {
    $('.con_detail').waitMe(wtconf);
    $.get('promotion/'+$(this).attr('data-id')).done(function(data) {
      $('.con_detail').html(data);
      $('.con_detail').waitMe('hide');
    }).fail(function() {
      console.log('Error Ajax');
    });
  });
  $('.cnbtn').on('click', function(event) {
    $('#fncn').attr('action', $(this).attr('data-link'));
  });
@endsection
