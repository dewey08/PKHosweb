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
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
        <form action="{{ url('account_pkti3099_dash') }}" method="GET">
            @csrf
            <div class="row mt-3"> 
                <div class="col-md-3">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.3099</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.3099</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-5 text-end">
                   
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
            </div>
        </form>  
        <div class="row"> 
            @foreach ($datashow as $item)   
            <div class="col-xl-4 col-md-6">
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
                                                    SELECT count(DISTINCT vn) as Can
                                                        ,SUM(debit_total) as sumdebit
                                                        from acc_debtor
                                                        WHERE account_code="1102050101.3099"
                                                        AND stamp = "N"
                                                        AND month(vstdate) = "'.$item->months.'"
                                                        AND year(vstdate) = "'.$item->year.'"; 
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_N = $value->Can;
                                                    $sum_N = $value->sumdebit;
                                                }
                                                // ตั้งลูกหนี้
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                    from acc_1102050101_3099
                                                    where month(vstdate) = "'.$item->months.'"
                                                    AND year(vstdate) = "'.$item->year.'"; 
                                                    
                                                ');   
                                                foreach ($datasum_ as $key => $value2) {
                                                    $sum_Y = $value2->debit_total;
                                                    $count_Y = $value2->Cvit;
                                                }
                                                
                                            // STM
                                            $sumapprove_ = DB::select('
                                                    SELECT sum(am.Total_amount) as Total_amount,count(DISTINCT a.vn) as Countvisit
                                                        from acc_1102050101_3099 a
                                                        LEFT JOIN acc_stm_ti_total am on am.cid = a.cid AND am.vstdate = a.vstdate
                                                        where month(a.vstdate) = "'.$item->months.'"
                                                        AND year(a.vstdate) = "'.$item->year.'"
                                                        AND Total_amount <> ""
                                                ');                                           
                                                foreach ($sumapprove_ as $key => $value3) {
                                                    $sum_stm = $value3->Total_amount; 
                                                    $count_stm = $value3->Countvisit; 
                                                }

                                                // Yokpai
                                            $yokpai_data = DB::select('
                                                    SELECT sum(a.debit_total) as debit_total,count(DISTINCT a.vn) as Countvisit
                                                        from acc_1102050101_3099 a
                                                        LEFT JOIN acc_stm_ti_total am on am.cid = a.cid AND am.vstdate = a.vstdate
                                                        where month(a.vstdate) = "'.$item->months.'"
                                                        AND year(a.vstdate) = "'.$item->year.'"
                                                        AND Total_amount IS NULL
                                                ');                                           
                                                foreach ($yokpai_data as $key => $value4) {
                                                    $sum_yokpai = $value4->debit_total; 
                                                    $count_yokpai = $value4->Countvisit; 
                                                }
                                                
                                                // if ( $sum_Y > $sum_stm) {
                                                //     $yokpai_ = $sum_Y - $sum_stm;
                                                //     $yokpai = '-'.$yokpai_;
                                                //     $count_yokpai = $count_Y - $count_stm;
                                                // } else {
                                                //     $yokpai_ = $sum_stm - $sum_Y;
                                                //     $yokpai = '+'.$yokpai_;
                                                //     $count_yokpai = $count_Y - $count_stm;
                                                // }
                                                // $yokpai = $sum_yokpai;
                                                // $count_yokpai = $count_Y - $count_stm;
                                                

                                                
                                            ?>
                                            <div class="row">
                                                <div class="col-md-5 text-start mt-4 ms-4">
                                                    <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    <a href="{{url('account_pkti3099_pull')}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                            <h6 class="text-end">{{ $count_N}} Visit</h6>
                                                        </div>
                                                    </a>
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
                                                        <div class="widget-chart widget-chart-hover" >
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{ $count_N}} Visit" >
                                                                    {{ number_format($sum_N, 2) }} 
                                                                    <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                            </p>
                                                        </div> 
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
                                                    <a href="{{url('account_pkti3099_detail/'.$item->months.'/'.$item->year)}}" target="_blank">
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
                                                    <a href="{{url('account_pkti3099_stm/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$count_stm}} Visit">
                                                                {{ number_format($sum_stm, 2) }} 
                                                                    <i class="fa-brands fa-btc text-success ms-2"></i>
                                                            </p>
                                                        </div>
                                                    </a>
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
                                                    <a href="{{url('account_pkti3099_stmnull/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยกยอดไปเดือนนี้ {{$count_yokpai}} Visit" >
                                                            {{ number_format($sum_yokpai, 2) }}  
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
                                                SELECT count(DISTINCT vn) as Can
                                                    ,SUM(debit_total) as sumdebit
                                                    from acc_debtor
                                                    WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                                                    AND account_code="1102050101.3099"
                                                    AND stamp = "N"   
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้
                                            $datasum_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                FROM acc_1102050101_3099
                                                WHERE vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"; 
                                                
                                            ');   
                                            foreach ($datasum_ as $key => $value2) {
                                                $sum_Y = $value2->debit_total;
                                                $count_Y = $value2->Cvit;
                                            }
                                            
                                        // STM
                                        $sumapprove_ = DB::select('
                                                SELECT sum(am.Total_amount) as Total_amount,count(DISTINCT a.vn) as Countvisit
                                                    from acc_1102050101_3099 a
                                                    LEFT JOIN acc_stm_ti_total am on am.cid = a.cid AND am.vstdate = a.vstdate
                                                    WHERE a.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                                    AND am.Total_amount <> ""
                                            ');                                           
                                            foreach ($sumapprove_ as $key => $value3) {
                                                $sum_stm = $value3->Total_amount; 
                                                $count_stm = $value3->Countvisit; 
                                            }

                                            // Yokpai
                                        $yokpai_data = DB::select('
                                                SELECT sum(a.debit_total) as debit_total,count(DISTINCT a.vn) as Countvisit
                                                    from acc_1102050101_3099 a
                                                    LEFT JOIN acc_stm_ti_total am on am.cid = a.cid AND am.vstdate = a.vstdate
                                                    WHERE a.vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                                    AND Total_amount IS NULL
                                            ');                                           
                                            foreach ($yokpai_data as $key => $value4) {
                                                $sum_yokpai = $value4->debit_total; 
                                                $count_yokpai = $value4->Countvisit; 
                                            }
                                           
                                        ?>
                                        <div class="row">
                                            <div class="col-md-5 text-start mt-4 ms-4">
                                                <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end mt-2 me-2">
                                                <a href="{{url('account_pkti3099_pull')}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                        <h6 class="text-end">{{ $count_N}} Visit</h6>
                                                    </div>
                                                </a>
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
                                                    <div class="widget-chart widget-chart-hover" >
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{ $count_N}} Visit" >
                                                                {{ number_format($sum_N, 2) }} 
                                                                <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                        </p>
                                                    </div> 
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
                                                <a href="{{url('account_pkti3099_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank">
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
                                                <a href="{{url('account_pkti3099_stm_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$count_stm}} Visit">
                                                            {{ number_format($sum_stm, 2) }} 
                                                                <i class="fa-brands fa-btc text-success ms-2"></i>
                                                        </p>
                                                    </div>
                                                </a>
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
                                                <a href="{{url('account_pkti3099_stmnull_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ยกยอดไปเดือนนี้ {{$count_yokpai}} Visit" >
                                                        {{ number_format($sum_yokpai, 2) }}  
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
