@extends('layouts.plannew')
@section('title', 'PK-OFFICER || Plan')
@section('content')
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

        .modal-dialog {
            max-width: 60%;
        }

        .modal-dialog-slideout {
            min-height: 100%;
            margin:auto 0 0 0 ;   /*  ซ้าย ขวา */
            background: #fff;
        }

        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(30);
            transform: translate(100%, 0)scale(5);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;

            /* overflow-y: hidden;
            overflow-x: auto; */
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }

        .datepicker {
            z-index: 2051 !important;
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
        $iddep = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\PlanController;
    use App\Models\Plan_control_money;
    $refnumber = PlanController::refnumber();
    ?>
    <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div> 
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">ทะเบียนควบคุมแผนงานโครงการ</h4>
        
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">ทะเบียนควบคุมแผนงานโครงการ</a></li>
                                <li class="breadcrumb-item active">เพิ่มทะเบียน</li>
                            </ol>
                        </div>
        
                    </div>
                </div>
            </div> 
        </div> 
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardplan">
                    {{-- <div class="card-header ">
                        ทะเบียนควบคุมแผนงานโครงการ
                        <div class="btn-actions-pane-right">
                            <a href="{{ url('plan_control_add') }}"
                                class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                <i class="fa-solid fa-folder-plus text-info me-2"></i>
                                เพิ่มทะเบียน
                            </a> 
                        </div>

                    </div> --}}
                    <div class="card-body p-2">
                        <div class="row mb-3"> 
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                <a href="{{ url('plan_control_add') }}" class="ladda-button me-2 btn-pill btn btn-primary cardacc Savestamp">
                                    <i class="fa-solid fa-folder-plus me-2"></i>
                                    เพิ่มทะเบียน
                                </a>
                                {{-- <button type="button" class="ladda-button me-2 btn-pill btn btn-danger cardacc Destroystamp" data-url="{{url('account_401_destroy_all')}}">
                                    <i class="fa-solid fa-trash-can me-2"></i>
                                    ลบ
                                </button>  --}}
                            </div>
                        </div>
                        {{-- <div class="table-responsive">                             --}}
                            {{-- <table id="example" class="table table-sm dt-responsive nowrap" style=" border-spacing: 0; width: 100%;">  --}}
                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center"> แผนงาน/โครงการ</th> 
                                        <th class="text-center">งบประมาณ</th> 
                                        <th class="text-center">เบิก</th> 
                                        <th class="text-center">คงเหลือ</th> 
                                        <th width="10%" class="text-center">จัดการ</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($plan_control as $va)
                                       
                                        <tr style="font-size: 13px">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-start">{{$va->plan_name}}</td>
                                            <td class="text-center" width="8%">{{ number_format($va->plan_price, 2) }}</td>
                                            <td class="text-center" width="5%">{{$va->plan_req_no}}</td>
                                            <td class="text-center" width="8%">{{ number_format($va->plan_price_total, 2) }}</td>
                                            <td width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                           
                                                            <button type="button" class="dropdown-item menu btn btn-outline-info btn-sm MoneyModal_"  value="{{ $va->plan_control_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="เบิกเงิน"> 
                                                                <i class="fa-brands fa-bitcoin me-2" style="font-size:17px;color: rgb(34, 148, 255)"></i> 
                                                                <label for=""
                                                                style="color: rgb(34, 148, 255);font-size:13px">เบิกเงิน</label>
                                                            </button>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>                                                        
                                                        <a type="button" href="{{ url('plan_control_edit/' . $va->plan_control_id) }}"
                                                            class="dropdown-item menu btn btn-outline-warning btn-sm" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2" style="color: rgb(252, 185, 0);font-size:13px"></i>
                                                                <label for=""
                                                                style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                            <a class="dropdown-item menu btn btn-outline-danger btn-sm" href="javascript:void(0)"
                                                                onclick="bookmake_destroy({{ $va->plan_control_id}})"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                <label for=""
                                                                    style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                            </a>
                                                    </ul>
                                                  </div>
                                                {{-- <a href="{{ url('plan_control_edit/' . $va->plan_control_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข"
                                                    class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-warning">
                                                    <i class="fa-solid fa-pen-to-square text-warning" ></i> 
                                                </a>
                                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info DetailModal_"  value="{{ $va->plan_control_id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="รายละเอียด"> 
                                                    <i class="fa-brands fa-bitcoin" style="font-size:17px;color: rgb(34, 148, 255)"></i> 
                                                </button>
                                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger MoneyModal_"  value="{{ $va->plan_control_id }}" data-bs-toggle="tooltip" data-bs-placement="right" title="เบิกเงิน"> 
                                                    <i class="fa-brands fa-bitcoin" style="font-size:17px;color: rgb(255, 34, 89)"></i> 
                                                </button>  --}}
                                            </td>
             
                                        </tr>
 

                                        <div class="modal fade" id="UpdateModal{{ $va->plan_control_id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myExtraLargeModalLabel">
                                                            แก้ไขทะเบียนควบคุมแผนงานโครงการ</h5>
                                                        <h6 class="mt-2">{{ $va->billno }} </h6>
                                                        <input id="billno" class="form-control form-control-sm"
                                                            name="billno" type="hidden" value="{{ $va->billno }}">
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 ">
                                                                <label for="">ชื่อโครงการ</label>
                                                                <div class="form-group">
                                                                    <input id="plan_name"
                                                                        class="form-control form-control-sm"
                                                                        name="plan_name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3 ">
                                                                <label for="">ระยะเวลา วันที่</label>
                                                                <div class="form-group"> 
                                                                    <div class="input-daterange input-group"
                                                                        id="datepicker1" data-date-format="dd M, yyyy"
                                                                        data-date-autoclose="true"
                                                                        data-provide="datepicker"
                                                                        data-date-container='#datepicker1'>
                                                                        <input type="text" class="form-control"
                                                                            name="startdate" id="startdate"
                                                                            placeholder="Start Date"
                                                                            data-date-container='#datepicker1'
                                                                            data-provide="datepicker"
                                                                            data-date-autoclose="true" autocomplete="off"
                                                                            data-date-language="th-th"
                                                                            value="{{ $datenow }}" required />

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                <label for="">ถึง </label>
                                                                <div class="form-group">
                                                                    {{-- <input id="plan_endtime" class="form-control form-control-sm" name="plan_endtime"> --}}
                                                                    <div class="input-daterange input-group"
                                                                        id="datepicker1" data-date-format="dd M, yyyy"
                                                                        data-date-autoclose="true"
                                                                        data-provide="datepicker"
                                                                        data-date-container='#datepicker1'>

                                                                        <input type="text" class="form-control"
                                                                            name="enddate" placeholder="End Date"
                                                                            id="enddate"
                                                                            data-date-container='#datepicker1'
                                                                            data-provide="datepicker"
                                                                            data-date-autoclose="true" autocomplete="off"
                                                                            data-date-language="th-th"
                                                                            value="{{ $datenow }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                <label for="">งบประมาณ </label>
                                                                <div class="form-group">
                                                                    <input id="edit_plan_price"
                                                                        class="form-control form-control-sm"
                                                                        name="plan_price">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 ">
                                                                <label for="">แหล่งงบ </label>
                                                                <div class="form-group">
                                                                    <select name="edit_plan_type" id="edit_plan_type"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 100%">
                                                                        @foreach ($plan_control_type as $item2)
                                                                            <option
                                                                                value="{{ $item2->plan_control_type_id }}">
                                                                                {{ $item2->plan_control_typename }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-8 ">
                                                                <label for="">กลุ่มงาน </label>
                                                                <div class="form-group">
                                                                    <select name="department" id="department"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 100%">
                                                                        {{-- <option value="">=เลือก=</option> --}}
                                                                        @foreach ($department_sub_sub as $item)
                                                                            @if ($iddep == $item->DEPARTMENT_SUB_SUB_ID)
                                                                                <option
                                                                                    value="{{ $item->DEPARTMENT_SUB_SUB_ID }}"
                                                                                    selected>
                                                                                    {{ $item->DEPARTMENT_SUB_SUB_NAME }}
                                                                                </option>
                                                                            @else
                                                                                <option
                                                                                    value="{{ $item->DEPARTMENT_SUB_SUB_ID }}">
                                                                                    {{ $item->DEPARTMENT_SUB_SUB_NAME }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 ">
                                                                <label for="">ผู้รับผิดชอบ </label>
                                                                <div class="form-group">
                                                                    <select name="user_id" id="user_id"
                                                                        class="form-control form-control-sm"
                                                                        style="width: 100%">
                                                                        @foreach ($users as $item3)
                                                                            <option value="{{ $item3->id }}">
                                                                                {{ $item3->fname }} {{ $item3->lname }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-end">
                                                            <div class="form-group">
                                                                <button type="button" id="SaveBtn"
                                                                    class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                    บันทึกข้อมูล
                                                                </button>
                                                                <button type="button"
                                                                    class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark me-2"></i>Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    @endforeach
                                </tbody>
                            </table>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MoneyModal" tabindex="-1"
        role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        {{-- <div class="modal-dialog modal-lg"> --}}
            <div class="modal-dialog modal-dialog-slideout">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <div class="row">
                        <div class="col-md-7 text-start"><h2>เบิกเงินทะเบียนควบคุมแผนงานโครงการ</h2> </div>
                        <div class="col"></div>
                        <div class="col-md-3 text-end">
                            {{-- <button class="btn-icon btn-shadow btn-dashed btn btn-outline-success"> 
                                ครั้งที่  {{$maxno}} 
                            </button> --}}
                        </div>
                    </div>
                
                </div>
                <input id="plan_control_money_no" class="form-control form-control-sm" name="plan_control_money_no" type="hidden" >
                <input id="update_plan_control_id" class="form-control form-control-sm" name="update_plan_control_id" type="hidden" >

                <div class="modal-body">
                    <div class="row mt-5">
                        <div class="col-md-2 text-end mt-2"> 
                            <p for="">วันที่</p>
                             
                        </div>
                        <div class="col-md-3"> 
                            <input type="text" id="plan_control_moneydate" class="form-control" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off" value="{{ $datenow }}">
           
                        </div>
                        <div class="col-md-1 text-start"><i class="fa-solid fa-calendar-days mt-2"></i> </div>
                        <div class="col-md-2 text-end mt-2"> 
                            <p for="">ยอดเบิก</p>
                             
                        </div>
                        <div class="col-md-3 "> 
                            <div class="form-group">
                                <input id="plan_control_moneyprice"
                                    class="form-control form-control-sm"
                                    name="plan_control_moneyprice">
                            </div>
                        </div>
                        <div class="col-md-1 text-start mt-2"> <p for="">บาท</p> </div>
                      
                    </div>
                     <div class="row mt-2">
                        <div class="col-md-2 text-end"> <p for="">ผู้เบิก </p> </div>
                        <div class="col-md-10"> 
                            <div class="form-group">
                                <select name="plan_control_moneyuser_id" id="plan_control_moneyuser_id"
                                    class="form-control"
                                    style="width: 100%">
                                    @foreach ($users as $item3)
                                    @if ($iduser == $item3->id)
                                        <option value="{{ $item3->id }}" selected> {{ $item3->fname }} {{ $item3->lname }} </option>
                                    @else
                                        <option value="{{ $item3->id }}"> {{ $item3->fname }} {{ $item3->lname }} </option>
                                    @endif 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                     </div>

                     <div class="row mt-2">
                        <div class="col-md-2 text-end"> <p for="">หมายเหตุ </p> </div>
                        <div class="col-md-10"> 
                            <textarea name="plan_control_moneycomment" id="plan_control_moneycomment" class="form-control form-control-sm" rows="4"></textarea>
                        </div>
                    </div>
                  
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="SaveMoneyBtn"
                                class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2">
                                {{-- <i class="fa-solid fa-floppy-disk me-2"></i> --}}
                                <i class="pe-7s-diskette btn-icon-wrapper me-2"></i>
                                Save
                            </button>
                            <button type="button"
                                class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Modal content for the insert example -->
    <div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มทะเบียนควบคุมแผนงานโครงการ</h5>
                    <h6 class="mt-2">{{ $refnumber }} </h6>
                    <input id="billno" class="form-control form-control-sm" name="billno" type="hidden"
                        value="{{ $refnumber }}">
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 ">
                            <label for="">ชื่อโครงการ</label>
                            <div class="form-group">
                                <input id="plan_name" class="form-control form-control-sm" name="plan_name">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3 ">
                            <label for="">ระยะเวลา วันที่</label>
                            <div class="form-group">
                                {{-- <input id="plan_starttime" class="form-control form-control-sm" name="plan_starttime"> --}}
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                    data-date-autoclose="true" data-provide="datepicker"
                                    data-date-container='#datepicker1'>
                                    <input type="text" class="form-control" name="startdate" id="startdate"
                                        placeholder="Start Date" data-date-container='#datepicker1'
                                        data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $datenow }}" required />

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <label for="">ถึง </label>
                            <div class="form-group">
                                {{-- <input id="plan_endtime" class="form-control form-control-sm" name="plan_endtime"> --}}
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                    data-date-autoclose="true" data-provide="datepicker"
                                    data-date-container='#datepicker1'>

                                    <input type="text" class="form-control" name="enddate" placeholder="End Date"
                                        id="enddate" data-date-container='#datepicker1' data-provide="datepicker"
                                        data-date-autoclose="true" autocomplete="off" data-date-language="th-th"
                                        value="{{ $datenow }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <label for="">งบประมาณ </label>
                            <div class="form-group">
                                <input id="plan_price" class="form-control form-control-sm" name="plan_price">
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <label for="">แหล่งงบ </label>
                            <div class="form-group">
                                <select name="plan_type" id="plan_type" class="form-control form-control-sm"
                                    style="width: 100%">
                                    @foreach ($plan_control_type as $item2)
                                        <option value="{{ $item2->plan_control_type_id }}">
                                            {{ $item2->plan_control_typename }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-md-8 ">
                            <label for="">กลุ่มงาน </label>
                            <div class="form-group">
                                <select name="department" id="department" class="form-control form-control-sm"
                                    style="width: 100%">
                                    {{-- <option value="">=เลือก=</option> --}}
                                    @foreach ($department_sub_sub as $item)
                                        @if ($iddep == $item->DEPARTMENT_SUB_SUB_ID)
                                            <option value="{{ $item->DEPARTMENT_SUB_SUB_ID }}" selected>
                                                {{ $item->DEPARTMENT_SUB_SUB_NAME }}</option>
                                        @else
                                            <option value="{{ $item->DEPARTMENT_SUB_SUB_ID }}">
                                                {{ $item->DEPARTMENT_SUB_SUB_NAME }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <label for="">ผู้รับผิดชอบ </label>
                            <div class="form-group">
                                <select name="user_id" id="user_id" class="form-control form-control-sm"
                                    style="width: 100%">
                                    @foreach ($users as $item3)
                                        <option value="{{ $item3->id }}">{{ $item3->fname }} {{ $item3->lname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="SaveBtn"
                                class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger"
                                data-bs-dismiss="modal"><i class="fa-solid fa-xmark me-2"></i>Close</button>

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
           
            $('#startdate').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#enddate').datepicker({
                format: 'yyyy-mm-dd'
            });
           
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
           
            $('[data-toggle="datepicker"]').datepicker({ 
                autoHide: true,
                zIndex: 2048,
            });
            
            

            $('select').select2();
            $('#plan_control_moneyuser_id').select2({
                dropdownParent: $('#MoneyModal')
            });

            $('#edit_plan_type').select2({
                dropdownParent: $('#UpdateModal')
            });
            
          
            $('#plan_type').select2({
                dropdownParent: $('#insertModal')
            });
            $('#department').select2({
                dropdownParent: $('#insertModal')
            });
            $('#user_id').select2({
                dropdownParent: $('#insertModal')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#SaveBtn').click(function() {
                var plan_name = $('#plan_name').val();
                var datepicker1 = $('#startdate').val();
                var datepicker2 = $('#enddate').val();
                var plan_price = $('#plan_price').val();
                var department = $('#department').val();
                var plan_type = $('#plan_type').val();
                var user_id = $('#user_id').val();
                var billno = $('#billno').val();
                // alert(datepicker1);
                $.ajax({
                    url: "{{ route('p.plan_control_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_name,
                        datepicker1,
                        datepicker2,
                        plan_price,
                        department,
                        plan_type,
                        user_id,
                        billno
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

            $(document).on('click', '.edit_data', function() {
                var audiovisual_id = $(this).val();
                $('#UpdateModal').modal('show');
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

            $(document).on('click', '.MoneyModal_', function() {
                var plan_control_id = $(this).val();
                $('#plan_control_moneydate').datepicker();
                // alert(plan_control_id);
                $('#MoneyModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('plan_control_moneyedit') }}" + '/' + plan_control_id,
                    success: function(data) { 
                        $('#update_plan_control_id').val(data.data_show.plan_control_id)
                        $('#data_sub_count').val(data.data_show.plan_control_money_no)
                    },
                });
            });

            $('#SaveMoneyBtn').click(function() {
                var plan_control_money_no = $('#plan_control_money_no').val();
                var plan_control_moneydate = $('#plan_control_moneydate').val();
                var plan_control_moneyprice = $('#plan_control_moneyprice').val();
                var plan_control_moneyuser_id = $('#plan_control_moneyuser_id').val();
                var plan_control_moneycomment = $('#plan_control_moneycomment').val();
                var update_plan_control_id = $('#update_plan_control_id').val();
                
                $.ajax({
                    url: "{{ route('p.plan_control_repmoney') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_control_money_no,
                        plan_control_moneydate,
                        plan_control_moneyprice,
                        plan_control_moneyuser_id,
                        plan_control_moneycomment ,
                        update_plan_control_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เบิกเงินสำเร็จ',
                                text: "You Request Money success",
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
