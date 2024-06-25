@extends('layouts.medicalslide')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
 
@section('content')
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
    
    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div>
        <div class="main-card mb-3 card">

            <div class="card-header">
                ทะเบียนครุภัณฑ์เครื่องมือแพทย์
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="{{ url('medical/med_add') }}"
                            class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                            <i class="fa-solid fa-folder-plus text-primary me-2"></i>
                            เพิ่มเครื่องมือแพทย์
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;"
                                id="example2"> --}}
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2">
                        {{-- <table class="align-middle mb-0 table table-borderless table-striped table-hover" > --}}
                        <thead>
                            <tr height="10px">
                                <th width="4%" class="text-center">ลำดับ</th>
                                <th width="25%" class="text-center">รหัสครุภัณฑ์</th>
                                <th class="text-center">รายการครุภัณฑ์</th>
                                {{-- <th width="15%" class="text-center">ประเภทค่าเสื่อม</th> --}}
                                {{-- <th width="15%" class="text-center">หมวดครุภัณฑ์</th> --}}
                                <th width="25%" class="text-center">ประจำหน่วยงาน</th> 
                                <th width="5%" class="text-center">สถานะ</th>
                                {{-- <th width="9%" class="text-center">การใช้งาน</th> --}}
                                <th width="5%" class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            $date = date('Y');
                            ?>
                            @foreach ($article_data as $item)
                                <tr id="sid{{ $item->article_id }}">
                                    <td class="text-center" width="4%" style="font-size: 13px;">{{ $i++ }}</td>
                                    <td class="p-2" width="25%" style="font-size: 13px;">{{ $item->article_num }}
                                    </td>
                                    <td class="p-2" style="font-size: 13px;">{{ $item->article_name }}</td>
                                    {{-- <td class="p-2" width="15%">{{ $item->article_decline_name }}</td> --}}
                                    {{-- <td class="p-2" width="17%" style="font-size: 13px;">{{ $item->article_categoryname }}</td> --}}
                                    <td class="p-2" width="25%" style="font-size: 13px;">
                                        {{-- {{ $item->article_deb_subsub_name }} --}}
                                        {{ $item->DEPARTMENT_SUB_SUB_NAME }}
                                    </td>
                                     

                                    <td class="text-center" width="10%">
                                        @if ($item->article_status_id == '1')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning">ถูกยืม</span>
                                        @elseif ($item->article_status_id == '2')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">ส่งซ่อม</span>
                                        @elseif ($item->article_status_id == '3')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">ปกติ</span>
                                        @elseif ($item->article_status_id == '4')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">ระหว่างซ่อม</span>
                                        @elseif ($item->article_status_id == '5')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary">รอจำหน่าย</span>
                                        @else
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">จำหน่าย</span>
                                        @endif
                                    </td>
                                    {{-- <td class="text-center" width="10%">
                                        @if ($item->article_status_id == '1')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" style="background-color: rgb(235, 81, 10);font-size:13px;color:white">ถูกยืม</span>
                                        @elseif ($item->article_status_id == '2')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" style="background-color: rgb(89, 10, 235);font-size:13px;color:white">ส่งซ่อม</span>
                                        @elseif ($item->article_status_id == '3')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" style="background-color: rgb(3, 188, 117);font-size:13px;color:white">ปกติ</span>
                                        @elseif ($item->article_status_id == '4')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" style="background-color: rgb(235, 104, 10);font-size:13px;color:white">ระหว่างซ่อม</span>
                                        @elseif ($item->article_status_id == '5')
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" style="background-color: rgb(177, 154, 243);font-size:13px;color:white">รอจำหน่าย</span>
                                        @else
                                            <span class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" style="background-color: rgb(255, 177, 177);font-size:13px;color:white">จำหน่าย</span>
                                        @endif
                                    </td> --}}

                                    <td class="text-center" width="5%">

                                        <div class="dropdown">
                                            <button class="btn btn-outline-info dropdown-toggle menu btn-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                            <ul class="dropdown-menu">

                                                <a class="dropdown-item menu"href="{{ url('medical/med_edit/' . $item->article_id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                    <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                    <label for=""
                                                        style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                </a>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <a class="dropdown-item menu"href="{{ url('medical/med_maintenance/' . $item->article_id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="รายการบำรุงรักษา"
                                                    target="_blank">
                                                    <i class="fa-solid fa-file-circle-plus ms-2 me-2 text-info"></i>
                                                    <label for=""
                                                        style="font-size:13px;color: rgb(6, 158, 196)">รายการบำรุงรักษา</label>
                                                </a>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <a class="dropdown-item menu"href="{{ url('medical/med_repaire/' . $item->article_id) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    data-bs-custom-class="custom-tooltip" title="ส่งซ่อม" target="_blank">
                                                    <i class="fa-solid fa-screwdriver-wrench ms-2 me-2"
                                                        style="color: rgb(79, 6, 196)"></i>
                                                    <label for=""
                                                        style="font-size:13px;color: rgb(79, 6, 196)">ส่งซ่อม</label>
                                                </a>
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
    

@endsection
