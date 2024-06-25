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
 
            <form action="{{ route('acc.account_502_dash') }}" method="GET">
                @csrf
                <div class="row"> 
                    <div class="col"></div>
                    <div class="col-md-7">
                        <h4 class="card-title">Detail 1102050101.502</h4>
                        <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.502</p>
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
                                            <th class="text-center" style="background-color: rgb(135, 190, 253)">ลูกหนี้ต้องตั้ง</th>  
                                            <th class="text-center" style="background-color: rgb(135, 190, 253)">ตั้งลูกหนี้</th> 
                                            <th class="text-center" style="background-color: rgb(135, 190, 253)">Stm</th> 
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
                                                // ลูกหนี้ที่ต้องตั้ง 502
                                                $datas = DB::select('
                                                    SELECT count(DISTINCT an) as Can
                                                        ,SUM(debit_total) as sumdebit
                                                        from acc_debtor
                                                        WHERE account_code="1102050101.502"
                                                        AND stamp = "N" AND debit_total > 0
                                                        AND month(dchdate) = "'.$item->months.'"
                                                        AND year(dchdate) = "'.$item->year.'"
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_N = $value->Can;
                                                    $sum_N = $value->sumdebit;
                                                }
                                                // ตั้งลูกหนี้ IPD 502
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT an) as Cvit
                                                    from acc_1102050101_502
                                                    where month(dchdate) = "'.$item->months.'"
                                                    AND year(dchdate) = "'.$item->year.'"
                                                
                                                ');   
                                                foreach ($datasum_ as $key => $value2) {
                                                    $total_sumY = $value2->debit_total;
                                                    $total_countY = $value2->Cvit;
                                                } 
 
                                                // STM 502
                                                $stm_ = DB::select(
                                                    'SELECT sum(stm_money) as stm_money,count(DISTINCT an) as Countvisit FROM acc_1102050101_502 
                                                    WHERE month(dchdate) = "'.$item->months.'" AND year(dchdate) = "'.$item->year.'" AND (stm_money IS NOT NULL OR stm_money <> "")
                                                ');                                           
                                                foreach ($stm_ as $key => $value3) {
                                                    $sum_stm_money  = $value3->stm_money; 
                                                    $count_stm      = $value3->Countvisit; 
                                                }
  
                                            ?>
                                    
                                                <tr>
                                                    <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>  
                                                    <td class="p-2">
                                                        {{-- <p style="font-size: 14px;"> {{$item->MONTH_NAME}}</p> --}}
                                                        {{$item->MONTH_NAME}} {{$ynew}}
                                                    </td>    
                                                    <td class="text-end" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($item->income, 2) }}</td>                                      
                                                    <td class="text-end" style="color:rgb(6, 82, 170);background-color: rgb(203, 227, 255)" width="10%">
                                                        <a href="{{url('account_502_pull')}}" target="_blank" style="color:rgb(5, 58, 173);"> {{ number_format($sum_N, 2) }}</a>
                                                    </td>                                                    
                                                    <td class="text-end" style="color:rgb(231, 73, 139);background-color: rgb(203, 227, 255)" width="10%"> 
                                                        <a href="{{url('account_502_detail/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(231, 73, 139);"> {{ number_format($total_sumY, 2) }}</a> 
                                                    </td> 
                                                    <td class="text-end" style="color:rgb(2, 116, 63);background-color: rgb(203, 227, 255)" width="10%"> 
                                                        {{ number_format($sum_stm_money, 2) }}
                                                         {{-- <a href="{{url('account_502_stm/'.$item->months.'/'.$item->year)}}" target="_blank" style="color:rgb(2, 116, 63);"> {{ number_format($sum_stm_money, 2) }}</a>  --}}
                                                    </td> 
                                                   
                                                    <td class="text-end" style="color:rgb(224, 128, 17)" width="10%">0.00</td> 
                                                </tr>
                                            <?php
                                                    $total1 = $total1 + $item->income; 
                                                    $total2 = $total2 + $sum_N;
                                                   
                                                    $total3 = $total3 + $total_sumY; 
                                                    $total4 = $total4 + $sum_stm_money; 
                                                
                                            ?> 
                                        @endforeach
    
                                    </tbody>
                                    <tr style="background-color: #f3fca1">
                                        <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                        <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                        <td class="text-end" style="background-color: #033a6d"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                        <td class="text-end" style="background-color: #fc5089"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td>
                                        <td class="text-end" style="background-color: #149966" ><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td> 
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
            $('#year').select2({
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
