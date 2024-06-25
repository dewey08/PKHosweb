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
        <form action="{{ url('account_301_dash') }}" method="GET">
            @csrf
            <div class="row mt-2"> 
               
                <div class="col-md-6 text-start">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail SSS OPD</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูลประกันสังคม ผู้ป่วยนอก</p>
                </div>
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-3 text-center ">
                    <select name="acc_trimart_id" id="acc_trimart_id" class="form-control inputacc">
                        <option value="">--เลือก--</option>
                        @foreach ($trimart as $item) 
                            <option value="{{$item->acc_trimart_id}}">{{$item->acc_trimart_name}}( {{$item->acc_trimart_start_date}} ถึง {{$item->acc_trimart_end_date}})</option>
                        @endforeach
                    </select> 
                </div>
                <div class="col-md-1 text-start">
                    <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary inputacc" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button>  
                </div>
                
            </div>
        </form>  
      
        <div class="row">  
            {{-- <div class="col"></div>  --}}
            {{-- @if ($startdate !='')  --}}
                <div class="col-xl-12 col-md-12">
                    <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">   
                        <div class="table-responsive p-3">                                
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        {{-- <th class="text-center">ลำดับ</th> 
                                        <th class="text-center">ไตรมาส</th> 
                                        <th class="text-center">ลูกหนี้ที่ต้องตั้ง</th> 
                                        <th class="text-center">income</th>
                                        <th class="text-center">ลูกหนี้-301</th>  
                                        <th class="text-center">ลูกหนี้-3011</th> 
                                        <th class="text-center">ลูกหนี้-3013</th> 
                                        <th class="text-center">Statement</th>
                                        <th class="text-center">ยกยอดไป</th>  --}}

                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">ลำดับ</th> 
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">ไตรมาส</th> 
                                        <th class="text-center" style="background-color: rgb(219, 247, 232)">income</th> 
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ต้องตั้ง-301</th>  
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">ตั้งลูกหนี้-301</th> 
                                        <th class="text-center" style="background-color: rgb(135, 190, 253)">Stm-301</th>
                                        <th class="text-center" style="background-color: rgb(253, 135, 174)">ต้องตั้ง-3011</th> 
                                        <th class="text-center" style="background-color: rgb(253, 135, 174)">ตั้งลูกหนี้-3011</th> 
                                        <th class="text-center" style="background-color: rgb(253, 135, 174)">Stm-3011</th>
                                        <th class="text-center" style="background-color: rgb(250, 246, 198)">ต้องตั้ง-3013</th> 
                                        <th class="text-center" style="background-color: rgb(250, 246, 198)">ตั้งลูกหนี้-3013</th> 
                                        <th class="text-center" style="background-color: rgb(250, 246, 198)">Stm-3013</th>
                                        <th class="text-center" style="background-color: rgb(250, 225, 234)">ยกยอดไป</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $number = 0; $total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0;$total6 = 0;$total7 = 0;$total8 = 0;$total9 = 0;$total10 = 0;$total11 = 0;
                                    ?>
                                    @foreach ($datashow as $item)
                                        <?php
                                                $number++;
                                                // $y = $item->year;
                                                $y = date('Y') + 543;
                                                $ynew = $y + 543;

                                                // ลูกหนี้ทั้งหมด
                                                $datasincome = DB::select('
                                                    SELECT count(DISTINCT vn) as Can
                                                        ,SUM(income) as sumdebit_income
                                                        from acc_debtor
                                                        WHERE account_code="1102050101.301" 
                                                        AND vstdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                                ');
                                                foreach ($datasincome as $key => $value_in) {
                                                    $count_income  = $value_in->Can;
                                                    $sum_income    = $value_in->sumdebit_income;
                                                }
                                           
                                                // ลูกหนี้ต้องตั้ง N 301
                                                $datas = DB::select('
                                                    SELECT count(DISTINCT vn) as Can
                                                        ,SUM(debit_total) as sumdebit
                                                        from acc_debtor
                                                        WHERE account_code="1102050101.301"
                                                        AND stamp = "N"
                                                        AND vstdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                                ');
                                                foreach ($datas as $key => $value) {
                                                    $count_tongtung  = $value->Can;
                                                    $sum_tongtung    = $value->sumdebit;
                                                }
                                            
                                                // ตั้งลูกหนี้ 301
                                                $datasum_ = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                                    from acc_1102050101_301
                                                    where vstdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                                ');   
                                                foreach ($datasum_ as $key => $value2) {
                                                    $sum_Y      = $value2->debit_total; 
                                                    $count_Y    = $value2->Cvit;
                                                }
                                                $total_sumY   = $sum_Y ;
                                                $total_countY = $count_Y; 

                                                 //STM 301
                                                 $stm_ = DB::select(
                                                    'SELECT 
                                                        SUM(ar.acc_stm_repmoney_price301) as total                                                   
                                                        FROM acc_stm_repmoney ar 
                                                        LEFT JOIN acc_trimart a ON a.acc_trimart_id = ar.acc_trimart_id 
                                                        WHERE ar.acc_trimart_id = "'.$item->acc_trimart_id.'"  
                                                ');                                           
                                                foreach ($stm_ as $key => $value3) {
                                                    $total301 = $value3->total; 
                                                }

                                                // *********** 3011 *****************
                                                // ลูกหนี้ต้องตั้ง N 3011
                                                $datas3011 = DB::select('
                                                    SELECT count(DISTINCT vn) as Can
                                                        ,SUM(debit_total) as sumdebit
                                                        from acc_debtor
                                                        WHERE account_code="1102050101.3011"
                                                        AND stamp = "N"
                                                        AND vstdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                                ');
                                                foreach ($datas3011 as $key => $value_3011) {
                                                    $count_tongtung3011  = $value_3011->Can;
                                                    $sum_tongtung3011    = $value_3011->sumdebit;
                                                }

                                                // ตั้งลูกหนี้ OPD 3011
                                                $datasum_3011 = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvits
                                                    from acc_1102050101_3011
                                                    where vstdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'" 
                                                ');   
                                                foreach ($datasum_3011 as $key => $value5) {
                                                    $sum_ins_sss   = $value5->debit_total;
                                                    $count_vn_sss  = $value5->Cvits;
                                                }


                                                // *********** 3013 *****************
                                                // ลูกหนี้ต้องตั้ง N 3013
                                                $datas3013 = DB::select('
                                                    SELECT count(DISTINCT vn) as Can
                                                        ,SUM(debit_total) as sumdebit
                                                        from acc_debtor
                                                        WHERE account_code="1102050101.3013"
                                                        AND stamp = "N"
                                                        AND vstdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'"
                                                ');
                                                foreach ($datas3013 as $key => $value_3013) {
                                                    $count_tongtung3013  = $value_3013->Can;
                                                    $sum_tongtung3013    = $value_3013->sumdebit;
                                                }
                                                 // ตั้งลูกหนี้ OPD 3013
                                                 $datasum_3013 = DB::select('
                                                    SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvits
                                                    from acc_1102050101_3013
                                                    where vstdate between "'.$item->acc_trimart_start_date.'" and "'.$item->acc_trimart_end_date.'" 
                                                ');   
                                                foreach ($datasum_3013 as $key => $value6) {
                                                    $sum_ct_sss      = $value6->debit_total;
                                                    $count_vnct_sss  = $value6->Cvits;
                                                }
                                             
                                               
                                                if ( $sum_Y > $total301) {
                                                    $yokpai = $sum_Y - $total301;
                                                } else {
                                                    $yokpai = $total301 - $sum_Y;
                                                }
 
                                        ?>
                               
                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td>  
                                                <td class="p-2">{{$item->acc_trimart_name}} {{$y}}</td> 
                                                <td class="text-end" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($sum_income, 2) }}</td>                                          
                                                <td class="text-end" style="color:rgb(73, 147, 231);background-color: rgb(193, 222, 255)" width="10%"> 
                                                   <a href="{{url('account_301_pull')}}" target="_blank" style="color:rgb(80, 7, 129);"> {{ number_format($sum_tongtung, 2) }}</a>
                                                </td>  
                                                <td class="text-end" width="5%" style="background-color: rgb(193, 222, 255)">
                                                    <a href="{{url('account_301_income/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(186, 75, 250)"> {{ number_format($sum_Y, 2) }}</a>
                                                </td> 
                                                <td class="text-end" width="5%" style="background-color: rgb(193, 222, 255)">
                                                    <a href="{{url('account_301_dashsub/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(7, 143, 143)"> {{ number_format($total301, 2) }}</a>
                                                </td> 
                                                <td class="text-end" width="5%" style="background-color: rgb(253, 208, 231)">
                                                    <a href="{{url('account_301_dashsub/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(115, 7, 119)"> {{ number_format($sum_tongtung3011, 2) }}</a>
                                                </td>                                                
                                                <td class="text-end" width="5%" style="background-color: rgb(253, 208, 231)">
                                                    <a href="{{url('account_301_ins/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(233, 19, 101)"> {{ number_format($sum_ins_sss, 2) }}</a>
                                                </td> 
                                                <td class="text-end" style="color:rgb(4, 161, 135);background-color: rgb(253, 208, 231)" width="5%">
                                                    {{-- {{ number_format($total301, 2) }} --}}
                                                    0.00000000
                                                 </td> 
                                                <td class="text-end" width="5%" style="background-color: rgb(253, 246, 223)">
                                                    <a href="{{url('account_3013_pull')}}" target="_blank" style="color:rgb(13, 67, 138)"> {{ number_format($sum_tongtung3013, 2) }}</a>
                                                </td>                                                 
                                                <td class="text-end" style="color:rgb(84, 4, 131);background-color: rgb(253, 246, 223)" width="5%">
                                                    <a href="{{url('account_3013_detail/'.$item->acc_trimart_start_date.'/'.$item->acc_trimart_end_date)}}" target="_blank" style="color:rgb(84, 4, 131)"> {{ number_format($sum_ct_sss, 2) }}</a>
                                                 
                                                </td> 
                                                <td class="text-end" style="color:rgb(6, 155, 142);background-color: rgb(253, 246, 223)" width="5%">
                                                    0.00000000
                                                </td> 
                                                <td class="text-end" style="color:rgb(230, 128, 12)" width="5%">
                                                    0.00000000
                                                </td> 
                                            </tr>
                                        <?php
                                                $total1 = $total1 + $sum_income; 
                                                $total2 = $total2 + $sum_tongtung;                                                
                                                $total3 = $total3 + $sum_Y; 
                                                $total4 = $total4 + $total301; 
                                                $total5 = $total5 + $sum_tongtung3011; 
                                                $total6 = $total6 + $sum_ins_sss; 
                                                // $total2 = $total2 + $sum_Y;                                                
                                                $total8 = $total8 + $sum_tongtung3013; 
                                                $total9 = $total4 + $sum_ct_sss; 
                                                // $total10 = $total10 + $total301; 
                                                // $total11 = $total11 + $total301; 
                                        ?>
                                    @endforeach

                                </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #6842f1"><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td> 
                                    <td class="text-end" style="background-color: #9f4efc" ><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td>                                   
                                    <td class="text-end" style="background-color: #10aaa2"><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #990aac"><label for="" style="color: #FFFFFF">{{ number_format($total5, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #f02584"><label for="" style="color: #FFFFFF">{{ number_format($total6, 2) }}</label></td> 
                                    <td class="text-end" style="background-color: #07ac7a"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                    <td class="text-end" style="background-color: #073bac"><label for="" style="color: #FFFFFF">{{ number_format($total8, 2) }}</label></td> 
                                    <td class="text-end" style="background-color: #5407ac"><label for="" style="color: #FFFFFF">{{ number_format($total9, 2) }}</label></td> 
                                    <td class="text-end" style="background-color: #07ac7a"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                    <td class="text-end" style="background-color: #fc6b17"><label for="" style="color: #FFFFFF">0.00</label></td> 
                                 
                                </tr>  
                            </table>
                        </div>
                    </div>
                </div>
            {{-- @else  --}}
            {{-- @endif --}}
            {{-- <div class="col"></div> --}}
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
