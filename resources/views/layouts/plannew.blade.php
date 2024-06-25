 
 
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
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
          
           
        
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
           <link rel="stylesheet"
           href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
       {{-- <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}
   
       <link rel="stylesheet" href="{{ asset('disacc/vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
       <link rel="stylesheet" href="{{ asset('disacc/vendors/ionicons-npm/css/ionicons.css') }}">
       <link rel="stylesheet" href="{{ asset('disacc/vendors/linearicons-master/dist/web-font/style.css') }}">
       {{-- <link rel="stylesheet"
           href="{{ asset('disacc/vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}"> --}}
       <link href="{{ asset('disacc/styles/css/base.css') }}" rel="stylesheet">
       <link rel="stylesheet" href="{{ asset('css/dplan.css') }}">
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
         
        </style>
        
        <body data-topbar="dark">
            {{-- <body data-sidebar="white" data-keep-enlarged="true" class="vertical-collpsed"> --}}

            <!-- Begin page -->
            <div id="layout-wrapper">
        
                <header id="page-topbar">
                    {{-- <div class="navbar-header shadow-lg" style="background-color: rgb(252, 252, 252)"> --}}
                        <div class="navbar-header shadow" style="background-color: rgb(250, 209, 209)">
        
                        <div class="d-flex">
                            <!-- LOGO -->
                            <div class="navbar-brand-box" style="background-color: rgb(255, 255, 255)">
                                <a href="" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm" height="37">
                                    </span>
                                    <span class="logo-lg">
                                        {{-- <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-dark" height="20"> --}}
                                        <h4 style="color:rgba(247, 217, 217, 0.781)" class="mt-4">PK-OFFICER</h4>
                                    </span>
                                </a>
        
                                <a href="" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="{{ asset('pkclaim/images/logo150.png') }}" alt="logo-sm-light"
                                            height="40">
                                    </span>
                                    <span class="logo-lg">
                                        <h4 style="color:rgba(247, 217, 217, 0.781)" class="mt-4">PK-OFFICER</h4>
                                    </span>
                                </a>
                            </div>
        
                            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                                id="vertical-menu-btn">
                                <i class="ri-menu-2-line align-middle" style="color: rgb(255, 255, 255)"></i>
                            </button>
                            <a href="{{url('plan')}}">
                                <h4 style="color:rgb(255, 255, 255)" class="mt-4">PLAN</h4>
                            </a>
                           
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
                <style>
                    .nom6{ 
                        background: linear-gradient(to right,#ffafbd); 
                    }
                </style>
        
                <!-- ========== Left Sidebar Start ========== -->
                <div class="vertical-menu ">
                    <div data-simplebar class="h-100"> 
                        <!--- Sidemenu -->
                        <div id="sidebar-menu">
                            <!-- Left Menu Start -->
                            <ul class="metismenu list-unstyled" id="side-menu">
                                <li class="menu-title">Menu</li>
                                {{-- <li>
                                    <a href="{{ url('plan_project') }}">  
                                        <i class="ri-apps-2-line me-2 text-danger"></i>
                                        <span>แผนโครงการ</span>
                                    </a> 
                                </li>  --}}
                                {{-- <li>
                                    <a href="{{ url('plan_development') }}">   
                                        <i class="ri-apps-2-line me-2 text-danger"></i>
                                        <span>แผนพัฒนาบุคลากร</span>
                                    </a> 
                                </li>  --}}
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect"> 
                                        <i class="fa-solid fa-clipboard-user text-danger"></i>
                                        <span>Plan</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        {{-- <li><a href="{{ url('plan_project') }}">แผนโครงการ</a></li>  --}}
                                        {{-- <li><a href="{{ url('plan_development') }}"> แผนพัฒนาบุคลากร</a></li>  --}}
                                        <li><a href="{{ url('plan_procurement') }}"> แผนจัดซื้อพัสดุ-ครุภัณฑ์</a></li> 
                                        {{-- <li><a href="{{ url('plan_maintenance') }}"> แผนบำรุงรักษา</a></li>  --}}
                                        <li><a href="{{ url('plan_control') }}"> ทะเบียนควบคุมแผนโครงการ</a></li> 
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                        <i class="fa-solid fa-gears text-danger"></i>
                                        <span>ตั่งค่า</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{ url('plan_type') }}">ประเภทแผนงาน</a></li> 
                                        <li><a href="{{ url('plan_vision') }}"> วิสัยทัศน์</a></li> 
                                        <li><a href="{{ url('plan_mission') }}"> พันธกิจ</a></li> 
                                        <li><a href="{{ url('plan_strategic') }}"> ยุทธศาสตร์</a></li> 
                                    </ul>
                                </li>
                                    {{--                                 
                                
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                        <i class="fa-solid fa-square-person-confined text-danger"></i>
                                        <span>ข้อมูลการรักษานักโทษ</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li ><a href="{{ url('prisoner_opd') }}" >438-OPD</a></li>  
                                        <li ><a href="{{ url('prisoner_ipd') }}" >438-IPD</a></li> 
                                    </ul>
                                </li> 
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">  
                                        <i class="fa-solid fa-square-person-confined text-danger"></i>
                                        <span>Telemed</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li ><a href="{{ url('telemedicine') }}" >Telemed นัด</a></li>  
                                        <li ><a href="{{ url('telemedicine_visit') }}" >Telemed เปิด Visit</a></li> 
                                    </ul>
                                </li>  --}}
                                
                            </ul>
                        </div>
                        <!-- Sidebar -->
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

    <!-- App js -->
    <script src="{{ asset('pkclaim/js/app.js') }}"></script>
    {{-- <link href="{{ asset('acccph/styles/css/base.css') }}" rel="stylesheet"> --}}
    @yield('footer')

        <script type="text/javascript">

            


            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
                $('#example4').DataTable();
                $('#example5').DataTable(); 

                
            });

         
            $(document).ready(function() {
                $('#insert_productForm').on('submit', function(e) {
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
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location =
                                            "{{ url('supplies/supplies_index') }}"; // กรณี add page new 
                                    }
                                })
                            }
                        }
                    });
                });

                $('#update_productForm').on('submit', function(e) {
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
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You edit data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location =
                                            "{{ url('supplies/supplies_index') }}"; // กรณี add page new   
                                    }
                                })
                            }
                        }
                    });
                });


            });
    

            function addunit() {
                var unitnew = document.getElementById("UNIT_INSERT").value;
                // alert(unitnew);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('article/addunit') }}",
                    method: "GET",
                    data: {
                        unitnew: unitnew,
                        _token: _token
                    },
                    success: function(result) {
                        $('.show_unit').html(result);
                    }
                })
            }
    
        </script>
    </body> 
</html>
