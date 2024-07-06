 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>PK-OFFICER</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <link href="{{ asset('medical/assets/img/logo150.ico') }}" rel="icon">
    {{-- <link href="{{ asset('medical/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Vendor CSS Files -->
    <link href="{{ asset('medical/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('medical/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Variables CSS Files. Uncomment your preferred color scheme -->
    <link href="{{ asset('medical/assets/css/variables.css') }}" rel="stylesheet">
 
    <!-- Template Main CSS File -->
    <link href="{{ asset('medical/assets/css/main.css') }}" rel="stylesheet"> 
    
    
    <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/css/util.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('Login_v1/css/main.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/dcss.css') }}"> --}}
   
</head>
<style>
    .modal-dialog2 {
            max-width: 100%;
        }
        .modal-dialog-slideout {
            min-height: 100%;
            margin: 0 0 0 auto;
            background: #fff;
        }
        /* .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(1);
            transform: translate(100%, 0)scale(1);
        } */
        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
        .bgbody{
            /* width: 100%; */
            /* height: 100vh; */
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
                url(/pkbackoffice/public/assets/images/lg.png)no-repeat 50%; 
            /* background-size: cover; */
            /* background-attachment: fixed; */
            /* display: flex; */
            /* align-items: center; */
            /* justify-content: center; */
        }
        .dcheckbox{        
            border: 30px solid teal; 
            box-shadow: 0 0 10px teal; 
        }
        $position-values: (
            0: 0,
            50: 50%,
            100: 100%
        );
        .modal-loginflex {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flexbox;
            display: -o-flex;
            display: flex;
            flex-flow:column nowrap; /*Add this */
            justify-content: center;
            -ms-justify-content: center;
            -ms-flex-pack: center;
            align-items: center;
            }

