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
            border-top: 10px #ff8897 solid;
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
        <form action="{{ url('account_203_dash') }}" method="GET">
            @csrf
            <div class="row mt-2"> 
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.203</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.203</p>
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
                                                                WHERE account_code="1102050101.203"
                                                                AND stamp = "N"
                                                                AND month(vstdate) = "'.$item->months.'"
                                                                AND year(vstdate) = "'.$item->year.'"; 
                                                        ');
                                                        foreach ($datas as $key => $value) {
                                                            $count_N = $value->Can;
                                                            $sum_N = $value->sumdebit;
                                                        }
                                                        // ตั้งลูกหนี้ OPD
                                                        $datasum_ = DB::select('
                                                            SELECT sum(income) as debit_total,count(DISTINCT vn) as Cvit
                                                            from acc_1102050101_203
                                                            where month(vstdate) = "'.$item->months.'"
                                                            AND year(vstdate) = "'.$item->year.'"
                                                        
                                                        ');   
                                                        foreach ($datasum_ as $key => $value2) {
                                                            $sum_Y = $value2->debit_total;
                                                            $count_Y = $value2->Cvit;
                                                        }
        
                                                        $total_sumY   = $sum_Y ;
                                                        $total_countY = $count_Y;

                                                        // ตั้งลูกหนี้ OPD ตามข้อตกลง
                                                        $datasum_ = DB::select('
                                                            SELECT sum(debit_total) as debit_total,sum(ct_price) as debit_ct_price,count(DISTINCT vn) as Cvit
                                                            from acc_1102050101_203
                                                            where month(vstdate) = "'.$item->months.'"
                                                            AND year(vstdate) = "'.$item->year.'"; 
                                                            
                                                        ');   
                                                        foreach ($datasum_ as $key => $value5) {
                                                            $sum_toklong = $value5->debit_total+$value5->debit_ct_price;
                                                            $count_toklong = $value5->Cvit;
                                                        }
                                                        
                                                        // STM
                                                        $sumapprove_ = DB::select('
                                                                SELECT sum(recieve_true) as recieve_true,count(vn) as Countvisit
                                                                    from acc_1102050101_203
                                                                    where month(vstdate) = "'.$item->months.'"
                                                                    AND year(vstdate) = "'.$item->year.'"
                                                                    AND recieve_true IS NOT NULL
                                                            ');                                           
                                                            foreach ($sumapprove_ as $key => $value3) {
                                                                $sum_stm = $value3->recieve_true; 
                                                                $count_stm = $value3->Countvisit; 
                                                            }

                                                        // ยกไป
                                                        $yokpai_ = DB::select('
                                                                SELECT sum(debit_total) as debit_total,count(vn) as Countvi
                                                                    from acc_1102050101_203
                                                                    where month(vstdate) = "'.$item->months.'"
                                                                    AND year(vstdate) = "'.$item->year.'"
                                                                    AND recieve_true IS NULL
                                                            ');                                           
                                                            foreach ($yokpai_ as $key => $valpai) {
                                                                $sum_yokpai = $valpai->debit_total; 
                                                                $count_yokpai = $valpai->Countvi; 
                                                        }
        
                                                    ?>
        
                                                    <div class="row">
                                                        <div class="col-md-5 text-start mt-4 ms-4">
                                                            <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                        </div>
                                                        <div class="col"></div>
                                                        <div class="col-md-5 text-end mt-2 me-2"> 
                                                                <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง {{$count_N}}">
                                                                    <h6 class="text-end">{{$count_N}} Visit</h6>
                                                                </div> 
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-1 text-start ms-4">
                                                            <i class="fa-solid fa-sack-dollar align-middle text-secondary"></i>
                                                        </div>
                                                        <div class="col-md-4 text-start">
                                                            <p class="text-muted mb-0"> 
                                                                ลูกหนี้ที่ต้องตั้ง
                                                            </p>
                                                        </div>
                                                        <div class="col"></div>
                                                        <div class="col-md-5 text-end me-2">  
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_N}} Visit" >
                                                                {{ number_format($sum_N, 2) }}
                                                                <i class="fa-brands fa-btc text-secondary ms-2 me-2"></i>
                                                            </p> 
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-1 text-start mt-2 ms-4">
                                                            <i class="fa-brands fa-bitcoin align-middle text-danger"></i>
                                                        </div>
                                                        <div class="col-md-4 text-start mt-2">
                                                            <p class="text-muted mb-0" >
                                                                ตั้งลูกหนี้
                                                            </p>
                                                        </div>
                                                        <div class="col"></div>
                                                        <div class="col-md-5 text-end mt-2 me-2">
                                                            <a href="{{url('account_203_detail/'.$item->months.'/'.$item->year)}}" target="_blank"> 
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_Y}} Visit">
                                                                    {{ number_format($sum_Y, 2) }}
                                                                    <i class="fa-brands fa-btc text-danger ms-2 me-2"></i>
                                                                </p> 
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-1 text-start mt-2 ms-4">
                                                            <i class="fa-brands fa-bitcoin align-middle text-info"></i>
                                                        </div>
                                                        <div class="col-md-4 text-start mt-2">
                                                            <p class="text-muted mb-0">
                                                                ลูกหนี้ตามข้อตกลง+CT
                                                            </p>
                                                        </div>
                                                        <div class="col"></div>
                                                        <div class="col-md-5 text-end mt-2 me-2">  
                                                            <a href="{{url('account_203_hoscode/'.$item->months.'/'.$item->year)}}" target="_blank">
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_toklong}} Visit">
                                                                    {{ number_format($sum_toklong, 2) }}
                                                                    <i class="fa-brands fa-btc text-info ms-2 me-2"></i>
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-1 text-start mt-2 ms-4">
                                                            <i class="fa-brands fa-bitcoin align-middle text-success"></i>
                                                        </div>
                                                        <div class="col-md-4 text-start text-success mt-2">
                                                            <p class="text-muted mb-0">
                                                                Statement
                                                            </p>
                                                        </div>
                                                        <div class="col"></div>
                                                        <div class="col-md-5 text-end mt-2 me-2">  
                                                            <a href="{{url('account_203_stm/'.$item->months.'/'.$item->year)}}" target="_blank">  
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$count_stm}} Visit">
                                                                    {{-- {{ number_format($sum_stm, 2) }}  --}}
                                                                    ยังไม่ได้เขียน
                                                                    <i class="fa-brands fa-btc text-success ms-2 me-2"></i>
                                                                </p>    
                                                            </a>                               
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="row mb-4">
                                                        <div class="col-md-1 text-start mt-2 ms-4">
                                                            <i class="fa-brands fa-bitcoin align-middle text-primary"></i>
                                                        </div>
                                                        <div class="col-md-4 text-start mt-2">
                                                            <p class="text-muted mb-0">
                                                                ยกยอดไปเดือนนี้
                                                            </p>
                                                        </div>
                                                        <div class="col"></div>
                                                        <div class="col-md-5 text-end mt-2 me-2"> 
                                                            <a href="{{url('acc_107_debt_months/'.$item->months.'/'.$item->year)}}" target="_blank">          
                                                                <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement {{$count_yokpai}} Visit">
                                                                    {{-- {{ number_format($sum_yokpai, 2) }} --}}
                                                                    ยังไม่ได้เขียน
                                                                    <i class="fa-brands fa-btc text-success ms-2 me-2"></i>
                                                                </p>  
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
                                                            WHERE account_code="1102050101.203"
                                                            AND stamp = "N"
                                                            AND vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                                                    ');
                                                    foreach ($datas as $key => $value) {
                                                        $count_NN = $value->Can;
                                                        $sum_NN = $value->sumdebit;
                                                    }
                                                    
                                                    // ตั้งลูกหนี้ OPD
                                                    $datasum_ = DB::select('
                                                            SELECT sum(income) as debit_total,count(DISTINCT vn) as Cvit
                                                            from acc_1102050101_203
                                                            where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"    
                                                        ');   
                                                        foreach ($datasum_ as $key => $value2) {
                                                            $sum_YY = $value2->debit_total;
                                                            $count_YY = $value2->Cvit;
                                                        }
        
                                                        // ตั้งลูกหนี้ OPD ตามข้อตกลง
                                                        $datasum_ = DB::select('
                                                            SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                            from acc_1102050101_203
                                                            where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"  
                                                        ');   
                                                        foreach ($datasum_ as $key => $value5) {
                                                            $sum_toklong_d = $value5->debit_total;
                                                            $count_toklong_d = $value5->Cvit;
                                                        }
                                                
                                                ?>
                                            
                                                <div class="row">
                                                    <div class="col-md-5 text-start mt-4 ms-4">
                                                        <h5 > {{$item->MONTH_NAME}} {{$ynew}}</h5>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end mt-2 me-2"> 
                                                            <div class="widget-chart widget-chart-hover" data-bs-toggle="tooltip" data-bs-placement="top" title="จำนวนลูกหนี้ที่ต้องตั้ง {{$count_NN}}">
                                                                <h6 class="text-end">{{$count_NN}} Visit</h6>
                                                            </div> 
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-1 text-start ms-4">
                                                        <i class="fa-solid fa-sack-dollar align-middle text-secondary"></i>
                                                    </div>
                                                    <div class="col-md-4 text-start">
                                                        <p class="text-muted mb-0"> 
                                                            ลูกหนี้ที่ต้องตั้ง
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end me-2">  
                                                        <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ลูกหนี้ที่ต้องตั้ง {{$count_NN}} Visit" >
                                                            {{ number_format($sum_NN, 2) }}
                                                            <i class="fa-brands fa-btc text-secondary ms-2 me-2"></i>
                                                        </p> 
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-1 text-start mt-2 ms-4">
                                                        <i class="fa-brands fa-bitcoin align-middle text-danger"></i>
                                                    </div>
                                                    <div class="col-md-4 text-start mt-2">
                                                        <p class="text-muted mb-0" >
                                                            ตั้งลูกหนี้
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end mt-2 me-2">
                                                        <a href="{{url('account_203_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank"> 
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_YY}} Visit">
                                                                {{ number_format($sum_YY, 2) }}
                                                                <i class="fa-brands fa-btc text-danger ms-2 me-2"></i>
                                                            </p> 
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-1 text-start mt-2 ms-4">
                                                        <i class="fa-brands fa-bitcoin align-middle text-info"></i>
                                                    </div>
                                                    <div class="col-md-4 text-start mt-2">
                                                        <p class="text-muted mb-0">
                                                            ลูกหนี้ตามข้อตกลง
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end mt-2 me-2">  
                                                        <a href="{{url('account_203_hoscode_date/'.$startdate.'/'.$enddate)}}" target="_blank">
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="ตั้งลูกหนี้ {{$count_toklong_d}} Visit">
                                                                {{ number_format($sum_toklong_d, 2) }}
                                                                <i class="fa-brands fa-btc text-info ms-2 me-2"></i>
                                                            </p>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-1 text-start mt-2 ms-4">
                                                        <i class="fa-brands fa-bitcoin align-middle text-success"></i>
                                                    </div>
                                                    <div class="col-md-4 text-start text-success mt-2">
                                                        <p class="text-muted mb-0">
                                                            Statement
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end mt-2 me-2">  
                                                        <a href="{{url('account_203_stm/'.$startdate.'/'.$enddate)}}" target="_blank">  
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement 00 Visit">
                                                                {{-- {{ number_format($sum_stm, 2) }}  --}}
                                                                ยังไม่ได้เขียน
                                                                <i class="fa-brands fa-btc text-success ms-2 me-2"></i>
                                                            </p>    
                                                        </a>                               
                                                    </div>
                                                </div>
                                                

                                                <div class="row mb-4">
                                                    <div class="col-md-1 text-start mt-2 ms-4">
                                                        <i class="fa-brands fa-bitcoin align-middle text-primary"></i>
                                                    </div>
                                                    <div class="col-md-4 text-start mt-2">
                                                        <p class="text-muted mb-0">
                                                            ยกยอดไปเดือนนี้
                                                        </p>
                                                    </div>
                                                    <div class="col"></div>
                                                    <div class="col-md-5 text-end mt-2 me-2"> 
                                                        <a href="{{url('acc_107_debt_months/'.$item->months.'/'.$item->year)}}" target="_blank">          
                                                            <p class="text-end mb-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Statement 00 Visit">
                                                                {{-- {{ number_format($sum_yokpai, 2) }} --}}
                                                                ยังไม่ได้เขียน
                                                                <i class="fa-brands fa-btc text-success ms-2 me-2"></i>
                                                            </p>  
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

                    <div class="table-responsive">
                        
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center">ลูกหนี้ที่ต้องตั้ง</th> 
                                    <th class="text-center">ตั้งลูกหนี้</th> 
                                    <th class="text-center">Statement</th>
                                    <th class="text-center">ยกยอดไปเดือนนี้</th> 
                                </tr>
                            </thead>
                            {{-- <tbody>
                                <?php 
                                    $number = 0; 
                                    $total1 = 0;
                                    $total2 = 0;
                                    $total3 = 0;
                                    $total4 = 0;
                                    $total5 = 0;$total6 = 0;
                                ?>
                                @foreach ($data as $item)
                                    <?php $number++; ?> 
                                        <tr>
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td> 
                                            <td class="text-center" width="7%">{{ $item->vstdate }}</td>
                                            <td class="text-center" width="8%">{{ $item->vn }}</td> 
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>
                                            <td class="text-center" width="7%">{{ $item->cid }}</td>
                                            <td class="p-2">{{ $item->ptname }}</td>                                            
                                            <td class="text-center" width="5%">{{ $item->pttype }}</td>   
                                            <td class="text-end" style="color:rgb(243, 157, 27)" width="7%"> {{ $item->nhso_ownright_pid }}</td>                                         
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->income, 2) }}</td>  
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->rcpt_money, 2) }}</td> 
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->income - $item->rcpt_money, 2) }}</td>  
                                            <td class="text-end"  width="7%" style="color:#0A4F87"> {{ $item->debit_total }}</td>   
                                            <td class="text-end"  width="7%" style="color:#108A1A"> {{ $item->ct_price }}</td> 
                                            <td class="text-end"  width="7%" style="color:#E9540F"> {{ number_format(($item->income)-($item->rcpt_money)-($item->debit_total)-($item->ct_price),2) }}</td> 
                                            <td class="text-center" width="5%">{{ $item->hospcode }}</td>
                                        </tr>
                                    <?php
                                            $total1 = $total1 + $item->income;
                                            $total2 = $total2 + $item->rcpt_money;
                                            $total6 = $total6 + ($item->income - $item->rcpt_money);
                                            $total3 = $total3 + $item->debit_total;
                                            $total4 = $total4 + $item->ct_price;
                                            $total5 = $total5 + (($item->income)-($item->rcpt_money)-($item->debit_total)-($item->ct_price));
                                    ?>
                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="8" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-center" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                <td class="text-center" style="background-color: #FCA533" ><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                <td class="text-center" style="background-color: #b3109d"><label for="" style="color: #FFFFFF">{{ number_format($total6, 2) }}</label> </td>
                                <td class="text-center" style="background-color: #0A4F87"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td>
                                <td class="text-center" style="background-color: #108A1A"><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td>
                                <td class="text-center" style="background-color: #E9540F"><label for="" style="color: #FFFFFF">{{ number_format($total5, 2) }}</label></td>
                                <td colspan="1" class="text-end" style="background-color: #fca1a1"></td>
                            </tr>   --}}
                        </table>
                    </div>

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
