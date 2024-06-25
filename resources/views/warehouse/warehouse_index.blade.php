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
        function warehouse_confirm_recieve(warehouse_rep_id) {
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
                        url: "{{ url('warehouse_confirm_recieve') }}" + '/' + warehouse_rep_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(data) {
                            if (data.status == 200 ) {
                                Swal.fire({
                                title: 'นำเข้าคลังเรียบร้อย',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                              }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                              })

                            } else {
                            //   Swal.fire({
                            //     title: 'นำเข้าคลังเรียบร้อย',
                            //     text: "You Insert data success",
                            //     icon: 'success',
                            //     showCancelButton: false,
                            //     confirmButtonColor: '#06D177',
                            //     confirmButtonText: 'เรียบร้อย'
                            //   }).then((result) => {
                            //     if (result.isConfirmed) {
                            //         window.location.reload();
                            //     }
                            //   })
                            }

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
    $yearnow = date('Y') + 543;
    $datefull = date('Y-m-d H:i:s');
    $time = date('H:i:s');
    $loter = $date . '' . $time;
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
           border: 10px #ddd solid;
           border-top: 10px #1fdab1 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% {
               transform: rotate(390deg);
           }
           }
           .is-hide{
           display:none;
           }
</style>
<div class="tabs-animation">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
            </div>
        </div>
    </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="main-card mb-3 card shadow">
                    <div class="card-header">
                        รายการตรวจรับ
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                {{-- <a href="" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-shuffle btn-icon-wrapper"></i>เปิดบิล
                            </a> --}}
                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-shuffle btn-icon-wrapper"></i>ออกบิล
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        {{-- <div class="table-responsive"> --}}
                            {{-- <table style="width: 100%;" id="example"
                                class="table table-hover table-striped table-bordered myTable"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-family: sans-serif;font-size: 13px;">
                                        <th width="3%" class="text-center">ลำดับ</th>
                                        {{-- <th width="7%" class="text-center">สถานะ</th> --}}
                                        <th width="9%" class="text-center">เลขที่รับ</th>
                                        {{-- <th width="4%" class="text-center">ปีงบ</th> --}}
                                        <th width="9%" class="text-center">วันที่</th>
                                        <th class="text-center">รับเข้าคลัง</th>
                                        {{-- <th width="8%" class="text-center">ประเภทรับ</th> --}}
                                        {{-- <th width="8%" class="text-center">สถานะส่ง</th> --}}
                                        <th width="8%" class="text-center">สถานะคลัง</th>
                                        {{-- <th class="text-center">ตัวแทนจำหน่าย</th> --}}
                                        {{-- <th width="10%" class="text-center">ผู้รับ</th> --}}
                                        <th width="5%" class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $date = date('Y');
                                    ?>
                                    @foreach ($warehouse_rep as $item)
                                        <tr id="sid{{ $item->warehouse_rep_id }}" style="font-family: sans-serif;font-size: 13px;">
                                            <td class="text-center" width="3%">{{ $i++ }}</td>
                                            {{-- <td class="text-center" width="7%">{{ $item->warehouse_rep_status }} </td> --}}
                                            <td class="text-center" width="9%">{{ $item->warehouse_rep_code }} </td>
                                            {{-- <td class="text-center" width="4%">{{ $item->warehouse_rep_year }}</td> --}}
                                            <td class="text-center" width="9%">
                                                {{ DateThai($item->warehouse_rep_date) }}
                                            </td>
                                            <td class="p-2">{{ $item->warehouse_rep_inven_name }}</td>

                                            {{-- @if ($item->warehouse_rep_type == 'ASSET')
                                                <td class="font-weight-medium text-center" width="10%"> 
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-warning">ผ่านพัสดุ</button>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="10%"> 
                                                    <button
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-info">โดยตรง</button>
                                                </td>
                                            @endif --}}

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

                                            {{-- <td class="p-2" width="14%">{{ $item->warehouse_rep_vendor_name }}</td> --}}
                                            {{-- <td class="text-center" width="9%">{{ $item->warehouse_rep_user_name }} </td> --}}
                                            <td class="text-center" width="5%">
                                                <div class="dropdown d-inline-block">
                                                    <button type="button" aria-haspopup="true" aria-expanded="false"
                                                        data-bs-toggle="dropdown"
                                                        class="me-2 dropdown-toggle btn btn-outline-secondary btn-sm">
                                                        ทำรายการ
                                                    </button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu">

                                                        @if ($item->warehouse_rep_status == 'recieve'  && $item->warehouse_rep_send == '')

                                                            <button class="dropdown-item text-warning" style="font-size:13px" data-bs-toggle="modal" data-bs-target=".editModal{{ $item->warehouse_rep_id }}">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-warning" style="font-size:13px"></i>
                                                                <span>แก้ไขบิล</span>
                                                            </button>
                                                            <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-success"
                                                                    href="{{ url('warehouse_add_product/' . $item->warehouse_rep_id) }}"
                                                                    style="font-size:13px" target="blank">
                                                                    <i class="fa-solid fa-clipboard-check me-2 text-success"
                                                                        style="font-size:13px"></i>
                                                                    <span>เพิ่มรายการ</span>
                                                                </a>

                                                                    {{-- <a class="dropdown-item text-info"
                                                                    href="{{ url('warehouse_edit_product/' . $item->warehouse_rep_id) }}"
                                                                    style="font-size:13px" target="blank">
                                                                    <i class="fa-solid fa-clipboard-check me-2 text-info"
                                                                        style="font-size:13px"></i>
                                                                    <span>เพิ่ม/แก้ไขรายการวัสดุ</span>
                                                                </a> --}}
                                                        @else
                                                        @endif

                                                        @if ($item->warehouse_rep_status == 'beforallow')
                                                            {{-- <a class="dropdown-item"
                                                                href="{{ url('warehouse/warehouse_addsub/' . $item->warehouse_rep_id) }}"
                                                                style="color: rgb(5, 173, 134);font-size:13px">
                                                                <i class="fa-solid fa-square-check me-2"
                                                                    style="color: rgb(5, 173, 134);font-size:14px"></i>
                                                                <span>เพิ่มรายการที่ส่งไม่ครบ</span>
                                                            </a> --}}

                                                        @else
                                                        @endif

                                                        @if ($item->warehouse_rep_status == 'recieve' && $item->warehouse_rep_send == 'WAIT')
                                                            <a class="dropdown-item text-success"
                                                                href="{{ url('warehouse_add_product/' . $item->warehouse_rep_id) }}"
                                                                style="font-size:13px" target="blank">
                                                                <i class="fa-solid fa-clipboard-check me-2 text-success"
                                                                    style="font-size:13px"></i>
                                                                <span>เพิ่มรายการ</span>
                                                            </a>

                                                        @else
                                                        @endif

                                                        @if ($item->warehouse_rep_status == 'recieve' && $item->warehouse_rep_send == 'STALE')
                                                            {{-- <div class="dropdown-divider"></div> --}}
                                                            {{-- <a class="dropdown-item text-success"
                                                                href="javascript:void(0)"
                                                                onclick="warehouse_confirmbefor({{ $item->warehouse_rep_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-clipboard-check me-2 text-success"
                                                                    style="font-size:13px"></i>
                                                                <span>ยืนยันรับเข้าคลังกรณีไม่ครบ</span>
                                                            </a>
                                                            <div class="dropdown-divider"></div> --}}

                                                        @else
                                                        @endif

                                                        @if ($item->warehouse_rep_send == 'STALE' || $item->warehouse_rep_send == '')

                                                        @elseif ($item->warehouse_rep_send == 'FINISH' && $item->warehouse_rep_status == 'recieve')
                                                        <a class="dropdown-item text-info"
                                                        href="{{ url('warehouse_edit_product/' . $item->warehouse_rep_id) }}"
                                                        style="font-size:13px" target="blank">
                                                        <i class="fa-solid fa-clipboard-check me-2 text-info"
                                                            style="font-size:13px"></i>
                                                        <span>เพิ่ม/แก้ไขรายการวัสดุ</span>
                                                    </a>
                                                        <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-primary"
                                                                href="javascript:void(0)"
                                                                onclick="warehouse_confirm_recieve({{ $item->warehouse_rep_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-clipboard-check me-2 text-primary"
                                                                    style="font-size:13px"></i>
                                                                <span>ยืนยันรับเข้าคลัง</span>
                                                            </a>

                                                        @else
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

                                        <!-- Modal Edit-->
                                        <div class="modal fade editModal{{ $item->warehouse_rep_id }}" id="editModal" tabindex="-1" role="dialog" aria-pledby="editModalp" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalp">แก้ไขบิล</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-p="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('ware.warehouse_billupdate') }}" method="POST" id="Wbillupdate" enctype="multipart/form-data">
                                                            @csrf

                                                            <input id="warehouse_rep_id" type="hidden" name="warehouse_rep_id" value="{{ $item->warehouse_rep_id }}">
                                                            <input id="warehouse_rep_code" type="hidden" name="warehouse_rep_code" value="{{ $item->warehouse_rep_code }}">
                                                            <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">
                                                            <input type="hidden" name="warehouse_rep_user_id" id="warehouse_rep_user_id" value="{{ Auth::user()->id }}">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-1">
                                                                            <p for="warehouse_rep_no_bill">เลขที่บิล :</p>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                <input id="warehouse_rep_no_bill" type="text"
                                                                                    class="form-control-sm form-control" name="warehouse_rep_no_bill" value="{{ $item->warehouse_rep_no_bill }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1 ">
                                                                            <p for="warehouse_rep_po">เลขที่ PO :</p>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                <input id="warehouse_rep_po" type="text"
                                                                                    class="form-control-sm form-control" name="warehouse_rep_po" value="{{ $item->warehouse_rep_po }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 text-end">
                                                                            <p for="warehouse_rep_year">ปีงบ :</p>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="form-group">
                                                                                <input id="warehouse_rep_year2" type="text" class="form-control-sm form-control" name="warehouse_rep_year" value="{{$item->warehouse_rep_year}}" readonly>
                                                                                {{-- <select id="warehouse_rep_year_edit" name="warehouse_rep_year"
                                                                                    class="form-select form-select-lg" style="width: 100%">
                                                                                    @foreach ($budget_year as $ye)
                                                                                        @if ($ye->leave_year_id == $item->warehouse_rep_year)
                                                                                            <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }} </option>
                                                                                        @else
                                                                                            <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-2">
                                                                            <p for="warehouse_rep_inven_id">รับเข้าคลัง :</p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <select id="warehouse_rep_inven_id_edit" name="warehouse_rep_inven_id"
                                                                                    class="form-select form-select-lg" style="width: 100%">
                                                                                    <option value="">--เลือก--</option>
                                                                                    @foreach ($warehouse_inven as $inven)
                                                                                    @if ($inven->warehouse_inven_id == $item->warehouse_rep_inven_id)
                                                                                        <option value="{{ $inven->warehouse_inven_id }}" selected> {{ $inven->warehouse_inven_name }} </option>
                                                                                    @else
                                                                                        <option value="{{ $inven->warehouse_inven_id }}"> {{ $inven->warehouse_inven_name }} </option>
                                                                                    @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 text-end">
                                                                            <p for="warehouse_rep_vendor_id">รับจาก :</p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <select id="warehouse_rep_vendor_id_edit" name="warehouse_rep_vendor_id"
                                                                                    class="form-select form-select-lg" style="width: 100%">
                                                                                    <option value="">--เลือก--</option>
                                                                                    @foreach ($products_vendor as $ven)
                                                                                    @if ($ven->vendor_id == $item->warehouse_rep_vendor_id)
                                                                                        <option value="{{ $ven->vendor_id }}" selected> {{ $ven->vendor_name }} </option>
                                                                                    @else
                                                                                        <option value="{{ $ven->vendor_id }}"> {{ $ven->vendor_name }} </option>
                                                                                    @endif

                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <input class="form-control form-control-sm" type="hidden" id="example-datetime-local-input" name="warehouse_rep_date"
                                                                            value="{{ $datefull }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                            <i class="pe-7s-diskette btn-icon-wrapper"></i>Update Data
                                                        </button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <!--  Modal content for the above example -->
                                        <div class="modal fade detail{{ $item->warehouse_rep_id }}" tabindex="-1"
                                            role="dialog" aria-pledby="myExtraLargeModalp" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myExtraLargeModalp">
                                                            รายละเอียดการตรวจรับ</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-p="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="col-md-1">
                                                                <p for="warehouse_rep_code">เลขที่รับ </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_code }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <p for="warehouse_rep_no_bill">เลขที่บิล </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_no_bill }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 ">
                                                                <p for="warehouse_rep_po">เลขที่ PO </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_po }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <p for="warehouse_rep_year">ปีงบ </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_year }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mt-3">
                                                            <div class="col-md-1">
                                                                <p for="warehouse_rep_user_id">ผู้รับ </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_user_name }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <p for="warehouse_rep_inven_id">รับเข้าคลัง </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_inven_name }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <p for="warehouse_rep_vendor_id">รับจาก </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_vendor_name }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <p for="">วันที่รับ </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <p
                                                                        for="warehouse_rep_code">{{ $item->warehouse_rep_date }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <div class="row bg-info">
                                                            <div class="col-md-2 text-center"> <p for=""
                                                                    style="color:white;font-size:17xp">รหัสวัสดุ</p>
                                                            </div>
                                                            <div class="col-md-3 text-center"> <p for=""
                                                                    style="color:white;font-size:17xp">รายการวัสดุ</p>
                                                            </div>
                                                            <div class="col-md-1 text-center"> <p for=""
                                                                    style="color:white;font-size:17xp">หน่วยนับ</p>
                                                            </div>
                                                            <div class="col-md-1 text-center"> <p for=""
                                                                    style="color:white;font-size:17xp">ประเภท</p></div>
                                                            <div class="col-md-1 text-center"> <p for=""
                                                                    style="color:white;font-size:17xp">จำนวน</p></div>
                                                            <div class="col-md-2 text-center"> <p for=""
                                                                    style="color:white;font-size:17xp">ราคา</p></div>
                                                            <div class="col-md-2 text-center"> <p for=""
                                                                    style="color:white;font-size:17xp">ราคารวม</p>
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
                                                            {{-- <p for="">{{ number_format(($item->sum_price),2 )}}</p> --}}
                                                            <p for=""
                                                                class="me-4">ราคารวมทั้งหมด</p><p
                                                                for=""> <b style="color: red;font-size:17px">
                                                                    {{ number_format($total, 5) }} </b> </p><p
                                                                for="" class="ms-4"> บาท</p>
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
                        {{-- </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-pledby="exampleModalp"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalp">ออกบิล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-p="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('ware.warehouse_billsave') }}" method="POST" id="Wbillsave" enctype="multipart/form-data">
                        @csrf

                        <input id="warehouse_rep_code" type="hidden" name="warehouse_rep_code" value="{{ $refnumber }}">
                        <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">
                        <input type="hidden" name="warehouse_rep_user_id" id="warehouse_rep_user_id" value="{{ Auth::user()->id }}">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">
                                        <p for="warehouse_rep_no_bill">เลขที่บิล :</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_no_bill" type="text"
                                                class="form-control-sm form-control" name="warehouse_rep_no_bill">
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <p for="warehouse_rep_po">เลขที่ PO :</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_po" type="text"
                                                class="form-control-sm form-control" name="warehouse_rep_po">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <p for="warehouse_rep_year">ปีงบ :</p>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="warehouse_rep_year2" type="text" class="form-control-sm form-control" name="warehouse_rep_year" value="{{$yearnow}}">
                                            {{-- <select id="warehouse_rep_year" name="warehouse_rep_year"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($budget_year as $ye)
                                                    @if ($ye->leave_year_id == $date)
                                                        <option value="{{ $ye->leave_year_id }}" selected> {{ $ye->leave_year_id }} </option>
                                                    @else
                                                        <option value="{{ $ye->leave_year_id }}"> {{ $ye->leave_year_id }}</option>
                                                    @endif
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <p for="warehouse_rep_inven_id">รับเข้าคลัง :</p>
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
                                        <p for="warehouse_rep_vendor_id">รับจาก :</p>
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
                                    <input class="form-control form-control-sm" type="hidden" id="example-datetime-local-input" name="warehouse_rep_date"
                                        value="{{ $datefull }}">

                                </div>


                            </div>
                        </div>

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
        $(document).ready(function() {
            $('#warehouse_rep_year').select2({
                dropdownParent: $('#exampleModal')
            });
            // $('#warehouse_rep_user_id').select2({
            //     dropdownParent: $('#exampleModal')
            // });
            $('#warehouse_rep_inven_id').select2({
                dropdownParent: $('#exampleModal')
            });
            $('#warehouse_rep_vendor_id').select2({
                dropdownParent: $('#exampleModal')
            });

            $('#warehouse_rep_year_edit').select2({
                dropdownParent: $('#editModal')
            });
            $('#warehouse_rep_inven_id_edit').select2({
                dropdownParent: $('#editModal')
            });
            $('#warehouse_rep_vendor_id_edit').select2({
                dropdownParent: $('#editModal')
            });
        });



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
            $('#Wbillsave').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 100) {
                            Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับเข้าคลัง...!!',
                                text: 'กรุณาเลือกรับเข้าคลังอะไร!',
                            }).then((result) => {
                                if (result.isConfirmed) {}
                            })
                        } else if (data.status == 150) {
                            Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับจาก...!!',
                                text: 'กรุณาเลือกรับจากตัวแทนจำหน่ายอะไร!',
                            }).then((result) => {
                                if (result.isConfirmed) {

                                }
                            })
                        } else if (data.status == 500) {
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
                                    window.location =
                                        "{{ url('warehouse/warehouse_index') }}";
                                }
                            })
                        }
                    }
                });
            });

            $('#Wbillupdate').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 100) {
                            Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับเข้าคลัง...!!',
                                text: 'กรุณาเลือกรับเข้าคลังอะไร!',
                            }).then((result) => {
                                if (result.isConfirmed) {}
                            })
                        } else if (data.status == 150) {
                            Swal.fire({
                                icon: 'error',
                                title: 'คุณยังไม่ได้เลือกรับจาก...!!',
                                text: 'กรุณาเลือกรับจากตัวแทนจำหน่ายอะไร!',
                            }).then((result) => {
                                if (result.isConfirmed) {

                                }
                            })
                        } else if (data.status == 500) {
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
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Update data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location =
                                        "{{ url('warehouse/warehouse_index') }}";
                                }
                            })
                        }
                    }
                });
            });
        });
    </script>


@endsection
