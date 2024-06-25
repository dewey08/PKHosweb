<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menudis.css') }}" rel="stylesheet">
    <link href="{{ asset('sky16/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
      <!-- Bootstrap CSS -->
     
      <link href="{{ asset('sky16/css/bootstrap.min.css') }}" rel="stylesheet" />
      <link href="{{ asset('sky16/css/bootstrap-extended.css') }}" rel="stylesheet" />
      <link href="{{ asset('sky16/css/style.css') }}" rel="stylesheet" />
</head>
<?php
if (Auth::check()) {
   $type = Auth::user()->type;
   $iduser = Auth::user()->id;
} else {
   echo "<body onload=\"TypeAdmin()\"></body>";
   exit();
}
$url = Request::url();
$pos = strrpos($url, '/') + 1;
 
?>
<body>
  <div class="menu">
    <div class="toggle">  
      <img src="{{ asset('assets/images/logo150.png') }}" alt="logo-sm-light" height="220">
    </div>
    <li style="--i:0;">
      <a href="{{url("person/person_index")}}" target="_blank">
        <i class="fa-solid fa-3x fa-user-tie text-primary " data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="บุคลากร"></i>
      </a>
    </li>
    <li style="--i:1;">
      <a href="{{url("book/bookmake_index")}}" target="_blank">
        <i class="fa-solid fa-3x fa-book-open-reader text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="งานสารบรรณ"></i>
      </a>
    </li>
    <li style="--i:2;">
      <a href="{{url("car/car_narmal_calenda")}}" target="_blank">
        <i class="fa-solid fa-3x fa-truck-medical text-info" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ยานพาหนะ"></i>
      </a>
    </li>
    <li style="--i:3;">
      <a href="{{url("meetting/meettingroom_dashboard")}}" target="_blank">
        <i class="fa-solid fa-3x fa-house-laptop text-success" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ห้องประชุม"></i>
      </a>
    </li>
    <li style="--i:4;">
      <a href="" target="_blank">
        <i class="fa-solid fa-3x fa-screwdriver-wrench text-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="แจ้งซ่อมทั่วไป"></i>
      </a>
    </li>
    <li style="--i:5;">
      <a href="{{url('computer/com_staff_calenda')}}" target="_blank">
        <i class="fa-solid fa-3x fa-computer text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คอมพิวเตอร์"></i>
      </a>
    </li>
    <li style="--i:6;">
      <a href="{{url('medical/med_dashboard')}}" target="_blank">
        <i class="fa-solid fa-3x fa-pump-medical text-warning" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="เครื่องมือแพทย์"></i>
      </a>
    </li>
    <li style="--i:7;">
      <a href="{{url('housing/housing_dashboard')}}" target="_blank"> 
        <i class="fa-solid fa-3x fa-house-chimney-user text-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="บ้านพัก"></i>
      </a>
    </li>
    <li style="--i:8;">
      <a href="">
        <i class="fa-solid fa-3x fa-clipboard text-danger" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="แผนงาน"></i>
      </a>
    </li>
    <li style="--i:9;">
      <a href="{{url("article/article_dashboard")}}" target="_blank">
        <i class="fa-solid fa-3x fa-building-shield text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="ทรัพย์สิน"></i>
      </a>
    </li>
    <li style="--i:10;">
      <a href="{{url("supplies/supplies_dashboard")}}" target="_blank">
        <i class="fa-solid fa-3x fa-paste text-success" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="พัสดุ"></i>
      </a>
    </li>
    <li style="--i:11;">
      <a href="" target="_blank">
        <i class="fa-solid fa-3x fa-shop-lock text-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คลังวัสดุ"></i>
      </a>
    </li>
    <li style="--i:12;">
      <a href="" target="_blank">
        <i class="fa-solid fa-3x fa-prescription text-success" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คลังยา"></i> 
      </a>
    </li>
    <li style="--i:13;">
      <a href="{{url('pkclaim/pkclaim_info')}}" target="_blank">
        <i class="fa-solid fa-3x fa-sack-dollar text-danger" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="งานประกัน"></i> 
      </a>
    </li>
  </div> 
 
 
  <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>  
  <script src="{{ asset('sky16/js/jquery.min.js') }}"></script>
 <script src="{{ asset('sky16/js/app.js') }}"></script> 
   <script>
    let toggle = document.querySelector('.toggle');
    let menu = document.querySelector('.menu');
    toggle.onclick = function () {
      menu.classList.toggle('active');
    }
  </script>
</body>
</html>