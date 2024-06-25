@extends('layouts.accountnew')
@section('title', 'PK-OFFICER || Account')
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

            /* .custom-tooltip {
                --bs-tooltip-bg: var(--bs-primary);
            } */

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
        {{-- <div class="row ">
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-header ">
                                    <form action="{{ url('account_money_pay/'.$id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-1 text-left">บัญชีจ่าย</div>
                                            <div class="col-md-1 text-end">วันที่</div>
                                            <div class="col-md-2 text-center">
                                                <div class="input-group" id="datepicker1">
                                                    <input type="text" class="form-control" name="startdate" id="datepicker"
                                                        data-date-container='#datepicker1' data-provide="datepicker"
                                                        data-date-language="th-th" data-date-autoclose="true"
                                                        value="{{ $startdate }} ">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-end">ถึงวันที่</div>
                                            <div class="col-md-2 text-center">
                                                <div class="input-group" id="datepicker1">
                                                    <input type="text" class="form-control" name="enddate" id="datepicker2"
                                                        data-date-container='#datepicker1' data-provide="datepicker"
                                                        data-date-language="th-th" data-date-autoclose="true"
                                                        value="{{ $enddate }} ">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-2">
                                                <select name="account_main_type" id="account_main_type2"
                                                    class="form-control"bstyle="width: 100%" required>
                                                    <option value="">=เลือก=</option>
                                                    @foreach ($users_groups as $ug)
                                                        @if ($main_type == $ug->users_group_id)
                                                            <option value="{{ $ug->users_group_id }}" selected>
                                                                {{ $ug->users_group_name }}</option>
                                                        @else
                                                            <option value="{{ $ug->users_group_id }}">{{ $ug->users_group_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                                                    ค้นหา
                                                </button>
                                            </div> 
                                        </div>

                                </div>
                    </form> --}}
        <form action="{{ url('account_money_pay/' . $id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col"></div>
                <div class="col-md-1 text-end">วันที่</div>
             
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="account_main_type" id="account_main_type2" class="form-control"bstyle="width: 100%"
                        required>
                        <option value="">=เลือก=</option>
                        @foreach ($users_groups as $ug)
                            @if ($main_type == $ug->users_group_id)
                                <option value="{{ $ug->users_group_id }}" selected>
                                    {{ $ug->users_group_name }}</option>
                            @else
                                <option value="{{ $ug->users_group_id }}">{{ $ug->users_group_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                    </button>
                </div>
                {{-- <div class="col-md-1 text-end"> --}}
                    {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#insertuserdata">
                        เพิ่มเจ้าหน้าที่
                    </button> --}}
                {{-- </div> --}}

                {{-- <div class="col-md-1 text-start"> --}}
                    {{-- <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                        data-bs-target="#copydata">
                        คัดลอกข้อมูล
                    </button> --}}
                {{-- </div> --}}
            </div>
        </form>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>บัญชีรับ {{ $data_hos->users_hos_name }}</h5>
                            <div class="btn-actions-pane-right">
                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(236, 232, 181)">
                                    {{-- <i class="fa-solid fa-arrows-rotate text-danger me-2"></i> --}}
                                    ลงบัญชีจ่าย
                                </button>
                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(200, 233, 248)">
                                    {{-- <i class="fa-solid fa-arrows-rotate text-danger me-2"></i> --}}
                                    เช็คบัญชีจ่าย
                                </button>
                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-secondary" style="background-color: rgb(232, 208, 255)">
                                    {{-- <i class="fa-solid fa-arrows-rotate text-danger me-2"></i> --}}
                                    ลงบัญชีจ่ายสำเร็จ
                                </button>
                            </div>
                        </div>
                    {{-- <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>บัญชีจ่าย {{ $data_hos->users_hos_name }}</h5>
                            </div>
                            <div class="col-md-1 text-end">
                                <label for="" style="font-size: 17px">สถานะสี</label>
                            </div>
                            <div class="col-md-5 ">
                                <button type="button" class="btn ms-3 text-white"
                                    style="background-color: rgb(156, 219, 7)">ลงบัญชีรับเรียบร้อย</button>
                                    <button type="button" class="btn ms-3 text-danger"
                                    style="background-color: rgb(236, 232, 181)">ลงบัญชีจ่าย</button>
                                <button type="button" class="btn ms-3 text-danger"
                                    style="background-color: rgb(200, 233, 248)">เช็คบัญชีจ่าย</button>
                                <button type="button" class="btn ms-3 text-danger"
                                    style="background-color: rgb(232, 208, 255)">ลงบัญชีจ่ายสำเร็จ</button>
                            </div>

                            <div class="col-md-2"></div>
                        </div>
                    </div> --}}
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="3%" class="text-center">ลำดับ</th>
                                        <th class="text-center">เดือน/ปี</th>
                                        <th class="text-center">เลขบัตร ปชช</th>
                                        <th class="text-center">ชื่อ-สกุล</th>
                                        <th class="text-center">จัดการ</th>
                                        <th class="text-center">ภาษี</th>
                                        <th class="text-center">กบข./กสจ./สมทบ</th>
                                        <th class="text-center">กบข.</th>
                                        <th class="text-center">ส่วนเพิ่ม.</th>
                                        <th class="text-center">ผ่อน</th>
                                        <th class="text-center">แฟลต</th>
                                        <th class="text-center">หุ้น</th>
                                        <th class="text-center">กู้</th>
                                        <th class="text-center">คืน สสจ</th>
                                        <th class="text-center">ค่าน้ำ</th>
                                        <th class="text-center">ค่าไฟ</th>
                                        <th class="text-center">สหกรณ์</th>
                                        <th class="text-center">ฌกส.</th>
                                        <th class="text-center">ธอส</th>
                                        <th class="text-center">ประกัน</th>
                                        <th class="text-center">KTB</th>
                                        <th class="text-center">GSB</th>
                                        <th class="text-center">SCB</th>
                                        <th class="text-center">กยศ./อื่นๆ</th>
                                        <th class="text-center">รวมจ่าย</th>
                                        <th class="text-center">คงเหลือรับ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item2)

                                        <?php $yearthai = $item2->account_main_year;
                                            $repstatus = $item2->account_rep_active;
                                            $colorstatus = $item2->account_pay_active;
                                            
                                            if ($colorstatus == 'TAKEDOWN') {
                                                $color_new = 'background-color: rgb(236, 232, 181)';
                                            } elseif ($colorstatus == 'CHECK') {
                                                $color_new = 'background-color: rgb(200, 233, 248)';
                                            } elseif ($colorstatus == 'PAYFINISH') {
                                                $color_new = 'background-color: rgb(232, 208, 255)';
                                            // } elseif ($colorstatus == 'REQUEST' && $repstatus == 'REPFINISH') {
                                            //     $color_new = 'background-color: rgb(156, 219, 7)';
                                            } elseif ($colorstatus == 'REQUEST') {
                                                $color_new = ' ';
                                            } else {
                                                $color_new = 'background-color: rgb(107, 180, 248)';
                                            }                                                                                
                                        ?>

                                        <tr id="sid{{ $item2->account_main_id }}" style="{{ $color_new }}">
                                            <td width="3%">{{ $i++ }}</td>

                                            @if ($item2->account_main_mounts == '1')
                                                <td width="10%" class="text-center" >มกราคม / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '2')
                                                <td width="10%" class="text-center">กุมภาพันธ์ / {{ $yearthai }}
                                                </td>
                                            @elseif ($item2->account_main_mounts == '3')
                                                <td width="10%" class="text-center">มีนาคม / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '4')
                                                <td width="10%" class="text-center">เมษายน / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '5')
                                                <td width="10%" class="text-center">พฤษภาคม / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '6')
                                                <td width="10%" class="text-center">มิถุนายน / {{ $yearthai }}
                                                </td>
                                            @elseif ($item2->account_main_mounts == '7')
                                                <td width="10%" class="text-center">กรกฎาคม / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '8')
                                                <td width="10%" class="text-center">สิงหาคม / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '9')
                                                <td width="10%" class="text-center">กันยายน / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '10')
                                                <td width="10%" class="text-center">ตุลาคม / {{ $yearthai }}</td>
                                            @elseif ($item2->account_main_mounts == '11')
                                                <td width="10%" class="text-center">พฤษจิกายน / {{ $yearthai }}
                                                </td>
                                            @else
                                                <td width="10%" class="text-center">ธันวาคม / {{ $yearthai }}</td>
                                            @endif

                                            <td class="text-center" width="10%">{{ $item2->cid }}</td>
                                            <td class="p-2">{{ $item2->prefix_name }}{{ $item2->fname }} {{ $item2->lname }}</td>
                                            
                                            @if ($item2->expend_sum == '' )
                                                <td width="3%" class="text-center">
                                                    {{-- <button type="button" class="btn btn-outline-danger btn-sm" 
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="รายชื่อนี้ยังไม่ใด้ลงบัญชีรับ">
                                                            <i class="fa-solid fa-dollar-sign text-danger"
                                                                style="font-size:13px"></i>
                                                    </button> --}}
                                                    <button type="button" class="btn btn-info btn-sm shadow text-white editDatapay_only"
                                                            value="{{ $item2->account_main_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="ลงข้อมูลบัญชีจ่าย">
                                                            ลงข้อมูล
                                                            {{-- <i class="fa-solid fa-dollar-sign text-primary"
                                                                style="font-size:13px"></i> --}}
                                                    </button>
                                                </td>
                                            @elseif ($item2->account_rep_active != 'REPFINISH') 
                                                <td width="3%" class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="รายชื่อนี้ยังลงบัญชีรับไม่เรียบร้อย">
                                                            <i class="fa-solid fa-dollar-sign text-danger"
                                                                style="font-size:13px"></i>
                                                    </button>
                                                </td>
                                            @else  
                                                <td width="3%" class="text-center">  
                                                    @if ($item2->account_pay_active == 'CHECK')
                                                        <button type="button" class="btn btn-outline-light btn-sm "
                                                            value="{{ $item2->account_main_id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip" data-bs-title="ลงข้อมูลบัญชีจ่ายสำเร็จ">
                                                            <i class="fa-solid fa-dollar-sign text-white" style="font-size:13px"></i>
                                                        </button>
                                                    @elseif ($item2->account_pay_active == 'TAKEDOWN') 
                                                        <button type="button" class="btn btn-warning btn-sm shadow editData_check"
                                                            value="{{ $item2->account_main_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="เช็คการลงข้อมูลบัญชีจ่าย">
                                                            เช็คข้อมูล
                                                            {{-- <i class="fa-solid fa-dollar-sign text-white"
                                                                style="font-size:13px"></i> --}}
                                                        </button>
                                                    @elseif ($item2->account_pay_active == 'REPFINISH') 
                                                        <button type="button" class="btn btn-success btn-sm shadow"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                               
                                                            data-bs-title="ลงข้อมูลบัญชีจ่ายสำเร็จ">
                                                            &nbsp;&nbsp;สำเร็จ&nbsp;&nbsp;
                                                            {{-- <i class="fa-solid fa-dollar-sign text-success"
                                                                style="font-size:13px"></i> --}}
                                                        </button>
                                                    @else 
                                                        {{-- <button type="button" class="btn btn-outline-primary btn-sm editData"
                                                            value="{{ $item2->account_main_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="ลงบัญชีจ่าย">
                                                            <i class="fa-solid fa-dollar-sign text-primary"
                                                                style="font-size:13px"></i>
                                                        </button> --}}
                                                    @endif
                                                </td>
                                            @endif
                                            {{-- <td width="3%" class="text-center">
                                                <button type="button" class="btn btn-outline-primary btn-sm editData"
                                                    value="{{ $item2->account_main_id }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="ลงบัญชีจ่าย">
                                                    <i class="fa-solid fa-dollar-sign text-primary"
                                                        style="font-size:13px"></i>
                                                </button>
                                            </td> --}}
                                            <td class="text-center" width="10%">{{ number_format($item2->tax, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->fund, 2) }} </td>
                                            <td class="text-end" width="5%">
                                                {{ number_format($item2->fundbackpay, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->add, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->installment, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->flat, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->share, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->loan, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->food, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->water, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->electric, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->coop, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->F24, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->F25, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->F26, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->F27, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->F28, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->F29, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->other, 2) }} </td>
                                            <td class="text-end" width="5%">
                                                {{ number_format($item2->expend_sum, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->balance, 2) }} </td>
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

    <!--  Modal content for the insertuserdata example -->
    {{-- <div class="modal fade" id="insertuserdata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">ประเภทบุคลากร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('acc.account_money_personsave') }}" method="POST" id="money_personsave">
                        @csrf
                        <input type="hidden" name="store_id" id="store_id" value="{{ $id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">ปี</label>
                                <div class="form-group mt-2 text-center">
                                    <select name="leave_year_id" id="leave_year_id" class="form-control form-control-sm"
                                        style="width: 100%">
                                        <option value="">=เลือก=</option>
                                        @foreach ($budget_year as $ye)
                                            @if ($strY == $ye->leave_year_id)
                                                <option value="{{ $ye->leave_year_id }}" selected>
                                                    {{ $ye->leave_year_id }}</option>
                                            @else
                                                <option value="{{ $ye->leave_year_id }}">{{ $ye->leave_year_id }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">เดือน</label>
                                <div class="form-group mt-2 text-center">
                                    <select name="MONTH_ID" id="MONTH_ID" class="form-control form-control-sm"
                                        style="width: 100%">
                                        <option value="">=เลือก=</option>
                                        @foreach ($leave_month as $leave)
                                            @if ($strM == $leave->MONTH_ID)
                                                <option value="{{ $leave->MONTH_ID }}" selected>
                                                    {{ $leave->MONTH_NAME }}</option>
                                            @else
                                                <option value="{{ $leave->MONTH_ID }}">{{ $leave->MONTH_NAME }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="">ประเภทบุคลากร</label>
                                <div class="form-group mt-2 text-center">
                                    <select name="account_main_type" id="account_main_type"
                                        class="form-control form-control-sm" style="width: 100%" required>
                                        <option value="">=เลือก=</option>
                                        @foreach ($users_group as $ug)
                                            <option value="{{ $ug->users_group_id }}">{{ $ug->users_group_name }}
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
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                เพิ่มบุคลากร
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div> --}}

    <!--  Modal content for the copydata example -->
    {{-- <div class="modal fade" id="copydata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">คัดลอกข้อมูลรายจ่ายบุคลากร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="store_idCopy" id="store_idCopy" value="{{ $id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">ปี</label>
                            <div class="form-group mt-2 text-center">
                                <select name="leave_year_id22" id="leave_year_id22" class="form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($budget_year as $ye)
                                        @if ($strY == $ye->leave_year_id)
                                            <option value="{{ $ye->leave_year_id }}" selected>
                                                {{ $ye->leave_year_id }}</option>
                                        @else
                                            <option value="{{ $ye->leave_year_id }}">{{ $ye->leave_year_id }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">เดือน</label>
                            <div class="form-group mt-2 text-center">
                                <select name="MONTH_ID22" id="MONTH_ID22" class="form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($leave_month as $leave)
                                        @if ($strM == $leave->MONTH_ID)
                                            <option value="{{ $leave->MONTH_ID }}" selected>
                                                {{ $leave->MONTH_NAME }}</option>
                                        @else
                                            <option value="{{ $leave->MONTH_ID }}">{{ $leave->MONTH_NAME }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">ประเภทบุคลากร</label>
                            <div class="form-group mt-2 text-center">
                                <select name="account_main_type22" id="account_main_type22"
                                    class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($users_group as $ug)
                                        <option value="{{ $ug->users_group_id }}">{{ $ug->users_group_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr class="text-center">
                    <label for="" style="font-size:17px;color:red;">คัดลอกไป</label>
                    <hr>

                    <div class="row">
                        <div class="col"> </div>

                        <div class="col-md-4">
                            <label for="">ปี</label>
                            <div class="form-group mt-2 text-center">
                                <select name="leave_year_id3" id="leave_year_id3" class="form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($budget_year as $ye)
                                        @if ($strY == $ye->leave_year_id)
                                            <option value="{{ $ye->leave_year_id }}" selected>
                                                {{ $ye->leave_year_id }}</option>
                                        @else
                                            <option value="{{ $ye->leave_year_id }}">{{ $ye->leave_year_id }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">เดือน</label>
                            <div class="form-group mt-2 text-center">
                                <select name="MONTH_ID3" id="MONTH_ID3" class="form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($leave_month as $leave)
                                        @if ($strM == $leave->MONTH_ID)
                                            <option value="{{ $leave->MONTH_ID }}" selected>
                                                {{ $leave->MONTH_NAME }}</option>
                                        @else
                                            <option value="{{ $leave->MONTH_ID }}">{{ $leave->MONTH_NAME }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col"> </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="SaveCopy" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                เพิ่มบุคลากร
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div> --}}

    <!--  Modal content for the Updatedata example -->
    <div class="modal fade" id="UpdatedataModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xls">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="myExtraLargeModalLabel" style="color: white">ลงข้อมูลบัญชีรายจ่ายบุคลากร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-1">
                            <label for="">ภาษี</label>
                            <div class="form-group mt-2">
                                <input type="text" name="tax" id="edittax"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">กบข./กสจ./สมทบ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="fund" id="editfund"
                                    class="form-control form-control-sm text-end" style="background-color: #fbff7d"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">กบข.</label>
                            <div class="form-group mt-2">
                                <input type="text" name="fundbackpay" id="editfundbackpay"
                                    class="form-control form-control-sm text-end" style="background-color: #fbff7d"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">ส่วนเพิ่ม %</label>
                            <div class="form-group mt-2">
                                <input type="text" name="add" id="editadd"
                                    class="form-control form-control-sm text-end" placeholder="ใส่เฉพาะเลข">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">ผ่อน</label>
                            <div class="form-group mt-2">
                                <input type="text" name="installment" id="editinstallment"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">แฟลต</label>
                            <div class="form-group mt-2">
                                <input type="text" name="flat" id="editflat"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">หุ้น</label>
                            <div class="form-group mt-2">
                                <input type="text" name="share" id="editshare"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">กู้</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="loan" id="editloan"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">คืน สสจ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="food" id="editfood"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">ค่าน้ำ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="water" id="editwater"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">ค่าไฟ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="electric" id="editelectric"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">สหกรณ์</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="coop" id="editcoop"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1 mt-2">
                            <label for="">ฌกส.</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F24" id="editF24"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">ธอส</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F25" id="editF25"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">ประกัน</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F26" id="editF26"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">KTB</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F27" id="editF27"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">GSB</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F28" id="editF28"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">SCB</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F29" id="editF29"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">กยศ./อื่นๆ</label>
                            <div class="form-group mt-2">
                                <input type="text" name="other" id="editother"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="account_main_id" id="editaccount_main_id" class="form-control">

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="Updatedata" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกรายจ่าย
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

     <!--  Modal content for the Updatedata_checkModal example -->
     <div class="modal fade" id="Updatedata_checkModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xls">
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgb(175, 97, 248)">
                    <h5 class="modal-title" id="myExtraLargeModalLabel" style="color: white">เช็คการลงข้อมูลรายจ่ายบุคลากร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-1">
                            <label for="">ภาษี</label>
                            <div class="form-group mt-2">
                                <input type="text" name="tax" id="edittax_check"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">กบข./กสจ./สมทบ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="fund" id="editfund_check"
                                    class="form-control form-control-sm text-end" style="background-color: #fbff7d"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">กบข.</label>
                            <div class="form-group mt-2">
                                <input type="text" name="fundbackpay" id="editfundbackpay_check"
                                    class="form-control form-control-sm text-end" style="background-color: #fbff7d"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            {{-- <label for="">ส่วนเพิ่ม %</label> --}}
                            <div class="form-group mt-2">
                                <input type="text" name="add" id="editadd_checkshow" class="form-control form-control-sm text-end" style="background-color: #fbff7d" readonly>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" name="add" id="editadd_check" class="form-control form-control-sm text-end" placeholder="ส่วนเพิ่ม %">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">ผ่อน</label>
                            <div class="form-group mt-2">
                                <input type="text" name="installment" id="editinstallment_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">แฟลต</label>
                            <div class="form-group mt-2">
                                <input type="text" name="flat" id="editflat_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">หุ้น</label>
                            <div class="form-group mt-2">
                                <input type="text" name="share" id="editshare_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">กู้</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="loan" id="editloan_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">คืน สสจ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="food" id="editfood_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">ค่าน้ำ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="water" id="editwater_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">ค่าไฟ</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="electric" id="editelectric_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="">สหกรณ์</label>
                            <div class="form-group mt-2 ">
                                <input type="text" name="coop" id="editcoop_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1 mt-2">
                            <label for="">ฌกส.</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F24" id="editF24_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">ธอส</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F25" id="editF25_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">ประกัน</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F26" id="editF26_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">KTB</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F27" id="editF27_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">GSB</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F28" id="editF28_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">SCB</label>
                            <div class="form-group mt-2">
                                <input type="text" name="F29" id="editF29_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="">กยศ./อื่นๆ</label>
                            <div class="form-group mt-2">
                                <input type="text" name="other" id="editother_check"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="account_main_id" id="editaccount_main_id_check" class="form-control">

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="Updatedata_check" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกรายจ่าย
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

     <!--  Modal content for the Updatepay_onlyModal example -->
     <div class="modal fade" id="Updatepay_onlyModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-xls">
         <div class="modal-content">
             <div class="modal-header bg-info">
                 <h5 class="modal-title" id="myExtraLargeModalLabel" style="color: white">ลงข้อมูลบัญชีรายจ่ายบุคลากร</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">

                 <div class="row">
                     <div class="col-md-1">
                         <label for="">ภาษี</label>
                         <div class="form-group mt-2">
                             <input type="text" name="tax" id="editpay_onlytax"
                                 class="form-control form-control-sm">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">กบข./กสจ./สมทบ</label>
                         <div class="form-group mt-2 ">
                             <input type="text" name="fund" id="editpay_onlyfund"
                                 class="form-control form-control-sm text-end" style="background-color: #fbff7d"
                                 readonly>
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">กบข.</label>
                         <div class="form-group mt-2">
                             <input type="text" name="fundbackpay" id="editpay_onlyfundbackpay"
                                 class="form-control form-control-sm text-end" style="background-color: #fbff7d"
                                 readonly>
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">ส่วนเพิ่ม %</label>
                         <div class="form-group mt-2">
                              
                                 <div class="form-group mt-2">
                                    <input type="text" name="add" id="editpay_onlyaddshow" class="form-control form-control-sm text-end" style="background-color: #fbff7d" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <input type="text" name="add" id="editpay_onlyadd" class="form-control form-control-sm text-end" placeholder="ส่วนเพิ่ม %">
                                </div>
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">ผ่อน</label>
                         <div class="form-group mt-2">
                             <input type="text" name="installment" id="editpay_onlyinstallment"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">แฟลต</label>
                         <div class="form-group mt-2">
                             <input type="text" name="flat" id="editpay_onlyflat"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">หุ้น</label>
                         <div class="form-group mt-2">
                             <input type="text" name="share" id="editpay_onlyshare"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">กู้</label>
                         <div class="form-group mt-2 ">
                             <input type="text" name="loan" id="editpay_onlyloan"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">คืน สสจ</label>
                         <div class="form-group mt-2 ">
                             <input type="text" name="food" id="editpay_onlyfood"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">ค่าน้ำ</label>
                         <div class="form-group mt-2 ">
                             <input type="text" name="water" id="editpay_onlywater"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">ค่าไฟ</label>
                         <div class="form-group mt-2 ">
                             <input type="text" name="electric" id="editpay_onlyelectric"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1">
                         <label for="">สหกรณ์</label>
                         <div class="form-group mt-2 ">
                             <input type="text" name="coop" id="editpay_onlycoop"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                 </div>

                 <div class="row">
                     <div class="col-md-1 mt-2">
                         <label for="">ฌกส.</label>
                         <div class="form-group mt-2">
                             <input type="text" name="F24" id="editpay_onlyF24"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1 mt-2">
                         <label for="">ธอส</label>
                         <div class="form-group mt-2">
                             <input type="text" name="F25" id="editpay_onlyF25"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1 mt-2">
                         <label for="">ประกัน</label>
                         <div class="form-group mt-2">
                             <input type="text" name="F26" id="editpay_onlyF26"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1 mt-2">
                         <label for="">KTB</label>
                         <div class="form-group mt-2">
                             <input type="text" name="F27" id="editpay_onlyF27"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1 mt-2">
                         <label for="">GSB</label>
                         <div class="form-group mt-2">
                             <input type="text" name="F28" id="editpay_onlyF28"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1 mt-2">
                         <label for="">SCB</label>
                         <div class="form-group mt-2">
                             <input type="text" name="F29" id="editpay_onlyF29"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                     <div class="col-md-1 mt-2">
                         <label for="">กยศ./อื่นๆ</label>
                         <div class="form-group mt-2">
                             <input type="text" name="other" id="editpay_onlyother"
                                 class="form-control form-control-sm text-end">
                         </div>
                     </div>
                 </div>
             </div>

             <input type="hidden" name="account_main_id" id="editpay_onlyaccount_main_id" class="form-control">

             <div class="modal-footer">
                 <div class="col-md-12 text-end">
                     <div class="form-group">
                         <button type="button" id="Updatedatapay_only" class="btn btn-primary btn-sm">
                             <i class="fa-solid fa-floppy-disk me-2"></i>
                             บันทึกรายจ่าย
                         </button>
                         <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                 class="fa-solid fa-xmark me-2"></i>Close</button>

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

            $('select').select2();
            $('#account_main_type').select2({
                dropdownParent: $('#insertuserdata')
            });
            $('#MONTH_ID').select2({
                dropdownParent: $('#insertuserdata')
            });
            $('#leave_year_id').select2({
                dropdownParent: $('#insertuserdata')
            });
            $('#addstore_id').select2({
                dropdownParent: $('#insertuserdata')
            });

            $('#account_main_type22').select2({
                dropdownParent: $('#copydata')
            });
            $('#MONTH_ID22').select2({
                dropdownParent: $('#copydata')
            });
            $('#leave_year_id22').select2({
                dropdownParent: $('#copydata')
            });

            $('#account_main_type3').select2({
                dropdownParent: $('#copydata')
            });
            $('#MONTH_ID3').select2({
                dropdownParent: $('#copydata')
            });
            $('#leave_year_id3').select2({
                dropdownParent: $('#copydata')
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

            $('#SaveCopy').click(function() {
                var leave_year_id22 = $('#leave_year_id22').val();
                var MONTH_ID22 = $('#MONTH_ID22').val();
                var account_main_type22 = $('#account_main_type22').val();
                var leave_year_id3 = $('#leave_year_id3').val();
                var MONTH_ID3 = $('#MONTH_ID3').val();
                var store_idCopy = $('#store_idCopy').val();

                $.ajax({
                    url: "{{ route('acc.account_money_copysave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        leave_year_id22,
                        MONTH_ID22,
                        account_main_type22,
                        leave_year_id3,
                        MONTH_ID3,
                        store_idCopy
                    },
                    success: function(data) {
                        if (data.status == 200) {
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
                                    console.log(data);
                                    window.location.reload();
                                }
                            })
                        } else if (data.status == 50) {
                            Swal.fire({
                                title: 'ไม่มีข้อมูล !!',
                                text: "You clicked the button !",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Back'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'ประเภทนี้ได้ถูกเพิ่มไปแล้ว',
                                text: "You clicked the button !",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Back'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }
                    },
                });
            });

            $(document).on('click', '.editData', function() {
                var account_main_id = $(this).val();
                // alert(account_main_id);
                $('#UpdatedataModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('account_money_payedit') }}" + '/' + account_main_id,
                    success: function(data) {
                        console.log(data.account.tax);
                        $('#edittax').val(data.account.tax)
                        $('#editfund').val(data.account.fund)
                        $('#editfundbackpay').val(data.account.fundbackpay)
                        // $('#editadd').val(data.account.add)
                        $('#editinstallment').val(data.account.installment)
                        $('#editflat').val(data.account.flat)
                        $('#editshare').val(data.account.share)
                        $('#editloan').val(data.account.loan)
                        $('#editfood').val(data.account.food)
                        $('#editwater').val(data.account.water)
                        $('#editelectric').val(data.account.electric)
                        $('#editcoop').val(data.account.coop)
                        $('#editF24').val(data.account.F24)
                        $('#editF25').val(data.account.F25)
                        $('#editF26').val(data.account.F26)
                        $('#editF27').val(data.account.F27)
                        $('#editF28').val(data.account.F28)
                        $('#editF29').val(data.account.F29)
                        $('#editother').val(data.account.other)
                        $('#editaccount_main_id').val(data.account.account_main_id)
                    },
                });
            });  
            $('#Updatedata').click(function() {
                var account_main_id = $('#editaccount_main_id').val();
                var tax = $('#edittax').val();
                var fund = $('#editfund').val();
                var fundbackpay = $('#editfundbackpay').val();
                var add = $('#editadd').val();
                var installment = $('#editinstallment').val();
                var flat = $('#editflat').val();
                var share = $('#editshare').val();
                var loan = $('#editloan').val();
                var food = $('#editfood').val();
                var water = $('#editwater').val();
                var electric = $('#editelectric').val();
                var coop = $('#editcoop').val();
                var F24 = $('#editF24').val();
                var F25 = $('#editF25').val();
                var F26 = $('#editF26').val();
                var F27 = $('#editF27').val();
                var F28 = $('#editF28').val();
                var F29 = $('#editF29').val();
                var other = $('#editother').val();
                $.ajax({
                    url: "{{ route('acc.account_money_payupdate') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_main_id,
                        tax,
                        fund,
                        fundbackpay,
                        add,
                        installment,
                        flat,
                        share,
                        loan,
                        food,
                        water,
                        electric,
                        coop,
                        F24,
                        F25,
                        F26,
                        F27,
                        F28,
                        F29,
                        other
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'จัดการข้อมูลสำเร็จ',
                                text: "You Manage data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            $(document).on('click', '.editData_check', function() {
                var account_main_id = $(this).val(); 
                $('#Updatedata_checkModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('account_money_payedit') }}" + '/' + account_main_id,
                    success: function(data) {
                        console.log(data.account.tax);
                        $('#edittax_check').val(data.account.tax)
                        $('#editfund_check').val(data.account.fund)
                        $('#editfundbackpay_check').val(data.account.fundbackpay)

                        $('#editadd_check').val()
                        $('#editadd_checkshow').val(data.account.add)
                        
                        $('#editinstallment_check').val(data.account.installment)
                        $('#editflat_check').val(data.account.flat)
                        $('#editshare_check').val(data.account.share)
                        $('#editloan_check').val(data.account.loan)
                        $('#editfood_check').val(data.account.food)
                        $('#editwater_check').val(data.account.water)
                        $('#editelectric_check').val(data.account.electric)
                        $('#editcoop_check').val(data.account.coop)
                        $('#editF24_check').val(data.account.F24)
                        $('#editF25_check').val(data.account.F25)
                        $('#editF26_check').val(data.account.F26)
                        $('#editF27_check').val(data.account.F27)
                        $('#editF28_check').val(data.account.F28)
                        $('#editF29_check').val(data.account.F29)
                        $('#editother_check').val(data.account.other)
                        $('#editaccount_main_id_check').val(data.account.account_main_id)
                    },
                });
            });

            $('#Updatedata_check').click(function() {
                var account_main_id = $('#editaccount_main_id_check').val();
                var tax = $('#edittax_check').val();
                var fund = $('#editfund_check').val();
                var fundbackpay = $('#editfundbackpay_check').val();

                var add = $('#editadd_check').val();

                var installment = $('#editinstallment_check').val();
                var flat = $('#editflat_check').val();
                var share = $('#editshare_check').val();
                var loan = $('#editloan_check').val();
                var food = $('#editfood_check').val();
                var water = $('#editwater_check').val();
                var electric = $('#editelectric_check').val();
                var coop = $('#editcoop_check').val();
                var F24 = $('#editF24_check').val();
                var F25 = $('#editF25_check').val();
                var F26 = $('#editF26_check').val();
                var F27 = $('#editF27_check').val();
                var F28 = $('#editF28_check').val();
                var F29 = $('#editF29_check').val();
                var other = $('#editother_check').val();
                $.ajax({
                    url: "{{ route('acc.account_money_paycheckupdate') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_main_id,
                        tax,
                        fund,
                        fundbackpay,
                        add,
                        installment,
                        flat,
                        share,
                        loan,
                        food,
                        water,
                        electric,
                        coop,
                        F24,
                        F25,
                        F26,
                        F27,
                        F28,
                        F29,
                        other
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'จัดการข้อมูลสำเร็จ',
                                text: "You Manage data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });


            //กรณีจ่ายอย่างเดียว จะลงรับหรือไม่ก็ได้
            $(document).on('click', '.editDatapay_only', function() {
                var account_main_id = $(this).val();
                // alert(account_main_id);
                $('#Updatepay_onlyModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('account_money_payedit') }}" + '/' + account_main_id,
                    success: function(data) {
                        console.log(data.account.tax);
                        $('#editpay_onlytax').val(data.account.tax)
                        $('#editpay_onlyfund').val(data.account.fund)
                        $('#editpay_onlyfundbackpay').val(data.account.fundbackpay)

                        $('#editpay_onlyadd').val()
                        $('#editpay_onlyaddshow').val(data.account.add)

                        $('#editpay_onlyinstallment').val(data.account.installment)
                        $('#editpay_onlyflat').val(data.account.flat)
                        $('#editpay_onlyshare').val(data.account.share)
                        $('#editpay_onlyloan').val(data.account.loan)
                        $('#editpay_onlyfood').val(data.account.food)
                        $('#editpay_onlywater').val(data.account.water)
                        $('#editpay_onlyelectric').val(data.account.electric)
                        $('#editpay_onlycoop').val(data.account.coop)
                        $('#editpay_onlyF24').val(data.account.F24)
                        $('#editpay_onlyF25').val(data.account.F25)
                        $('#editpay_onlyF26').val(data.account.F26)
                        $('#editpay_onlyF27').val(data.account.F27)
                        $('#editpay_onlyF28').val(data.account.F28)
                        $('#editpay_onlyF29').val(data.account.F29)
                        $('#editpay_onlyother').val(data.account.other)
                        $('#editpay_onlyaccount_main_id').val(data.account.account_main_id)
                    },
                });
            }); 
            $('#Updatedatapay_only').click(function() {
                var account_main_id = $('#editpay_onlyaccount_main_id').val();
                var tax = $('#editpay_onlytax').val();
                var fund = $('#editpay_onlyfund').val();
                var fundbackpay = $('#editpay_onlyfundbackpay').val();

                var add = $('#editpay_onlyadd').val();

                var installment = $('#editpay_onlyinstallment').val();
                var flat = $('#editpay_onlyflat').val();
                var share = $('#editpay_onlyshare').val();
                var loan = $('#editpay_onlyloan').val();
                var food = $('#editpay_onlyfood').val();
                var water = $('#editpay_onlywater').val();
                var electric = $('#editpay_onlyelectric').val();
                var coop = $('#editpay_onlycoop').val();
                var F24 = $('#editpay_onlyF24').val();
                var F25 = $('#editpay_onlyF25').val();
                var F26 = $('#editpay_onlyF26').val();
                var F27 = $('#editpay_onlyF27').val();
                var F28 = $('#editpay_onlyF28').val();
                var F29 = $('#editpay_onlyF29').val();
                var other = $('#editpay_onlyother').val();
                $.ajax({
                    url: "{{ route('acc.account_money_pay_onlyupdate') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_main_id,
                        tax,
                        fund,
                        fundbackpay,
                        add,
                        installment,
                        flat,
                        share,
                        loan,
                        food,
                        water,
                        electric,
                        coop,
                        F24,
                        F25,
                        F26,
                        F27,
                        F28,
                        F29,
                        other
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'จัดการข้อมูลสำเร็จ',
                                text: "You Manage data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            }); 
            

        });
        $(document).ready(function() {
            $('#money_personsave').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                // alert('OJJJJOL');
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 100) {
                            Swal.fire({
                                title: 'ข้อมูลถูกเพิ่มไปแล้ว !!',
                                text: "You clicked the button !",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Back'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else if (data.status == 50) {
                            Swal.fire({
                                title: 'ยังไม่มีข้อมูล !!',
                                text: "You clicked the button !",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Back'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            });
        });
    </script>


@endsection
