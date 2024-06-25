@extends('layouts.user')
@section('title', 'PK-OFFICER || P4P')

    


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
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();

     $ynow = date('Y')+543;
    $yb =  date('Y')+542;
    
 ?>
     <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{	
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
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
               border-top: 10px #fd6812 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(360deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Dashboard P4P </h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                           
 
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">

            {{-- @foreach ($leave_month_year as $item)    --}}
            @foreach ($p4p_work as $item)   
                <?php 
                    $countacc_debtor = DB::select('
                        SELECT count(vn) as VN from acc_debtor 
                        WHERE stamp="N" and pttype_eclaim_id = "17" 
                        and account_code="1102050101.401" 
                        and month(vstdate) = "'.$item->MONTH_ID.'";
                    ');
                    foreach ($countacc_debtor as $key => $value) {
                        $debtor_ = $value->VN;
                    }
                    $sumacc_debtor = DB::select('
                        SELECT SUM(debit) as debit from acc_debtor 
                        WHERE stamp="N" and pttype_eclaim_id = "17" 
                        and account_code="1102050101.401" 
                        and month(vstdate) = "'.$item->MONTH_ID.'";
                    ');
                    foreach ($sumacc_debtor as $key => $value2) {
                        $sumdebtor_ = $value2->debit;
                    }

                    $sumap4p = DB::select('
                        SELECT SUM(p4p_workload_sum) as summon 
                            FROM p4p_workload wl
                            LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id
                            WHERE wl.p4p_workload_user="'.$iduser.'" 
                            AND w.p4p_work_month ="'.$item->MONTH_ID.'"
                        ');
                    foreach ($sumap4p as $key => $value3) {
                        $summ_ = $value3->summon;
                    }
                    $sumqty_1 = DB::select('SELECT SUM(p4p_workload_1) as qty_1 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_1 as $key => $item_1) {
                        $sqty_1 = $item_1->qty_1;
                    }
                    $sumqty_2 = DB::select('SELECT SUM(p4p_workload_2) as qty_2 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_2 as $key => $item_2) {
                        $sqty_2 = $item_2->qty_2;
                    }
                    $sumqty_3 = DB::select('SELECT SUM(p4p_workload_3) as qty_3 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_3 as $key => $item_3) {
                        $sqty_3 = $item_3->qty_3;
                    }
                    $sumqty_4 = DB::select('SELECT SUM(p4p_workload_4) as qty_4 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_4 as $key => $item_4) {
                        $sqty_4 = $item_4->qty_4;
                    }
                    $sumqty_5 = DB::select('SELECT SUM(p4p_workload_5) as qty_5 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_5 as $key => $item_5) {
                        $sqty_5 = $item_5->qty_5;
                    }
                    $sumqty_6 = DB::select('SELECT SUM(p4p_workload_6) as qty_6 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_6 as $key => $item_6) {
                        $sqty_6 = $item_6->qty_6;
                    }
                    $sumqty_7 = DB::select('SELECT SUM(p4p_workload_7) as qty_7 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_7 as $key => $item_7) {
                        $sqty_7 = $item_7->qty_7;
                    }
                    $sumqty_8 = DB::select('SELECT SUM(p4p_workload_8) as qty_8 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_8 as $key => $item_8) {
                        $sqty_8 = $item_8->qty_8;
                    }
                    $sumqty_9 = DB::select('SELECT SUM(p4p_workload_9) as qty_9 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_9 as $key => $item_9) {
                        $sqty_9 = $item_9->qty_9;
                    }
                    $sumqty_10 = DB::select('SELECT SUM(p4p_workload_10) as qty_10 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_10 as $key => $item_10) {
                        $sqty_10 = $item_10->qty_10;
                    }
                    $sumqty_11 = DB::select('SELECT SUM(p4p_workload_11) as qty_11 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_11 as $key => $item_11) {
                        $sqty_11 = $item_11->qty_11;
                    }
                    $sumqty_12 = DB::select('SELECT SUM(p4p_workload_12) as qty_12 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_12 as $key => $item_12) {
                        $sqty_12 = $item_12->qty_12;
                    }
                    $sumqty_13 = DB::select('SELECT SUM(p4p_workload_13) as qty_13 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_13 as $key => $item_13) {
                        $sqty_13 = $item_13->qty_13;
                    }
                    $sumqty_14 = DB::select('SELECT SUM(p4p_workload_14) as qty_14 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_14 as $key => $item_14) {
                        $sqty_14= $item_14->qty_14;
                    }
                    $sumqty_15 = DB::select('SELECT SUM(p4p_workload_15) as qty_15 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_15 as $key => $item_15) {
                        $sqty_15 = $item_15->qty_15;
                    }
                    $sumqty_16 = DB::select('SELECT SUM(p4p_workload_16) as qty_16 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_16 as $key => $item_16) {
                        $sqty_16 = $item_16->qty_16;
                    }
                    $sumqty_17 = DB::select('SELECT SUM(p4p_workload_17) as qty_17 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_17 as $key => $item_17) {
                        $sqty_17 = $item_17->qty_17;
                    }
                    $sumqty_18 = DB::select('SELECT SUM(p4p_workload_18) as qty_18 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_18 as $key => $item_18) {
                        $sqty_18 = $item_18->qty_18;
                    }
                    $sumqty_19 = DB::select('SELECT SUM(p4p_workload_19) as qty_19 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_19 as $key => $item_19) {
                        $sqty_19 = $item_19->qty_19;
                    }
                    $sumqty_20 = DB::select('SELECT SUM(p4p_workload_20) as qty_20 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_20 as $key => $item_20) {
                        $sqty_20 = $item_20->qty_20;
                    }
                    $sumqty_21 = DB::select('SELECT SUM(p4p_workload_21) as qty_21 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_21 as $key => $item_21) {
                        $sqty_21 = $item_21->qty_21;
                    }
                    $sumqty_22 = DB::select('SELECT SUM(p4p_workload_22) as qty_22 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_22 as $key => $item_22) {
                        $sqty_22 = $item_22->qty_22;
                    }
                    $sumqty_23 = DB::select('SELECT SUM(p4p_workload_23) as qty_23 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_23 as $key => $item_23) {
                        $sqty_23 = $item_23->qty_23;
                    }
                    $sumqty_24 = DB::select('SELECT SUM(p4p_workload_24) as qty_24 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_24 as $key => $item_24) {
                        $sqty_24 = $item_24->qty_24;
                    }
                    $sumqty_25 = DB::select('SELECT SUM(p4p_workload_25) as qty_25 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_25 as $key => $item_25) {
                        $sqty_25 = $item_25->qty_25;
                    }
                    $sumqty_26 = DB::select('SELECT SUM(p4p_workload_26) as qty_26 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_26 as $key => $item_26) {
                        $sqty_26 = $item_26->qty_26;
                    }
                    $sumqty_27 = DB::select('SELECT SUM(p4p_workload_27) as qty_27 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_27 as $key => $item_27) {
                        $sqty_27 = $item_27->qty_27;
                    }
                    $sumqty_28 = DB::select('SELECT SUM(p4p_workload_28) as qty_28 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_28 as $key => $item_28) {
                        $sqty_28 = $item_28->qty_28;
                    }
                    $sumqty_29 = DB::select('SELECT SUM(p4p_workload_29) as qty_29 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_29 as $key => $item_29) {
                        $sqty_29 = $item_29->qty_29;
                    }
                    $sumqty_30 = DB::select('SELECT SUM(p4p_workload_30) as qty_30 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_30 as $key => $item_30) {
                        $sqty_30 = $item_30->qty_30;
                    }
                    $sumqty_31 = DB::select('SELECT SUM(p4p_workload_31) as qty_31 FROM p4p_workload wl LEFT JOIN p4p_work w ON w.p4p_work_id = wl.p4p_work_id WHERE wl.p4p_workload_user="'.$iduser.'" AND w.p4p_work_month ="'.$item->MONTH_ID.'"');
                    foreach ($sumqty_31 as $key => $item_31) {
                        $sqty_31 = $item_31->qty_31;
                    }

                    $totalqty = $sqty_1+$sqty_2+$sqty_3+$sqty_4+$sqty_5+$sqty_6+$sqty_7+$sqty_8+$sqty_9+$sqty_10+ $sqty_11+$sqty_12+$sqty_13+$sqty_14+$sqty_15+$sqty_16+$sqty_17+$sqty_18+$sqty_19+$sqty_20+ $sqty_21+$sqty_22+$sqty_23+$sqty_24+$sqty_25+$sqty_26+$sqty_27+$sqty_28+$sqty_29+$sqty_30+$sqty_31;
                ?>
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    {{-- @if ($item->month_year_name =='ตุลาคม')
                                        <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p>
                                    @elseif ($item->month_year_name =='พฤศจิกายน')
                                    <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p>
                                    @elseif ($item->month_year_name =='ธันวาคม')
                                    <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$yb}}</p>
                                    @else
                                        <p class="text-truncate font-size-14 mb-2">เดือน {{$item->month_year_name}} {{$ynow}}</p>
                                    @endif --}}
                                    <p class="text-truncate font-size-14 mb-2">เดือน {{$item->p4p_work_monthth}} {{($item->p4p_work_year)+543}}</p>
                                    @if ($summ_ == 0)
                                    <h4 class="mb-2">0.00 แต้ม</h4>
                                    @else
                                    <h4 class="mb-2"><a href="{{url('work_choose/'.$item->p4p_work_id)}}">{{$summ_}}  </a>แต้ม</h4>
                                    {{-- <h4 class="mb-2"><a href="">{{$summ_}}  </a>แต้ม</h4> --}}
                                    @endif
                                   
                                    <p class="text-muted mb-0"><span class="text-danger fw-bold font-size-12 me-2"><i class="ri-arrow-right-up-line me-1 align-middle"></i>{{$totalqty}}</span>ชิ้นงาน</p>
                                </div>
                                <div class="avatar-sm me-2">
                                    <a href="">
                                        <span class="avatar-title bg-light rounded-3">
                                            <i class="fa-solid fa-p text-info font-size-22"></i>  
                                        </span> 
                                    </a>
                                </div>
                                <div class="avatar-sm me-2">
                                    <span class="avatar-title bg-light rounded-3"> 
                                        <i class="fa-solid fa-4 text-danger font-size-24"></i>
                                    </span> 
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-info rounded-3"> 
                                        <i class="fa-solid fa-p text-warning font-size-24"></i>
                                    </span> 
                                </div>
                            </div>                                            
                        </div><!-- end cardbody -->
                    </div> 
                </div> 
            @endforeach
           
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
                    placeholder:"--เลือก--",
                    allowClear:true
                });
                $('#p4p_work_id2').select2({
                        dropdownParent: $('#Copy_worksetbtn')
                    });
                    $('#p4p_work_year').select2({
                        dropdownParent: $('#Copy_worksetbtn')
                    });
                $('#p4p_workset_id').select2({
                    placeholder:"--เลือก--",
                    allowClear:true
                });
                // Saveworksetbtn
                
                $('#SaveScorebtn').click(function() {
                    var p4p_workload_date = $('#p4p_workload_date').val(); 
                    var p4p_workset_id = $('#p4p_workset_id').val(); 
                    var p4p_workset_score_now = $('#p4p_workset_score_now').val();
                    var p4p_work_id = $('#p4p_work_id').val();
                    $.ajax({
                        url: "{{ route('p4.p4p_work_scorenowsave') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            p4p_workload_date,
                            p4p_workset_id,
                            p4p_workset_score_now,
                            p4p_work_id                       
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'บันทึกข้อมูลสำเร็จ',
                                    text: "You Insert data success",
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
                                        // window.location="{{url('warehouse/warehouse_index')}}";
                                    }
                                })
                            } else {
                                 
                            }
    
                        },
                    });
                });
                
               
                
            });
            
    </script>
    
    @endsection
