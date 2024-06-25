@extends('layouts.meettingnew')
@section('title', 'PK-OFFICER || ห้องประชุม')

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

        function room_listdestroy(room_list_id) {
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
                        url: "{{ url('meetting/room_listdestroy') }}" + '/' + room_list_id,
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
                                    $("#sid" + room_list_id).remove();
                                    window.location.reload();
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

        .form-control {
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
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h6>เพิ่มอุปกรณ์</h6>
                    </div>
                    <div class="card-body shadow-lg">


                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    @if ($dataedits->room_img == null)
                                        <img src="{{ asset('assets/images/default-image.JPG') }}" id="edit_upload_preview"
                                            height="450px" width="350px" alt="Image" class="img-thumbnail">
                                    @else
                                        <img src="{{ asset('storage/meetting/' . $dataedits->room_img) }}"
                                            id="edit_upload_preview" height="450px" width="350px" alt="Image"
                                            class="img-thumbnail">
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-8">
                                <form action="{{ route('meetting.meettingroom_index_toolsave') }}" method="POST"
                                    id="insert_roomtoolForm" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" id="room_id" name="room_id" class="form-control"
                                        value="{{ $dataedits->room_id }}" />
                                    <input type="hidden" name="store_id" id="store_id"
                                        value=" {{ Auth::user()->store_id }}">

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="room_type">รายการอุปกรณ์:</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input id="room_list_name" type="text" class="form-control"
                                                name="room_list_name" required>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="room_type">จำนวน:</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="room_list_qty" type="text" class="form-control"
                                                    name="room_list_qty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                                เพิ่ม
                                            </button>
                                            <a href="{{ url('meetting/meettingroom_index') }}"
                                                class="btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                                ยกเลิก
                                            </a>
                                        </div>
                                    </div>
                                    <hr>

                                </form>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered table-sm myTable"
                                                    style="width: 100%;" id="example2">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%" class="text-center">ลำดับ</th>
                                                            <th class="p-2">รายการอุปกรณ์</th>
                                                            <th class="text-center" width="15%">จำนวน</th>
                                                            <th width="5%" class="text-center">ลบ</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        @foreach ($roomlists as $itemlist)
                                                            <tr id="sid{{ $itemlist->room_list_id }}">
                                                                <td class="text-center" width="3%">{{ $i++ }}
                                                                </td>
                                                                <td class="p-2">{{ $itemlist->room_list_name }}</td>
                                                                <td class="text-center" width="15%">
                                                                    {{ $itemlist->room_list_qty }}</td>

                                                                <td class="text-center" width="5%">
                                                                    <a class="text-danger" href="javascript:void(0)"
                                                                        onclick="room_listdestroy({{ $itemlist->room_list_id }})"
                                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                        data-bs-custom-class="custom-tooltip"
                                                                        title="ลบ">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </a>
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


                </div>
            </div>
        </div>
    </div>
    </div>


@endsection
