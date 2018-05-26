<nav>
<div class="nav nav-tabs" id="{{$id}}" role="tablist">
  @foreach ($nav as $value)
    <a class="nav-item nav-link {{($value[0])?'active':null}}" id="nav-{{$value[1]}}" data-toggle="tab" href="#tab_{{$value[1]}}" role="tab" aria-controls="nav-{{$value[1]}}">
      <i class="fa fa-{{$value[2]}}"></i> <b>{{$value[3]}}</b>
    </a>
  @endforeach
</div>
</nav>
<div class="tab-content" id="nav-tabContent">
  {{$slot}}
</div>
