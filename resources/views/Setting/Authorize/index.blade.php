@inject('emdb', App\Model\Masterdata\Employee)
@extends('template.blank')

@section('title_page','User')

@section('card_title')
  <h5><i class="fa fa-user"></i> Authorize</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('authorize.index'),'Authorize','active']]])
  @endcomponent
@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="btn-group" role="group" aria-label="Basic example">
        <a class="btn btn-success" data-toggle="tooltip" title="Add User" href="{{route('authorize.create')}}"><i class="fa fa-plus"></i> Add</a>
      </div><br><br>
    </div>
    <div class="col-12">
      @component('component.table',['istfoot'=>0,'table_class'=>'text-center'])
        @slot('thead')
          <tr class="table-info">
            <th>User</th>
            <th>Authorize</th>
            <th>Menu</th>
          </tr>
        @endslot
        @foreach ($data as $value)
          <tr>
            <td>{{$value->username}}</td><td>
              <div class="row">
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <b>Type: </b>{{($value->isadmin)?'Admin':'User'}}
                </div>
                @foreach ($value->authorize as $fn)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <b>{{$function_name[$fn->funct_id]}}: </b>{{($fn->funct_id==0)?$auth2_name[$fn->permit]:$auth_name[$fn->permit]}}
                </div>
                @endforeach
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                @if($sales->where('SlpCode',$emdb::where('code',$value->username)->first()->salecode)->count())
                <b>Sales Code: </b>{{$sales->where('SlpCode',$emdb::where('code',$value->username)->first()->salecode)->first()->SlpName}}
                @else
                <b>Sales Code: </b> No Sales
                @endif
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <b>Approve List: </b>{{$value->approve_list->name}}
                </div>
              </div>
            </td><td>
              <form action="{{route('authorize.destroy',['authorize'=>$value->id])}}" method="post" name="delete{{$loop->index}}" id="delete{{$loop->index}}">{{csrf_field()}}{{method_field('DELETE')}}</form>
              <div class="btn-group" role="group" aria-label="Basic example">
                <a class="btn btn-warning" title="Edit User" href="{{route('authorize.edit',['authorize'=>$value->id])}}" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
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
