@extends('layouts.com')
@section('title', 'PK-OFFICER || แจ้งซ่อมคอมพิวเตอร์')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function com_techdestroy(com_tec_id) {
            // alert(bookrep_id);
            Swal.fire({
                title: 'ต้องการลบข้อมูลใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('computer/com_techdestroy') }}" + '/' + com_tec_id,
                        success: function(response) {
                            Swal.fire({
                                title: 'ลบข้อมูลสำเร็จ !!',
                                text: "Delete Data Success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177', 
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {

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
    use App\Http\Controllers\UsercarController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    
    $refnumber = UsercarController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
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
        {{-- <div class="row justify-content-center">
            <div class="row invoice-card-row">
                <div class="col-md-12 mt-2">
                    <div class="card bg-secondary p-1 mx-0 shadow-lg">
                        <div class="panel-header px-3 py-2 text-white">
                            <div class="d-flex">
                                <div class="p-2">{{ __('ช่างซ่อมคอมพิวเตอร์') }} </div>
                                <div class="ms-auto p-2">
                                    <a href="" class="btn btn-white btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#comdetailModal">
                                        <i class="fa-solid fa-user-plus text-secondary me-2"></i>
                                        เพิ่มช่างซ่อม</a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row justify-content-center">
                            <div class="row invoice-card-row">
                                <div class="col-md-12"> 
                                    <div class="card shadow">
                                        <div class="card-header ">
                                            <div class="d-flex">
                                                <div class="p-2" style="font-size: 14px">{{ __('ช่างซ่อมคอมพิวเตอร์') }} </div>
                                                
                                                <div class="ms-auto p-2">
                                                    <a href="" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#comdetailModal">
                                                    <i class="fa-solid fa-user-plus text-secondary me-2"></i>
                                                    เพิ่มช่างซ่อม</a>
                                                </div>
                                            </div>
                                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-sm myTable "
                                            style="width: 100%;" id="example">
                                            <thead>
                                                <tr height="10px">
                                                    <th width="7%">ลำดับ</th>
                                                    <th>ชื่อ-สกุล</th>
                                                    <th width="35%">ตำแหน่ง</th>
                                                    <th width="10%">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($com_tec as $item)
                                                    <tr id="sid{{ $item->com_tec_id }}" height="30">
                                                        <td class="text-center" width="3%">{{ $i++ }}</td>
                                                        <td class="p-2">{{ $item->fname }} {{ $item->lname }}</td>
                                                        <td class="p-2" width="35%">{{ $item->POSITION_NAME }}</td>
                                                        <td class="text-center" width="10%">
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle menu"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">ทำรายการ</button>
                                                                <ul class="dropdown-menu">
                                                                    <a class="dropdown-item menu" href="javascript:void(0)"
                                                                        onclick="com_techdestroy({{ $item->com_tec_id }})"
                                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                                        title="ลบ">

                                                                        <i
                                                                            class="fa-solid fa-xmark me-2 mt-2 ms-2 mb-2 text-danger"></i>
                                                                        <label for=""
                                                                            style="color: rgb(255, 22, 22)">ลบ</label>
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
        </div>
    </div>


    <div class="modal fade" id="comdetailModal" tabindex="-1" aria-labelledby="comdetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comdetailModalLabel">เพิ่มช่างซ่อมคอมพิวเตอร์ </h5>

                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-2 ">
                            <label for=""><b>ชื่อ-นามสกุล :</b></label>
                        </div>
                        <div class="col-md-9">
                            <select id="com_tec_user_id" name="com_tec_user_id" class="form-control" multiple="multiple"
                                style="width: 100%;">
                                @foreach ($users as $ust)
                                    <option value=""></option>
                                    <option value="{{ $ust->id }}">{{ $ust->fname }} {{ $ust->lname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="saveBtn" class="btn btn-primary btn-sm me-2">
                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                        บันทึกข้อมูล
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ปิด
                    </button>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            $('select').select2();
            $('#com_tec_user_id').select2({
                dropdownParent: $('#comdetailModal')
            });

            $('#saveBtn').click(function() {
                // alert('okkkkk');
                var com_tec_user_id = $('#com_tec_user_id').val(); // aray mutiselect2

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('com.com_tech_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        com_tec_user_id
                    },
                    success: function(data) {
                        if (data.status == 100) {

                            Swal.fire(
                                'รายชื่อนี้ถูกเพิ่มไปแล้ว !',
                                'You clicked the button !',
                                'warning'
                            )
                        } else {
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
                                    window.location.reload();
                                }
                            })
                        }
                    },
                });
            });

        });
    </script>



@endsection
