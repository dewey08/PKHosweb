@extends('layouts.medical')
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
        {{-- <div class="row">
            <div class="col-xl-12">
                <form action="{{ url('medical/med_rep3_search') }}" method="POST">
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
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                        </div>
                        <div class="col"></div>

                </form>
            </div>
        </div>
    </div> --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>รายงานยืม/การใช้เครื่องมือแพทย์ (ใช้ประจำ/ยืม) </h5>
                        </div>
                        <div class="col"></div>
                        <div class="col-md-2 text-end">
                            <a href="{{ url('medical/med_rep3_excel') }}" class="btn btn-success waves-effect waves-light btn-sm"
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
                                    <th width="10%" class="text-center" rowspan="3">ที่</th>
                                    <th class="text-center" rowspan="3">หน่วยงาน</th> 
                                    <th class="text-center" colspan="10">ประเภทเครื่องมือ/จำนวน(เครื่อง)</th> 
                                </tr>
                                <tr> 
                                    <th class="text-center" colspan="2">Infusion Pump</th>
                                    <th class="text-center" colspan="2">Syring Pump</th>
                                    <th class="text-center" colspan="2">Monitor</th>
                                    <th class="text-center" colspan="2">EKG</th>
                                    <th class="text-center" colspan="2">Defrib</th>
                                </tr>
                                <tr> 
                                    <th class="text-center">ใช้ประจำ</th>
                                    <th class="text-center">ยืม</th>                                
                                    <th class="text-center">ใช้ประจำ</th>
                                    <th class="text-center">ยืม</th>                                
                                    <th class="text-center">ใช้ประจำ</th>
                                    <th class="text-center">ยืม</th>                               
                                    <th class="text-center">ใช้ประจำ</th>
                                    <th class="text-center">ยืม</th>                                
                                    <th class="text-center">ใช้ประจำ</th>
                                    <th class="text-center">ยืม</th>
                                </tr>
                            </thead>
                            <tbody>
 
                                <?php $i = 1; ?>
                                {{-- @foreach ($medical_deb as $item)                                     
                                            <tr id="sid{{ $item->DEPARTMENT_SUB_SUB_ID }}">
                                                <td width="10%">{{ $i++ }}</td> 
                                                <td class="p-2">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>                                
                                                <td class="text-center">3</td>
                                                <td class="text-center">4</td>                                
                                                <td class="text-center">5</td>
                                                <td class="text-center">6</td>                               
                                                <td class="text-center">7</td>
                                                <td class="text-center">8</td>                                
                                                <td class="text-center">9</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">11</td>
                                                <td class="text-center">12</td>                                    
                                            </tr>                                      
                                @endforeach --}}
                                @foreach ($medical_deb as $item)
                                <?php 
                                // $deb = $item->medical_borrow_fromdebsubsub_id;
                                    // ใช้ประจำ
                                        $Infusionpump_n = DB::table('article_data')->where('medical_typecat_id','=',5)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $SyringPump_n = DB::table('article_data')->where('medical_typecat_id','=',4)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $Monitor_n = DB::table('article_data')->where('medical_typecat_id','=',3)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $Ekg_n = DB::table('article_data')->where('medical_typecat_id','=',2)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $Defrib_n = DB::table('article_data')->where('medical_typecat_id','=',1)->where('article_deb_subsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                    // ยืม
                                        $Infusionpump_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',5)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $SyringPump_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',4)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $Monitor_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',3)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $Ekg_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',2)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
                                        $Defrib_c = DB::table('medical_borrow')->where('medical_borrow_typecat_id','=',1)->where('medical_borrow_debsubsub_id','=',$item->DEPARTMENT_SUB_SUB_ID)->count(); 
?>
                         
                                            <tr>
                                                <td width="10%">{{ $i++ }}</td> 
                                                <td class="p-2">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>                                
                                                <td class="text-center">{{$Infusionpump_n}}</td>
                                                <td class="text-center"> {{$Infusionpump_c}}</td>                                
                                                <td class="text-center">{{$SyringPump_n}}</td>
                                                <td class="text-center">{{$SyringPump_c}}</td>                               
                                                <td class="text-center">{{$Monitor_n}}</td>
                                                <td class="text-center">{{$Monitor_c}}</td>                                
                                                <td class="text-center">{{$Ekg_n}}</td>
                                                <td class="text-center">{{$Ekg_c}}</td>
                                                <td class="text-center">{{$Defrib_n}}</td>
                                                <td class="text-center">{{$Defrib_c}}</td>                                    
                                            </tr>    
                                   
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
