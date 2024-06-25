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
    $refnumber = PlanController::refnumber();
    ?>
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header ">
                        ทะเบียนควบคุมแผนงานโครงการ
                        <div class="btn-actions-pane-right">
                            <a href="{{ url('plan_control_add') }}"
                                class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                <i class="fa-solid fa-folder-plus text-info me-2"></i>
                                เพิ่มทะเบียน
                            </a>
                            {{-- data-bs-toggle="modal" data-bs-target="#insertModal" --}}
                        </div>

                    </div>
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover"
                                id="example">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center"> แผนงาน/โครงการ</th>
                                        {{-- <th class="text-center">วัตถุประสงค์ /ตัวชี้วัด</th>  --}}
                                        {{-- <th class="text-center">แหล่งงบประมาณ</th>  --}}
                                        {{-- <th class="text-center">งบประมาณ</th>  --}}
                                        {{-- <th class="text-center">ระยะเวลา</th>       --}}
                                        {{-- <th class="text-center">กลุ่มงาน</th>   --}}
                                        <th class="text-center">รวมเบิก</th>
                                        <th class="text-center" width="7%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($plan_control as $va)
                                        <?php
                                        $data_sub_ = DB::connection('mysql')->select(
                                            '
                                            SELECT 
                                                plan_control_id,billno,plan_obj,plan_name,plan_reqtotal,pt.plan_control_typename,p.plan_price,p.plan_starttime,p.plan_endtime,p.`status`,s.DEPARTMENT_SUB_SUB_NAME
                                                FROM
                                                plan_control p
                                                LEFT OUTER JOIN department_sub_sub s ON s.DEPARTMENT_SUB_SUB_ID = p.department
                                                LEFT OUTER JOIN plan_control_type pt ON pt.plan_control_type_id = p.plan_type
                                                WHERE plan_control_id = "' .
                                                $va->plan_control_id .
                                                '"',
                                        );
                                        
                                        ?>
                                        <tr style="font-size: 13px">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-start">

                                                <div id="headingTwo" class="b-radius-0 card-header">
                                                    @if ($va->plan_name == '0')
                                                        <button type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne2{{ $va->plan_control_id }}"
                                                            aria-expanded="false" aria-controls="collapseTwo"
                                                            class="text-start m-0 p-0 btn btn-link btn-block">
                                                            <h7 style="color: rgb(207, 204, 204)">{{ $va->plan_name }}
                                                                <label for="" style="color: red"> !! รายละเอียด คลิก
                                                                    !!</label></h7>
                                                        </button>
                                                    @else
                                                        <button type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne2{{ $va->plan_control_id }}"
                                                            aria-expanded="false" aria-controls="collapseTwo"
                                                            class="text-start m-0 p-0 btn btn-link btn-block">
                                                            <h7>{{ $va->plan_name }} <label for=""
                                                                    style="color: red"> !! รายละเอียด คลิก !!</label></h7>
                                                        </button>
                                                    @endif

                                                </div>
                                                <div data-parent="#accordion" id="collapseOne2{{ $va->plan_control_id }}"
                                                    class="collapse">
                                                    <div class="card-body">
                                                        <div class="row ms-3 me-3">
                                                            <div class="col-md-3"> วัตถุประสงค์ /ตัวชี้วัด</div>
                                                            <div class="col-md-2"> แหล่งงบประมาณ</div>
                                                            <div class="col-md-2"> งบประมาณ</div>
                                                            <div class="col-md-2">ระยะเวลา </div>
                                                            <div class="col-md-3">กลุ่มงาน </div>
                                                        </div>
                                                        @foreach ($data_sub_ as $itemsub)
                                                            <div class="row ms-3 me-3">
                                                                <div class="col-md-3">{{ $itemsub->plan_obj }} </div>
                                                                <div class="col-md-2">{{ $itemsub->plan_control_typename }}
                                                                </div>
                                                                <div class="col-md-2"> {{ $itemsub->plan_price }}</div>
                                                                <div class="col-md-2">{{ $itemsub->plan_starttime }} ถึง
                                                                    {{ $itemsub->plan_endtime }} </div>
                                                                <div class="col-md-3">
                                                                    {{ $itemsub->DEPARTMENT_SUB_SUB_NAME }} </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td class="text-start">{{$va->plan_obj}}</td> --}}
                                            {{-- <td class="text-start">{{$va->plan_control_typename}}</td> --}}
                                            {{-- <td class="text-start">{{$va->plan_price}}</td> --}}
                                            {{-- <td class="text-start">{{DateThai($va->plan_starttime)}}ถึง{{DateThai($va->plan_endtime)}}</td>  --}}
                                            {{-- <td class="text-start">{{$va->DEPARTMENT_SUB_SUB_NAME}}</td> --}}
                                            <td class="text-center">{{ $va->plan_reqtotal }}</td>
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        {{-- <button type="button"class="dropdown-item menu "
                                                            data-bs-toggle="modal" data-bs-target="#UpdateModal{{ $va->plan_control_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for=""
                                                                style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </button> --}}
                                                        <a href="{{ url('plan_control_edit/' . $va->plan_control_id) }}"
                                                            class="dropdown-item menu " {{-- data-bs-toggle="modal" data-bs-target="#UpdateModal{{ $va->plan_control_id }}" --}}
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for=""
                                                                style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </a>
                                                        <button type="button"class="dropdown-item menu MoneyModal_"
                                                            {{-- data-bs-toggle="modal" data-bs-target="#MoneyModal" --}}
                                                            value="{{ $va->plan_control_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="เบิกเงิน">
                                                          
                                                            <i class="fa-solid fa-hand-holding-dollar ms-2 me-2" style="font-size:13px;color: rgb(34, 122, 255)"></i>
                                                            <label for=""
                                                                style="font-size:13px;color: rgb(34, 122, 255)">เบิกเงิน</label>
                                                        </button> 
                                                    </ul>
                                                </div>
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
                                                                    {{-- <input id="plan_starttime" class="form-control form-control-sm" name="plan_starttime"> --}}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="MoneyModal" tabindex="-1"
        role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">
                        เบิกเงินทะเบียนควบคุมแผนงานโครงการ</h5>
                    <h6 class="mt-2">ครั้งที่ </h6>

                    <input id="plan_control_money_no" class="form-control form-control-sm" name="plan_control_money_no" type="hidden" >
                    <input id="plan_control_id" class="form-control form-control-sm" name="plan_control_id" type="text" >
                    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 ">
                            <label for="">วันที่</label>
                            <div class="form-group">
                                <input id="plan_control_moneydate"
                                    class="form-control form-control-sm"
                                    name="plan_control_moneydate">
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <label for="">จำนวนเงิน</label>
                            <div class="form-group">
                                <input id="plan_control_moneyprice"
                                    class="form-control form-control-sm"
                                    name="plan_control_moneyprice">
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <label for="">ผู้เบิก </label>
                            <div class="form-group">
                                <select name="plan_control_moneyuser_id" id="plan_control_moneyuser_id"
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
                            <button type="button" id="SaveMoneyBtn"
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
                $('#MoneyModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('plan_control_moneyedit') }}" + '/' + plan_control_id,
                    success: function(data) {
                        $('#plan_control_moneydate').val(data.data_show.plan_control_moneydate)
                        $('#plan_control_money_no').val(data.data_show.plan_control_money_no)
                        $('#plan_control_moneyprice').val(data.data_show.plan_control_moneyprice)
                        $('#plan_control_moneyuser_id').val(data.data_show.plan_control_moneyuser_id)  
                        $('#plan_control_id').val(data.data_show.plan_control_id)
                    },
                });
            });


        });
    </script>

@endsection
