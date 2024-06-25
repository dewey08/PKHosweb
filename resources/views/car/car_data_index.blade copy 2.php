@extends('layouts.car')
@section('title', 'PK-OFFICER || ยานพาหนะ')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function car_destroy(article_id) {
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
                        url: "{{ url('car/car_destroy') }}" + '/' + article_id,
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
                                    $("#sid" + article_id).remove();
                                    window.location.reload();
                                    // window.location = "/car/car_data_index"; //     
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
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        {{-- <form action="{{ url('account_money_rep/'.$id) }}" method="POST">
                            @csrf --}}
                        <div class="row">
                            <div class="col-md-2 text-left">
                                <h6>ข้อมูลยานพาหนะ</h6>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-1 text-end">หมวดครุภัณฑ์</div>
                            <div class="col-md-3 text-center">
                                <div class="input-group" > 
                                   <select id="category_id" name="category_id" class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                    @foreach ($product_category as $cat)
                                        <option value="{{ $cat->category_id }}"> {{ $cat->category_name }} </option>
                                    @endforeach
                            </select>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                                    ค้นหา
                                </button>
                            </div>


                            <div class="col-md-2 text-end">
                                {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#insertuserdata"> 
                                        เพิ่มเจ้าหน้าที่
                                    </button> --}}
                                <a href="{{ url('car/car_data_index_add') }}" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-car-on text-primary me-2"></i>
                                    เพิ่มข้อมูลยานพาหนะ
                                </a>
                            </div>

                            {{-- <div class="col-md-1 text-start">
                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#copydata"> 
                                        คัดลอกข้อมูลเดิม
                                    </button>
                                </div> --}}
                        </div>

                    </div>
                    {{-- </form> --}}
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example">
                                <thead>
                                    <tr>
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
                                    $date = date('Y'); ?>
                                    @foreach ($article_data as $item)
                                        <tr id="sid{{ $item->article_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="p-2" width="13%">{{ $item->article_num }} </td>
                                            <td class="p-2">{{ $item->article_name }}</td>
                                            <td class="p-2" width="15%">{{ $item->article_decline_name }}</td>
                                            <td class="p-2" width="15%">{{ $item->article_categoryname }}</td>
                                            <td class="p-2" width="20%">{{ $item->article_deb_subsub_name }}</td>
                                            <td class="text-center" width="10%">
                                                {{-- <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                              <li>
                                                                <a href="{{ url('car/car_data_index_edit/' .$item->article_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)" onclick="car_destroy({{ $item->article_id }})">
                                                                  <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                  <label for="" style="color: black">ลบ</label>
                                                                </a> 
                                                              </li>

                                                        </ul>
                                                </div> --}}
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle menu"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ url('car/car_data_index_edit/' . $item->article_id) }}"
                                                                class="dropdown-item menu" data-bs-toggle="tooltip"
                                                                data-bs-placement="left" title="แก้ไข">
                                                                <i
                                                                    class="fa-solid fa-pen-to-square mt-2 ms-2 mb-2 me-2 text-warning" style="font-size: 13px;"></i>
                                                                <label for=""
                                                                    style="font-size: 13px;color: rgb(233, 175, 17)">แก้ไข</label>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item menu" href="javascript:void(0)"
                                                                onclick="car_destroy({{ $item->article_id }})"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="ลบ">

                                                                <i
                                                                    class="fa-solid fa-trash-can  me-2 mt-2 ms-2 mb-2 text-danger" style="font-size: 13px;"></i>
                                                                <label for=""
                                                                    style="font-size: 13px;color: rgb(255, 22, 22)">ลบ</label>
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
    @endsection
    @section('footer')   
    <script>
         $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('#category_id').select2({
                placeholder: "--เลือก-- ",
                allowClear: true
            });

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }); 
    </script>

@endsection
