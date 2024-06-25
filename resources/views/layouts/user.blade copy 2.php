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
  <link href="{{ asset('css/tablecar.css') }}" rel="stylesheet">
  <script src="{{ asset('lib/webviewer.min.js') }}"></script>

  <!-- MDB -->
          <link rel="stylesheet" href="{{ asset('assets/css/mdb.min.css') }}" />
        <link href="{{ asset('css/fontuser.css') }}" rel="stylesheet">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

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

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }
    .bg-head{
        background-color: #757272;
    color: #ffffff;
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
<?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $userid = Auth::user()->id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
          
    use App\Http\Controllers\StaticController;  
    use App\Http\Controllers\RongController;  
    $checkhn = StaticController::checkhn($userid);
    $checkhnshow = StaticController::checkhnshow($userid);
    $orginfo_headep = StaticController::orginfo_headep($userid);
    $orginfo_po = StaticController::orginfo_po($userid);
    $countadmin = StaticController::countadmin($userid);
    
    
  ?>
<body>
       <div id="app">
        <div class="px-3 py-2 bg-info text-white">
            <div class="container">
              <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{url('user/home')}}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                  
                  {{-- <label for="" style="color: white;font-size:35px">งานสารบรรณ</label>  --}}
                  <label for="" style="color: white;font-size:45px">Z-</label>
                  <label for="" style="color: rgb(250, 120, 33);font-size:45px">OF</label>
                  <label for="" style="color: white;font-size:45px">Fice</label>
                </a>
                
      
                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    
                  <li>
                    {{-- <a href="{{ url('user/home') }}" class="nav-link text-white text-center"> 
                        <i class="fa-solid fa-2x fa-user-tie text-info"></i>
                      <br>
                      ผู้ใช้งานทั่วไป
                    </a> --}}
                    <a class="dropdown-toggle text-white text-center mt-2" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false" >
                      <i class="fa-solid fa-2x fa-user-tie text-white"></i>   <br>
                      ผู้ใช้งานทั่วไป
                    </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ url('user/home') }}">หน้าหลัก</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#">ข้อมูลบุคคล</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user/gleave_data/'. Auth::user()->id) }}">ข้อมูลการลา</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user/book_inside/'. Auth::user()->id) }}">สารบรรณ</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user/persondev_dashboard/'. Auth::user()->id) }}">ประชุม/อบรม/ดูงาน</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user_car/car_calenda/'. Auth::user()->id) }}">ยานพาหนะ</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user_meetting/meetting_calenda') }}">ห้องประชุม</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user/repair_dashboard/'. Auth::user()->id) }}">แจ้งซ่อม</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user/house_detail/' . Auth::user()->id) }}">บ้านพัก</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user/supplies_data_add/' . Auth::user()->id) }}">งานพัสดุ</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="{{ url('user/warehouse_dashboard/' . Auth::user()->id) }}">คลังวัสดุ</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>                           
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                  </li>
           
                  @if ($checkhn != 0)
                <li>
                  <a href="{{ url('hn/hn_bookindex/'.Auth::user()->id) }}" class="nav-link text-white text-center"> 
                      <i class="fa-solid fa-2x fa-user-tie text-warning"></i>
                    <br>
                    หัวหน้า
                  </a>
                </li>
                @endif 
                    
                @if ($countadmin != 0)
                <li>
                  <a href="{{ url('setting/setting_index') }}" class="nav-link text-white text-center"> 
                      <i class="fa-solid fa-2x fa-user-tie text-danger"></i>
                    <br>
                    ผู้ดูแลระบบ
                  </a>
                </li>
                @endif 

                @if ($orginfo_headep != 0)
                <li>
                  <a href="{{ url('rong/rong_bookindex/'.Auth::user()->id) }}" class="nav-link text-white text-center"> 
                      <i class="fa-solid fa-2x fa-user-tie text-secondary"></i>
                    <br>
                    หัวหน้าบริหาร
                  </a>
                </li>
                @endif

                @if ($orginfo_po != 0)
                <li>
                  <a href="{{url("po/po_bookindex/".Auth::user()->id)}}" class="nav-link text-white text-center"> 
                      <i class="fa-solid fa-2x fa-user-tie text-success"></i>
                    <br>
                    ผู้อำนวยการ
                  </a>
                </li>
                @endif

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
                        <a class="dropdown-toggle text-white text-center mt-2" type="button" id="dropdownMenuButton" data-mdb-toggle="dropdown" aria-expanded="false" >
                                @if (Auth::user()->img == null)
                                <img src="{{ asset('assets/images/default-image.jpg') }}"
                                    id="edit_upload_preview" height="32px" width="32px" alt="Image"
                                    class="img-thumbnail">
                                @else
                                    <img src="{{ asset('storage/person/' . Auth::user()->img) }}"
                                        id="edit_upload_preview" height="32px" width="32px" alt="Image"
                                        class="img-thumbnail">
                                @endif 
                                <br>
                                {{ Auth::user()->fname }}   {{ Auth::user()->lname }}
                        </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    {{-- <li><a class="dropdown-item" href="#">ข้อมูลบุคคล</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user/gleave_data/'. Auth::user()->id) }}">ข้อมูลการลา</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user/book_inside/'. Auth::user()->id) }}">สารบรรณ</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user/persondev_dashboard/'. Auth::user()->id) }}">ประชุม/อบรม/ดูงาน</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user_car/car_narmal/'. Auth::user()->id) }}">ยานพาหนะ</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user_meetting/meetting_calenda') }}">ห้องประชุม</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user/repair_dashboard/'. Auth::user()->id) }}">แจ้งซ่อม</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user/house_detail/' . Auth::user()->id) }}">บ้านพัก</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user/supplies_data_add/' . Auth::user()->id) }}">งานพัสดุ</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="{{ url('user/warehouse_dashboard/' . Auth::user()->id) }}">คลังวัสดุ</a></li>
                                    <li><hr class="dropdown-divider" /></li> --}}
                                    <li>                           
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                    </div>
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
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('assets/js/mdb.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>


    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @yield('footer')

  <script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#example3').DataTable();
        $('#example4').DataTable();
        $('#example5').DataTable();
        $('#example_user').DataTable();
        $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
    });

    $(document).ready(function(){
      $('#book_saveForm').on('submit',function(e){
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
                if (data.status == 200 ) {
                    Swal.fire({
                      title: 'บันทึกข้อมูลสำเร็จ',
                      text: "You Insert data success",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177',
                      // cancelButtonColor: '#d33',
                      confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                      if (result.isConfirmed) { 
                        window.location = "{{url('book/bookmake_index')}}"; // กรณี add page new  
                      }
                    })      
                } else {          
                
                }
              }
            });
          });
    });

    $(document).ready(function(){
  
        $('#bookrep_import_fam').select2({
            placeholder:"นำเข้าไว้ในแฟ้ม ",
            allowClear:true
        });
        

           
    });

    
  </script>


</body>
</html>

