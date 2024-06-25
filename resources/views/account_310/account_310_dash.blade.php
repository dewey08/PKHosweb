@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
 
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
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

   <div class="tabs-animation">
    <div class="row text-center">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div> 
    </div> 
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div>
        <form action="{{ url('account_310_dash') }}" method="GET">
            @csrf
            <div class="row mt-2"> 
                <div class="col-md-3">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.310</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.310</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <select name="acc_trimart_id" id="acc_trimart_id" class="form-control cardacc">
                        <option value="">--เลือก--</option>
                        @foreach ($trimart as $item)
                            <option value="{{$item->acc_trimart_id}}">{{$item->acc_trimart_name}}( {{$item->acc_trimart_start_date}} ถึง {{$item->acc_trimart_end_date}})</option>
                        @endforeach
                    </select>
                </div>
           
                    <div class="col-md-2 text-start">
                        <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardacc" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button> 
                    {{-- <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button> --}}
                    {{-- <a href="{{url('account_310_pull')}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" target="_blank">  
                        <i class="fa-solid fa-file-circle-plus text-primary me-2"></i>
                        ดึงข้อมูล
                    </a> --}}
                </div>
            </div>
        </form>  
        <div class="row"> 
            @foreach ($data_trimart as $item)   
            <div class="col-xl-4 col-md-4">
                <div class="card cardacc" style="background-color: rgb(235, 242, 247)"> 

                    {{-- @if ($startdate == '') --}}
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="d-flex text-start">
                                    <div class="flex-grow-1 ">
                                        <?php
                                           
                                            // ลูกหนี้ทั้งหมด
                                            $datas = DB::select('
                                                SELECT count(DISTINCT an) as Can
                                                    ,SUM(debit) as sumdebit
                                                    from acc_debtor
                                                    WHERE account_code="1102050101.310"
                                                    AND stamp = "N"
                                                    AND dchdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้
                                             $datasum_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(an) as Cvit
                                                from acc_1102050101_310
                                                where dchdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                            ');   
                                            foreach ($datasum_ as $key => $value2) {
                                                $sum_Y = $value2->debit_total;
                                                $count_Y = $value2->Cvit;
                                            }
                                            
                                            //STM
                                            $sumapprove_ = DB::select('
                                                SELECT 
                                                    SUM(ar.acc_stm_repmoney_price310) as total                                                   
                                                    FROM acc_stm_repmoney ar 
                                                    LEFT JOIN acc_trimart a ON a.acc_trimart_id = ar.acc_trimart_id 
                                                    WHERE ar.acc_trimart_id = "'.$item->acc_trimart_id.'" 
                                            ');                                           
                                            foreach ($sumapprove_ as $key => $value3) {
                                                $total310 = $value3->total; 
                                            }

                                            if ( $sum_Y > $total310) {
                                                $yokpai_ = $sum_Y - $total310;
                                                $yokpai = '-'.$yokpai_;
                                            } else {
                                                $yokpai_ = $total310 - $sum_Y;
                                                $yokpai = '+'.$yokpai_;
                                            }
                                            

                                            
                                        ?>
                                        <div class="row">
                                            <div class="col-md-5 text-start mt-4 ms-4">
                                                <h5> {{$item->acc_trimart_name}} {{($item->year)+543}}</h5>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end mt-2 me-2">
                                                {{-- <a href="{{url('account_310_pull')}}" target="_blank"> --}}
                                                    <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                        <h6 class="text-end">{{ $count_N}} Visit</h6>
                                                    </div>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0"> 
                                                    ลูกหนี้ที่ต้องตั้ง
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                                {{-- <a href="" target="_blank"> --}}
                                                    <div class="widget-chart widget-chart-hover" >
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{ $count_N}} Visit" >
                                                                {{ number_format($sum_N, 2) }} 
                                                                <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                        </p>
                                                    </div>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-danger"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0" >
                                                    ตั้งลูกหนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                                {{-- <a href="{{url('account_302_detail/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank"> --}}
                                                <a href="{{url('account_310_dashsub/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                {{ number_format($sum_Y, 2) }}
                                                                <i class="fa-brands fa-btc text-danger ms-2"></i>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-success"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        Statement
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                         
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{number_format($total310, 2) }} บาท">
                                                                {{ number_format($total310, 2) }} 
                                                                <i class="fa-brands fa-btc text-success ms-2"></i>
                                                        </p>
                                                    </div>
                                              
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        ยกยอดไปเดือนนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-2">
                                               
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                            @if ($yokpai > 0)
                                                            + {{ number_format($yokpai, 2) }} 
                                                            @else
                                                            {{ number_format($yokpai, 2) }} 
                                                            @endif
                                                           
                                                                <i class="fa-brands fa-btc ms-2" style="color: rgb(160, 12, 98)"></i>
                                                        </p>
                                                    </div>
                                              
                                            </div>
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
            $('#acc_trimart_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
