<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>gtw backoffice</title>

    <meta name="description" content="gtw-backoffice">
    <meta name="author" content="backoffice">
    <meta name="robots" content="noindex, nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('asset/media/favicons/logo_cir.png') }}">

    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('asset/media/favicons/logo_cir.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('asset/media/favicons/apple-touch-icon-180x180.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Fonts and Styles -->
    @yield('css_before')


    <link rel="stylesheet" id="css-theme" href="{{ asset('asset/css/dashmix.css') }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    {{-- <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('assets/js/sweetalert2/sweetalert2.all.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.13.0/sweetalert2.min.js"
        integrity="sha512-33a7z5UWvWHAxBi0waVWN71V1WSXylTH1Iier1lEZdKxvE4RdoYkOKWazVr9av5O1GS6aaOcE3nUB3sPQRA7Jg=="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.13.0/sweetalert2.min.css"
        integrity="sha512-EeZYT52DgUwGU45iNoywycYyJW/C2irAZhp2RZAA0X4KtgE4XbqUl9zXydANcIlEuF+BXpsooxzkPW081bqoBQ=="
        crossorigin="anonymous" />


    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 12px;
            font-size: 1.2rem;
        }

        input {
            font-size: 1.5em;

        }

        /* table,
    td,
    th {
        border: 1px solid black;
    } */
    </style>
    <link rel="stylesheet" href="{{asset('css/stylesl.css?v='.time())}}">
    @yield('css_after')
    <script>
        window.Laravel = {
            !!json_encode(['csrfToken' => csrf_token(), ]) !!
        };
    </script>
</head>

