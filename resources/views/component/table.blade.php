<div class="table-responsive">
  <table class="table table-straped {{$table_class}}">
    <thead>
      {{$thead}}
    </thead>
    <tbody>
      {{$slot}}
    </tbody>
    @if ($istfoot)
      <tfoot>
        {{$tfoot}}
      </tfoot>
      @endif
    </table>
</div>
