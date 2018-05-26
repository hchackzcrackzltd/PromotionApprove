@inject('emdb', App\Model\Masterdata\Employee)
@extends('template.blank')

@section('title_page','Approvel')

@section('card_title')
  <h5><i class="fa fa-check"></i> Approvel</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('approvelmt.index'),'Approvel','active']]])
  @endcomponent
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="btn-group" role="group" aria-label="Basic example">
        <a class="btn btn-success" data-toggle="tooltip" title="Add User" href="{{route('approvelmt.create')}}"><i class="fa fa-plus"></i> Add</a>
      </div><br><br>
    </div>
    <div class="col-12">
      @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
        @slot('thead')
          <tr class="table-info">
            <th>List</th>
            <th>Status</th>
            <th>CreateBy</th>
            <th>UpdateBy</th>
            <th>Menu</th>
          </tr>
        @endslot
        @foreach ($data as $value)
          <tr>
            <td>{{$value->name}}</td><td>{{($value->inactive)?'Inactive':'Active'}}</td>
            <td>{{Adldap::search()->where('sAMAccountName',$value->createby)->get()[0]->cn[0]}}</td>
            <td>{{($value->updateby)?Adldap::search()->where('sAMAccountName',$value->updateby)->get()[0]->cn[0]:null}}</td>
            <td>
              <form action="{{route('approvelmt.destroy',['approvelmt'=>$value->id])}}" method="post" name="delete{{$loop->index}}" id="delete{{$loop->index}}">{{csrf_field()}}{{method_field('DELETE')}}</form>
              <div class="btn-group" role="group" aria-label="Basic example">
                <a class="btn btn-warning" title="Edit User" href="{{route('approvelmt.edit',['approvelmt'=>$value->id])}}" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                <button type="submit" class="btn btn-danger" title="Delete User" data-toggle="tooltip" form="delete{{$loop->index}}"><i class="fa fa-trash"></i></button>
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
