<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <script src="{{ asset('lib/webviewer.min.js') }}"></script>

    <link href="{{ asset('sky16/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('sky16/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/bootstrap-extended.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/icons.css') }}" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/tablecar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontuser.css') }}" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- loader-->
    <link href="{{ asset('sky16/css/pace.min.css') }}" rel="stylesheet" />

    <!--Theme Styles-->
    <link href="{{ asset('sky16/css/dark-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/light-theme.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/semi-dark.css') }}" rel="stylesheet" />
    <link href="{{ asset('sky16/css/header-colors.css') }}" rel="stylesheet" />

</head>

<?php
if (Auth::check()) {
    $type = Auth::user()->type;
    $userid = Auth::user()->id;
} else {
    echo "<body onload=\"TypeAdmin()\"></body>";
    exit();
}
$url = Request::url();
$pos = strrpos($url, '/') + 1;

use App\Http\Controllers\StaticController;
use App\Http\Controllers\RongController;
        $checkhn = StaticController::checkhn($userid);
        $checkhnshow = StaticController::checkhnshow($userid);
        $orginfo_headep = StaticController::orginfo_headep($userid);
        $orginfo_po = StaticController::orginfo_po($userid);
        $countadmin = StaticController::countadmin($userid);
        $count_article_car = StaticController::count_article_car();
        $count_car_service = StaticController::count_car_service(); 
        $count_car_service_ambu = StaticController::count_car_service_ambu();
        $checkhn = StaticController::checkhn($iduser);
        $checkhnshow = StaticController::checkhnshow($iduser);
        $count_suprephn = StaticController::count_suprephn($iduser);
        $count_bookrep_po = StaticController::count_bookrep_po();

?>
<style>
    body {
      font-family: 'Kanit', sans-serif;
      font-size: 14px;

      }

      label{
            font-family: 'Kanit', sans-serif;
            font-size: 14px;

      }

      @media only screen and (min-width: 1200px) {
label {
    /* float:right; */
  }

      }
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  
    .dataTables_wrapper   .dataTables_filter{
            float: right 
          }

        .dataTables_wrapper  .dataTables_length{
                float: left 
        }
        .dataTables_info {
                float: left;
        }
        .dataTables_paginate{
                float: right
        }
        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
      
      
    }
    .table thead tr th{
        font-size:14px;
    }
    .table tbody tr td{
        font-size:13px;
    }
    .menu{
        font-size:13px;
    }
  </style>

