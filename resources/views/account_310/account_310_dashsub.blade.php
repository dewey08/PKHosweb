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
       
            <div class="row"> 
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.310</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.310</p>
                </div>
                <div class="col"></div>
               
            </div>
        
        <div class="row"> 
            @foreach ($datashow as $item)   
            <div class="col-xl-4 col-md-6">
                <div class="card cardacc" style="background-color: rgb(246, 235, 247)"> 
 
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <div class="d-flex text-start">
                                    <div class="flex-grow-1 ">
                                        <?php   
                                         $y = $item->year;
                                        $ynew = $y + 543;
                                            $datashow_a = DB::select('
                                                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME,l.MONTH_ID
                                                    ,count(distinct a.hn) as hn
                                                    ,count(distinct a.vn) as vn 
                                                    ,sum(a.income) as income
                                                    ,sum(a.paid_money) as paid_money
                                                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                                                    ,sum(a.debit) as debit
                                                    FROM acc_debtor a
                                                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                                                    WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                                                    and month(a.dchdate) = "'.$item->months.'" 
                                                    and a.account_code="1102050101.310"  
                                                    and a.stamp ="N"                                                  
                                            ');
                                            // WHERE month(a.vstdate) = "'.$item->months.'" 
                                            foreach ($datashow_a as $key => $value1) {
                                                $visit = $value1->vn;
                                                $sum_N = $value1->debit;
                                            }

                                            $datashow_b = DB::select('
                                                    SELECT month(a.dchdate) as months,year(a.dchdate) as year,l.MONTH_NAME,l.MONTH_ID
                                                    ,count(distinct a.hn) as hn
                                                    ,count(distinct a.vn) as vn 
                                                    ,sum(a.income) as income
                                                    ,sum(a.paid_money) as paid_money
                                                    ,sum(a.income)-sum(a.discount_money)-sum(a.rcpt_money) as total
                                                    ,sum(a.debit) as debit
                                                    FROM acc_debtor a
                                                    left outer join leave_month l on l.MONTH_ID = month(a.dchdate)
                                                    WHERE a.dchdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                                                    and month(a.dchdate) = "'.$item->months.'"
                                                    and a.account_code="1102050101.310" and a.stamp ="Y"    
                                                                                                  
                                            ');
                                            foreach ($datashow_b as $key => $value2) {
                                                $count_Y = $value2->vn;
                                                $sum_Y = $value2->debit;
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-5 text-start mt-4 ms-4">
                                                <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-3 text-end mt-2 me-4">
                                                <a href="{{url('account_301_pull')}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ตั้ง {{$visit}} Visit">
                                                        <h6 class="text-end">{{$visit}} Visit</h6>
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
                                            <div class="col-md-4 text-end me-4">
                                                {{-- <a href="" target="_blank"> --}}
                                                    <div class="widget-chart widget-chart-hover" >
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{ $visit}} Visit" >
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
                                            <div class="col-md-4 text-end me-4">
                                                {{-- <a href="" target="_blank"> --}}
                                                    <a href="{{url('account_310_dashsubdetail/'.$item->months.'/'.$item->year)}}" target="_blank">
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
