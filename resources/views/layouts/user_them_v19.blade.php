<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">

    {{-- <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tablecar.css') }}" rel="stylesheet"> --}}
    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">   
  <link href="{{ asset('css/tablecar.css') }}" rel="stylesheet">
  <script src="{{ asset('lib/webviewer.min.js') }}"></script>


  <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/tablecar.css') }}" rel="stylesheet">

    <!-- MDB -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/mdb.min.css') }}" /> --}}
        <link href="{{ asset('css/fontuser.css') }}" rel="stylesheet">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('themes/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/vendor/nouislider/nouislider.min.css') }}">
    <!-- Style css -->
    <link href="{{ asset('themes/css/style.css') }}" rel="stylesheet">


   



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

?>
 <style>
  .small { font: italic 13px sans-serif; }
  .heavy { font: bold 27px sans-serif; }
  .Rrrrr { font: italic 40px serif; fill: red; }
</style>
<body>

    <!--******************* Preloader start ********************-->
    <div id="preloader">
        <div class="waviy">
            <span style="--i:1">L</span>
            <span style="--i:2">o</span>
            <span style="--i:3">a</span>
            <span style="--i:4">d</span>
            <span style="--i:5">i</span>
            <span style="--i:6">n</span>
            <span style="--i:7">g</span>
            <span style="--i:8">.</span>
            <span style="--i:9">.</span>
            <span style="--i:10">.</span>
        </div>
    </div>
    <!--******************* Preloader end ********************-->


    <div id="main-wrapper">
        <!--********************************** Nav header start ***********************************-->
        <div class="nav-header">
            <a href="" class="brand-logo">
              <img src="{{ asset('assets/images/logoZoffice2.png') }}" height="53px" width="53px" alt="Image" >
            
               </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--********************************** Nav header end ***********************************-->

        @yield('header')
      
        <!--********************************** Sidebar start ***********************************-->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown"> 
                            @if (Auth::user()->img == null)
                                <img src="{{ asset('assets/images/default-image.jpg') }}" height="20px" width="20px" alt="Image" class="img-thumbnail">
                                @else
                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}" height="20px" width="20px" alt="Image" class="img-thumbnail">
                                @endif 
                            <div class="header-info ms-3">
                                <span class="font-w600 "><b> {{ Auth::user()->fname }} </b></span>
                                <small class="text-end font-w400">dekbanbaproject@gmail.com</small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                    width="18" height="18" viewbox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ms-2">Profile </span>
                            </a>
                          
                            <a href="{{ route('logout') }}" class="dropdown-item ai-icon" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                    width="18" height="18" viewbox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ms-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                        </div>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-050-info"></i>
                            <span class="nav-text">บริหารทั่วไป</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ url('user/gleave_data/'. Auth::user()->id) }}">ข้อมูลการลา</a></li>
                            <li><a href="{{ url('user/book_inside/'. Auth::user()->id) }}">สารบรรณ</a></li>
                            <li><a href="{{ url('user/persondev_dashboard/'. Auth::user()->id) }}">ประชุม/อบรม/ดูงาน</a></li>
                            <li><a href="{{ url('user_car/car_calenda/'. Auth::user()->id) }}">ยานพาหนะ</a></li>
                            <li><a href="{{ url('user_meetting/meetting_calenda') }}">ห้องประชุม</a></li>
                            <li><a href="{{ url('user/repair_dashboard/'. Auth::user()->id) }}">แจ้งซ่อม</a></li>
                            <li><a href="{{ url('user/house_detail/' . Auth::user()->id) }}">บ้านพัก</a></li>
                            <li><a href="{{ url('user/supplies_data_add/' . Auth::user()->id) }}">งานพัสดุ</a></li>
                            <li><a href="{{ url('user/warehouse_dashboard/' . Auth::user()->id) }}">คลังวัสดุ</a></li>
                        </ul>
                    </li>

                  
                </ul>
                <div class="copyright">
                    <p><strong>Dekbanbanproject</strong> © 2022 All Rights Reserved</p>
                    <p class="fs-12">พัฒนาโดย <span class="heart"></span>  นายประดิษฐ์ ระหา</p>
                </div>
            </div>
        </div>
        <!--********************************** Sidebar end ***********************************-->

        <div class="content-body">
              @yield('content')
        </div>
   
    </div>
    <!--********************************** Scripts ***********************************-->
    

    <!-- Required vendors -->
    <script src="{{ asset('themes/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('themes/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('themes/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script> --}}

    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>  --}}
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>


    <script src="{{ asset('themes/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <!-- Apex Chart -->
    {{-- <script src="{{ asset('themes/vendor/apexchart/apexchart.js') }}"></script> --}}
    {{-- <script src="{{ asset('themes/vendor/nouislider/nouislider.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('themes/vendor/wnumb/wNumb.js') }}"></script> --}}

    <!-- Dashboard 1 -->
    <script src="{{ asset('themes/js/dashboard/dashboard-1.js') }}"></script>

    <script src="{{ asset('themes/js/custom.min.js') }}"></script>
    <script src="{{ asset('themes/js/dlabnav-init.js') }}"></script>
    <script src="{{ asset('themes/js/demo.js') }}"></script>
    <script src="{{ asset('themes/js/styleSwitcher.js') }}"></script>


    {{-- <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> 
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/mdb.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script> --}}
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @yield('footer')

    <script type="text/javascript">
        $(document).ready(function() {
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

            $('#bookrep_import_fam').select2({
                placeholder: "นำเข้าไว้ในแฟ้ม ",
                allowClear: true
            });



        });
    </script>


</body>

</html>
