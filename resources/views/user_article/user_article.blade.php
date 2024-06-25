@extends('layouts.user')
@section('title', 'PK-OFFICER || ทะเบียนทรัพย์สิน')

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
    <div class="container-fluid" >
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>ทะเบียนครุภัณฑ์ </h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;" id="example2"> 
                                <thead>
                                    <tr height="10px">
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="15%" class="text-center">รหัสครุภัณฑ์</th>
                                        <th class="text-center">รายการครุภัณฑ์</th>
                                        <th width="15%" class="text-center">ประเภทค่าเสื่อม</th>
                                        <th width="15%" class="text-center">หมวดครุภัณฑ์</th>
                                        <th width="17%" class="text-center">ประจำหน่วยงาน</th>
                                        {{-- <th width="5%" class="text-center">Manage</th> --}}
                                    </tr>
                                </thead>
                            <tbody>
                                <?php $i = 1;                                    
                                $date = date('Y');                                    
                                ?>
                                @foreach ($article_data as $item)
                                    <tr id="sid{{ $item->article_id }}">
                                        <td class="text-center" width="4%">{{ $i++ }}</td>
                                        <td class="p-2" width="12%">{{ $item->article_num }} </td>
                                        <td class="p-2">{{ $item->article_name }}</td>
                                        <td class="p-2" width="17%">{{ $item->decline_name }}</td>
                                        <td class="p-2" width="15%">{{ $item->category_name }}</td>
                                        <td class="p-2" width="17%">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
                                        {{-- <td class="text-center" width="5%">
                                            <a href="{{ url('article/article_index_edit/' . $item->article_id) }}"
                                                class="text-success" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                title="รายการบำรุงรักษา" >
                                                <i class="fa-solid fa-toolbox me-2"></i>
                                            </a>                                                                                   
                                        </td> --}}
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
