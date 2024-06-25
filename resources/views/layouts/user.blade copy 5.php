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
    <link rel="shortcut icon" href="{{ asset('apkclaim/images/logo150.ico') }}">

    <link href="{{ asset('apkclaim//libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('apkclaim//libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('apkclaim//libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('apkclaim//libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
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
    <link href="{{ asset('apkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('apkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('apkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"> --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


<body>
    {{-- <body data-topbar="dark"> --}}
    {{-- <body data-topbar="dark" data-sidebar="dark"> --}}
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
            <div class="navbar-header" style="background-color: rgba(9, 165, 165, 0.952)">
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

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle" style="color: rgb(255, 255, 255)"></i>
                    </button>
 
                        @foreach ($datadetail as $item)
                        <h4 style="color: white;font-size:22px;" class="ms-2 mt-4">{{$item->orginfo_name}}</h4>
                    @endforeach

                </div>

                <div class="d-flex">
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

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>
                        <li>
                            <a href="{{ url('user/home') }}" class="waves-effect">
                                <i class="ri-dashboard-line"></i> 
                                <span>Dashboard</span>
                            </a>
                        </li>
                       
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie"></i>
                                <span>ข้อมูลการลา</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{ url('user/gleave_data_sick') }}" >
                                        <span>ลาป่วย</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_leave') }}" > 
                                        <span>ลากิจ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_vacation') }}" >
                                        <span>ลาพักผ่อน</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_study') }}" >
                                        <span>ลาศึกษา ฝึกอบรม</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_work') }}" >
                                        <span>ลาทำงานต่างประเทศ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_occupation') }}" >
                                        <span>ลาฟื้นฟูอาชีพ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_soldier') }}" >
                                        <span>ลาเกณฑ์ทหาร</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_helpmaternity') }}" >
                                        <span>ลาช่วยภริยาคลอด</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_maternity') }}" >
                                        <span>ลาคลอดบุตร</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_spouse') }}" >
                                        <span>ลาติดตามคู่สมรส</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_out') }}" >
                                        <span>ลาออก</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_law') }}" >
                                        <span>ลาป่วยตามกฎหมายฯ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/gleave_data_ordination') }}" >
                                        <span>ลาอุปสมบทประกอบพิธีฮัจญ์</span>
                                    </a>
                                </li>

                            </ul>
                        </li> --}}
                       
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-handshake"></i>
                                <span>ประชุม/อบรม/ดูงาน</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{ url('user/persondev_index/'. Auth::user()->id)}}">
                                        <span>ประชุมภายนอก</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/persondev_inside/'. Auth::user()->id)}}"  > 
                                        <span>ประชุมภายใน</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li> --}}
                        
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-house-chimney-user"></i>
                                <span>บ้านพัก</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{ url('user/house_detail/'. Auth::user()->id)}}" >
                                        <span>ข้อมูลบ้านพัก</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/house_petition/'. Auth::user()->id)}}"> 
                                        <span>ยื่นคำร้อง</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/house_problem/'. Auth::user()->id)}}"> 
                                        <span>แจ้งปัญหา</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li> --}}
                   
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-book-open"></i>
                                <span>สารบรรณ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{ url('user/book_inside/'. Auth::user()->id)}}" >
                                        <span>หนังสือเข้า</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('user/book_send/'. Auth::user()->id)}}" > 
                                        <span>หนังสือส่ง</span>
                                    </a>
                                </li> 
                            </ul>
                        </li> --}}

                       
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-person-shelter"></i>
                                <span>ห้องประชุม</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{ url('user_meetting/meetting_calenda') }}" >
                                        <span>ปฎิทินการใช้ห้องประชุม</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('user_meetting/meetting_index')}}" > 
                                        <span>ช้อมูลการจองห้องประชุม</span>
                                    </a>
                                </li> 
                            </ul>
                        </li> --}}
                       
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                <span>แจ้งซ่อม</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{ url('user_com/com_calenda') }}" >
                                        <span>ปฎิทินการแจ้งซ่อม</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('user_com/repair_com')}}" > 
                                        <span>ทะเบียนซ่อมคอมพิวเตอร์</span>
                                    </a>
                                </li> 
                                <li>
                                    <a href="{{url('user_com/repair_com_add')}}" > 
                                        <span>แจ้งซ่อมคอมพิวเตอร์</span>
                                    </a>
                                </li> 
                            </ul>
                        </li>
                        
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-building-shield"></i>
                                <span>งานทรัพย์สิน</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{url('user/article_index/'.Auth::user()->id)}}" >
                                        <span>ทะเบียนทรัพย์สิน</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('user/article_borrow/'.Auth::user()->id)}}" > 
                                        <span>ทะเบียนยืม</span>
                                    </a>
                                </li> 
                                <li>
                                    <a href="{{url('user/article_return/'.Auth::user()->id)}}" > 
                                        <span>ทะเบียนคืน</span>
                                    </a>
                                </li> 
                            </ul>
                        </li> --}}
                       
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-paste"></i>
                                <span>งานพัสดุ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{url('user/supplies_data/'.Auth::user()->id)}}" >
                                        <span>รายการจัดซื้อ-จัดจ้าง</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('user/supplies_data_add/'.Auth::user()->id)}}" > 
                                        <span>ขอจัดซื้อ-จัดจ้าง</span>
                                    </a>
                                </li> 
                                 
                            </ul>
                        </li> --}}
                       
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-shop-lock"></i>
                                <span>คลังวัสดุ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="{{url('user/warehouse_deb_sub_sub/'.Auth::user()->id)}}" >
                                        <span>รายการคลังวัสดุ</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('user/warehouse_main_request/'.Auth::user()->id)}}" > 
                                        <span>ขอเบิกคลังวัสดุ</span>
                                    </a>
                                </li> 
                                 
                            </ul>
                        </li> --}}

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-car-side"></i>
                                <span>การบันทึกข้อมูล OPD</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                {{-- <li>
                                    <a href="{{ url('user_car/car_calenda/'. Auth::user()->id) }}" class="waves-effect"> 
                                        <span>ปฎิทินการใช้รถ</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="waves-effect"> 
                                        <span>รถทั่วไป</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="waves-effect"> 
                                        <span>รถพยาบาล</span>
                                    </a>
                                </li> --}}
                                <?php 
                                    $date = date('Y-m-d');
                                    // $y = date('Y') + 543; 
                                    $y = date('Y');
                                    $newDate = date('Y-m-d', strtotime($y . ' -60 months')); // 1 ปี 
                                    $buget = DB::table('budget_year')->where('DATE_BEGIN', '>', $newDate)->get();
                                ?>
                                <li>
                                    @foreach ($buget as $item)
                                    <a href="{{ url('report_refer_opd/'.$item->leave_year_id) }}" >
                                        <span> ปี {{$item->leave_year_id}}</span>
                                    </a>
                                    @endforeach
                                    
                                </li>
                          
                               
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-car-side"></i>
                                <span>การบันทึกข้อมูล REFER</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                             
                          
                                <li>
                                    <a href="{{ url('report_refer_main') }}" >                                       
                                        <span> <label for="" style="color:red">**</label>การลงข้อมูล REFER</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('report_refer_main_repback') }}" class="waves-effect"> 
                                        <span>การลงข้อมูลรับกลับ REFER</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('report_refer_main_rep') }}" class="waves-effect"> 
                                        <span>การลงข้อมูลรับ REFER</span>
                                    </a>
                                </li>
                               
                                <li>
                                    <a href="{{ url('report_ipopd') }}" class="waves-effect"> 
                                        <span>Refer in จากสถานพยาบาลอื่น แยกตาม OPD,IPD</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('report_refer_out') }}" class="waves-effect"> 
                                        <span>Refer out ทะเบียนผู้ป่วยส่งต่อทั้งหมด</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('report_refer_outipd') }}" class="waves-effect"> 
                                        <span>Refer out ทะเบียนผู้ป่วยส่งต่อประเภท IPD</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('report_refer_outopd') }}" class="waves-effect"> 
                                        <span>Refer out ทะเบียนผู้ป่วยส่งต่อประเภท OPD</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('report_refer_outmonth') }}" class="waves-effect"> 
                                        <span> Refer out สรุปการส่งต่อรายเดือนแบบเลือกสาขา</span>
                                    </a>
                                </li> 
                            </ul>
                        </li>
                       
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-people-robbery"></i>
                                <span>งานจิตเวชและยาเสพติด</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a >
                                        {{-- <a href="{{url('equipment')}}" > --}}
                                        <span>อุปกรณ์</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('restore')}}" > 
                                        <span>ฟื้นฟู</span>
                                    </a>
                                </li> 
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
                                Created with <i class="mdi mdi-heart text-danger"></i> by งานประกัน
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
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> 
    {{-- <script src="{{ asset('apkclaim/libs/jquery/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('apkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('apkclaim/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('apkclaim/libs/select2/js/select2.min.js') }}"></script>
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

    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
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
