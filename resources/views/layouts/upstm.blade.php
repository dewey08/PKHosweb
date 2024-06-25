 
 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>@yield('title')</title>

      <!-- Font Awesome -->
      <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
      <!-- App favicon -->
      <link rel="shortcut icon" href="{{ asset('pkclaim/images/logo150.ico') }}">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('telemed/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('telemed/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('telemed/assets/css/templatemo-onix-digital.css') }}">
    <link rel="stylesheet" href="{{ asset('telemed/assets/css/animated.css') }}">
    <link rel="stylesheet" href="{{ asset('telemed/assets/css/owl.css') }}">
   
  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.html" class="logo">
              {{-- <img src="{{ asset('telemed/assets/images/logo.png') }}"> --}}
              <img src="{{ asset('sky16/images/logo250.png') }}" width="60" height="60">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              {{-- <li class="scroll-to-section"><a href="#top" class="active">Home</a></li> --}}
              <li class="scroll-to-section"><a href="#top">Home</a></li>
              <li class="scroll-to-section"><a href="{{url('import_stm')}}"> STM SSOP</a></li>
              <li class="scroll-to-section"><a href="{{url('stm_aipn')}}">STM AIPN</a></li>

              <li class="scroll-to-section"><a href="{{url('import_rep_aipn')}}">REP AIPN</a></li>
              {{-- <li class="scroll-to-section"><a href="#portfolio">Portfolio</a></li> --}}
              {{-- <li class="scroll-to-section"><a href="#video">Videos</a></li>  --}}
              {{-- <li class="scroll-to-section"><a href="#contact">Contact Us</a></li>  --}}
              <li class="scroll-to-section"><div class="main-red-button-hover">
                {{-- <a href="#register">ลงทะเบียน</a> --}}
              </div></li> 
            </ul>        
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->


 
       
        <div class="main-content">

            <div class="page-content">

                @yield('content')

            </div>
            <!-- End Page-content -->
 
        </div>
        <!-- end main content-->
  
 
  
    <div class="footer-dec">
        <img src="{{ asset('telemed/assets/images/footer-dec.png') }}" alt="">
      </div>
    
      <footer>
        <div class="container">
          <div class="row">
            <div class="col-lg-3">
              <div class="about footer-item">
                <div class="logo">
                  <a href="#"><img src="assets/images/logo.png" alt="Onix Digital TemplateMo"></a>
                </div>
                <a href="#">dekbanbanproject@gmail.com</a>
                <ul>
                  <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="#"><i class="fa fa-behance"></i></a></li>
                  <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="services footer-item">
                <h4>Services</h4>
                <ul>
                  <li><a href="#">Phukieo Hospital.</a></li>
                  {{-- <li><a href="#">Phukieo Hospital.</a></li> --}}
                  {{-- <li><a href="#">Phukieo Hospital.</a></li> --}}
                  {{-- <li><a href="#">Phukieo Hospital.</a></li> --}}
                </ul>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="community footer-item">
                <h4>Community</h4>
                <ul>
                  <li><a href="#">Phukieo Hospital.</a></li>
                  {{-- <li><a href="#">Phukieo Hospital.</a></li> --}}
                  {{-- <li><a href="#">Phukieo Hospital.</a></li> --}}
                  {{-- <li><a href="#">Phukieo Hospital.</a></li> --}}
                </ul>
              </div>
            </div>
            <div class="col-lg-3">
              <div class="subscribe-newsletters footer-item">
                <h4>Subscribe Newsletters</h4>
                <p>Get our latest news to your inbox</p>
                <form action="#" method="get">
                  <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email" required="">
                  <button type="submit" id="form-submit" class="main-button "><i class="fa fa-paper-plane-o"></i></button>
                </form>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="copyright">
                <p>Copyright © 2023 Phukieo Hospital. All Rights Reserved. 
                <br>
                {{-- Designed by <a rel="nofollow" href="https://templatemo.com" title="free CSS templates">TemplateMo</a><br> --}}
                Designed by <a href="http://www.phukieo.net">Pradit Raha</a>
              </p>
              </div>
            </div>
    
          </div>
        </div>
      </footer>
    
    
      <!-- Scripts -->
      <script src="{{ asset('telemed/vendor/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('telemed/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('telemed/assets/js/owl-carousel.js') }}"></script>
      <script src="{{ asset('telemed/assets/js/animation.js') }}"></script>
      <script src="{{ asset('telemed/assets/js/imagesloaded.js') }}"></script>
      <script src="{{ asset('telemed/assets/js/custom.js') }}"></script>
    
      @yield('footer')
      <script>
      // Acc
        $(document).on("click", ".naccs .menu div", function() {
          var numberIndex = $(this).index();
    
          if (!$(this).is("active")) {
              $(".naccs .menu div").removeClass("active");
              $(".naccs ul li").removeClass("active");
    
              $(this).addClass("active");
              $(".naccs ul").find("li:eq(" + numberIndex + ")").addClass("active");
    
              var listItemHeight = $(".naccs ul")
                .find("li:eq(" + numberIndex + ")")
                .innerHeight();
              $(".naccs ul").height(listItemHeight + "px");
            }
        });
      </script>
    </body>
    </html>
 