</style>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top" data-scrollto-offset="0">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <a href="" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                 <img src="{{ asset('medical/assets/img/logo150.png') }}" alt="" class="me-2">  
                <h2 class="mt-2">Phukieo Chalermprakiat Hospital<span></span></h2>
            </a>

            <nav id="navbar" class="navbar">
                <ul>   
                    <li><a class="nav-link scrollto" href="{{ url('/login') }}" target="_blank"><i class="fa-solid fa-house-chimney me-2"></i>Home</a></li> 
                    <li><a class="nav-link scrollto" href="#exsecutiva" target="_blank"><i class="fa-solid fa-person me-2"></i>คณะผู้บริหารงาน</a></li> 
                    <li><a class="nav-link scrollto" href="#vision" target="_blank"><i class="fa-solid fa-person me-2"></i>วิสัยทัศน์/พันธกิจ</a></li> 
                     {{-- <li class="dropdown "><a href="{{url('/login')}}">
                        <i class="fa-solid fa-house-chimney me-2"></i>
                        <span class="text-center">Home</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li class="dropdown "><a href="#">
                        <i class="fa-solid fa-address-book me-2"></i>
                        <span class="text-center">เกี่ยวกับเรา</span>  
                        <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="">ประวัติโรงพยาบาล</a></li>
                            <li><a href="#exsecutiva">คณะผู้บริหารงาน</a></li>
                            <li><a href="#vision">วิสัยทัศน์/พันธกิจ</a></li> 
                            <li><a href="#department">หน่วยงาน</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown "><a href="#contact">
                        <i class="fa-regular fa-address-book me-2"></i>
                        <span class="text-center">Contact</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li class="dropdown "><a href="{{url('report_dashboard')}}">
                        <i class="fa-solid fa-chart-line me-2"></i>
                        <span class="text-center">Report</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    <li><a class="nav-link scrollto" href="#contact"><i class="fa-regular fa-address-book me-2"></i>Contact</a></li> 
                    <li><a href="{{ url('report_dashboard') }}" target="_blank"><i class="fa-solid fa-chart-line me-2"></i>Report</a></li> 
               
                    {{-- <li class="dropdown"><a href="#"> <i class="fa-solid fa-download me-2"></i><span>Download</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                    
                          <li class="dropdown"><a href="#"><span>รายงานการประชุม รพ.</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                              <li><a href="#">ปี พศ.2560</a></li>
                              <li><a href="#">ปี พศ.2561</a></li>
                              <li><a href="#">ปี พศ.2562</a></li>
                              <li><a href="#">ปี พศ.2563</a></li>
                              <li><a href="#">ปี พศ.2564</a></li>
                              <li><a href="#">ปี พศ.2565</a></li>
                              <li><a href="#">ปี พศ.2566</a></li>
                            </ul>
                          </li>
                          <li class="dropdown"><a href="#"><span>รายงานการประชุม คปสอ.</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                              <li><a href="#">ปี พศ.2560</a></li>
                              <li><a href="#">ปี พศ.2561</a></li>
                              <li><a href="#">ปี พศ.2562</a></li>
                              <li><a href="#">ปี พศ.2563</a></li>
                              <li><a href="#">ปี พศ.2564</a></li>
                              <li><a href="#">ปี พศ.2565</a></li>
                              <li><a href="#">ปี พศ.2566</a></li>
                            </ul>
                          </li>
                          <li class="dropdown"><a href="#"><span>รายงานการประชุม คปสอ.</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                              <li><a href="#">ปี พศ.2560</a></li>
                              <li><a href="#">ปี พศ.2561</a></li>
                              <li><a href="#">ปี พศ.2562</a></li>
                              <li><a href="#">ปี พศ.2563</a></li>
                              <li><a href="#">ปี พศ.2564</a></li>
                              <li><a href="#">ปี พศ.2565</a></li>
                              <li><a href="#">ปี พศ.2566</a></li>
                            </ul>
                          </li>
                          <li><a href="#">แบบฟอร์มต่างๆ</a></li> 
                        </ul>
                    </li> --}}

                    {{-- <li class="dropdown "><a data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal">
                        <i class="fa-solid fa-fingerprint me-2"></i>
                        <span class="text-center">Login</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li class="dropdown "><a href="{{url('authen_main')}}">
                        <i class="fa-solid fa-person me-2"></i>
                        <span class="text-center">Authen</span>  
                        <i class="bi bi-chevron-down dropdown-indicator" style="color: transparent"></i></a> 
                    </li> --}}
                    {{-- <li><a class="nav-link scrollto" href="#login"><i class="fa-solid fa-fingerprint me-2"></i>Login</a></li> --}}
                    <li> <a href="" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal"><i class="fa-solid fa-fingerprint me-2"></i>Login</a> </li> 
                    {{-- <li><a href="{{ url('authen_main') }}" target="_blank"><i class="fa-solid fa-person me-2" style="font-size: 15px"></i>Authen</a></li>  --}}
                </ul> 
                <i class="bi bi-list mobile-nav-toggle d-none"></i>
            </nav>
            <!-- .navbar -->
 
        </div>
    </header><!-- End Header -->

    <section id="hero-fullscreen" class="hero-fullscreen d-flex align-items-center">
        <div class="container d-flex flex-column align-items-center position-relative" data-aos="zoom-out">
            <h2>Welcome to <span>Phukieo Chalermprakiat Hospital</span></h2>
            <p>เป็นโรงพยาบาลตัวอย่าง ด้านคุณภาพความปลอดภัยและประทับใจ.</p>
            <div class="d-flex">
                <a href="#about" class="btn-get-started scrollto">Get Started</a>
                {{-- <a href="" --}}
                <a href="https://www.youtube.com/watch?v=7VTjCocVzFM"
                    class="btn btn-outline-info glightbox btn-watch-video d-flex align-items-center">
                    <i class="bi bi-play-circle"></i><span>Watch Video</span>
                </a>
            </div>
        </div>
    </section>

    <main id="main">

        <!-- ======= Featured Services Section กล่องประชาสัมพันธ์======= -->
        <section id="featured-services" class="featured-services">
            <div class="container">

                <div class="row gy-4">

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-activity icon"></i></div>
                            <h4><a href="" class="stretched-link">ข่าวสาร</a></h4>
                            <p>ประชาสัมพันธ์</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                            <h4><a href="" class="stretched-link">ประชาสัมพันธ์</a></h4>
                            <p>public relations</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                            <h4><a href="" class="stretched-link">ประกาศจัดซื้อจัดจ้าง</a></h4>
                            <p>Procurement Announcement</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-out" data-aos-delay="600">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                            <h4><a href="" class="stretched-link">ประกาศรับสมัครงาน<br>และผลสอบ</a></h4>
                            <p>Job announcement</p>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>
        </section><!-- End Featured Services Section -->

        <!-- ======= About Section ======= -->
        <section id="vision" class="about">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>วิสัยทัศน์ (Vision)</h2>
                    {{-- <p>เป็นโรงพยาบาลตัวอย่าง ด้านคุณภาพความปลอดภัยและประทับใจ.</p> --}}
                    <h4 >เป็นโรงพยาบาลตัวอย่าง ด้านคุณภาพความปลอดภัยและประทับใจ.</h4>
                    <img src="{{ asset('medical/assets/img/visio.jpg') }}" class="img-fluid mt-2" alt="">
                </div>

                <div class="row g-4 g-lg-5" data-aos="fade-up" data-aos-delay="200">

                    {{-- <div class="col-lg-3">
                        <div class="about-img">
                            <img src="assets/img/about.jpg" class="img-fluid" alt="">
                        </div>
                    </div> --}}

                    <div class="col-lg-12">
                        {{-- <h4 class="pt-0 pt-lg-5">เป็นโรงพยาบาลตัวอย่าง ด้านคุณภาพความปลอดภัยและประทับใจ.</h4> --}}

                        <!-- Tabs -->
                        <ul class="nav nav-pills mb-3">
                            <li><a class="nav-link active" data-bs-toggle="pill" href="#tab1">พันธกิจ (Missions)</a></li>
                            <li><a class="nav-link" data-bs-toggle="pill" href="#tab2">ยุทธศาสตร์(Strategic Issue)</a></li>
                            <li><a class="nav-link" data-bs-toggle="pill" href="#tab3">วัตถุประสงค์เชิงกลยุทธ์(Strategic Objectives)</a></li>
                            <li><a class="nav-link" data-bs-toggle="pill" href="#tab4">จุดเน้น/เข็มมุ่ง(Key Focus Area)</a></li>
                        </ul><!-- End Tabs -->

                        <!-- Tab Content -->
                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="tab1">

                                {{-- <p class="fst-italic">1.พัฒนาการให้บริการที่มีคุณภาพและปลอดภัย</p> --}}

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>1.พัฒนาการให้บริการที่มีคุณภาพและปลอดภัย</h4>
                                </div>
                                {{-- <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi
                                    dolorum non eveniet magni quaerat nemo et.</p> --}}

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>2.พัฒนาระบบการดูแลรักษาและการส่งต่อระหว่างเครือข่ายให้มีความปลอดภัย ไร้รอยต่อ</h4>
                                </div>
                                {{-- <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta
                                    tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at.
                                    Dolorem quo tempora. Quia et perferendis.</p> --}}

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>3.พัฒนาระบบการจัดการและสนับสนุนการให้บริการด้านสุขภาพ</h4>
                                </div>
                                {{-- <p>Eius alias aut cupiditate. Dolor voluptates animi ut blanditiis quos nam. Magnam
                                    officia aut ut alias quo explicabo ullam esse. Sunt magnam et dolorem eaque magnam
                                    odit enim quaerat. Vero error error voluptatem eum.</p> --}}

                            </div><!-- End Tab 1 Content -->

                            <div class="tab-pane fade show" id="tab2">

                                {{-- <p class="fst-italic">tab2 Consequuntur inventore voluptates consequatur aut vel et. Eos
                                    doloribus expedita. Sapiente atque consequatur minima nihil quae aspernatur quo
                                    suscipit voluptatem.</p> --}}

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>1.ส่งเสริมสุขภาพ ป้องกันโรค และคุ้มครองผู้บริโภคอย่างมีประสิทธิภาพ</h4>
                                </div>
                                {{-- <p>Laborum omnis voluptates voluptas qui sit aliquam blanditiis. Sapiente minima commodi
                                    dolorum non eveniet magni quaerat nemo et.</p> --}}

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>2.พัฒนาระบบบริการสุขภาพ(Service Plan)</h4>
                                </div>
                                {{-- <p>Non quod totam minus repellendus autem sint velit. Rerum debitis facere soluta
                                    tenetur. Iure molestiae assumenda sunt qui inventore eligendi voluptates nisi at.
                                    Dolorem quo tempora. Quia et perferendis.</p> --}}

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>3.พัฒนาศักยภาพบุคลากรและองค์กรแห่งความสุข</h4>
                                </div>
                                {{-- <p>Eius alias aut cupiditate. Dolor voluptates animi ut blanditiis quos nam. Magnam
                                    officia aut ut alias quo explicabo ullam esse. Sunt magnam et dolorem eaque magnam
                                    odit enim quaerat. Vero error error voluptatem eum.</p> --}}
                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>4.พัฒนาระบบการจัดการและสนับสนุนการให้บริการด้านสุขภาพ</h4>
                                </div>

                            </div><!-- End Tab 2 Content -->

                            <div class="tab-pane fade show" id="tab3">
 

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>1.พัฒนาระบบส่งเสริมสุขภาพ ป้องกันโรค ในกลุ่มวัย(M1,S1)</h4>
                                </div>
                                
                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>2.พัฒนาระบบดูแลทางคลีนิค และระบบส่งต่อระหว่างเครือข่ายให้มีคุณภาพและปลอดภัย(M1,M2,S2)</h4>
                                </div>
                                

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>3.พัฒนาศักยภาพบุคลากร ส่งเสริมสุขภาพดี มีความสุขของบุคลากร (M3,S3)</h4>
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>4.พัฒนาระบบเทคโนโลยี่สารสนเทศ สนับสนุนระบบบริการ (M3,S4)</h4>
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>5.พัฒนาให้เป็นองค์กรคุณภาพ (M3,S4)</h4>
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>6.ส่งเสริมการให้บริการที่เป็นเลิศ (M1,S2,S3)</h4>
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>7.สร้างความมั่นคงทางด้านการเงิน (M3,S4)</h4>
                                </div>
                                 
                            </div><!-- End Tab 3 Content -->

                            <div class="tab-pane fade show" id="tab4">

                                {{-- <p class="fst-italic">tab2 Consequuntur inventore voluptates consequatur aut vel et. Eos
                                    doloribus expedita. Sapiente atque consequatur minima nihil quae aspernatur quo
                                    suscipit voluptatem.</p> --}}

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>1.การพัฒนาความปลอดภัยในการดูแลผู้ป่วย</h4>
                                </div>
                               

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>2.องค์กรแห่งความสุข</h4>
                                </div>
                              
                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>3.ความมั่นคงทางด้านการเงินและการคลัง</h4>
                                </div>
                             
                            </div><!-- End Tab 2 Content -->

                        </div>

                    </div>

                </div>

            </div>
        </section>
        <!-- End About Section -->
  
        <!-- ======= Team Section ======= -->
        <section id="exsecutiva" class="team">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>โครงสร้างบริหารงาน</h2>
                    <p>โครงสร้างบริหารงานโรงพยาบาลภูเขียวเฉลิมพระเกียรติ อำเภอภูเขียว จังหวัดชัยภูมิ</p>
                    
                </div>

                <div class="row gy-5">
                    <div class="col"></div>
                    {{-- <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="200">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h4>Walter White</h4>
                                <span>Chief Executive Officer</span>
                            </div>
                        </div>
                    </div>  --}}
                   
                    <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/po.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h4>นายแพทย์สุภาพ สำราญวงษ์</h4>
                                <span>ผู้อำนวยการโรงพยาบาล</span>
                            </div>
                        </div>
                    </div> 
                    {{-- <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="600">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="member-info">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h4>William Anderson</h4>
                                <span>CTO</span>
                            </div>
                        </div>
                    </div>  --}}
                    <div class="col"></div>
                </div>
                <div class="row gy-5 mt-2">
                    <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="200">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/mo.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h5>นายสถาพร ป้อมสุวรรณ</h5>
                                <span>รองผู้อำนวยการฝ่ายบริหาร</span>
                            </div>
                        </div>
                    </div> 
                    <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/otinee.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h5>แพทย์หญิงโอทนี สุวรรณมาลี</h5>
                                <span>รองผู้อำนวยการฝ่ายการแพทย์</span>
                            </div>
                        </div>
                    </div> 
                    <div class="col-xl-4 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="600">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/satapon.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h5>นางสิริพร ศัลย์วิเศษ</h5>
                                <span>หัวหน้ากลุ่มภารกิจด้านการพยาบาล</span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row gy-5 mt-2">
                    {{-- <div class="col"></div> --}}
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/niwat.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h6>นายแพทย์นิวัฒน์ ขจัดพาล</h6>
                                <span>หัวหน้ากลุ่มภารกิจด้านพัฒนาระบบบริการและสนับสนุนบริการสุขภาพ(พรส)</span>
                            </div>
                        </div>
                    </div> 
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="400">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/naruemon.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h6>แพทย์หญิงนฤมล บำเพ็ญเกียรติกุล</h6>
                                <span>หัวหน้ากลุ่มภารกิจด้านบริการปฐมภูมิ</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex" style="" data-aos="zoom-in" data-aos-delay="600">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/Dent.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h6>ทันตแพทย์อตินาต ธรรมรัชสุนทร</h6>
                                <span>หัวหน้ากลุ่มภารกิจด้านทันตกรรม</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex" data-aos="zoom-in" data-aos-delay="800">
                        <div class="team-member">
                            <div class="member-img text-center">
                                <img src="{{ asset('medical/assets/img/IT.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="member-info mt-1">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                                <h6>นายปรเมษฐ แควภูเขียว</h6>
                                <span>หัวหน้ากลุ่มภารกิจสุขภาพดิจิทัล</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                 
                

            </div>
        </section><!-- End Team Section -->

        <!-- ======= Recent Blog Posts Section department======= -->
        <section id="department" class="recent-blog-posts">

            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>หน่วยงาน</h2>
                    <p>Department</p>
                </div>

                <div class="row">

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="post-box">
                            <div class="post-img">
                                <img src="{{ asset('medical/assets/img/mareng.jpg') }}" class="img-fluid" alt=""> 
                            </div>
                            <div class="meta">
                                <span class="post-date">Tue, December 12</span>
                                <span class="post-author"> / Julia Parker</span>
                            </div>
                            <h3 class="post-title">ศูนย์มะเร็ง</h3>
                            {{-- <p>Illum voluptas ab enim placeat. Adipisci enim velit nulla. Vel omnis laudantium.
                                Asperiores eum ipsa est officiis. Modi cupiditate exercitationem qui magni est...</p> --}}
                            <a href="" class="readmore stretched-link"><span>Read More</span><i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="400">
                        <div class="post-box">
                            <div class="post-img"> <img src="{{ asset('medical/assets/img/suti.jpg') }}" class="img-fluid" alt=""> </div>
                            <div class="meta">
                                <span class="post-date">Fri, September 05</span>
                                <span class="post-author"> / Mario Douglas</span>
                            </div>
                            <h3 class="post-title">สูตินรีเวชกรรม</h3>
                            {{-- <p>Voluptatem nesciunt omnis libero autem tempora enim ut ipsam id. Odit quia ab eum
                                assumenda. Quisquam omnis aliquid necessitatibus tempora consectetur doloribus...</p> --}}
                            <a href="" class="readmore stretched-link"><span>Read More</span><i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="600">
                        <div class="post-box">
                            <div class="post-img"> <img src="{{ asset('medical/assets/img/dental.jpg') }}" class="img-fluid" alt=""> </div>
                            <div class="meta">
                                <span class="post-date">Tue, July 27</span>
                                <span class="post-author"> / Lisa Hunter</span>
                            </div>
                            <h3 class="post-title">ทันตกรรม</h3>
                            {{-- <p>Quia nam eaque omnis explicabo similique eum quaerat similique laboriosam. Quis omnis
                                repellat sed quae consectetur magnam veritatis dicta nihil...</p> --}}
                            <a href="" class="readmore stretched-link"><span>Read More</span><i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="600">
                        <div class="post-box">
                            <div class="post-img"> <img src="{{ asset('medical/assets/img/aryu.jpg') }}" class="img-fluid" alt=""> </div>
                            <div class="meta">
                                <span class="post-date">Tue, July 27</span>
                                <span class="post-author"> / Lisa Hunter</span>
                            </div>
                            <h3 class="post-title">อายุรกรรม</h3>
                            {{-- <p>Quia nam eaque omnis explicabo similique eum quaerat similique laboriosam. Quis omnis
                                repellat sed quae consectetur magnam veritatis dicta nihil...</p> --}}
                            <a href="" class="readmore stretched-link"><span>Read More</span><i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- End Recent Blog Posts Section -->
  
         <!-- ======= Contact Section ======= -->
         <section id="login" class="contact mt-5">
            
            <div class="container">
             
                <div class="row">
                    {{-- <div class="col"></div>                    
                    <div class="col-md-4 d-flex" data-aos="zoom-out" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf 

                                <div class="form-group mt-3 text-center">
                                    <img src="{{ asset('images/logo150.png') }}" class="bi mb-3" width="150" height="150" alt="">
                                </div> 
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" >
                                </div>
                                <div class="form-group mt-3">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" >
                                </div> 
                                <div class="my-3"> </div>
                                <div class="text-center">
                                    <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"> <i class="fa-solid fa-fingerprint text-primary me-2"></i>เข้าสู่ระบบ</button>
                                </div>
                          
                        </div>
                    </div> 
                    </form> 
                    <div class="col"></div> --}}
                    {{-- <div class="limiter"> --}}
                        {{-- <div class="container-login100"> --}}
                        <div class="container">
                            {{-- <div class="wrap-login100 dcheckbox"> --}}
                            <div class="wrap-login100">
                                <div class="login100-pic js-tilt" data-tilt> 
                                    <img src="{{ asset('images/team.png') }}" width="500" height="250" alt="IMG">
                                </div> 
                                <form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
                                    @csrf
                                    {{-- <img src="{{ asset('images/logo_350.jpg') }}" width="100" height="100" alt="IMG">
                                    <br> --}}
                                    <span class="login100-form-title">
                                        <img src="{{ asset('images/logo_350.jpg') }}" width="120" height="120" alt="IMG"><br><br>
                                        เข้าสู่ระบบ
                                    </span>
                
                                    <div class="wrap-input100 validate-input" data-validate = "Username is required">
                                        <input class="input100" type="text" name="username" id="username" placeholder="Username">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </span>
                                    </div>
                
                                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
                                        <input class="input100" type="password" name="password" id="password" placeholder="Password">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    
                                    <div class="container-login100-form-btn">
                                        <button type="submit" class="login100-form-btn">
                                            Login
                                        </button>
                                    </div>
                
                                    <div class="text-center p-t-12">
                                        <span class="txt1">
                                            Forgot
                                        </span>
                                        <a class="txt2" href="#">
                                            Username / Password?
                                        </a>
                                    </div>
                
                                    <div class="text-center p-t-26">
                                        <a class="txt2" href="#">
                                            Create your Account
                                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    {{-- </div> --}}
                    
                </div>
               
            </div>
        </section>
        <!-- End Contact Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact mt-5">
            <div class="container">

                <div class="section-header">
                    <h2>Contact Us</h2>
                    <p>สอบถามข้อมูลเพิ่มเติมได้ที่นี่.</p>
                </div>

            </div>

            <div class="map">
    
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.970617774736!2d102.12411908484135!3d16.375459090829438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x312203324df99815%3A0xcd2f7b21c5895544!2z4LmC4Lij4LiH4Lie4Lii4Liy4Lia4Liy4Lil4Lig4Li54LmA4LiC4Li14Lii4Lin4LmA4LiJ4Lil4Li04Lih4Lie4Lij4Liw4LmA4LiB4Li14Lii4Lij4LiV4Li0!5e0!3m2!1sth!2sth!4v1692861084953!5m2!1sth!2sth" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <!-- End Google Maps -->

            <div class="container">

                <div class="row gy-5 gx-lg-5">

                    <div class="col-lg-4">

                        <div class="info">
                            <h3>Get in touch</h3>
                            <p>ติดต่อส่งข้อความถึงเรา.</p>

                            <div class="info-item d-flex">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h4>Location:</h4>
                                    <p>149 หมู่ 4 ตำบล ผักปัง อำเภอ ภูเขียว ชัยภูมิ 36110</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h4>Email:</h4>
                                    <p>info@example.com</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex">
                                <i class="bi bi-phone flex-shrink-0"></i>
                                <div>
                                    <h4>Call:</h4>
                                    <p>044-861700-3</p>
                                </div>
                            </div><!-- End Info Item -->

                        </div>

                    </div>

                    <div class="col-lg-8">
                        <form action="{{route('Cus.contact_save')}}" method="POST">
                            @csrf
                            {{-- id="Sendmessage" --}}
                            <div class="row ">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="patientpk_name" class="form-control" id="patientpk_name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="patientpk_email" id="patientpk_email" placeholder="Your Email" >
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="patientpk_subject" id="patientpk_subject" placeholder="Subject" >
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="patientpk_message" id="patientpk_message" placeholder="Message" rows="10" ></textarea>
                            </div>
                            <div class="my-3">
                                {{-- <div class="loading">Loading</div> --}}
                                {{-- <div class="error-message"></div> --}}
                                {{-- <div class="sent-message">Your message has been sent. Thank you!</div> --}}
                            </div>
                            <div class="text-center">
                                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">Send Message</button>
                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>
        </section>
        <!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="footer-content">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-info">
                            <h3>PHUKIEO CHALERMPRAKIAT HOSPITAL</h3>
                            <p>
                                149 หมู่ 4 ตำบล ผักปัง  <br>
                                อำเภอ ภูเขียว ชัยภูมิ 36110<br><br>
                                <strong>Phone:</strong> 044-861700-3<br>
                                <strong>Email:</strong> info@example.com<br>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Wb Pages</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="{{url('/')}}">Home</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#contact">Contact</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#exsecutiva">คณะผู้บริหารงาน</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#vision">วิสัยทัศน์/พันธกิจ</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#department">หน่วยงาน</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="footer-legal text-center">
            <div
                class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div class="copyright">
                        &copy; Copyright <strong><span>PHUKIEO CHALERMPRAKIAT HOSPITAL</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
                        Designed by <a href="">PK TAEM</a>
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>

            </div>
        </div>

    </footer><!-- End Footer -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- <div class="modal-dialog modal-dialog-slideout"> --}}
            <div class="modal-dialog">
            <div class="modal-content"> 
                    <div class="modal-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <br>
                            
                                <div class="container"> 
                                    <div class="row">
                                        <div class="col-md-1"> </div>
                                        <div class="col-md-11">
                                            <div class="d-flex justify-content-center">
                                                <span>
                                                    <img src="{{ asset('images/logo_350.jpg') }}" width="200" height="200" alt="IMG"><br><br> 
                                                </span> 
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2"><i class="fa-solid fa-user-large text-primary"></i></div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="wrap-input100 validate-input" data-validate = "กรุณาใส่ Username">
                                                    <input type="text" class="form-control input100" name="username" id="username" placeholder="Username" required> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end mt-2"><i class="fa-solid fa-key text-danger"></i></div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="wrap-input100 validate-input" data-validate = "กรุณาใส่ Password">
                                                    <input type="password" class="form-control input100" name="password" id="password" placeholder="Password" required>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col"></div>
                                        <div class="col-md-1 text-end"></div>
                                        <div class="col-md-5">
                                            <div class="mb-3">
                                                <button type="submit" class="login100-form-btn">
                                                    <i class="fa-solid fa-fingerprint me-3"></i>
                                                    Login
                                                </button>
                                              </div>
                                        </div> 
                                        <div class="col"></div>
                                    </div>
                                    <div class="text-center p-t-12">
                                        <span class="txt1">
                                            Forgot
                                        </span>
                                        <a class="txt2" href="#">
                                            Username / Password?
                                        </a>
                                    </div>
                                    <div class="text-center p-t-20">
                                        <a class="txt2" href="#">
                                            Create your Account
                                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                                        </a>
                                    </div>

                                </div>   
                                <br> <br>
                                {{-- </div> --}}
                                        {{-- <span class="login100-form-title">
                                            <img src="{{ asset('images/logo_350.jpg') }}" width="120" height="120" alt="IMG"><br><br>
                                            เข้าสู่ระบบ
                                        </span> --}}
                    
                                        {{-- <div class="wrap-input100 validate-input" data-validate = "Username is required">
                                            <input class="input100" type="text" name="username" id="username" placeholder="Username">
                                            <span class="focus-input100"></span>
                                            <span class="symbol-input100">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </span>
                                        </div> --}}
                    
                                        {{-- <div class="wrap-input100 validate-input" data-validate = "Password is required">
                                            <input class="input100" type="password" name="password" id="password" placeholder="Password">
                                            <span class="focus-input100"></span>
                                            <span class="symbol-input100">
                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                            </span>
                                        </div> --}}
                                        
                                        {{-- <div class="container-login100-form-btn">
                                            <button type="submit" class="login100-form-btn">
                                                Login
                                            </button>
                                        </div>
                     --}}
                                        {{-- <div class="text-center p-t-12">
                                            <span class="txt1">
                                                Forgot
                                            </span>
                                            <a class="txt2" href="#">
                                                Username / Password?
                                            </a>
                                        </div> --}}
                    
                                        {{-- <div class="text-center p-t-26">
                                            <a class="txt2" href="#">
                                                Create your Account
                                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    --}}



                                </form>     
                        </div>
                    

                    </div>         
            </div>
        </div>
    </div>



    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->

      <!--===============================================================================================-->	
	<script src="{{ asset('Login_v1/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
        <script src="{{ asset('Login_v1/vendor/bootstrap/js/popper.js') }}"></script>
        <script src="{{ asset('Login_v1/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

       
  
    {{-- <script src="{{ asset('pkclaim/libs/jquery/jquery.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('Login_v1/vendor/bootstrap/js/popper.js') }}"></script> --}}
    <script src="{{ asset('medical/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('medical/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('medical/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    {{-- <script src="{{ asset('medical/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}') }}"></script> --}}
    <script src="{{ asset('medical/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('medical/assets/vendor/php-email-form/validate.js') }}"></script> 
    <script src="{{ asset('medical/assets/js/main.js') }}"></script> 
    <script src="{{ asset('pkclaim/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.th.min.js"
        integrity="sha512-cp+S0Bkyv7xKBSbmjJR0K7va0cor7vHYhETzm2Jy//ZTQDUvugH/byC4eWuTii9o5HN9msulx2zqhEXWau20Dg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <!-- Required datatable js -->
   <script src="{{ asset('pkclaim/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
   <script src="{{ asset('pkclaim/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
      <!--===============================================================================================-->
      <script src="{{ asset('Login_v1/vendor/select2/select2.min.js') }}"></script>
      <!--===============================================================================================-->
          <script src="{{ asset('Login_v1/vendor/tilt/tilt.jquery.min.js') }}"></script>
          <script >
              $('.js-tilt').tilt({
                  scale: 1.1
              })
          </script>
           <script src="{{ asset('Login_v1/js/main.js') }}"></script>
      <!--===============================================================================================-->
    <script>
        
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
   
            $('#Sendmessage').on('submit',function(e){
                    e.preventDefault();
                    var form = this;
                    $.ajax({
                      url:$(form).attr('action'),
                      method:$(form).attr('method'),
                      data:new FormData(form),
                      processData:false,
                      dataType:'json',
                      contentType:false,
                      beforeSend:function(){
                        $(form).find('span.error-text').text('');
                      },
                      success:function(data){
                        if (data.status == 0 ) {

                        } else {
                          Swal.fire({
                            title: 'แก้ไขข้อมูลสำเร็จ',
                            text: "You edit data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'เรียบร้อย'
                          }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                          })
                        }
                      }
                    });
            });   
            
            $('#Savedata').click(function() {
                    var patientpk_name = $('#patientpk_name').val();
                    var patientpk_email = $('#patientpk_email').val();
                    var patientpk_subject = $('#patientpk_subject').val();
                    var patientpk_message = $('#patientpk_message').val(); 
                alert(patientpk_name);
                    $.ajax({
                        url: "{{ route('Cus.contact_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            patientpk_name,patientpk_email,patientpk_subject,patientpk_message 
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'ส่งข้อมูลสำเร็จ',
                                    text: "You Send data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result
                                        .isConfirmed) {
                                        console.log(
                                            data);
                                        window.location.reload();
                                        // window.location="{{ url('warehouse/warehouse_index') }}";
                                    }
                                })
                            } else {

                            }

                        },
                    });
            });
             
        });
       
    </script>
</body>

</html>

 
