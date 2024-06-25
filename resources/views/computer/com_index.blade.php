@extends('layouts.com')
@section('title', 'PK-OFFICER || แจ้งซ่อมคอมพิวเตอร์')
  
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
 
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    ?>
     <style>
        @media (min-width: 950px) {
            .modal {
                --bs-modal-width: 950px;
            }
        }
        @media (min-width: 1500px) {
            .modal-xls {
                --bs-modal-width: 1500px;
            }
        }
        @media (min-width: 1500px) {
            .container-fluids {
                width: 1500px;
                margin-left: auto;
                margin-right: auto;
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
    </style>
    <div class="container-fluids">
        <div class="row justify-content-center">
            <div class="row invoice-card-row">
                <div class="col-md-12"> 
                    <div class="card shadow">
                        <div class="card-header ">
                            <div class="d-flex">
                                <div class="p-2">
                                    <label for="">ข้อมูลครุภัณฑ์คอมพิวเตอร์</label>
                                </div>
                                <div class="ms-auto p-2">
                                </div>
                            </div>
                        </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example2"> 
                                <thead>
                                    <tr height="10px">
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="13%" class="text-center">รหัสครุภัณฑ์</th>
                                        <th class="text-center">รายการครุภัณฑ์</th>
                                        <th width="15%" class="text-center">ประเภทค่าเสื่อม</th>
                                        <th width="15%" class="text-center">หมวดครุภัณฑ์</th>
                                        <th width="20%" class="text-center">ประจำหน่วยงาน</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                            <tbody>
                                <?php $i = 1;                                    
                                $date = date('Y');                                    
                                ?>
                                @foreach ($article_data as $item)
                                    <tr id="sid{{ $item->article_id }}">
                                        <td class="text-center" width="4%">{{ $i++ }}</td>
                                        <td class="p-2" width="20%">{{ $item->article_num }} </td>
                                        <td class="p-2">{{ $item->article_name }}</td>
                                        <td class="p-2" width="15%">{{ $item->article_decline_name }}</td>
                                        <td class="p-2" width="15%">{{ $item->article_categoryname }}</td>
                                        <td class="p-2" width="17%">{{ $item->article_deb_subsub_name }}</td>
                                        <td class="text-center" width="10%">
                                            {{-- <a href="{{ url('article/article_index_edit/' . $item->article_id) }}"
                                                class="text-success" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                title="รายการบำรุงรักษา" >
                                                <i class="fa-solid fa-toolbox me-2"></i>
                                            </a>--}}
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle menu"
                                                    type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">ทำรายการ</button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item menu" data-bs-toggle="modal"
                                                            data-bs-target="#comdetailModal{{ $item->article_id }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="รายละเอียด">
                                                            <i
                                                                class="fa-solid fa-file-pen mt-2 ms-2 mb-2 me-2 text-info"></i>
                                                            <label for=""
                                                                style="color: rgb(33, 187, 248)">รายละเอียด</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item menu"
                                                            href="{{ url('computer/com_maintenance/' . $item->article_id) }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="รายการบำรุงรักษา"> 
                                                            <i class="fa-solid fa-toolbox mt-2 ms-2 mb-2 me-2"
                                                                style="color: rgb(191, 24, 224)"></i>
                                                            <label for=""
                                                                style="color: rgb(191, 24, 224)">รายการบำรุงรักษา</label>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item menu"
                                                            href="{{ url('computer/com_qrcode/' . $item->article_id) }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="Print QRCODE"
                                                            target="_blank">
                                                            <i
                                                                class="fa-solid fa-print mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                                            <label for=""
                                                                style="color: rgb(24, 115, 252)">Print QRCODE</label>
                                                        </a>
                                                    </li>
                                                    
                                                </ul>
                                            </div>
                                        </td>
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
    <script src="{{ asset('js/com.js') }}"></script>

@endsection
