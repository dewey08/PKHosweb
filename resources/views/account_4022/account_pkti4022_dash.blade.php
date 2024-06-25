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
        <form action="{{ url('account_pkti4022_dash') }}" method="GET">             <form action="{{ route('acc.account_pkti4022_dash') }}" method="GET">
                @csrf
                <div class="row"> 
                    <div class="col"></div>
                    <div class="col-md-7">
                        <h4 class="card-title">Detail 1102050101.4022</h4>
                        <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.4022</p>
                    </div>
                    {{-- <div class="col"></div> --}}
                     
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
                        <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>   
                    </div> 
              
                    <div class="col"></div>
               
            </div>
            </form>  
       
            <div class="row">  
                <div class="col"></div> 
                @if ($startdate !='') 
                    <div class="col-xl-10 col-md-10">
                        <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">   
                            <div class="table-responsive p-3">                                
                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="background-color: rgb(219, 247, 232)">ลำดับ</th> 
                                            <th class="text-center" style="background-color: rgb(219, 247, 232)">เดือน</th> 
                                            <th class="text-center" style="background-color: rgb(219, 247, 232)">income</th> 
                                            {{-- <th class="text-center" style="background-color: rgb(135, 190, 253)">ต้องตั้ง-402</th>   --}}
                                            {{-- <th class="text-center" style="background-color: rgb(135, 190, 253)">ตั้งลูกหนี้-402</th>  --}}
                                            {{-- <th class="text-center" style="background-color: rgb(135, 190, 253)">Stm-402</th> --}}
                                            <th class="text-center" style="background-color: rgb(253, 135, 174)">ต้องตั้ง</th> 
                                            <th class="text-center" style="background-color: rgb(253, 135, 174)">ตั้งลูกหนี้</th> 
                                            <th class="text-center" style="background-color: rgb(253, 135, 174)">Stm</th>
                                            <th class="text-center" style="background-color: rgb(250, 225, 234)">ยกยอดไป</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $number = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0;
                                        ?>
                                        @foreach ($datashow as $item)
                                            <?php
                                                $number++;
                                                $y = $item->year;
                                                    $ynew = $y + 543;
                                                   
                                                 // ลูกหนี้ที่ต้องตั้ง 4022
                                                 $datas4022 = DB::select('
                                                    SELECT count(DISTINCT an) as Can
                                                        ,SUM(debit_total) as sumdebit
                                                        from acc_debtor
                                                        WHERE account_code="1102050101.4022"
                                                        AND stamp = "N" AND debit_total > 0
                                                        AND month(dchdate) = "'.$item->months.'"
                                                        AND year(dchdate) = "'.$item->year.'"
                                                ');
                                                foreach ($datas4022 as $key => $value22) {
                                                    $count_N4022  = $value22->Can;
                                                    $sum_N4022    = $value22->sumdebit;
                                                }
    
                                                // ตั้งลูกหนี้ IPD 4022
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                    from acc_1102050101_4022
                                                    where month(dchdate) = "'.$item->months.'"
                                                    AND year(dchdate) = "'.$item->year.'"; 
                                                    
                                                ');   
                                                foreach ($datasum_ as $key => $value5) {
                                                    $sum_fokliad    = $value5->debit_total;
                                                    $count_toklong = $value5->Cvit;
                                                }
                                                 

                                                 // STM 4022
                                                 $stm_4022 = DB::select(
                                                    'SELECT sum(U2.Total_amount) as Total_amount,count(DISTINCT U1.an) as Countvisit 
                                                        from acc_1102050101_4022 U1
                                                        LEFT JOIN acc_stm_ti_total U2 on U2.hn = U1.hn AND U2.vstdate = U1.rxdate
                                                        WHERE month(U1.dchdate) = "'.$item->months.'" AND year(U1.dchdate) = "'.$item->year.'" 
                                                        AND U2.Total_amount is not null AND U2.HDflag IN("CIC")
                                                      
                                                ');                                          
                                                foreach ($stm_4022 as $key => $value4) {
                                                    $sum_stm_moneyti  = $value4->Total_amount; 
                                                    $count_stmti      = $value4->Countvisit; 
                                                }
    
                                                
    
                                            ?>
                                    
                                                <tr>
                                                    <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>  
                                                    <td class="p-2">
                                                        {{-- <p style="font-size: 14px;"> {{$item->MONTH_NAME}}</p> --}}
                                                        {{$item->MONTH_NAME}} {{$ynew}}
                                                    </td>    
                                                    <td class="text-end" style="color:rgb(3, 62, 129)" width="10%"> {{ number_format($item->income, 2) }}</td>                                      
                                                    {{-- <td class="text-end" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="10%"> {{ number_format($sum_N, 2) }}</td>                                                     --}}
                                                    {{-- <td class="text-end" style="color:rgb(231, 73, 139);background-color: rgb(203, 227, 255)" width="10%"> 
                                                        <a href="{{url('account_402_detail/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(231, 73, 139);"> {{ number_format($total_sumY, 2) }}</a>
                                                    </td>  --}}
                                                    {{-- <td class="text-end" style="color:rgb(2, 116, 63);background-color: rgb(203, 227, 255)" width="10%"> 
                                                         <a href="{{url('account_402_stm/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(2, 116, 63);"> {{ number_format($sum_stm_money, 2) }}</a> 
                                                    </td>  --}}
                                                    {{-- account_pkti4022_pull --}}
                                                    <td class="text-end" style="color:rgb(45, 57, 230);background-color: rgb(255, 174, 201)" width="10%"> 
                                                      <a href="{{url('account_pkti4022_pull')}}" target="_blank" style="color:rgb(21, 85, 223);"> {{ number_format($sum_N4022, 2) }}</a>
                                                    </td> 
                                                    <td class="text-end" width="10%" style="background-color: rgb(255, 174, 201)">  
                                                        <a href="{{url('account_pkti4022_detail/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(199, 42, 3);"> {{ number_format($sum_fokliad, 2) }}</a>
                                                    </td>                                               
                                                    <td class="text-end" style="color:rgb(5, 114, 96);background-color: rgb(255, 174, 201)" width="10%">
                                                        <a href="{{url('account_pkti4022_stm/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(5, 119, 90);">{{ number_format($sum_stm_moneyti, 2) }}</a>
                                                    </td> 
                                                    <td class="text-end" style="color:rgb(224, 128, 17)" width="10%">0.00</td> 
                                                </tr>
                                            <?php
                                                    $total1 = $total1 + $item->income; 
                                                    // $total2 = $total2 + $sum_N;
                                                   
                                                    // $total3 = $total3 + $total_sumY; 
                                                    // $total4 = $total4 + $sum_stm_money; 
                                                    $total7 = $total7 + $sum_N4022; 
                                                    $total5 = $total5 + $sum_fokliad;
                                                    $total6 = $total6 + $sum_stm_moneyti; 
                                                    // $total4 = $total4 + $sum_fokliad; 
                                            ?> 
                                        @endforeach
    
                                    </tbody>
                                    <tr style="background-color: #f3fca1">
                                        <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                        <td class="text-end" style="background-color: #055fb4"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                        {{-- <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td> --}}
                                        {{-- <td class="text-end" style="background-color: #fc5089"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td> --}}
                                        {{-- <td class="text-end" style="background-color: #149966" ><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td>  --}}
                                        <td class="text-end" style="background-color: #2e41e9" ><label for="" style="color: #FFFFFF">{{ number_format($total7, 2) }}</label></td> 
                                        <td class="text-end" style="background-color: #c5224b"><label for="" style="color: #FFFFFF">{{ number_format($total5, 2) }}</label></td>
                                        <td class="text-end" style="background-color: #0ea080"><label for="" style="color: #FFFFFF">{{ number_format($total6, 2) }}</label></td> 
                                        <td class="text-end" style="background-color: #f89625"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                     
                                    </tr>  
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                 
                @endif
                <div class="col"></div>
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
