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
                @foreach ($datashow_ as $item) 
                    <?php 
                        // $data_ = DB::connection('mysql3')->select('
                        //     SELECT count(o.vn) as vn from ovst o LEFT JOIN opitemrece oo on oo.an=o.an LEFT JOIN an_stat a on a.an=o.an WHERE oo.icode ="3010777" AND month(a.dchdate) = "'.$item->month_year_code.'";
                        // ');
                        // foreach ($data_ as $key => $value) {
                        //     $count_vn = $value->vn;
                        // }
                    ?>
                    <div class="col-xl-3 col-md-3">
                        <div class="main-card mb-3 card">
                            <div class="grid-menu-col">
                                <div class="g-0 row">
                                    <div class="col-sm-12">
                                        <div class="widget-chart widget-chart-hover"> 
                                                <div class="d-flex">
                                                    <div class="flex-grow-1"> 
                                                        @if ($item->months == '1')
                                                            <p class="text-start font-size-14 mb-2">เดือน มกราคม {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4> 
                                                        @elseif ($item->months == '2')
                                                            <p class="text-start font-size-14 mb-2">เดือน กุมภาพันธ์ {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '3')
                                                            <p class="text-start font-size-14 mb-2">เดือน มีนาคม {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '4')
                                                            <p class="text-start font-size-14 mb-2">เดือน เมษายน {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '5')
                                                            <p class="text-start font-size-14 mb-2">เดือน พฤษภาคม {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '6')
                                                            <p class="text-start font-size-14 mb-2">เดือน มิถุนายน {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '7')
                                                            <p class="text-start font-size-14 mb-2">เดือน กรกฎาคม {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '8')
                                                            <p class="text-start font-size-14 mb-2">เดือน สิงหาคม {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '9')
                                                            <p class="text-start font-size-14 mb-2">เดือน กันยายน {{$ynow}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '10')
                                                            <p class="text-start font-size-14 mb-2">เดือน ตุลาคม {{$yb}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '11')
                                                            <p class="text-start font-size-14 mb-2">เดือน พฤษจิกายน {{$yb}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @elseif ($item->months == '12')
                                                            <p class="text-start font-size-14 mb-2">เดือน ธันวาคม {{$yb}}</p> 
                                                            <h4 class="text-start mb-2"> {{$item->cvn}} Visit</h4>
                                                        @else
                                                            
                                                        @endif
                                                        
                                                        {{-- <p class="text-start mb-0">
                                                            <span class="text-danger fw-bold font-size-12 me-2">
                                                                <i class="ri-arrow-right-up-line me-1 align-middle"> </i>
                                                                    10
                                                            </span>
                                                            บาท
                                                        </p> --}}
                                                    </div>
                                                    
                                                    <div class="avatar-sm me-2">
                                                        
                                                    </div> 
                                                    <div class="avatar-sm me-2">
                                                        <a href="{{url('report_ormonth/'.$item->months)}}" target="_blank">
                                                            <span class="avatar-title bg-light text-danger rounded-3">
                                                                <p style="font-size: 10px;">
                                                                    <i class="fa-solid fa-file-import font-size-24 mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"></i>
                                                                    <br> 
                                                                    {{$item->months}}
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
