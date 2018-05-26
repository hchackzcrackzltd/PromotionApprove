<ol class="breadcrumb">
  @foreach ($item as $value)
    <li class="breadcrumb-item {{$value[2]}}">
      <a href="{{$value[0]}}">{{$value[1]}}</a>
    </li>
  @endforeach
  {{$slot}}
</ol>
