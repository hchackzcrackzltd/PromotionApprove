@extends('template.blank')

@section('title_page','Promotion Approval Status')

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[[route('Dashboard'),'Dashboard',null],[route('promotion.index'),'Promotion Status','active']]])
  @endcomponent
@endsection

@section('card_title')
<h5><i class="fa fa-tasks"></i> Request Status</h5>
@endsection

@section('content')
  @component('component.card')
    @slot('title')
      <i class="fa fa-certificate"></i> New Request
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
      @foreach ($datareq->where('status', 'NQ') as $value)
        <tr>
          <td>{{$value->created_at}}</td><td>{{$value->account_group}}</td>
          <td>
            @foreach (json_decode($value->account_id) as $cusin)
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
            @foreach ($value->Pro2->groupBy('pro') as $key => $value2)
              <p>{{$key}}</p>
            @endforeach
          </td><td>{{$value->str_date}}-{{$value->end_date}}</td>
          <td><form action="{{route('promotion.destroy',['promotion'=>$value->id])}}" method="post" name="cancel{{$loop->index}}" id="cancel{{$loop->index}}">{{method_field('DELETE')}}{{csrf_field()}}</form><div class="btn-group" role="group" aria-label="Menu">
            <button type="button" class="btn btn-primary shdt" data-id="{{$value->id}}" title="See More Detail" data-toggle="modal" data-target="#detail"><i class="fa fa-search"></i></button>
            <a class="btn btn-secondary" title="Duplicate Document" data-toggle="tooltip" href="{{route('promotion.edit',['promotion'=>$value->id])}}"><i class="fa fa-copy"></i></a>
            <button type="submit" class="btn btn-danger" title="Cancle"  data-toggle="tooltip" form="cancel{{$loop->index}}"><i class="fa fa-ban"></i></button>
          </div></td>
        </tr>
      @endforeach
    @endcomponent
  @endcomponent
  <br>
  @component('component.card')
    @slot('title')
      <i class="fa fa-hourglass-half"></i> Approved Request
    @endslot
    @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
      @slot('thead')
        <tr class="text-center table-info">
          <th>Date</th>
          <th>Customer Group</th>
          <th>Customer</th>
          <th>Promotion</th>
          <th>Period</th>
          <th>Menu</th>
        </tr>
      @endslot
      @foreach ($datareq->whereIn('status', ['WP','AC']) as $value)
        <tr>
          <td>{{$value->created_at}}</td><td>{{$value->account_group}}</td>
          <td>
            @foreach (json_decode($value->account_id) as $cusin)
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
            @foreach ($value->Pro2->groupBy('pro') as $key => $value2)
              <p>{{$key}}</p>
            @endforeach
          </td><td>{{$value->str_date}}-{{$value->end_date}}</td>
          <td><div class="btn-group" role="group" aria-label="Menu">
            <button type="button" class="btn btn-primary shdt" data-id="{{$value->id}}" title="See More Detail" data-toggle="modal" data-target="#detail"><i class="fa fa-search"></i></button>
            <a class="btn btn-secondary" title="Duplicate Document" data-toggle="tooltip" href="{{route('promotion.edit',['promotion'=>$value->id])}}"><i class="fa fa-copy"></i></a>
          </div></td>
        </tr>
      @endforeach
    @endcomponent
  @endcomponent
  <br>
  @component('component.card')
    @slot('title')
      <i class="fa fa-check"></i> Complete Request
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
      @foreach ($datareq->where('status', 'SC') as $value)
        <tr>
          <td>{{$value->created_at}}</td><td>{{$value->account_group}}</td>
          <td>
            @foreach (json_decode($value->account_id) as $cusin)
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
            @foreach ($value->Pro2->groupBy('pro') as $key => $value2)
              <p>{{$key}}</p>
            @endforeach
          </td><td>{{$value->str_date}}-{{$value->end_date}}</td>
          <td><div class="btn-group" role="group" aria-label="Menu">
            <button type="button" class="btn btn-primary shdt" data-id="{{$value->id}}" title="See More Detail" data-toggle="modal" data-target="#detail"><i class="fa fa-search"></i></button>
            <a class="btn btn-secondary" title="Duplicate Document" data-toggle="tooltip" href="{{route('promotion.edit',['promotion'=>$value->id])}}"><i class="fa fa-copy"></i></a>
          </div></td>
        </tr>
      @endforeach
    @endcomponent
  @endcomponent
  <br>
  @component('component.card')
    @slot('title')
      <i class="fa fa-ban"></i> Cancel Request
    @endslot
    @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
      @slot('thead')
        <tr class="text-center table-danger">
          <th>Date</th>
          <th>Customer Group</th>
          <th>Customer</th>
          <th>Promotion</th>
          <th>Period</th>
          <th>Menu</th>
        </tr>
      @endslot
      @foreach ($datareq->where('status', 'CN') as $value)
        <tr>
          <td>{{$value->created_at}}</td><td>{{$value->account_group}}</td>
          <td>
            @foreach (json_decode($value->account_id) as $cusin)
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
            @foreach ($value->Pro2->groupBy('pro') as $key => $value2)
              <p>{{$key}}</p>
            @endforeach
          </td><td>{{$value->str_date}}-{{$value->end_date}}</td>
          <td>
            <div class="btn-group" role="group" aria-label="Menu">
              <button type="button" class="btn btn-primary shdt" data-id="{{$value->id}}" title="See More Detail" data-toggle="modal" data-target="#detail"><i class="fa fa-search"></i></button>
              <a class="btn btn-secondary" title="Duplicate Document" data-toggle="tooltip" href="{{route('promotion.edit',['promotion'=>$value->id])}}"><i class="fa fa-copy"></i></a>
          </div></td>
        </tr>
      @endforeach
    @endcomponent
  @endcomponent
  @component('component.model',['id'=>'detail','footer'=>null])
    @slot('title')
      <i class="fa fa-search"></i> Detail Request
    @endslot
    <div class="con_detail"><div style="height:443px"></div></div>
  @endcomponent
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
@endsection
