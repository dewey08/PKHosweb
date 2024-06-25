<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}"> 
   <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
   <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
   <!-- Font Awesome -->
   <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">  
   <link href="{{ asset('css/sizebarhn.css') }}" rel="stylesheet">
   <link href="{{ asset('css/tablehncss.css') }}" rel="stylesheet">
   <script src="{{ asset('lib/webviewer.min.js') }}"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <!-- MDB -->
   <link rel="stylesheet" href="{{ asset('assets/css/mdb.min.css') }}" />
    </head>
    <style>
   
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
      </style>
    <body> 
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
        <?php
        use App\Http\Controllers\UsersuppliesController;
        use App\Http\Controllers\StaticController;
        use App\Models\Products_request_sub;
    
        $refnumber = UsersuppliesController::refnumber();    
        $checkhn = StaticController::checkhn($iduser);
        $checkhnshow = StaticController::checkhnshow($iduser);
        $count_suprephn = StaticController::count_suprephn($iduser);
        ?> 
<body style="background-color: rgba(217, 237, 241, 0.756)">
    <div class="page">

        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo-container">
                    <div class="logo-container">
                        <img class="logo-sidebar" src="{{ asset('assets/images/logoZoffice-smm.png') }}"> 
                    </div>
                    <div class="brand-name-container">
                        <p class="brand-name">
                            Z-OFFice
                            {{-- Z<br />
                            <span class="brand-subname">
                                Z-OFFice
                            </span> --}}
                        </p>
                        
                    </div>
                </div>
            </div>
            <div class="sidebar-body">
                <hr style="color:rgb(255, 255, 255);margin-top:10px;">

                <ul class="navigation-list">

                    <li class="navigation-list-item {{'user/home' == request()->path() ? 'active':''}}">
                        <a class="navigation-link" href="{{url('user/home')}}">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-users "></i>
                                </div>
                                <div class="col-9">
                                    ผู้ใช้งานทั่วไป
                                </div>
                            </div>
                        </a>
                    </li>

                    <li class="navigation-list-item {{'hn/hn_dashboard/'.Auth::user()->id == request()->path() ? 'active':''}}">
                        <a class="navigation-link" href="{{url('hn/hn_dashboard/'.Auth::user()->id)}}">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                <div class="col-9">
                                    Dashboard
                                </div>
                            </div>
                        </a>
                    </li>
                   
                    <li class="navigation-list-item {{'hn/hn_bookindex/'.Auth::user()->id == request()->path() ? 'active':''}}">
                        <a class="navigation-link" href="{{url('hn/hn_bookindex/'.Auth::user()->id)}}">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="col-8">
                                    หนังสือราชการ
                                </div>
                                <div class="col-1">
                                    <span class="badge bg-danger ms-2">0</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item {{'hn/hn_leaveindex/'.Auth::user()->id == request()->path() ? 'active':''}}">
                        <a class="navigation-link" href="{{url('hn/hn_leaveindex/'.Auth::user()->id)}}">
                            <div class="row">
                                <div class="col-2">
                              
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="col-8">
                                   การลา
                                </div>
                                <div class="col-1">
                                    <span class="badge bg-danger ms-2">0</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item {{'hn/hn_trainindex/'.Auth::user()->id == request()->path() ? 'active':''}}">
                        <a class="navigation-link" href="{{url('hn/hn_trainindex/'.Auth::user()->id)}}">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div class="col-8">
                                   ประชุม/อบรม/ดูงาน
                                </div>
                                <div class="col-1">
                                    <span class="badge bg-danger ms-2">0</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item {{'hn/hn_purchaseindex/'.Auth::user()->id == request()->path() ? 'active':''}}">
                        <a class="navigation-link" href="{{url('hn/hn_purchaseindex/'.Auth::user()->id)}}">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="col-8">
                                    จัดซื้อจัดจ้าง
                                </div>
                                <div class="col-1">
                                    <span class="badge bg-danger ms-2">{{$count_suprephn}}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="navigation-list-item {{'hn/hn_storeindex/'.Auth::user()->id == request()->path() ? 'active':''}}">
                        <a class="navigation-link" href="{{url('hn/hn_storeindex/'.Auth::user()->id)}}">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="col-8">
                                    คลังวัสดุ
                                </div>
                                <div class="col-1">
                                    <span class="badge bg-danger ms-2">0</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    
                    
                </ul>
                {{-- <hr style="color:rgb(255, 255, 255);margin-top:30px;">
                <div class="teams-title-container">
                    <p class="teams-title">TEAMS</p>
                </div>                --}}

            </div>
        </div>
        
        <div class="content">
            <div class="navigationBar">
                <button id="sidebarToggle" class="btn sidebarToggle"> 
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            
                  <div class="position-absolute me-5 end-0">
                    <ul class="navbar-nav">                        
               
                        @guest
                        @if (Route::has('login'))
                            <li class="nav-item text-white">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item text-white">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown ">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                   
                              <img src="{{ asset('assets/images/logoZoffice.png') }}" height="40" width="80"> <br>
                              {{ Auth::user()->fname }}   {{ Auth::user()->lname }}
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
   
            <main class="py-2">
                @yield('content')
            </main>
        
    </div>
 

    <script>
        let sidebarToggle = document.querySelector(".sidebarToggle");
        sidebarToggle.addEventListener("click", function(){
            document.querySelector("body").classList.toggle("active");
            document.getElementById("sidebarToggle").classList.toggle("active");
        })
    </script>

 
<script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

<!-- MDB -->
<script type="text/javascript" src="{{ asset('assets/js/mdb.min.js') }}"></script> 

<script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('footer')

<script type="text/javascript">
    $(document).ready(function(){

        $('#examplebook').DataTable();
        $('#examplesup').DataTable();
        $('#example3').DataTable();
        $('#example4').DataTable();
        $('#example5').DataTable();
    });
     
</script>
  </body>


</html>