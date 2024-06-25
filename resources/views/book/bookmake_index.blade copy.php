@extends('layouts.book')
@section('title', 'PK-OFFICER || งานสารบรรณ')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>

    <script>
        function bookmake_destroy(bookrep_id) {
            // alert(bookrep_id);
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "delete",
                        url: "{{ url('bookmake_destroy') }}" + '/' + bookrep_id,
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
                                    $("#sid" + bookrep_id).remove();
                                    window.location.reload();
                                    // window.location = "/book/bookmake_index"; //   

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
        #zoom-in {}
        #zoom-percent {
            display: inline-block;
        }
        #zoom-percent::after {
            content: "%";
        }
        #zoom-out {}
        .fpdf {
            /* width:1024px; */
            height: 650px;
            width: 1024px;
            /* height:auto; */
            margin: 0;

            overflow: scroll;
            background-color: #DAD8D8;
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

        .hrow {
            height: 2px;
            margin-bottom: 9px;
        }
    </style>

    <div class="container-fluids">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example">
                                <thead>
                                    <tr>
                                        <th width="3%" class="text-center">ลำดับ</th>
                                        <th class="text-center" width="7%">ชั้นความเร็ว</th>
                                        <th class="text-center" width="7%">สถานะ</th>
                                        <th class="text-center" width="10%">สถานะส่ง</th>
                                        <th class="text-center">เรื่อง</th>
                                        <th class="text-center" width="9%">วันที่</th>
                                        <th class="text-center" width="9%">เวลา</th>
                                        <th class="text-center" width="10%">ผู้ส่ง</th>
                                        <th width="7%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $date = date('Y'); ?>
                                    @foreach ($bookrep as $item)
                                        <tr id="sid{{ $item->bookrep_id }}">
                                            <td class="text-center" width="3%">{{ $i++ }}</td>
                                            @if ($item->bookrep_speed_class_id == '4')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-danger shadow">
                                                        {{ $item->bookrep_speed_class_name }}</div>
                                                </td>
                                            @elseif ($item->bookrep_speed_class_id == '2')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-success shadow">
                                                        {{ $item->bookrep_speed_class_name }}</div>
                                                </td>
                                            @elseif ($item->bookrep_speed_class_id == '1')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-info shadow">{{ $item->bookrep_speed_class_name }}
                                                    </div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-warning shadow">
                                                        {{ $item->bookrep_speed_class_name }}</div>
                                                </td>
                                            @endif


                                            @if ($item->bookrep_send_code == 'waitsend')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-info shadow"> รอดำเนินการ</div>
                                                </td>
                                            @elseif ($item->bookrep_send_code == 'senddep')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-warning shadow">ส่งหน่วยงาน</div>
                                                </td>
                                            @elseif ($item->bookrep_send_code == 'waitretire')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-primary shadow">รอเกษียณ</div>
                                                </td>
                                            @elseif ($item->bookrep_send_code == 'retire')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-success shadow">เกษียณ</div>
                                                </td>
                                            @elseif ($item->bookrep_send_code == 'waitallows')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-secondary shadow">เสนอ ผอ.</div>
                                                </td>
                                            @elseif ($item->bookrep_send_code == 'allows')
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-success shadow">ผอ.อนุมัติ</div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="7%">
                                                    <div class="badge bg-dark shadow">ลงรับ</div>
                                                </td>
                                            @endif

                                            @if ($item->bookrep_send_status_code == 'waitsend')
                                                <td class="font-weight-medium text-center" width="8%">
                                                    <div class="badge bg-info shadow"> รอดำเนินการ</div>
                                                </td>
                                            @elseif ($item->bookrep_send_status_code == 'senddep')
                                                <td class="font-weight-medium text-center" width="8%">
                                                    <div class="badge bg-warning shadow">ส่งหน่วยงาน</div>
                                                </td>
                                            @else
                                                <td class="font-weight-medium text-center" width="8%">
                                                    <div class="badge bg-primary shadow">ลงรับ</div>
                                                </td>
                                            @endif

                                            <td class="p-2">{{ $item->bookrep_name }}</td>
                                            <td class="p-2" width="9%">{{ dateThai($item->bookrep_save_date) }} </td>
                                            <td class="p-2" width="9%"> {{ $item->bookrep_save_time }} น.</td>

                                            <td class="p-2" width="10%">{{ $item->bookrep_usersend_name }}</td>
                                            <td class="text-center" width="7%">

                                                <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#"
                                                        id="dropdownMenuLink" data-mdb-toggle="dropdown"
                                                        aria-expanded="false">
                                                        ทำรายการ
                                                    </button>
                                                    <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                        <!-- <li>
                                                          <a href="{{ url('book/book_send_email/' . $item->bookrep_id) }}" class="text-primary me-3 " data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="ส่งอีเมล์" >
                                                            <i class="fa-solid fa-envelope-open-text me-2 mt-3 ms-4"></i>
                                                            <label for="" style="color: black">ส่งอีเมล์</label>
                                                          </a>
                                                        </li> -->
                                                        <li>
                                                            <a href="{{ url('book/bookmake_index_send/' . $item->bookrep_id) }}"
                                                                class="text-primary me-3" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                data-bs-custom-class="custom-tooltip" title="ส่งหนังสือ">
                                                                <i class="fa-solid fa-paper-plane me-2 mt-3 ms-4"></i>
                                                                <label for=""
                                                                    style="color: black">ส่งหนังสือ</label>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('book/bookmake_index_edit/' . $item->bookrep_id) }}"
                                                                class="text-warning me-3" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                data-bs-custom-class="custom-tooltip" title="แก้ไข"> 
                                                                <i class="bi bi-pencil-square me-2 mt-2 ms-2"></i>
                                                                <label for=""
                                                                    style="color: rgb(238, 147, 10)">แก้ไข</label>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="text-danger" href="javascript:void(0)"
                                                                onclick="bookmake_destroy({{ $item->bookrep_id }})">
                                                                <i class="fa-solid fa-trash-can me-2 mt-2 ms-2 mb-2"></i>
                                                                <label for=""
                                                                    style="color: rgb(255, 22, 22)">ลบ</label>
                                                            </a>
                                                            
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="btn-group">
                                                  <button type="button"
                                                      class="btn btn-outline-secondary btn-sm"
                                                      data-bs-toggle="dropdown" aria-expanded="false">
                                                      ทำรายการ
                                                      <i class="mdi mdi-chevron-down"></i>
                                                  </button>
                                                  <div class="dropdown-menu">
                                                      <a class="dropdown-item text-primary"
                                                          href="{{ url('book/bookmake_index_send/' . $item->bookrep_id) }}"
                                                          data-bs-toggle="tooltip" data-bs-placement="left"
                                                          data-bs-custom-class="custom-tooltip" title="ส่งหนังสือ">
                                                          <i class="fa-solid fa-paper-plane me-2"></i>
                                                          <label for=""
                                                              style="color: rgb(23, 92, 241);font-size:13px">ส่งหนังสือ</label>
                                                      </a>

                                                      <a class="dropdown-item text-warning"
                                                      href="{{ url('book/bookmake_index_edit/' . $item->bookrep_id) }}"
                                                      data-bs-toggle="tooltip" data-bs-placement="left"
                                                      data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                      <i class="fa-solid fa-pen-to-square me-2"></i>
                                                      <label for=""
                                                          style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                  </a>

                                                      <div class="dropdown-divider"></div>
                                                      <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                          onclick="bookmake_destroy({{ $item->bookrep_id }})"
                                                          data-bs-toggle="tooltip" data-bs-placement="left"
                                                          data-bs-custom-class="custom-tooltip" title="ลบ">
                                                          <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                          <label for=""
                                                              style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                      </a>
                                                  </div>
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

@endsection
@section('footer')



@endsection
