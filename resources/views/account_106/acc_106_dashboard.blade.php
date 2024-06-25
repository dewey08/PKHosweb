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

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

   <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        <form action="{{ route('acc.acc_106_dashboard') }}" method="GET">
            @csrf
            <div class="row ms-2 me-2 mt-2">
                <div class="col-md-3">
                    <h5 class="card-title">Detail 1102050102.106</h5>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050102.106</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>
                 
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                </div>
                </div>

            </div>
        </form>
        <div class="row ">
            @foreach ($datashow as $item)
                <div class="col-xl-4 col-md-12">
                    <div class="main-card mb-3 card shadow" style="background-color: rgb(246, 235, 247)">
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
                                                            WHERE account_code="1102050102.106"
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
                                                        from acc_1102050102_106
                                                        where month(vstdate) = "'.$item->months.'"
                                                        AND year(vstdate) = "'.$item->year.'"; 
                                                        
                                                    ');   
                                                    foreach ($datasum_ as $key => $value2) {
                                                        $sum_Y = $value2->debit_total;
                                                        $count_Y = $value2->Cvit;
                                                    }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-5 text-start mt-4 ms-4">
                                                        <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end mt-2 me-2">
                                                        {{-- <a href="{{url('account_401_pull')}}" target="_blank"> --}}
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
                                                    <div class="col-md-4 text-start mt-3">
                                                        <p class="text-muted mb-0"> 
                                                            ลูกหนี้ที่ต้องตั้ง
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end me-2">
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
                                                    <div class="col-md-4 text-start mt-3">
                                                        <p class="text-muted mb-0" >
                                                            ตั้งลูกหนี้
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end me-2">
                                                        <a href="{{url('acc_106_detail/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                            <div class="widget-chart widget-chart-hover">
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                        {{ number_format($sum_Y, 2) }}
                                                                        <i class="fa-brands fa-btc text-danger ms-2"></i>
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
                                                        WHERE account_code="1102050102.106"
                                                        AND stamp = "N"
                                                        AND vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"  
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_N = $value->Can;
                                                    $sum_N = $value->sumdebit;
                                                }
                                                // ตั้งลูกหนี้
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                    from acc_1102050102_106
                                                    where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"   
                                                    
                                                ');   
                                                foreach ($datasum_ as $key => $value2) {
                                                    $sum_Y = $value2->debit_total;
                                                    $count_Y = $value2->Cvit;
                                                }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-5 text-start mt-4 ms-4">
                                                    <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    {{-- <a href="{{url('account_401_pull')}}" target="_blank"> --}}
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
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0"> 
                                                        ลูกหนี้ที่ต้องตั้ง
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
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
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0" >
                                                        ตั้งลูกหนี้
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="{{url('acc_106_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                    {{ number_format($sum_Y, 2) }}
                                                                    <i class="fa-brands fa-btc text-danger ms-2"></i>
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
