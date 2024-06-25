<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Dashmix - Bootstrap 4 Admin Template &amp; UI Framework</title>

        <meta name="description" content="gtw-backoffice">
        <meta name="author" content="backoffice">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('asset/media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('asset/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('asset/media/favicons/apple-touch-icon-180x180.png') }}">

        <!-- Fonts and Styles -->
        @yield('css_before')
      
        <link rel="stylesheet" id="css-main" href="{{ asset('asset/css/dashmix.css') }}">
       <link rel="stylesheet" id="css-theme" href="{{ asset('asset/css/themes/xinspire.css') }}">

      
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
   <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 12px;
            font-size: 1.2rem;
            }
            input {
                font-size:1.5em;

            }
    </style>

        <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
        <link rel="stylesheet" href="{{asset('css/stylesl.css')}}">
        @yield('css_after')

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
    </head>
    <body>
        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
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
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed page-header-dark main-content-narrow">
            <!-- Side Overlay-->
            <aside id="side-overlay">
                <!-- Side Header -->
                <div class="bg-image" style="background-image: url('{{ asset('asset/media/various/bg_side_overlay_header.jpg') }}');">
                    <div class="bg-primary-op">
                        <div class="content-header">
                            <!-- User Avatar -->
                            <a class="img-link mr-1" href="javascript:void(0)">
                                <img class="img-avatar img-avatar48" src="{{ asset('asset/media/avatars/avatar10.jpg') }}" alt="">
                            </a>
                            <!-- END User Avatar -->

                            <!-- User Info -->
                            <div class="ml-2">
                                <a class="text-white font-w600" href="javascript:void(0)">George Taylor</a>
                                <div class="text-white-75 font-size-sm font-italic">Full Stack Developer</div>
                            </div>
                            <!-- END User Info -->

                            <!-- Close Side Overlay -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                                <i class="fa fa-times-circle"></i>
                            </a>
                            <!-- END Close Side Overlay -->
                        </div>
                    </div>
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="content-side">
                    <p>
                        Content..
                    </p>
                </div>
                <!-- END Side Content -->
            </aside>
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            <!--
                Sidebar Mini Mode - Display Helper classes

                Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                    If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

                Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
                Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
                Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
            -->
            <nav id="sidebar" aria-label="Main Navigation">
                <!-- Side Header -->
                <div class="bg-header-dark">
                    <div class="content-header bg-white-10">
                        <!-- Logo -->
                        <a class="link-fx font-w600 font-size-lg text-white" href="/">
                            <span class="smini-visible">
                                <span class="text-white-75">D</span><span class="text-white">x</span>
                            </span>
                            <span class="smini-hidden">
                                <span class="text-white-75" style=" font-size: 30px;">BACK</span><span class="text-white" style=" font-size: 30px;">office</span>
                            </span>
                        </a>
                        <!-- END Logo -->

                        <!-- Options -->
                        <div>
                            <!-- Toggle Sidebar Style -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                            <a class="js-class-toggle text-white-75" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" data-toggle="layout" data-action="sidebar_style_toggle" href="javascript:void(0)">
                                <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                            </a>
                            <!-- END Toggle Sidebar Style -->

                            <!-- Close Sidebar, Visible only on mobile screens -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                                <i class="fa fa-times-circle"></i>
                            </a>
                            <!-- END Close Sidebar -->
                        </div>
                        <!-- END Options -->
                    </div>
                </div>
                <!-- END Side Header -->
                <?php 
                      
                      $status = Auth::user()->status; 
                      $id_user = Auth::user()->PERSON_ID; 
                      $url = Request::url();
                      $pos = strrpos($url, '/') + 1;
                       
                    if($status=='ADMIN'){
                        $user_id = substr($url, $pos);    
                    }else{
                        $user_id = $id_user;  
                    }          

                ?>

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                        
                            <a class="nav-main-link{{ request()->is('dashboard/*') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                                <i class="nav-main-link-icon si si-cursor"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                                <span class="nav-main-link-badge badge badge-pill badge-success">5</span>
                            </a>
                        </li>
                        <li class="nav-main-heading"><h5 style="font-family: 'Kanit', sans-serif;">บุคคล</h5></li>
                        <li class="nav-main-item{{ request()->is('person/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-user"></i>
                                <span class="nav-main-link-name">ข้อมูลบุคคล</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                           
                                    @if(request()->is('person/personinfouser/edit/*'))
                                    <a class="nav-main-link active" href="{{ url('person/personinfouser/'.$user_id) }}">
                                        <span class="nav-main-link-name">รายละเอียดข้อมูลบุคคล</span>
                                        
                                    </a>
                                    @else
                                    <a class="nav-main-link{{ request()->is('person/personinfouser/*') ? ' active' : ''}}" href="{{ url('person/personinfouser/'.$user_id) }}">
                                        <span class="nav-main-link-name">รายละเอียดข้อมูลบุคคล</span>
                                        
                                    </a>
                                    @endif
                                    
 
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfousereducat/*') ? ' active' : '' }}" href="{{ url('person/personinfousereducat/'.$user_id) }}">
                                            <span class="nav-main-link-name">ข้อมูลการศึกษา</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserwork/*') ? ' active' : '' }}"  href="{{ url('person/personinfouserwork/'.$user_id) }}">
                                            <span class="nav-main-link-name">ประวัติการทำงาน</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserreward/*') ? ' active' : '' }}" href="{{ url('person/personinfouserreward/'.$user_id) }}">
                                            <span class="nav-main-link-name">การได้รับรางวัล</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserexpert/*') ? ' active' : '' }}"   href="{{ url('person/personinfouserexpert/'.$user_id) }}">
                                            <span class="nav-main-link-name">ความเชี่ยวชาญ</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserchangename/*') ? ' active' : '' }}" href="{{ url('person/personinfouserchangename/'.$user_id) }}">
                                            <span class="nav-main-link-name">การเปลี่ยนชื่อ</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfousersalary/*') ? ' active' : '' }}" href="{{ url('person/personinfousersalary/'.$user_id) }}">
                                            <span class="nav-main-link-name">เลื่อนขั้นเงินเดือน</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserteamlist/*') ? ' active' : '' }}"  href="{{ url('person/personinfouserteamlist/'.$user_id) }}" >
                                            <span class="nav-main-link-name">สังกัดทีมนำองค์กร</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouseretrainspacial/*') ? ' active' : '' }}"  href="{{ url('person/personinfouseretrainspacial/'.$user_id) }}">
                                            <span class="nav-main-link-name">อบรมเฉพาะทาง</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouseroccu/*') ? ' active' : '' }}" href="{{ url('person/personinfouseroccu/'.$user_id) }}">
                                            <span class="nav-main-link-name">การต่อใบประกอบ</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                    @if(request()->is('person/addpersoninfousercid') || request()->is('person/editpersoninfousercid/*'))
                                    <a class="nav-main-link active" href="{{ url('person/personinfousercid/'.$user_id) }}">
                                        <span class="nav-main-link-name">บัตรประชาชน</span>
                                        
                                    </a>

                                    @else
                                        <a class="nav-main-link{{ request()->is('person/personinfousercid/*') ? ' active' : '' }}" href="{{ url('person/personinfousercid/'.$user_id) }}">
                                            <span class="nav-main-link-name">บัตรประชาชน</span>
                                        </a>
                                    @endif
                                    </li>
                                    <li class="nav-main-item">

                                    @if(request()->is('person/addpersoninfouserofficial') || request()->is('person/editpersoninfouserofficial/*/*'))

                                    <a class="nav-main-link active" href="{{ url('person/personinfouserofficial/'.$user_id) }}">
                                    <span class="nav-main-link-name">บัตรข้าราชการ</span>
                                        
                                    </a>
                                    @else
                                    <a class="nav-main-link{{ request()->is('person/personinfouserofficial/*') ? ' active' : '' }}" href="{{ url('person/personinfouserofficial/'.$user_id) }}">
                                            <span class="nav-main-link-name">บัตรข้าราชการ</span>
                                        </a>

                                    @endif
                                       
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('') ? ' active' : '' }}" href="{{ url('person/personinfouserother/'.$user_id) }}">
                                            <span class="nav-main-link-name">ประวัติครอบครัว</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">ข้อมูลการลงโทษทางวินัย</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">ลายเซ็น</span>
                                        </a>
                                    </li>
                                   
                            </ul>
                        </li>
                        <li class="nav-main-item{{ request()->is('person_work/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="">
                                <i class="nav-main-link-icon fa fa-newspaper"></i>
                                <span class="nav-main-link-name">ข้อมูลการทำงาน</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">job description</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">ข้อมูลตัวชี้วัด</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">Core competency </span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">Finetry</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person_work/personworkability') ? ' active' : '' }}" href="{{ url('person_work/personworkability') }}">
                                            <span class="nav-main-link-name">การทดสบสมรรถภาพ</span>
                                        </a>
                                    </li>
                                   
                                   
                            </ul>
                        </li>
                        <li class="nav-main-item">

                           @if(request()->is('person_leave/personleaveindex/*') || request()->is('person_leave/personleavetype/*') || request()->is('person_leave/addpersonleavesick/*') || request()->is('person_leave/personleaveinfo/*') || request()->is('person_leave/personleavesearch/*') || request()->is('person_leave/personleaveinfoapp/*'))
                                    <a class="nav-main-link active" href="{{ url('person_leave/personleaveindex/'.$user_id)}}">
                                    <i class="nav-main-link-icon fa fa-history"></i>
                                        <span class="nav-main-link-name">ข้อมูลการลา</span>
                                        
                                    </a>

                                    @else
                        
                            <a class="nav-main-link{{ request()->is('person_leave/personleaveindex/*') ? ' active' : '' }}" href="{{ url('person_leave/personleaveindex/'.$user_id)}}">

                                <i class="nav-main-link-icon fa fa-history"></i>
                                <span class="nav-main-link-name">ข้อมูลการลา</span>
                              
                            </a>
                            @endif

                        </li>
                        <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('person_dev/persondevindex/*') ? ' active' : '' }}" href="{{ url('person_dev/persondevindex/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-handshake"></i>
                            <span class="nav-main-link-name">ประชุม/อบรม/ดูงาน</span>
                          
                        </a>
                    </li>
                    <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-hand-holding-usd"></i>
                            <span class="nav-main-link-name">เงินเดือนค่าตอบแทน</span>
                          
                        </a>
                    </li>
                        <li class="nav-main-heading"><h5 style="font-family: 'Kanit', sans-serif;">งานบริหารทั่วไป</h5></li>
                        <li class="nav-main-item">
                        
                            <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                                <i class="nav-main-link-icon fa fa-atlas"></i>
                                <span class="nav-main-link-name">งานสารบรรณ</span>
                              
                            </a>
                        </li>
                        <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-users"></i>
                            <span class="nav-main-link-name">งานบริการห้องประชุม</span>
                          
                        </a>
                    </li>
                    <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-truck"></i>
                            <span class="nav-main-link-name">งานบริการยานพาหนะ</span>
                          
                        </a>
                    </li>
                    <li class="nav-main-item{{ request()->is('person_work/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="">
                                <i class="nav-main-link-icon fa fa-wrench"></i>
                                <span class="nav-main-link-name">งานแจ้งซ่อมบำรุง</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">ซ่อมบำรุงทั่วไป</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">ซ่อมบำรุงคอมพิวเตอร์</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('person/personinfouserework') ? ' active' : '' }}" href="">
                                            <span class="nav-main-link-name">ซ่อมเครื่องมือแพทย์</span>
                                        </a>
                                    </li>
                             </ul>       
                    </li>
                    <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-table"></i>
                            <span class="nav-main-link-name">ตารางเวรปฏิบัติงาน</span>
                          
                        </a>  
                    </li>
                        <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-money-bill-wave"></i>
                            <span class="nav-main-link-name">ระบบยืมเงิน/ล้างเงินยืม</span>
                          
                        </a>  
                    </li> 
                    <li class="nav-main-heading"><h5 style="font-family: 'Kanit', sans-serif;">งานพัฒนาคุณภาพ</h5></li>
                    <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-list-alt"></i>
                            <span class="nav-main-link-name">รายงานความเสี่ยง</span>
                          
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
                            <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-user d-sm-none"></i>
                               
                                <span class="d-none d-sm-inline-block">{{ Auth::user()->name }} </span>
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

                        <!-- Notifications Dropdown -->
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-bell"></i>
                                <span class="badge badge-secondary badge-pill">5</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                                   Notifications
                                </div>
                                <ul class="nav-items my-2">
                                    <li>
                                        <a class="text-dark media py-2" href="javascript:void(0)">
                                            <div class="mx-3">
                                                <i class="fa fa-fw fa-check-circle text-success"></i>
                                            </div>
                                            <div class="media-body font-size-sm pr-2">
                                                <div class="font-w600">App was updated to v5.6!</div>
                                                <div class="text-muted font-italic">3 min ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark media py-2" href="javascript:void(0)">
                                            <div class="mx-3">
                                                <i class="fa fa-fw fa-user-plus text-info"></i>
                                            </div>
                                            <div class="media-body font-size-sm pr-2">
                                                <div class="font-w600">New Subscriber was added! You now have 2580!</div>
                                                <div class="text-muted font-italic">10 min ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark media py-2" href="javascript:void(0)">
                                            <div class="mx-3">
                                                <i class="fa fa-fw fa-times-circle text-danger"></i>
                                            </div>
                                            <div class="media-body font-size-sm pr-2">
                                                <div class="font-w600">Server backup failed to complete!</div>
                                                <div class="text-muted font-italic">30 min ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark media py-2" href="javascript:void(0)">
                                            <div class="mx-3">
                                                <i class="fa fa-fw fa-exclamation-circle text-warning"></i>
                                            </div>
                                            <div class="media-body font-size-sm pr-2">
                                                <div class="font-w600">You are running out of space. Please consider upgrading your plan.</div>
                                                <div class="text-muted font-italic">1 hour ago</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark media py-2" href="javascript:void(0)">
                                            <div class="mx-3">
                                                <i class="fa fa-fw fa-plus-circle text-primary"></i>
                                            </div>
                                            <div class="media-body font-size-sm pr-2">
                                                <div class="font-w600">New Sale! + $30</div>
                                                <div class="text-muted font-italic">2 hours ago</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="p-2 border-top">
                                    <a class="btn btn-light btn-block text-center" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-eye mr-1"></i> View All
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END Notifications Dropdown -->

                        <!-- Toggle Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-dual" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="far fa-fw fa-list-alt"></i>
                        </button>
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
                                    <button type="button" class="btn btn-primary" data-toggle="layout" data-action="header_search_off">
                                        <i class="fa fa-fw fa-times-circle"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control border-0" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
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

        @yield('footer')
    </body>
</html>
