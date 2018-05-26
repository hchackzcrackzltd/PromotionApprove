<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
  <a class="nav-link" href="{{route('Dashboard')}}">
    <i class="fa fa-address-book"></i>
    <span class="nav-link-text">Dashboard</span>
  </a>
</li>
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Promotion Form">
  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsePromotion" data-parent="#exampleAccordion">
    <i class="fa fa-fw fa-file"></i>
    <span class="nav-link-text">Promotion</span>
  </a>
  <ul class="sidenav-second-level collapse" id="collapsePromotion">
    @can ('promotionview', auth()->user()->Authorize_Main()->first())
    <li>
      <a href="{{route('promotion.index')}}"><i class="fa fa-tasks"></i> Status</a>
    </li>
    @endcan
    @can ('promotion', auth()->user()->Authorize_Main()->first())
    <li>
      <a href="{{route('promotion.create')}}"><i class="fa fa-file"></i> Request</a>
    </li>
    @endcan
  </ul>
</li>
@can ('approve', auth()->user()->Authorize_Main()->first())
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
  <a class="nav-link" href="{{route('approve.index')}}">
    <i class="fa fa-fw fa-check"></i>
    <span class="nav-link-text">Approve</span>
  </a>
</li>
@endcan
@can ('setting', auth()->user()->Authorize_Main()->first())
<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Setting">
  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseSetting" data-parent="#exampleAccordion">
    <i class="fa fa-fw fa-wrench"></i>
    <span class="nav-link-text">Setting</span>
  </a>
  <ul class="sidenav-second-level collapse" id="collapseSetting">
    <li>
      <a href="{{route('promotionmt.index')}}"><i class="fa fa-tag"></i> Promotion</a>
    </li>
    <li>
      <a href="{{route('expense.index')}}"><i class="fa fa-money"></i> Expense</a>
    </li>
    <li>
      <a href="{{route('approvelmt.index')}}"><i class="fa fa-users"></i> Approvel</a>
    </li>
    <li>
      <a href="{{route('authorize.index')}}"><i class="fa fa-user"></i> Authorize</a>
    </li>
  </ul>
</li>
@endcan
