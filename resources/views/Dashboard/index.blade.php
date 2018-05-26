@extends('template.blank')

@section('title_page','Dashboard')

@section('breadcrumb')
  @component('component.breadcrumb',['item'=>[[route('Dashboard'),'Dashboard','active']]])
  @endcomponent
@endsection

@section('content')
  <div class="col text-center">
    <h3 class="text-danger">Comming Soon</h3>
  </div>
@endsection
