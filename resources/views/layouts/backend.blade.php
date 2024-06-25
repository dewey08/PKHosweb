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
    <!--  loading Screen page  -->
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
      if($status=='ADMIN'){
          $user_id = substr($url, $pos);    
      }else{
          $user_id = $id_user;  
      }  
      
      
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
        <!-- Side Overlay-->
        <aside id="side-overlay">
            <!-- Side Header -->
            <div class="bg-image"
                style="background-image: url('{{ asset('asset/media/various/bg_side_overlay_header.jpg') }}');">
                <div class="bg-primary-op">
                    <div class="content-header">
                        <!-- User Avatar 
                            <a class="img-link mr-1" href="javascript:void(0)">
                                <img class="img-avatar img-avatar48" src="{{ asset('asset/media/avatars/avatar10.jpg') }}" alt="">
                            </a>
                            END User Avatar -->

                        <!-- User Info -->
                        <div class="ml-2">
                            <a class="text-white font-w600" href="javascript:void(0)">Gotowin solution</a>
                            <div class="text-white-75 font-size-sm font-italic">คู่มือแนะนำการใช้งาน</div>
                        </div>
                        <!-- END User Info -->

                        <!-- Close Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout"
                            data-action="side_overlay_close">
                            <i class="fa fa-times-circle"></i>
                        </a>
                        <!-- END Close Side Overlay -->
                    </div>
                </div>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="content-side ">
                <div class="row ml-3">
                    <div class="col-md-12">
                        <label><a
                                href=" https://drive.google.com/drive/folders/1K1ScT_BTl2RGY4wno04NUilrHzFTF-n4?fbclid=IwAR1pPQxqa-qADhCq4u_OEmah7s65XkFdAJ8l9CK4Ru6RJmhr2lHd9omCjvs"
                                target="_blank">คู่มือการใช้งาน</label></a>
                    </div>
                    {{-- <div class="col-md-12">
                        <label>วิดิโอแนะนำการใช้งานงานบริหารบุคคล </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_personcheckinindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-history mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">ลงเวลาปฏิบัติงาน</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-calendar-alt mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">ข้อมูลการลา</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_persondevindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-handshake mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">ประชุม/อบรม/ดูงาน</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_compensationindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-hand-holding-usd mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">เงินเดือนค่าตอบแทน</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_guesthouseindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-hotel mr-2"></i><span
                                    class="nav-main-link-name loadscreen">สวัสดิการบ้านพัก</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>วิดิโอแนะนำการใช้งานงานบริหารทั่วไป </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-atlas mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">งานสารบรรณ</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-users mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">งานบริการห้องประชุม</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-truck mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">งานบริการยานพาหนะ</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-boxes mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">งานบริหารทรัพย์สิน</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-donate mr-2"></i><span
                                    class="nav-main-link-name loadscreen">งานพัสดุ</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_warehouse/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-box-open mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">คลังวัสดุ</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-wrench mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">งานแจ้งซ่อมบำรุง</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-table mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">ตารางเวรปฏิบัติงาน</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-calendar-check mr-2"></i> <span
                                    class="nav-main-link-name loadscreen ">ตารางจัด OT</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label>
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-1x fa-tshirt mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">งานซักฟอก</span>
                            </a>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <label class="mr-2">
                            <a href="{{ url('youtube/youtubeuser_gleaveindex/'.$user_id) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-1x fa-dolly-flatbed mr-2"></i> <span
                                    class="nav-main-link-name loadscreen">งานจ่ายกลาง</span>
                            </a>
                        </label>
                    </div>

                </div> --}}



            </div>
            <!-- END Side Content -->
        </aside>
        <!-- END Side Overlay -->


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
                            <span class="text-white-75" style=" font-size: 30px;">BACK</span><span class="text-white"
                                style=" font-size: 30px;">office</span>
                            <span style=" font-size: 14;"> version <?= env('APP_VERSION');?></span>
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

                        <a class="nav-main-link{{ request()->is('dashboard/*') ? ' active' : '' }}"
                            href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-bullhorn"></i>
                            <span class="nav-main-link-name loadscreen">ประชาสัมพันธ์</span>

                        </a>
                    </li>
                    <li class="nav-main-heading">
                        <h5 style="font-family: 'Kanit', sans-serif;">งานบริหารบุคคล</h5>
                    </li>
                    <li class="nav-main-item{{ request()->is('person/*') ? ' open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                            aria-expanded="true" href="#">
                            <i class="nav-main-link-icon fa fa-user"></i>
                            <span class="nav-main-link-name">ข้อมูลบุคคล</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">

                                @if(request()->is('person/personinfouser/edit/*'))
                                <a class="nav-main-link active" href="{{ url('person/personinfouser/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">รายละเอียดข้อมูลบุคคล</span>
                                </a>
                                @else
                                <a class="nav-main-link{{ request()->is('person/personinfouser/*') ? ' active' : ''}}"
                                    href="{{ url('person/personinfouser/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">รายละเอียดข้อมูลบุคคล</span>
                                </a>
                                @endif
                            </li>


                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfousereducat/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfousereducat/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen "
                                        style="font-weight: normal;">ข้อมูลการศึกษา</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserwork/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserwork/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen "
                                        style="font-weight: normal;">ประวัติการทำงาน</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserreward/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserreward/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">การได้รับรางวัล</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/inforegalia/main/*') ? ' active ' : '' }}" 
                                    href="{{ url('person/inforegalia/main/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen" style="font-weight:normal;">
                                        เครื่องราชอิสริยาภรณ์
                                    </span>
                                </a>
                            </li> 
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserexpert/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserexpert/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ความเชี่ยวชาญ</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserchangename/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserchangename/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">การเปลี่ยนชื่อ</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfousersalary/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfousersalary/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">เลื่อนขั้นเงินเดือน</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserteamlist/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserteamlist/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">สังกัดทีมนำองค์กร</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouseretrainspacial/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouseretrainspacial/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">อบรมเฉพาะทาง</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouseroccu/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouseroccu/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">การต่อใบประกอบ</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @if(request()->is('person/addpersoninfousercid') ||
                                request()->is('person/editpersoninfousercid/*'))
                                <a class="nav-main-link active" href="{{ url('person/personinfousercid/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">บัตรประจำตัว</span>

                                </a>

                                @else
                                <a class="nav-main-link{{ request()->is('person/personinfousercid/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfousercid/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">บัตรประจำตัว</span>
                                </a>
                                @endif
                            </li>
                            <li class="nav-main-item">

                                @if(request()->is('person/addpersoninfouserofficial') ||
                                request()->is('person/editpersoninfouserofficial/*/*'))

                                <a class="nav-main-link active"
                                    href="{{ url('person/personinfouserofficial/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ยานพาหนะ</span>

                                </a>
                                @else
                                <a class="nav-main-link{{ request()->is('person/personinfouserofficial/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserofficial/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ยานพาหนะ</span>
                                </a>

                                @endif

                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserother/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserother/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ประวัติครอบครัว</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserdisciplinary/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserdisciplinary/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ข้อมูลการลงโทษทางวินัย</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfousersignature/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfousersignature/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">ลายเซ็น</span>
                                </a>
                            </li>

                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('person/personinfouserfile/*') ? ' active' : '' }}"
                                    href="{{ url('person/personinfouserfile/'.$user_id) }}">
                                    <span class="nav-main-link-name loadscreen"
                                        style="font-weight: normal;">แนบไฟล์</span>
                                </a>
                            </li>

                        </ul>
                        @if($checkinfoperson == 1)

                        @if( $check1 == 'True')
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('person_checkin/*') ? ' active' : '' }}"
                            href="{{ url('person_checkin/personcheckin/'.$id_user)}}">
                            <i class="nav-main-link-icon fa fa-history"></i>
                            <span class="nav-main-link-name loadscreen">ลงเวลาปฏิบัติงาน</span>
                        </a>
                    </li>
                    </li>
                    @endif

                    {{-- @if($check2 == 'True')

                    <li class="nav-main-item">

                        @if(request()->is('person_work/personworkjobdescription/*') ||
                        request()->is('person_work/personworkcorecompetency_detail/*') ||
                        request()->is('person_work/personworkfuntionalcompetency_detail/*') ||
                        request()->is('person_work/personworkcorecompetency_setup/*') ||
                        request()->is('person_work/personworkfuntionalcompetency_setup/*') ||
                        request()->is('person_work/personworkkpi/*') )
                        <a class="nav-main-link active"
                            href="{{ url('person_work/personworkjobdescription/'.$user_id) }}">
                            <i class="nav-main-link-icon fa fa-address-card"></i>
                            <span class="nav-main-link-name loadscreen">ข้อมูลการทำงาน</span>
                        </a>

                        @else

                        <a class="nav-main-link{{ request()->is('person_work/personworkjobdescription/*') ? ' active' : '' }}"
                            href="{{ url('person_work/personworkjobdescription/'.$user_id) }}">
                            <i class="nav-main-link-icon fa fa-address-card"></i>
                            <span class="nav-main-link-name loadscreen">ข้อมูลการทำงาน</span>
                        </a>
                        @endif


                    </li>
                    </li>
                    @endif --}}

                    @if($check3 == 'True')
                    <li class="nav-main-item">
                        {{--
                        @if(request()->is('person_work/carcalendarhealth/*') ||
                        request()->is('person_leave/personworkability/*') ||
                        request()->is('person_work/personworkscreening/checkup/*') ||
                        request()->is('person_work/personworkscreening/screen/*') ||
                        request()->is('person_work/personworkscreening/screen_add/*') )
                        <a class="nav-main-link active" href="{{ url('person_leave/personworkability/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-child"></i>
                            <span class="nav-main-link-name loadscreen">ข้อมูลสุขภาพ</span>
                        </a>
                        @else --}}
                        <a class="nav-main-link{{ request()->is('person_work/carcalendarhealth/*') ? ' active' : '' }}"
                            href="{{ url('person_work/carcalendarhealth/'.$user_id) }}">
                            <i class="nav-main-link-icon fa fa-child"></i>
                            <span class="nav-main-link-name loadscreen">ข้อมูลสุขภาพ</span>
                        </a>
                        {{-- @endif --}}

                    </li>
                    @endif




                    <li class="nav-main-item">
                        @if($check4 == 'True')

                        @if(request()->is('person_leave/personleaveindex/*') ||
                        request()->is('person_leave/personleavetype/*') ||
                        request()->is('person_leave/addpersonleavesick/*') ||
                        request()->is('person_leave/personleaveinfo/*') ||
                        request()->is('person_leave/personleavesearch/*') ||
                        request()->is('person_leave/personleaveinfoapp/*') ||
                        request()->is('person_leave/personleaveinfover/*') ||
                        request()->is('person_leave/personleaveinfolastapp/*'))
                        <a class="nav-main-link active" href="{{ url('person_leave/personleaveindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-calendar-alt"></i>
                            <span class="nav-main-link-name loadscreen">ข้อมูลการลา</span>
                        </a>
                        @else

                        <a class="nav-main-link{{ request()->is('person_leave/personleaveindex/*') ? ' active' : '' }}"
                            href="{{ url('person_leave/personleaveindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-calendar-alt"></i>
                            <span class="nav-main-link-name loadscreen">ข้อมูลการลา</span>
                        </a>
                        @endif


                    </li>
                    @endif


                    @if($check5 == 'True')

                    <li class="nav-main-item">
                        @if(request()->is('person_dev/persondevindex/*') ||
                        request()->is('person_dev/personmeetinginside/*') || request()->is('person_dev/persondevinfo/*')
                        || request()->is('person_dev/persondevver/*') ||
                        request()->is('person_dev/personmeetinginside_add/*') ||
                        request()->is('person_dev/personmeetinginside_edit/*') ||
                        request()->is('person_dev/persondevadd/*') || request()->is('person_dev/persondevedit/*') ||
                        request()->is('person_dev/persondevcancel/*') )
                        <a class="nav-main-link active" href="{{ url('person_dev/persondevindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-handshake"></i>
                            <span class="nav-main-link-name loadscreen">ประชุม/อบรม/ดูงาน</span>
                        </a>
                        @else
                        <a class="nav-main-link{{ request()->is('person_dev/persondevindex/*') ? ' active' : '' }}"
                            href="{{ url('person_dev/persondevindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-handshake"></i>
                            <span class="nav-main-link-name loadscreen">ประชุม/อบรม/ดูงาน</span>
                        </a>
                        @endif

                    </li>
                    @endif

                    @if($check6 == 'True')
                    <li class="nav-main-item">
                        @if(request()->is('person_compensation/dashboard/*') ||
                        request()->is('person_compensation/cominfosalary/*') ||
                        request()->is('person_compensation/certificate/*') ||
                        request()->is('person_compensation/salaryslip/*') ||
                        request()->is('person_compensation/borrow/*') ||
                        request()->is('person_compensation/borrow_add/*') ||
                        request()->is('person_compensation/borrow_edit/*') ||
                        request()->is('person_compensation/borrow_cancel/*') ||
                        request()->is('person_compensation/certificate_add/*') ||
                        request()->is('person_compensation/certificate_edit/*') ||
                        request()->is('person_compensation/certificate_cancel/*') ||
                        request()->is('person_compensation/salaryslip_add/*') ||
                        request()->is('person_compensation/salaryslip_edit/*') ||
                        request()->is('person_compensation/salaryslip_cancel/*'))
                        <a class="nav-main-link active" href="{{ url('person_compensation/dashboard/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-hand-holding-usd"></i>
                            <span class="nav-main-link-name loadscreen">เงินเดือนค่าตอบแทน</span>
                        </a>
                        @else
                        <a class="nav-main-link{{ request()->is('person_compensation/dashboard') ? ' active' : '' }}"
                            href="{{ url('person_compensation/dashboard/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-hand-holding-usd"></i>
                            <span class="nav-main-link-name loadscreen">เงินเดือนค่าตอบแทน</span>
                        </a>
                        @endif
                    </li>
                    @endif
                    @if($check7 == 'True')
                    <li class="nav-main-item">
                        @if(request()->is('person_guesthouse/guesthouse_info/*') ||
                        request()->is('person_guesthouse/guesthouse_petition/*') ||
                        request()->is('person_guesthouse/guesthouse_problem/*') ||
                        request()->is('person_guesthouse/guesthouse_petition_add/*') ||
                        request()->is('person_guesthouse/guesthouse_petition_edit/*') ||
                        request()->is('person_guesthouse/guesthouse_problem_add/*') ||
                        request()->is('person_guesthouse/guesthouse_problem_edit/*') ||
                        request()->is('person_guesthouse/guesthouse_problem_cancel/*') )
                        <a class="nav-main-link active" href="{{ url('person_guesthouse/guesthouse_info/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-hotel "></i>
                            <span class="nav-main-link-name loadscreen">สวัสดิการบ้านพัก</span>
                        </a>
                        @else
                        <a class="nav-main-link{{ request()->is('person_guesthouse/guesthouse_info') ? ' active' : '' }}"
                            href="{{ url('person_guesthouse/guesthouse_info/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-hotel "></i>
                            <span class="nav-main-link-name loadscreen">สวัสดิการบ้านพัก</span>
                        </a>
                        @endif
                    </li>
                    @endif


                    <li class="nav-main-heading">
                        <h5 style="font-family: 'Kanit', sans-serif;">งานบริหารทั่วไป</h5>
                    </li>

                    </li>

                    @if($check19 == 'True')
                    <li class="nav-main-item">
                        @if(request()->is('general_plan/plan_dashboard'))
                        <a class="nav-main-link{{ request()->is('general_plan/plan_dashboard') ? ' active' : '' }}"
                            href="{{ url('general_plan/plan_dashboard/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-project-diagram "></i>
                            <span class="nav-main-link-name loadscreen">แผนงานโครงการ</span>
                        </a>
                        @else
                        <a class="nav-main-link{{ request()->is('general_plan/*') ? ' active' : '' }}"
                            href="{{ url('general_plan/plan_dashboard/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-project-diagram "></i>
                            <span class="nav-main-link-name loadscreen">แผนงานโครงการ</span>
                        </a>
                        @endif

                    </li>
                    @endif



                    @if($check8 == 'True')
                    </li>
                    <li class="nav-main-item">

                        <a class="nav-main-link{{ request()->is('general_document/*') ? ' active' : '' }}"
                            href="{{ url('general_document/genodocdocumententer/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-atlas"></i>
                            <span class="nav-main-link-name loadscreen">งานสารบรรณ</span>

                        </a>
                    </li>
                    @endif

                    @if($check9 == 'True')
                    <li class="nav-main-item">
                        @if(request()->is('general_meet/genmeetindex') || request()->is('general_meet/genmeetroom/*') ||
                        request()->is('general_meet/genmeetroominfo/*') ||
                        request()->is('general_meet/genmeetroomver/*') ||
                        request()->is('general_meet/genmeetroomvercancel/*'))
                        <a class="nav-main-link active" href="{{ url('general_meet/genmeetindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-users"></i>
                            <span class="nav-main-link-name loadscreen">งานบริการห้องประชุม</span>
                        </a>
                        @else
                        <a class="nav-main-link{{ request()->is('general_meet/genmeetindex/*') ? ' active' : '' }}"
                            href="{{ url('general_meet/genmeetindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-users"></i>
                            <span class="nav-main-link-name loadscreen">งานบริการห้องประชุม</span>
                        </a>
                        @endif
                    </li>
                    @endif
                    @if($check10 == 'True')
                    <li class="nav-main-item">

                        @if(request()->is('general_car/gencarindex') || request()->is('general_car/gencartype/*') ||
                        request()->is('general_car/gencarinfonomal/*') || request()->is('general_car/gencarinforefer/*')
                        || request()->is('general_car/gencarnomaladd/*') ||
                        request()->is('general_car/gencarreferadd/*') || request()->is('general_car/gencarreferedit/*'))
                        <a class="nav-main-link active" href="{{ url('general_car/gencarindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-truck"></i>
                            <span class="nav-main-link-name loadscreen">งานบริการยานพาหนะ</span>
                        </a>
                        @else
                        <a class="nav-main-link{{ request()->is('general_car/gencarindex/*') ? ' active' : '' }}"
                            href="{{ url('general_car/gencarindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-truck"></i>
                            <span class="nav-main-link-name loadscreen">งานบริการยานพาหนะ</span>
                        </a>
                        @endif

                    </li>
                    @endif

                    <!--
                        <li class="nav-main-item{{ request()->is('general_asset/*') ? ' open' : '' }}">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-boxes "></i>
                                    <span class="nav-main-link-name loadscreen">งานบริหารทรัพย์สิน</span>
                                </a>
                                <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('general_asset/genassetindex/*') ? ' active' : '' }}" href="{{ url('general_asset/genassetindex/'.$user_id)}}">
                                                <span class="nav-main-link-name loadscreen">ทะเบียนครุภัณฑ์</span>
                                            </a>
                                    </li>
                                    <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('general_asset/genassetdisburseindex/*') ? ' active' : '' }}" href="{{ url('general_asset/genassetdisburseindex/'.$user_id)}}">
                                                <span class="nav-main-link-name loadscreen">ทะเบียนเบิกครุภัณฑ์</span>
                                            </a>
                                    </li>

                                    <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('general_asset/infolendindex/*') ? ' active' : '' }}" href="{{ url('general_asset/infolendindex/'.$user_id)}}">
                                                <span class="nav-main-link-name loadscreen">ยืม-คืนครุภัณฑ์</span>
                                            </a>
                                    </li>
                                
                                </ul>
                        </li> 
                    -->
                    @if($check11 == 'True')
                    <li class="nav-main-item">

                        <a class="nav-main-link{{ request()->is('general_asset/*') ? ' active' : '' }}"
                            href="{{ url('general_asset/dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-boxes"></i>
                            <span class="nav-main-link-name loadscreen">งานบริหารทรัพย์สิน</span>

                        </a>
                    </li>

                    @endif
                    @if($check12 == 'True')

                    <li class="nav-main-item">

                        <a class="nav-main-link{{ request()->is('general_suplies/*') ? ' active' : '' }}"
                            href="{{ url('general_suplies/dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-donate"></i>
                            <span class="nav-main-link-name loadscreen">งานพัสดุ</span>

                        </a>
                    </li>

                    @endif
                    @if($check13 == 'True')
                    <li class="nav-main-item">

                        <a class="nav-main-link{{ request()->is('general_warehouse/*') ? ' active' : '' }}"
                            href="{{ url('general_warehouse/dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-box-open"></i>
                            <span class="nav-main-link-name loadscreen">คลังวัสดุ</span>

                        </a>
                    </li>

                    @endif


                    @if($check14 == 'True')
                    <li class="nav-main-item">

                        @if(request()->is('general_repair/genrepairtype') ||
                        request()->is('general_repair/genrepairnomal/*') ||
                        request()->is('general_repair/genrepairnomaladd/*') ||
                        request()->is('general_repair/genrepairnomal/edit/*') ||
                        request()->is('general_repair/genrepairnomalcancel/*') ||
                        request()->is('general_repair/genrepaircom/*') ||
                        request()->is('general_repair/genrepaircomadd/*') ||
                        request()->is('general_repair/genrepaircom/edit/*') ||
                        request()->is('general_repair/genrepaircomcancel/*') ||
                        request()->is('general_repair/genrepairmedical/*') ||
                        request()->is('general_repair/genrepairmedicaladd/*') ||
                        request()->is('general_repair/genrepairmedical/edit/*') ||
                        request()->is('general_repair/genrepairmedicalcancel/*') )
                        <a class="nav-main-link active" href="{{ url('general_repair/genrepairtype/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-wrench"></i>
                            <span class="nav-main-link-name loadscreen">งานแจ้งซ่อมบำรุง</span>
                        </a>

                        @else

                        <a class="nav-main-link{{ request()->is('general_repair/genrepairtype/*') ? ' active' : '' }}"
                            href="{{ url('general_repair/genrepairtype/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-wrench"></i>
                            <span class="nav-main-link-name loadscreen">งานแจ้งซ่อมบำรุง</span>
                        </a>
                        @endif

                    </li>
                    @endif
                    @if($check15 == 'True')
                    <li class="nav-main-item">

                        @if(request()->is('general_operate/genoperateindex') ||
                        request()->is('general_operate/genoperateindexset/*') ||
                        request()->is('general_operate/genoperateswap/*') ||
                        request()->is('general_operate/genoperateindexver/*') ||
                        request()->is('general_operate/genoperateindexapp/*') )
                        <a class="nav-main-link active" href="{{ url('general_operate/genoperateindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-table"></i>
                            <span class="nav-main-link-name loadscreen">ตารางเวรปฏิบัติงาน</span>
                        </a>

                        @else

                        <a class="nav-main-link{{ request()->is('general_operate/genoperateindex/*') ? ' active' : '' }}"
                            href="{{ url('general_operate/genoperateindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-table"></i>
                            <span class="nav-main-link-name loadscreen">ตารางเวรปฏิบัติงาน</span>
                        </a>

                        @endif

                    </li>
                    @endif

                    @if($check20 == 'True')
                    <li class="nav-main-item">

                        @if(request()->is('general_ot/geotindex') || request()->is('general_ot/geotsetdetail_add/*') )
                        <a class="nav-main-link active" href="{{ url('general_ot/geotindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-calendar-check"></i>
                            <span class="nav-main-link-name loadscreen">ตารางจัด OT</span>
                        </a>

                        @else

                        <a class="nav-main-link{{ request()->is('general_ot/geotindex/*') ? ' active' : '' }}"
                            href="{{ url('general_ot/geotindex/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-calendar-check"></i>
                            <span class="nav-main-link-name loadscreen">ตารางจัด OT</span>
                        </a>


                        @endif
                    </li>
                    @endif

                    @if($check16 == 'True')
                    <li class="nav-main-item">

                        @if(request()->is('general_launder/dashboard_launder') ||
                        request()->is('general_launder/stockcard_launder/*') ||
                        request()->is('general_launder/stockcard_launder_sub/*') ||
                        request()->is('general_launder/withdraw_launder/*') ||
                        request()->is('general_launder/withdrowlaunder_add/*') ||
                        request()->is('general_launder/pay_launder/*') )

                        <a class="nav-main-link active" href="{{ url('general_launder/dashboard_launder/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-1x fa-tshirt"></i>
                            <span class="nav-main-link-name loadscreen">งานซักฟอก</span>
                        </a>

                        @else

                        <a class="nav-main-link{{ request()->is('general_launder/dashboard_launder/*') ? ' active' : '' }}"
                            href="{{ url('general_launder/dashboard_launder/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-1x fa-tshirt"></i>
                            <span class="nav-main-link-name loadscreen">งานซักฟอก</span>
                        </a>

                        @endif

                    </li>
                    @endif
                    @if($check17 == 'True')
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('general_cpay/*') ? ' active' : '' }}"
                            href="{{route('gencpay.quota_equpment',$user_id)}}">
                            <i class="nav-main-link-icon fa fa-1x fa-dolly-flatbed"></i>
                            <span class="nav-main-link-name loadscreen">งานจ่ายกลาง</span>
                        </a>
                    </li>
                    @endif
                    @if($check18 == 'True')
                    <li class="nav-main-item">

                        @if(request()->is('general_risk/dashboard_risk') ||
                        request()->is('general_risk/risk_notify_internalcontrol/*') ||
                        request()->is('general_risk/risk_notify_report4/*') ||
                        request()->is('general_risk/risk_notify_report5/*') ||
                        request()->is('general_risk/risk_notify_account_detail/*') ||
                        request()->is('general_risk/risk_notify/*') ||
                        request()->is('general_risk/risk_notify_checkinfo/*') ||
                        request()->is('general_risk/risk_notify_deal/*') ||
                        request()->is('general_risk/risk_notify_add/*') ||
                        request()->is('general_risk/risk_notify_edit/*') ||
                        request()->is('general_risk/risk_notify_internalcontrol_add/*') ||
                        request()->is('general_risk/risk_notify_internalcontrol_edit/*') ||
                        request()->is('general_risk/risk_notify_analysis/*') ||
                        request()->is('general_risk/risk_notify_report4_add/*') ||
                        request()->is('general_risk/risk_notify_report4_edit/*') )

                        <a class="nav-main-link active" href="{{ url('general_risk/dashboard_risk/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-1x fa-file-signature"></i>
                            <span class="nav-main-link-name loadscreen">รายงานความเสี่ยง</span>
                        </a>

                        @else

                        <a class="nav-main-link{{ request()->is('general_risk/dashboard_risk/*') ? ' active' : '' }}"
                            href="{{ url('general_risk/dashboard_risk/'.$user_id)}}">
                            <i class="nav-main-link-icon fa fa-1x fa-file-signature"></i>
                            <span class="nav-main-link-name loadscreen">รายงานความเสี่ยง</span>
                        </a>

                        @endif

                    </li>
                    @endif

                    @endif
                    <!-- <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-money-bill-wave"></i>
                            <span class="nav-main-link-name loadscreen">ระบบยืมเงิน/ล้างเงินยืม</span>
                          
                        </a>  
                    </li> 
                    <li class="nav-main-heading"><h5 style="font-family: 'Kanit', sans-serif;">งานพัฒนาคุณภาพ</h5></li>
                    <li class="nav-main-item">
                        
                        <a class="nav-main-link{{ request()->is('dashboard/') ? ' active' : '' }}" href="{{ url('dashboard/'.$user_id)}}">

                            <i class="nav-main-link-icon fa fa-list-alt"></i>
                            <span class="nav-main-link-name loadscreen">รายงานความเสี่ยง</span>
                          
                        </a>  
                    </li> -->


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
                                <!-- <a class="dropdown-item" href="javascript:void(0)">
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
                                    

                                     Toggle Side Overlay -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <!--<a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                                        <i class="far fa-fw fa-building mr-1"></i> Settings
                                    </a>
                                     END Side Overlay -->

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
                    <!-- END User Dropdown -->

                    <!-- Notifications Dropdown -->
                    <!-- <div class="dropdown d-inline-block">
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
                        </div>-->
                    <!-- END Notifications Dropdown -->

                    <!-- Toggle Side Overlay -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    @if(Auth::user()->status != 'ADMIN')
                    <button type="button"
                        onclick="window.location.href='{{ url('changpassworduser/'.Auth::user()->PERSON_ID) }}' "
                        class="btn btn-dual">
                        <i class=" fa fa-key"></i>
                    </button>
                    @endif
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