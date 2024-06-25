<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Gotowin</title>

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
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('asset/media/favicons/apple-touch-icon-180x180.png') }}">


        <!-- Stylesheets -->
        <!-- Fonts and Dashmix framework -->
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
        <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
   

        <link rel="stylesheet" id="css-main" href="{{ asset('asset/css/dashmix.css') }}">
        <link rel="stylesheet" id="css-theme" href="{{ asset('asset/css/themes/xplay.css') }}">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
     
        <!-- END Stylesheets -->
     <style>
         .fix{
            position: fixed;
            width: 100%;
            z-index: 5;
         }
     </style>   
     <link rel="stylesheet" href="{{asset('css/stylesl.css')}}">
        @yield('css_before')
    </head>
    <body>
        <!-- Page Container -->
    <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-dark'                              Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header


        Footer

            ''                                          Static Footer if no class is added
            'page-footer-fixed'                         Fixed Footer (please have in mind that the footer has a specific height when is fixed)

        HEADER STYLE

            ''                                          Classic Header style if no class is added
            'page-header-dark'                          Dark themed Header
            'page-header-glass'                         Light themed Header with transparency by default
                                                        (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
            'page-header-glass page-header-dark'         Dark themed Header with transparency by default
                                                        (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
    -->
        <div id="page-container" class="page-header-dark main-content-boxed page-header-fixed">

            <!-- Header -->
            <header id="page-header" style="background-color: #FF7F50;">
                <!-- Header Content -->
                <div class="content-header"  >
                    <!-- Left Section -->
                    <div class="d-flex align-items-center">
                        <!-- Logo -->
                      
                        <a class="link-fx font-size-lg font-w600 text-white" href="">
                        <i class="fa fa-1.5x fa-tshirt text-warning"></i>
                            <span class="text-white-50"></span><span class="text-white" style="font-weight: normal;font-family: 'Kanit', sans-serif;">ซักฟอก</span>
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
                        <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block" style=" font-family: 'Kanit', sans-serif; font-weight: normal;" >{{ Auth::user()->name }} </span>
                                <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                                <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
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
                                    <a class="dropdown-item" href="javascript:void(0)"
                                    onclick="event.preventDefault();
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
            <main id="main-container">

                <!-- Navigation -->
                <div class="bg-white fix">
                    <div >
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
                      
                            <ul class="nav-main nav-main-horizontal nav-main-hover ">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('manager_launder/dashboard') ? ' active' : '' }}" href="{{ url('manager_launder/dashboard') }}">
                                        <i class="nav-main-link-icon fa fa-chart-pie"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">Dashboard</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_getre') ? ' active' : '' }}" href="{{ url('manager_launder/launder_getre') }}">
                                        <i class="nav-main-link-icon fas fa-qrcode"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">รับ-ส่งผ้า</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_getback') ? ' active' : '' }}" href="{{ url('manager_launder/launder_getback') }}">
                                        <i class="nav-main-link-icon fas fa-qrcode"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">ข้อมูลรับผ้า</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_check') ? ' active' : '' }}" href="{{ url('manager_launder/launder_check') }}">
                                        <i class="nav-main-link-icon fas fa-qrcode"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">ข้อมูลตรวจรับผ้า</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_send') ? ' active' : '' }}" href="{{ url('manager_launder/launder_send') }}">
                                        <i class="nav-main-link-icon fas fa-qrcode"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">ข้อมูลส่งผ้า</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_disburse') ? ' active' : '' }}" href="{{ url('manager_launder/launder_disburse') }}">
                                        <i class="nav-main-link-icon fas fa-qrcode"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">เบิกจ่ายผ้า</span>
                    
                                    </a>
                                </li>
                                {{-- <li class="nav-main-item"> 
                                    <a class="nav-main-link{{ request()->is('manager_launder/launder_withdraw') ? ' active' : '' }}" href="{{ url('manager_launder/launder_withdraw') }}">
                                    <i class="nav-main-link-icon fas fa-qrcode"></i>
                                    <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">เช็คสต็อก-เบิกผ้า</span>
                
                                </a>
                            </li> --}}
                                <!-- <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                        <i class="nav-main-link-icon fas fa-qrcode"></i>
                                        <span class="nav-main-link-name">สติกเกอร์ชุด 1</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">                                       
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_stickersmall') }}">
                                            <i class="nav-main-link-icon fas fa-qrcode"></i>
                                                <span class="nav-main-link-name">สติกเกอร์เล็ก</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                       
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_stickerlarge') }}">
                                            <i class="nav-main-link-icon fas fa-qrcode"></i>
                                                <span class="nav-main-link-name">สติกเกอร์ใหญ่</span>
                                            </a>
                                        </li>                                       
                                    </ul>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fas fa-barcode"></i>
                                        <span class="nav-main-link-name">สติ๊กเกอร์ชุด 2</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_stickersmall2') }}">
                                            <i class="nav-main-link-icon fas fa-barcode"></i>
                                                <span class="nav-main-link-name">สติกเกอร์เล็ก</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_stickerlarge2') }}">
                                            <i class="nav-main-link-icon fas fa-barcode"></i>
                                                <span class="nav-main-link-name">สติกเกอร์ใหญ่</span>
                                            </a>
                                        </li>                                       
                                    </ul>
                                </li> 
                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fas fa-barcode"></i>
                                        <span class="nav-main-link-name">สติ๊กเกอร์เซ็ต</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_stickerset1') }}">
                                            <i class="nav-main-link-icon fas fa-barcode"></i>
                                                <span class="nav-main-link-name">สติ๊กเกอร์เซ็ต 1</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_stickerset2') }}">
                                            <i class="nav-main-link-icon fas fa-qrcode"></i>
                                                <span class="nav-main-link-name">สติ๊กเกอร์เซ็ต 2</span>
                                            </a>
                                        </li>                                       
                                    </ul>
                                </li>

                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fas fa-sync-alt"></i>
                                        <span class="nav-main-link-name">บริหารจัดการ</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_stickernight') }}">
                                            <i class="nav-main-link-icon fas fa-sync-alt"></i>
                                                <span class="nav-main-link-name">คืนสติกเกอร์</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_pay') }}">
                                            <i class="nav-main-link-icon fab fa-amazon-pay"></i>
                                                <span class="nav-main-link-name">จ่ายของ</span>
                                            </a>
                                        </li>    
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_recieve') }}">
                                            <i class="nav-main-link-icon fas fa-recycle"></i>
                                                <span class="nav-main-link-name">รับคืน</span>
                                            </a>
                                        </li>  
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="{{ url('manager_launder/launder_dispose') }}">
                                            <i class="nav-main-link-icon fas fa-eraser"></i>
                                                <span class="nav-main-link-name">จำหน่ายทิ้ง</span>
                                            </a>
                                        </li>                                     
                                    </ul>
                                </li>




                               
                                 <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_stickernight') ? ' active' : '' }}" href="{{ url('manager_launder/launder_stickernight') }}">
                                        <i class="nav-main-link-icon fas fa-sync-alt"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">คืนสติกเกอร์</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_pay') ? ' active' : '' }}" href="{{ url('manager_launder/launder_pay') }}">
                                        <i class="nav-main-link-icon fab fa-amazon-pay"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">จ่ายของ</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_recieve') ? ' active' : '' }}" href="{{ url('manager_launder/launder_recieve') }}">
                                        <i class="nav-main-link-icon fas fa-recycle"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">รับคืน</span>
                    
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_dispose') ? ' active' : '' }}" href="{{ url('manager_launder/launder_dispose') }}">
                                        <i class="nav-main-link-icon fas fa-eraser"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">จำหน่ายทิ้ง</span>
                    
                                    </a>
                                </li> -->
                                <li class="nav-main-item"> 
                                    <a class="nav-main-link{{ request()->is('manager_launder/launder_checkstock') ? ' active' : '' }}" href="{{ url('manager_launder/launder_checkstock') }}">
                                        <i class="nav-main-link-icon fas fa-warehouse"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">Stock คลังหลัก</span>
                                    </a>
                                </li>
                                <li class="nav-main-item"> 
                                    <a class="nav-main-link{{ request()->is('manager_launder/launder_checktreasury') ? ' active' : '' }}" href="{{ url('manager_launder/launder_checktreasury') }}">
                                        <i class="nav-main-link-icon fas fa-warehouse"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">Stock คลังย่อย</span>
                                    </a>
                                </li>
                                  <!--  <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_static') ? ' active' : '' }}" href="{{ url('manager_launder/launder_static') }}">
                                        <i class="nav-main-link-icon fas fa-chart-line"></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">รายงาน</span>
                    
                                    </a>
                                </li> 
                               
                                <li class="nav-main-item"> 
                                        <a class="nav-main-link{{ request()->is('manager_launder/launder_checkday') ? ' active' : '' }}" href="{{ url('manager_launder/launder_checkday') }}">
                                        <i class="nav-main-link-icon fa fa-calendar-alt"></i></i>
                                        <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">ตรวจสอบวัน</span>
                    
                                    </a>
                                </li>-->
                            
                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon fas fa-sync-alt"></i>
                                        <span class="nav-main-link-name">ตั้งค่า</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                            <li class="nav-main-item"> 
                                                    <a class="nav-main-link{{ request()->is('manager_launder/launder_clothingtype') ? ' active' : '' }}" href="{{ url('manager_launder/launder_clothingtype') }}">
                                                    <i class="nav-main-link-icon fas fa-sync-alt"></i>
                                                    <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">ชนิดผ้า</span>
                                                    </a>
                                            </li>
                                            <li class="nav-main-item"> 
                                                    <a class="nav-main-link{{ request()->is('manager_launder/launder_dep') ? ' active' : '' }}" href="{{ url('manager_launder/launder_dep') }}">
                                                    <i class="nav-main-link-icon fas fa-sync-alt"></i>
                                                    <span class="nav-main-link-name" style="font-size: 14px;font-family: 'Kanit', sans-serif;">หน่วยงาน</span>
                                                    </a>
                                            </li>

                                          
                                    </ul>
                                </li>

                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- END Main Navigation -->
                    </div>
                </div>
                <!-- END Navigation -->

                <!-- Page Content -->
                
                @yield('content')
             

            </main>
            <!-- END Main Container -->

            <script src="{{ asset('asset/js/dashmix.app.js') }}"></script>

            <!-- Laravel Scaffolding JS -->
            <script src="{{ asset('asset/js/laravel.app.js') }}"></script>

            @yield('footer')
    </body>
</html>

