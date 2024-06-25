<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
   <!-- Font Awesome -->
   <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
   <!-- App favicon -->
   <link rel="shortcut icon" href="{{ asset('apkclaim/images/logo150.ico') }}">

   

   {{-- <link href="{{ asset('apkclaim/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"> --}}
   <link href="{{ asset('apkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
   <link href="{{ asset('apkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('apkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
   <!-- jquery.vectormap css -->
   <link href="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
       rel="stylesheet" type="text/css" />

   <!-- DataTables -->
   <link href="{{ asset('apkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
       type="text/css" />

   <!-- Responsive datatable examples -->
   <link href="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
       rel="stylesheet" type="text/css" />
       <link href="{{ asset('css/tableuser_new.css') }}" rel="stylesheet">
   <!-- Bootstrap Css -->
   {{-- <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
   <link href="{{ asset('apkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
   <!-- Icons Css -->
   <link href="{{ asset('apkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- App Css-->
   <link href="{{ asset('apkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
   <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
   {{-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> --}}
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body data-topbar="dark" data-layout="horizontal">

         <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div>

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar" style="background-color: rgba(9, 165, 165, 0.952)">
                <div class="navbar-header">
                    <div class="d-flex">
                         <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href=" " class="logo logo-dark">

                        </a>

                        <a href=" " class="logo" style="background-color: rgb(9, 165, 165, 0.952)">
                            <span class="logo-sm mb-2">
                                <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light"
                                    height="40">
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light"
                                    height="40"> --}}
                                <label for="" style="color: white;font-size:25px;"
                                    class="ms-1 mt-2">PK-OFFICER</label>
                                    
                            </span>
                        </a>
                    </div>
                    <?php  
                    $datadetail = DB::connection('mysql')->select(                                                            '   
                            select * from orginfo 
                            where orginfo_id = 1                                                                                                                      ',
                    ); 
                ?>

                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="ri-menu-2-line align-middle" style="color: rgb(255, 255, 255)"></i>
                        </button>
                        {{-- @foreach ($datadetail as $item)
                        <h4 style="color: white;font-size:22px;" class="ms-2 mt-4">{{$item->orginfo_name}}</h4>
                    @endforeach --}}

                        <!-- App Search-->
                        {{-- <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="ri-search-line"></span>
                            </div>
                        </form> --}}

                        {{-- <div class="dropdown dropdown-mega d-none d-lg-block ms-2">
                            <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                Mega Menu
                                <i class="mdi mdi-chevron-down"></i> 
                            </button>
                            <div class="dropdown-menu dropdown-megamenu">
                                <div class="row">
                                    <div class="col-sm-8">
                
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5 class="font-size-14">UI Components</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);">Lightbox</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Range Slider</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Sweet Alert</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Rating</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Forms</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Tables</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Charts</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-md-4">
                                                <h5 class="font-size-14">Applications</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);">Ecommerce</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Calendar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Email</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Projects</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Tasks</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Contacts</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-md-4">
                                                <h5 class="font-size-14">Extra Pages</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);">Light Sidebar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Compact Sidebar</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Horizontal layout</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Maintenance</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Coming Soon</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Timeline</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">FAQs</a>
                                                    </li>
                                        
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h5 class="font-size-14">UI Components</h5>
                                                <ul class="list-unstyled megamenu-list">
                                                    <li>
                                                        <a href="javascript:void(0);">Lightbox</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Range Slider</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Sweetalert 2</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Rating</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Forms</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Tables</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);">Charts</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="col-sm-5">
                                                <div>
                                                    <img src="assets/images/megamenu-img.png" alt="megamenu-img" class="img-fluid mx-auto d-block">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> --}}
                    </div>

                    <div class="d-flex">

                        {{-- <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-search-line"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                    
                                <form class="p-3">
                                    <div class="mb-3 m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> --}}

                        {{-- <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="" src="assets/images/flags/us.jpg" alt="Header Language" height="16">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                    
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <img src="assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                                </a>
                            </div>
                        </div> --}}

                        {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-apps-2-line"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                <div class="px-lg-2">
                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/github.png" alt="Github">
                                                <span>GitHub</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/bitbucket.png" alt="bitbucket">
                                                <span>Bitbucket</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/dribbble.png" alt="dribbble">
                                                <span>Dribbble</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row g-0">
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/dropbox.png" alt="dropbox">
                                                <span>Dropbox</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/mail_chimp.png" alt="mail_chimp">
                                                <span>Mail Chimp</span>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a class="dropdown-icon-item" href="#">
                                                <img src="assets/images/brands/slack.png" alt="slack">
                                                <span>Slack</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line"></i>
                            </button>
                        </div> --}}

                        {{-- <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                                  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-notification-3-line"></i>
                                <span class="noti-dot"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="ri-shopping-cart-line"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mb-1">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="assets/images/users/avatar-3.jpg"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">It will seem like simplified English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="ri-checkbox-circle-line"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="mb-1">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">If several languages coalesce the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="assets/images/users/avatar-4.jpg"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top">
                                    <div class="d-grid">
                                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                            <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                        {{-- <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1">Julia</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My Wallet</a>
                                <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                                <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                            </div>
                        </div> --}}

                        {{-- <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="ri-settings-2-line"></i>
                            </button>
                        </div> --}}
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line" style="color: rgb(255, 255, 255)"></i>
                            </button>
                        </div>
    
                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->img == null)
                                    <img src="{{ asset('assets/images/default-image.jpg') }}" height="32px" width="32px"
                                        alt="Header Avatar" class="rounded-circle header-profile-user">
                                @else
                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="32px"
                                        width="32px" alt="Header Avatar" class="rounded-circle header-profile-user">
                                @endif
                                <span class="d-none d-xl-inline-block ms-1">
                                    {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                                </span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="{{ url('user/profile_edit/' . Auth::user()->id) }}"><i
                                        class="ri-user-line align-middle me-1"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    class="text-reset notification-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
    
                        <div class="dropdown d-inline-block user-dropdown">
                        </div>
            
                    </div>
                </div>
            </header>
    
                <div class="topnav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
    
                            <div class="collapse navbar-collapse" id="topnav-menu-content">
                                <ul class="navbar-nav">

                                    <li class="nav-item">
                                        <a class="nav-link" href="index.html">
                                            <i class="ri-dashboard-line me-2"></i> Dashboard
                                        </a>
                                    </li>
    
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                            <i class="ri-layout-3-line me-2"></i><span key="t-layouts">งานบริหารบุคคล</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                                    role="button">
                                                    <span key="t-vertical">ข้อมูลการลา</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                                    <a href="{{ url('user/gleave_data_sick') }}" class="dropdown-item" key="t-dark-sidebar">ลาป่วย</a>
                                                    <a href="{{ url('user/gleave_data_leave') }}" class="dropdown-item" key="t-compact-sidebar">ลากิจ</a>
                                                    <a href="{{ url('user/gleave_data_vacation') }}" class="dropdown-item" key="t-icon-sidebar">ลาพักผ่อน</a>
                                                    <a href="{{ url('user/gleave_data_study') }}" class="dropdown-item" key="t-boxed-width">ลาศึกษา ฝึกอบรม</a>
                                                    <a href="{{ url('user/gleave_data_work') }}" class="dropdown-item" key="t-preloader">ลาทำงานต่างประเทศ</a>
                                                    <a href="{{ url('user/gleave_data_occupation') }}" class="dropdown-item" key="t-colored-sidebar">ลาฟื้นฟูอาชีพ</a>
                                                    <a href="{{ url('user/gleave_data_soldier') }}" class="dropdown-item" key="t-boxed-width">ลาเกณฑ์ทหาร</a>
                                                    <a href="{{ url('user/gleave_data_helpmaternity') }}" class="dropdown-item" key="t-boxed-width">ลาช่วยภริยาคลอด</a>
                                                    <a href="{{ url('user/gleave_data_maternity') }}" class="dropdown-item" key="t-boxed-width">ลาคลอดบุตร</a>
                                                    <a href="{{ url('user/gleave_data_spouse') }}" class="dropdown-item" key="t-boxed-width">ลาติดตามคู่สมรส</a>
                                                </div>
                                            </div>
    
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">ประชุม/อบรม/ดูงาน</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{ url('user/persondev_index/'. Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">ประชุมภายนอก</a>
                                                    <a href="{{ url('user/persondev_inside/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ประชุมภายใน</a>                                                    
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">บ้านพัก</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{ url('user/house_detail/'. Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">ข้อมูลบ้านพัก</a>
                                                    <a href="{{ url('user/house_petition/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ยื่นคำร้อง</a>   
                                                    <a href="{{ url('user/house_problem/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">แจ้งปัญหา</a>                                                   
                                                </div>
                                            </div>
 
                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                            <i class="ri-layout-3-line me-2"></i><span key="t-layouts">งานบริหารทั่วไป</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                             
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">สารบรรณ</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{ url('user/book_inside/'. Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">หนังสือเข้า</a>
                                                    <a href="{{ url('user/book_send/'. Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">หนังสือส่ง</a>                                                    
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">ห้องประชุม</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{ url('user_meetting/meetting_calenda') }}" class="dropdown-item" key="t-horizontal">ปฎิทินการใช้ห้องประชุม</a>
                                                    <a href="{{url('user_meetting/meetting_index')}}" class="dropdown-item" key="t-topbar-light">ช้อมูลการจองห้องประชุม</a>                                                    
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">แจ้งซ่อม</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{ url('user_com/com_calenda') }}" class="dropdown-item" key="t-horizontal">ปฎิทินการแจ้งซ่อม</a>
                                                    <a href="{{url('user_com/repair_com')}}" class="dropdown-item" key="t-topbar-light">ทะเบียนซ่อมคอมพิวเตอร์</a>  
                                                    <a href="{{url('user_com/repair_com_add')}}" class="dropdown-item" key="t-topbar-light">แจ้งซ่อมคอมพิวเตอร์</a>                                                   
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">งานทรัพย์สิน</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{url('user/article_index/'.Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">ทะเบียนทรัพย์สิน</a>
                                                    <a href="{{url('user/article_borrow/'.Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ทะเบียนยืม</a>  
                                                    <a href="{{url('user/article_return/'.Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ทะเบียนคืน</a>                                                   
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">งานพัสดุ</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{url('user/supplies_data/'.Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">รายการจัดซื้อ-จัดจ้าง</a>
                                                    <a href="{{url('user/supplies_data_add/'.Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ขอจัดซื้อ-จัดจ้าง</a>                                               
                                                </div>
                                            </div>

                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">คลังวัสดุ</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{url('user/warehouse_deb_sub_sub/'.Auth::user()->id)}}" class="dropdown-item" key="t-horizontal">รายการคลังวัสดุ</a>
                                                    <a href="{{url('user/warehouse_main_request/'.Auth::user()->id)}}" class="dropdown-item" key="t-topbar-light">ขอเบิกคลังวัสดุ</a>                                               
                                                </div>
                                            </div>

                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                            <i class="ri-layout-3-line me-2"></i><span key="t-layouts">รายงาน</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                                    role="button">
                                                    <span key="t-vertical">REFER</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                                    <a href="{{ url('report_refer_main') }}" class="dropdown-item" key="t-dark-sidebar">การลงข้อมูล REFER</a>
                                                    <a href="{{ url('report_refer_main_repback') }}" class="dropdown-item" key="t-compact-sidebar">การลงข้อมูลรับกลับ REFER</a>
                                                    <a href="{{ url('report_refer_main_rep') }}" class="dropdown-item" key="t-icon-sidebar">การลงข้อมูลรับ REFER</a>
                                                    <a href="{{ url('report_ipopd') }}" class="dropdown-item" key="t-boxed-width">Refer in จากสถานพยาบาลอื่น แยกตาม OPD,IPD</a>
                                                    <a href="{{ url('report_refer_out') }}" class="dropdown-item" key="t-preloader">Refer out ทะเบียนผู้ป่วยส่งต่อทั้งหมด</a>
                                                    <a href="{{ url('report_refer_outipd') }}" class="dropdown-item" key="t-colored-sidebar">Refer out ทะเบียนผู้ป่วยส่งต่อประเภท IPD</a>
                                                    <a href="{{ url('report_refer_outopd') }}" class="dropdown-item" key="t-boxed-width">Refer out ทะเบียนผู้ป่วยส่งต่อประเภท OPD</a>
                                                    <a href="{{ url('report_refer_outmonth') }}" class="dropdown-item" key="t-boxed-width">Refer out สรุปการส่งต่อรายเดือนแบบเลือกสาขา</a>  
                                                </div>
                                            </div>
                                              
                                            <div class="dropdown">
                                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                                    role="button">
                                                    <span key="t-horizontal">งานจิตเวชและยาเสพติด</span> <div class="arrow-down"></div>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                                    <a href="{{ url('equipment')}}" class="dropdown-item" key="t-horizontal">อุปกรณ์</a>
                                                    <a href="{{ url('restore')}}" class="dropdown-item" key="t-topbar-light">ฟื้นฟู</a>                                                    
                                                </div>
                                            </div>
 
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Horizontal</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                                            <li class="breadcrumb-item active">Horizontal</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Total Sales</p>
                                                <h4 class="mb-2">1452</h4>
                                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from previous period</p>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-primary rounded-3">
                                                    <i class="ri-shopping-cart-2-line font-size-24"></i>  
                                                </span>
                                            </div>
                                        </div>                                            
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">New Orders</p>
                                                <h4 class="mb-2">938</h4>
                                                <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from previous period</p>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-success rounded-3">
                                                    <i class="mdi mdi-currency-usd font-size-24"></i>  
                                                </span>
                                            </div>
                                        </div>                                              
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">New Users</p>
                                                <h4 class="mb-2">8246</h4>
                                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from previous period</p>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-primary rounded-3">
                                                    <i class="ri-user-3-line font-size-24"></i>  
                                                </span>
                                            </div>
                                        </div>                                              
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate font-size-14 mb-2">Unique Visitors</p>
                                                <h4 class="mb-2">29670</h4>
                                                <p class="text-muted mb-0"><span class="text-success fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from previous period</p>
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-success rounded-3">
                                                    <i class="mdi mdi-currency-btc font-size-24"></i>  
                                                </span>
                                            </div>
                                        </div>                                              
                                    </div><!-- end cardbody -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->

                       
                        <!-- end row -->
                    </div>
                    
                </div>
                <!-- End Page-content -->
               
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                @foreach ($datadetail as $item)
                                <script>document.write(new Date().getFullYear())</script> © {{$item->orginfo_name}}.
                       
                    @endforeach 
                                
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Dekbanbanproject
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                {{-- <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6> --}}

                {{-- <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="layout-3">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

            
                </div> --}}

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
    <!-- JAVASCRIPT -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> 
    {{-- <script src="{{ asset('apkclaim/libs/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('apkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/node-waves/waves.min.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>  --}}
    {{-- <script src="{{ asset('apkclaim/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('apkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('apkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

      <!-- Buttons examples -->
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/jszip/jszip.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/pdfmake/build/pdfmake.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/pdfmake/build/vfs_fonts.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
      <script src="{{ asset('apkclaim/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
  
      <script src="{{ asset('apkclaim/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('apkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

     <!-- Datatable init js -->
     {{-- <script src="{{ asset('apkclaim/js/pages/datatables.init.js') }}"></script> --}}
     <script src="{{ asset('apkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script> 
     <script src="{{ asset('apkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>
 
 
     <script src="{{ asset('apkclaim/js/pages/form-wizard.init.js') }}"></script>
    {{-- <script src="{{ asset('apkclaim/js/pages/dashboard.init.js') }}"></script> --}}
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

    {{-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="{{ asset('apkclaim/js/app.js') }}"></script>

        @yield('footer')

        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
                $('#example4').DataTable();
                $('#example5').DataTable();
                $('#example_user').DataTable();
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
            });
    
            $(document).ready(function() {
                $('#book_saveForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    // alert('OJJJJOL');
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 200) {
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
                                        window.location =
                                            "{{ url('book/bookmake_index') }}"; // กรณี add page new  
                                    }
                                })
                            } else {
    
                            }
                        }
                    });
                });
            });
    
            $(document).ready(function() {
                $('#update_personForm').on('submit', function(e) {
                    e.preventDefault();
                    //   alert('Person');
                    var form = this;
    
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Username...!!',
                                    text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
    
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You Edit data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = "{{ url('user/home') }}"; //
                                    }
                                })
                            }
                        }
                    });
                });
            });
    
            $(document).ready(function() {
    
                $('#bookrep_import_fam').select2({
                    placeholder: "นำเข้าไว้ในแฟ้ม ",
                    allowClear: true
                });
    
                $('#bookrep_speed_class_id').select2({
                    placeholder: "ชั้นความเร็ว",
                    allowClear: true
                });
                $('#bookrep_secret_class_id').select2({
                    placeholder: "ชั้นความลับ",
                    allowClear: true
                });
                $('#bookrep_type_id').select2({
                    placeholder: "ประเภทหนังสือ",
                    allowClear: true
                });
                $('#sendperson_user_id').select2({
                    placeholder: "ชื่อ-นามสกุล",
                    allowClear: true
                });
                $('#DEPARTMENT_SUB_ID').select2({
                    placeholder: "ฝ่าย/แผนก",
                    allowClear: true
                });
                $('#dep').select2({
                    placeholder: "กลุ่มงาน",
                    allowClear: true
                });
                $('#depsub').select2({
                    placeholder: "ฝ่าย/แผนก",
                    allowClear: true
                });
                $('#depsubsub').select2({
                    placeholder: "หน่วยงาน",
                    allowClear: true
                });
                $('#team').select2({
                    placeholder: "ทีมนำองค์กร",
                    allowClear: true
                });
                $('#depsubsubtrue').select2({
                    placeholder: "หน่วยงานที่ปฎิบัติจริง",
                    allowClear: true
                });
                $('#book_objective').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective2').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective3').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective4').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#book_objective5').select2({
                    placeholder: "วัตถุประสงค์",
                    allowClear: true
                });
                $('#org_team_id').select2({
                    placeholder: "ทีมนำองค์กร",
                    allowClear: true
                });
                $('#com_repaire_speed').select2({
                    placeholder: "ความเร่งด่วน",
                    allowClear: true
                });
                $('#com_repaire_year').select2({
                    placeholder: "ปีงบประมาณ",
                    allowClear: true
                });
    
    
    
            });
        </script>
    </body>
</html>
