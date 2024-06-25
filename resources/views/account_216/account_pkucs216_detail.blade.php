@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
@section('content')
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
            border: 10px #ddd solid;
            border-top: 10px #ff8897 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
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

    $strDate = date('Y-m-d');
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    // // $strDay= date("j",strtotime($strDate));

    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    // // return $strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear;
    $monthyear = $strMonthThai.'  พ.ศ. '.$strYear;
    // return $monthyear;
    // return $strMonthThai.'  พ.ศ. '.$strYear;
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
        <div class="container-fluid">
           
                    <!-- start page title -->
                    <div class="row"> 
                            <div class="col-md-6">
                                <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail 1102050101.216</h4>
                                <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.216 เดือน {{$monthyear}}</p>
                            </div>
                            <div class="col"></div>
                           
                    </div> 
        </div> <!-- container-fluid -->

        <div class="row"> 
            <div class="col-xl-7 col-md-7">
                <div class="card card_audit_4c" style="background-color: rgb(246, 235, 247)">   
                    <div class="table-responsive p-3">                                
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr> 
                                    <th class="text-center">เดือน</th> 
                                    <th class="text-center">ลูกหนี้ที่ต้องตั้ง</th> 
                                    <th class="text-center">ตั้งลูกหนี้</th>  
                                    {{-- <th class="text-center">ลูกหนี้ Walkin</th>  --}}
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
                                                WHERE account_code="1102050101.216"
                                                AND stamp = "N" AND debit_total > 0
                                                AND month(vstdate) = "'.$months.'" AND year(vstdate) ="'.$year.'"
                                        ');
                                        foreach ($datas as $key => $value) {
                                            $count_N = $value->Can;
                                            $sum_N = $value->sumdebit;
                                        }
                                        // ตั้งลูกหนี้ OPD
                                        $datasum_ = DB::select('
                                            SELECT sum(debit_total) as debit_total,count(DISTINCT vn) as Cvit
                                            from acc_1102050101_216
                                            where month(vstdate) = "'.$months.'" AND year(vstdate) ="'.$year.'"
                                        
                                        ');   
                                        foreach ($datasum_ as $key => $value2) {
                                            $sum_Y = $value2->debit_total;
                                            $count_Y = $value2->Cvit;
                                        }

                                        $total_sumY   = $sum_Y ;
                                        $total_countY = $count_Y;

                                        // ตั้งลูกหนี้ OPD ตามข้อตกลง
                                        $datasum_ = DB::select('
                                            SELECT sum(debit_total) as debit_total,sum(debit_walkin) as debit_walkin,count(DISTINCT vn) as Cvit
                                            from acc_1102050101_216
                                            where month(vstdate) = "'.$months.'" AND year(vstdate) ="'.$year.'"
                                            
                                        ');   
                                        foreach ($datasum_ as $key => $value5) {
                                            $sum_toklong            = $value5->debit_total;
                                            $count_toklong           = $value5->Cvit;
                                            $sum_debit_walkin        = $value5->debit_walkin;
                                        }
                                        
                                        // STM
                                        $sumapprove_ = DB::select('
                                                SELECT sum(stm_money) as stm_money,count(vn) as Countvisit
                                                    from acc_1102050101_216
                                                    where month(vstdate) = "'.$months.'" AND year(vstdate) ="'.$year.'"
                                                    AND (stm_money IS NOT NULL OR stm_money <> "")
                                        ');                                           
                                        foreach ($sumapprove_ as $key => $value3) {
                                            $sum_stm_money = $value3->stm_money; 
                                            $count_stm     = $value3->Countvisit; 
                                        } 
                                        // ยกไป
                                        $yokpai_ = DB::select('
                                                SELECT sum(debit_total) as debit_total,count(vn) as Countvi
                                                    from acc_1102050101_216
                                                    where month(vstdate) = "'.$months.'" AND year(vstdate) ="'.$year.'"
                                                    AND (stm_money IS NULL OR stm_money = "")
                                        ');                                           
                                        foreach ($yokpai_ as $key => $valpai) {
                                            $sum_yokpai = $valpai->debit_total; 
                                            $count_yokpai = $valpai->Countvi; 
                                        } 
                                    ?>
                            
                                        <tr> 
                                            <td class="p-2">{{$item->MONTH_NAME}} {{$ynew}}</td>                                         
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="10%"> {{ number_format($sum_N, 2) }}</td>  
                                            <td class="text-end" width="10%" style="color:rgb(186, 75, 250)"> {{ number_format($sum_Y, 2) }}</td>  
                                            {{-- <td class="text-end" width="10%" style="color:rgb(253, 60, 47)">{{ number_format($sum_debit_walkin, 2) }}</td>  --}}
                                            <td class="text-end" style="color:rgb(4, 161, 135)" width="10%">{{ number_format($sum_stm_money, 2) }}</td> 
                                            <td class="text-end" style="color:rgb(224, 128, 17)" width="10%">0.00</td> 
                                        </tr>
                                    <?php
                                            $total1 = $total1 + $sum_N;
                                            $total2 = $total2 + $sum_Y; 
                                            $total3 = $total3 + $sum_debit_walkin; 
                                            $total4 = $total4 + $sum_stm_money; 
                                    ?>
                                @endforeach

                            </tbody>
                                <tr style="background-color: #f3fca1">
                                    <td colspan="1" class="text-end" style="background-color: #fca1a1"></td>
                                    <td class="text-end" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #9f4efc" ><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td> 
                                    {{-- <td class="text-end" style="background-color: #c5224b"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label></td> --}}
                                    <td class="text-end" style="background-color: #0ea080"><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label></td>
                                    <td class="text-end" style="background-color: #f89625"><label for="" style="color: #FFFFFF">0.00</label></td>  
                                
                                </tr>  
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-5 col-md-5">
                <div class="card card_audit_4c" style="background-color: rgb(235, 242, 247)">   
                    <div class="table-responsive p-3">                                
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center">HCODE</th>  
                                    <th class="text-center">ลูกหนี้กรณีส่งต่อ</th> 
                                    <th class="text-center">ลูกหนี้CT</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $number = 1; 
                                    $total11 = 0;
                                    $total22 = 0;
                                    $total33 = 0;
                                    $total44 = 0;
                                    $total55 = 0;$total66 = 0;
                                ?>
                                @foreach ($data_hospcode as $item_h)  
                                    <?php
                                            $y = $item_h->years;
                                                $ynew = $y + 543;
                                            // ลูกหนี้กรณีส่งต่อ
                                            $datas = DB::select(
                                                'SELECT count(DISTINCT vn) as Can,SUM(debit_total) as sumdebit
                                                    FROM acc_1102050101_203
                                                    WHERE month(vstdate) = "'.$months.'" AND year(vstdate) ="'.$year.'"
                                                    AND hospcode = "'.$item_h->hospcode.'" 
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_N     = $value->Can;
                                                $sum_toklong = $value->sumdebit;
                                            }
                                            // ลูกหนี้กรณี CT
                                            $datas = DB::select(
                                                'SELECT count(DISTINCT vn) as Canct,SUM(ct_price) as sumctdebit
                                                    FROM acc_1102050101_203
                                                    WHERE month(vstdate) = "'.$months.'" AND year(vstdate) ="'.$year.'"
                                                    AND hospcode = "'.$item_h->hospcode.'" 
                                            ');
                                            foreach ($datas as $key => $value) {
                                                $count_ct     = $value->Canct;
                                                $sum_ct       = $value->sumctdebit;
                                            }
                                    ?>                                
                                        <tr>
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number++ }} </td>  
                                            <td class="p-2">{{$item_h->hname}}</td>       
                                            <td class="text-end" width="20%" style="color:rgb(238, 36, 86)">{{ number_format($sum_toklong, 2) }}</td> 
                                            <td class="text-end" width="15%" style="color:rgb(237, 100, 255)">{{ number_format($sum_ct, 2) }}</td>  
                                        </tr>
                                        <?php 
                                                $total11 = $total11 + $sum_toklong;
                                                $total22 = $total22 + $sum_ct; 
                                            ?>
                                    
                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                <td class="text-center" style="background-color: #f82c25"><label for="" style="color: #FFFFFF">{{ number_format($total11, 2) }}</label></td>
                                <td class="text-center" style="background-color: #ed4efc" ><label for="" style="color: #FFFFFF">{{ number_format($total22, 2) }}</label></td> 
                            </tr> 
                               
                        </table>
                    </div>
                </div>
            </div> --}}
        </div> 
    
        <div class="row">
            <div class="col-xl-12">
                    <div class="card card_audit_4c">                   
                        <div class="card-body">                     
                            <div class="table-responsive">
                                
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ลำดับ</th> 
                                            <th class="text-center">vstdate</th>  
                                            <th class="text-center">hn</th>
                                            <th class="text-center">cid</th>
                                            <th class="text-center">ptname</th>                                       
                                            <th class="text-center">pttype</th>   
                                            <th class="text-center">income</th>
                                            <th class="text-center">ชำระเงินเอง</th> 
                                            <th class="text-center">ตั้งลูกหนี้</th> 
                                            {{-- <th class="text-center">Walkin</th>  --}}
                                            <th class="text-center">ส่วนต่าง</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $number = 0; 
                                        $total111 = 0;
                                        $total222 = 0;
                                        $total333 = 0;
                                        $total444 = 0;
                                        $total555 = 0; $total666 = 0;
                                    ?>
                                        @foreach ($data as $item)
                                        <?php $number++; ?> 
                                            <tr>
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }} </td> 
                                                <td class="text-center" width="7%">{{ $item->vstdate }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>
                                                <td class="text-center" width="7%">{{ $item->cid }}</td>
                                                <td class="p-2">{{ $item->ptname }}</td>                                            
                                                <td class="text-center" width="5%">{{ $item->pttype }}</td>                                      
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->income, 2) }}</td>  
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="7%"> {{ number_format($item->rcpt_money, 2) }}</td> 
                                                <td class="text-center" style="color:rgb(207, 28, 37)" width="7%"> {{ number_format($item->debit_total, 2) }}</td> 
                                                {{-- <td class="text-center"  width="7%" style="color:#108A1A"> {{ number_format($item->debit_walkin, 2) }}</td>   --}}
                                                <td class="text-end"  width="7%" style="color:#E9540F"> {{ number_format(($item->income)-($item->rcpt_money)-($item->debit_total),2) }}</td>  
                                            </tr>
                                                <?php 
                                                    $total111 = $total111 + $item->income;
                                                    $total222 = $total222 + $item->rcpt_money; 
                                                    $total333 = $total333 + $item->debit_total;
                                                    // $total444 = $total444 + $item->debit_walkin;
                                                    $total555 = $total555 + (($item->income)-($item->rcpt_money)-($item->debit_total));
                                                ?>
                                    @endforeach

                                    </tbody>
                                    <tr style="background-color: #f3fca1">
                                        <td colspan="6" class="text-end" style="background-color: #fca1a1"></td>
                                        <td class="text-center" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total111, 2) }}</label></td>
                                        <td class="text-center" style="background-color: #9f4efc" ><label for="" style="color: #FFFFFF">{{ number_format($total222, 2) }}</label></td>
                                        <td class="text-center" style="background-color: #c5224b"><label for="" style="color: #FFFFFF">{{ number_format($total333, 2) }}</label> </td>
                                        {{-- <td class="text-center" style="background-color: #0ea080"><label for="" style="color: #FFFFFF">{{ number_format($total444, 2) }}</label></td> --}}
                                        <td class="text-center" style="background-color: #f89625"><label for="" style="color: #FFFFFF">{{ number_format($total555, 2) }}</label></td>  
                                    </tr>  
                             
                                </table>

                            </div>
                        </div>
                    </div>
            </div> 
        </div>
    </div>