<body>
     loading Screen page 
    <div class="loading-page">
        <div id="loader-wrapper">
            <div id="loader"></div>
            <!-- <div style="padding-top: 10%; ">
                    <img src="/image/boss.png"  style="width: 30%;display:block;margin: auto;"/>
                </div>  -->
        </div>
    </div>
    <?php 
                      
        $status = Auth::user()->status; 
        $id_user = Auth::user()->PERSON_ID; 
        $url = Request::url();
        $pos = strrpos($url, '/') + 1;
        
        $user_id = substr($url, $pos);      
      
      
      use App\Http\Controllers\AdminPersonController;
      $checkinfoperson = AdminPersonController::checkinfoperson($id_user);


      use App\Http\Controllers\SetuppermisController;
      $check1 = SetuppermisController::check1();
      $check2 = SetuppermisController::check2();
      $check3 = SetuppermisController::check3();
      $check4 = SetuppermisController::check4();
      $check5 = SetuppermisController::check5();
      $check6 = SetuppermisController::check6();
      $check7 = SetuppermisController::check7();
      $check8 = SetuppermisController::check8();
      $check9 = SetuppermisController::check9();
      $check10 = SetuppermisController::check10();
      $check11 = SetuppermisController::check11();
      $check12 = SetuppermisController::check12();
      $check13 = SetuppermisController::check13();
      $check14 = SetuppermisController::check14();
      $check15 = SetuppermisController::check15();
      $check16 = SetuppermisController::check16();
      $check17 = SetuppermisController::check17();
      $check18 = SetuppermisController::check18();
      $check19 = SetuppermisController::check19();
      $check20 = SetuppermisController::check20();
  ?>


    <div id="page-container"
        class="sidebar-o enable-page-overlay side-scroll page-header-fixed page-header-dark main-content-narrow">

        


        <nav id="sidebar" aria-label="Main Navigation">
            <!-- Side Header -->
            <div class="bg-header-dark">
                <div class="content-header bg-white-10">
                    <!-- Logo -->
                    <a class="link-fx font-w600 font-size-lg text-white">
                        <span class="smini-visible">
                            <span class="text-white-75">D</span><span class="text-white">x</span>
                        </span>
                        <span class="smini-hidden">
                            <i class="nav-main-link-icon fa fa-user-alt"></i>
                            <span class="text-white-75" style=" font-size: 30px;">บุคลากร</span><span class="text-white"
                                style=" font-size: 30px;"></span>
                        </span>
                    </a>
                    <!-- END Logo -->

                    <!-- Options -->
                    <div>
                        <!-- Toggle Sidebar Style -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                        <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler"
                            data-class="fa-toggle-off fa-toggle-on" data-toggle="layout"
                            data-action="sidebar_style_toggle" href="javascript:void(0)">
                            <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                        </a>
                        <!-- END Toggle Sidebar Style -->

                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close"
                            href="javascript:void(0)">
                            <i class="fa fa-times-circle"></i>
                        </a>
                        <!-- END Close Sidebar -->
                    </div>
                    <!-- END Options -->
                </div>
            </div>
            <!-- END Side Header -->


            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    <li class="nav-main-item">
                    </li>
                            <li class="nav-main-item">

                                @if(request()->is('manager_person/detail/edit/*'))
                                <a class="nav-main-link active" href="{{ url('manager_person/detail/'.$user_id) }}">
                                
                                    <span class="nav-main-link-name loadscreen"
                                        >รายละเอียดข้อมูลบุคคล</span>
                                </a>
                                @else
                                <a class="nav-main-link{{ request()->is('manager_person/detail/*') ? ' active' : ''}}"
                                    href="{{ url('manager_person/detail/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-file-alt"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">รายละเอียดข้อมูลบุคคล</span>
                                </a>
                                @endif
                            </li>


                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view_information/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view_information/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-book"></i>
                                    <span class="nav-main-link-name loadscreen "
                                        style="font-weight: normal;">ข้อมูลการศึกษา</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view_workhistory/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view_workhistory/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-book-open"></i>
                                    <span class="nav-main-link-name loadscreen "
                                        style="font-weight: normal;">ประวัติการทำงาน</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view_award/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view_award/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-trophy"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">การได้รับรางวัล</span>
                                </a>
                            </li> 
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/regalia/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/regalia/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-gem"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">เครื่องราชอิสริยาภรณ์</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/expertise/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/expertise/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-id-badge"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ความเชี่ยวชาญ</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/namechange/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/namechange/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-book-reader"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">การเปลี่ยนชื่อ</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/upmoney/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/upmoney/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-money-bill-alt"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">เลื่อนขั้นเงินเดือน</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/family_history/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/leadership_team/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-user-tie"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">สังกัดทีมนำองค์กร</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/specialized_training/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/specialized_training/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-chalkboard-teacher"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">อบรมเฉพาะทาง</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/assembly_sheet/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/assembly_sheet/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-feather-alt"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">การต่อใบประกอบ</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @if(request()->is('manager_person/inforperson/view_idcard') ||
                                request()->is('manager_person/inforperson/view_idcard/*'))
                                <a class="nav-main-link active" href="{{ url('manager_person/inforperson/view_idcard/'.$user_id) }}">
                                <i class="nav-main-link-icon fa fa-address-card"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">บัตรประจำตัว</span>

                                </a>

                                @else
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view_idcard/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view_idcard/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-address-card"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">บัตรประจำตัว</span>
                                </a>
                                @endif
                            </li>
                            <li class="nav-main-item">

                                @if(request()->is('manager_person/inforperson/view/vehicle') ||
                                request()->is('manager_person/inforperson/view/vehicle/*/*'))

                                <a class="nav-main-link active"
                                    href="{{ url('manager_person/inforperson/view/vehicle/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ยานพาหนะ</span>

                                </a>
                                @else
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/vehicle/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/vehicle/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-car-alt"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ยานพาหนะ</span>
                                </a>

                                @endif

                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/family_history/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/family_history/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-users"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ประวัติครอบครัว</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/discipline/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/discipline/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-clipboard-list"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ข้อมูลการลงโทษทางวินัย</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('manager_person/inforperson/view/signature/*') ? ' active' : '' }}"
                                    href="{{ url('manager_person/inforperson/view/signature/'.$user_id) }}">
                                    <i class="nav-main-link-icon fa fa-signature"></i>
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ลายเซ็นต์</span>
                                </a>
                            </li>




                </ul>
            </div>
            <!-- END Side Navigation -->
        </nav>
        <!-- END Sidebar -->

        <!-- Header -->
        <header id="page-header">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div>
                    <!-- Toggle Sidebar -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                    <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    <!-- END Toggle Sidebar -->


                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div>

                    <!-- User Dropdown -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-user d-sm-none"></i>

                            <span class="d-none d-sm-inline-block"
                                style=" font-family: 'Kanit', sans-serif; font-weight: normal;">{{ Auth::user()->name }}
                            </span>
                            <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                            <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                                User Options
                            </div>
                            <div class="p-2">
                             

                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>



                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->status != 'ADMIN')
                    <button type="button"
                        onclick="window.location.href='{{ url('changpassworduser/'.Auth::user()->PERSON_ID) }}' "
                        class="btn btn-dual">
                        <i class=" fa fa-key"></i>
                    </button>
                    @endif
                    <!-- <button type="button" class="btn btn-dual" data-toggle="layout" data-action="side_overlay_toggle">
                      
                    </button> -->
                    <!-- END Toggle Side Overlay -->
                </div>
                <!-- END Right Section -->
            </div>
            <!-- END Header Content -->

            <!-- Header Search -->
            <div id="page-header-search" class="overlay-header bg-primary">
                <div class="content-header">
                    <form class="w-100" action="/dashboard" method="POST">
                        @csrf
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <button type="button" class="btn btn-primary" data-toggle="layout"
                                    data-action="header_search_off">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control border-0" placeholder="Search or hit ESC.."
                                id="page-header-search-input" name="page-header-search-input">
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Header Search -->

            <!-- Header Loader -->
            <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
            <div id="page-header-loader" class="overlay-header bg-primary-darker">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container">
            @yield('content')
        </main>
        <!-- END Main Container -->


    </div>
    <!-- END Page Container -->

    <!-- Dashmix Core JS -->
    <script src="{{ asset('asset/js/dashmix.app.js') }}"></script>


    <!-- Laravel Scaffolding JS -->
    <script src="{{ asset('asset/js/laravel.app.js') }}"></script>
    <script src="{{ asset('js/globalFunction.js') }}"></script>
    <script src="{{ asset('js/formControl.js') }}"></script>

    @yield('footer')
</body>

</html>