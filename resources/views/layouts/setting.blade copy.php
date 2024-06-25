<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">
   
  <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">   
  <link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">
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
            background-color: #FF2407D2;
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
  </style>
<body>
       <div id="app">
        <div class="px-3 py-2 bg-head text-white">
            <div class="container">
              <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                  {{-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> --}}
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
                  <li>
                   
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

    @yield('footer')

    <script type="text/javascript">

        $(document).ready(function () {
            $('#example').DataTable();
            $('#example2').DataTable();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });

        $(document).ready(function(){
              $('#insert_depForm').on('submit',function(e){
                    e.preventDefault();            
                    var form = this;
                    // alert('OJJJJOL');
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
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('setting/setting_index')}}";
                                }
                              })      
                            }
                          }
                    });
              });

              $('#update_depForm').on('submit',function(e){
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
                                    window.location="{{url('setting/setting_index')}}";
                                  }
                                })      
                              }
                            }
                      });
              });
        });

        $(document).ready(function(){
              $('#insert_depsubForm').on('submit',function(e){
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
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('setting/depsub_index')}}";
                                }
                              })      
                            }
                          }
                    });
              });

              $('#update_depsubForm').on('submit',function(e){
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
                                    window.location="{{url('setting/depsub_index')}}";
                                  }
                                })      
                              }
                            }
                      });
              });
        });

        $(document).ready(function(){
    
          $('#LEADER_ID').select2({
              placeholder:"หัวหน้ากลุ่มงาน",
              allowClear:true
          });

          $('#DEPARTMENT_ID').select2({
              placeholder:"กลุ่มงาน",
              allowClear:true
          });
          $('#LEADER_ID2').select2({
              placeholder:"หัวหน้าหน่วยงาน",
              allowClear:true
          });
          $('#LEADER_ID3').select2({
              placeholder:"ผู้อนุมัติเห็นชอบ",
              allowClear:true
          });
          $('#USER_ID').select2({
              placeholder:"ผู้ถูกเห็นชอบ",
              allowClear:true
          });
          $('#DEPARTMENT_SUB_ID').select2({
              placeholder:"ฝ่าย/แผนก",
              allowClear:true
          });
                
        });

    
  </script>


</body>
</html>
