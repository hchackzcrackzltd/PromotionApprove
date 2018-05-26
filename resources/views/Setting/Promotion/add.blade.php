@extends('template.blank')

@section('title_page','Add Promotion')

@section('card_title')
  <h5><i class="fa fa-tags"></i> Add Promotion</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('promotionmt.index'),'Promotion',null],[route('promotionmt.create'),'Add Promotion','active']]])
  @endcomponent
@endsection
@section('content')
  <form action="{{route('promotionmt.store')}}" method="post">
    {{csrf_field()}}
  @component('component.card')
    @slot('title')
      <i class="fa fa-tag"></i> Promotion
    @endslot
    <div class="row">
      <div class="col-12">
          <fieldset class="form-group">
            <label for="promotion">Promotion</label>
            <input type="text" class="form-control" id="Promotion" name="promotion" placeholder="Please Insert Promotion" required>
          </fieldset>
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