<body>

    <!--start wrapper-->
    <div class="wrapper">

        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand bg-secondary">
                <div class="mobile-toggle-icon d-xl-none">
                    <i class="bi bi-list"></i>
                </div>
                <div class="top-navbar d-none d-xl-block">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('admin/home')}}">
                              
                              <label for="" style="color: white">Dashboard</label>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="ms-auto">

                </div>

                <div class="top-navbar-right ms-3">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                                data-bs-toggle="dropdown">
                                <div class="user-setting d-flex align-items-center gap-1"> 
                                    @if (Auth::user()->img == null)
                                        <img src="{{ asset('assets/images/default-image.jpg') }}"n height="32px"
                                            width="32px" alt="Image" class="user-img">
                                    @else
                                        <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="32px"
                                            width="32px" alt="Image" class="user-img">
                                    @endif
                                    <div class="user-name d-none d-sm-block"> {{ Auth::user()->fname }}
                                        {{ Auth::user()->lname }}</div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">


                                            @if (Auth::user()->img == null)
                                                <img src="{{ asset('assets/images/default-image.jpg') }}"
                                                    width="60" height="60" alt="Image" class="rounded-circle">
                                            @else
                                                <img src="{{ asset('storage/person/' . Auth::user()->img) }}"
                                                    width="60" height="60" alt="Image" class="rounded-circle">
                                            @endif

                                            <div class="ms-3">
                                                <h6 class="mb-0 dropdown-user-name"> {{ Auth::user()->fname }}
                                                    {{ Auth::user()->lname }}</h6>
                                                <small
                                                    class="mb-0 dropdown-user-designation text-secondary">{{ Auth::user()->position_name }}
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-user-profile.html">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon"><i class="bi bi-person-fill"></i></div>
                                            <div class="setting-text ms-3"><span>Profile</span></div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                                            <div class="setting-text ms-3"><span>Logout</span></div>
                                        </div>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                      @csrf
                                  </form>
                                </li>
                            </ul>
                        </li>
                      
                    </ul>
                </div>
            </nav>
        </header>
        <!--end top header-->

       

        <!--start sidebar -->
        <aside class="sidebar-wrapper">
            <div class="iconmenu">
                <div class="nav-toggle-box bg-secondary">
                    <div class="nav-toggle-icon"><i class="bi bi-list"></i></div>
                </div>
                <ul class="nav nav-pills flex-column"> 
                    {{-- <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="ข้อมูลการลา">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-gleave" type="button">
                            <i class="bi bi-file-person"></i>
                        </button>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="ประชุม/อบรม/ดูงาน">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-persondev" type="button">
                         <i class="fa-solid fa-handshake "></i>
                        </button>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="บ้านพัก">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-hosing" type="button">
                            <i class="fa-solid fa-house-chimney-user"></i>
                        </button>
                    </li>
                    <hr>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="สารบรรณ">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-book" type="button">
                            <i class="fa-solid fa-book-open"></i>
                        </button>
                    </li> --}}
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="ยานพาหนะ">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-car" type="button">
                            <i class="fa-solid fa-car-side"></i>
                        </button>
                    </li>
                    {{-- <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="ห้องประชุม">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-meetting" type="button">
                         
                            <i class="fa-solid fa-person-shelter"></i>
                        </button>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="แจ้งซ่อม">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-repaire" type="button">                         
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </button>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="งานทรัพย์สิน">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-article" type="button">                         
                            <i class="fa-solid fa-building-shield"></i>
                        </button>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="งานพัสดุ">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-supplies" type="button">                         
                            <i class="fa-solid fa-paste"></i>
                        </button>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="คลังวัสดุ">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-store" type="button">                         
                            <i class="fa-solid fa-shop-lock"></i>
                        </button>
                    </li> --}}
                </ul>
            </div>
            <div class="textmenu ">
                <div class="brand-logo bg-secondary">
                    <img src="{{ asset('assets/images/logoZoffice.png') }}" width="100" height="30px" alt="" />
                </div>
                <div class="tab-content">  
                       
                    {{-- <div class="tab-pane fade" id="pills-gleave">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">ข้อมูลการลา</h5>
                                </div> 
                            </div>
                            <a href="{{ url('user/gleave_data/'. Auth::user()->id) }}" class="list-group-item">  
                                <i class="fa-solid fa-circle-info text-secondary"></i>
                                ข้อมูลการลา
                            </a>
                            <a href="{{ url('user/gleave_data_sick') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-bed-pulse text-info"></i>
                                ลาป่วย
                            </a>
                            <a href="{{ url('user/gleave_data_leave') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-half-dress text-info"></i>
                                ลากิจ
                            </a>
                            <a href="{{ url('user/gleave_data_vacation') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-pregnant text-success"></i>
                                ลาพักผ่อน
                            </a>
                            <a href="{{ url('user/gleave_data_study') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-chalkboard text-warning"></i>
                                ลาศึกษา ฝึกอบรม
                            </a>
                            <a href="{{ url('user/gleave_data_work') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-walking-luggage text-danger"></i>
                                ลาทำงานต่างประเทศ
                            </a>
                            <a href="{{ url('user/gleave_data_occupation') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-people-pulling text-dark"></i>
                                ลาฟื้นฟูอาชีพ
                            </a>
                            <a href="{{ url('user/gleave_data_soldier') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-rifle text-primary"></i>
                                ลาเกณฑ์ทหาร
                            </a>
                            <a href="{{ url('user/gleave_data_helpmaternity') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-dots-from-line text-success"></i>
                                ลาช่วยภริยาคลอด
                            </a>
                            <a href="{{ url('user/gleave_data_maternity') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-breastfeeding text-danger"></i>
                                ลาคลอดบุตร
                            </a>
                            <a href="{{ url('user/gleave_data_spouse') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-hospital-user text-dark"></i>
                                ลาติดตามคู่สมรส
                            </a>
                            <a href="{{ url('user/gleave_data_out') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-arrow-right-from-bracket text-info"></i>
                                ลาออก
                            </a>
                            <a href="{{ url('user/gleave_data_law') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-person-hiking"></i>
                                ลาป่วยตามกฎหมายฯ
                            </a>
                            <a href="{{ url('user/gleave_data_ordination') }}" class="list-group-item"> 
                                <i class="far fa-solid fa-user-injured text-warning"></i>
                                ลาอุปสมบทประกอบพิธีฮัจญ์
                            </a>
                           
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-persondev">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">ประชุม/อบรม/ดูงาน</h5>
                                </div>                               
                            </div>                            
                            <a href="{{ url('user/persondev_index/'. Auth::user()->id)}}" class="list-group-item"> 
                                <i class="fa-solid fa-handshake text-primary"></i>
                                ประชุมภายนอก
                            </a>
                            <a href="{{ url('user/persondev_inside/'. Auth::user()->id)}}" class="list-group-item">
                                <i class="fa-solid fa-handshake-simple text-success"></i>
                                ประชุมภายใน
                            </a>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-hosing">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">บ้านพัก</h5>
                                </div>                               
                            </div>   
                            <a href="{{ url('user/house_detail/'. Auth::user()->id)}}" class="list-group-item">
                                <i class="fa-solid fa-house-circle-exclamation text-info"></i>
                                ข้อมูลบ้านพัก
                            </a>                         
                            <a href="{{ url('user/house_petition/'. Auth::user()->id)}}" class="list-group-item">
                                <i class="fa-solid fa-hand-holding-droplet text-success"></i>
                                ยื่นคำร้อง
                            </a>   
                            <a href="{{ url('user/house_problem/'. Auth::user()->id)}}" class="list-group-item">
                                <i class="fa-solid fa-house-crack text-danger"></i>
                                แจ้งปัญหา
                            </a>                           
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-book">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">สารบรรณ</h5>
                                </div>                               
                            </div>   
                            <a href="{{ url('user/book_inside/'. Auth::user()->id)}}" class="list-group-item"> 
                                <i class="fa-solid fa-book text-info"></i>
                                หนังสือเข้า
                            </a>                         
                            <a href="{{ url('user/book_send/'. Auth::user()->id)}}" class="list-group-item"> 
                                <i class="fa-solid fa-book-open-reader text-success"></i>
                                หนังสือส่ง
                            </a>   
                                                       
                        </div>
                    </div> --}}

                    <div class="tab-pane fade" id="pills-car">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">ยานพาหนะ</h5>
                                </div>                               
                            </div>   
                            <a href="{{ url('car/car_narmal_calenda') }}" class="list-group-item">  
                                <i class="fa-solid fa-calendar-days text-info"></i>
                                ปฎิทินการใช้รถ
                            </a>                         
                            <a href="{{url('car/car_narmal_index')}}" class="list-group-item">  
                                <i class="fa-solid fa-car-side text-success"> </i>
                                รถทั่วไป
                                <span class="badge bg-danger ms-2">{{$count_car_service}}</span>
                            </a>   
                            <a href="{{url('car/car_ambulance')}}" class="list-group-item"> 
                                <i class="fa-solid fa-truck-medical text-danger"> </i> 
                                รถพยาบาล
                                <span class="badge bg-danger ms-2">{{$count_car_service_ambu}}</span>
                            </a>   
                            <a href="{{url('car/car_data_index')}}" class="list-group-item">  
                                <i class="fa-solid fa-car text-secondary"></i>
                                ข้อมูลยานพาหนะ
                                <span class="badge bg-danger ms-2">{{$count_article_car}}</span>
                            </a> 
                            <a href="{{url('car/car_data_index_add')}}" class="list-group-item">   
                                <i class="fa-solid fa-car-on text-dark"></i>
                                เพิ่มข้อมูลยานพาหนะ 
                            </a>  
                            {{-- <a href="" class="list-group-item">  
                                <i class="fa-solid fa-chart-line text-warning"></i>
                                รายงาน
                            </a>     --}}
                            {{-- <a href="{{url('car/car_narmal_report')}}" class="list-group-item">  
                              <i class="fa-solid fa-chart-line text-warning"></i>
                              รายงาน
                          </a>                          --}}
                        </div>
                    </div>

                    {{-- <div class="tab-pane fade" id="pills-meetting">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">ห้องประชุม</h5>
                                </div>                               
                            </div>   
                            <a href="{{ url('user_meetting/meetting_calenda') }}" class="list-group-item">  
                                <i class="fa-solid fa-calendar-days text-info"></i>
                                ปฎิทินการใช้ห้องประชุม
                            </a>                         
                            <a href="{{url('user_meetting/meetting_index')}}" class="list-group-item">   
                                <i class="fa-solid fa-people-roof text-success"></i>
                                ช้อมูลการจองห้องประชุม
                            </a>   
                            
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-repaire">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">แจ้งซ่อม</h5>
                                </div>                               
                            </div>   
                            <a href="{{url('user/repair_narmal/'.Auth::user()->id)}}" class="list-group-item">   
                                <i class="fa-solid fa-toolbox text-info"></i>
                                ซ่อมทั่วไป
                            </a>                         
                            <a href="{{url('user/repair_com/'.Auth::user()->id)}}" class="list-group-item">   
                                <i class="fa-solid fa-computer text-success"></i>
                                ซ่อมคอมพิวเตอร์
                            </a>   
                            <a href="{{url('user/repair_med/'.Auth::user()->id)}}" class="list-group-item">   
                                <i class="fa-solid fa-pump-medical text-danger"></i>
                                ซ่อมเครื่องมือแพทย์
                            </a> 
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-article">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">งานทรัพย์สิน</h5>
                                </div>                               
                            </div>   
                            <a href="{{url('user/article_index/'.Auth::user()->id)}}" class="list-group-item">    
                                <i class="fa-solid fa-building-circle-exclamation text-info"></i>
                                ทะเบียนทรัพย์สิน
                            </a>                         
                            <a href="{{url('user/article_borrow/'.Auth::user()->id)}}" class="list-group-item">    
                                <i class="fa-solid fa-building-circle-check text-success"></i>
                                ทะเบียนยืม
                            </a>   
                            <a href="{{url('user/article_return/'.Auth::user()->id)}}" class="list-group-item">    
                                <i class="fa-solid fa-building-circle-arrow-right text-danger"></i>
                                ทะเบียนคืน
                            </a> 
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-supplies">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">งานพัสดุ</h5>
                                </div>                               
                            </div>   
                            <a href="{{url('user/supplies_data/'.Auth::user()->id)}}" class="list-group-item">   
                                <i class="fa-solid fa-hand-holding-dollar text-info"></i>
                                รายการจัดซื้อ-จัดจ้าง
                            </a>                         
                            <a href="{{url('user/supplies_data_add/'.Auth::user()->id)}}" class="list-group-item">  
                                <i class="fa-solid fa-hand-holding-medical text-success"></i>
                                ขอจัดซื้อ-จัดจ้าง
                            </a>   
                            
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-store">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-0">คลังวัสดุ</h5>
                                </div>                               
                            </div>   
                            <a href="{{url('user/warehouse_deb_sub_sub/'.Auth::user()->id)}}" class="list-group-item">   
                                <i class="fa-solid fa-hand-holding-dollar text-info"></i>
                                รายการคลังวัสดุ
                            </a>                         
                            <a href="{{url('user/warehouse_main_request/'.Auth::user()->id)}}" class="list-group-item">     
                                <i class="fa-solid fa-pager text-success"></i>
                                ขอเบิกคลังวัสดุ
                            </a>   
                            
                        </div>
                    </div>
                     --}}

                </div>
            </div>
        </aside>
     
        <main class="page-content">
            @yield('content')
        </main>
        <!--end page main-->

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

      

    </div>
    <!--********************************** Scripts ***********************************-->


    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('sky16/js/jquery.min.js') }}"></script>
    <script src="{{ asset('sky16/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('sky16/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sky16/js/pace.min.js') }}"></script>
    <script src="{{ asset('sky16/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('sky16/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    {{-- <script src="{{ asset('sky16/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script> --}}
  
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--app-->
  <script src="{{ asset('sky16/js/app.js') }}"></script> 
    {{-- ที่เออเร่อตอนนี้ปิดตัวนี้ก็หาย ==> sky16/js/app.js แต่ togle จะไม่ออกมา --}}
  {{-- <script src="{{ asset('sky16/js/index.js') }}"></script> --}}
    <script>
        // new PerfectScrollbar(".best-product")
        // new PerfectScrollbar(".top-sellers-list")
    </script>

    @yield('footer')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            $('#example_user').DataTable();

            $('#article_user_id').select2({
                placeholder:"เลือกผู้รับผิดชอบ ",
                allowClear:true
            });
            $('#article_status_id').select2({
                placeholder:"เลือกสถานะ",
                allowClear:true
            });
            $('#article_car_type_id').select2({
                placeholder:"เพิ่มประเภท",
                allowClear:true
            });        
            $('#article_brand_id').select2({
                placeholder:"เพิ่มยี่ห้อ",
                allowClear:true
            });
            $('#article_color_id').select2({
                placeholder:"เพิ่มสี",
                allowClear:true
            });
            $('#article_deb_subsub_id').select2({
                placeholder:"หน่วยงาน",
                allowClear:true
            });


            $('#dep').select2({
                placeholder:"กลุ่มงาน",
                allowClear:true
            });
            $('#depsub').select2({
                placeholder:"ฝ่าย/แผนก",
                allowClear:true
            });
            // $('#depsubsub').select2({
            //     placeholder:"หน่วยงาน",
            //     allowClear:true
            // });
            $('#team').select2({
                placeholder:"ทีมนำองค์กร",
                allowClear:true
            });
            $('#depsubsubtrue').select2({
                placeholder:"หน่วยงานที่ปฎิบัติจริง",
                allowClear:true
            });
            $('#book_objective').select2({
                placeholder:"วัตถุประสงค์",
                allowClear:true
            });
            $('#book_objective2').select2({
                placeholder:"วัตถุประสงค์",
                allowClear:true
            });
            $('#book_objective3').select2({
                placeholder:"วัตถุประสงค์",
                allowClear:true
            });
            $('#book_objective4').select2({
                placeholder:"วัตถุประสงค์",
                allowClear:true
            });
            $('#book_objective5').select2({
                placeholder:"วัตถุประสงค์",
                allowClear:true
            });
            $('#org_team_id').select2({
                placeholder:"ทีมนำองค์กร",
                allowClear:true
            }); 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#insert_carForm').on('submit',function(e){
                  e.preventDefault();
                  var form = this; 
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 500 ) {
                        alert('Error');
                      } else {          
                        Swal.fire({
                          title: 'บันทึกข้อมูลสำเร็จ',
                          text: "You Insert data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {                  
                            window.location="{{url('car/car_data_index')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            $('#update_carForm').on('submit',function(e){
                e.preventDefault();
            
                var form = this;
                // alert('OJJJJOL');
                $.ajax({
                  url:$(form).attr('action'),
                  method:$(form).attr('method'),
                  data:new FormData(form),
                  processData:false,
                  dataType:'json',
                  contentType:false,
                  beforeSend:function(){
                    $(form).find('span.error-text').text('');
                  },
                  success:function(data){
                    if (data.status == 0 ) {
                      
                    } else {          
                      Swal.fire({
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: "You edit data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                          window.location="{{url('car/car_data_index')}}";
                        }
                      })      
                    }
                  }
                });
            });    

        });

        function addarticle(input) {
          var fileInput = document.getElementById('article_img');
          var url = input.value;
          var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
              if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                  var reader = new FileReader();    
                  reader.onload = function (e) {
                      $('#add_upload_preview').attr('src', e.target.result);
                  }    
                  reader.readAsDataURL(input.files[0]);
              }else{    
                  alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                  fileInput.value = '';
                  return false;
                  }
        }

       
    </script>


</body>

</html>