@endsection
@section('footer')

    <script>
        $(document).ready(function() {

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $('.Pulldata').click(function() { 
                var vn = $(this).val();
                // alert(vn);
                Swal.fire({
                        title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
                        text: "You Sync Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Sync it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show();  
                                
                                $.ajax({
                                    url: "{{ url('account_307_sync') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {vn},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Sync data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })

                                        } else if (data.status == 100) { 
                                            Swal.fire({
                                                title: 'ยังไม่ได้ลงเลขที่หนังสือ',
                                                text: "Please enter the number of the book.",
                                                icon: 'warning',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                   
                                                }
                                            })
                                            
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
        });
         
        $('.PulldataAll').click(function() { 
                var months = $('#months').val();
                var year = $('#year').val();
                // alert(startdate);
                Swal.fire({
                        title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
                        text: "You Sync Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Sync it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show();  
                                
                                $.ajax({
                                    url: "{{ url('account_307_syncall') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {months,year},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ซิ้งค์ข้อมูลสำเร็จ',
                                                text: "You Sync data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })

                                        } else if (data.status == 100) { 
                                            Swal.fire({
                                                title: 'ยังไม่ได้ลงเลขที่หนังสือ',
                                                text: "Please enter the number of the book.",
                                                icon: 'warning',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                   
                                                }
                                            })
                                            
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
        });
        
                  
    </script>
@endsection
