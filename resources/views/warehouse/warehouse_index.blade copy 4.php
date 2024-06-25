{{-- @extends('layouts.accpk') --}}
@extends('layouts.warehouse_new')
@section('title', 'PK-OFFICER || คลังวัสดุ')
@section('content')

    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function warehouse_destroy(warehouse_rep_id) {
            Swal.fire({
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('warehouse/warehouse_destroy') }}" + '/' + warehouse_rep_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + warehouse_rep_id).remove();
                                    window.location.reload();
                                }
                            })
                        }
                    })
                }
            })
        }

        function warehouse_confirm(warehouse_rep_id) {
            Swal.fire({
                title: 'ยืนยันการรับเข้าคลังใช่ไหม?',
                text: "รายการวัสดุจะถูกนำเข้าคลังตามที่เลือกไว้ !!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ยืนยัน !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('warehouse/warehouse_confirm') }}" + '/' + warehouse_rep_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'นำเข้าคลังเรียบร้อย!',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // $("#sid" + product_id).remove();
                                    window.location.reload();
                                    // window.location =
                                    //     "{{ url('supplies/supplies_index') }}"; //     
                                }
                            })
                        }
                    })
                }
            })
        }

        function warehouse_confirmbefor(warehouse_rep_id) {
            Swal.fire({
                title: 'ยืนยันการรับเข้าคลังใช่ไหม?',
                text: "รายการวัสดุจะถูกนำเข้าคลังตามที่เลือกไว้ !!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ยืนยัน !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('warehouse/warehouse_confirmbefor') }}" + '/' + warehouse_rep_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'นำเข้าคลังเรียบร้อย!',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // $("#sid" + product_id).remove();
                                    window.location.reload();
                                    // window.location =
                                    //     "{{ url('supplies/supplies_index') }}"; //     
                                }
                            })
                        }
                    })
                }
            })
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
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\WarehouseController;
    use App\Http\Controllers\StaticController;
    $refnumber = WarehouseController::refnumber();
    $count_product = StaticController::count_product();
    $count_service = StaticController::count_service();
    date_default_timezone_set('Asia/Bangkok');
    $date = date('Y') + 543;
    $datefull = date('Y-m-d H:i:s');
    $time = date("H:i:s");
    $loter = $date.''.$time
    ?>
    {{-- <style>
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
            width: 90%;
            margin: 10px;
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
        .hrow{
            height: 2px;
            margin-bottom: 9px;
        }
        
    </style> --}}
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="main-card mb-3 card shadow">
                    {{-- <div class="card-header ">
                        <div class="d-flex">
                            <div class="p-2">
                                <label for="">รายการตรวจรับ</label>
                            </div>
                            <div class="ms-auto p-2">
                                <a href="{{ url('warehouse/warehouse_add') }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    ตรวจรับทั่วไป
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="card-header">
                        รายการตรวจรับ
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                {{-- <a href="{{ url('warehouse/warehouse_add') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                    <i class="pe-7s-shuffle btn-icon-wrapper"></i>ตรวจรับทั่วไป
                                </a> --}}

                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-shuffle btn-icon-wrapper"></i>เปิดบิล
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example"> --}}
                            <table style="width: 100%;" id="example"
                                class="table table-hover table-striped table-bordered myTable" {{-- class="table table-hover table-bordered table-sm myTable" --}}>
                                <thead>
                                    <tr>
                                        <th width="3%" class="text-center">ลำดับ</th>
                                        {{-- <th width="7%" class="text-center">สถานะ</th> --}}
                                        <th width="9%" class="text-center">เลขที่รับ</th>
                                        <th width="4%" class="text-center">ปีงบ</th>
                                        <th width="9%" class="text-center">วันที่</th>
                                        <th class="text-center">รับเข้าคลัง</th>
                                        <th width="8%" class="text-center">ประเภทรับ</th>
                                        {{-- <th width="8%" class="text-center">สถานะส่ง</th> --}}
                                        <th width="8%" class="text-center">สถานะคลัง</th>
                                        <th class="text-center">ตัวแทนจำหน่าย</th>
                                        <th width="10%" class="text-center">ผู้รับ</th>
                                        <th width="5%" class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $date = date('Y');
                                    ?>
                                    @foreach ($warehouse_rep as $item)
                                        <tr id="sid{{ $item->warehouse_rep_id }}">
                                            <td class="text-center" width="3%">{{ $i++ }}</td>
                                            {{-- <td class="text-center" width="7%">{{ $item->warehouse_rep_status }} </td> --}}
                                            <td class="text-center" width="9%">{{ $item->warehouse_rep_code }} </td>
                                            <td class="text-center" width="4%">{{ $item->warehouse_rep_year }}</td>
                                            <td class="text-center" width="9%">
                                                {{ DateThai($item->warehouse_rep_date) }}
                                            </td>
                                            <td class="p-2">{{ $item->warehouse_rep_inven_name }}</td>

                                            @if ($item->warehouse_rep_type == 'ASSET')
                                                <td class="font-weight-medium text-center" width="10%">
                                                    {{-- <div class="badge bg-warning">ผ่านพัสดุ</div> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-warning">ผ่านพัสดุ</button>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="10%">
                                                    {{-- <div class="badge bg-info">โดยตรง</div> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info">โดยตรง</button>
                                                </td>
                                            @endif

                                            {{-- @if ($item->warehouse_rep_send == 'FINISH')
                                                <td class="font-weight-medium text-center" style="font-size:15px"
                                                    width="8%">
                                                    <div class="badge bg-primary">ครบ</div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" style="font-size:15px"
                                                    width="8%">
                                                    <div class="badge bg-danger">ค้าง</div>
                                                </td>
                                            @endif --}}

                                            @if ($item->warehouse_rep_status == 'recieve')
                                                <td class="font-weight-medium text-center" width="10%">
                                                    {{-- <div class="badge bg-warning">รอรับเข้าคลัง</div> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-warning">รอรับเข้าคลัง</button>
                                                </td>
                                            @elseif ($item->warehouse_rep_status == 'beforallow')
                                                <td class="font-weight-medium text-center" width="10%">
                                                    {{-- <div class="badge" style="background-color: rgb(2, 119, 92)">
                                                        รับเข้าคลังกรณีไม่ครบ</div> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-primary">รับเข้าคลังกรณีไม่ครบ</button>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="10%">
                                                    {{-- <div class="badge bg-success">รับเข้าคลัง</div> --}}
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-success">รับเข้าคลัง</button>
                                                </td>
                                            @endif

                                            <td class="p-2" width="14%">{{ $item->warehouse_rep_vendor_name }}</td>
                                            <td class="text-center" width="9%">{{ $item->warehouse_rep_user_name }}
                                            </td>
                                            <td class="text-center" width="5%">
                                                <div class="dropdown d-inline-block">
                                                    <button type="button" aria-haspopup="true" aria-expanded="false"
                                                        data-bs-toggle="dropdown"
                                                        class="me-2 dropdown-toggle btn btn-outline-secondary btn-sm">
                                                        ทำรายการ
                                                    </button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true"
                                                        class="dropdown-menu-hover-link dropdown-menu">

                                                        @if ($item->warehouse_rep_status == 'recieve')
                                                            <a class="dropdown-item text-info" href=""
                                                                style="font-size:13px" data-bs-toggle="modal"
                                                                data-bs-target=".detail{{ $item->warehouse_rep_id }}">
                                                                <i class="fa-solid fa-circle-info me-2 text-info"
                                                                    style="font-size:13px"></i>
                                                                <span>รายละเอียด</span></a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-warning"
                                                                href="{{ url('warehouse/warehouse_edit/' . $item->warehouse_rep_id) }}"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-warning"
                                                                    style="font-size:13px"></i>
                                                                <span>แก้ไข</span>
                                                            </a>
                                                        @else
                                                        @endif

                                                        @if ($item->warehouse_rep_status == 'beforallow')
                                                            <a class="dropdown-item text-info" href=""
                                                                style="font-size:13px" data-bs-toggle="modal"
                                                                data-bs-target=".detail{{ $item->warehouse_rep_id }}">
                                                                <i class="fa-solid fa-circle-info me-2 text-info"
                                                                    style="font-size:13px"></i>
                                                                <span>รายละเอียด</span></a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item"
                                                                href="{{ url('warehouse/warehouse_addsub/' . $item->warehouse_rep_id) }}"
                                                                style="color: rgb(5, 173, 134);font-size:13px">
                                                                <i class="fa-solid fa-square-check me-2"
                                                                    style="color: rgb(5, 173, 134);font-size:14px"></i>
                                                                <span>เพิ่มรายการที่ส่งไม่ครบ</span>
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-primary" href=""
                                                                style="font-size:12px">
                                                                <i class="fa-solid fa-print me-2 text-primary"
                                                                    style="font-size:12px"></i>
                                                                <span>Print</span></a>
                                                        @else
                                                        @endif

                                                        @if ($item->warehouse_rep_status == 'recieve' && $item->warehouse_rep_send == 'STALE')
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-success"
                                                                href="javascript:void(0)"
                                                                onclick="warehouse_confirmbefor({{ $item->warehouse_rep_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-clipboard-check me-2 text-success"
                                                                    style="font-size:13px"></i>
                                                                <span>ยืนยันรับเข้าคลังกรณีไม่ครบ</span>
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-primary" href=""
                                                                style="font-size:12px">
                                                                <i class="fa-solid fa-print me-2 text-primary"
                                                                    style="font-size:12px"></i>
                                                                <span>Print</span></a>
                                                        @else
                                                        @endif

                                                        @if ($item->warehouse_rep_send == 'STALE' || $item->warehouse_rep_send == '')
                                                            {{-- <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                                onclick="warehouse_destroy({{ $item->warehouse_rep_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-trash-can me-2 text-danger"
                                                                    style="font-size:13px"></i>
                                                                <span>ลบ</span>
                                                            </a> --}}
                                                        @elseif ($item->warehouse_rep_send == 'FINISH' && $item->warehouse_rep_status == 'recieve')
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-success"
                                                                href="javascript:void(0)"
                                                                onclick="warehouse_confirm({{ $item->warehouse_rep_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-clipboard-check me-2 text-success"
                                                                    style="font-size:13px"></i>
                                                                <span>ยืนยันรับเข้าคลัง</span>
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-primary" href=""
                                                                style="font-size:12px">
                                                                <i class="fa-solid fa-print me-2 text-primary"
                                                                    style="font-size:12px"></i>
                                                                <span>Print</span></a>
                                                        @else
                                                            <!-- Extra Large modal -->
                                                            <a class="dropdown-item text-info" href=""
                                                                style="font-size:13px" data-bs-toggle="modal"
                                                                data-bs-target=".detail{{ $item->warehouse_rep_id }}">
                                                                <i class="fa-solid fa-circle-info me-2 text-info"
                                                                    style="font-size:13px"></i>
                                                                <span>รายละเอียด</span></a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-primary" href=""
                                                                style="font-size:12px">
                                                                <i class="fa-solid fa-print me-2 text-primary"
                                                                    style="font-size:12px"></i>
                                                                <span>Print</span></a>
                                                        @endif
                                                    </div>
                                                </div>


                                            </td>
                                        </tr>


                                        <!--  Modal content for the above example -->
                                        <div class="modal fade detail{{ $item->warehouse_rep_id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myExtraLargeModalLabel">
                                                            รายละเอียดการตรวจรับ</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_code">เลขที่รับ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_code }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_no_bill">เลขที่บิล </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_no_bill }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 ">
                                                                <label for="warehouse_rep_po">เลขที่ PO </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_po }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_year">ปีงบ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_year }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mt-3">
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_user_id">ผู้รับ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_user_name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_inven_id">รับเข้าคลัง </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_inven_name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="warehouse_rep_vendor_id">รับจาก </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_vendor_name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label for="">วันที่รับ </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_date }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <div class="row bg-info">
                                                            <div class="col-md-2 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">รหัสวัสดุ</label>
                                                            </div>
                                                            <div class="col-md-3 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">รายการวัสดุ</label>
                                                            </div>
                                                            <div class="col-md-1 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">หน่วยนับ</label>
                                                            </div>
                                                            <div class="col-md-1 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">ประเภท</label></div>
                                                            <div class="col-md-1 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">จำนวน</label></div>
                                                            <div class="col-md-2 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">ราคา</label></div>
                                                            <div class="col-md-2 text-center"> <label for=""
                                                                    style="color:white;font-size:17xp">ราคารวม</label>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <?php $ii = 1;
                                                        $datadetail = DB::connection('mysql')->select(
                                                            '   
                                                                                                                select product_code,product_name,product_type_name,product_qty,product_price,product_price_total,product_unit_subname
                                                                                                                from warehouse_rep_sub 
                                                                                                                where warehouse_rep_id ="' .
                                                                $item->warehouse_rep_id .
                                                                '"  
                                                                                                                  ',
                                                        );
                                                        $total = 0;
                                                        ?>
                                                        @foreach ($datadetail as $item3)
                                                            <div class="row hrow ">
                                                                <div class="col-md-2 text-center " style="font-size:14px">
                                                                    {{ $item3->product_code }}</div>
                                                                <div class="col-md-3" style="font-size:14px">
                                                                    {{ $item3->product_name }}</div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">
                                                                    {{ $item3->product_unit_subname }} </div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">
                                                                    {{ $item3->product_type_name }}</div>
                                                                <div class="col-md-1 text-center" style="font-size:14px">
                                                                    {{ $item3->product_qty }} </div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">
                                                                    {{ number_format($item3->product_price, 5) }}</div>
                                                                <div class="col-md-2 text-center" style="font-size:14px">
                                                                    {{ number_format($item3->product_price_total, 5) }}
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <?php
                                                            $total = $total + $item3->product_qty * $item3->product_price;
                                                            ?>
                                                        @endforeach
                                                        <div class="text-end me-5">
                                                            {{-- <label for="">{{ number_format(($item->sum_price),2 )}}</label> --}}
                                                            <label for=""
                                                                class="me-4">ราคารวมทั้งหมด</label><label
                                                                for=""> <b style="color: red;font-size:17px">
                                                                    {{ number_format($total, 5) }} </b> </label><label
                                                                for="" class="ms-4"> บาท</label>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-dismiss="modal">
                                                            <i class="fa-solid fa-xmark me-2"></i>
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เปิดบิล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form class="custom-validation" action="{{ route('ware.warehouse_billsave') }}" method="POST" id="Wbillsave" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">
                        <input type="hidden" name="warehouse_rep_user_id" id="warehouse_rep_user_id" value="{{ Auth::user()->id }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    {{-- <div class="col-md-1">
                                        <label for="warehouse_rep_code">เลขที่รับ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"> --}}
                                            <input id="warehouse_rep_code" type="hidden" class="form-control form-control-sm" name="warehouse_rep_code" value="{{ $refnumber }}" readonly>
                                        {{-- </div>
                                    </div> --}}
                                    <div class="col-md-1">
                                        <label for="warehouse_rep_no_bill">เลขที่บิล :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_no_bill" type="text"
                                                class="form-control-sm form-control" name="warehouse_rep_no_bill">
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <label for="warehouse_rep_po">เลขที่ PO :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_po" type="text" class="form-control-sm form-control"
                                                name="warehouse_rep_po">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="warehouse_rep_year" >ปีงบ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select id="warehouse_rep_year" name="warehouse_rep_year"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($budget_year as $ye)
                                                    @if ($ye->leave_year_id == $date)
                                                        <option value="{{ $ye->leave_year_id }}" selected>
                                                            {{ $ye->leave_year_id }} </option>
                                                    @else
                                                        <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-1">
                                        <label for="warehouse_rep_user_id">ผู้รับ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select id="warehouse_rep_user_id" name="warehouse_rep_user_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($users as $itemu)
                                                @if ($iduser == $itemu->id)
                                                <option value="{{ $itemu->id }}" selected> {{ $itemu->fname }} {{ $itemu->lname }} </option>
                                                @else
                                                <option value="{{ $itemu->id }}"> {{ $itemu->fname }} {{ $itemu->lname }} </option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row mt-3">
                                    
                                    <div class="col-md-2">
                                        <label for="warehouse_rep_inven_id">รับเข้าคลัง :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="warehouse_rep_inven_id" name="warehouse_rep_inven_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($warehouse_inven as $inven)
                                                    <option value="{{ $inven->warehouse_inven_id }}">
                                                        {{ $inven->warehouse_inven_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label for="warehouse_rep_vendor_id">รับจาก :</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="warehouse_rep_vendor_id" name="warehouse_rep_vendor_id"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($products_vendor as $ven)
                                                    <option value="{{ $ven->vendor_id }}"> {{ $ven->vendor_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-1">
                                        <label for="warehouse_rep_date">วันที่รับ :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group"> --}}
                                            <input class="form-control form-control-sm" type="hidden"
                                                id="example-datetime-local-input" name="warehouse_rep_date" value="{{$datefull}}">

                                        {{-- </div>
                                    </div> --}}

                                </div>


                            </div>
                        </div>
                        {{-- <div class="input-group">
                            <div class="input-group-text">
                                <span class="">@cid</span>
                            </div>
                            <input type="text" id="cid" name="cid" class="form-control">
                        </div>
                        <br>
                        <div class="input-group input-group-sm">
                            <div class="input-group-text">
                                <span class="">@Token</span>
                            </div>
                            <input type="text" class="form-control" id="token" name="token">
                        </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.detail', function() {
            var an = $(this).val();
            // alert(line_token_id);
            $('#labdetail').modal('show');
            $.ajax({

                type: "GET",
                url: "{{ url('k.karn_main_sss_detail') }}" + '/' + an,
                success: function(data) {
                    console.log(data.datadetail.billcode);
                    $('#billcode').val(data.datadetail.billcode)
                    $('#namelab').val(data.datadetail.namelab)
                    $('#qt').val(data.datadetail.qt)
                    $('#pricet').val(data.datadetail.pricet)
                },
            });
        });
    </script>
    <script>
        $(document).ready(function() {
        $('#Wbillsave').on('submit',function(e){
                    e.preventDefault();            
                    var form = this; 
                    $.ajax({
                          url:$(form).attr('action'),
                          method:$(form).attr('method'),
                          data:new FormData(form),
                          processData:false,
                          dataType:'json',
                          contentType:false,
                          beforeSend:function(){
                            $(form).find('span.error-text').text('');
                          },
                          success:function(data){
                            if (data.status == 100 ) {
                                Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับเข้าคลัง...!!',
                                text: 'กรุณาเลือกรับเข้าคลังอะไร!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                    }
                                })
                            }else if (data.status == 150 ) {
                                Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับจาก...!!',
                                text: 'กรุณาเลือกรับจากตัวแทนจำหน่ายอะไร!',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                    }
                                })
                            }else if (data.status == 500 ) {
                                Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรายการวัสดุ...!!',
                                text: 'กรุณาเลือกรายการวัสดุ!',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                    }
                                })
                            } else {          
                              Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {                  
                                  window.location="{{url('warehouse/warehouse_index')}}";
                                }
                              })      
                            }
                          }
                    });
              });
    });
    </script>
  

@endsection
