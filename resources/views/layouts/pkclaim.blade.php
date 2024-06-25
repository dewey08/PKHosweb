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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



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
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/select2/css/select2.min.css') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet"
        href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/dacccss.css') }}"> --}}
    {{-- <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet"> --}}
    <!-- Plugins css -->
    {{-- <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" /> --}}
     <!-- Responsive datatable examples -->
     {{-- <link href="{{ asset('css/timepicker.less') }}" rel="stylesheet" type="text/css" /> --}}
</head>
<style>
    body {
        /* background: */
        /* url(/pkbackoffice/public/images/bg7.png);  */
        /* -webkit-background-size: cover; */
        background-color: rgb(245, 240, 240);
        background-repeat: no-repeat;
        background-attachment: fixed;
        /* background-size: cover; */
        background-size: 100% 100%;
        /* display: flex; */
        /* align-items: center; */
        /* justify-content: center; */
        /* width: 100vw;   ให้เต็มพอดี */
        /* height: 100vh; ให้เต็มพอดี  */
    }

    .Bgsidebar {
        background-image: url('/pkbackoffice/public/images/bgside.jpg');
        background-repeat: no-repeat;
    }

    .Bgheader {
        background-image: url('/pkbackoffice/public/images/bgheader.jpg');
        background-repeat: no-repeat;
    }
    .myTable tbody tr{
        font-size:13px;
        height: 13px;
    }
    .cardclaim{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 10px rgb(252, 161, 119);
        border:solid 1px #fd8086;
        /* box-shadow: 0 0 10px rgb(247, 198, 176); */
    } 
    .dcheckbox{         
        width: 20px;
        height: 20px;       
        /* border-radius: 2em 2em 2em 2em; */
        border: 10px solid pink;
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 10px pink;
        /* box-shadow: 0 0 10px teal; */
    }
    .card_pink{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px pink;
    }
    .card_audit_2b{
        border-radius: 0em 0em 3em 3em;
        box-shadow: 0 0 10px rgb(250, 128, 124);
    }
    .card_audit_4c{
        border-radius: 2em 2em 2em 2em;
        box-shadow: 0 0 10px rgb(250, 128, 124);
        border:solid 1px #80acfd;
    }
    .card_audit_4{
        border-radius: 3em 3em 3em 3em;
        box-shadow: 0 0 10px rgb(250, 128, 124);
    }
    .dcheckbox_{         
        width: 20px;
        height: 20px;       
        /* border-radius: 2em 2em 2em 2em; */
        border: 10px solid rgb(250, 128, 124);
        /* color: teal; */
        /* border-color: teal; */
        box-shadow: 0 0 10px rgb(250, 128, 124);
        /* box-shadow: 0 0 10px teal; */
    }
</style>

<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    } 
</script>
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

<body data-topbar="dark">
    {{-- <body data-sidebar="white" data-keep-enlarged="true" class="vertical-collpsed"> --}}
        {{-- <body data-sidebar="white" data-keep-enlarged="true" class="vertical-collpsed"> --}}
    {{-- <body style="background-image: url('my_bg.jpg');"> --}}
    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            {{-- <div class="navbar-header shadow-lg" style="background-color: rgb(252, 252, 252)"> --}}
            <div class="navbar-header shadow" style="background-color: rgba(247, 198, 176)">

                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box" style="background-color: rgb(255, 255, 255)">
                        <a href="" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm" height="37">
                            </span>
                            <span class="logo-lg">
                                {{-- <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" height="20"> --}}
                                <h4 style="color:rgba(247, 217, 217, 0.781)" class="mt-4">PK-OFFICER</h4>
                            </span>
                        </a>

                        <a href="" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm-light"
                                    height="40">
                            </span>
                            <span class="logo-lg">
                                <h4 style="color:rgba(247, 198, 176)" class="mt-4">PK-OFFICER</h4>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle" style="color: rgb(255, 255, 255)"></i>
                    </button>
                    <h4 style="color:rgb(255, 255, 255)" class="mt-4">CLAIM CENTER</h4>
                    <?php
                    $org = DB::connection('mysql')->select('   
                                                    select * from orginfo 
                                                    where orginfo_id = 1                                                                                                                      ');
                    ?>
                    {{-- <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            @foreach ($org as $item)
                            <h4 style="color:rgb(255, 255, 255)" class="mt-2">{{$item->orginfo_name}}</h4>
                            @endforeach
                            
                        </div>
                    </form>                                          --}}
                </div>

                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(54, 53, 53)"></i>
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
                            <span class="d-none d-xl-inline-block ms-1" style="font-size: 12px;color:black">
                                {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                            </span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ url('profile_edit/' . Auth::user()->id) }}"
                                style="font-size: 12px"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" {{-- class="text-reset notification-item" --}}
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="ri-shut-down-line align-middle me-1 text-danger"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        {{-- <style>
            .nom6{ 
                background: linear-gradient(to right,#ffafbd);
              
            }
        </style> --}}

        <!-- ========== Left Sidebar Start ========== -->
        {{-- <div class="vertical-menu "> --}}
        <div class="vertical-menu">
            {{-- <div class="vertical-menu" style="background-color: rgb(128, 216, 209)"> --}}
            <div data-simplebar class="h-100">
                {{-- <div data-simplebar class="h-100 nom6"> --}}
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul class="metismenu list-unstyled mb-5" id="side-menu">

                        <li class="menu-title">Menu</li>
                        <li>
                            <a href="{{ url('pkclaim_info') }}">
                                <i class="fa-solid fa-gauge-high text-danger"></i>
                                <span>Dashboard</span>
                                {{-- <span style="color: white">Dashboard</span> --}}
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar text-warning"></i>
                                <span>New-Eclaim</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('check_auth') }}" target="_blank">Check User Api</a></li> 
                            </ul> 
                        </li>
                        {{-- <li>
                            <a href="{{ url('fdh_data') }}"> 
                                <i class="fa-solid fa-notes-medical text-primary"></i>
                                <span>FDH</span> 
                            </a>
                        </li> --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-column text-success"></i>
                                <span>Report STM</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('report_zero') }}">Report STM 0</a></li>
                                <li><a href="{{ url('hpv_report') }}">Report HPV</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">UCS</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('walkin_report') }}">WalkIn</a></li>
                                       
                                    </ul>
                                </li> 
                            </ul>  
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-pen text-danger"></i>
                                <span>FS EClaim</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('doc_eclaim') }}">คู่มือเคลม</a></li>
                                <li><a href="{{ url('fs_eclaim') }}">Fs Eclaim & Hos</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-invoice-dollar text-danger"></i>
                                <span>Claim</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('crrt') }}">CRRT</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">UCS</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('ucep24') }}">UCEP 24</a></li>
                                        <li><a href="{{ url('ucep24_claim') }}">UCEP 24-Claim</a></li> 
                                        <li><a href="{{ url('walkin') }}">WalkIn</a></li> 
                                    </ul>
                                </li> 
                                <li><a href="javascript: void(0);" class="has-arrow">OFC</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('ofc_401_main') }}">OFC-MAIN </a></li>
                                        <li><a href="{{ url('ofc_401') }}">OFC-401 </a></li> 
                                        {{-- <li><a href="{{ url('ofc_401_check') }}">OFC-CHECK </a></li> --}}
                                        <li><a href="{{ url('ofc_401_rep') }}">OFC-REP </a></li>
                                        <li><a href="{{ url('ofc_402') }}">OFC-402 </a></li>
                                        {{-- <li><a href="{{ url('ktb_spawn') }}">การตรวจหลังคลอด ANC</a></li> --}}
                                        {{-- <li><a href="{{ url('ktb_ferrofolic') }}">บริการยาเสริมธาตุเหล็ก </a></li> --}}
                                        {{-- <li><a href="{{ url('ktb_kids_glasses') }}">แว่นตาเด็ก </a></li> --}}
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">LGO</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('lgo_801_main') }}">LGO-MAIN </a></li> 
                                        <li><a href="{{ url('lgo_801') }}">LGO-CLAIM </a></li> 
                                        {{-- <li><a href="{{ url('lgo_801_check') }}">LGO-CHECK </a></li> --}}
                                        <li><a href="{{ url('lgo_801_rep') }}">LGO-REP </a></li> 
                                    </ul>
                                </li>
                                {{-- <li><a href="{{ url('six') }}">ส่งออก 16 แฟ้ม</a></li> --}}
                                {{-- <li><a href="javascript: void(0);" class="has-arrow">KTB</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('anc_Pregnancy_test') }}">การทดสอบการตั้งครรภ์ (Pregnancy test)</a></li>
                                        <li><a href="{{ url('ktb') }}">การฝากครรภ์ ANC</a></li>
                                        <li><a href="{{ url('ktb_spawn') }}">การตรวจหลังคลอด ANC</a></li>
                                        <li><a href="{{ url('ktb_ferrofolic') }}">บริการยาเสริมธาตุเหล็ก </a></li>
                                        <li><a href="{{ url('ktb_kids_glasses') }}">แว่นตาเด็ก </a></li>
                                    </ul>
                                </li> --}}
                                <li><a href="{{ url('ssop') }}">SSOP</a></li>
                                {{-- <li><a href="{{ url('ssop_recheck') }}">SSOP RECHECK</a></li> --}}
                                <li><a href="{{ url('aipn') }}">AIPN</a></li>
                                {{-- <li><a href="{{ url('aipn_plb') }}">AIPN พรบ</a></li> --}}
                                {{-- <li><a href="{{ url('aipn_disability') }}">AIPN ทุภพพลภาพ </a></li> --}}
                                {{-- <li><a href="{{ url('aipn_equipdev') }}">SSIP-Equipdev</a></li> --}}
                                {{-- <li><a href="{{ url('free_schedule') }}">PPFS-Fre Schedule</a></li> --}}
                                <li><a href="javascript: void(0);" class="has-arrow">PPFS-67</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('ppfs_12001') }}">12001-คัดกรองสุขภาพจิต 15-34ปี</a></li>
                                        <li><a href="{{ url('ppfs_12002') }}">12002-คัดกรองสุขภาพจิต 35-59ปี</a></li>
                                        <li><a href="{{ url('ppfs_12003') }}">12003-เจาะเลือดจากหลอดเลือดดำ 35-59ปี</a></li>
                                        <li><a href="{{ url('ppfs_12004') }}">12004-เจาะเลือดจากหลอดเลือดดำ 45-59ปี</a></li>
                                        <li><a href="{{ url('ppfs_2206') }}">2206-7 แว่นตาเด็ก</a></li>
                                        {{-- <li><a href="{{ url('prb_repipdover') }}">Admit อยู่แต่วงเงินเกิน 30000</a></li> --}}
                                    </ul>
                                </li>
                            {{-- </ul>
                            <ul class="sub-menu" aria-expanded="true"> --}}
                                <li><a href="javascript: void(0);" class="has-arrow">ANC-หญิงตั้งครรภ์</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('ppfs_30011') }}">บริการดูแลและฝากครรภ์</a></li>
                                        <li><a href="{{ url('ppfs_30015') }}">บริการตรวจหลังคลอด</a></li>
                                        {{-- <li><a href="{{ url('anc_dent') }}">ตรวจฟัน+ขัดฟัน</a></li> --}}
                                        {{-- <li><a href="{{ url('anc_14001') }}">บริการยาเม็ดเสริมธาตุเหล็ก</a></li> --}}
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">แพทย์แผนไทย</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('herb9') }}">ยาสมุนไพร 9 ชนิด</a></li>
                                       
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">ทาลัสซีเมีย</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li><a href="{{ url('thalassemia_opd') }}">OPD </a></li>
                                        <li><a href="{{ url('thalassemia_ipd') }}">IPD </a></li>
                                    </ul>
                                </li>
                            </ul> 
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-column text-primary"></i>
                                <span>รายงาน</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('rep_crrt') }}">CRRT</a></li>
                                {{-- <li><a href="{{ url('prb_repopd') }}">OPD</a></li>  --}}
                                <li><a href="javascript: void(0);" class="has-arrow">วัณโรค</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('phthisis_opd') }}">OPD </a></li>
                                        <li><a href="{{ url('phthisis_ipd') }}">IPD</a></li>
                                        {{-- <li><a href="{{ url('prb_repipdover') }}">Admit อยู่แต่วงเงินเกิน 30000</a> --}}
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">ข้อมูลการรักษานักโทษ</a>
                                    <ul class="sub-menu" aria-expanded="true"> 
                                        <li ><a href="{{ url('prisoner_opd') }}" >438-OPD</a></li>
                                        <li ><a href="{{ url('prisoner_ipd') }}" >438-IPD</a></li>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-pen text-danger"></i>
                                <span>ใบงาน</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('request_report') }}">ยื่นใบงาน</a></li>
                            </ul>
                        </li> --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>ตรวจตึกแยก ward</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('check_ward') }}">ตรวจตึก</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-pen text-danger"></i>
                                <span>UCNIFO</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="https://ucinfo.nhso.go.th/ucinfo/RptRegisPop-4"
                                        target="_blank">รายงานเกี่ยวกับระบบทะเบียนประชากร</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-column text-danger"></i>
                                <span>Document</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('document') }}">เก็บเอกสาร</a></li>
                                {{-- <li><a href="{{ url('inst_sss_todtan') }}">กองทุนทดแทน-ปกส.</a></li> --}}
                                {{-- <li><a href="{{ url('inst_sss') }}">รายการค่าอวัยวะเทียมและอุปกรณ์บำบัด-ปกส.</a></li> --}}
                                {{-- <li><a href="https://cs3.chi.or.th/ambtrcs/login.asp">เบิกค่ารถ Refer</a></li>  --}}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-pen text-danger"></i>
                                <span>OT</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('otone') }}">ลง OT</a></li>
                                {{-- <li><a href="{{url('ottwo')}}">OT 2</a></li> --}}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-line text-danger"></i>
                                <span>รายงานแยกปีงบ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('report_op') }}">ผู้ป่วย OPD Visit</a></li>
                                <li><a href="{{ url('report_ipd') }}">ผู้ป่วย IPD Visit</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">รายงาน OFC แยกปีงบ</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('report_opd_ofc') }}">ผู้ป่วย OPD OFC</a></li>
                                        <li><a href="{{ url('report_ipd_ofc') }}">ผู้ป่วย IPD OFC</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>PCT กุมารเวชกรรม</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('thalassemia_year') }}">การเบิก Thalassemia </a></li>
                                <li><a href="http://hinsoxxx/21/images/%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%9A%E0%B8%B1%E0%B8%99%E0%B8%97%E0%B8%B6%E0%B8%81%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B8%A5%E0%B8%87%E0%B8%97%E0%B8%B0%E0%B9%80%E0%B8%9A%E0%B8%B5%E0%B8%A2%E0%B8%99%E0%B8%9C%E0%B8%B9%E0%B9%89%E0%B8%9B%E0%B9%88%E0%B8%A7%E0%B8%A2%E0%B9%82%E0%B8%A3%E0%B8%84%E0%B9%82%E0%B8%A5%E0%B8%AB%E0%B8%B4%E0%B8%95%E0%B8%88%E0%B8%B2%E0%B8%87%E0%B8%98%E0%B8%B2%E0%B8%A5%E0%B8%B1%E0%B8%AA%E0%B8%8B%E0%B8%B5%E0%B9%80%E0%B8%A1%E0%B8%B5%E0%B8%A2.pdf"
                                        target="_blank">คู่มือ</a></li>
                                {{-- <li><a href="{{url('karn_sss_309')}}">ไต 309</a></li> --}}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-column text-danger"></i>
                                <span>SSS</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                {{-- <li><a href="{{ url('inst_sss_todtan') }}">กองทุนทดแทน-ปกส.</a></li> --}}
                                {{-- <li><a href="{{ url('inst_sss') }}">รายการค่าอวัยวะเทียมและอุปกรณ์บำบัด-ปกส.</a></li> --}}
                                <li><a href="https://cs3.chi.or.th/ambtrcs/login.asp">เบิกค่ารถ Refer</a></li>
                                {{-- <li><a href="{{url('prb_repopd')}}">OPD</a></li> --}}
                                {{-- <li><a href="{{url('prb_repipd')}}">IPD</a></li> --}}
                                <li><a href="javascript: void(0);" class="has-arrow">สถิติรายงาน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('opd_chai') }}">OPD ชัยภูมิ</a></li>
                                        <li><a href="{{ url('opd_chai_list') }}">OPD-IPD ชัยภูมิ อุปกรณ์</a></li>
                                        <li><a href="{{ url('ipd_chai') }}">IPD ชัยภูมิ</a></li>
                                        <li><a href="{{ url('opd_outlocate') }}">OPD นอกเขต</a></li>
                                        <li><a href="{{ url('ipd_outlocate') }}">IPD นอกเขต</a></li>

                                    </ul>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-pen text-danger"></i>
                                <span>ทะเบียนคลุมหนังสือเข้า</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('book_inside_manage') }}">ทะเบียนหนังสือเข้า</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-pen text-danger"></i>
                                <span>ปรับสถานะ ECLAIM</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('eclaim_check') }}">ตรวจสอบ</a></li>
                                {{-- <li><a href="{{url('karn_main_sss')}}">LAB 07</a></li> --}}
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-file-pen text-danger"></i>
                                <span>เฝ้าระวัง ติดตาม</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('prb_opd') }}">accident OPD รายวัน</a></li>
                                <li><a href="{{ url('prb_ipd') }}">accident IPD รายวัน</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-column text-danger"></i>
                                <span>พรบ สถิติ รายงาน</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('prb_cpo') }}">คปอ</a></li>
                                <li><a href="{{ url('prb_repopd') }}">OPD</a></li>
                                {{-- <li><a href="{{url('prb_repipd')}}">IPD</a></li> --}}
                                <li><a href="javascript: void(0);" class="has-arrow">IPD</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('prb_repipd') }}">ผู้ป่วยใน พรบ.ที่จำหน่าย</a></li>
                                        <li><a href="{{ url('prb_repipdpay') }}">ผู้ป่วยใน
                                                พรบ.ที่จำหน่าย(ชำระเงิน)</a></li>
                                        <li><a href="{{ url('prb_repipdover') }}">Admit อยู่แต่วงเงินเกิน 30000</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>karn</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('karn_main') }}">ตรวจสอบ</a></li>
                                <li><a href="{{ url('karn_main_sss') }}">LAB 07</a></li>
                                <li><a href="{{ url('karn_sss_309') }}">ไต 309</a></li>
                            </ul>
                        </li> --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-chart-column text-danger"></i>
                                <span>ผังบัญชี</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);" class="has-arrow">ลูกหนี้รายตัวงานประกัน</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="https://docs.google.com/spreadsheets/d/15Csl_ob0un0s9Uu7Lp43yl2PwwaFRubS/edit#gid=1628425741"
                                                target="_blank">ลูกหนี้รายตัวผัง 2UC</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1t2HkWE8wvtrwc6GKLXMBr5I-XblVFtnD/edit#gid=1056463907"
                                                target="_blank">ทะเบียนเปลี่ยนสิทธิ์</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1gzmOl_SjYxEyiqJUNPR1-QBtSKWNEJiyT6eQs48rmqw/edit#gid=0"
                                                target="_blank">ลูกหนี้ชำระเงิน/สิ่งส่งตรวจ</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1LRUyXxWmRzBXu-z2-192rMorSBn6aRu6ncnPr71bBks/edit#gid=1232079612"
                                                target="_blank">ลูกหนี้เรียกเก็บจังหวัด 203</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1S_mPfZLEIoNx53NZto3LXN6ilrJsZZ0NZBdk2ZWT2lI/edit#gid=635173635"
                                                target="_blank">ลูกหนี้ประกันสังคมผัง 301-310</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1npnk1VyLD8lqWUWRn8S16kfMyzaC3t-R/edit#gid=207253454"
                                                target="_blank">ลูกหนี้รายตัวผัง 401/402</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1KgJ6ZVyrtrvlAIJfvbLm2q3cP3HpaLIO/edit#gid=516509406"
                                                target="_blank">ลูกหนี้รายตัวผัง 501/502/503/504</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1yGbrUM8yv7ZcczX4qNMP49rXpLhFT1gVS1OmZmYXM1Y/edit#gid=1774899226"
                                                target="_blank">ลูกหนี้รายตัว พรบ.ผัง 602/603</a></li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1wWo3J7OqtbUFb_3US3n6rELMrN1z-bj7/edit#gid=598482675"
                                                target="_blank">ลูกหนี้รายตัวผัง 701/702/704</a> </li>
                                        <li><a href="https://docs.google.com/spreadsheets/d/1JfGAqoEuUCXT3PsmfolnurrsXDb_PH2P/edit#gid=617103815"
                                                target="_blank">ลูกหนี้รายตัวผัง 801/802/803/804</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript: void(0);" class="has-arrow">ตรวจสอบสิทธิ์</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('acc_checksit') }}">ตรวจสอบสิทธิ์</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-user-tie text-danger"></i>
                                <span>ค่ารักษาที่ไม่โอนไป IPD</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('opdtoipd') }}">ตรวจสอบ</a></li>
                            </ul>
                        </li>
                       
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect"> 
                                <i class="fa-solid fa-cloud-arrow-up text-primary"></i>
                                <span>Up-rep New-Eclaim</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('uprep_eclaim') }}">Up Rep</a></li>
                            </ul>
                        </li>



                    </ul>
                </div >
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
 


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            {{-- background:url(/pkbackoffice/public/sky16/images/logo250.png)no-repeat 50%; --}}
            {{-- <div class="page-content Backgroupbody"> --}}
            <div class="page-content Backgroupbody">
                {{-- <div class="page-content"> --}}
                {{-- <div class="page-content" style="background-color: rgba(247, 244, 244, 0.911)"> --}}
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
                                Created with <i class="mdi mdi-heart text-danger"></i> by ทีมพัฒนา PK-OFFICER
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
    {{-- <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script> --}}

    <script src="{{ asset('pkclaim/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
        integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
    {{-- <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}

    <script src="{{ asset('assets/jquery-tabledit/jquery.tabledit.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-timepicker.js') }}"></script>
    @yield('footer')


    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
            $('#example6').DataTable();
            $('#example7').DataTable();
            $('#example8').DataTable();
            $('#example9').DataTable();
            $('#example10').DataTable();
            $('#example11').DataTable();
            $('#example12').DataTable();
            $('#example13').DataTable();
            $('#example14').DataTable();
            $('#example15').DataTable();
            $('#example16').DataTable();
            $('#example17').DataTable();
            $('#example18').DataTable();
            $('#example_user').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

        $(document).ready(function() {
            $('#insert_depForm').on('submit', function(e) {
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
                        if (data.status == 0) {

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
                                    window.location =
                                        "{{ url('setting/setting_index') }}";
                                }
                            })
                        }
                    }
                });
            });

            $('#update_depForm').on('submit', function(e) {
                e.preventDefault();

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
                                    window.location =
                                        "{{ url('setting/setting_index') }}";
                                }
                            })
                        }
                    }
                });
            });

            $('#insert_repForm').on('submit', function(e) {
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
                        if (data.status == 0) {} else {
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
            $('#update_repForm').on('submit', function(e) {
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
                        if (data.status == 0) {} else {
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

        $(document).ready(function() {
            $('#insert_depsubForm').on('submit', function(e) {
                e.preventDefault();
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
                                    window.location =
                                        "{{ url('setting/depsub_index') }}";
                                }
                            })
                        }
                    }
                });
            });

            $('#update_depsubForm').on('submit', function(e) {
                e.preventDefault();

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
                                    window.location =
                                        "{{ url('setting/depsub_index') }}";
                                }
                            })
                        }
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#insert_depsubsubForm').on('submit', function(e) {
                e.preventDefault();
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
                                    window.location =
                                        "{{ url('setting/depsubsub_index') }}";
                                }
                            })
                        }
                    }
                });
            });

            $('#update_depsubsubForm').on('submit', function(e) {
                e.preventDefault();

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
                                    window.location =
                                        "{{ url('setting/depsubsub_index') }}";
                                }
                            })
                        }
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#insert_leaderForm').on('submit', function(e) {
                e.preventDefault();
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
                                    window.location = "{{ url('setting/leader') }}";
                                }
                            })
                        }
                    }
                });
            });

            $('#insert_leader2Form').on('submit', function(e) {
                e.preventDefault();
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

            $('#insert_leadersubForm').on('submit', function(e) {
                e.preventDefault();
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
                                    // window.location="{{ url('setting/leader') }}";
                                }
                            })
                        }
                    }
                });
            });

        });

        $(document).ready(function() {
            $('#LEADER_ID').select2({
                placeholder: "หัวหน้ากลุ่มงาน",
                allowClear: true
            });
            $('#LEADER_ID2').select2({
                placeholder: "หัวหน้าฝ่าย/แผนก",
                allowClear: true
            });
            $('#DEPARTMENT_ID').select2({
                placeholder: "กลุ่มงาน",
                allowClear: true
            });
            $('#LEADER_ID3').select2({
                placeholder: "หัวหน้าหน่วยงาน",
                allowClear: true
            });
            $('#LEADER_ID4').select2({
                placeholder: "ผู้อนุมัติเห็นชอบ",
                allowClear: true
            });
            $('#USER_ID').select2({
                placeholder: "ผู้ถูกเห็นชอบ",
                allowClear: true
            });
            $('#DEPARTMENT_SUB_ID').select2({
                placeholder: "ฝ่าย/แผนก",
                allowClear: true
            });
            $('#orginfo_manage_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#orginfo_po_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        });

        $(document).on('click', '.edit_line', function() {
            var line_token_id = $(this).val();
            // alert(line_token_id);
            $('#linetokenModal').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ url('setting/line_token_edit') }}" + '/' + line_token_id,
                success: function(data) {
                    console.log(data.line_token.line_token_name);
                    $('#line_token_name').val(data.line_token.line_token_name)
                    $('#line_token_code').val(data.line_token.line_token_code)
                    $('#line_token_id').val(data.line_token.line_token_id)
                },
            });
        });

        $(document).ready(function() {
            $('#insert_lineForm').on('submit', function(e) {
                e.preventDefault();

                var form = this;
                //   alert('OJJJJOL');
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

            $('#insert_permissForm').on('submit', function(e) {
                e.preventDefault();
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
                                    window.location = "{{ url('setting/permiss') }}";
                                }
                            })
                        }
                    }
                });
            });
            $('#update_infoorgForm').on('submit', function(e) {
                e.preventDefault();
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
