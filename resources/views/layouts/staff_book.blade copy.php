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
  <link href="{{ asset('css/tablebook.css') }}" rel="stylesheet">
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
        <div class="px-3 py-2 bg-secondary text-white">
            <div class="container">
              <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
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

        <main class="py-2">
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
        $('#example3').DataTable();
        $('#example4').DataTable();
        $('#example5').DataTable();

        $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         $(document).ready(function(){
              $(document).on('click','.edit_bookrep',function(e){
                  e.preventDefault();
                  let bookrep_id = $('#bookrep_id').val();
                  let bookrep_recievenum = $('#bookrep_recievenum').val();
                  let user_id = $('#user_id').val();
                  let store_id = $('#store_id').val();
                  let bookrep_repbooknum = $('#bookrep_repbooknum').val();
                  let bookrep_save_date = $('#bookrep_save_date').val();
                  let bookrep_secret_class_id = $('#bookrep_secret_class_id').val();
                  let bookrep_speed_class_id = $('#bookrep_speed_class_id').val();
                  let bookrep_follow_date = $('#bookrep_follow_date').val();
                  let bookrep_type_id = $('#bookrep_type_id').val();
                  let bookrep_import_fam = $('#bookrep_import_fam').val();
                  let bookrep_name = $('#bookrep_name').val();
                  let bookrep_story = $('#bookrep_story').val();
                  let bookrep_assembly = $('#bookrep_assembly').val();
                  let bookrep_file1 = $('#bookrep_file1').val();
                  let bookrep_file2 = $('#bookrep_file2').val();
                  let bookrep_file3 = $('#bookrep_file3').val();
                  let bookrep_file4 = $('#bookrep_file4').val();
                  let bookrep_file5 = $('#bookrep_file5').val();
                  console.log(
                    bookrep_id+bookrep_recievenum+
                    user_id+store_id+bookrep_repbooknum+
                    bookrep_save_date+bookrep_secret_class_id+bookrep_file5
                    );

                  $.ajaxSetup({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                  });
                  $.ajax({ 
                      type: "post",
                      url:"{{route('book.bookmake_index_update')}}" , 
                      success:function(response)
                      {          
                        if (data.status == 0 ) {
        
                            } else {          
                              Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You edit data success",
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
                            }
                      }
                  }) 

                  
              })

            function addtype() {
                var bookrep_type = document.getElementById("BOOK_TYPE_INSERT").value;
                // alert(bookrep_type);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{url('book.addtype')}}",
                    method: "GET",
                    data: {
                      bookrep_type: bookrep_type,
                        _token: _token
                    },
                    success: function (result) {
                        $('.show_type').html(result);
                    }
                })
            }

            function addfam() {
                var book_fam = document.getElementById("BOOK_FAM_INSERT").value;
                // alert(bookrep_type);
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "/book/addfam",
                    method: "GET",
                    data: {
                      book_fam: book_fam,
                        _token: _token
                    },
                    success: function (result) {
                        $('.show_fam').html(result);
                    }
                })
          }
          })



    });

      $(document).ready(function(){
  
        $('#bookrep_import_fam').select2({
            placeholder:"นำเข้าไว้ในแฟ้ม ",
            allowClear:true
        });

        $('#bookrep_speed_class_id').select2({
            placeholder:"ชั้นความเร็ว",
            allowClear:true
        });
        $('#bookrep_secret_class_id').select2({
            placeholder:"ชั้นความลับ",
            allowClear:true
        });
        $('#bookrep_type_id').select2({
            placeholder:"ประเภทหนังสือ",
            allowClear:true
        });
        $('#sendperson_user_id').select2({
            placeholder:"ชื่อ-นามสกุล",
            allowClear:true
        });
        $('#DEPARTMENT_SUB_ID').select2({
            placeholder:"ฝ่าย/แผนก",
            allowClear:true
        });
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
        $('#team').select2({
            placeholder:"ทีมนำองค์กร",
            allowClear:true
        });
        $('#depsubsubtrue').select2({
            placeholder:"หน่วยงานที่ปฎิบัติจริง",
            allowClear:true
        });
        $('#book_objective').select2({
            placeholder:"วัตถุประสงค์",
            allowClear:true
        });
        $('#book_objective2').select2({
            placeholder:"วัตถุประสงค์",
            allowClear:true
        });
        $('#book_objective3').select2({
            placeholder:"วัตถุประสงค์",
            allowClear:true
        });
        $('#book_objective4').select2({
            placeholder:"วัตถุประสงค์",
            allowClear:true
        });
        $('#book_objective5').select2({
            placeholder:"วัตถุประสงค์",
            allowClear:true
        });
        $('#org_team_id').select2({
            placeholder:"ทีมนำองค์กร",
            allowClear:true
        });      
    });

    
  </script>


</body>
</html>
