<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
 
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>     
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> 
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/tablestaff.css') }}" rel="stylesheet">
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
                    <a href="{{url("person/person_index")}}" class="nav-link text-white text-center">
                      <i class="fa-solid fa-2x fa-user-tie text-white "></i><br>
                      บุคคลากร
                    </a>
                  </li>
                  <li>
                    <a href="{{url("supplies/supplies_index")}}" class="nav-link text-white text-center">
                      <i class="fa-solid fa-2x fa-boxes-packing text-white"></i><br>
                      ทรัพย์สิน-พัสดุ
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link text-white text-center">
                      <i class="fa-solid fa-2x fa-building-circle-check text-white"></i>
                      <br>
                      คลังยา
                    </a>
                  </li>
                  <li>
                    <a href="#" class="nav-link text-white text-center">
                      <i class="fa-solid fa-2x fa-building-shield text-white"></i>
                      <br>
                      คลังวัสดุ
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery-3.5.1.js') }}"></script> --}}
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script src="{{ asset('js/person.js') }}"></script>
    {{-- <script src="{{ asset('js/products.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/article.js') }}"></script> --}}

<script type="text/javascript">
    $(document).ready(function(){

      $('#table_id').DataTable();
      
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
</script>


</body>

</html>
