@extends('layouts.meetting')
@section('title', 'PK-OFFICER || ห้องประชุม')
@section('content')
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>
  
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
        .form-control{
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
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                       
                        <div class="row">
                            <div class="col-md-2 text-left">
                                <h6>ข้อมูลห้องประชุม</h6>
                            </div>
                            <div class="col"></div>
                           
                          
                        </div>

                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> 
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ชื่อห้องประชุม</th>
                                        <th class="text-center">สถานที่ตั้ง</th>
                                        <th class="text-center">ความจุ</th>
                                        <th class="text-center">ผู้รับผิดชอบ</th>  
                                        <th width="10%" class="text-center">Manage</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; $date = date('Y'); ?>
                                    @foreach ($building_data as $item)
                                        <tr id="sid{{ $item->building_id }}">
                                            <td class="text-center" width="3%">{{ $i++ }}</td>                                           
                                            <td class="p-2">{{ $item->room_name }}</td>
                                            <td class="p-2">{{ $item->building_name }}</td>                                         
                                            <td class="p-2" width="7%">{{ $item->room_amount }}</td>
                                            <td class="p-2" width="12%">{{ $item->room_user_name }}</td>
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle menu"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ url('meetting/meettingroom_index_edit/' . $item->room_id) }}"
                                                                class="dropdown-item menu" data-bs-toggle="tooltip"
                                                                data-bs-placement="left" title="แก้ไข">
                                                                <i
                                                                    class="fa-solid fa-pen-to-square mt-2 ms-2 mb-2 me-2 text-warning" style="font-size: 13px;"></i>
                                                                <label for=""
                                                                    style="font-size: 13px;color: rgb(233, 175, 17)">แก้ไข</label>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('meetting/meettingroom_index_tool/' . $item->room_id) }}"
                                                                class="text-primary me-3" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                                title="เพิ่มอุปกรณ์">   
                                                                <i class="fa-solid fa-list-check me-2 mt-3 ms-4 mb-4"></i>
                                                                <label for="" style="font-size: 13px;color: rgb(53, 81, 241)">เพิ่มอุปกรณ์</label>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                {{-- <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>                                      
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                          
                                                              <li>
                                                                <a href="{{ url('meetting/meettingroom_index_edit/' . $item->room_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>  
                                                              </li>
                                                              <li>
                                                                
                                                                <a href="{{ url('meetting/meettingroom_index_tool/' . $item->room_id) }}"
                                                                    class="text-primary me-3" data-bs-toggle="tooltip"
                                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                                    title="เพิ่มอุปกรณ์">   
                                                                    <i class="fa-solid fa-list-check me-2 mt-3 ms-4 mb-4"></i>
                                                                    <label for="" style="color: black">เพิ่มอุปกรณ์</label>
                                                                </a>
                                                              </li>

                                                        </ul>
                                                </div> --}}
                                                 
                                                
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
