<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="pixelstrap">
  <link rel="icon" href="{{ URL::asset('bb.png') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ URL::asset('bb.png') }}" type="image/x-icon">
  <title>Nawa Sena Klinik | Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/font-awesome.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/icofont.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/themify.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/flag-icon.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/feather-icon.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/bootstrap.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
  <link id="color" rel="stylesheet" href="{{ URL::asset('css/color-1.css') }}" media="screen">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/responsive.css') }}">
</head>
<body>
  <div class="container-fluid p-0">
    <div class="row">
      <div class="col-12">
        <div class="login-card">
          <form class="theme-form login-form" method="POST" action="{{ url("auth/login") }}" style="border-radius: 20px !important;">
            @csrf
            @include("template.notif")
            <center>
              <h4>PT. Nawasena Loka Gemilang</h4>
              <img src="bb.png" style="width: 25%">
              <hr>
              <h6>Selamat Datang ! Silahkan Masukan Akun Anda</h6>
            </center>
            <div class="form-group">
              <label>Username</label>
              <div class="input-group">
                <span class="input-group-text"><i class="icon-email"></i></span>
                <input class="form-control" type="text" name="username" id="username" required placeholder="masukan username">
              </div>
            </div>
            <div class="form-group">
              <label>Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="icon-lock"></i></span>
                <input class="form-control" id="password" type="password" name="password" placeholder="*********">
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <input id="check" type="checkbox">
                <label for="check">Tampilkan Password</label>
              </div>
              {{-- <a class="link" href="#">
                Lupa Password ?
              </a> --}}
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-block" type="submit">
                <i class="fa fa-send"></i>  Login
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="{{ URL::asset('js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ URL::asset('js/icons/feather-icon/feather-icon.js') }}"></script>
<script src="{{ URL::asset('js/config.js') }}"></script>
<script src="{{ URL::asset('js/script.js') }}"></script>

<script type="text/javascript">
  $(function(){
    $('#check').change(function()
    {
      if($(this).is(':checked')) {
        $("#password").attr("type", "text");
      }else{   
        $("#password").attr("type", "password");
      }
    });
  });
</script>

</html>