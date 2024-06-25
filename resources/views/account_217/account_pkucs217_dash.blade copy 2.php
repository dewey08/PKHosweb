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
        <form action="{{ route('acc.account_pkucs217_dash') }}" method="GET">
            @csrf
            <div class="row"> 
                <div class="col-md-4">
                    <h4 class="card-title">Detail 1102050101.217</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.217</p>
                </div>
                <div class="col"></div>
                {{-- <div class="col-md-1 text-end mt-2">วันที่</div> --}}
                
                @if ($budget_year =='')
                <div class="col-md-2"> 
                        <select name="budget_year" id="budget_year" class="form-control inputmedsalt text-center" style="width: 100%">
                            @foreach ($dabudget_year as $item_y)
                                @if ($y == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif                                   
                            @endforeach
                        </select>
                </div>
                @else
                <div class="col-md-2"> 
                        <select name="budget_year" id="budget_year" class="form-control inputmedsalt text-center" style="width: 100%">
                            @foreach ($dabudget_year as $item_y)
                                @if ($budget_year == $item_y->leave_year_id )
                                    <option value="{{$item_y->leave_year_id}}" selected>{{$item_y->leave_year_name}}</option>
                                @else
                                    <option value="{{$item_y->leave_year_id}}">{{$item_y->leave_year_name}}</option>
                                @endif                                   
                            @endforeach
                        </select>
                </div>
                @endif
                <div class="col-md-1 text-start"> 
                    {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control inputacc" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control inputacc" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>    --}}
                    <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button> 
                    {{-- <button type="button" class="ladda-button btn-pill btn btn-danger cardacc" data-style="expand-left" id="Processdata">
                        <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ประมวลผล</span>
                        <span class="ladda-spinner"></span>
                    </button> --}}
                     
                </div>
                        {{-- <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                            <input type="text" class="form-control inputacc" name="startdate" id="datepicker" placeholder="Start Date"
                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                data-date-language="th-th" value="{{ $startdate }}" required/>
                            <input type="text" class="form-control inputacc" name="enddate" placeholder="End Date" id="datepicker2"
                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                data-date-language="th-th" value="{{ $enddate }}" required/>  
                                <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardacc" data-style="expand-left">
                                    <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                                    <span class="ladda-spinner"></span>
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
                                                $y = $item->years;
                                                $ynew = $y + 543;
                                                // ลูกหนี้ทั้งหมด
                                                $datas = DB::select('
                                                    SELECT count(DISTINCT an) as Can
                                                        ,SUM(debit) as sumdebit
                                                        from acc_debtor
                                                            WHERE account_code="1102050101.217"
                                                            AND stamp = "N"
                                                            and month(dchdate) = "'.$item->months.'"
                                                            and year(dchdate) = "'.$item->years.'";
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_N = $value->Can;
                                                    $sum_N = $value->sumdebit;
                                                }
                                                // ตั้งลูกหนี้
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                            from acc_1102050101_217
                                                            WHERE month(dchdate) = "'.$item->months.'"
                                                            and year(dchdate) = "'.$item->years.'" 
                                                ');
                                                
                                                // AND status = "N"
                                                foreach ($datasum_ as $key => $value2) {
                                                    $sum_Y = $value2->debit_total;
                                                    $count_Y = $value2->Cvit;
                                                }
                                                // สีเขียว STM
                                                $sumapprove_ = DB::select('
                                                        SELECT count(DISTINCT a.an) as Apvit ,sum(s.hc_drug)+sum(s.hc)+sum(s.ae)+sum(s.ae_drug)+sum(s.inst)+sum(s.dmis_money2)+sum(s.dmis_drug) as STM217
                                                            FROM acc_1102050101_217 a
                                                            LEFT JOIN acc_stm_ucs s ON s.an = a.an 
                                                            WHERE year(a.dchdate) = "'.$item->years.'"
                                                            AND month(a.dchdate) = "'.$item->months.'" 
                                                            AND (s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> 0 OR s.hc_drug+ s.hc+ s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> "") 

                                                    ');
                                                    
                                                    foreach ($sumapprove_ as $key => $value3) {
                                                        $amountpay = $value3->STM217;
                                                        $stm_count = $value3->Apvit;
                                                    }
                                                     
                                                    // $mo = $item->months;
                                                    $sumyokma_all_ = DB::select('
                                                        SELECT count(DISTINCT U1.an) as anyokma ,sum(U1.debit_total) as debityokma
                                                                FROM acc_1102050101_217 U1
                                                                LEFT JOIN acc_stm_ucs s ON s.an = U1.an 
                                                                WHERE U1.status ="N" 
                                                                AND year(U1.dchdate) = "'.$item->years.'"
                                                                AND month(U1.dchdate) = "'.$item->months.'"
                                                                AND (s.hc_drug+ s.hc+ s.ae+s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug = 0 OR s.hc_drug+ s.hc+ s.ae+s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug is null) 
                                                                
                                                    ');
                                                    // AND month(U1.dchdate) < "'.$mo.'"
                                                    // AND U2.rep IS NULL
                                                    foreach ($sumyokma_all_ as $key => $value6) {
                                                        $total_yokma_all = $value6->debityokma;
                                                        $count_yokma_all = $value6->anyokma;
                                                    }
 
                                            ?>
                                            <div class="row">
                                                <div class="col-md-5 text-start mt-4 ms-4">
                                                    <h5 >{{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end mt-2 me-2">
                                                    <a href="{{url('account_pkucs217')}}" target="_blank">
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
                                                <div class="col-md-4 text-start mt-3">
                                                    <p class="text-muted mb-0"> 
                                                        ลูกหนี้ที่ต้องตั้ง
                                                    </p>
                                                </div>
                                                <div class="col"></div>
                                                <div class="col-md-5 text-end me-2">
                                                    <a href="" target="_blank">
                                                        <div class="widget-chart widget-chart-hover" >
                                                            <p class="text-end mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
                                                                    {{ number_format($sum_N, 2) }}
                                                                    <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                            </p>
                                                        </div>
                                                    </a>
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
                                                    <a href="{{url('account_pkucs217_detail/'.$item->months.'/'.$item->years)}}" target="_blank">
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
                                                    <a href="{{url('account_pkucs217_stm/'.$item->months.'/'.$item->years)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$stm_count}} Visit">
                                                                    {{ number_format($amountpay, 2) }}
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
                                                    <a href="{{url('account_pkucs217_stmnull/'.$item->months.'/'.$item->years)}}" target="_blank">
                                                        <div class="widget-chart widget-chart-hover">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$count_yokma_all}} Visit">
                                                                    {{ number_format($total_yokma_all, 2) }}
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
                  
                    {{-- <div class="grid-menu-col">
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
                                                        WHERE account_code="1102050101.217"
                                                        AND stamp = "N"
                                                        and dchdate BETWEEN "'.$startdate.'" and  "'.$enddate.'"
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้
                                            $datasum_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                        from acc_1102050101_217
                                                        WHERE dchdate BETWEEN "'.$startdate.'" and  "'.$enddate.'"
                                            ');                                            
                                            // AND status = "N"
                                            foreach ($datasum_ as $key => $value2) {
                                                $sum_Y = $value2->debit_total;
                                                $count_Y = $value2->Cvit;
                                            }
                                            // สีเขียว STM
                                            $sumapprove_ = DB::select('
                                                SELECT count(DISTINCT a.an) as Apvit ,sum(s.hc_drug)+sum(s.hc)+sum(s.ae)+sum(s.ae_drug)+sum(s.inst)+sum(s.dmis_money2)+sum(s.dmis_drug) as STM217
                                                    FROM acc_1102050101_217 a
                                                    LEFT JOIN acc_stm_ucs s ON s.an = a.an 
                                                    WHERE a.dchdate BETWEEN "'.$startdate.'" and  "'.$enddate.'"
                                                    AND s.hc_drug + s.hc + s.ae + s.ae_drug + s.inst + s.dmis_money2 + s.dmis_drug > "0.00"
                                                   
                                            ');
                                            // AND (s.hc_drug+ s.hc+s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug > "0.00" OR s.hc_drug+ s.hc+s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> "")  
                                            // AND (s.hc_drug+ s.hc+s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug > "0.00" OR s.hc_drug+ s.hc+s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug <> "")  
                                            // AND (s.hc_drug >0 or s.hc >0 or s.ae >0 or s.ae_drug >0 or s.inst >0 or s.dmis_money2 >0 or s.dmis_drug >0)
                                            // AND au.ip_paytrue IS NOT NULL
                                            foreach ($sumapprove_ as $key => $value3) {
                                                $amountpay = $value3->STM217;
                                                $stm_count = $value3->Apvit;
                                            }                                                 
                                            // $mo = $item->months;
                                            $sumyokma_all_ = DB::select('
                                                SELECT count(DISTINCT U1.an) as anyokma ,sum(U1.debit_total) as debityokma
                                                        FROM acc_1102050101_217 U1
                                                        LEFT JOIN acc_stm_ucs s ON s.an = U1.an 
                                                        WHERE U1.status ="N" 
                                                        AND U1.dchdate BETWEEN "'.$startdate.'" and  "'.$enddate.'"
                                                        AND s.hc_drug + s.hc + s.ae + s.ae_drug + s.inst + s.dmis_money2 + s.dmis_drug <= "0.00" 
                                            ');
                                            // <= "0.00"
                                            // AND (s.hc_drug+ s.hc+s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug = "0.00" OR s.hc_drug+ s.hc+s.ae+ s.ae_drug+s.inst+s.dmis_money2 + s.dmis_drug is null) 
                                            // AND month(U1.dchdate) < "'.$mo.'"
                                            // AND U2.rep IS NULL
                                            foreach ($sumyokma_all_ as $key => $value6) {
                                                $total_yokma_all = $value6->debityokma;
                                                $count_yokma_all = $value6->anyokma;
                                            }

                                        ?>
                                        <div class="row">
                                            <div class="col-md-5 text-start mt-4 ms-4">
                                                <h5 >{{$item->MONTH_NAME}} {{$ynew}}</h5>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end mt-2 me-2">
                                           
                                                    <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง">
                                                        <h6 class="text-end">{{$count_N}} Visit</h6>
                                                    </div>
                                            
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
                                            <div class="col-md-5 text-end me-4">
                                               
                                                    <div class="widget-chart widget-chart-hover" >
                                                        <p class="text-end mb-0"  data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
                                                                {{ number_format($sum_N, 2) }}
                                                                <i class="fa-brands fa-btc text-secondary ms-2"></i>
                                                        </p>
                                                    </div>
                                           
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 text-start ms-2">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-danger"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0" >
                                                    ตั้งลูกหนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-4">
                                                <a href="{{url('account_pkucs217_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank">
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
                                            <div class="col-md-1 text-start ms-2">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle text-success"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        Statement
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-4">
                                                <a href="{{url('account_pkucs217_stm_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$stm_count}} Visit">
                                                                {{ number_format($amountpay, 2) }}
                                                                <i class="fa-brands fa-btc text-success ms-2"></i>
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1 text-start ms-2">
                                                <i class="fa-brands fa-2x fa-bitcoin me-2 align-middle" style="color: rgb(160, 12, 98)"></i>
                                            </div>
                                            <div class="col-md-4 text-start mt-3">
                                                <p class="text-muted mb-0">
                                                        ยกยอดไปเดือนนี้
                                                </p>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col-md-5 text-end me-4">
                                                <a href="{{url('account_pkucs217_stmnull_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                    <div class="widget-chart widget-chart-hover">
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$count_yokma_all}} Visit">
                                                                {{ number_format($total_yokma_all, 2) }}
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
                    </div> --}}

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
