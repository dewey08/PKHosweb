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
      <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">   
      <link href="{{ asset('css/tablecar.css') }}" rel="stylesheet">
      <script src="{{ asset('lib/webviewer.min.js') }}"></script>
      <link href="{{ asset('sky16/css/icons.css') }}" rel="stylesheet">
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
      <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
    .bg-head{
        background-color: #757272;
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
        <div class="px-3 py-2 bg-info text-white">
            <div class="container">
              <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{url('admin/home')}}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                 <!-- <img src="{{ asset('assets/images/logoZoffice.png') }}" alt="logo-dark" height="80">  -->
                 <label for="" style="color: white;font-size:45px">Z-</label>
                 <label for="" style="color: rgb(250, 120, 33);font-size:45px">OF</label>
                 <label for="" style="color: rgb(223, 239, 247);font-size:45px">Fice</label>
                </a>
                
      
                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    
                  <li>
                    <a href="{{url("admin/home")}}" class="nav-link text-white text-center">
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

        <main class="py-3">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('assets/js/mdb.min.js') }}"></script>     
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('js/gcpdfviewer.js') }}"></script> 

  @yield('footer')


<script> 
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("canvas");
    var el_note = document.getElementById("note");
    var signaturePad;
    signaturePad = new SignaturePad(canvas);
    clearButton.addEventListener("click", function (event) {
    document.getElementById("note").innerHTML="The signature should be inside box";
    signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function (event){
            if (signaturePad.isEmpty()){
                alert("Please provide signature first.");
                event.preventDefault();
            }else{
                var canvas  = document.getElementById("the_canvas");
                var dataUrl = canvas.toDataURL();
                document.getElementById("signature").value = dataUrl;

                // ข้อความแจ้ง
                    Swal.fire({
                        title: 'สร้างสำเร็จ',
                        text: "You create success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',               
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {}
                    })  
            }
    });
    function my_function(){
        document.getElementById("note").innerHTML="";
    } 

</script> 

  <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
            $('#example4').DataTable();
            $('#example5').DataTable();
        });

        $(document).ready(function(){

          // $('select').select2();
            // $('#car_service_status').select2({
            //     dropdownParent: $('#cardetailModal')
            // });

            $('#article_user_id').select2({
                placeholder:"เลือกผู้รับผิดชอบ ",
                allowClear:true
            });
            $('#article_status_id').select2({
                placeholder:"เลือกสถานะ",
                allowClear:true
            });
            $('#article_car_type_id').select2({
                placeholder:"เพิ่มประเภท",
                allowClear:true
            });        
            $('#article_brand_id').select2({
                placeholder:"เพิ่มยี่ห้อ",
                allowClear:true
            });
            $('#article_color_id').select2({
                placeholder:"เพิ่มสี",
                allowClear:true
            });
            $('#article_deb_subsub_id').select2({
                placeholder:"หน่วยงาน",
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
            // $('#depsubsub').select2({
            //     placeholder:"หน่วยงาน",
            //     allowClear:true
            // });
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

        $(document).ready(function(){

          $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#insert_carForm').on('submit',function(e){
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
                      if (data.status == 500 ) {
                        alert('Error');
                      } else {          
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
                            window.location="{{url('car/car_data_index')}}"; 
                          }
                        })      
                      }
                    }
                  });
            });

            $('#update_carForm').on('submit',function(e){
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
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: "You edit data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                          window.location="{{url('car/car_data_index')}}";
                        }
                      })      
                    }
                  }
                });
            });    
            
          

        });

        function addarticle(input) {
          var fileInput = document.getElementById('article_img');
          var url = input.value;
          var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
              if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                  var reader = new FileReader();    
                  reader.onload = function (e) {
                      $('#add_upload_preview').attr('src', e.target.result);
                  }    
                  reader.readAsDataURL(input.files[0]);
              }else{    
                  alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                  fileInput.value = '';
                  return false;
                  }
        }
    
  </script>

<script>
  $(document).on('click','.edit_car',function(){
                var id = $(this).val();
                alert(id);
                        $('#carModal').modal('show');
                        $.ajax({
                        type: "GET",
                        url:"{{url('car/car_narmal_allocate')}}" +'/'+ id,  
                        success: function(data) {
                          //   console.log(data.carservice.car_service_id);
                            // $('#line_token_name').val(data.carservice.line_token_name)  
                            // $('#line_token_code').val(data.carservice.line_token_code) 
                            // $('#line_token_id').val(data.carservice.car_service_id)                
                        },      
                });
        });
</script>

</body>
</html>
