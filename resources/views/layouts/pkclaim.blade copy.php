<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title')</title>
    
     <!-- Font Awesome -->
     <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="{{ asset('apkclaim/images/favicon.ico') }}"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('apkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('apkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('apkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('apkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
   
</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

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

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href=" " class="logo logo-dark">
                            {{-- <span class="logo-sm">
                                    <img src="apkclaim/images/logo-sm.png" alt="logo-sm" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="apkclaim/images/logo-dark.png" alt="logo-dark" height="20">
                                </span> --}}
                        </a>

                        <a href=" " class="logo logo-light">
                            <span class="logo-sm"> 
                                <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light" height="40">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('apkclaim/images/logo150.png') }}" alt="logo-sm-light" height="40">
                                <label for="" style="color: white;font-size:25px;"
                                    class="ms-2">PKClaim</label>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                    {{-- <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        Mega Menu
                        <i class="mdi mdi-chevron-down"></i> 
                    </button> --}}
                    {{-- <a class="btn header-item waves-effect mt-3" href="{{url('bar')}}"><label for="" style="color: white">Dashboard</label></a> --}}
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block me-4">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- <i class="ri-notification-3-line"></i> --}}
                            <i class="fa-solid fa-right-from-bracket"></i>
                            {{-- <span class="noti-dot"></span> --}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2">
                               
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="{{ route('logout') }}" class="text-reset notification-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-danger rounded-circle font-size-16">
                                                <i class="fa-solid fa-right-from-bracket "></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Logout</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">ออกจากระบบ</p> 
                                            </div>
                                        </div>
                                    </div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </a>
 
                            </div>
                            <div class="p-2 border-top">
                                 
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block user-dropdown">
                        
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!-- User details -->
                <div class="user-profile text-center mt-3">
                    <div class="">                       
                        @if (Auth::user()->img == null)
                        <img src="{{ asset('assets/images/default-image.jpg') }}" height="32px"
                            width="32px" alt="Image" class="avatar-md rounded-circle">                                    
                    @else
                        <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="32px"
                            width="32px" alt="Image" class="avatar-md rounded-circle">
                    @endif
                    </div>
                    <div class="mt-3">
                        <h4 class="font-size-16 mb-1">
                            {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                        </h4>
                        <span class="text-muted"><i
                                class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
                    </div>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="{{url('admin/home')}}" class="waves-effect">
                                <i class="ri-dashboard-line"></i><span
                                    class="badge rounded-pill bg-success float-end">3</span>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        {{-- <li>
                            <a href="calendar.html" class=" waves-effect">
                                <i class="ri-calendar-2-line"></i>
                                <span>รายงานแยกปีงบ</span>
                            </a>
                        </li> --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-line text-primary"></i>
                                <span>รายงานแยกปีงบ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{url('report_op')}}">ผู้ป่วย OPD Visit</a></li>
                                <li><a href="{{url('report_ipd')}}">ผู้ป่วย IPD Visit</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">รายงาน OFC แยกปีงบ</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{url('report_opd_ofc')}}">ผู้ป่วย OPD OFC</a></li>
                                        <li><a href="{{url('report_ipd_ofc')}}">ผู้ป่วย IPD OFC</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">รายงาน LGO แยกปีงบ</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ผู้ป่วย OPD LGO</a></li>
                                        <li><a href="javascript: void(0);">ผู้ป่วย IPD LGO</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">รายงาน BKK แยกปีงบ</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ผู้ป่วย OPD BKK</a></li>
                                        <li><a href="javascript: void(0);">ผู้ป่วย IPD BKK</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect"> 
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>ข้าราชการจ่ายตรง</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Flow</a></li>
                                <li><a href="javascript: void(0);">ตรวจสอบสิทธิ</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul>
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">OPD</a></li>
                                        <li><a href="javascript: void(0);">IPD</a></li>
                                        <li><a href="javascript: void(0);">Admin</a></li>
                                        <li><a href="javascript: void(0);">ข้าราชการไต</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-warning"></i>
                                <span>ข้าราชการท้องถิ่นจ่ายตรง</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Flow</a></li>
                                <li><a href="javascript: void(0);">ตรวจสอบสิทธิ</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul>
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">OPD</a></li>
                                        <li><a href="javascript: void(0);">IPD</a></li>
                                        <li><a href="javascript: void(0);">Admin</a></li>
                                        <li><a href="javascript: void(0);">ข้าราชการไต</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-success"></i>
                                <span>ข้าราชการ กทม.</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Flow</a></li>
                                <li><a href="javascript: void(0);">ตรวจสอบสิทธิ</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul>
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">OPD</a></li>
                                        <li><a href="javascript: void(0);">IPD</a></li>
                                        <li><a href="javascript: void(0);">Admin</a></li>
                                        <li><a href="javascript: void(0);">ข้าราชการไต</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-warning"></i>
                                <span>บัตรทอง</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">                                
                                <li><a href="javascript: void(0);">ตรวจสอบสิทธิ</a></li>
                                <li><a href="javascript: void(0);">ลบ 16 แฟ้ม</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul>
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">OPD</a></li>
                                        <li><a href="javascript: void(0);">OPD Rabie</a></li>
                                        <li><a href="javascript: void(0);">OPD Colorstomy bag</a></li>
                                        <li><a href="javascript: void(0);">OPD Clopidogel(พลาวิกซ์)</a></li>
                                        <li><a href="javascript: void(0);">Admin</a></li>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-secondary"></i>
                                <span>ประกันสังคม</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true"> 
                                <li><a href="{{url('sss_in')}}">การวินิจฉัยว่างเฉพาะในเขต</a></li>                               
                                {{-- <li><a href="javascript: void(0);">เบิกค่ารถ Refer</a></li>
                                <li><a href="javascript: void(0);">Flow</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul>
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">OPD ชัยภูมิ</a></li>
                                        <li><a href="javascript: void(0);">OPD ชัยภูมิ อุปกรณ์</a></li>
                                        <li><a href="javascript: void(0);">IPD ชัยภูมิ</a></li>
                                        <li><a href="javascript: void(0);">OPD นอกเขต</a></li>
                                        <li><a href="javascript: void(0);">IPD นอกเขต</a></li>
                                        
                                    </ul>
                                </li> --}}
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-regular fa-address-book text-success"></i>
                                <span>พรบ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">    
                                <li><a href="javascript: void(0);">Flow</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    {{-- <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul> --}}
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">คปภ</a></li>
                                        <li><a href="javascript: void(0);">OPD </a></li>
                                        <li><a href="javascript: void(0);">IPD  </a></li>
                                        <li><a href="javascript: void(0);">เฝ้าระวัง ติดตาม</a></li>
                                        <li><a href="javascript: void(0);">RVP</a></li>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-truck-medical text-warning"></i>
                                <span>Refer</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">    
                                <li><a href="javascript: void(0);">ตรวจสอบสิทธิ์</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    {{-- <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul> --}}
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="javascript: void(0);">OPD </a></li>                                         
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-person-rays text-danger"></i>
                                <span>ต่างด้าว</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">    
                                <li><a href="javascript: void(0);">Flow</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">การบันทึกข้อมูล</a>
                                    {{-- <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">ทำรายงาน</a></li>
                                        <li><a href="javascript: void(0);">การขอ Claim Code</a></li>
                                        <li><a href="javascript: void(0);">โอนข้อมูล 16 แฟ้ม</a></li>
                                        <li><a href="javascript: void(0);">การทำคำขอเบิก</a></li>
                                    </ul> --}}
                                </li>
                                
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติ รายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="javascript: void(0);">ONE STOP </a></li>    
                                        <li><a href="javascript: void(0);">OPD </a></li>  
                                        <li><a href="javascript: void(0);">IPD </a></li>                                       
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-secondary"></i>
                                <span>ประกันสังคม 10 กรณี</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">    
                                <li><a href="javascript: void(0);">2561</a></li>
                                <li><a href="javascript: void(0);">2562</a></li>
                                <li><a href="javascript: void(0);">2563</a></li>
                                <li><a href="javascript: void(0);">2564</a></li>
                                <li><a href="javascript: void(0);">2565</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-virus-covid text-primary"></i>
                                <span>Covid 19</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">     
                                <li><a href="javascript: void(0);">2563</a></li>
                                <li><a href="javascript: void(0);">2564</a></li>
                                <li><a href="javascript: void(0);">2565</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect"> 
                                <i class="fa-solid fa-capsules text-primary"></i>
                                <span>ยา ไปรษณีย์</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">     
                                <li><a href="javascript: void(0);">2563</a></li>
                                <li><a href="javascript: void(0);">2564</a></li>
                                <li><a href="javascript: void(0);">2565</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-person-circle-check text-warning"></i>
                                <span>เงื่อนไขพิเศษเขต 9</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">     
                                <li><a href="javascript: void(0);">2563</a></li>
                                <li><a href="javascript: void(0);">2564</a></li>
                                <li><a href="javascript: void(0);">2565</a></li>
                            </ul>
                        </li>


                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                @yield('content')

            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © โรงพยาบาลภูเขียวเฉลิมพระเกียรติ
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Created with <i class="mdi mdi-heart text-danger"></i> by PKClaim
                            </div>
                        </div>
                    </div>
                </div>
            </footer>


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

  

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('apkclaim/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/node-waves/waves.min.js') }}"></script>

   

    <!-- jquery.vectormap map -->
    <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('apkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('apkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    {{-- <script src="{{ asset('apkclaim/js/pages/dashboard.init.js') }}"></script> --}}
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="{{ asset('apkclaim/js/app.js') }}"></script>

    @yield('footer')

    {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}

    <!-- Bar Google chart-->
   {{-- <script type="text/javascript">
       google.charts.load('current', {
           'packages': ['corechart']
       });
       google.charts.setOnLoadCallback(drawVisualization);

       function drawVisualization() {
           // Some raw data (not necessarily accurate)
           var data = google.visualization.arrayToDataTable([
               ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
               ['2004/05', 165, 938, 522, 998, 450, 614.6],
               ['2005/06', 135, 1120, 599, 1268, 288, 682],
               ['2006/07', 157, 1167, 587, 807, 397, 623],
               ['2007/08', 139, 1110, 615, 968, 215, 609.4],
               ['2008/09', 136, 691, 629, 1026, 366, 569.6]
           ]);

           var options = {
               title: 'Monthly Coffee Production by Country',
               vAxis: {
                   title: 'Cups'
               },
               hAxis: {
                   title: 'Month'
               },
               seriesType: 'bars',
               series: {
                   5: {
                       type: 'line'
                   }
               }
           };

           var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
           chart.draw(data, options);
       }
   </script> --}}

   <!-- Bubble Google chart-->
   {{-- <script type="text/javascript">
       google.charts.load('current', {
           'packages': ['corechart']
       });
       google.charts.setOnLoadCallback(drawSeriesChart);

       function drawSeriesChart() {

           var data = google.visualization.arrayToDataTable([
               ['ID', 'Life Expectancy', 'Fertility Rate', 'Region', 'Population'],
               ['CAN', 80.66, 1.67, 'North America', 33739900],
               ['DEU', 79.84, 1.36, 'Europe', 81902307],
               ['DNK', 78.6, 1.84, 'Europe', 5523095],
               ['EGY', 72.73, 2.78, 'Middle East', 79716203],
               ['GBR', 80.05, 2, 'Europe', 61801570],
               ['IRN', 72.49, 1.7, 'Middle East', 73137148],
               ['IRQ', 68.09, 4.77, 'Middle East', 31090763],
               ['ISR', 81.55, 2.96, 'Middle East', 7485600],
               ['RUS', 68.6, 1.54, 'Europe', 141850000],
               ['USA', 78.09, 2.05, 'North America', 307007000]
           ]);

           var options = {
               title: 'Fertility rate vs life expectancy in selected countries (2010).' +
                   ' X=Life Expectancy, Y=Fertility, Bubble size=Population, Bubble color=Region',
               hAxis: {
                   title: 'Life Expectancy'
               },
               vAxis: {
                   title: 'Fertility Rate'
               },
               bubble: {
                   textStyle: {
                       fontSize: 11
                   }
               }
           };

           var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
           chart.draw(data, options);
       }
   </script> --}}

<script type="text/javascript">

        $(document).ready(function () {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            $('#example_user').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

        $(document).ready(function(){
              $('#insert_depForm').on('submit',function(e){
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
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('setting/setting_index')}}";
                                }
                              })      
                            }
                          }
                    });
              });

              $('#update_depForm').on('submit',function(e){
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
                              if (data.status == 0 ) {
                                
                              } else {          
                                Swal.fire({
                                  title: 'แก้ไขข้อมูลสำเร็จ',
                                  text: "You edit data success",
                                  icon: 'success',
                                  showCancelButton: false,
                                  confirmButtonColor: '#06D177', 
                                  confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                  if (result.isConfirmed) {                  
                                    window.location="{{url('setting/setting_index')}}";
                                  }
                                })      
                              }
                            }
                      });
              });
        });

        $(document).ready(function(){
              $('#insert_depsubForm').on('submit',function(e){
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
                            if (data.status == 0 ) {
                              
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('setting/depsub_index')}}";
                                }
                              })      
                            }
                          }
                    });
              });

              $('#update_depsubForm').on('submit',function(e){
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
                              if (data.status == 0 ) {
                                
                              } else {          
                                Swal.fire({
                                  title: 'แก้ไขข้อมูลสำเร็จ',
                                  text: "You edit data success",
                                  icon: 'success',
                                  showCancelButton: false,
                                  confirmButtonColor: '#06D177', 
                                  confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                  if (result.isConfirmed) {                  
                                    window.location="{{url('setting/depsub_index')}}";
                                  }
                                })      
                              }
                            }
                      });
              });
        });

        $(document).ready(function(){
              $('#insert_depsubsubForm').on('submit',function(e){
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
                            if (data.status == 0 ) {
                              
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('setting/depsubsub_index')}}";
                                }
                              })      
                            }
                          }
                    });
              });

              $('#update_depsubsubForm').on('submit',function(e){
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
                              if (data.status == 0 ) {
                                
                              } else {          
                                Swal.fire({
                                  title: 'แก้ไขข้อมูลสำเร็จ',
                                  text: "You edit data success",
                                  icon: 'success',
                                  showCancelButton: false,
                                  confirmButtonColor: '#06D177', 
                                  confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                  if (result.isConfirmed) {                  
                                    window.location="{{url('setting/depsubsub_index')}}";
                                  }
                                })      
                              }
                            }
                      });
              });
        });

        $(document).ready(function(){
              $('#insert_leaderForm').on('submit',function(e){
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
                            if (data.status == 0 ) {
                              
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('setting/leader')}}";
                                }
                              })      
                            }
                          }
                    });
              });

              $('#insert_leader2Form').on('submit',function(e){
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
                            if (data.status == 0 ) {
                              
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {   
                                  window.location.reload();                
                                  
                                }
                              })      
                            }
                          }
                    });
              });

              $('#insert_leadersubForm').on('submit',function(e){
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
                            if (data.status == 0 ) {
                              
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {  
                                  window.location.reload();                 
                                  // window.location="{{url('setting/leader')}}";
                                }
                              })      
                            }
                          }
                    });
              });
              
        });

        $(document).ready(function(){    
                $('#LEADER_ID').select2({
                    placeholder:"หัวหน้ากลุ่มงาน",
                    allowClear:true
                });
                $('#LEADER_ID2').select2({
                    placeholder:"หัวหน้าฝ่าย/แผนก",
                    allowClear:true
                });
                $('#DEPARTMENT_ID').select2({
                    placeholder:"กลุ่มงาน",
                    allowClear:true
                });
                $('#LEADER_ID3').select2({
                    placeholder:"หัวหน้าหน่วยงาน",
                    allowClear:true
                });
                $('#LEADER_ID4').select2({
                    placeholder:"ผู้อนุมัติเห็นชอบ",
                    allowClear:true
                });
                $('#USER_ID').select2({
                    placeholder:"ผู้ถูกเห็นชอบ",
                    allowClear:true
                });
                $('#DEPARTMENT_SUB_ID').select2({
                    placeholder:"ฝ่าย/แผนก",
                    allowClear:true
                }); 
                $('#orginfo_manage_id').select2({
                    placeholder:"--เลือก--",
                    allowClear:true
                });
                $('#orginfo_po_id').select2({
                  placeholder:"--เลือก--",
                    allowClear:true
                });               
        });

        $(document).on('click','.edit_line',function(){
                var line_token_id = $(this).val();
                // alert(line_token_id);
                        $('#linetokenModal').modal('show');
                        $.ajax({
                        type: "GET",
                        url:"{{url('setting/line_token_edit')}}" +'/'+ line_token_id,  
                        success: function(data) {
                            console.log(data.line_token.line_token_name);
                            $('#line_token_name').val(data.line_token.line_token_name)  
                            $('#line_token_code').val(data.line_token.line_token_code) 
                            $('#line_token_id').val(data.line_token.line_token_id)                
                        },      
                });
        });

        $(document).ready(function(){ 
            $('#insert_lineForm').on('submit',function(e){
                e.preventDefault();

                var form = this;
              //   alert('OJJJJOL');
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
                        text: "You Update data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177', 
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                          window.location.reload(); 
                        }
                      })      
                    }
                  }
                });
            });

            $('#insert_permissForm').on('submit',function(e){
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
                            if (data.status == 0 ) {
                              
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('setting/permiss')}}";
                                }
                              })      
                            }
                          }
                    });
            });
            $('#update_infoorgForm').on('submit',function(e){
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
                          if (data.status == 0 ) {
                            
                          } else {          
                            Swal.fire({
                              title: 'บันทึกข้อมูลสำเร็จ',
                              text: "You Insert data success",
                              icon: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#06D177', 
                              confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                              if (result.isConfirmed) {                  
                                window.location.reload(); 
                              }
                            })      
                          }
                        }
                  });
            });
        });
    
</script>

</body>

</html>
