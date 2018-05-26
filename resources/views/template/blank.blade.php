<!DOCTYPE html>
<html lang="{{config('app.locale')}}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>{{config('app.name')}} - @yield('title_page')</title>
  <!-- Bootstrap core CSS-->
  <link href="{{asset('css/app.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/datatable.css')}}">
</head>

<body class="waitMe_body fixed-nav sticky-footer bg-dark" id="page-top">
  <div class="waitMe_container working" style="background:#fff">
<div style="background:#000"></div>
</div>
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">{{studly_case(config('app.name'))}}</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        @include('template.menu')
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-user"></i> <small>{{auth()->user()->name}}</small>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <div class="row">
              <div class="col-12 text-center">
                <form action="{{route('logout')}}" method="post">
                  {{csrf_field()}}
                  <button type="submit" class="btn btn-default" title="Logout" data-toggle="tooltip">
                    <i class="fa fa-fw fa-sign-out"></i> Logout
                  </button>
                </form>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      @yield('breadcrumb')
      <div class="row">
        @foreach ($errors->all() as $value)
          <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> {{$value}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
          </div>
        @endforeach
        @if (session()->has('success'))
          <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success</strong> {{session('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
          </div>
        @endif
      </div>
      <div class="card">
        <div class="card-header">
          @yield('card_title')
        </div>
        <div class="card-body">
        @yield('content')
        </div>
      </div>

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © {{config('app.company')}}</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/template.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>
    <script>
      @yield('script')
    </script>
  </div>
</body>

</html>
