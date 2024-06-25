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
    <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
  
   

    {{-- <link href="{{ asset('pkclaim/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('pkclaim/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('pkclaim/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('pkclaim/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('pkclaim/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('pkclaim/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('pkclaim/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
   <!-- select2 -->
    <link rel="stylesheet" href="{{asset('asset/js/plugins/select2/css/select2.min.css')}}">
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   

</head>
<style> 
    *{
        margin: 0;
        padding: 0;
    }
    .headerZ{
        z-index: 1;
        background:linear-gradient(-45deg,red,rgb(201, 241, 154),rgb(184, 230, 226),rgb(238, 238, 107));
        background-size: 400% 400%;
        width: 100%;
        height: 100vh;
        animation: animate 5s ease infinite;
    }
    @keyframes animate{
        0%{
            background-position: 0 50%;
        }
        50%{
            background-position: 100% 50%;
        }
        0%{
            background-position: 0 50%;
        }
    } 
    /* .myTable thead tr{
    background-color: #6e6d6e;
    color: #ffffff;
    text-align: center;
    }
    .myTable th .myTable td{
        padding: 12px 15px;
    }
    .myTable tbody tr{
        border-bottom: 1px solid #6e6d6e;
    }
    .myTable tbody td{
        font-size:15px;
    }
    .myTable tbody tr:nth-of-type(even){
        background-color: #f4e1f7;
    }
    .myTable tbody tr:last-of-type{
        border-bottom: 3px solid #ccbcd1;
    }
    .myTable tbody tr .active-row{
        color: #ccbcd1;
    } */
</style>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Loader -->
    {{-- <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div> --}}

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header" style="background-color: rgb(102, 99, 99)">
                

                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="" class="logo logo-light">
                            <span class="logo-sm"> 
                                <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm-light" height="40">
                            </span>
                            <span class="logo-lg">
                                <h4 style="color:rgb(255, 255, 255)" class="mt-4">PK-OFFICER</h4> 
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                    <?php  
                        $org = DB::connection('mysql')->select(                                                            '   
                                select * from orginfo 
                                where orginfo_id = 1                                                                                                                      ',
                        ); 
                    ?>
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            @foreach ($org as $item)
                            <h4 style="color:rgb(255, 255, 255)" class="mt-2">{{$item->orginfo_name}}</h4>
                            @endforeach
                            
                        </div>
                    </form>                                         
                </div>



                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(255, 255, 255)"></i>
                        </button>
                    </div>
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="modal" data-bs-target="#Keypassword"> 
                            <i class="fa-solid fa-key" style="color: rgb(255, 255, 255)"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->img == null)
                                <img src="{{ asset('assets/images/default-image.jpg') }}" height="32px"
                                    width="32px" alt="Header Avatar" class="rounded-circle header-profile-user">
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
                                    class="ri-shut-down-line align-middle me-1 text-danger"></i>
                                Logout
                            </a>
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
                        <li class="menu-title">งานบริหารบุคคล</li> 
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect"> 
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>ข้อมูลการลา</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user/gleave_data_sick') }}">ลาป่วย</a></li>  
                                <li><a href="{{ url('user/gleave_data_vacation') }}">ลาพักผ่อน</a></li> 
                                <li><a href="{{ url('user/gleave_data_study') }}">ลาศึกษา ฝึกอบรม</a></li> 
                                <li><a href="{{ url('user/gleave_data_work') }}">ลาทำงานต่างประเทศ</a></li> 
                                <li><a href="{{ url('user/gleave_data_occupation') }}">ลาฟื้นฟูอาชีพ</a></li> 
                                <li><a href="{{ url('user/gleave_data_soldier') }}">ลาเกณฑ์ทหาร</a></li> 
                                <li><a href="{{ url('user/gleave_data_helpmaternity') }}">ลาช่วยภริยาคลอด</a></li> 
                                <li><a href="{{ url('user/gleave_data_maternity') }}">ลาคลอดบุตร</a></li> 
                                <li><a href="{{ url('user/gleave_data_spouse') }}">ลาติดตามคู่สมรส</a></li> 
                            </ul>
                        </li>                        
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect"> 
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>ข้อมูล OT</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user_otone') }}">บันทึก OT</a></li> 
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>ประชุม/อบรม/ดูงาน</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user/persondev_index/'.Auth::user()->id)}}">ประชุมภายนอก</a></li> 
                                <li><a href="{{ url('user/persondev_inside/'.Auth::user()->id)}}">ประชุมภายใน</a></li>     
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">   
                                <i class="fa-solid fa-house-chimney-user text-danger"></i>
                                <span>บ้านพัก</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user/house_detail/' . Auth::user()->id) }}">ข้อมูลบ้านพัก</a></li> 
                                <li><a href="{{ url('user/house_petition/' . Auth::user()->id) }}">ยื่นคำร้อง</a></li> 
                                <li><a href="{{ url('user/house_problem/' . Auth::user()->id) }}">แจ้งปัญหา</a></li>     
                            </ul>
                        </li>
                        <li class="menu-title">งานบริหารทั่วไป</li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">   
                                <i class="fa-solid fa-p text-danger"></i> 
                                <span>P4P</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('p4p_dashboarduser') }}">Dashboard</a></li> 
                                <li><a href="{{ url('p4p_user') }}">บันทึก P4P</a></li> 
                                <li><a href="{{ url('workgroupset') }}">หมวดภาระงาน</a></li> 
                                <li><a href="{{ url('workset') }}">รายการภาระงาน</a></li>    
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                <i class="fa-solid fa-book-medical text-danger"></i>
                                <span>สารบรรณ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user/book_inside/' . Auth::user()->id) }}">หนังสือเข้า</a></li>     
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                <i class="fa-solid fa-people-roof text-danger"></i>
                                <span>ห้องประชุม</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user_meetting/meetting_calenda') }}">ปฎิทินการใช้ห้องประชุม</a></li>     
                                <li><a href="{{ url('user_meetting/meetting_index') }}">ช้อมูลการจองห้องประชุม</a></li>  
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                <i class="fa-solid fa-car-side text-danger"></i>
                                <span>จองรถ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user_car/car_calenda/' . Auth::user()->id) }}">ปฎิทินการใช้รถ</a></li>     
                                <li><a href="{{ url('user_car/car_narmal/' . Auth::user()->id) }}">ช้อมูลการการใช้รถทั่วไป</a></li> 
                                <li><a href="{{ url('user_car/car_ambulance/' . Auth::user()->id) }}">ช้อมูลการการใช้รถพยาบาล</a></li>  
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">   
                                <i class="fa-solid fa-desktop text-danger"></i>
                                <span>แจ้งซ่อมคอมพิวเตอร์</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user_com/repair_com_calenda') }}">ปฎิทินการแจ้งซ่อมคอมพิวเตอร์</a></li>     
                                <li><a href="{{ url('user_com/repair_com') }}">ทะเบียนซ่อมคอมพิวเตอร์</a></li> 
                                <li><a href="{{ url('user_com/repair_com_add') }}">แจ้งซ่อมคอมพิวเตอร์</a></li>  
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">   
                                <i class="fa-solid fa-screwdriver-wrench text-danger"></i>
                                <span>แจ้งซ่อมทั่วไป</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user_com/repair_com_calenda') }}">ปฎิทินการแจ้งซ่อมทั่วไป</a></li>     
                                <li><a href="{{ url('user_com/repair_com') }}">ทะเบียนซ่อมทั่วไป</a></li> 
                                <li><a href="{{ url('user_com/repair_com_add') }}">แจ้งซ่อมทั่วไป</a></li>  
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                <i class="fa-solid fa-building-shield text-danger"></i>
                                <span>งานทรัพย์สิน</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user_article') }}">ทะเบียนทรัพย์สิน</a></li>     
                                <li><a href="{{ url('user_article_borrow') }}">ทะเบียนยืม</a></li> 
                                <li><a href="{{ url('user_article_return') }}">ทะเบียนคืน</a></li>  
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                <i class="fa-solid fa-paste text-danger"></i>
                                <span>งานพัสดุ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user/supplies_data/' . Auth::user()->id) }}">รายการจัดซื้อ-จัดจ้าง</a></li>     
                                <li><a href="{{ url('user/supplies_data_add/' . Auth::user()->id) }}">ขอจัดซื้อ-จัดจ้าง</a></li>  
                            </ul>
                        </li> 
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                <i class="fa-solid fa-shop-lock text-danger"></i>
                                <span>คลังวัสดุ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('user_ware/warehouse_stock_sub') }}">รายการคลังวัสดุ</a></li>     
                                <li><a href="{{ url('user_ware/warehouse_stock_sub_add') }}">ขอเบิกคลังวัสดุ</a></li>  
                            </ul>
                        </li>  --}}
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!--  Modal content for the Keypassword example -->
        <div class="modal fade" id="Keypassword" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">เปลี่ยนรหัสผ่าน </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"> 
                        <div class="row">                    
                            <div class="col-md-4 text-end"><label for="">รหัสผ่าน New</label></div>
                            <div class="col-md-7"> 
                                <div class="form-group text-center">
                                    <input type="password" class="form-control form-control-sm" id="password" name="password">
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group"> 
                                <button type="button" id="SaveChang" class="btn btn-outline-info btn-sm" > 
                                    <i class="fa-solid fa-floppy-disk me-1"></i>
                                    เปลี่ยน
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark me-2"></i>ปิด</button>

                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">

                @yield('content')

            </div>
            <!-- End Page-content -->

            {{-- <footer class="footer ">
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
            </footer> --}}


        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  --}}
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> 
    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}

   
    <script src="{{ asset('pkclaim/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('pkclaim/libs/select2/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js" integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Required datatable js -->
    <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Buttons examples -->
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('pkclaim/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

    <script src="{{ asset('pkclaim/libs/twitter-bootstrap-wizard/prettify.js') }}"></script>


    <script src="{{ asset('pkclaim/js/pages/form-wizard.init.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="{{ asset('pkclaim/js/app.js') }}"></script>

    @yield('footer')

    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#Workload_update').on('submit',function(e){
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
                          title: 'บันทึกข้อมูลสำเร็จ',
                          text: "You Insert data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            window.location="{{url('p4p_user')}}";
                          }
                        })      
                      }
                    }
                  });
            });

        });

        $(document).ready(function() {
            $('#SaveChang').click(function() {
                var password = $('#password').val();  
                $.ajax({
                    url: "{{ route('user.password_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: { 
                        password                       
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เปลี่ยนรหัสผ่านสำเร็จ',
                                text: "You Chang password success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                     
                                }
                            })
                        } else {
                             
                        }

                    },
                });
            });
  
        });

       
    </script>

</body>

</html>
