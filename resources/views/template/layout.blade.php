@php
$ses_login = Session("role_id");

if($ses_login == 1){
  $level1 = App\Models\Navigations::getMenu(1, $ses_login);
  $level = App\Models\Navigations::getMenu(2, $ses_login);
}else{
  $level1 = App\Models\RolePermition::getMenu(1, $ses_login);
  $level = App\Models\RolePermition::getMenu(2, $ses_login);
  $access_login = App\Models\RolePermition::getAccess(Request::segment(1), $ses_login);
}

$level2 = [];
foreach ($level as $key => $value) {
  $level2[$value->parent_navigation_id][$key] = $value;
}
@endphp

@php
$nav_menu = \App\Models\Navigations::where("uri", Request::segment(1))->get()->first();
@endphp
@section('description', ucfirst($nav_menu->description))
@section('title', ucfirst($nav_menu->name))
@section('icon-title',strtolower($nav_menu->icon))

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
  <title> Nawa Sena Klinik | @yield('title')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/font-awesome.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/icofont.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/themify.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/flag-icon.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/feather-icon.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/scrollbar.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/bootstrap.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
  <link id="color" rel="stylesheet" href="{{ URL::asset('css/color-1.css') }}" media="screen">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/select2.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/responsive.css') }}">
  <style type="text/css">
    .img-custome{
      width: 200px !important;
      height: 70px !important;
    }
    .sidebar-custome{
      padding-top: 1100px !important;
    }
    .text-notif{
      font-size: 12px;
      color: grey;
    }
    .dropdown-item:hover{
      background-color: grey !important;
      color: #FFFF !important;
    }
    .text-theme{
      color: #6610f2 !important;
    }
  </style>
  @yield("style")

  <script src="{{ URL::asset('js/jquery-3.5.1.min.js') }}"></script>
</head>
<body>
  <div class="tap-top">
    <i data-feather="chevrons-up"></i>
  </div>
  
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    @include("template.header")
    <div class="page-body-wrapper">
      <div class="sidebar-wrapper"> 
        <div>
          <div class="logo-wrapper">
            <a href="{{ url('/') }}">
              <img class="img-fluid for-light img-custome" src="{{ URL::asset('cc.png') }}" alt="">
              <img class="img-fluid for-dark img-custome" src="{{ URL::asset('cc.png') }}" alt="">
            </a>
            <div class="back-btn">
              <i class="fa fa-angle-left"></i>
            </div>
          </div>
          <div class="logo-icon-wrapper">
            <a href="{{ url('/') }}">
              <img class="img-fluid" src="{{ URL::asset('cc.png') }}" alt="">
            </a>
          </div>

          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
              <i data-feather="arrow-left"></i>
            </div>
            <div id="sidebar-menu" >
              @include("template.sidebar")
            </div>
            <div class="right-arrow" id="right-arrow">
              <i data-feather="arrow-right"></i>
            </div>
          </nav>
        </div>
      </div>  

      <div class="page-body">
        @include("template.breadcrumb")
        @yield("content")
      </div>

    </div>
    
    @include("template.delete")
    @include("template.import")

    <script src="{{ URL::asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ URL::asset('js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ URL::asset('js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ URL::asset('js/scrollbar/custom.js') }}"></script>
    <script src="{{ URL::asset('js/config.js') }}"></script>
    <script src="{{ URL::asset('js/sidebar-menu.js') }}"></script>
    <script src="{{ URL::asset('js/form-validation-custom.js') }}"></script>.
    <script src="{{ URL::asset('js/script.js') }}"></script>
    <script src="{{ URL::asset('js/theme-customizer/customizer.js') }}"></script>

    @yield("script")

    <script type="text/javascript">
      $("#link-nav-{{ Request::segment(1) }}").addClass("active");
      $("#menu-item-{{ Request::segment(1) }}").addClass("text-theme");
      @foreach($level1 as $key => $value)
      @if(isset($level2[$value->navigation_id]))
      @php
      $level4 = $level2[$value->navigation_id];
      @endphp
      @foreach($level4 as $key2 => $value2)
      @php
      $url2 = $value2->uri;
      @endphp
      @if(Request::segment(1)==$url2)
      $("#side-{{ $value->navigation_id }}").addClass("active");
      $("#sub-menu-{{ $value->navigation_id }}").removeAttr("style");
      @endif
      @endforeach
      @endif
      @endforeach

      $(".simplebar-content-wrapper").removeAttr('style');
      
      $("#sidebar-list").on('click', function() {
        $(".simplebar-content-wrapper").removeAttr('style');
      });

      $(document).ready(function() { 
        if ($(window).width() <= 768) {
          $("#collapseExample").removeClass("show");
          $("#btn-filters").show();
        }else{
          $("#collapseExample").addClass("show");
          $("#btn-filters").hide();
        }

      });

      $(window).resize(function() {
        if ($(window).width() <= 768) {
          $("#collapseExample").removeClass("show");
          $("#btn-filters").show();
        }else{
          $("#collapseExample").addClass("show");
          $("#btn-filters").hide();
        }
      });

      function goImport() {
        $("#modal-import").modal("show");
      }

      $("body").removeClass("dark-only");
  </script>
</body>
</html>