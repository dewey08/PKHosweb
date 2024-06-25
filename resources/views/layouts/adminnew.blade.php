<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin Free Bootstrap Admin Dashboard Template</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assetsnew/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assetsnew/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assetsnew/vendors/css/vendor.bundle.addons.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assetsnew/css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('assetsnew/images/favicon.png') }}" />
</head>
<style>
  #button{
         display:block;
         margin:20px auto;
         padding:10px 30px;
         background-color:#eee;
         border:solid #ccc 1px;
         cursor: pointer;
         }
         #overlay{	
         position: fixed;
         top: 0;
         z-index: 100;
         width: 100%;
         height:100%;
         display: none;
         background: rgba(0,0,0,0.6);
         }
         .cv-spinner {
         height: 100%;
         display: flex;
         justify-content: center;
         align-items: center;  
         }
         .spinner {
         width: 250px;
         height: 250px;
         border: 5px #ddd solid;
         border-top: 10px #fd0909 solid;
         border-radius: 50%;
         animation: sp-anime 0.8s infinite linear;
         }
         @keyframes sp-anime {
         100% { 
             transform: rotate(360deg); 
         }
         }
         .is-hide{
         display:none;
         }
</style>
<body>
   <!-- Loader -->
   <div id="preloader">
    <div id="status">
        <div class="spinner">
           
        </div>
    </div>
</div>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-dark">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html">
          <img src="images/logo.svg" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.html">
          <img src="images/logo-mini.svg" alt="logo" />
        </a>
      </div>
     
          </li>
          <li class="nav-item dropdown d-none d-xl-inline-block">
          
              <span class="profile-text">{{ Auth::user()->name }}</span>
             
        
           
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav ">
          
          <li class="nav-item">
            <a class="nav-link" href="index.html">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">หน้าหลัก</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">บุคลากร</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="pages/ui-features/buttons.html">ข้อมูลบุคลากร</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/ui-features/typography.html">ข้อมูลการศึกษา</a>
                </li>
              </ul>
            </div>
          </li>
       
          <li  class="nav-item">
          <a class="nav-link" href="{{ url('about') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">    <i class="menu-icon mdi mdi-television"></i>ออกจากระบบ</a>
                                       
                               
                                   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
          </li>
       
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
   @yield('footer')
  <!-- plugins:js -->
  <script src="{{ asset('assetsnew/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assetsnew/vendors/js/vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->
 
 
</body>

</html>