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
                    <div class="col"></div>
                    <div class="col-md-3">
                        <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.203</h4>
                        <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.203</p>
                    </div>
                
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
                        </div>
                    </div>
                    <div class="col"></div>
              
            </div>
        </form>  
        <div class="row">   
            @if ($startdate =='') 
                <div class="col"></div>
                <div class="col-xl-8 col-md-8">
                    <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">   
                        <div class="table-responsive p-3">                                
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th> 
                                        <th class="text-center">เดือน</th> 
                                        <th class="text-center">ลูกหนี้ที่ต้องตั้ง</th> 
                                        <th class="text-center">ตั้งลูกหนี้</th> 
                                        <th class="text-center">ลูกหนี้ตามข้อตกลง+CT</th> 
                                        <th class="text-center">Statement</th>
                                        <th class="text-center">ยกยอดไปเดือนนี้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $number = 0; 
                                        $total1 = 0;
                                        $total2 = 0;
                                        $total3 = 0;
                                        $total4 = 0;
                                        $total5 = 0;$total6 = 0;
                                    ?>
                                    @foreach ($datashow as $item)
                                        <?php
                                            $number++;
                                            $y = $item->year;
                                                $ynew = $y + 543;
                                            // ลูกหนี้ทั้งหมด
                                            $datas = DB::select('
                                                SELECT count(DISTINCT vn) as Can
                                                    ,SUM(debit_total) as sumdebit
                                                    from acc_debtor
                                                    WHERE account_code="1102050101.203"
                                                    AND stamp = "N" AND debit_total > 0
                                                    AND month(vstdate) = "'.$item->months.'"
                                                    AND year(vstdate) = "'.$item->year.'"; 
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้ OPD
                                            $datasum_ = DB::select('
                                                SELECT sum(income)-sum(rcpt_money) as debit_total,count(DISTINCT vn) as Cvit
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
                                
                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>  
                                                <td class="p-2">{{$item->MONTH_NAME}} {{$ynew}}</td>                                         
                                                <td class="text-end" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($sum_N, 2) }}</td>  
                                                <td class="text-end" width="10%">  <a href="{{url('account_203_detail/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(186, 75, 250)"> {{ number_format($sum_Y, 2) }}</a></td> 
                                                <td class="text-end" width="10%"><a href="{{url('account_203_hoscode/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(238, 36, 86)">{{ number_format($sum_toklong, 2) }}</a></td> 
                                                <td class="text-end" style="color:rgb(4, 161, 135)" width="10%">0.00</td> 
                                                <td class="text-end" style="color:rgb(224, 128, 17)" width="10%">0.00</td> 
                                            </tr>
                                        <?php
                                                $total1 = $total1 + $sum_N;
                                                $total2 = $total2 + $sum_Y; 
                                                $total3 = $total3 + $sum_toklong;
                                                // $total4 = $total4 + $item->ct_price;
                                                // $total5 = $total5 + (($item->income)-($item->rcpt_money)-($item->debit_total)-($item->ct_price));
                                        ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #9f4efc" ><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td> 
                                    <td class="text-end" style="background-color: #c5224b"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #0ea080"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                    <td class="text-end" style="background-color: #f89625"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                    {{-- <td class="text-center" style="background-color: #0A4F87"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td> --}}
                                    {{-- <td class="text-center" style="background-color: #108A1A"><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td>  --}}
                                    {{-- <td colspan="1" class="text-end" style="background-color: #fca1a1"></td> --}}
                                </tr>  
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            @else
                <div class="col"></div>
                <div class="col-xl-8 col-md-8">
                    <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">   
                        <div class="table-responsive p-3">                                
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th> 
                                        <th class="text-center">เดือน</th> 
                                        <th class="text-center">ลูกหนี้ที่ต้องตั้ง</th> 
                                        <th class="text-center">ตั้งลูกหนี้</th> 
                                        <th class="text-center">ลูกหนี้ตามข้อตกลง+CT</th> 
                                        <th class="text-center">Statement</th>
                                        <th class="text-center">ยกยอดไปเดือนนี้</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $number = 0; 
                                        $total1 = 0;
                                        $total2 = 0;
                                        $total3 = 0;
                                        $total4 = 0;
                                        $total5 = 0;$total6 = 0;
                                    ?>
                                    @foreach ($datashow as $item)
                                        <?php
                                            $number++;
                                            $y = $item->year;
                                                $ynew = $y + 543;
                                            // ลูกหนี้ทั้งหมด
                                            $datas = DB::select('
                                                SELECT count(DISTINCT vn) as Can
                                                    ,SUM(debit_total) as sumdebit
                                                    from acc_debtor
                                                    WHERE account_code="1102050101.203"
                                                    AND stamp = "N" AND debit_total > 0
                                                    AND vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"; 
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N = $value->Can;
                                                $sum_N = $value->sumdebit;
                                            }
                                            // ตั้งลูกหนี้ OPD
                                            $datasum_ = DB::select('
                                                SELECT sum(income)-sum(rcpt_money) as debit_total,count(DISTINCT vn) as Cvit
                                                from acc_1102050101_203
                                                where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
                                            
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
                                                where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"  
                                                
                                            ');   
                                            foreach ($datasum_ as $key => $value5) {
                                                $sum_toklong = $value5->debit_total+$value5->debit_ct_price;
                                                $count_toklong = $value5->Cvit;
                                            }
                                            
                                            // STM
                                            $sumapprove_ = DB::select('
                                                    SELECT sum(recieve_true) as recieve_true,count(vn) as Countvisit
                                                        from acc_1102050101_203
                                                        where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'"
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
                                                        where vstdate BETWEEN "'.$startdate.'" AND "'.$enddate.'" 
                                                        AND recieve_true IS NULL
                                            ');                                           
                                            foreach ($yokpai_ as $key => $valpai) {
                                                $sum_yokpai = $valpai->debit_total; 
                                                $count_yokpai = $valpai->Countvi; 
                                            }

                                        ?>
                                
                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>  
                                                <td class="p-2">{{$item->MONTH_NAME}} {{$ynew}}</td>                                         
                                                <td class="text-end" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($sum_N, 2) }}</td>  
                                                <td class="text-end" width="10%">  <a href="{{url('account_203_detail_date/'.$startdate.'/'.$enddate)}}" target="_blank" style="color:rgb(186, 75, 250)"> {{ number_format($sum_Y, 2) }}</a></td> 
                                                <td class="text-end" width="10%"><a href="{{url('account_203_hoscode/'.$startdate.'/'.$enddate)}}" target="_blank" style="color:rgb(238, 36, 86)">{{ number_format($sum_toklong, 2) }}</a></td> 
                                                <td class="text-end" style="color:rgb(4, 161, 135)" width="10%">0.00</td> 
                                                <td class="text-end" style="color:rgb(224, 128, 17)" width="10%">0.00</td> 
                                            </tr>
                                        <?php
                                                $total1 = $total1 + $sum_N;
                                                $total2 = $total2 + $sum_Y; 
                                                $total3 = $total3 + $sum_toklong;
                                                // $total4 = $total4 + $item->ct_price;
                                                // $total5 = $total5 + (($item->income)-($item->rcpt_money)-($item->debit_total)-($item->ct_price));
                                        ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #9f4efc" ><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td> 
                                    <td class="text-end" style="background-color: #c5224b"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #0ea080"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                    <td class="text-end" style="background-color: #f89625"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                    {{-- <td class="text-center" style="background-color: #0A4F87"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td> --}}
                                    {{-- <td class="text-center" style="background-color: #108A1A"><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td>  --}}
                                    {{-- <td colspan="1" class="text-end" style="background-color: #fca1a1"></td> --}}
                                </tr>  
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
            @endif
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
