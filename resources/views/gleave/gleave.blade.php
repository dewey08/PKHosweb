@extends('layouts.gleave')
@section('title', 'PK-OFFICER || ระบบลา')

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
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-xl-12">
                        <form action="{{ route('ot.otonesearch') }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- <div class="col"></div> --}}
                                <div class="col-md-1 text-end">วันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="startdate" id="datepicker"
                                            data-date-container='#datepicker1' data-provide="datepicker"
                                            data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $start }}">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">ถึงวันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="enddate" id="datepicker2"
                                            data-date-container='#datepicker1' data-provide="datepicker"
                                            data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $end }}">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">ประเภท</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <select id="ot_type_pk" name="ot_type_pk" class="form-select form-select-lg"
                                            style="width: 100%">
                                            {{-- @foreach ($ot_type_pk as $reqshow)
                                                @if ($reqsend == $reqshow->ot_type_pk_id)
                                                    <option value="{{ $reqshow->ot_type_pk_id }}" selected>
                                                        {{ $reqshow->ot_type_pkname }} </option>
                                                @else
                                                    <option value="{{ $reqshow->ot_type_pk_id }}">
                                                        {{ $reqshow->ot_type_pkname }} </option>
                                                @endif
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-magnifying-glass text-white me-2"></i>
                                        ค้นหา
                                    </button>
                                </div>
                                 
                        </form>
                    </div>
                </div>

            </div>
        </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <div class="d-flex">
                            <div class="p-2">
                                <label for="">ตรวจสอบข้อมูลการลา</label>
                            </div>
                            <div class="ms-auto p-2">
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;"
                                id="example2">
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
                                    {{-- @foreach ($article_data as $item)
                                    <tr id="sid{{ $item->article_id }}">
                                        <td class="text-center" width="4%">{{ $i++ }}</td>
                                        <td class="p-2" width="20%">{{ $item->article_num }} </td>
                                        <td class="p-2">{{ $item->article_name }}</td>
                                        <td class="p-2" width="15%">{{ $item->article_decline_name }}</td>
                                        <td class="p-2" width="15%">{{ $item->article_categoryname }}</td>
                                        <td class="p-2" width="17%">{{ $item->article_deb_subsub_name }}</td>
                                        <td class="text-center" width="10%">
                                            
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
                                @endforeach --}}
                                </tbody>
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
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#example3').DataTable();

        $('select').select2();
        $('#ECLAIM_STATUS').select2({
            dropdownParent: $('#detailclaim')
        });

        $('#users_group_id').select2({
            placeholder: "--เลือก-- ",
            allowClear: true
        });

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        // $(document).on('click', '.add_color', function() {
        //     var user_id = $(this).val(); 
        //     $('#add_color').modal('show');
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ url('otone_add_color') }}" + '/' + user_id,
        //         success: function(data) {
        //             $('#user_id').val(data.users_color.id)

        //         },
        //     });

        // $('#saveBtn').click(function() { 
        //     var color_ot = $('#color_ot').val();
        //     var user_id = $('#user_id').val(); 
        //     $.ajax({
        //         url: "{{ route('ot.otone_updatecolor') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         data: {
        //             color_ot,
        //             user_id
        //         },
        //         success: function(data) {
        //             if (data.status == 200) { 
        //                 Swal.fire({
        //                     title: 'บันทึกข้อมูลสำเร็จ',
        //                     text: "You Insert data success",
        //                     icon: 'success',
        //                     showCancelButton: false,
        //                     confirmButtonColor: '#06D177',
        //                     confirmButtonText: 'เรียบร้อย'
        //                 }).then((result) => {
        //                     if (result
        //                         .isConfirmed) {
        //                         console.log(
        //                             data);

        //                         window.location
        //                             .reload();
        //                     }
        //                 })
        //             } else {

        //             }

        //         },
        //     });
        // });
        });

        // $(document).on('click', '.edit_data', function() {
        //     var ot_one_id = $(this).val(); 
        //     $('#updteModal').modal('show');
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ url('otone_edit') }}" + '/' + ot_one_id,
        //         success: function(data) {
        //             $('#editot_one_starttime').val(data.ot.ot_one_starttime)
        //             $('#editot_one_endtime').val(data.ot.ot_one_endtime)
        //             $('#editot_one_date').val(data.ot.ot_one_date)
        //             $('#editot_one_detail').val(data.ot.ot_one_detail) 
        //             $('#editot_one_id').val(data.ot.ot_one_id)
        //         },
        //     });
        // });

        // $('#updateBtn').click(function() {
        //     var ot_one_starttime = $('#editot_one_starttime').val();
        //     var ot_one_endtime = $('#editot_one_endtime').val();
        //     var ot_one_date = $('#editot_one_date').val();
        //     var ot_one_detail = $('#editot_one_detail').val();
        //     var user_id = $('#edituser_id').val();
        //     var ot_one_id = $('#editot_one_id').val();

        //     $.ajax({
        //         url: "{{ route('ot.otone_update') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         data: {
        //             ot_one_id,
        //             ot_one_detail,
        //             ot_one_date,
        //             ot_one_starttime,
        //             ot_one_endtime,
        //             user_id
        //         },
        //         success: function(data) {
        //             if (data.status == 200) {
        //                 Swal.fire({
        //                     title: 'แก้ไขข้อมูลสำเร็จ',
        //                     text: "You edit data success",
        //                     icon: 'success',
        //                     showCancelButton: false,
        //                     confirmButtonColor: '#06D177',
        //                     confirmButtonText: 'เรียบร้อย'
        //                 }).then((result) => {
        //                     if (result
        //                         .isConfirmed) {
        //                         console.log(
        //                             data);

        //                         window.location
        //                             .reload();
        //                     }
        //                 })
        //             } else {

        //             }

        //         },
        //     });
        // });



        });
    </script>

@endsection
