@extends('template.blank')

@section('title_page','Add Authorize')

@section('card_title')
  <h5><i class="fa fa-user"></i> Add Authorize</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('authorize.index'),'Authorize',null],[route('authorize.create'),'Add Authorize','active']]])
  @endcomponent
@endsection
@section('content')
  <form action="{{route('authorize.store')}}" method="post">
    {{csrf_field()}}
  @component('component.card')
    @slot('title')
      <i class="fa fa-user"></i> User
    @endslot
    <div class="row">
      <div class="col-12">
          <fieldset class="form-group">
            <label for="user">User</label>
            <select class="form-control" name="username" required>
              @foreach (Adldap::search()->where('userAccountControl',512)->get() as $value)
                <option value="{{$value->samaccountname[0]}}">{{$value->samaccountname[0]}} - {{$value->cn[0]}}</option>
              @endforeach
            </select>
          </fieldset>
      </div>
      <div class="col-12">
          <fieldset class="form-group">
            <label for="type">Type</label>
            <select class="form-control" name="type" required>
              <option value="0">User</option>
              <option value="1">Admin</option>
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
                <option value="{{$value->SlpCode}}">{{$value->SlpName}}</option>
              @endforeach
            </select>
          </fieldset>
      </div>
      <div class="col-12">
          <fieldset class="form-group">
            <label for="applist">Approve List</label>
            <select class="form-control" name="apvlist" required>
              @foreach ($applist as $value)
                <option value="{{$value->id}}">{{$value->name}}</option>
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
          <input type="radio" id="pro0" name="role[0]" value="0" checked> View Only
        </label>
        <label class="checkbox-inline">
          <input type="radio" id="pro1" name="role[0]" value="1"> Full Authorize
        </label>
      </div>
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <b>Approve: </b>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox1" name="role[1]" value="0" checked> No Authorize
        </label>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox2" name="role[1]" value="1"> Full Authorize
        </label>
      </div>
      <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <b>Setting: </b>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox1" name="role[2]" value="0" checked> No Authorize
        </label>
        <label class="checkbox-inline">
          <input type="radio" id="inlineCheckbox2" name="role[2]" value="1"> Full Authorize
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
