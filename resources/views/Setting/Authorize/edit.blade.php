@inject('employee', 'App\Model\Masterdata\Employee')
@extends('template.blank')

@section('title_page','Edit Authorize')

@section('card_title')
  <h5><i class="fa fa-user"></i> Edit Authorize</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('authorize.index'),'Authorize',null],[route('authorize.edit',['authorize'=>$data->id]),'Edit Authorize','active']]])
  @endcomponent
@endsection
@section('content')
  <form action="{{route('authorize.update',['authorize'=>$data->id])}}" method="post">
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
            <input type="text" class="form-control" value="{{$data->username}} - {{Adldap::search()->where('samaccountname',$data->username)->get()[0]->cn[0]}}" readonly>
          </fieldset>
      </div>
      <div class="col-12">
          <fieldset class="form-group">
            <label for="type">Type</label>
            <select class="form-control" name="type" required>
              <option value="0" {{($data->isadmin==0)?'selected':null}}>User</option>
              <option value="1" {{($data->isadmin)?'selected':null}}>Admin</option>
            </select>
          </fieldset>
      </div>
    </div>
  @endcomponent
  @component('component.card')
    @slot('title')
      <i class="fa fa-tag"></i> Sales & Approve List
    @endslot
    <div class="row">
      <div class="col-12">
          <fieldset class="form-group">
            <label for="user">Sales Code</label>
            <select class="form-control" name="salescode" required>
              @foreach ($sales as $value)
                <option value="{{$value->SlpCode}}" {{($employee::find($data->username)->salecode==$value->SlpCode)?'selected':null}}>{{$value->SlpName}}</option>
              @endforeach
            </select>
          </fieldset>
      </div>
      <div class="col-12">
          <fieldset class="form-group">
            <label for="applist">Approve List</label>
            <select class="form-control" name="apvlist" required>
              @foreach ($applist as $value)
                <option value="{{$value->id}}" {{($data->approve_id==$value->id)?'selected':null}}>{{$value->name}}</option>
              @endforeach
            </select>
          </fieldset>
      </div>
    </div>
  @endcomponent
  @component('component.card')
    @slot('title')
      <i class="fa fa-list"></i> Menu
    @endslot
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <b>Promotion: </b>
        <label class="checkbox-inline">
          <input type="radio" id="pro0" name="role[0]" value="0" {{($data->authorize->where('funct_id',0)->first()->permit==0)?'checked':null}}> View Only
        </label>
        <label class="checkbox-inline">
          <input type="radio" id="pro1" name="role[0]" value="1" {{($data->authorize->where('funct_id',0)->first()->permit==1)?'checked':null}}> Full Authorize
        </label>
      </div>
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <b>Approve: </b>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox1" name="role[1]" value="0" {{($data->authorize->where('funct_id',1)->first()->permit==0)?'checked':null}}> No Authorize
        </label>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox2" name="role[1]" value="1" {{($data->authorize->where('funct_id',1)->first()->permit==1)?'checked':null}}> Full Authorize
        </label>
      </div>
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <b>Setting: </b>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox1" name="role[2]" value="0" {{($data->authorize->where('funct_id',2)->first()->permit==0)?'checked':null}}> No Authorize
        </label>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox2" name="role[2]" value="1" {{($data->authorize->where('funct_id',2)->first()->permit==1)?'checked':null}}> Full Authorize
        </label>
      </div>
    </div>
  @endcomponent
  <br>
  <div class="col-12 text-right">
    <div class="btn-group" role="group" aria-label="Basic example">
      <button type="reset" class="btn btn-default" title="Reset" data-toggle="tooltip"><i class="fa fa-repeat"></i> Reset</button>
      <button type="submit" class="btn btn-success" title="Save" data-toggle="tooltip"><i class="fa fa-save"></i> Save</button>
    </div>
  </div>
  </form>
@endsection

@section('script')
  $('select[name=username]').select2();
@endsection
