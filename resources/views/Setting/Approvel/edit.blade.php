@extends('template.blank')

@section('title_page','Add Approvel')

@section('card_title')
  <h5><i class="fa fa-check"></i> Edit Approvel</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('approvelmt.index'),'Approvel',null],[route('approvelmt.edit',['approvelmt'=>$data->id]),'Edit Approval','active']]])
  @endcomponent
@endsection
@section('content')
  <form action="{{route('approvelmt.update',['approvelmt'=>$data->id])}}" method="post" id="mainform">
    {{csrf_field()}}
    {{method_field('PATCH')}}
  @component('component.card')
    @slot('title')
      <i class="fa fa-user"></i> User
    @endslot
    <div class="row">
      <div class="col-12">
          <fieldset class="form-group">
            <label for="user">User</label>
            <select class="form-control" name="username">
              @foreach (Adldap::search()->where('userAccountControl',512)->get() as $value)
                <option value="{{$value->samaccountname[0]}}">{{$value->samaccountname[0]}} - {{$value->cn[0]}}</option>
              @endforeach
            </select>
          </fieldset>
      </div>
      <div class="col-12">
          <fieldset class="form-group">
            <label for="user">Sequence</label>
            <input type="text" class="form-control" name="seq" placeholder="Approve Sequence" data-inputmask="'alias':'decimal'">
          </fieldset>
      </div>
      <div class="col-12 text-right">
        <div class="btn-group">
          <button type="button" class="btn btn-default adduser"><i class="fa fa-plus"></i> Add</button>
        </div>
      </div>
    </div>
  @endcomponent
  @component('component.card')
    @slot('title')
      <i class="fa fa-check"></i> Approval
    @endslot
    <div class="row">
      <div class="col-12">
        <fieldset class="form-group">
          <label for="list_name">List Name</label>
          <input type="text" class="form-control" name="list_name" placeholder="List Name" value="{{$data->name}}" readonly>
        </fieldset>
      </div>
      <div class="col-12">
          @component('component.table',['istfoot'=>0,'table_class'=>'text-center t1'])
            @slot('thead')
              <tr class="table-info">
                <th>UserName</th><th>Sequence</th><th>Action</th>
              </tr>
            @endslot
              @foreach ($data->approve1->sortBy('seq') as $key => $value)
                <tr>
                  <td>{{$value->user_id}}</td><td>{{$value->seq}}</td><td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger delete" data-line='{{$value->line}}' title="Delete">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
          @endcomponent
      </div>
    </div>
  @endcomponent
  <textarea name="userall" class="d-none" required>{{$data->approve1->sortBy('seq')}}</textarea>
  <br>
  <div class="col-12 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="reset" class="btn btn-default" title="Reset" data-toggle="tooltip"><i class="fa fa-repeat"></i> Reset</button>
      <button type="submit" class="btn btn-success" title="Save" data-toggle="tooltip"><i class="fa fa-save"></i> Save</button>
    </div>
  </div>
  </form>
  <div class="d-none btnact">
    <div class="btn-group">
      <button type="button" class="btn btn-danger delete" title="Delete">
        <i class="fa fa-trash"></i>
      </button>
    </div>
  </div>
@endsection

@section('script')
  $(function(){
    var item=JSON.parse($('textarea[name=userall]').val());
    $('textarea[name=userall]').empty();
    $('select[name=username]').select2();
    var t1=$('.t1').DataTable();
    inputmask().mask($('input[name=seq]'));
    $('.adduser').on('click', function(event) {
      if ($('input[name=seq]').val()=='') {
        swal('WARNING','Please Insert Sequence','warning');
        return false;
      }
      $('.btnact').find('.delete').attr('data-line', item.length);
      t1.row.add([$('select[name=username]').val(),$('input[name=seq]').val(),$('.btnact').html()]).draw();
      item[item.length]={user_id:$('select[name=username]').val(),seq:$('input[name=seq]').val(),line:item.length};
      $('textarea[name=userall]').text(JSON.stringify(item));
      $('input[name=seq]').val(null);
    });
    $('.t1').on('click', '.delete', function(event) {
      var id=$(this).attr('data-line'),temp=[];
      $.each(item,function(index,data){
        if(data.line!=id){
        temp[temp.length]=data;
        }
      });
      item=temp;
      $('textarea[name=userall]').text(JSON.stringify(item));
      t1.row($(this).parentsUntil('tr')).remove().draw();
    });
  });
@endsection
