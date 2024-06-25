<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Gotowin</title>

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


        
      
        <!--<link rel="stylesheet" id="css-theme" href="{{ asset('asset/css/dashmix.css') }}">-->

        <link rel="stylesheet" id="css-main" href="{{ asset('asset/css/dashmix.css') }}">
      <link rel="stylesheet" id="css-theme" href="{{ asset('asset/css/themes/xplay.css') }}">

      


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
                                <a class="text-white font-w600" href="javascript:void(0)">Gotowin solution</a>
                                <div class="text-white-75 font-size-sm font-italic">คู่มือแนะนำการใช้งาน</div>
                            </div>
                            <div class="ml-2">
                                <a class="text-white font-w600" href="{{ url('youtube/youtubeindex') }}">Gotowin solution</a>
                                <div class="text-white-75 font-size-sm font-italic">คู่มือและวิดิโอแนะนำการใช้งาน</div>
                            </div>
                            <!-- END User Info  -->

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
                                <span style=" font-size: 14;"> version 63.05.25</span>
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
                <?php $status = Auth::user()->status; $id_user = Auth::user()->PERSON_ID; ?>

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('dashboardadmin') ? ' active' : '' }}" href="{{ url('/dashboardadmin') }}">
                                <i class="nav-main-link-icon si si-cursor"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                                
                            </a>
                        </li>
                        @if($id_user !== '0')
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ url('/dashboard/'.$id_user) }}" target="_blank">
                                <i class="nav-main-link-icon fa fa-address-card"></i>
                                <span class="nav-main-link-name">เข้าหน้าต่างผู้ใช้งาน</span>
                                
                            </a>
                        </li>
                        @endif
                        <li class="nav-main-heading">STEP 1</li>

                        <li class="nav-main-item{{ request()->is('admin_person/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-users"></i>
                                <span class="nav-main-link-name">ตั้งค่าข้อมูลบุคคล</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfoworkgroup') ? ' active' : '' }}" href="{{ url('admin_person/setupinfoworkgroup') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กลุ่มงาน</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfodepartment') ? ' active' : '' }}" href="{{ url('admin_person/setupinfodepartment') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ฝ่าย/แผนก</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfoinstitution') ? ' active' : '' }}" href="{{ url('admin_person/setupinfoinstitution') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หน่วยงาน</span>
                                        </a>
                                    </li> 
                                   <!-- <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfopersonteam') ? ' active' : '' }}" href="{{ url('admin_person/setupinfopersonteam') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ทีมนำองค์กร**</span>
                                        </a>
                                    </li> -->
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfolevel') ? ' active' : '' }}" href="{{ url('admin_person/setupinfolevel') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ระดับ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfostatus') ? ' active' : '' }}" href="{{ url('admin_person/setupinfostatus') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานะปัจจุบัน</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfokind') ? ' active' : '' }}" href="{{ url('admin_person/setupinfokind') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กลุ่มข้าราชการ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfokindtype') ? ' active' : '' }}" href="{{ url('admin_person/setupinfokindtype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทข้าราชการ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfopersongroup') ? ' active' : '' }}" href="{{ url('admin_person/setupinfopersongroup') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กลุ่มบุคลากร</span>
                                        </a>
                                    </li> 
                                
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person/setupinfopersonteamposition') ? ' active' : '' }}" href="{{ url('admin_person/setupinfopersonteamposition') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ตำแหน่งทีม</span>
                                        </a>
                                    </li> 

                            </ul>

                        <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('person/all') ? ' active' : '' }}" href="{{ url('person/all') }}">
                        <i class="nav-main-link-icon fa fa-user"></i>
                        <span class="nav-main-link-name"><i class="fas fa-plus"></i> เพิ่มข้อมูลบุคคล</span>
                        </a>
                        </li>


                        <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin_permis/setupinfopermis') ? ' active' : '' }}" href="{{ url('admin_permis/setupinfopermis') }}">
                        <i class="nav-main-link-icon fa fa-user"></i>
                        <span class="nav-main-link-name">กําหนดสิทธิ์ใช้งาน</span>
                        </a>
                        </li>
                        

                        <li class="nav-main-item{{ request()->is('admin_person_H/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-users"></i>
                                <span class="nav-main-link-name">ตั้งค่าตำแหน่งบุคคล</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person_H/setupinfoworkgroup_H') ? ' active' : '' }}" href="{{ url('admin_person_H/setupinfoworkgroup_H') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กลุ่มงาน</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person_H/setupinfodepartment_H') ? ' active' : '' }}" href="{{ url('admin_person_H/setupinfodepartment_H') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ฝ่าย/แผนก</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person_H/setupinfoinstitution_H') ? ' active' : '' }}" href="{{ url('admin_person_H/setupinfoinstitution_H') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หน่วยงาน</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_person_H/setupinfopersonteam') ? ' active' : '' }}" href="{{ url('admin_person_H/setupinfopersonteam') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ทีมนำองค์กร</span>
                                        </a>
                                    </li> 

                            </ul>

                     

                        <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin_leave_H/setupinfoapprov') ? ' active' : '' }}" href="{{ url('admin_leave_H/setupinfoapprov') }}">
                        <i class="nav-main-link-icon fa fa-users"></i>
                        <span class="nav-main-link-name">กำหนดสิทธิการเห็นชอบ</span>
                        </a>
                        </li>
                     
                      
                        <li class="nav-main-heading">STEP 2</li>
                        <li class="nav-main-item{{ request()->is('admin/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-cogs"></i>
                                <span class="nav-main-link-name">ทั่วไป</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin/setupinfoorg') ? ' active' : '' }}"  href="{{ url('admin/setupinfoorg') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ตั้งค่าองค์กร</span>
                                        </a>
                                 </li> 
                                  
                                    <li class="nav-main-item">
                                    <a class="nav-main-link{{ request()->is('admin/setupinfobudget') ? ' active' : '' }}"  href="{{ url('admin/setupinfobudget') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ตั้งค่าปีงบประมาณ</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin/setupinfoposition') ? ' active' : '' }}"  href="{{ url('admin/setupinfoposition') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ตั้งค่าตำแหน่ง</span>
                                        </a>
                                   </li> 
                              <!--     <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin/setupinfopermis') ? ' active' : '' }}"  href="{{ url('admin/setupinfopermis') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กําหนดสิทธิ์</span>
                                        </a>
                                   </li> -->  
                                   <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin/setupinfodaytype') ? ' active' : '' }}" href="{{ url('admin/setupinfodaytype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทวัน</span>
                                        </a>
                                    </li> 

                                


                                   
                            </ul>
                      
                        </li>

                        <li class="nav-main-heading">STEP 3</li>
                      
                        <li class="nav-main-item{{ request()->is('admin_leave/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-clock"></i>
                                <span class="nav-main-link-name">ข้อมูลการลา</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_leave/setupinfoleavetype') ? ' active' : '' }}" href="{{ url('admin_leave/setupinfoleavetype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทการลา</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_leave/setupinfovacation') ? ' active' : '' }}" href="{{ url('admin_leave/setupinfovacation') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กำหนดค่าวันลาพักผ่อน</span>
                                        </a>
                                    </li> 
                                
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_leave/setupinfocondition') ? ' active' : '' }}" href="{{ url('admin_leave/setupinfocondition') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กำหนดเงื่อนไขการลา</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_leave/setupinfoholiday') ? ' active' : '' }}" href="{{ url('admin_leave/setupinfoholiday') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กำหนดวันหยุดนักขัตฤกษ์</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_leave/setupinfofunction') ? ' active' : '' }}" href="{{ url('admin_leave/setupinfofunction') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">การใช้งานฟังก์ชัน</span>
                                        </a>
                                    </li> 

                            </ul>
                            <li class="nav-main-item{{ request()->is('admin_dev/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-user-cog"></i>
                                <span class="nav-main-link-name" >ประชุม/อบรม/ดูงาน</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfobranch') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfobranch') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สาขาที่เกี่ยวข้อง</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfocapacity') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfocapacity') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ด้านที่ได้รับ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfogo') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfogo') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ลักษณะการไป</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfoorg') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfoorg') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หน่วยงานที่จัด</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfoorglocation') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfoorglocation') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานที่จัด</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfotype') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfotype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทการไป</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfolevel') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfolevel') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ระดับการไป</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfoknow') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfoknow') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">การนำความรู้ไปใช้</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_dev/setupinfodoctype') ? ' active' : '' }}" href="{{ url('admin_dev/setupinfodoctype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทเอกสาร</span>
                                        </a>
                                    </li> 
                                   
                                    </ul>
                                    <li class="nav-main-item{{ request()->is('admin_meeting/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-handshake"></i>
                                <span class="nav-main-link-name">จองห้องประชุม</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_meeting/setupinforoom') ? ' active' : '' }}" href="{{ url('admin_meeting/setupinforoom') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ห้องประชุม</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_meeting/setupinforoomfood') ? ' active' : '' }}" href="{{ url('admin_meeting/setupinforoomfood') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">เมนูอาหาร</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_meeting/setupinforoomfoodtype') ? ' active' : '' }}" href="{{ url('admin_meeting/setupinforoomfoodtype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทอาหาร</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_meeting/setupinforoomarticle') ? ' active' : '' }}" href="{{ url('admin_meeting/setupinforoomarticle') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">อุปกรณ์โสต</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_meeting/setupinforoomtime') ? ' active' : '' }}" href="{{ url('admin_meeting/setupinforoomtime') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ช่วงเวลา</span>
                                        </a>
                                    </li> 
                              
                            </ul>

                            <li class="nav-main-item{{ request()->is('admin_checkin/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-business-time"></i>
                                <span class="nav-main-link-name">ลงเวลาปฏิบัติงาน</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_checkin/setupcheckintype') ? ' active' : '' }}" href="{{ url('admin_checkin/setupcheckintype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทการลงเวลา</span>
                                        </a>
                                    </li> 

                            </ul>

                            <li class="nav-main-item{{ request()->is('admin_operate/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-list-alt"></i>
                                <span class="nav-main-link-name">เวรปฏิบัติงาน</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_operate/setupoperatetype') ? ' active' : '' }}" href="{{ url('admin_operate/setupoperatetype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทเวร</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_operate/setupoperatejob') ? ' active' : '' }}" href="{{ url('admin_operate/setupoperatejob') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กำหนดเวร</span>
                                        </a>
                                    </li> 

                            </ul>

                            <li class="nav-main-item{{ request()->is('admin_book/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-book"></i>
                                <span class="nav-main-link-name">งานสารบรรณ</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbooktype') ? ' active' : '' }}" href="{{ url('admin_book/setupbooktype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทหนังสือ</span>
                                        </a>
                                    </li> 
                                    
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbooksecret') ? ' active' : '' }}" href="{{ url('admin_book/setupbooksecret') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ชั้นความลับ</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbookinstant') ? ' active' : '' }}" href="{{ url('admin_book/setupbookinstant') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ความเร่งด่วน</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbookfile') ? ' active' : '' }}" href="{{ url('admin_book/setupbookfile') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">File Server</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbooktypeout') ? ' active' : '' }}" href="{{ url('admin_book/setupbooktypeout') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทออก</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbookdepartmentadmin') ? ' active' : '' }}" href="{{ url('admin_book/setupbookdepartmentadmin') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ธุรการกลุ่มงาน</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbookdepartmentadminsub') ? ' active' : '' }}" href="{{ url('admin_book/setupbookdepartmentadminsub') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ธุรการฝ่าย</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbookorgin') ? ' active' : '' }}" href="{{ url('admin_book/setupbookorgin') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หน่วยงานรับหนังสือเข้า</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_book/setupbookorgout') ? ' active' : '' }}" href="{{ url('admin_book/setupbookorgout') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หน่วยงานหนังสือออก</span>
                                        </a>
                                    </li> 

                            </ul>
                    
                    <li class="nav-main-item{{ request()->is('admin_car/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-truck"></i>
                                <span class="nav-main-link-name">งานยานพาหนะ</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcartype') ? ' active' : '' }}" href="{{ url('admin_car/setupcartype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทรถ</span>
                                        </a>
                                    </li> 
                                    
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcarstatus') ? ' active' : '' }}" href="{{ url('admin_car/setupcarstatus') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานะรถ</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcarstyle') ? ' active' : '' }}" href="{{ url('admin_car/setupcarstyle') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ลักษณะรถ</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcarbrand') ? ' active' : '' }}" href="{{ url('admin_car/setupcarbrand') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ยี่ห้อรถ</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcarmachinbrand') ? ' active' : '' }}" href="{{ url('admin_car/setupcarmachinbrand') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ยี่ห้อเครื่องยนต์</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcarpower') ? ' active' : '' }}" href="{{ url('admin_car/setupcarpower') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">เชื้อเพลิง</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcardriver') ? ' active' : '' }}" href="{{ url('admin_car/setupcardriver') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">พนักงานขับรถ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcaraccessory') ? ' active' : '' }}" href="{{ url('admin_car/setupcaraccessory') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">อุปกรณ์เสริมภายใน</span>
                                        </a>
                                    </li>  

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcarappointlocate') ? ' active' : '' }}" href="{{ url('admin_car/setupcarappointlocate') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานที่นัดหมาย</span>
                                        </a>
                                    </li> 

                            </ul>

                            <li class="nav-main-item{{ request()->is('admin_safe/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-shield-alt"></i>
                                <span class="nav-main-link-name">งาน รปภ.</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_safe/setupsafeservice') ? ' active' : '' }}" href="{{ url('admin_safe/setupsafeservice') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทรายงาน</span>
                                        </a>
                                    </li> 
                                    
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_safe/setupevent') ? ' active' : '' }}" href="{{ url('admin_safe/setupevent')}}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">เหตุการณ์</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_safe/setupsafelocation') ? ' active' : '' }}" href="{{ url('admin_safe/setupsafelocation')}}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานที่เกิดเหตุ</span>
                                        </a>
                                    </li> 

                                 

                            </ul>


                            <li class="nav-main-item{{ request()->is('admin_asset_supplies/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-boxes"></i>
                                <span class="nav-main-link-name">งานทรัพย์สินและพัสดุ</span>
                            </a>
                            <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliespurchase') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliespurchase') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ทะเบียนคุม</span>
                                        </a>
                                    </li> 
                                    
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliestypekind') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliestypekind') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทพัสดุ</span>
                                        </a>
                                    </li> 
                                    
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesunit') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesunit') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หน่วยนับ</span>
                                        </a>
                                    </li> 

                                   <!-- <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesdepsubsup') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesdepsubsup') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">คลังย่อย</span>
                                        </a>
                                    </li> -->

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliestypelist') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliestypelist') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทรายการ</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliestypebudget') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliestypebudget') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทเงิน</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliestype') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliestype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หมวด/ประเภทพัสดุ</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesbuy') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesbuy') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">วิธีการจัดซื้อ/จัดจ้าง</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesbrand') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesbrand') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ยี่ห้อสินค้า</span>
                                        </a>
                                    </li>  

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesmodel') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesmodel') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">รุ่นสินค้า</span>
                                        </a>
                                    </li>  
                                    <!--<li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesinven') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesinven') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">คลังวัสดุ</span>
                                        </a>
                                    </li>  -->
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliestrimart') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliestrimart') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ไตรมาส</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesordertype') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesordertype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทการเบิก</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliespriceref') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliespriceref') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">แหล่งอ้างอิง</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesposition') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesposition') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ตำแหน่งกรรมการ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesstatusregis') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesstatusregis') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานะทะเบียนคุม</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesmethod') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesmethod') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">วิธีการจัดหา</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesdecline') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesdecline') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">อัตราค่าเสื่อมราคา</span>
                                        </a>
                                    </li>   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesconpremise') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesconpremise') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หลักฐานการรับ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliescontypelist') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliescontypelist') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทสินค้าที่รับ</span>
                                        </a>
                                    </li> 
                                    <!--<li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsupplieslocation') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsupplieslocation') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานที่ตั้งอาคาร</span>
                                        </a>
                                    </li>  --> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesexpiretype') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesexpiretype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">แทงจำหน่าย</span>
                                        </a>
                                    </li>   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesboardlist') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesboardlist') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กลุ่มกรรมการ</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliestypemaster') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliestypemaster') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ชนิดพัสดุหลัก</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliessendmoneyitem') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliessendmoneyitem') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ส่งการเงิน</span>
                                        </a>
                                    </li>  
                                  <!--<li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_car/setupcaraccessory') ? ' active' : '' }}" href="{{ url('admin_car/setupcaraccessory') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">พัสดุเบิกได้เฉพาะ</span>
                                        </a>
                                    </li>--->
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupsuppliesvendor') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesvendor') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ผู้แทนจำหน่าย</span>
                                        </a>
                                    </li>   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_asset_supplies/setupassettypevalue') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupassettypevalue') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทตามมูลค่า</span>
                                        </a>
                                    </li>           


                                    
                            </ul>


                            
                            <li class="nav-main-item{{ request()->is('admin_repair_nomal/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-wrench"></i>
                                <span class="nav-main-link-name">งานซ่อมบำรุง</span>
                            </a>
                            <ul class="nav-main-submenu">
                              
                                   
                                  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_nomal/Setupinformcompriority') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcompriority') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ความเร่งด่วนการซ่อม</span>
                                        </a>
                                    </li> 
                                    
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_nomal/Setupinformrepairtech') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformrepairtech') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">นายช่างประจำศูนย์ซ่อม</span>
                                        </a>
                                    </li> 

                                      
                               

                            </ul>


                            <li class="nav-main-item{{ request()->is('admin_repair_com/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-tv"></i>
                                <span class="nav-main-link-name">ศูนย์คอมพิวเตอร์</span>
                            </a>
                            <ul class="nav-main-submenu">

                            <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomtype') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomtype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทคอม</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomengineer') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomengineer') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ช่างซ่อมคอม</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setuprepairpriority') ? ' active' : '' }}" href="{{ url('admin_repair/Setuprepairpriority') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ความเร่งด่วนในการซ่อมคอม</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomhardware') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomhardware') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภท/รุ่น</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomlocation') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomlocation') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">*สถานที่ตั้ง</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/SetupInformcomstatus') ? ' active' : '' }}" href="{{ url('admin_repair/SetupInformcomstatus') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานะคอม</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomprogram') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomprogram') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">โปรแกรม</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcombrand') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcombrand') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ยี่ห้อรุ่น</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomcolor') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomcolor') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สี</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomsize') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomsize') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ขนาด</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomrepairlist') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomrepairlist') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">รายการซ่อม</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/setupsuppliesstatusregis') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesstatusregis') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">อะไหล่ซ่อม/เชื่อมวัสดุ</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomsupplierrepair') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomsupplierrepair') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ร้านซ่อม</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcomrepairtype') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcomrepairtype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทซ่อม</span>
                                        </a>
                                    </li>   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupinformcombuilding') ? ' active' : '' }}" href="{{ url('admin_repair/Setupinformcombuilding') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ข้อมูลอาคาร</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/Setupservicelist') ? ' active' : '' }}" href="{{ url('admin_repair/Setupservicelist') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">บริการอื่นๆ</span>
                                        </a>
                                    </li> 
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_com/setupsupplieslocation') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsupplieslocation') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทแม็บครุภัณฑ์</span>
                                        </a>
                                    </li>



                            </ul>


                            <li class="nav-main-item{{ request()->is('admin_repair_m/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-stethoscope"></i>
                                <span class="nav-main-link-name">ศูนย์เครื่องมือแพทย์</span>
                            </a>
                            <ul class="nav-main-submenu">

                            <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/Setupassetpadoctool') ? ' active' : '' }}" href="{{ url('admin_repair/Setupassetpadoctool') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">เครื่องมือสอบเทียบ</span>
                                        </a>
                                    </li>   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/Setupassetpaardoctype') ? ' active' : '' }}" href="{{ url('admin_repair/Setupassetpaardoctype') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทสอบเทียบ</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/Setupassetpaardocmedical') ? ' active' : '' }}" href="{{ url('admin_repair/Setupassetpaardocmedical') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทเครื่องมือ</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/Setupassetpadoccalibration') ? ' active' : '' }}" href="{{ url('admin_repair/Setupassetpadoccalibration') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">หน่วยงานสอบเทียบ</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/Setupassetpadoccheck') ? ' active' : '' }}" href="{{ url('admin_repair/Setupassetpadoccheck') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ผลการตรวจเช็ค</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/Setupassetpaardocleader') ? ' active' : '' }}" href="{{ url('admin_repair/Setupassetpaardocleader') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">คณะกรรมการจัดการ</span>
                                        </a>
                                    </li>      
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/setupsuppliesvendor') ? ' active' : '' }}" href="{{ url('admin_asset_supplies/setupsuppliesvendor') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ความสำคัญเครื่องมือ</span>
                                        </a>
                                    </li>       
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_repair_m/Setupassetcareenginer') ? ' active' : '' }}" href="{{ url('admin_repair/Setupassetcareenginer') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ช่างภายในผู้ดูแล</span>
                                        </a>
                                    </li>        

                            </ul>
          <li class="nav-main-item{{ request()->is('admin_warehouse/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-box-open "></i>
                                <span class="nav-main-link-name">คลังสินค้า</span>
                            </a>
                            <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_warehouse/setupsuppliesinven') ? ' active' : '' }}" href="{{ url('admin_warehouse/setupsuppliesinven') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">คลังวัสดุ</span>
                                        </a>

                                        </li> 
                                        <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_warehouse/setupwarehousedepsubsup') ? ' active' : '' }}" href="{{ url('admin_warehouse/setupwarehousedepsubsup') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">คลังย่อย</span>
                                        </a>
                                         </li> 
                                         <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_warehouse/setupwarehousestatuscheck') ? ' active' : '' }}" href="{{ url('admin_warehouse/setupwarehousestatuscheck') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานะตรวจรับ</span>
                                        </a>
                                         </li> 
                                         <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_warehouse/setupwarehousetypereceive') ? ' active' : '' }}" href="{{ url('admin_warehouse/setupwarehousetypereceive') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทการรับ</span>
                                        </a>
                                         </li> 
                                         <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_warehouse/setupwarehousetypecycle') ? ' active' : '' }}" href="{{ url('admin_warehouse/setupwarehousetypecycle') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">รอบการเบิก</span>
                                        </a>
                                         </li> 
                                         <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_warehouse/setupwarehousestatusdisburse') ? ' active' : '' }}" href="{{ url('admin_warehouse/setupwarehousestatusdisburse') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานะเบิก</span>
                                        </a>
                                         </li> 
                                         <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_warehouse/setupwarehousetypedisburse') ? ' active' : '' }}" href="{{ url('admin_warehouse/setupwarehousetypedisburse') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภท</span>
                                        </a>
                                         </li> 
                            </ul>
                            <li class="nav-main-item{{ request()->is('admin_compensation/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-hand-holding-usd"></i>
                                <span class="nav-main-link-name">เงินเดือนค่าตอบแทน</span>
                            </a>

                            <ul class="nav-main-submenu">

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_compensation/setupcompensationacc') ? ' active' : '' }}" href="{{ url('admin_compensation/setupcompensationacc') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">บัญชีเงินเดือน</span>
                                        </a>
                                    </li>   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_compensation/setupcompensationlist') ? ' active' : '' }}" href="{{ url('admin_compensation/setupcompensationlist') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">รายการรับจ่าย</span>
                                        </a>
                                    </li>   
                            </ul>



                                    <li class="nav-main-item{{ request()->is('admin_other/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-hand-holding-usd"></i>
                                <span class="nav-main-link-name">อื่นๆ</span>
                            </a>
                            <ul class="nav-main-submenu">

                            <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_other/setupinfopublicityimage') ? ' active' : '' }}" href="{{ url('admin_other/setupinfopublicityimage') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ข่าวประชาสัมพันธ์</span>
                                        </a>
                                    </li> 

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_other/setuplinetoken') ? ' active' : '' }}" href="{{ url('admin_other/setuplinetoken') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">LINE GROUP</span>
                                        </a>
                                    </li> 
                             

                            </ul>

                            <li class="nav-main-item{{ request()->is('admin_risk/*') ? ' open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                <i class="nav-main-link-icon fa fa-hand-holding-usd"></i>
                                <span class="nav-main-link-name">อุบัติการณ์ความเสี่ยง</span>
                            </a>

                            <ul class="nav-main-submenu">

                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_group') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_group') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กลุ่มอุบัติการณ์ความเสี่ยง</span>
                                        </a>
                                    </li>   
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_category') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_category') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ประเภทอุบัติการณ์ความเสี่ยง</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_setting') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_setting') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">อุบัติการณ์ความเสี่ยง</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_groupuser') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_groupuser') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">กลุ่มผู้ใช้</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_level') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_level') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">ระดับความรุนแรง</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_location') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_location') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">แหล่งที่มา/วิธีการค้นพบอุบัติการณ์ความเสี่ยง</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_origin') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_origin') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">สถานที่เกิดเหตุ</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_listdataset') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_listdataset') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">รายการชุดข้อมูลกลางของระบบ(Data set)</span>
                                        </a>
                                    </li>  
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('admin_risk/setupincidence_sub') ? ' active' : '' }}" href="{{ url('admin_risk/setupincidence_sub') }}">
                                            <span class="nav-main-link-name" style="font-weight: normal;">อุบัติการณ์ความเสี่ยงย่อย(ภายใน รพ.)</span>
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
                        <button onclick="window.location.href='{{ url('changpassword') }}' " type="button" class="btn btn-dual" >
                            <i class=" fa fa-key"></i> 
                        </button>
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
