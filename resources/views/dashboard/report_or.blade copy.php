@extends('layouts.report_font')
@section('title', 'PK-OFFICER || DASHBOARD')

   


@section('content')
   
    <?php  
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
        $mo =  date('m');
    ?>  
     
     <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
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
               border: 10px #ddd solid;
               border-top: 10px rgb(212, 106, 124) solid;
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
      <?php
      use App\Http\Controllers\StaticController;
      use Illuminate\Support\Facades\DB;   
      $count_meettingroom = StaticController::count_meettingroom();
  ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>  
        
            <div class="row">
                @foreach ($leave_month_year as $item) 
                    <?php 
                        $data_ = DB::connection('mysql3')->select('
                            SELECT count(o.vn) as vn from ovst o LEFT JOIN opitemrece oo on oo.an=o.an LEFT JOIN an_stat a on a.an=o.an WHERE oo.icode ="3010777" AND month(a.dchdate) = "'.$item->month_year_code.'";
                        ');
                        foreach ($data_ as $key => $value) {
                            $count_vn = $value->vn;
                        }
                    ?>
                    <div class="col-xl-3 col-md-3">
                        <div class="main-card mb-3 card">
                            <div class="grid-menu-col">
                                <div class="g-0 row">
                                    <div class="col-sm-12">
                                        <div class="widget-chart widget-chart-hover"> 
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                    
                                                    {{-- <p class="text-start font-size-14 mb-2">ห้องผ่าตัด</p> --}}
                                                    @if ($item->month_year_name =='ตุลาคม')
                                                        <p class="text-start font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p> 
                                                    @elseif ($item->month_year_name =='พฤศจิกายน')
                                                        <p class="text-start font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p> 
                                                    @elseif ($item->month_year_name =='ธันวาคม')
                                                        <p class="text-start font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p> 
                                                    @else
                                                        <p class="text-start font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$ynow}}</p> 
                                                    @endif
                                                    {{-- <p class="text-start font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$ynow}}</p>  --}}
                                                        <h4 class="text-start mb-2">{{$count_vn}} Visit</h4>
                                                        
                                                        {{-- <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ number_format($sumdebtor_, 2) }}</span>บาท</p> --}}
                                                        {{-- <p class="text-start mb-0">
                                                            <span class="text-danger fw-bold font-size-12 me-2">
                                                                <i class="ri-arrow-right-up-line me-1 align-middle"> </i>
                                                                    10
                                                            </span>
                                                            บาท
                                                        </p> --}}
                                                    </div>
                                                    
                                                    <div class="avatar-sm me-2">
                                                        {{-- <a href="" target="_blank">
                                                            <span class="avatar-title bg-light text-danger rounded-3">
                                                                <p style="font-size: 10px;">
                                                                <i class="fa-solid fa-stamp font-size-22 mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ 100"> </i>  
                                                                <br>
                                                                2323 
                                                            </p>                                                            
                                                            </span>  
                                                        </a> --}}
                                                    </div> 
                                                    <div class="avatar-sm me-2">
                                                        <a href="" target="_blank">
                                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                                <p style="font-size: 10px;">
                                                                    <i class="fa-solid fa-file-import font-size-24 mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"></i>
                                                                    <br> 
                                                                    000
                                                                </p>
                                                            </span> 
                                                        </a>
                                                    </div>


                                                </div> 
                                        </div>                                           
                                    </div>  
                                </div>                                           
                            </div> 
                        </div> 
                    </div> 
                @endforeach
               
            </div>

           
       
    </div>
  

    @endsection
    @section('footer')
    
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
              
        });
    </script>
    @endsection
