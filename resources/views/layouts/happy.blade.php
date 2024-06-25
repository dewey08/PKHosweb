<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Gotowin</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="gtw-backoffice">
    <meta name="author" content="backoffice">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="gtw-backoffice">
    <meta property="og:site_name" content="gtw">
    <meta property="og:description" content="gtw-backoffice">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('asset/media/favicons/logo_cir.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('asset/media/favicons/logo_cir.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/media/favicons/apple-touch-icon-180x180.png') }}">

         
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" id="css-main" href="{{ asset('asset/css/dashmix.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('asset/css/themes/xpro.css') }}">
    <link rel="stylesheet" href="{{asset('css/stylesl.css')}}">

    
    
    <!-- END Stylesheets -->
    <style>
        #page-container.main-content-boxed>#page-header .content-header,
        #page-container.main-content-boxed>#page-header .content,
        #page-container.main-content-boxed>#main-container .content,
        #page-container.main-content-boxed>#page-footer .content {
            max-width: 1399px;
        }

        .fix {
            position: fixed;
            width: 100%;
            z-index: 5;
        }

        body *{
             font-family:'Kanit',sans-serif;
         }
         .fix {
                position: fixed;
                width: 100%;
                z-index: 5;
            }
    
            #loader-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1000;
                background-color: #00000042;
            }
    
            #loader {
                display: block;
                position: relative;
                left: 50%;
                top: 50%;
                width: 150px;
                height: 150px;
                margin: -75px 0 0 -75px;
                border-radius: 50%;
                border: 3px solid transparent;
                border-top-color: #3498db;
                -webkit-animation: spin 2s linear infinite;
                /* Chrome, Opera 15+, Safari 5+ */
                animation: spin 2s linear infinite;
                /* Chrome, Firefox 16+, IE 10+, Opera */
            }
    
            #loader:before {
                content: "";
                position: absolute;
                top: 5px;
                left: 5px;
                right: 5px;
                bottom: 5px;
                border-radius: 50%;
                border: 3px solid transparent;
                border-top-color: #e74c3c;
                -webkit-animation: spin 3s linear infinite;
                /* Chrome, Opera 15+, Safari 5+ */
                animation: spin 3s linear infinite;
                /* Chrome, Firefox 16+, IE 10+, Opera */
            }
    
            #loader:after {
                content: "";
                position: absolute;
                top: 15px;
                left: 15px;
                right: 15px;
                bottom: 15px;
                border-radius: 50%;
                border: 3px solid transparent;
                border-top-color: #f9c922;
                -webkit-animation: spin 1.5s linear infinite;
                /* Chrome, Opera 15+, Safari 5+ */
                animation: spin 1.5s linear infinite;
                /* Chrome, Firefox 16+, IE 10+, Opera */
            }
    
            @-webkit-keyframes spin {
                0% {
                    -webkit-transform: rotate(0deg);
                    /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(0deg);
                    /* IE 9 */
                    transform: rotate(0deg);
                    /* Firefox 16+, IE 10+, Opera */
                }
    
                100% {
                    -webkit-transform: rotate(360deg);
                    /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(360deg);
                    /* IE 9 */
                    transform: rotate(360deg);
                    /* Firefox 16+, IE 10+, Opera */
                }
            }
    
            @keyframes spin {
                0% {
                    -webkit-transform: rotate(0deg);
                    /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(0deg);
                    /* IE 9 */
                    transform: rotate(0deg);
                    /* Firefox 16+, IE 10+, Opera */
                }
    
                100% {
                    -webkit-transform: rotate(360deg);
                    /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(360deg);
                    /* IE 9 */
                    transform: rotate(360deg);
                    /* Firefox 16+, IE 10+, Opera */
                }
            }


    </style>
    @yield('css_before')


    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    {{-- <link rel="stylesheet" href="{{ asset('assets/js/sweetalert2/sweetalert2.min.css') }}">
    <script src="{{ asset('assets/js/sweetalert2/sweetalert2.all.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.13.0/sweetalert2.min.js" integrity="sha512-33a7z5UWvWHAxBi0waVWN71V1WSXylTH1Iier1lEZdKxvE4RdoYkOKWazVr9av5O1GS6aaOcE3nUB3sPQRA7Jg==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.13.0/sweetalert2.min.css" integrity="sha512-EeZYT52DgUwGU45iNoywycYyJW/C2irAZhp2RZAA0X4KtgE4XbqUl9zXydANcIlEuF+BXpsooxzkPW081bqoBQ==" crossorigin="anonymous" />


    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
    <script>
        function checklogin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    
    if (Auth::check()) {
        $status = Auth::user()->status;
        $id_user = Auth::user()->PERSON_ID;
    } else {
        echo "<body onload=\"checklogin()\"></body>";
        exit();
    }
    $NAME_USER = Auth::user()->name;
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    if ($status == 'ADMIN') {
        $user_id = substr($url, $pos);
    } else {
        $user_id = $id_user;
    }
    
 
    use App\Http\Controllers\Happy_Net_Controller;
    $setcompliment_Happy = Happy_Net_Controller::setcompliment_Happy();
    $setproblem_Happy = Happy_Net_Controller::setproblem_Happy();


      use App\Http\Controllers\DashboardController;
        $checkhappy_ed = DashboardController::checkhappy_ed($id_user);
        $checkhappy_re = DashboardController::checkhappy_re($id_user);
        // dd($id_user);
        // dd($checkhappy_ed,$checkhappy_re);
    ?>
</head>

<body>

    <div class="loading-page">
        <div id="loader-wrapper">
            <div id="loader"></div>
        </div>
    </div>

    <div id="page-container" class="page-header-dark main-content-boxed page-header-fixed">

        <!-- Header -->
        <header id="page-header" style=" background-color: #31a42f;">
            <!-- Header Content -->
            <div class="content-header">
                <!-- Left Section -->
                <div class="d-flex align-items-center">
                    <!-- Logo -->

                    <a class="link-fx font-size-lg font-w600 text-white" href="">
                        <i style="color: #ffc94d;" class="fa fa-heartbeat fa-1.5x"></i>
                        <span class="text-white-50"></span><span class="text-white" style="font-weight: normal;font-family: 'Kanit', sans-serif;">ความสุขของบุคลากร</span>
                    </a>
                    <!-- END Logo -->

                    <!-- Open Search Section -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->

                    <!-- END Open Search Section -->
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div>
                    <!-- User Dropdown -->
                    <div class="dropdown d-inline-block" >
                        <button  type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-user d-sm-none" style=" background-color: #be7dff;"></i>
                            <span class="d-none d-sm-inline-block" style=" font-family: 'Kanit', sans-serif; font-weight: normal;">{{ Auth::user()->name }} </span>
                            <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                            <div class=" rounded-top font-w600 text-white text-center p-3" style=" background-color: #73c088;">
                                User Options
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-user mr-1"></i> Profile
                                </a>
                                <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                    <span><i class="far fa-fw fa-envelope mr-1"></i> Inbox</span>
                                    <span class="badge badge-primary">3</span>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-file-alt mr-1"></i> Invoices
                                </a>
                                <div role="separator" class="dropdown-divider"></div>

                                <!-- Toggle Side Overlay -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                                    <i class="far fa-fw fa-building mr-1"></i> Settings
                                </a>
                                <!-- END Side Overlay -->

                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>



                            </div>
                        </div>
                    </div>
                    <!-- END User Dropdown -->
                </div>
                <!-- END Right Section -->
            </div>
            <!-- END Header Content -->

            <!-- Header Search -->
            <div id="page-header-search" class="overlay-header bg-header-dark">
                <div class="content-header">
                    <form class="w-100" action="be_pages_generic_search.html" method="POST">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <button type="button" class="btn btn-primary" data-toggle="layout" data-action="header_search_off">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control" placeholder="Search your websites.." id="page-header-search-input" name="page-header-search-input">
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Header Search -->

            <!-- Header Loader -->
            <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
            <div id="page-header-loader" class="overlay-header bg-primary">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-2x fa-spinner fa-spin text-white"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Container -->
        <main id="main-container" >

            <!-- Navigation -->
            <div class="bg-white fix">
                <div>
                    <!-- Toggle Main Navigation -->
                    <div class="d-lg-none push">
                        <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                        <button type="button" class="btn btn-block btn-light d-flex justify-content-between align-items-center" data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                            Menu
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- END Toggle Main Navigation -->

                    <!-- Main Navigation -->
                    <div id="main-navigation" class="d-none d-lg-block ">

                        <ul class="nav-main nav-main-horizontal nav-main-hover" style="width: 95%;margin: auto;">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person_happynet/dashboard_Happy_Net') ? ' active' : '' }}" href="{{ url('person_happynet/dashboard_Happy_Net') }}">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-chart-pie"></i>
                                    <span class="nav-main-link-name loadscreen" style="font-size: 14px;font-family: 'Kanit', sans-serif;">Dashboard</span>

                                </a>
                            </li>
                         
                          
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person_happynet/get_user_Happy_Net') ? ' active' : '' }}" href="{{ url('person_happynet/get_user_Happy_Net') }}">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-heart"></i>
                                    <span class="nav-main-link-name loadscreen" style="font-size: 14px;font-family: 'Kanit', sans-serif;">คำชื่นชม &nbsp;<span class="badge badge-danger">{{ Happy_Net_Controller::count_chom() }}</span>

                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person_happynet/send_user_Happy_Net') ? ' active' : '' }}" href="{{ url('person_happynet/send_user_Happy_Net') }}">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-comments "></i>
                                    <span class="nav-main-link-name loadscreen" style="font-size: 14px;font-family: 'Kanit', sans-serif;">เพื่อนช่วยเพื่อน &nbsp;<span class="badge badge-danger">{{ Happy_Net_Controller::count_probem() }}</span></span>

                                </a>
                            </li>

                            {{-- <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person_happynet/rank_Happy_Net') ? ' active' : '' }}" href="{{ url('person_happynet/rank_Happy_Net') }}">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-trophy "></i>
                                    <span class="nav-main-link-name loadscreen" style="font-size: 14px;font-family: 'Kanit', sans-serif;">การจัดอันดับ</span>

                                </a>
                            </li> --}}
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person_happynet/reward_Happy_Net') ? ' active' : '' }}" href="{{ url('person_happynet/reward_Happy_Net') }}">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-shopping-basket "></i>
                                    <span class="nav-main-link-name loadscreen" style="font-size: 14px;font-family: 'Kanit', sans-serif;">แลกของรางวัล</span>

                                </a>
                            </li>
                            
                            @if ($checkhappy_ed != 0)
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-trophy "></i>
                                    <span class="nav-main-link-name ">การจัดอันดับ</span>
                                </a>
                                <ul class="nav-main-submenu">

                                 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/rank_ques_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">คำถาม</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/rank_coin_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">คะแนน</span>
                                        </a>
                                    </li>
                                   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/rank_ans_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">คำชม</span>
                                        </a>
                                    </li>
                                  


                                </ul>
                            </li>
                            @endif
                            @if ($checkhappy_re != 0)
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person_happynet/order_Happy_Net') ? ' active' : '' }}" href="{{ url('person_happynet/order_Happy_Net') }}">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-clipboard-list "></i>
                                    <span class="nav-main-link-name loadscreen" style="font-size: 14px;font-family: 'Kanit', sans-serif;">รายงานการแลกของรางวัล</span>

                                </a>
                            </li>
                             @endif
      
                             @if ($checkhappy_ed != 0)
                            <li class="nav-main-item">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i style="color: #73c088;" class="nav-main-link-icon fa fa-cogs"></i>
                                    <span class="nav-main-link-name ">ตั้งค่า</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/Equestion_group_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">หมวดหมู่คำถาม/คำถาม</span>
                                        </a>
                                    </li>

                                
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/Ereward_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">รางวัล</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/Ecoin_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">ระดับ / คะแนน</span>
                                        </a>
                                    </li>
                                 

                                    @if ($setcompliment_Happy == 0)
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/Eset_compliment_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">กำหนดการชื่นชม ครั้ง/ต่อวัน</span>
                                        </a>
                                    </li>
                                    @elseif ($setcompliment_Happy == 1)
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/Eset_compliment_Happy_Net/'. Happy_Net_Controller::setcompliment_Happys() ) }}">
                                            <span class="nav-main-link-name loadscreen">กำหนดการชื่นชม ครั้ง/ต่อวัน</span>
                                        </a>
                                    </li>
                                    @endif


                                    @if ($setproblem_Happy == 0)
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/Eset_problem_Happy_Net') }}">
                                            <span class="nav-main-link-name loadscreen">จำกัดการสอบถาม /<br> ขอความช่วยเหลือ ครั้ง/ต่อวัน</span>                                        </a>
                                    </li>
                                    @elseif ($setproblem_Happy == 1)
                                    <li class="nav-main-item">
                                        <a class="nav-main-link" href="{{ url('person_happynet/Eset_problem_Happy_Net/'. Happy_Net_Controller::setproblem_Happy() ) }}">
                                            <span class="nav-main-link-name loadscreen">จำกัดการสอบถาม /<br> ขอความช่วยเหลือ ครั้ง/ต่อวัน</span>                                        </a>
                                    </li>
                                    @endif

                                

                                  
                                   
                                </ul>
                            </li>

                            @endif
                        </ul>

                    </div>
                    <!-- END Main Navigation -->
                </div>
            </div>
            <!-- END Navigation -->

            <!-- Page Content -->
            <div style="margin-top:50px">
                @yield('content')
            </div>


        </main>
        <!-- END Main Container -->
        <script src="{{ asset('asset/js/dashmix.app.js') }}"></script>
        <!-- Laravel Scaffolding JS -->
        <script src="{{ asset('asset/js/laravel.app.js') }}"></script>
        <script src="{{ asset('js/globalFunction.js') }}"></script>
        <script src="{{ asset('js/formControl.js') }}"></script>
   {{-- load --}}
   <script src="{{ asset('js/globalFunction.js') }}"></script>
   <script src="{{ asset('js/formControl.js') }}"></script>
   <script src="{{ asset('js/crud.js') }}"></script>


        @yield('footer')
</body>

</html>