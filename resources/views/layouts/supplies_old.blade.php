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
  <link href="{{ asset('css/tablesupplies.css') }}" rel="stylesheet">
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
        <div class="px-3 py-2 bg-success text-white">
            <div class="container">
              <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{url('admin/home')}}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                  <!-- <img src="{{ asset('assets/images/logoZoffice.png') }}" alt="logo-dark" height="80">  -->
                  <label for="" style="color: white;font-size:45px">Z-</label>
                  <label for="" style="color: rgb(250, 120, 33);font-size:45px">OF</label>
                  <label for="" style="color: rgb(33, 181, 250);font-size:45px">Fice</label>
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
          $(document).ready(function(){
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
                $('#example4').DataTable();
                $('#example5').DataTable();  
                $('#table_id').DataTable();     
            });
          $(document).ready(function () {
             

              $('#building_decline_id').select2({
                  placeholder:"อัตราเสื่อม",
                  allowClear:true
              });
              $('#building_buy_id').select2({
                  placeholder:"วิธีการซื้อ",
                  allowClear:true
              });
              $('#building_method_id').select2({
                  placeholder:"วิธีได้มา",
                  allowClear:true
              });
              $('#building_budget_id').select2({
                  placeholder:"งบประมาณ",
                  allowClear:true
              });
              $('#building_tonnage_number').select2({
                  placeholder:"หมายเลขระวาง",
                  allowClear:true
              });
              $('#land_province_location').select2({
                  placeholder:"จังหวัด",
                  allowClear:true
              });
              $('#land_district_location').select2({
                  placeholder:"อำเภอ",
                  allowClear:true
              });
              $('#land_tumbon_location').select2({
                  placeholder:"ตำบล",
                  allowClear:true
              });

              $('#article_deb_subsub_id').select2({
                  placeholder:"ประจำหน่วยงาน",
                  allowClear:true
              });
              $('#article_categoryid').select2({
                  placeholder:"หมวดวัสดุ",
                  allowClear:true
              });
              $('#leave_year_id').select2({
                  placeholder:"ปีงบประมาณ",
                  allowClear:true
              });
              $('#article_decline_id').select2({
                  placeholder:"ประเภทค่าเสื่อม",
                  allowClear:true
              });
              $('#product_typeid').select2({
                  placeholder:"ประเภทวัสดุ",
                  allowClear:true
              });
              $('#product_categoryid').select2({
                  placeholder:"หมวดวัสดุ",
                  allowClear:true
              });
              $('#product_spypriceid').select2({
                  placeholder:"ราคาสืบ",
                  allowClear:true
              });
              $('#product_groupid').select2({
                  placeholder:"ชนิดวัสดุ",
                  allowClear:true
              });
              $('#product_unit_bigid').select2({
                  placeholder:"หน่วยบรรจุ",
                  allowClear:true
              });
              $('#product_unit_subid').select2({
                  placeholder:"หน่วยย่อย",
                  allowClear:true
              });
              $('#status').select2({
                  placeholder:"สถานะ",
                  allowClear:true
              });

          });

          $(document).ready(function() {      
              $('select').select2( );

          });

          $(document).ready(function(){
              $('#insert_productForm').on('submit',function(e){
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
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                          window.location = "{{url('supplies/supplies_index')}}"; // กรณี add page new 
                        }
                      })      
                    }
                  }
                });
              });
            
              $('#update_productForm').on('submit',function(e){
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
                          window.location = "{{url('supplies/supplies_index')}}"; // กรณี add page new   
                        }
                      })      
                    }
                  }
                });
              }); 
              
              
          });

          $(document).ready(function(){
                $('#insert_serveForm').on('submit',function(e){
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
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {     
                                  window.location = "{{url('serve/serve_index')}}";
                                }
                              })      
                            }
                          }
                        });
                });
              
                $('#update_serveForm').on('submit',function(e){
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
                                window.location = "{{url('serve/serve_index')}}";
                              }
                            })      
                          }
                        }
                      });
                });

              
              });

          function addproducts(input) {
              var fileInput = document.getElementById('img');
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
          function editproducts(input) {
            var fileInput = document.getElementById('img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                    var reader = new FileReader();    
                    reader.onload = function (e) {
                        $('#edit_upload_preview').attr('src', e.target.result);
                    }    
                    reader.readAsDataURL(input.files[0]);
                }else{    
                    alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                    fileInput.value = '';
                    return false;
                    }
          }

          function addunit() {
            var unitnew = document.getElementById("UNIT_INSERT").value;
            // alert(unitnew);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('article/addunit')}}",
                method: "GET",
                data: {
                  unitnew: unitnew,
                    _token: _token
                },
                success: function (result) {
                    $('.show_unit').html(result);
                }
            })
          }

          function addunitsub() {
            var unitnew = document.getElementById("UNIT_SUBINSERT").value;
            // alert(unitnew);
            var _token = $('input[name="_token"]').val();
            $.ajax({ 
                url: "{{url('article/addunit')}}",
                method: "GET",
                data: {
                  unitnew: unitnew,
                    _token: _token
                },
                success: function (result) {
                    $('.show_unitsub').html(result);
                }
            })
          }

          function addserve(input) {
              var fileInput = document.getElementById('img');
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
          function editserve(input) {
            var fileInput = document.getElementById('img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                    var reader = new FileReader();    
                    reader.onload = function (e) {
                        $('#edit_upload_preview').attr('src', e.target.result);
                    }    
                    reader.readAsDataURL(input.files[0]);
                }else{    
                    alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                    fileInput.value = '';
                    return false;
                    }
          }
  
  
  </script>


</body>
</html>
