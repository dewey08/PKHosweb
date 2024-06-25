@extends('layouts.medicalslide')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')

<?php
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\DB;
$count_meettingroom = StaticController::count_meettingroom();
?>
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
        body {
            font-size: 13px;
        }

        .btn {
            font-size: 13px;
        }

        .bgc {
            background-color: #264886;
        }

        .bga {
            background-color: #fbff7d;
        }

        .boxpdf {
            /* height: 1150px; */
            height: auto;
        }

        .page {
            width: 80%;
            /* margin: 10px; */
            box-shadow: 0px 0px 5px #000;
            animation: pageIn 1s ease;
            transition: all 1s ease, width 0.2s ease;
        }

        @keyframes pageIn {
            0% {
                transform: translateX(-300px);
                opacity: 0;
            }

            100% {
                transform: translateX(0px);
                opacity: 1;
            }
        }

        @media (min-width: 500px) {
            .modal {
                --bs-modal-width: 500px;
            }
        }

        @media (min-width: 950px) {
            .modal-lg {
                --bs-modal-width: 950px;
            }
        }

        @media (min-width: 1500px) {
            .modal-xls {
                --bs-modal-width: 1500px;
            }
        }

        @media (min-width: auto; ) {
            .container-fluids {
                width: auto;
                margin-left: 20px;
                margin-right: 20px;
                margin-top: auto;
            }

            .dataTables_wrapper .dataTables_filter {
                float: right
            }

            .dataTables_wrapper .dataTables_length {
                float: left
            }

            .dataTables_info {
                float: left;
            }

            .dataTables_paginate {
                float: right
            }

            .custom-tooltip {
                --bs-tooltip-bg: var(--bs-primary);
            }

            .table thead tr th {
                font-size: 14px;
            }

            .table tbody tr td {
                font-size: 13px;
            }

            .menu {
                font-size: 13px;
            }
        }

        .hrow {
            height: 2px;
            margin-bottom: 9px;
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
        }

        .colortool {
            background-color: red;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ url('medical/med_rep3') }}" method="POST">
                    @csrf
                    <div class="row"> 
                        <div class="col"></div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group">
                                <input type="date" class="form-control form-control-sm" name="startdate" id="startdate" value="{{ $startdate }}"> 
                            </div>
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group">
                                <input type="date" class="form-control form-control-sm" name="enddate" id="enddate" value="{{ $enddate }}"> 
                            </div>
                        </div>
 
                        
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                        </div>
                        <div class="col"></div>

                </form>
            </div>
        </div> 
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>รายงานยืม/การใช้เครื่องมือแพทย์ (ใช้เกินกำหนด(14 วัน)) </h5>
                        </div>
                        <div class="col"></div>
                        <div class="col-md-2 text-end">
                            <a href="{{ url('medical/med_rep3_excel/'.$startdate.'/'.$enddate) }}" class="btn btn-success waves-effect waves-light btn-sm"
                            target="_blank"><i class="fa-solid fa-file-excel text-white me-2"></i>
                            ส่งออก Excel
                        </a>
                        </div>

                    </div>
                </div>
                <div class="card-body shadow-lg">
                    <div class="table-responsive">
                        <table style="width: 100%;" id="example"
                            class="table table-hover table-striped table-bordered myTable">
                            <thead> 
                                <tr> 
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">เลขครุภัณฑ์ / SN</th>                                
                                    <th class="text-center">รายการเครื่องมือการแพทย์</th>
                                    <th class="text-center">จำนวนวันที่ยืม</th>                                
                                    <th class="text-center">หน่วยงานที่ยืม</th> 
                                </tr>
                            </thead>
                            <tbody>
 
                                <?php $i = 1; ?>
                                @foreach ($medical_borrow_rep3 as $item) 
                                    <?php
                                            $date = date('Y-m-d');
                                            $d = date('d');
                                            $datestart = $item->medical_borrow_date;
                                            $newDatestart = date('Y-m-d', strtotime($datestart));
                                            $newDatestart2 = date('d', strtotime($datestart));
                                            $dateend = $item->medical_borrow_backdate;

                                            $countdateold =   round(abs(strtotime(date('Y-m-d')) - strtotime($item->medical_borrow_date))/60/60/24)+1; 
                                            $datestartss = strtotime($item->medical_borrow_date);
                                            
                                            $total = DB::table('medical_borrow')
                                            ->whereBetween('medical_borrow_date', [$newDatestart, $date])->count(); 

                                                $start = strtotime($item->medical_borrow_date);
                                                $end = strtotime($date);
                                                $tot = ($end - $start) / 25200; 
                                            
                                            if ($dateend == '') {
                                                $newDatetotal = $countdateold; 
                                            } else {      
                                                $newDateend  = date('d', strtotime($dateend));                                  
                                                $newDatetotal  = $newDateend - $newDatestart2;
                                            } 
                                    ?>
                                    @if ($newDatetotal >= 14)
                                        <tr id="sid{{ $item->medical_borrow_id }}">
                                            <td width="5%" style="font-size:13px;">{{ $i++ }}</td> 
                                            <td class="p-2" style="font-size:13px;">{{ $item->article_num }}</td>                                
                                            <td class="p-2" style="font-size:13px;">{{ $item->article_name }}</td>
                                            <td class="text-center" style="font-size:13px;">{{ $newDatetotal }}</td>                                
                                            <td class="p-2" style="font-size:13px;">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>                                                                               
                                        </tr>   
                                    @else
                                        
                                    @endif
                                                                               
                                @endforeach
                               
                            </tbody>
                        </table>

                    </div>
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
            $('#example').DataTable();
            $('#example2').DataTable();

            $('#article_status_id').select2({
                placeholder: "--สถานะ--",
                allowClear: true
            });
            $('#article_deb_subsub_id').select2({
                placeholder: "--หน่วยงาน--",
                allowClear: true
            });
            $('#medical_typecat_id').select2({
                placeholder: "--ประเภทเครื่องมือ--",
                allowClear: true
            });
        });
    </script>
@endsection
