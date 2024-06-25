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
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ url('medical/med_rep1_search') }}" method="POST">
                    @csrf
                    <div class="row"> 
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                    id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $startdate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                    id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $enddate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <div class="input-group">
                                <select id="medical_typecat_id" name="medical_typecat_id" class="form-select form-select-lg"
                                    style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($medical_typecat as $typecat)
                                    @if ($typecat_id == $typecat->medical_typecat_id)
                                    <option value="{{ $typecat->medical_typecat_id }}" selected>
                                        {{ $typecat->medical_typecatname }}
                                    </option>
                                    @else
                                    <option value="{{ $typecat->medical_typecat_id }}">
                                        {{ $typecat->medical_typecatname }}
                                    </option>
                                    @endif
                                       
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="input-group">
                                <select id="article_deb_subsub_id" name="article_deb_subsub_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($department_sub_sub as $deb_subsub)
                                                @if ($deb_subsub_id == $deb_subsub->DEPARTMENT_SUB_SUB_ID)
                                                <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}" selected>
                                                    {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                                @else
                                                <option value="{{ $deb_subsub->DEPARTMENT_SUB_SUB_ID }}">
                                                    {{ $deb_subsub->DEPARTMENT_SUB_SUB_NAME }} </option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">
                            <div class="input-group">
                                <select id="article_status_id" name="article_status_id"
                                class="form-select form-select-lg" style="width: 100%">
                                <option value=""></option>
                                @foreach ($article_status as $te)
                                @if ($status_id == $te->article_status_id)
                                <option value="{{ $te->article_status_id }}" selected>
                                    {{ $te->article_status_name }} </option>
                                @else
                                <option value="{{ $te->article_status_id }}">
                                    {{ $te->article_status_name }} </option>
                                @endif
                                   
                                @endforeach
                            </select>
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
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>สถานะ การยืม/การใช้เครื่องมือแพทย์(ตามประเภท-หน่วยงาน) </h5>
                        </div>
                        <div class="col"></div>
                        <div class="col-md-2 text-end">
                            <a href="{{ url('medical/med_rep1_excel') }}" class="btn btn-success waves-effect waves-light btn-sm"
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
                                    <th width="10%" class="text-center">เครื่องที่</th>
                                    <th class="text-center">เลขครุภัณฑ์/serial number</th> 
                                    <th class="text-center" width="10%">สถานะเครื่อง</th>
                                    <th class="text-center">หน่วยงานที่ยืม หรือใช้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($medical_borrow as $item)
                                    <?php
                                    
                                    $colorstatus = $item->medical_borrow_active;
                                    if ($colorstatus == 'REQUEST') {
                                        $color_new = 'background-color: rgb(181, 236, 234)';
                                    } elseif ($colorstatus == 'APPROVE') {
                                        $color_new = 'background-color: rgb(38, 202, 194)';
                                        // } elseif ($colorstatus == 'REPFINISH') {
                                        //     $color_new = 'background-color: rgb(156, 219, 7)';
                                        // } elseif ($colorstatus == 'REQUEST') {
                                        //     $color_new = ' ';
                                    } else {
                                        $color_new = 'background-color: rgb(107, 180, 248)';
                                    }
                                    
                                    ?>
                                    <tr id="sid{{ $item->medical_borrow_id }}">
                                        <td width="10%">{{ $i++ }}</td>
                                        <td class="p-2">{{ $item->article_num }}</td>

                                        <td class="text-center" width="10%">
                                            {{-- @if ($item->medical_borrow_active == 'REQUEST')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color: rgb(235, 81, 10);font-size:13px;color:white">ร้องขอ
                                                </button>
                                            @elseif ($item->medical_borrow_active == 'SENDEB')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color: rgb(89, 10, 235);font-size:13px;color:white">ส่งคืน
                                                </button>
                                            @elseif ($item->medical_borrow_active == 'APPROVE')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color:rgb(10, 235, 160);font-size:13px;color:white">จัดสรร
                                                </button>
                                            @else                                               
                                            @endif --}}
                                            @if ($item->article_status_id == '1' )
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color: rgb(235, 81, 10);font-size:13px;color:white">ยืม
                                                </button>
                                            @elseif ($item->article_status_id == '2')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color:rgb(10, 201, 235);font-size:13px;color:white">พร้อมใช้(คืน)
                                                </button>
                                            @elseif ($item->article_status_id == '3')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color:rgb(10, 235, 160);font-size:13px;color:white">ปกติ
                                                </button>
                                            @elseif ($item->article_status_id == '4')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color:rgb(235, 220, 10);font-size:13px;color:white">ระหว่างซ่อม
                                                </button>
                                            @elseif ($item->article_status_id == '5')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color:rgb(10, 235, 160);font-size:13px;color:white">รอจำหน่าย
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color: rgb(89, 10, 235);font-size:13px;color:white">จำหน่ายแล้ว
                                                </button>
                                            @endif
                                        </td>
                                    
                                      
                                        <td class="p-2">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
                                       
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
