<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Web Terpadu | Pemerintahan Kabupaten Tangerang</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/css/custom9tins.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/iCheck/square/blue.css')}}">

  </head>
  <body class="skin-blue-light hold-transition login-page">
    <div class="login-box">

      <div class="login-logo-custom">
        <div class="logo-custom">
          <img style="float:left;" src="{{asset('images/logo.png')}}" width="50px;"; />
        </div>
        <div class="logo-name-custom">
          <div class="head-logo-name">
            Web Terpadu
          </div>
          <div>
            Pemerintahan Kabupaten Tangerang
          </div>
        </div>
      </div>
      <br>
      <div class="login-box-body">
        <p class="login-box-msg">Silahkan lakukan proses login</p>
        <form action="{{route('login')}}" method="post">
          {!! csrf_field() !!}
          <div class="form-group has-feedback">
            <input name="email" type="text" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
