@extends('template.blank')

@section('title_page','Expense')

@section('card_title')
  <h5><i class="fa fa-money"></i> Expense</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('expense.index'),'Expense','active']]])
  @endcomponent
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="btn-group" role="group" aria-label="Basic example">
        <a class="btn btn-success" data-toggle="tooltip" title="Add Express" href="{{route('expense.create')}}"><i class="fa fa-plus"></i> Add</a>
      </div><br><br>
    </div>
    <div class="col-12">
      @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
        @slot('thead')
          <tr class="table-info">
            <th>Expense</th>
            <th>Inactive</th>
            <th>CreateBy</th>
            <th>UpdateBy</th>
            <th>Menu</th>
          </tr>
        @endslot
        @foreach ($data as $value)
          <tr>
            <td>{{$value->name}}</td>
            <td>{{($value->inactive)?'Inactive':'Active'}}</td>
            <td>{{Adldap::search()->where('sAMAccountName',$value->createby)->get()[0]->cn[0]}}</td>
            <td>{{($value->updateby)?Adldap::search()->where('sAMAccountName',$value->updateby)->get()[0]->cn[0]:null}}</td>
            <td>
              <form action="{{route('expense.destroy',['expense'=>$value->id])}}" method="post" name="delete{{$loop->index}}" id="delete{{$loop->index}}">{{csrf_field()}}{{method_field('DELETE')}}</form>
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="submit" class="btn {{($value->inactive)?'btn-success':'btn-warning'}}" title="{{($value->inactive)?'Active':'Inactive'}}" data-toggle="tooltip" form="delete{{$loop->index}}"><i class="fa {{($value->inactive)?'fa-check':'fa-ban'}}"></i></button>
              </div>
            </td>
          </tr>
        @endforeach
      @endcomponent
    </div>
  </div>
@endsection

@section('script')
  $('table').DataTable();
@endsection
