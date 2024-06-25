@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER || Sot')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function audiovisual_work_cancel(audiovisual_id) {
            Swal.fire({
                position: "top-end",
                title: 'ต้องการยกเลิกใช่ไหม?',
                text: "กรุณารอการยืนยันการยกเลิก !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ยกเลิกเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('audiovisual_work_cancel') }}" + '/' + audiovisual_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'แจ้งยกเลิกสำเร็จ!',
                                text: "You Cancel data ",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + audiovisual_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        }
                    })
                }
            })
        }

        function audiovisual_admin_finish(audiovisual_id) {
            Swal.fire({
                position: "top-end",
                title: 'ต้องการตรวจสอบงานใช่ไหม?',
                text: "กรุณาตรวจสอบงาน !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ยกเลิกเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('audiovisual_admin_finish') }}" + '/' + audiovisual_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ตรวจสอบงานสำเร็จ!',
                                text: "You Cgeck Confirm data ",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + audiovisual_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
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
        $tel_ = Auth::user()->tel;
        $debsubsub = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $datenow = date('Y-m-d');
            use Illuminate\Support\Facades\DB;
            use App\Http\Controllers\SoteController; 
            $refnumber = SoteController::refnumber();
    ?>
    <style>
        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }
    
        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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
    
        .is-hide {
            display: none;
        }
        .modal-dis {
            width: 1350px;
            margin: auto;
        }
        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%; 
            }
        }
    </style>
    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

        </div>

        <form action="{{ url('audiovisual_work') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            autocomplete="off" data-date-language="th-th" value="{{ $startdate }}" required />
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            autocomplete="off" data-date-language="th-th" value="{{ $enddate }}" />

                        <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                            <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                            ค้นหา
                        </button> 
                    </div>
                </div>
                <div class="col-md-2">
                    {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#addicodeModal" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่มข้อมูล">
                    
                        <i class="fa-solid fa-square-plus me-2"></i>
                     เพิ่มข้อมูล
                    </button> --}}
                    
                    {{-- <a href="#collapseTwo" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary " data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo" data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่มข้อมูล">
                    
                        <i class="fa-solid fa-square-plus me-2"></i>
                     เพิ่มข้อมูล
                    </a>  --}}

                    <a href="{{url('audiovisual_work_add')}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary "  data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่มข้อมูล">
                    
                        <i class="fa-solid fa-square-plus me-2"></i>
                     เพิ่มข้อมูล
                    </a> 
 
                </div>
            </div>
        </form>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card mb-1 card_user_4"> 
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordion">
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="ptname" class="form-label">ชื่อ-นามสกุล</label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm">  
                                        <select class="form-control" id="ptname" name="ptname" style="width: 100%">
                                            @foreach ($users as $item)
                                            @if ($iduser == $item->id)
                                            <option value="{{$item->id}}" selected>{{$item->fname}} {{$item->lname}}</option>
                                            @else
                                            <option value="">{{$item->fname}} {{$item->lname}}</option>
                                            @endif                                            
                                            @endforeach
                                        </select>
                                    
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <label for="tel" class="form-label"> เบอร์โทร</label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm">  
                                    
                                            <input type="text" class="form-control" id="tel" name="tel" value="{{ $tel_}}">   
                                        
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <label for="work_order_date" class="form-label" >วันที่สั่งงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm"> 
                                        
                                        <input type="date" class="form-control" id="work_order_date" name="work_order_date" value="{{$datenow}}">  
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <label for="job_request_date" class="form-label" >วันที่ขอรับงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm"> 
                                        <input type="date" class="form-control" id="job_request_date" name="job_request_date" value="{{$datenow}}">  
                                    </div>
                                </div> 
                                
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label for="department" class="form-label">หน่วยงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm">  
                                        <select class="form-control" id="department" name="department" style="width: 100%">
                                            @foreach ($department_sub_sub as $item2)
                                            @if ($debsubsub == $item2->DEPARTMENT_SUB_SUB_ID)
                                            <option value="{{$item2->DEPARTMENT_SUB_SUB_ID}}" selected>{{$item2->DEPARTMENT_SUB_SUB_NAME}} </option>
                                            @else
                                            <option value=""> {{$item2->DEPARTMENT_SUB_SUB_NAME}}</option>
                                            @endif                                            
                                            @endforeach
                                        </select>
                                    
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <label for="audiovisual_type" class="form-label" >ชนิดของงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm">  
                                        <select class="form-control" id="audiovisual_type" name="audiovisual_type" style="width: 100%">
                                            @foreach ($audiovisual_type as $item3)  
                                            <option value="{{$item3->audiovisual_type_id}}"> {{$item3->audiovisual_typename}}</option> 
                                            @endforeach
                                        </select>
                                    
                                    </div>
                                </div>  
                                
                            </div>  

                            <div class="row mt-2">
                                <div class="col-md-10">
                                    <label for="audiovisual_name" class="form-label" >ชื่อชิ้นงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm"> 
                                        <input type="text" class="form-control" id="audiovisual_name" name="audiovisual_name" >  
                                    </div>
                                </div>  
                                
                                <div class="col-md-2">
                                    <label for="audiovisual_qty" class="form-label" >จำนวนชิ้นงาน</label>
                                    <div class="input-group input-group-sm"> 
                                        <input type="text" class="form-control" id="audiovisual_qty" name="audiovisual_qty" >  
                                    </div>
                                </div> 
                            </div> 
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label for="audiovisual_detail" class="form-label" >รายละเอียดงาน (เช่นขนาดงาน สถานที่ )</label><label for="tel" class="form-label" style="color: red">*</label>
                                    <div class="input-group input-group-sm"> 
                                        <textarea id="audiovisual_detail" name="audiovisual_detail" cols="30" rows="3" class="form-control form-control-sm" ></textarea> 
                                    </div>
                                </div>  
                            </div> 
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card card_user_4 p-2">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th width="5%" class="text-center">ลำดับ</th> 
                                        <th class="text-center" width="5%">สถานะ</th>
                                        <th class="text-center" width="13%">ชื่อ-สกุล</th>
                                        <th class="text-center" width="6%">ไลน์ไอดี</th>
                                        <th class="text-center" width="7%">เบอร์โทร</th>
                                        <th class="text-center" width="7%">วันที่สั่งงาน</th>
                                        <th class="text-center" width="7%">วันที่ขอรับงาน</th>
                                        {{-- <th class="text-center" width="12%">ชนิดของงาน</th>  --}}
                                        <th class="p-2">ชื่อชิ้นงาน</th>
                                        <th class="p-2">รายละเอียดงาน</th>
                                        <th class="p-2" width="10%">หน่วยงาน</th>
                                        <th class="text-center" width="7%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($audiovisual as $item) 
                                        <tr id="sid{{ $item->audiovisual_id }}" style="font-size: 13px">
                                            <td class="text-center">{{ $i++ }}</td>
                                         
                                            @if ($item->audiovisual_status == 'REQUEST')
                                                <td class="text-center" width="5%">
                                                    <div class="badge bg-info" style="font-size:12px">ร้องขอ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'ACCEPTING')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background-color: #592DF7;font-size:12px"
                                                        style="font-size:12px">รับทราบ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'INPROGRESS')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background: rgb(96, 221, 243);font-size:12px"
                                                         >กำลังดำเนินการ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'VERIFY')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background: rgb(232,13,239);font-size:12px"
                                                         >ตรวจสอบ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'FINISH')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background: rgb(4, 190, 144);font-size:12px"
                                                        >เสร็จสิ้น</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'CANCEL')
                                                <td class="text-center" width="5%">
                                                    <div class="badge bg-danger" style="font-size:12px">แจ้งยกเลิก</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'CONFIRM_CANCEL')
                                                <td class="text-center" width="5%">
                                                    <div class="badge " style="background: rgb(141, 140, 138)"
                                                        style="font-size:12px">ยกเลิก</div>
                                                </td>
                                            @else
                                                <td class="text-center" width="5%">
                                                    <div class="badge bg-success" style="font-size:12px">ซ่อมเสร็จ</div>
                                                </td>
                                            @endif
                                         
                                            <td class="p-2" width="10%"> {{ $item->fname }} {{ $item->lname }}</td>
                                            <td class="text-center" width="6%">{{ $item->lineid }}</td> 
                                            <td class="text-center" width="6%">{{ $item->tel }}</td>                                            
                                            <td class="text-center" width="7%">{{ Datethai($item->work_order_date) }} </td>
                                            <td class="text-center" width="7%">{{Datethai($item->job_request_date )}}</td>
                                            {{-- <td class="p-2">{{ $item->audiovisual_typename }} </td> --}}
                                            <td class="p-2">{{ $item->audiovisual_name }} </td>
                                            <td class="p-2">{{ $item->audiovisual_detail }} </td>
                                            <td class="p-2" width="10%">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td> 
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        {{-- <button type="button"class="dropdown-item menu edit_data"
                                                            value="{{ $item->audiovisual_id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-info"
                                                                style="font-size:13px"></i>
                                                            <span style="color:orange">รายละเอียด</span> 
                                                        </button> --}}

                                                        <a href="{{url('audiovisual_work_edit/'.$item->audiovisual_id)}}"  class="dropdown-item menu "
                                                         data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"
                                                                style="font-size:13px"></i>
                                                            <span style="color:orange">แก้ไข</span> 
                                                    </a>

                                                        <button type="button"class="dropdown-item menu"
                                                        data-bs-toggle="modal" data-bs-target="#UpdateModal_in{{ $item->audiovisual_id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="รายละเอียด">
                                                            <i class="fa-solid fa-file-pen ms-2 me-2 text-info"
                                                                style="font-size:13px"></i>
                                                            <span class="text-info">รายละเอียด</span>
                                                        
                                                        </button>
                                                        <a class="dropdown-item text-success" href="javascript:void(0)"
                                                            onclick="audiovisual_admin_finish({{ $item->audiovisual_id }})"
                                                            style="font-size:13px">
                                                            <i class="fa-solid fa-file-pen ms-2 me-2 text-success"
                                                                style="font-size:13px"></i>
                                                            <span>ตรวจสอบงาน</span>
                                                        </a>
                                                        
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="audiovisual_work_cancel({{ $item->audiovisual_id }})"
                                                            style="font-size:13px">
                                                            <i class="fa-solid fa-xmark ms-2 me-2 text-danger"
                                                                style="font-size:13px"></i>
                                                            <span>ยกเลิก</span>
                                                        </a>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="UpdateModal_in{{ $item->audiovisual_id }}"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content ">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title me-3" id="editModalLabel">รายละเอียดการขอใช้บริการ</h5> <h6 class="mt-2"> </h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"> 
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="edit_ptname" class="form-label">ชื่อ-นามสกุล</label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm">  
                                                                        <label for="" style="color: gray">:: {{$item->fname}} {{$item->lname}}</label>
                                                                       
                                                                    </div>
                                                                </div>  
                                                                <div class="col-md-2">
                                                                    <label for="tel" class="form-label"> เบอร์โทร</label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm">  
                                                                        <label for="" style="color: gray">:: {{$item->tel}}</label>   
                                                                           
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-2">
                                                                    <label for="work_order_date" class="form-label" >วันที่สั่งงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm"> 
                                                                        <label for="" style="color: gray">:: {{$item->work_order_date}}</label> 
                                                                       
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-2">
                                                                    <label for="job_request_date" class="form-label" >วันที่ขอรับงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm"> 
                                                                        <label for="" style="color: gray">:: {{$item->job_request_date}}</label>  
                                                                    </div>
                                                                </div> 
                                                                
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-md-6">
                                                                    <label for="department" class="form-label">หน่วยงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm">  
                                                                        <label for="" style="color: gray">:: {{$item->DEPARTMENT_SUB_SUB_NAME}}</label>  
                                                                       
                                                                    </div>
                                                                </div>  
                                                                <div class="col-md-6">
                                                                    <label for="audiovisual_type" class="form-label" >ชนิดของงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm">  
                                                                        <label for="" style="color: gray">:: {{$item->audiovisual_typename}}</label>  
                                                                       
                                                                    </div>
                                                                </div>  
                                                                
                                                            </div> 
                                             
                                                            <div class="row mt-2">
                                                                <div class="col-md-10">
                                                                    <label for="audiovisual_name" class="form-label" >ชื่อชิ้นงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm"> 
                                                                        <label for="" style="color: gray">:: {{$item->audiovisual_name}}</label>  
                                                                    </div>
                                                                </div>  
                                                                
                                                                <div class="col-md-2">
                                                                    <label for="audiovisual_qty" class="form-label" >จำนวนชิ้นงาน</label>
                                                                    <div class="input-group input-group-sm"> 
                                                                        <label for="" style="color: gray">:: {{$item->audiovisual_qty}}</label>  
                                                                    </div>
                                                                </div> 
                                                            </div> 
                                                            <div class="row mt-2">
                                                                <div class="col-md-12">
                                                                    <label for="audiovisual_detail" class="form-label" >รายละเอียดงาน (เช่นขนาดงาน สถานที่ )</label><label for="tel" class="form-label" style="color: red">*</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <label for="" style="color: gray">:: {{$item->audiovisual_detail}}</label>   
                                                                    </div>
                                                                </div>  
                                                            </div> 
                                                    
                                                     
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-bs-dismiss="modal" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" >
                                                            <i class="fa-solid fa-xmark me-2"></i>Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                          

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- addicodeModal Modal -->
    {{-- <div class="modal fade" id="addicodeModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title me-3" id="editModalLabel">รายละเอียดการขอใช้บริการ</h5> <h6 class="mt-2"> เลขที่ {{$refnumber}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ptname" class="form-label">ชื่อ-นามสกุล</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                    <select class="form-control" id="ptname" name="ptname" style="width: 100%">
                                        @foreach ($users as $item)
                                        @if ($iduser == $item->id)
                                        <option value="{{$item->id}}" selected>{{$item->fname}} {{$item->lname}}</option>
                                        @else
                                        <option value="">{{$item->fname}} {{$item->lname}}</option>
                                        @endif                                            
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>  
                            <div class="col-md-2">
                                <label for="tel" class="form-label"> เบอร์โทร</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                   
                                        <input type="text" class="form-control" id="tel" name="tel" value="{{ $tel_}}">   
                                       
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="work_order_date" class="form-label" >วันที่สั่งงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    
                                    <input type="date" class="form-control" id="work_order_date" name="work_order_date" value="{{$datenow}}">  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="job_request_date" class="form-label" >วันที่ขอรับงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="date" class="form-control" id="job_request_date" name="job_request_date" value="{{$datenow}}">  
                                </div>
                            </div> 
                            
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="department" class="form-label">หน่วยงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                    <select class="form-control" id="department" name="department" style="width: 100%">
                                        @foreach ($department_sub_sub as $item2)
                                        @if ($debsubsub == $item2->DEPARTMENT_SUB_SUB_ID)
                                        <option value="{{$item2->DEPARTMENT_SUB_SUB_ID}}" selected>{{$item2->DEPARTMENT_SUB_SUB_NAME}} </option>
                                        @else
                                        <option value=""> {{$item2->DEPARTMENT_SUB_SUB_NAME}}</option>
                                        @endif                                            
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <label for="audiovisual_type" class="form-label" >ชนิดของงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                    <select class="form-control" id="audiovisual_type" name="audiovisual_type" style="width: 100%">
                                        @foreach ($audiovisual_type as $item3)  
                                        <option value="{{$item3->audiovisual_type_id}}"> {{$item3->audiovisual_typename}}</option> 
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>  
                            
                        </div> 
         
                        <div class="row mt-2">
                            <div class="col-md-10">
                                <label for="audiovisual_name" class="form-label" >ชื่อชิ้นงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="audiovisual_name" name="audiovisual_name" >  
                                </div>
                            </div>  
                            
                            <div class="col-md-2">
                                <label for="audiovisual_qty" class="form-label" >จำนวนชิ้นงาน</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="audiovisual_qty" name="audiovisual_qty" >  
                                </div>
                            </div> 
                        </div> 
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="audiovisual_detail" class="form-label" >รายละเอียดงาน (เช่นขนาดงาน สถานที่ )</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    <textarea id="audiovisual_detail" name="audiovisual_detail" cols="30" rows="3" class="form-control form-control-sm" ></textarea> 
                                </div>
                            </div>  
                        </div> 
                    <input type="hidden" name="user_id" id="adduser_id"> 
                    <input type="hidden" name="acc_debtor_id" id="acc_debtor_id"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Insertdata">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

     <!-- addicodeModal Modal -->
     <div class="modal fade" id="UpdateModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title me-3" id="editModalLabel">แก้ไขรายละเอียดการขอใช้บริการ</h5> <h6 class="mt-2"> </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body"> 
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_ptname" class="form-label">ชื่อ-นามสกุล</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                    <input type="text" class="form-control" id="edit_ptname" name="edit_ptname" >   
                                    <select class="form-control" id="edit_ptname" name="ptname" style="width: 100%">
                                        @foreach ($users as $item)
                                        @if ($iduser == $item->id)
                                        <option value="{{$item->id}}" selected>{{$item->fname}} {{$item->lname}}</option>
                                        @else
                                        <option value="{{$item->id}}">{{$item->fname}} {{$item->lname}}</option>
                                        @endif                                            
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>  
                            <div class="col-md-2">
                                <label for="tel" class="form-label"> เบอร์โทร</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                   
                                        <input type="text" class="form-control" id="edit_tel" name="tel" >   
                                       
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="work_order_date" class="form-label" >วันที่สั่งงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    
                                    <input type="date" class="form-control" id="edit_work_order_date" name="work_order_date">  
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <label for="job_request_date" class="form-label" >วันที่ขอรับงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="date" class="form-control" id="edit_job_request_date" name="job_request_date" >  
                                </div>
                            </div> 
                            
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="department" class="form-label">หน่วยงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                    <select class="form-control" id="edit_department" name="department" style="width: 100%">
                                        @foreach ($department_sub_sub as $item2)
                                        @if ($debsubsub == $item2->DEPARTMENT_SUB_SUB_ID)
                                        <option value="{{$item2->DEPARTMENT_SUB_SUB_ID}}" selected>{{$item2->DEPARTMENT_SUB_SUB_NAME}} </option>
                                        @else
                                        <option value="{{$item2->DEPARTMENT_SUB_SUB_ID}}"> {{$item2->DEPARTMENT_SUB_SUB_NAME}}</option>
                                        @endif                                            
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <label for="audiovisual_type" class="form-label" >ชนิดของงาน</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm">  
                                    <select class="form-control" id="edit_audiovisual_type" name="audiovisual_type" style="width: 100%">
                                        @foreach ($audiovisual_type as $item3)  
                                        <option value="{{$item3->audiovisual_type_id}}"> {{$item3->audiovisual_typename}}</option> 
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>  
                            
                        </div> 
         
                        <div class="row mt-2">
                            <div class="col-md-10">
                                <label for="audiovisual_name" class="form-label" >ชื่อชิ้นงาน </label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="edit_audiovisual_name" name="audiovisual_name" >  
                                </div>
                            </div>  
                            
                            <div class="col-md-2">
                                <label for="audiovisual_qty" class="form-label" >จำนวนชิ้นงาน</label>
                                <div class="input-group input-group-sm"> 
                                    <input type="text" class="form-control" id="edit_audiovisual_qty" name="audiovisual_qty" >  
                                </div>
                            </div> 
                        </div> 
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label for="audiovisual_detail" class="form-label" >รายละเอียดงาน (เช่นขนาดงาน สถานที่ )</label><label for="tel" class="form-label" style="color: red">*</label>
                                <div class="input-group input-group-sm"> 
                                    <textarea id="audiovisual_detail" name="edit_audiovisual_detail" cols="30" rows="3" class="form-control form-control-sm" ></textarea> 
                                </div>
                            </div>  
                        </div> 
                
                    <input type="text" name="edit_audiovisual_id" id="edit_audiovisual_id"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Insertdata">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                    </button>
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
            // collapseTwo
            // $('select').select2();
            $('#ptname').select2({
                dropdownParent: $('#collapseTwo')
            });
            $('#department').select2({
                dropdownParent: $('#collapseTwo')
            });
            $('#audiovisual_type').select2({
                dropdownParent: $('#collapseTwo')
            });

            // $('#ptname').select2({
            //     dropdownParent: $('#addicodeModal')
            // });

            $("#edit_ptname").select2({
                // tags: true,
                dropdownParent: $('#UpdateModal'),
                // tokenSeparators: [',', ' ']
            })
            $('#edit_department').select2({
                dropdownParent: $('#UpdateModal')
            });
            // $(".js-example-theme-multiple").select2({
            //     theme: "classic"
            // });
            // $('#department').select2({
            //     dropdownParent: $('#addicodeModal')
            // });
            // $('#audiovisual_type').select2({
            //     dropdownParent: $('#addicodeModal')
            // });
            $('#edit_audiovisual_type').select2({
                dropdownParent: $('#UpdateModal')
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

            $(document).on('click', '#printBtn', function() {
                var month_id = $(this).val();
                alert(month_id);

            });
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $(document).on('click', '.add_color', function() {
                var user_id = $(this).val();
                // alert(ot_one_id);
                $('#add_color').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('otone_add_color') }}" + '/' + user_id,
                    success: function(data) {
                        $('#user_id').val(data.users_color.id)

                    },
                });

                $('#saveBtn').click(function() {

                    var color_ot = $('#color_ot').val();
                    var user_id = $('#user_id').val();
                    // alert(color_ot);
                    $.ajax({
                        url: "{{ route('ot.otone_updatecolor') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            color_ot,
                            user_id
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                // alert('gggggg');
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
                                        console.log(
                                            data);

                                        window.location
                                            .reload();
                                    }
                                })
                            } else {

                            }

                        },
                    });
                });
            });

            $(document).on('click', '.edit_data', function() {
                var audiovisual_id = $(this).val(); 
                $('#UpdateModal').modal('show');
                // alert(audiovisual_id);
                // $("#overlay").fadeIn(300);　
                // $("#spinner").show(); //Load button clicked show spinner 
                $.ajax({
                    type: "GET",
                    url: "{{ url('audiovisual_work_detail') }}" + '/' + audiovisual_id,
                    success: function(data) {
                        $('#edit_ptname').val(data.work.ptname)
                        $('#edit_tel').val(data.work.tel)
                        $('#edit_work_order_date').val(data.work.work_order_date)
                        $('#edit_job_request_date').val(data.work.job_request_date)
                        $('#edit_department').val(data.work.department)
                        $('#edit_audiovisual_type').val(data.work.audiovisual_type)
                        $('#edit_audiovisual_name').val(data.work.audiovisual_name)
                        $('#edit_audiovisual_qty').val(data.work.audiovisual_qty)
                        $('#edit_audiovisual_detail').val(data.work.audiovisual_detail)
                        $('#edit_audiovisual_id').val(data.work.audiovisual_id)
                    },
                });
            });

            $('#Insertdata').click(function() {
                var ptname = $('#ptname').val();
                var tel = $('#tel').val();
                var work_order_date = $('#work_order_date').val();
                var job_request_date = $('#job_request_date').val();
                var department = $('#department').val();
                var audiovisual_type = $('#audiovisual_type').val();
                var audiovisual_name = $('#audiovisual_name').val();
                var audiovisual_qty = $('#audiovisual_qty').val();
                var audiovisual_detail = $('#audiovisual_detail').val();
              
                $.ajax({
                    url: "{{ route('user.audiovisual_work_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        ptname, tel,work_order_date, job_request_date,department,audiovisual_type,audiovisual_name,audiovisual_qty,audiovisual_detail 
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

        });
    </script>

@endsection
