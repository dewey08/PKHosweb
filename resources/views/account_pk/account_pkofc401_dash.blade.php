@extends('layouts.accountpk')
@section('title', 'PK-BACKOFFice || ACCOUNT')

   


@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
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
               border-top: 10px #fd6812 solid;
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
                    $countacc_debtor = DB::select('
                        SELECT count(vn) as VN from acc_debtor 
                        WHERE stamp="N" and pttype_eclaim_id = "17" 
                        and account_code="1102050101.401" 
                        and month(vstdate) = "'.$item->month_year_code.'";
                    ');
                    foreach ($countacc_debtor as $key => $value) {
                        $debtor_ = $value->VN;
                    }
                    $sumacc_debtor = DB::select('
                        SELECT SUM(debit) as debit from acc_debtor 
                        WHERE stamp="N" and pttype_eclaim_id = "17" 
                        and account_code="1102050101.401" 
                        and month(vstdate) = "'.$item->month_year_code.'";
                    ');
                    foreach ($sumacc_debtor as $key => $value2) {
                        $sumdebtor_ = $value2->debit;
                    }
                    $acc_stam = DB::select('
                        SELECT count(vn) as VN from acc_debtor 
                        WHERE stamp="Y" and pttype_eclaim_id = "17" 
                        and account_code="1102050101.401" 
                        and month(vstdate) = "'.$item->month_year_code.'";
                    ');
                    foreach ($acc_stam as $key => $value2) {
                        $acc_stam_ = $value2->VN;
                    }

                    $sumacc_debtor_y = DB::select('
                        SELECT SUM(debit) as debit from acc_debtor 
                        WHERE stamp="Y" and pttype_eclaim_id = "17" 
                        and account_code="1102050101.401" 
                        and month(vstdate) = "'.$item->month_year_code.'";
                    ');
                    foreach ($sumacc_debtor_y as $key => $value3) {
                        $sumdebtor_y = $value3->debit;
                    }
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="main-card mb-3 card">
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="widget-chart widget-chart-hover">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                @if ($item->month_year_name =='ตุลาคม')
                                                    <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p>
                                                @elseif ($item->month_year_name =='พฤศจิกายน')
                                                <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p>
                                                @elseif ($item->month_year_name =='ธันวาคม')
                                                <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p>
                                                @else
                                                    <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$ynow}}</p>
                                                @endif
                                                
                                                <h4 class="mb-2">{{$debtor_}} Visit</h4>
                                                <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{ number_format($sumdebtor_, 2) }}</span>บาท</p>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <a href="{{url('account_pkofc401/'.$item->month_year_code)}}">
                                                    <span class="avatar-title bg-light text-danger rounded-3">
                                                        <p style="font-size: 10px;">
                                                        <i class="fa-solid fa-stamp font-size-22 mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{number_format($sumdebtor_y, 2)}}"> </i>  
                                                        <br>
                                                        {{$acc_stam_}}
                                                    </p>
                                                        
                                                    </span> 
                                                    {{-- <p class="text-muted mb-0"><span class="bg-light text-danger fw-bold font-size-12 me-2 rounded-3"><i class="fa-solid fa-stamp font-size-20 me-1 align-middle"></i>{{ number_format($sumdebtor_, 2) }}</span></p> --}}
                                                    
                                                </a>
                                            </div>
                                            <div class="avatar-sm me-2">
                                                <span class="avatar-title bg-light text-primary rounded-3">
                                                    {{-- <i class="mdi mdi-currency-usd font-size-24"></i>   --}}
                                                    <i class="fa-solid fa-file-import font-size-24"></i>
                                                </span> 
                                            </div>
                                            <div class="avatar-sm">
                                                <span class="avatar-title bg-light text-info rounded-3">
                                                    {{-- <i class="ri-user-3-line font-size-24"></i>  --}}
                                                    <i class="fa-brands fa-btc font-size-24"></i>
                                                </span> 
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
