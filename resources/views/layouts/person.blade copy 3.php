<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">
    {{-- <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script> --}}
   
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script> --}}

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tableperson.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontuser.css') }}" rel="stylesheet">
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('assets/css/mdb.min.css') }}" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('lib/webviewer.min.js') }}"></script> --}}
  
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
       <!-- Font Awesome -->
       <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">  
       {{-- <link href="{{ asset('css/sizebar.css') }}" rel="stylesheet"> --}}
       <link href="{{ asset('css/tableperson.css') }}" rel="stylesheet">
       <script src="{{ asset('lib/webviewer.min.js') }}"></script>
       <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
       <!-- MDB -->
       <link rel="stylesheet" href="{{ asset('assets/css/mdb.min.css') }}" />

</head>
<style>
        .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
        }

        @media (min-width: 768px) {
          .bd-placeholder-img-lg {
            font-size: 3.5rem;
          }
        }

        .b-example-divider {
          height: 3rem;
          background-color: rgba(0, 0, 0, .1);
          border: solid rgba(0, 0, 0, .15);
          border-width: 1px 0;
          box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }
        .bg-head{
            background-color: #2A9BF8;
        color: #ffffff;
        }
        .b-example-vr {
          flex-shrink: 0;
          width: 1.5rem;
          height: 100vh;
        }

        .bi {
          vertical-align: -.125em;
          fill: currentColor;
        }

        .nav-scroller {
          position: relative;
          z-index: 2;
          height: 2.75rem;
          overflow-y: hidden;
        }

        .nav-scroller .nav {
          display: flex;
          flex-wrap: nowrap;
          padding-bottom: 1rem;
          margin-top: -1px;
          overflow-x: auto;
          text-align: center;
          white-space: nowrap;
          -webkit-overflow-scrolling: touch;
        }
        .dataTables_wrapper   .dataTables_filter{
            float: right 
          }

        .dataTables_wrapper  .dataTables_length{
                float: left 
        }
        .dataTables_info {
                float: left;
        }
        .dataTables_paginate{
                float: right
        }
        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
      
    }
    .btn {
          font-size: 15px;
      }
  </style>

<body>
   
    <div id="app">
        <div class="px-3 py-2 bg-primary text-white">
            <div class="container">
              <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="#" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                  <img src="{{ asset('assets/images/logoZoffice.png') }}" alt="logo-dark" height="80">    
                </a>              
      
                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    
                      <li>
                        <a href="{{url("staff/home")}}" class="nav-link text-white text-center">
                          <i class="fa-solid fa-2x fa-chart-line text-white"></i>
                          <br>
                          Dashboard
                        </a>
                      </li>
                      <li>
                        <a href="{{url("staff/home")}}" class="nav-link text-white position-relative text-center">
                          <i class="fa-solid fa-2x fa-envelope text-white"></i>
                          <span class="position-absolute top-0 start-70 translate-middle badge rounded-pill bg-danger">2 <span class="visually-hidden">unread messages</span></span>
                          <br>
                          ข้อความ
                        </a>
                      </li>
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white text-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{-- <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#people-circle"/></svg> --}}
                                  <i class="fa-solid fa-2x fa-user-tie text-white "></i><br>
                                  {{ Auth::user()->fname }}   {{ Auth::user()->lname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest



                </ul>
              </div>
              
            </div>
          </div>

         

          @yield('menu')

            </div>
          </div>

        <main class="py-3">
            @yield('content')
        </main>
    </div>

    {{-- <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jquery-3.5.1.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  --}}
    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
      <!-- MDB -->
      <script type="text/javascript" src="{{ asset('assets/js/mdb.min.js') }}"></script>

      <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>

      <script src="{{ asset('js/select2.min.js') }}"></script>
      <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      {{-- @yield('footer') --}}
      
<script type="text/javascript">
    $(document).ready(function(){

        $('#example').DataTable();
        $('#example2').DataTable();
        $('#example3').DataTable();
        $('#example4').DataTable();
        $('#example5').DataTable();
      });

  $(document).ready(function(){
        $('#dep').select2({
            placeholder:"กลุ่มงาน",
            allowClear:true
        });
        $('#depsub').select2({
            placeholder:"ฝ่าย/แผนก",
            allowClear:true
        });
        $('#depsubsub').select2({
            placeholder:"หน่วยงาน",
            allowClear:true
        });
        $('#depsubsubtrue').select2({
            placeholder:"หน่วยงานที่ปฎิบัติจริง",
            allowClear:true
        });
        $('#position').select2({
            placeholder:"ตำแหน่ง",
            allowClear:true
        });
        $('#status').select2({
            placeholder:"สถานะ",
            allowClear:true
        });
        $('#pname').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#users_group_id').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#users_type_id').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        
        // $('.datepicker').datetimepicker({
        //   timepicker:false,
        //   datepicker:true,
        //   format: 'y/m/d',
        //   weeks:true
          // startDate: '-3d'
      // });
    });
</script>
<script>
  $('.department').change(function () {
          if ($(this).val() != '') {
                  var select = $(this).val();
                  var _token = $('input[name="_token"]').val();
                  $.ajax({
                          url: "{{route('person.department')}}",
                          method: "GET",
                          data: {
                                  select: select,
                                  _token: _token
                          },
                          success: function (result) {
                                  $('.department_sub').html(result);
                          }
                  })
                  // console.log(select);
          }
  });

  $('.department_sub').change(function () {
          if ($(this).val() != '') {
                  var select = $(this).val();
                  var _token = $('input[name="_token"]').val();
                  $.ajax({
                          url: "{{route('person.departmenthsub')}}",
                          method: "GET",
                          data: {
                                  select: select,
                                  _token: _token
                          },
                          success: function (result) {
                                  $('.department_sub_sub').html(result);
                          }
                  })
                  // console.log(select);
          }
  });
</script>

</body>

</html>
