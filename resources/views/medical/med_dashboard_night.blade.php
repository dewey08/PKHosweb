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
                ทะเบียนครุภัณฑ์เครื่องมือแพทย์ ถูกยืม
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="{{ url('medical/med_dashboard') }}"
                            class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning"> 
                            <i class="fa-solid fa-arrow-left text-warning me-2"></i>
                            ย้อนกลับ
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"> 
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2">
                        <thead>
                            <tr height="10px">
                                <th width="4%" class="text-center">ลำดับ</th>
                                <th width="25%" class="text-center">รหัสครุภัณฑ์</th>
                                <th class="text-center">รายการครุภัณฑ์</th> 
                                <th width="25%" class="text-center">ประจำหน่วยงาน</th>
                                <th width="5%" class="text-center">สถานะ</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($med_detail as $item)
                                <tr id="sid{{ $item->article_id }}">
                                    <td class="text-center" width="4%" style="font-size: 13px;">{{ $i++ }}</td>
                                    <td class="p-2" width="25%" style="font-size: 13px;">{{ $item->article_num }} </td>
                                    <td class="p-2" style="font-size: 13px;">{{ $item->article_name }}</td>  
                                    <td class="p-2" width="25%" style="font-size: 13px;"> {{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>

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
                                     
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
    

@endsection
