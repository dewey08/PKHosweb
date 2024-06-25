<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">
 
     {{-- <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet"> --}}    
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">  
    <link href="{{ asset('css/sizebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tableuser.css') }}" rel="stylesheet">
    <script src="{{ asset('lib/webviewer.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('assets/css/mdb.min.css') }}" />

</head>
<style>
    body {
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      font-size: 14px;
      
      }
      .form-control{
        font-family:Verdana, Geneva, Tahoma, sans-serif;
            font-size: 14px;
            }
   .az{
        font-family:Verdana, Geneva, Tahoma, sans-serif;
        font-size: 13px;
        /* style="font-family:'Kanit',sans-serif;width: 100%;" */
    }
    /* .azz{
        font-family:Verdana, Geneva, Tahoma, sans-serif;
        font-size: 7px;
        /* style="font-family:'Kanit',sans-serif;width: 100%;" */
    /* } */ */
    /* .myFont{
        font-family:Verdana, Geneva, Tahoma, sans-serif;
        font-size:13px;
    } */
    /* .myFontselect{
        font-family:Verdana, Geneva, Tahoma, sans-serif;
        font-size:11px;
    } */
    /* .form-control form-control-sm{
        font-family:Verdana, Geneva, Tahoma, sans-serif;
        font-size:13px;
    } */
</style>

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
                            Z<br />
                            <span class="brand-subname">
                                OFFice
                            </span>
                        </p>

                    </div>
                </div>
            </div>
            <div class="sidebar-body">
                <hr style="color:rgb(255, 255, 255);margin-top:10px;">
                <div class="teams-title-container">
                    <p class="teams-title">TEAMS</p>
                </div>
                <ul class="navigation-list">

                    <li class="navigation-list-item {{ 'user/home' == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/home') }}">
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
                    {{-- <li class="navigation-list-item {{ 'user/user_data' == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/user_data') }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="col-9">
                                    ข้อมูลบุคคล
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    {{-- <li
                        class="navigation-list-item {{ 'user/gleave_data_dashboard/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/gleave_data_add/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/gleave_data/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/gleave_data_dashboard/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-address-book text-info"></i>
                                </div>
                                <div class="col-9">
                                    ข้อมูลการลา
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    <li
                        class="navigation-list-item {{ 'user/book_inside/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/book_send/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/book_advertise/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/book_inside/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-book-open-reader text-info"></i>
                                </div>
                                <div class="col-9">
                                    สารบรรณ
                                </div>
                            </div>
                        </a>
                    </li>
                    {{-- <li
                        class="navigation-list-item {{ 'user/persondev_dashboard/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/persondev_index/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/persondev_inside/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/persondev_dashboard/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-business-time text-info"></i>
                                </div>
                                <div class="col-9">
                                    ประชุม/อบรม/ดูงาน
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    <li
                        class="navigation-list-item {{ 'user_car/car_dashboard/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user_car/car_narmal/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user_car/car_ambulance/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user_car/car_narmal/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-truck-medical text-info"></i>
                                </div>
                                <div class="col-9">
                                    ยานพาหนะ
                                </div>
                            </div>
                        </a>
                    </li>
                    <li
                        class="navigation-list-item {{ 'user_meetting/meetting_dashboard' == request()->path() ? 'active' : '' }} || {{ 'user_meetting/meetting_index' == request()->path() ? 'active' : '' }} || {{ 'user_meetting/meetting_add' == request()->path() ? 'active' : '' }} || {{ 'user_meetting/meetting_calenda' == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link"
                            href="{{ url('user_meetting/meetting_calenda') }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-house-laptop text-info"></i>
                                </div>
                                <div class="col-9">
                                    ห้องประชุม
                                </div>
                            </div>
                        </a>
                    </li>
                    {{-- <li
                        class="navigation-list-item {{ 'user/repair_dashboard/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/repair_narmal/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/repair_com/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/repair_med/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/repair_dashboard/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-hammer text-info"></i>
                                </div>
                                <div class="col-9">
                                    แจ้งซ่อม
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    {{-- <li
                        class="navigation-list-item {{ 'user/house_detail/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/house_petition/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/house_problem/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/house_detail/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-house-chimney-user text-info"></i>
                                </div>
                                <div class="col-9">
                                    บ้านพัก
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    <li
                        class="navigation-list-item {{ 'user/supplies_data_add/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/supplies_data_add/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-boxes-packing text-info"></i>
                                </div>
                                <div class="col-9">
                                    งานพัสดุ
                                </div>
                            </div>
                        </a>
                    </li>
                    {{-- <li
                        class="navigation-list-item {{ 'user/warehouse_dashboard/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/warehouse_deb_sub_sub/' . Auth::user()->id == request()->path() ? 'active' : '' }} || {{ 'user/warehouse_main_request/' . Auth::user()->id == request()->path() ? 'active' : '' }}">
                        <a class="navigation-link" href="{{ url('user/warehouse_dashboard/' . Auth::user()->id) }}">
                            <div class="row">
                                <div class="col-2 me-2">
                                    <i class="fa-solid fa-building-shield text-info"></i>
                                </div>
                                <div class="col-9">
                                    คลังวัสดุ
                                </div>
                            </div>
                        </a>
                    </li> --}}
                    <!-- <li class="navigation-list-item">
                        <a class="navigation-link" href="/">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-address-book"></i>
                                </div>
                                <div class="col-9">
                                    Contacts
                                </div>
                            </div>
                        </a>
                    </li> -->
                </ul>
                <hr style="color:rgb(255, 255, 255);margin-top:30px;">
                {{-- <div class="teams-title-container">
                    <p class="teams-title">TEAMS</p>
                </div> --}}
                <!-- <ul class="teams-list">
                    <li class="teams-item">
                        <div class="row">
                            <div class="col-1">
                                <i class="fas fa-circle" style="color: rgb(255, 92, 160, 0.8);"></i>
                            </div>
                            <div class="col-9">
                                Marketing
                            </div>
                        </div>
                    </li>
                    <li class="teams-item">
                        <div class="row">
                            <div class="col-1">
                                <i class="fas fa-circle" style="color: rgb(36, 115, 242, 0.8);"></i>
                            </div>
                            <div class="col-9">
                                Development
                            </div>
                        </div>
                    </li>
                    <li class="teams-item">
                        <div class="row">
                            <div class="col-1">
                                <i class="fas fa-circle" style="color: rgb(51, 242, 105, 0.8);"></i>
                            </div>
                            <div class="col-9">
                                Webmaster
                            </div>
                        </div>
                    </li>
                    <li class="teams-item">
                        <div class="row">
                            <div class="col-1">
                                <i class="fas fa-circle" style="color: rgb(237, 181, 28, 0.8);"></i>
                            </div>
                            <div class="col-9">
                                Administration
                            </div>
                        </div>
                    </li>
                </ul> -->

            </div>
        </div>

        <div class="content">
            <div class="navigationBar">
                <button id="sidebarToggle" class="btn sidebarToggle">
                    <i class="fa-solid fa-1x fa-bars-staggered"></i>
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-center" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    @if (Auth::user()->img == null)
                                        <img src="{{ asset('assets/images/default-image.JPG') }}"
                                            id="edit_upload_preview" height="30px" width="50px" alt="Image"
                                            class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/person/' . Auth::user()->img) }}"
                                            id="edit_upload_preview" height="30px" width="50px" alt="Image"
                                            class="img-thumbnail">
                                    @endif
                                    {{-- <img src="{{ asset('assets/images/logoZoffice.png') }}" height="40" width="80"> --}}
                                    {{-- <img src="data:img/png;base64,{{ chunk_split(base64_encode( Auth::user()->img)) }}" height="30" width="50" alt="Image" class="img-thumbnail"> --}}
                                    <br>
                                    <label for="" style="color:rgb(255, 255, 255);">{{ Auth::user()->fname }}
                                        {{ Auth::user()->lname }}</label>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
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
            sidebarToggle.addEventListener("click", function() {
                document.querySelector("body").classList.toggle("active");
                document.getElementById("sidebarToggle").classList.toggle("active");
            })
        </script>


        <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <!-- <script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script> -->
        <!-- <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script> -->
        
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
            $(document).ready(function() {

                $('#example_user').DataTable();
                // $('#meeting_objective_id').select2({
                //     // dropdownCssClass: "myFont",
                //     placeholder:"--เลือก--",
                //     allowClear:true
                // });
                // $('#MEETTINGLIST_ID').select2({
                //     // dropdownCssClass: "myFont",
                //     placeholder:"--เลือก--",
                //     allowClear:true
                // });
                // $('#meetting_year').select2({
                //     // dropdownCssClass: "azz",
                //     placeholder:"--เลือก--",
                //     allowClear:true
                // });
                
            });
        </script>
</body>


</html>
