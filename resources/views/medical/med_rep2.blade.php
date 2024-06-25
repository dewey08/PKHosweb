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
        {{-- <div class="row">
            <div class="col-xl-12">
                <form action="{{ url('medical/med_rep2_search') }}" method="POST">
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
        </div> --}}
    {{-- </div> --}}
    <div class="row mt-1">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>รายงานยืม/การใช้เครื่องมือแพทย์ </h5>
                        </div>
                        <div class="col"></div>
                        <div class="col-md-2 text-end">
                            <a href="{{ url('medical/med_rep2_excel') }}" class="btn btn-success waves-effect waves-light btn-sm"
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
                                    <th width="10%" class="text-center" rowspan="2">ที่</th>
                                    <th class="text-center" rowspan="2">ประเภทเครื่องมือ</th> 
                                    <th class="text-center" colspan="5">จำนวน(เครื่อง)</th>  
                                </tr>
                                <tr> 
                                    <th class="text-center">มีทั้งหมด</th> 
                                    <th class="text-center">ถูกยืม</th>
                                    <th class="text-center">ส่งซ่อม</th>
                                    <th class="text-center">ระหว่างซ่อม</th>
                                    <th class="text-center">พร้อมใช้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($medical_typecat as $item)
                                    <?php                                    
                                     $counttype = DB::table('article_data')
                                     ->leftjoin('medical_borrow','article_data.article_id','=','medical_borrow.medical_borrow_article_id')
                                     ->where('medical_typecat_id','=',$item->medical_typecat_id)
                                     ->count();   
                                     $counbetweenrepair = DB::table('article_data')
                                     ->leftjoin('medical_borrow','article_data.article_id','=','medical_borrow.medical_borrow_article_id')
                                     ->where('medical_typecat_id','=',$item->medical_typecat_id)
                                     ->where('article_status_id','=',4)->count(); 
                                     $counready = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->where('article_status_id','=',3)->count();  
                                     $counborow = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->where('article_status_id','=',1)->count();  
                                     $counrepaire = DB::table('article_data')->where('medical_typecat_id','=',$item->medical_typecat_id)->where('article_status_id','=',2)->count();                                    
                                    ?>
                                    <tr id="sid{{ $item->medical_typecat_id }}">
                                        <td width="10%">{{ $i++ }}</td>
                                        <td class="p-2" style="font-size:13px;">{{ $item->medical_typecatname }}</td>
                                        <td class="text-center" width="10%" style="font-size:13px;">{{$counttype}} </td>    
                                        <td class="text-center" width="10%" style="font-size:13px;">{{$counborow}} </td>    
                                        <td class="text-center" width="10%" style="font-size:13px;">{{$counrepaire}} </td>                                  
                                        <td class="text-center" width="10%" style="font-size:13px;">{{$counbetweenrepair}} </td>
                                        <td class="text-center" width="10%" style="font-size:13px;">{{$counready}} </td>                                     
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
