@extends('template.blank')

@section('title_page','Add Expense')

@section('card_title')
  <h5><i class="fa fa-money"></i> Add Expense</h5>
@endsection

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[['#','Setting',null],[route('expense.index'),'Expense',null],[route('expense.create'),'Add Expense','active']]])
  @endcomponent
@endsection
@section('content')
  <form action="{{route('expense.store')}}" method="post">
    {{csrf_field()}}
  @component('component.card')
    @slot('title')
      <i class="fa fa-money"></i> Expense
    @endslot
    <div class="row">
      <div class="col-12">
          <fieldset class="form-group">
            <label for="express">Expense</label>
            <input type="text" class="form-control" id="express" name="express" placeholder="Please Insert Expense" required>
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
