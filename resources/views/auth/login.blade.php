<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>{{config('app.name')}} - Login</title>
  <!-- Bootstrap core CSS-->
  <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">

    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="{{route('login')}}" method="post">
          @csrf
          <div class="form-group">
            <label for="exampleInputEmail1">ID Employee</label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter ID Employee" name="username" value="{{old('username')}}">
            @if ($errors->has('username'))
              <div class="invalid-feedback" style="display:grid">
                Employee ID Incorrect
              </div>
            @endif
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password" name="password">
            @if ($errors->has('password'))
              <div class="invalid-feedback" style="display:grid">
                Password Incorrect
              </div>
            @endif
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" name="remember" type="checkbox" {{old('remember')?'checked':null}}> Remember Password</label>
            </div>
          </div>
          <div class="btn-group-vertical col-12">
            <button type="submit" title="Login to system" class="btn btn-primary btn-block" data-toggle='tooltip'>
              <i class="fa fa-sign-in"></i> Login
            </button>
            <button type="reset" title="Reset" class="btn btn-default btn-block" data-toggle='tooltip'>
              <i class="fa fa-repeat"></i> Reset
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="{{asset('js/bootstrap.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>
</body>

</html>
