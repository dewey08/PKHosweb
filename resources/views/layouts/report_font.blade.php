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
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@200&family=Srisakdi:wght@400;700&display=swap" rel="stylesheet"> --}}

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

   <link rel="stylesheet" href="{{ asset('disacc/vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ asset('disacc/vendors/ionicons-npm/css/ionicons.css') }}">
   <link rel="stylesheet" href="{{ asset('disacc/vendors/linearicons-master/dist/web-font/style.css') }}">

   <link rel="stylesheet"
   href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">

   {{-- <link rel="stylesheet" href="{{ asset('global.css') }}" /> --}}
   {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.1.0/styles/github.min.css" /> --}}
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.1.0/highlight.min.js"></script> --}}

   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/dreport.css') }}">
   
</head>
<style>
    body{
    background:
        /* url(/pkbackoffice/public/images/bg7.jpg); */
        /* background-color:rgb(245, 240, 240); */
        /* background-color:rgb(245, 240, 240);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%; */

        background-color: rgb(245, 240, 240);
        background-repeat: no-repeat;
        background-attachment: fixed;
        /* background-size: cover; */
        background-size: 100% 100%;
    }
.Bgsidebar {
      background-image: url('/pkbackoffice/public/images/bgside.jpg');
    background-repeat: no-repeat;
}
.Bgheader {
  		background-image: url('/pkbackoffice/public/images/bgheader.jpg');
		background-repeat: no-repeat;
	}
    .detail{
        font-size: 13px;
    }
    .headtable{
        font-size: 14px;
    }
    .myTable tbody tr{
        font-size:13px;
        height: 13px;
    }
</style>

<body data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            {{-- <div class="navbar-header shadow-lg bg-white"> --}}
              
                <div class="navbar-header shadow" style="background-color: rgb(235, 192, 255)">

                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box" style="background-color: rgb(255, 255, 255)">
                            <a href="" class="logo logo-dark">
                                <span class="logo-sm ">
                                    <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm" height="37">
                                </span>
                                <span class="logo-lg"> 
                                    <h4 style="color: rgb(235, 192, 255)" class="mt-4">PK-OFFICER</h4>
                                </span>
                            </a>
    
                            <a href="" class="logo logo-light">
                                <span class="logo-sm mt-3">
                                    <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm-light"
                                        height="40">
                                </span>
                                <span class="logo-lg">
                                    <h4 style="color: rgb(235, 192, 255)" class="mt-4">PK-OFFICER</h4>
                                </span>
                            </a>
                        </div>
    
                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                            id="vertical-menu-btn">
                            <i class="ri-menu-2-line align-middle" style="color: rgb(255, 255, 255)"></i>
                        </button>
                        <a href="{{url('account_pk_dash')}}">
                            <h4 style="color:rgb(255, 255, 255)" class="mt-4">Report</h4>
                        </a>
                       
                        <?php
                        $org = DB::connection('mysql')->select('   
                                                        select * from orginfo 
                                                        where orginfo_id = 1                                                                                                                      ');
                        ?>
                      
                    </div>


                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line" style="color: rgb(54, 53, 53)"></i>
                        </button>
                    </div>


                </div>
            </div>
        </header>
        <style>
            .nom6{
                background: linear-gradient(to right,#ffafbd);
                /* background: linear-gradient(to right, #c9ffbf, #ffafbd); */
            }
        </style>

        <!-- ========== Left Sidebar Start ========== -->
        {{-- <div class="vertical-menu Bgsidebar"> --}}
            <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>
                        {{-- <li>
                            <a href="{{ url('authen_dashboard') }}">
                                <i class="fa-solid fa-gauge-high text-danger"></i>
                                <span>Dashboard Authen</span>
                            </a>
                        </li>  --}}
                        {{-- <li>
                            <a href="{{ url('report_authen') }}">
                                <i class="fa-solid fa-gauge-high text-danger"></i>
                                <span>Dashboard Authen</span>
                            </a>
                        </li> --}}
                        <li>
                            <a href="{{ url('report_dashboard') }}">
                                <i class="fa-solid fa-gauge-high text-danger"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-clipboard-user text-danger"></i>
                                <span>Check Sit + Authen</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('check_dashboard') }}" target="_blank">DB Authen</a></li>
                                {{-- <li><a href="{{ url('check_dashboard_mob') }}" target="_blank">DB Authen Mobile</a></li> --}}
                                {{-- <li><a href="{{ url('check_sit_day') }}" target="_blank">เช็คสิทธิ์</a></li> --}}
                                <li><a href="{{ url('check_allsit_day') }}" target="_blank">เช็คสิทธิ์</a></li>
                                <li><a href="{{ url('import_authen_day') }}">Import Authen</a></li>
                                <li><a href="{{ url('check_authen_day') }}" target="_blank">Check Authen</a></li>
                                {{-- <li><a href="{{ url('check_authen') }}" target="_blank">Import Excel Authen</a></li> --}}
                                {{-- <li><a href="{{ url('check_sit_money') }}" target="_blank"> เช็คสิทธิ์ Money PK</a></li> --}} 
                                 <li><a href="javascript: void(0);" class="has-arrow">Data Auto</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('pull_hosauto') }}" target="_blank">Pull Hos Auto</a></li>
                                        <li><a href="{{ url('checksit_auto') }}" target="_blank">Checksit Auto</a></li> 
                                        <li><a href="{{ url('pullauthen_spsch') }}" target="_blank">Pull Authen SPSCH Auto</a></li> 
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-truck-medical text-danger"></i>
                                <span>Refer</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li ><a href="{{ url('report_refer') }}">การใช้งานรถ Refer BK</a></li>
                                <li ><a href="{{ url('report_refer_hos') }}">การใช้งานรถ Refer Hos</a></li>
                                {{-- <li ><a href="{{ url('report_refer_opds') }}">การบันทึกข้อมูล OPD Refer</a></li> --}}
                                <li ><a href="{{ url('refer_opds_cross') }}" >Referข้าม CUP ภายในจังหวัด</a></li>
                                <li ><a href="{{ url('report_ct') }}" >เรียกเก็บค่า CT ในจังหวัด</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-wheelchair text-danger"></i>
                                <span>อุปกรณ์อวัยวะเที่ยม</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li ><a href="{{ url('check_icd9_ipd') }}" >icd9</a></li>
                                <li ><a href="{{ url('check_knee_ipd') }}" >ข้อเข่า</a></li>
                                <li ><a href="{{ url('check_kradook') }}" >แผ่นโลหะกระดูก</a></li>
                                <li ><a href="{{ url('check_khosaphok') }}" >ข้อสะโพก</a></li>
                                <li ><a href="{{ url('check_bumbat') }}" >อุปกรณ์ในการบำบัดรักษา(9104)</a></li>
                                <li ><a href="{{ url('check_lapo') }}" >Laparoscopic appendectomy(4701)</a></li>
                                <li ><a href="{{ url('ins_a') }}" >Colostomy OPD</a></li>
                                <li ><a href="{{ url('ins_b') }}" >Colostomy IPD</a></li>
                                <li ><a href="{{ url('check_colpo_ipd') }}" >Colposcopic IPD</a></li>
                            </ul>
                        </li>
                        {{-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-square-person-confined text-danger"></i>
                                <span>ข้อมูลการรักษานักโทษ</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li ><a href="{{ url('prisoner_opd') }}" >438-OPD</a></li>
                                <li ><a href="{{ url('prisoner_ipd') }}" >438-IPD</a></li>
                            </ul>
                        </li> --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-square-person-confined text-danger"></i>
                                <span>Telemed</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li ><a href="{{ url('telemedicine') }}" >Telemed นัด</a></li>
                                <li ><a href="{{ url('telemedicine_visit') }}" >Telemed เปิด Visit</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-square-person-confined text-danger"></i>
                                <span>จิตเวช</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li ><a href="{{ url('kayapap_jitvs_mian') }}" >จิตเวช</a></li> 
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-square-person-confined text-danger"></i>
                                <span>มะเร็ง</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li ><a href="{{ url('acc_stm_ct') }}" >เทียบ STM มะเร็ง</a></li> 
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa-solid fa-square-person-confined text-danger"></i>
                                <span>ทาลัสซีเมีย </span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li ><a href="{{ url('thalassemia_opd') }}" >Thalassemia OPD</a></li> 
                                <li ><a href="{{ url('thalassemia_ipd') }}" >Thalassemia IPD</a></li> 
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
    {{-- <script type="text/javascript" src="{{ asset('disacc/vendors/jquery/dist/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script>
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

    <script type="text/javascript"
    src="{{ asset('disacc/vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('disacc/vendors/apexcharts/dist/apexcharts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('disacc/vendors/chart.js/dist/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('disacc/vendors/jquery-circle-progress/dist/circle-progress.min.js') }}">
</script>
    <script type="text/javascript" src="{{ asset('disacc/js/charts/apex-charts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('disacc/js/circle-progress.js') }}"></script>
    <script type="text/javascript" src="{{ asset('disacc/js/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('disacc/js/scrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('disacc/js/toastr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('disacc/js/treeview.js') }}"></script>
    <script type="text/javascript" src="{{ asset('disacc/js/form-components/toggle-switch.js') }}"></script>
    <script type="text/javascript" src="{{ asset('disacc/js/charts/chartjs.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('pkclaim/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/charts/apex-charts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/circle-progress.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/scrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/toastr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('acccph/js/form-components/toggle-switch.js') }}"></script>
    {{-- <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}
    {{-- <script src="{{ asset('js/ladda.js') }}"></script>  --}}
    {{-- <script src="{{ asset('presentation.js') }}"></script> --}}
    {{-- <script src="{{ asset('circularProgressBar.min.js') }}"></script> --}}
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

        });

    </script>
</body>

</html>
