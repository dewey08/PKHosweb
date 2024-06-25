<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  {{-- <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}"> --}}
      <!-- App favicon -->
      <link rel="shortcut icon" href="{{ asset('apkclaim/images/logo150.ico') }}">
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
<style>
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Edu VIC WA NT Beginner', cursive;
  }

  body {
      width: 100%;
      height: 100vh;
      background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
          url(/pkclaim/public/sky16/images/bgPK.jpg)no-repeat 50%;
          /* url(/sky16/images/bgPK.jpg)no-repeat 50%; */
          /* url(/sky16/images/logo.png)no-repeat 50%; */
      background-size: cover;
      background-attachment: fixed;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .container {
      position: relative;
  }

  .form {
      position: relative;
      z-index: 100;
      width: 500px;
      height: 500px;
      background-color: rgba(240, 248, 255, 0.158);
      border-radius: 20px;
      backdrop-filter: blur(2px);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
  }
  .logo{
      /* width: 200px; */
      width: 100vh;
      height: 100vh;
      background: 
      url(/pkclaim/public/sky16/images/logo250.png)no-repeat 50%;
      /* url(/sky16/images/logo250.png)no-repeat 25%; */
      background-size: cover;
      /* background-attachment: fixed; */
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .h1 {
      color: rgb(255, 255, 255);
      font-weight: 500;
      margin-bottom: 20px;
      font-size: 50px;
      margin-top: 20px;
  }

  .username {
      width: 250px;
      background: none;
      outline: none;
      border: none;
      margin: 15px 0px;
      border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
      padding: 10px;
      color: aliceblue;
      font-size: 18px;
      transition: 0.2s ease-in-out;
      margin-top: 50px;
  }
  .password {
      width: 250px;
      background: none;
      outline: none;
      border: none;
      margin: 5px 0px;
      border-bottom: rgba(240, 248, 255, 0.418) 1px solid;
      padding: 10px;
      color: aliceblue;
      font-size: 18px;
      transition: 0.2s ease-in-out;
  }

  ::placeholder {
      color: rgba(255, 255, 255, 0.582);
  }
  ::focus {
      border-bottom: aliceblue 1px solid;
  }

  .fa-solid {
      transition: 0.2s ease-in-out;
      color: rgba(240, 248, 255, 0.59);
      margin-right: 10px;
      /* margin-top: 50px; */
  }

  .btn {
      width: 120px;
      height: 40px;
      margin-top: 30px;
      font-weight: 500;
      color: aliceblue;
      outline: none;
      border: none;
      background: rgba(240, 248, 255, 0.2);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      font-size: 20px;
      transition: 0.2s;
  }

  &::hover {
      background: aliceblue;
      color: gray;
      font-weight: 500;
  }

  .circle1 {
      position: absolute;
      width: 290px;
      height: 290px;
      background: rgba(240, 248, 255, 0.1);
      border-radius: 50%;
      top: 60%;
      left: -35%;
      z-index: -1;
      animation: float 2s 0.5s ease-in-out infinite;
  }
  .circle2 {
      position: absolute;
      width: 170px;
      height: 170px;
      background: rgba(240, 248, 255, 0.1);
      border-radius: 50%;
      top: -15%;
      right: -25%;
      z-index: -1;
      animation: float 2s ease-in-out infinite;
  }
  .circle3 {
      position: absolute;
      width: 220px;
      height: 220px;
      background: rgba(240, 248, 255, 0.1);
      border-radius: 50%;
      top: 50%;
      right: -80%;
      z-index: -1;
      animation: float 2s 0.7s ease-in-out infinite;
  }
  @keyframes float{
      0%{
          transform: translateY(0);
      }
      50%{
          transform: translateY(-20px);
      }
      100%{
          transform: translateY(0);
      }
  }
</style>
<body  >
  <nav class="navbar navbar-expand-md navbar-light me-5">
    <div class="container-fuid">
        <a href="{{url("setting/setting_index")}}" target="_blank">  
          <i class="fa-solid fa-3x fa-gear text-danger" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ตั้งค่า"></i>
        </a>
        <a href="{{url("user/home")}}" target="_blank">  
          <i class="fa-solid fa-3x fa-user-group text-info" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ผู้ใช้งานทั่วไป"></i>
        </a> 
      <br>
        <a class="navbar-brand" href="{{ url('admin/home') }}">
            {{-- {{ config('app.name', 'Laravel') }} --}}
            {{-- <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light" height="40"> --}}
          <label for="" style="color: white;font-size:25px;" class="ms-2 mt-2 text-center">PK-OFFICER</label>
            {{-- class="ms-2 mt-2">PKClaim</label> --}}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon" ></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          @if (Auth::user()->img == null)
                          <img src="{{ asset('assets/images/default-image.jpg') }}" height="32px" width="32px"
                              alt=" " class="rounded-circle header-profile-user me-3">
                      @else
                          <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="32px"
                              width="32px" alt=" " class="rounded-circle header-profile-user me-3">
                      @endif
                      <label for="" style="color: white" >{{ Auth::user()->fname }}   {{ Auth::user()->lname }}</label>
                          
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
  <div class="menu">
    <div class="toggle">  
      <img src="{{ asset('assets/images/logo150.png') }}" alt="logo-sm-light" height="220">
    </div>
    {{-- <li style="--i:0;">
      <a href="{{url("person/person_index")}}" target="_blank">
        <i class="fa-solid fa-3x fa-user-tie text-primary " data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ประกันสังคม"></i>
      </a>
    </li> --}}
    <li style="--i:0;">
      <a href="{{url("person/person_index")}}" target="_blank">
        <i class="fa-solid fa-3x fa-user-tie text-primary " data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="บุคลากร"></i>
      </a>
    </li>
    <li style="--i:1;">
      <a href="{{url("book/bookmake_index")}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="อปท"></i> --}}
        <i class="fa-solid fa-3x fa-book-open-reader text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="งานสารบรรณ"></i>
      </a>
    </li>
    {{-- <li style="--i:2;">
      <a href="{{url("report_op")}}" target="_blank"> 
        <i class="fa-solid fa-3x fa-chart-line text-warning" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="รายงาน"></i>
      </a>
    </li> --}}
    <li style="--i:2;">
      <a href="{{url("car/car_narmal_calenda")}}" target="_blank">
        <i class="fa-solid fa-3x fa-truck-medical text-info" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ยานพาหนะ"></i>
      </a>
    </li>
    {{-- <li style="--i:2;">
      <a href="{{url("car/car_narmal_calenda")}}" target="_blank">
        <i class="fa-solid fa-3x fa-truck-medical text-info" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ยานพาหนะ"></i>
      </a>
    </li> --}}
    <li style="--i:3;">
      <a href="{{url("meetting/meettingroom_dashboard")}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-success" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ห้องประชุม"></i> --}}
        <i class="fa-solid fa-3x fa-house-laptop text-success" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="ห้องประชุม"></i>
      </a>
    </li>
    <li style="--i:4;">
      <a href="{{url("repaire_narmal")}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="แจ้งซ่อมทั่วไป"></i> --}}
        <i class="fa-solid fa-3x fa-screwdriver-wrench text-dark" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="แจ้งซ่อมบำรุง"></i>
      </a>
    </li>
    <li style="--i:5;">
      <a href="{{url('computer/com_staff_calenda')}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คอมพิวเตอร์"></i> --}}
        <i class="fa-solid fa-3x fa-computer text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คอมพิวเตอร์"></i>
      </a>
    </li>
    <li style="--i:6;">
      <a href="{{url('medical/med_dashboard')}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-warning" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="เครื่องมือแพทย์"></i> --}}
        <i class="fa-solid fa-3x fa-pump-medical text-warning" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="เครื่องมือแพทย์"></i>
      </a>
    </li>
    <li style="--i:7;">
      <a href="{{url('housing/housing_dashboard')}}" target="_blank"> 
        {{-- <i class="fa-solid fa-3x fa-user-tie text-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="บ้านพัก"></i> --}}
        <i class="fa-solid fa-3x fa-house-chimney-user text-info" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="บ้านพัก"></i>
      </a>
    </li>
    <li style="--i:8;">
      <a href="{{url('plan')}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-danger" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="แผนงาน"></i> --}}
        <i class="fa-solid fa-3x fa-clipboard text-danger" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="แผนงาน"></i>
      </a>
    </li>
    <li style="--i:9;">
      <a href="{{url("article/article_dashboard")}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="ทรัพย์สิน"></i> --}}
        <i class="fa-solid fa-3x fa-building-shield text-secondary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="ทรัพย์สิน"></i>
      </a>
    </li>
    <li style="--i:10;">
      <a href="{{url("supplies/supplies_dashboard")}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-success" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="พัสดุ"></i> --}}
        <i class="fa-solid fa-3x fa-paste text-success" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="พัสดุ"></i>
      </a>
    </li>
    <li style="--i:11;">
      <a href="{{url("warehouse/warehouse_dashboard")}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คลังวัสดุ"></i> --}}
        <i class="fa-solid fa-3x fa-shop-lock text-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คลังวัสดุ"></i>
      </a>
    </li>
    <li style="--i:12;">
      <a href="" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-success" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คลังยา"></i>--}}
        <i class="fa-solid fa-3x fa-prescription text-success" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="คลังยา"></i> 
      </a>
    </li>
    <li style="--i:13;">
      <a href="{{url('pkclaim/pkclaim_info')}}" target="_blank">
        {{-- <i class="fa-solid fa-3x fa-user-tie text-danger" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="งานประกัน"></i>--}}
        <i class="fa-solid fa-3x fa-sack-dollar text-danger" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="งานประกัน"></i> 
      </a>
    </li>
    <li style="--i:14;">
      <a href="{{url('account_info')}}" target="_blank"> 
        <i class="fa-solid fa-3x fa-file-invoice-dollar text-warning" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="การเงิน & บัญชี"></i> 
      </a> 
    </li>
  </div> 
  <footer class="footer ms-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                {{-- <script>
                    document.write(new Date().getFullYear())
                </script> --}}
                 <label for="" style="color: white">2022 © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</label> 
            </div>
            
        </div>
        <div class="row">
          <div class="col-sm-12 text-center"> 
               <label for="" style="color: white"> By งานประกัน</label>
          </div>
          
      </div>
    </div>
</footer>
 
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