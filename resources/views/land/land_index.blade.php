@extends('layouts.article')
@section('title', 'PK-OFFICER || ข้อมูลที่ดิน')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function land_destroy(land_id) {
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
                        url: "{{ url('land/land_destroy') }}" + '/' + land_id,
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
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + land_id).remove();
                                    // window.location.reload(); 
                                    window.location = "{{ url('land/land_index') }}";
                                }
                            })
                        }
                    })
                }
            })
        }
    </script>
    <?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_land = StaticController::count_land();
    $count_building = StaticController::count_building();
    $count_article = StaticController::count_article();
    ?>


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
    <?php
    use App\Http\Controllers\LandController;
    $refnumber = LandController::refnumber();
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
        <div class="row ">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header ">
                        <div class="d-flex">
                            <div class="">
                                <label for="">ข้อมูลที่ดิน</label>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ url('land/land_index_add') }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-folder-plus text-white me-2"></i>
                                    เพิ่มข้อมูลที่ดิน
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="card-body shadow">

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example">
                                <thead>
                                    <tr height="10px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th width="15%" class="text-center">หมายเลขระวาง</th>
                                        <th width="15%" class="text-center">เลขที่</th>
                                        <th width="15%" class="text-center">เลขโฉนดที่ดิน</th>
                                        <th width="15%" class="text-center">หน้าสำรวจ</th>
                                        <th width="15%" class="text-center">วันที่ถือครอง</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $date = date('Y');
                                    ?>
                                    @foreach ($land_data as $item)
                                        <tr id="sid{{ $item->land_id }}">
                                            <td class="text-center" width="5%">{{ $i++ }}</td>
                                            <td class="p-2">{{ $item->land_tonnage_number }} </td>
                                            <td class="p-2">{{ $item->land_no }}</td>
                                            <td class="p-2">{{ $item->land_tonnage_no }}</td>
                                            <td class="p-2">{{ $item->land_explore_page }}</td>
                                            <td class="text-center" width="15%">{{ DateThai($item->land_date) }}</td>
                                            <td class="text-center" width="10%">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        ทำรายการ
                                                        <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning"
                                                            href="{{ url('land/land_index_edit/' . $item->land_id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for=""
                                                                style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>

                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="land_destroy({{ $item->land_id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-custom-class="custom-tooltip" title="ลบ">
                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                            <label for=""
                                                                style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                           
                                                              <li>
                                                                <a href="{{ url('land/land_index_edit/' .$item->land_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)"  onclick="land_destroy({{ $item->land_id }})">
                                                                  <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                  <label for="" style="color: black">ลบ</label>
                                                                </a> 
                                                              </li>

                                                        </ul>
                                                </div>                                                     --}}
                                            </td>

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


    @endsection
