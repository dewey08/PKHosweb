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
        body{
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }
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
        <form action="{{ route('acc.account_603_dash') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050102.603</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050102.603</p>
                </div>
                
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control cardacc" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control cardacc" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>
                            <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardacc" data-style="expand-left">
                                <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                                <span class="ladda-spinner"></span>
                            </button>
                            {{-- <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                                ค้นหา
                            </button> --}}
                    </div>
                </div>
                {{-- <div class="col-md-2 text-start">
                    <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                  
                </div> --}}

            </div>
        </form>
        <div class="row">
            @foreach ($datashow as $item)
            <div class="col-xl-4 col-md-12">
                <div class="card cardacc" style="background-color: rgb(246, 235, 247)">
                    @if ($startdate == '')
                        <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12">
                                    <div class="d-flex text-start">
                                        <div class="flex-grow-1 ">
                                            <?php
                                                $y = $item->year;
                                                $ynew = $y + 543;
                                                // ลูกหนี้ทั้งหมด
                                                $datas = DB::select('
                                                    SELECT count(DISTINCT an) as Can
                                                        ,SUM(debit) as sumdebit
                                                        from acc_debtor
                                                            WHERE account_code="1102050102.603"
                                                            AND stamp = "N"
                                                            and month(dchdate) = "'.$item->months.'"
                                                            and year(dchdate) = "'.$item->year.'";
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_N = $value->Can;
                                                    $sum_N = $value->sumdebit;
                                                }
                                                // ตั้งลูกหนี้
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(an) as Cvit
                                                            from acc_1102050102_603
                                                            WHERE month(dchdate) = "'.$item->months.'"
                                                            and year(dchdate) = "'.$item->year.'"
                                                ');
                                                // AND status = "N"
                                                foreach ($datasum_ as $key => $value2) {
                                                    $sum_Y = $value2->debit_total;
                                                    $count_Y = $value2->Cvit;
                                                }
                                                // AND status = "N"
                                                // สีเขียว STM
                                            
                                                $sumapprove_ = DB::select('
                                                        SELECT count(DISTINCT U1.an) as Apvit,sum(U1.recieve_true) as recieve_true
                                                            from acc_1102050102_603 U1
                                                            
                                                            WHERE month(U1.dchdate) = "'.$item->months.'"
                                                            and year(U1.dchdate) = "'.$item->year.'"
                                                            AND U1.recieve_true IS NOT NULL
                                                        
                                                ');
                                                // count(DISTINCT U1.an) as Apvit,
                                                    foreach ($sumapprove_ as $key => $value3) {
                                                        $sum_stm = $value3->recieve_true;
                                                        $stm_count = $value3->Apvit;
                                                    }

                                                $data_null = DB::select('
                                                        SELECT count(DISTINCT an) as yokpai_an,sum(debit_total) as yokpai 
                                                            from acc_1102050102_603 
                                                            WHERE month(dchdate) = "'.$item->months.'"
                                                            and year(dchdate) = "'.$item->year.'"
                                                            AND recieve_true IS NULL 
                                                ');
                                                foreach ($data_null as $key => $valnull) {
                                                    $countyokpia = $valnull->yokpai_an;
                                                    $sumyokpia = $valnull->yokpai;
                                                }
                                                

                                                if ( $sum_Y > $sum_stm) {
                                                    $yokpai_ = $sum_Y - $sum_stm;
                                                    $yokpai = '-'.$yokpai_;
                                                    $yokpaicount = $count_Y - $stm_count;
                                                } else {
                                                    $yokpai_ = $sum_stm - $sum_Y;
                                                    $yokpai = '+'.$yokpai_;
                                                    $yokpaicount = $stm_count - $count_Y;
                                                }
                                                    
                                            ?>
                                            <div class="row">
                                                <div class="col-md-6 text-start mt-4 ms-4">
                                                    <h5 >เดือน {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                </div>
                                                {{-- <div class="col"></div> --}}
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    <a href="{{url('account_603_pull')}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                            <h6 class="text-end">{{$count_N}} Visit</h6>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                                </div>
                                                <div class="col-md-5 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                        {{-- <span class="text-secondary fw-bold font-size-15 me-2" style="font-family: sans-serif">ลูกหนี้ทั้งหมด</span> --}}
                                                        ลูกหนี้ที่ต้องตั้ง
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-4 text-end me-2">
                                                    {{-- <a href="" target="_blank"> --}}
                                                        <div class="widget-chart widget-chart-hover" >
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
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
                                                <div class="col-md-5 text-start mt-3">
                                                    <p class="text-muted mb-0" >
                                                        ตั้งลูกหนี้
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-4 text-end me-2">
                                                    <a href="{{url('account_603_detail/'.$item->months.'/'.$item->year)}}" target="_blank">
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
                                                <div class="col-md-5 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                            Statement
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-4 text-end me-2">
                                                    <a href="{{url('account_603_stm/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$stm_count}} Visit">
                                                                    {{ number_format($sum_stm, 2) }} 
                                                                    <i class="fa-brands fa-btc text-success ms-2"></i>
                                                            </p>
                                                        </div>
                                                        {{-- title="Statement {{$stm_count}} Visit" --}}
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1 text-start ms-4">
                                                    <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                                </div>
                                                <div class="col-md-5 text-start mt-3">
                                                    <p class="text-muted mb-0">
                                                            ยกยอดไปเดือนนี้
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-4 text-end me-2">
                                                    <a href="{{url('account_603_stmnull/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            {{-- <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวน {{$yokpaicount}} Visit">
                                                                @if ($yokpai > 0)
                                                                + {{ number_format($yokpai, 2) }} 
                                                                @else
                                                                {{ number_format($yokpai, 2) }} 
                                                                @endif --}}
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวน {{$countyokpia}} Visit">
                                                        {{ number_format($sumyokpia, 2) }} 
                                                                    <i class="fa-brands fa-btc ms-2" style="color: rgb(160, 12, 98)"></i>
                                                            </p>
                                                        </div>
                                                    </a>  
                                                </div>
                                            </div>

                                        

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else

                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="d-flex text-start">
                                    <div class="flex-grow-1 ">
                                        <?php
                                            $y = $item->year;
                                            $ynew = $y + 543;
                                            // ลูกหนี้ทั้งหมด
                                            $datas = DB::select('
                                                SELECT count(DISTINCT an) as Can
                                                    ,SUM(debit) as sumdebit
                                                    from acc_debtor
                                                        WHERE account_code="1102050102.603"
                                                        AND stamp = "N"
                                                        AND dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้
                                            $datasum_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(an) as Cvit
                                                        from acc_1102050102_603
                                                        WHERE dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
                                            ');
                                            // AND status = "N"
                                            foreach ($datasum_ as $key => $value2) {
                                                $sum_Y = $value2->debit_total;
                                                $count_Y = $value2->Cvit;
                                            }
                                            // AND status = "N"
                                            // สีเขียว STM
                                        
                                            $sumapprove_ = DB::select('
                                                    SELECT count(DISTINCT U1.an) as Apvit,sum(U1.recieve_true) as recieve_true
                                                        from acc_1102050102_603 U1
                                                        
                                                        WHERE U1.dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
                                                        AND U1.recieve_true IS NOT NULL
                                                    
                                            ');
                                            // count(DISTINCT U1.an) as Apvit,
                                                foreach ($sumapprove_ as $key => $value3) {
                                                    $sum_stm = $value3->recieve_true;
                                                    $stm_count = $value3->Apvit;
                                                }

                                            $data_null = DB::select('
                                                    SELECT count(DISTINCT an) as yokpai_an,sum(debit_total) as yokpai 
                                                        from acc_1102050102_603 
                                                        WHERE dchdate BETWEEN "'.$startdate.'" AND  "'.$enddate.'" 
                                                        AND recieve_true IS NULL 
                                            ');
                                            foreach ($data_null as $key => $valnull) {
                                                $countyokpia = $valnull->yokpai_an;
                                                $sumyokpia = $valnull->yokpai;
                                            }
                                            

                                            if ( $sum_Y > $sum_stm) {
                                                $yokpai_ = $sum_Y - $sum_stm;
                                                $yokpai = '-'.$yokpai_;
                                                $yokpaicount = $count_Y - $stm_count;
                                            } else {
                                                $yokpai_ = $sum_stm - $sum_Y;
                                                $yokpai = '+'.$yokpai_;
                                                $yokpaicount = $stm_count - $count_Y;
                                            }
                                                
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6 text-start mt-4 ms-4">
                                                <h5 >เดือน {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                            </div>
                                            {{-- <div class="col"></div> --}}
                                            <div class="col-md-5 text-end mt-2 me-4">
                                                {{-- <a href="{{url('account_603_pull')}}" target="_blank"> --}}
                                                    <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                        <h6 class="text-end">{{$count_N}} Visit</h6>
                                                    </div>
                                                {{-- </a> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-solid fa-2x fa-sack-dollar me-2 align-middle text-secondary"></i>
                                            </div>
                                            <div class="col-md-5 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                    {{-- <span class="text-secondary fw-bold font-size-15 me-2" style="font-family: sans-serif">ลูกหนี้ทั้งหมด</span> --}}
                                                    ลูกหนี้ที่ต้องตั้ง
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-4 text-end me-4">
                                                {{-- <a href="" target="_blank"> --}}
                                                    <div class="widget-chart widget-chart-hover" >
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
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
                                            <div class="col-md-5 text-start mt-3">
                                                <p class="text-muted mb-0" >
                                                    ตั้งลูกหนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-4 text-end me-4">
                                                <a href="{{url('account_603_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank">
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
                                            <div class="col-md-5 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        Statement
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-4 text-end me-4">
                                                <a href="{{url('account_603_stm_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$stm_count}} Visit">
                                                                {{ number_format($sum_stm, 2) }} 
                                                                <i class="fa-brands fa-btc text-success ms-2"></i>
                                                        </p>
                                                    </div>
                                                    {{-- title="Statement {{$stm_count}} Visit" --}}
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1 text-start ms-4">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                            </div>
                                            <div class="col-md-5 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        ยกยอดไปเดือนนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-4 text-end me-4">
                                                <a href="{{url('account_603_stmnull_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        {{-- <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวน {{$yokpaicount}} Visit">
                                                            @if ($yokpai > 0)
                                                            + {{ number_format($yokpai, 2) }} 
                                                            @else
                                                            {{ number_format($yokpai, 2) }} 
                                                            @endif --}}
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวน {{$countyokpia}} Visit">
                                                    {{ number_format($sumyokpia, 2) }} 
                                                                <i class="fa-brands fa-btc ms-2" style="color: rgb(160, 12, 98)"></i>
                                                        </p>
                                                    </div>
                                                </a>  
                                            </div>
                                        </div>

                                    

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif
                    
                </div>
            </div>
            @endforeach
        </div>

    </div>
<br><br><br> 
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
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
