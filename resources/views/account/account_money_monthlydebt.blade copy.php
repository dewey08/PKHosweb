@extends('layouts.account')
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
        <div class="row ">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <form action="{{ url('account_money_monthlydebt/'.$id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-1 text-left">ข้อมูลหนี้รายเดือน</div>
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
                                    <select name="account_monthlydebt_type" id="account_monthlydebt_type2"
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
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#insertuserdata">
                                        {{-- <i class="fa-solid fa-folder-plus text-primary me-2"></i> --}}
                                        เพิ่มเจ้าหน้าที่
                                    </button>
                                </div>

                                <div class="col-md-1 text-start">
                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#copydata">
                                        {{-- <i class="fa-solid fa-folder-plus text-primary me-2"></i> --}}
                                        คัดลอกข้อมูลเดิม
                                    </button>

                                </div>
                            </div>

                    </div>
                    </form>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>                                    
                                    <tr>
                                        <th rowspan="2" style="text-align: center">ลำดับ</th>
                                        <th rowspan="2" class="text-center">เดือน/ปี</th>
                                        <th rowspan="2" class="text-center">เลขบัตร ปชช</th>
                                        <th rowspan="2" style="text-align: center" width="12%">ชื่อ-สกุล</th>
                                        <th rowspan="2" class="text-center">จัดการ</th>  
                                        <th colspan="2" style="text-align: center">สหกรณ์ออมทรัพย์</th>
                                        <th colspan="2" style="text-align: center">ธนาคารอาคารสงเคราะห์</th>
                                        <th colspan="2" style="text-align: center">ธนาคารออมสิน</th>
                                        <th colspan="2" style="text-align: center">ธนาคารกรุงไทย</th>
                                        <th colspan="2" style="text-align: center">ฌาปนกิจ</th>
                                        <th colspan="2" style="text-align: center">หนี้สินอื่น ๆ</th>
                                        <th colspan="6" style="text-align: center">ธนาคารไทยพาณิชย์</th> 
                                    </tr>
                                    <tr>
                                        <td style="text-align: center">รหัสหนี้</td>
                                        <td style="text-align: center">จำนวนเงิน</td>
                                        <td style="text-align: center">รหัสหนี้</td>
                                        <td style="text-align: center">จำนวนเงิน</td>
                                        <td style="text-align: center">รหัสหนี้</td>
                                        <td style="text-align: center">จำนวนเงิน</td>
                                        <td style="text-align: center">รหัสหนี้</td>
                                        <td style="text-align: center">จำนวนเงิน</td>
                                        <td style="text-align: center">รหัสหนี้</td>
                                        <td style="text-align: center">จำนวนเงิน</td>
                                        <td style="text-align: center">รหัสหนี้</td>
                                        <td style="text-align: center">จำนวนเงิน</td>
                                        <td style="text-align: center">รหัสหนี้</td>
                                        <td style="text-align: center">จำนวนเงิน</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item2)
                                    <?php $yearthai = $item2->account_monthlydebt_year ?>

                                        <tr id="sid{{ $item2->account_monthlydebt_id }}">
                                            <td width="3%">{{ $i++ }}</td> 

                                            @if ($item2->account_monthlydebt_mounts == '1')
                                                <td width="10%" class="text-center">มกราคม / {{$yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '2')
                                                <td width="10%" class="text-center">กุมภาพันธ์ / {{$yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '3')
                                                <td width="10%" class="text-center">มีนาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '4')
                                                <td width="10%" class="text-center">เมษายน / {{$yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '5')
                                                <td width="10%" class="text-center">พฤษภาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '6')
                                                <td width="10%" class="text-center">มิถุนายน / {{ $yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '7')
                                                <td width="10%" class="text-center">กรกฎาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '8')
                                                <td width="10%" class="text-center">สิงหาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '9')
                                                <td width="10%" class="text-center">กันยายน / {{ $yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '10')
                                                <td width="10%" class="text-center">ตุลาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_monthlydebt_mounts == '11')
                                                <td width="10%" class="text-center">พฤษจิกายน / {{ $yearthai}}</td>
                                            @else
                                                <td width="10%" class="text-center">ธันวาคม / {{ $yearthai}}</td>
                                            @endif  

                                            <td class="text-center" width="10%">{{ $item2->cid }}</td>
                                            <td class="p-2">{{ $item2->prefix_name }}{{ $item2->fname }} {{ $item2->lname }}</td>
                                            <td width="3%" class="text-center">
                                                <button type="button" class="btn btn-outline-success editData" value="{{ $item2->account_monthlydebt_id }}">
                                                    <i class="fa-solid fa-dollar-sign text-danger"></i>
                                                </button>
                                                {{-- <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#UpdatedataModal{{$item2->account_monthlydebt_id}}">
                                                    <i class="fa-solid fa-dollar-sign text-danger"></i>
                                                </button> --}}
                                            </td>
                                          
                                            <td class="text-center" width="10%">{{ $item2->shk_code }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->shk_price, 2) }} </td>
                                            <td class="text-end" width="5%">{{$item2->tos_code}} </td>                                           
                                            <td class="text-end" width="5%">{{ number_format($item2->tos_price, 2) }} </td>
                                            <td class="text-end" width="5%">{{ $item2->os_code}}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->os_price, 2) }}</td>
                                            <td class="text-end" width="5%">{{ $item2->ktb_code}}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->ktb_price, 2) }}</td>
                                            <td class="text-end" width="5%">{{ $item2->cremation_code }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->cremation_price, 2) }}</td>
                                            <td class="text-end" width="5%">{{$item2->other_code }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->other_price, 2) }}</td>
                                            <td class="text-end" width="5%">{{ $item2->scb_code }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->scb_price, 2) }}</td>       
                                        </tr>

                                         <!--  Modal content for the Updatedata example -->
                                        {{-- <div class="modal fade" id="UpdatedataModal{{$item2->account_monthlydebt_id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xls">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myExtraLargeModalLabel">ปรับปรุงข้อมูลข้อมูลหนี้รายเดือน</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body"> 
                                                        <div class="row">
                                                            <div class="col-md-2 mt-2">
                                                                <label for="">สหกรณ์ออมทรัพย์</label>
                                                                <div class="form-group mt-2"> 
                                                                    <select name="shk_code" id="shk_code" class="form-control js-example-theme-single" style="width: 100%">
                                                                    <option value="">=เลือก=</option>
                                                                            @foreach ($account_creditor as $creditor)
                                                                                @if ($main_type == $ug->users_group_id)
                                                                                    <option value="{{ $ug->users_group_id }}" selected> {{ $ug->users_group_name }}</option>
                                                                                @else
                                                                                    <option value="{{ $creditor->account_creditor_code }}">{{ $creditor->account_creditor_name }} </option>
                                                                                @endif
                                                                            @endforeach
                                                                    </select>
                                                                    <br>
                                                                    <input type="text" name="shk_price" id="editshk_price" class="form-control form-control-sm text-end">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 mt-2">
                                                                <label for="">ธนาคารอาคารสงเคราะห์</label>
                                                                <div class="form-group mt-2">
                                                                    <input type="text" name="tos_price" id="edittos_price" class="form-control form-control-sm text-end">
                                                                    <input type="hidden" name="tos_code" id="edittos_code" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 mt-2">
                                                                <label for="">ธนาคารออมสิน</label>
                                                                <div class="form-group mt-2">
                                                                    <input type="text" name="os_price" id="editos_price" class="form-control form-control-sm text-end">
                                                                    <input type="hidden" name="os_code" id="editos_code" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 mt-2">
                                                                <label for=""> ธนาคารกรุงไทย</label>
                                                                <div class="form-group mt-2">
                                                                    <input type="text" name="ktb_price" id="editktb_price" class="form-control form-control-sm text-end">
                                                                    <input type="hidden" name="ktb_code" id="editktb_code" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 mt-2">
                                                                <label for="">ธนาคารไทยพาณิชย์</label>
                                                                <div class="form-group mt-2">
                                                                    <input type="text" name="scb_price" id="editscb_price" class="form-control form-control-sm text-end">
                                                                    <input type="hidden" name="scb_code" id="editscb_code" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 mt-2">
                                                                <label for=""> ฌาปนกิจ</label>
                                                                <div class="form-group mt-2">
                                                                    <input type="text" name="cremation_price" id="editcremation_price" class="form-control form-control-sm text-end">
                                                                    <input type="hidden" name="cremation_code" id="editcremation_code" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 mt-2">
                                                                <label for="">หนี้สินอื่น ๆ  </label>
                                                                <div class="form-group mt-2">
                                                                    <input type="text" name="other_price" id="editother_price" class="form-control form-control-sm text-end">
                                                                    <input type="hidden" name="other_code" id="editother_code" class="form-control">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="account_monthlydebt_id" id="editaccount_monthlydebt_id" class="form-control">

                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-end">
                                                            <div class="form-group">
                                                                <button type="button" id="Updatedata" class="btn btn-primary btn-sm">
                                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                    บันทึกรายรับ
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark me-2"></i>Close</button>

                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div> --}}

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
    <div class="modal fade" id="insertuserdata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มข้อมูลลูกหนี้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('acc.account_money_monthlydebt_personsave') }}" method="POST" id="monthlydebt_personsave">
                        @csrf
                        <input type="hidden" name="store_id" id="store_id" value="{{$id}}">
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
                                    <select name="account_monthlydebt_type" id="account_monthlydebt_type"
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
    </div>

    <!--  Modal content for the copydata example -->
    <div class="modal fade" id="copydata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">คัดลอกข้อมูลรายรับบุคลากร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="store_idCopy" id="store_idCopy" value="{{$id}}">
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
                                <select name="account_monthlydebt_type22" id="account_monthlydebt_type22"
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
                {{-- </form> --}}
            </div>
        </div>
    </div>

    <!--  Modal content for the Updatedata example -->
    <div class="modal fade" id="UpdatedataModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xls">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">ปรับปรุงข้อมูลข้อมูลหนี้รายเดือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-2 mt-2"> 
                            <div class="form-group mt-2">    
                                <select name="shk_code" id="editshk_code" class="form-control js-example-theme-single" style="width: 100%" >
                                
                                        @foreach ($account_creditor as $creditor) 
                                        @if ($creditor->account_creditor_id == '1')
                                        <option value="{{ $creditor->account_creditor_code }}" selected >{{ $creditor->account_creditor_name }} </option> 
                                        @else
                                        <option value="{{ $creditor->account_creditor_code }}" disabled>{{ $creditor->account_creditor_name }} </option> 
                                        @endif 
                                                
                                        @endforeach
                                </select>
                                <label for="" class="mt-2">จำนวนเงิน</label>
                                <input type="text" name="shk_price" id="editshk_price" class="form-control form-control-sm text-end ">
                            </div>
                        </div>
                        <div class="col-md-2 mt-2"> 
                            <div class="form-group mt-2"> 
                                <select name="tos_code" id="edittos_code" class="form-control js-example-theme-single" style="width: 100%">
                           
                                            @foreach ($account_creditor as $creditor) 
                                            @if ($creditor->account_creditor_id == '2')
                                            <option value="{{ $creditor->account_creditor_code }}" selected>{{ $creditor->account_creditor_name }} </option> 
                                            @else
                                            <option value="{{ $creditor->account_creditor_code }}" disabled>{{ $creditor->account_creditor_name }} </option> 
                                            @endif 
                                                   
                                            @endforeach
                                </select>
                                <label for="" class="mt-2">จำนวนเงิน</label>
                                <input type="text" name="tos_price" id="edittos_price" class="form-control form-control-sm text-end ">
                            </div>
                        </div>
                        <div class="col-md-2 mt-2"> 
                            <div class="form-group mt-2">
                                <select name="os_code" id="editos_code" class="form-control js-example-theme-single" style="width: 100%">                           
                                        @foreach ($account_creditor as $creditor) 
                                        @if ($creditor->account_creditor_id == '3')
                                        <option value="{{ $creditor->account_creditor_code }}" selected>{{ $creditor->account_creditor_name }} </option> 
                                        @else
                                        <option value="{{ $creditor->account_creditor_code }}" disabled>{{ $creditor->account_creditor_name }} </option> 
                                        @endif                                             
                                        @endforeach
                                </select>
                                <label for="" class="mt-2">จำนวนเงิน</label>                    
                                <input type="text" name="os_price" id="editos_price" class="form-control form-control-sm text-end">                                
                            </div>
                        </div>
                        <div class="col-md-2 mt-2"> 
                            <div class="form-group mt-2"> 
                                <select name="ktb_code" id="editktb_code" class="form-control js-example-theme-single" style="width: 100%">                           
                                    @foreach ($account_creditor as $creditor) 
                                    @if ($creditor->account_creditor_id == '4')
                                    <option value="{{ $creditor->account_creditor_code }}" selected>{{ $creditor->account_creditor_name }} </option> 
                                    @else
                                    <option value="{{ $creditor->account_creditor_code }}" disabled>{{ $creditor->account_creditor_name }} </option> 
                                    @endif                                         
                                    @endforeach
                                </select>
                                <label for="" class="mt-2">จำนวนเงิน</label>                    
                                <input type="text" name="ktb_price" id="editktb_price" class="form-control form-control-sm text-end"> 
                            </div>
                        </div>
                        <div class="col-md-2 mt-2"> 
                            <div class="form-group mt-2"> 
                                <select name="scb_code" id="editscb_code" class="form-control js-example-theme-single" style="width: 100%">                           
                                    @foreach ($account_creditor as $creditor) 
                                    @if ($creditor->account_creditor_id == '7')
                                    <option value="{{ $creditor->account_creditor_code }}" selected>{{ $creditor->account_creditor_name }} </option> 
                                    @else
                                    <option value="{{ $creditor->account_creditor_code }}" disabled>{{ $creditor->account_creditor_name }} </option> 
                                    @endif                                         
                                    @endforeach
                                </select>
                                <label for="" class="mt-2">จำนวนเงิน</label>                    
                                <input type="text" name="scb_price" id="editscb_price" class="form-control form-control-sm text-end"> 
                            </div>
                        </div>
                        {{-- ฌาปนกิจ --}}
                        <div class="col-md-1 mt-2"> 
                            <div class="form-group mt-2"> 
                                <select name="cremation_code" id="editcremation_code" class="form-control js-example-theme-single" style="width: 100%">                           
                                    @foreach ($account_creditor as $creditor) 
                                    @if ($creditor->account_creditor_id == '5')
                                    <option value="{{ $creditor->account_creditor_code }}" selected>{{ $creditor->account_creditor_name }} </option> 
                                    @else
                                    <option value="{{ $creditor->account_creditor_code }}" disabled>{{ $creditor->account_creditor_name }} </option> 
                                    @endif                                         
                                    @endforeach
                                </select>
                                <label for="" class="mt-2">จำนวนเงิน</label>                    
                                <input type="text" name="cremation_price" id="editcremation_price" class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            {{-- <label for="">หนี้สินอื่น ๆ  </label> --}}
                            <div class="form-group mt-2">
                                {{-- <input type="text" name="other_price" id="editother_price" class="form-control form-control-sm text-end">
                                <input type="hidden" name="other_code" id="editother_code" class="form-control"> --}}
                                <select name="other_code" id="editother_code" class="form-control js-example-theme-single" style="width: 100%">                           
                                    @foreach ($account_creditor as $creditor) 
                                    @if ($creditor->account_creditor_id == '6')
                                    <option value="{{ $creditor->account_creditor_code }}" selected>{{ $creditor->account_creditor_name }} </option> 
                                    @else
                                    <option value="{{ $creditor->account_creditor_code }}" disabled>{{ $creditor->account_creditor_name }} </option> 
                                    @endif                                         
                                    @endforeach
                                </select>
                                <label for="" class="mt-2">จำนวนเงิน</label>                    
                                <input type="text" name="other_price" id="editother_price" class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        
                    </div>
                </div>

                <input type="hidden" name="account_monthlydebt_id" id="editaccount_monthlydebt_id" class="form-control">

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="Updatedata" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกรายรับ
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

            $(".js-example-theme-single").select2({
                theme: "classic"
                });

            $('select').select2();
            $('#account_monthlydebt_type').select2({
                dropdownParent: $('#insertuserdata')
            });
            

            $('#editshk_code').select2({
                dropdownParent: $('#UpdatedataModal')
            });
            $('#edittos_code').select2({
                dropdownParent: $('#UpdatedataModal')
            });
            $('#editos_code').select2({
                dropdownParent: $('#UpdatedataModal')
            });
            $('#editktb_code').select2({
                dropdownParent: $('#UpdatedataModal')
            });
            $('#editscb_code').select2({
                dropdownParent: $('#UpdatedataModal')
            });
            $('#editcremation_code').select2({
                dropdownParent: $('#UpdatedataModal')
            });
            $('#editother_code').select2({
                dropdownParent: $('#UpdatedataModal')
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

            $('#account_monthlydebt_type22').select2({
                dropdownParent: $('#copydata')
            });
            $('#MONTH_ID22').select2({
                dropdownParent: $('#copydata')
            });
            $('#leave_year_id22').select2({
                dropdownParent: $('#copydata')
            });

            $('#account_monthlydebt_type3').select2({
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
                var account_monthlydebt_type22 = $('#account_monthlydebt_type22').val();
                var leave_year_id3 = $('#leave_year_id3').val();
                var MONTH_ID3 = $('#MONTH_ID3').val();
                var store_idCopy = $('#store_idCopy').val();

                $.ajax({
                    url: "{{ route('acc.account_money_monthlydebt_copypersonsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        leave_year_id22,
                        MONTH_ID22,
                        account_monthlydebt_type22,
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
                        }else if (data.status == 50){
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
                var account_monthlydebt_id = $(this).val();

                // alert(account_monthlydebt_id);
                $('#UpdatedataModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('account_money_monthlydebtedit') }}" + '/' + account_monthlydebt_id,
                    success: function(data) {
                        console.log(data.account.shk_price); 
                        $('#editshk_price').val(data.account.shk_price)
                        // $('#editshk_code').val(data.account.shk_code)
                        $('#edittos_price').val(data.account.tos_price) 
                        // $('#edittos_code').val(data.account.tos_code)
                        $('#editos_price').val(data.account.os_price)
                        // $('#editos_code').val(data.account.os_code)
                        $('#editktb_price').val(data.account.ktb_price)
                        // $('#editktb_code').val(data.account.ktb_code)
                        $('#editcremation_price').val(data.account.cremation_price)
                        // $('#editcremation_code').val(data.account.cremation_code)
                        $('#editother_price').val(data.account.other_price)
                        // $('#editother_code').val(data.account.other_code)
                        $('#editscb_price').val(data.account.scb_price)
                        // $('#editscb_code').val(data.account.scb_code) 
                        $('#editaccount_monthlydebt_id').val(data.account.account_monthlydebt_id)
                    },
                });
            });
            $('#Updatedata').click(function() {
                var account_monthlydebt_id = $('#editaccount_monthlydebt_id').val();
                var shk_price = $('#editshk_price').val();
                var shk_code = $('#editshk_code').val();
                var tos_price = $('#edittos_price').val();
                var tos_code = $('#edittos_code').val();
                var os_price = $('#editos_price').val();
                var os_code = $('#editos_code').val();
                var ktb_price = $('#editktb_price').val();
                var ktb_code = $('#editktb_code').val();
                var cremation_price = $('#editcremation_price').val();
                var cremation_code = $('#editcremation_code').val();
                var other_price = $('#editother_price').val();
                var other_code = $('#editother_code').val();
                var scb_price = $('#editscb_price').val();
                var scb_code = $('#editscb_code').val(); 

                
                $.ajax({
                    url: "{{ route('acc.account_money_monthlydebtupdate') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_monthlydebt_id, shk_price, shk_code, tos_price,tos_code,os_price,
                        os_code,ktb_price,ktb_code,cremation_price,cremation_code,other_price,other_code,scb_price,scb_code 
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
                        }else if (data.status == 50){
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

            $('#monthlydebt_personsave').on('submit', function(e) {
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
                        }else if (data.status == 50){
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
