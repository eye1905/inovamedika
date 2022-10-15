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
  <title> Nawa Sena Klinik | Laporan @yield('title')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/vendors/font-awesome.css') }}">
  <style type="text/css">
    html { margin: 0px}
    body{
      font-family: 'roboto';
      padding: 7px;
    }
    .table1 {
      font-size: 10pt;
      font-family: sans-serif;
      color: #444;
      border-collapse: collapse;
      width: 100%;
      border: 1px solid #f2f5f7;
    }
    .table1 tr th{
      background: grey;
      color: #fff;
      font-weight: bold;
    }
    .table1, th, td {
      padding: 8px 20px;
      text-align: left;
    }
    .table1 tr:hover {
      background-color: #f5f5f5;
    }
    .table1 tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .text-center{
      text-align: center;
    }
    .text-title{
      margin-left: 10pt;
    }
  </style>
  @if(isset($filter["format"]) and $filter["format"] != null)
  @if($filter["format"]=="excel")
  @php
  $name = "Laporan".Request::segment(1).date("Y/m/d");
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=".$name.".xls");
  @endphp
  <style type="text/css">
    .table1 tr th{
      color: black;
      font-weight: bold;
    }
  </style>
  @else
  @endif
  @endif
  <script src="{{ URL::asset('js/jquery-3.5.1.min.js') }}"></script>
</head>
<body>
  <div class="container">
    @yield("content")
  </div>
</body>
</html>