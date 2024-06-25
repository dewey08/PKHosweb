@extends('layouts.account')
@section('title', 'PK-OFFICER || Account')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        // function changstatus(account_main_id)
        // {
        // Swal.fire({
        // title: 'ลงบัญชีรับเสร็จแล้วใช่ไหม?',
        // text: "ข้อมูลนี้จะถ฿กส่งไปให้บัญชีจ่าย !!",
        // icon: 'warning',
        // showCancelButton: true,
        // confirmButtonColor: '#3085d6',
        // cancelButtonColor: '#d33',
        // confirmButtonText: 'ใช่, ส่งเดี่ยวนี้!',
        // cancelButtonText: 'ไม่, ยกเลิก'
        // }).then((result) => {
        // if (result.isConfirmed) {
        //     $.ajax({
        //     url:"{{ url('changstatus') }}" +'/'+ account_main_id,  
        //     type:'POST',
        //     data:{
        //         _token : $("input[name=_token]").val()
        //     },
        //     success:function(response)
        //     {          
        //         Swal.fire({
        //             title: 'ลงบัญชีรับสำเร็จ!',
        //             text: "You Save data success",
        //             icon: 'success',
        //             showCancelButton: false,
        //             confirmButtonColor: '#06D177',
        //             // cancelButtonColor: '#d33',
        //             confirmButtonText: 'เรียบร้อย'
        //         }).then((result) => {
        //             if (result.isConfirmed) {                  
        //             $("#sid"+account_main_id).remove();     
        //             window.location.reload();    
        //             }
        //         }) 
        //     }
        //     })        
        //     }
        //     })
        // }
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
    <div class="container-fluids">
        {{-- <div class="row">
            <div class="col-md-4"> <h5>บัญชีรับโรงพยาบาล {{$data_hos->users_hos_name}}</h5> </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div> --}}
        <form action="{{ url('account_money_rep/'. $id) }}" method="POST">
            @csrf
            <div class="row"> 
                <div class="col"></div>
                <div class="col-md-1 text-end">วันที่</div>
                <div class="col-md-2 text-center">
                    <div class="input-group" id="datepicker1">
                        <input type="text" class="form-control" name="startdate" id="datepicker"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-language="th-th"
                            data-date-autoclose="true" value="{{ $startdate }} ">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                    </div>
                </div>
                <div class="col-md-1 text-center">ถึงวันที่</div>
                <div class="col-md-2 text-center">
                    <div class="input-group" id="datepicker1">
                        <input type="text" class="form-control" name="enddate" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-language="th-th"
                            data-date-autoclose="true" value="{{ $enddate }} ">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
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
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                        ค้นหา
                    </button>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#insertuserdata"> 
                        เพิ่มเจ้าหน้าที่
                    </button>
                </div>

                <div class="col-md-1 text-start">
                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                        data-bs-target="#copydata"> 
                        คัดลอกข้อมูลเดิม
                    </button>

                </div>
            </div>
        </form>
        {{-- <div class="row ">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header ">
                            <form action="{{ url('account_money_rep/' . $id) }}" method="POST">
                                @csrf
                                <div class="row">
                                  
                                    <div class="col"></div>
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
                                    <div class="col-md-1 text-center">ถึงวันที่</div>
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


                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#insertuserdata">
                                           
                                            เพิ่มเจ้าหน้าที่
                                        </button>
                                    </div>

                                    <div class="col-md-1 text-start">
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#copydata"> 
                                            คัดลอกข้อมูลเดิม
                                        </button>

                                    </div>
                                </div>

                        </div>
        </form> --}}


        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4"> <h5>บัญชีรับโรงพยาบาล {{ $data_hos->users_hos_name }}</h5> </div>
                            <div class="col-md-1 text-end">
                                 <label for="" style="font-size: 15px">สถานะสี</label> 
                            </div>
                            <div class="col-md-4 "> 
                               <button type="button" class="btn ms-3" style="background-color: rgb(107, 239, 248)">ลงบัญชีรับ</button>
                               <button type="button" class="btn ms-3" style="background-color: rgb(19, 184, 196)">เช็คบัญชีรับ</button>
                           </div>
                           
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                        <div class="card-body shadow-lg">
                            <div class="table-responsive">
                                <table id="example"
                                    class="table table-striped table-bordered dt-responsive nowrap myTable"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">ลำดับ</th>
                                            <th class="text-center">เดือน/ปี</th>
                                            <th class="text-center">เลขบัตร ปชช</th>
                                            <th class="text-center">ชื่อ-สกุล</th>
                                            <th class="text-center">จัดการ</th>
                                            <th class="text-center">เลขที่บัญชี</th>
                                            <th class="text-center">เงินเดือน</th>
                                            <th class="text-center">ตกเบิก</th>
                                            <th class="text-center">ปจต.</th>
                                            <th class="text-center">8-11</th>
                                            <th class="text-center">ครองชีพ</th>
                                            <th class="text-center">2%4%</th>
                                            <th class="text-center">OT</th>
                                            <th class="text-center">รวมรับ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datashow as $item2)
                                            <?php
                                            $yearthai = $item2->account_main_year;
                                            $colorstatus = $item2->account_rep_active;
                                            if ($colorstatus == 'TAKEDOWN') {
                                                $color_new = 'background-color: rgb(107, 239, 248)';
                                            } elseif ($colorstatus == 'CHECK') {
                                                $color_new = 'background-color: rgb(19, 184, 196)';
                                            } elseif ($colorstatus == 'FINISH') {
                                                $color_new = 'background-color: rgb(156, 219, 7)';
                                            } elseif ($colorstatus == 'REQUEST') {
                                                $color_new = ' ';
                                            } else {
                                                $color_new = 'background-color: rgb(107, 180, 248)';
                                            }
                                            
                                            ?>

                                            <tr style="{{ $color_new }}">
                                                <td width="3%" style="background-color: rgb(156, 219, 7)">
                                                    {{ $i++ }}</td>

                                                @if ($item2->account_main_mounts == '1')
                                                    <td width="10%" class="text-center">มกราคม / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '2')
                                                    <td width="10%" class="text-center">กุมภาพันธ์ / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '3')
                                                    <td width="10%" class="text-center">มีนาคม / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '4')
                                                    <td width="10%" class="text-center">เมษายน / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '5')
                                                    <td width="10%" class="text-center">พฤษภาคม / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '6')
                                                    <td width="10%" class="text-center">มิถุนายน / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '7')
                                                    <td width="10%" class="text-center">กรกฎาคม / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '8')
                                                    <td width="10%" class="text-center">สิงหาคม / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '9')
                                                    <td width="10%" class="text-center">กันยายน / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '10')
                                                    <td width="10%" class="text-center">ตุลาคม / {{ $yearthai }}
                                                    </td>
                                                @elseif ($item2->account_main_mounts == '11')
                                                    <td width="10%" class="text-center">พฤษจิกายน /
                                                        {{ $yearthai }}</td>
                                                @else
                                                    <td width="10%" class="text-center">ธันวาคม / {{ $yearthai }}
                                                    </td>
                                                @endif



                                                <td class="text-center" width="10%">{{ $item2->cid }}</td>
                                                <td class="p-2">{{ $item2->prefix_name }}{{ $item2->fname }}
                                                    {{ $item2->lname }}</td>
                                                <td width="5%" class="text-center">

                                                    @if ($item2->account_rep_active == 'CHECK')
                                                        <button type="button" class="btn btn-outline-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="ลงบัญชีรับเสร็จแล้วรอลงบัญชีจ่าย">
                                                            <i class="fa-solid fa-dollar-sign text-success"
                                                                style="font-size:13px"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-success"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="ส่งข้อมูลไปบัญชีจ่ายแล้ว">
                                                            <i class="fa-solid fa-share-from-square text-success"
                                                                style="font-size:13px"></i>
                                                        </button>
                                                    @elseif ($item2->account_rep_active == 'TAKEDOWN')
                                                        {{-- status = TAKEDOWN --}}
                                                        <button type="button" class="btn btn-outline-info editData2"
                                                            value="{{ $item2->account_main_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="รอเช็คการลงบัญชีรับ">
                                                            <i class="fa-solid fa-dollar-sign text-info"
                                                                style="font-size:13px"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-info"
                                                            value="{{ $item2->account_main_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="เช็คการลงบัญชีรับให้เรียบร้อยก่อนส่งข้อมูลไปบัญชีจ่าย">
                                                            <i class="fa-solid fa-share-from-square text-info"
                                                                style="font-size:13px"></i>
                                                        </button>
                                                        {{-- <button type="button" class="btn btn-outline-info changstatus"
                                                            value="{{ $item2->account_main_id }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip" data-bs-title="ส่งข้อมูลไปบัญชีจ่าย">
                                                            <i class="fa-solid fa-share-from-square text-info" style="font-size:13px"></i> 
                                                        </button> --}}
                                                    @else
                                                        {{-- status = REQUEST --}}
                                                        <button type="button" class="btn btn-outline-warning editData"
                                                            value="{{ $item2->account_main_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip"
                                                            data-bs-title="ลงบัญชีรับ">
                                                            <i class="fa-solid fa-dollar-sign text-danger"
                                                                style="font-size:13px"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-warning"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-custom-class="custom-tooltip colortool"
                                                            data-bs-title="ลงบัญชีรับให้เรียบร้อยก่อนส่งข้อมูลไปบัญชีจ่าย">
                                                            <i class="fa-solid fa-share-from-square text-primary"
                                                                style="font-size:13px"></i>
                                                        </button>
                                                    @endif


                                                </td>
                                                <td class="text-center" width="10%"> {{ $item2->acc }} </td>
                                                <td class="text-end" width="7%">
                                                    {{ number_format($item2->salary, 2) }}
                                                </td>
                                                <td class="text-end" width="7%">
                                                    {{ number_format($item2->backpay, 2) }}
                                                </td>
                                                <td class="text-end" width="7%">
                                                    {{ number_format($item2->positionpay, 2) }}</td>
                                                <td class="text-end" width="7%">{{ number_format($item2->a0811, 2) }}
                                                </td>
                                                <td class="text-end" width="7%">
                                                    {{ number_format($item2->cost_of_living, 2) }}</td>
                                                <td class="text-end" width="7%">
                                                    {{ number_format($item2->a24percent, 2) }}</td>
                                                <td class="text-end" width="7%">{{ number_format($item2->ot, 2) }}
                                                </td>
                                                <td class="text-end" width="10%">
                                                    {{ number_format($item2->revenue_sum, 2) }}</td>
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
        <div class="modal fade" id="insertuserdata" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
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
                                        <select name="leave_year_id" id="leave_year_id"
                                            class="form-control form-control-sm" style="width: 100%">
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
        </div>

        <!--  Modal content for the copydata example -->
        <div class="modal fade" id="copydata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">คัดลอกข้อมูลรายรับบุคลากร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="store_idCopy" id="store_idCopy" value="{{ $id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="">ปี</label>
                                <div class="form-group mt-2 text-center">
                                    <select name="leave_year_id22" id="leave_year_id22"
                                        class="form-control form-control-sm" style="width: 100%" required>
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
                                    <select name="leave_year_id3" id="leave_year_id3"
                                        class="form-control form-control-sm" style="width: 100%" required>
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
        <div class="modal fade" id="UpdatedataModal" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xls">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">ปรับปรุงข้อมูลรายรับบุคลากร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="">เลขที่บัญชี</label>
                                <div class="form-group mt-2">
                                    <input type="text" name="acc" id="editacc"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-2 ">
                                <label for="">เงินเดือน</label>
                                <div class="form-group mt-2 ">
                                    <input type="text" name="salary" id="editsalary"
                                        class="form-control form-control-sm text-end">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="">ตกเบิก</label>
                                <div class="form-group mt-2">
                                    <input type="text" name="backpay" id="editbackpay"
                                        class="form-control form-control-sm text-end">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="">ปจต</label>
                                <div class="form-group mt-2">
                                    <input type="text" name="positionpay" id="editpositionpay"
                                        class="form-control form-control-sm text-end">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="">8-11</label>
                                <div class="form-group mt-2">
                                    <input type="text" name="a0811" id="edita0811"
                                        class="form-control form-control-sm text-end">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="">ครองชีพ</label>
                                <div class="form-group mt-2">
                                    <input type="text" name="cost_of_living" id="editcost_of_living"
                                        class="form-control form-control-sm text-end">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="">2%4%</label>
                                <div class="form-group mt-2">
                                    <input type="text" name="a24percent" id="edita24percent"
                                        class="form-control form-control-sm text-end">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label for="">OT</label>
                                <div class="form-group mt-2 ">
                                    <input type="text" name="ot" id="editot"
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
                                    บันทึกรายรับ
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

        <!-- Modal -->
        <div class="modal fade" id="ChangstatusModal" tabindex="-1" aria-labelledby="ChangstatusModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title " id="ChangstatusModalLabel">
                            ลงบัญชีรับเสร็จแล้วต้องการส่งไปให้บัญชีจ่ายใช่ไหม?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="account_main_id" id="chang_account_main_id" class="form-control">

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <label for="pcustomer_code" style="font-size: 15px">ข้อมูลนี้จะถูกส่งไปให้บัญชีจ่าย
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="ChangstatusUpdate" class="btn btn-outline-success">
                            <i class="fa-solid fa-floppy-disk me-2"></i>
                            ส่งข้อมูล</button>

                    </div>
                    </form>
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
                        url: "{{ url('account_money_personedit') }}" + '/' + account_main_id,
                        success: function(data) {
                            console.log(data.account.acc);
                            $('#editacc').val(data.account.acc)
                            $('#editsalary').val(data.account.salary)
                            $('#editbackpay').val(data.account.backpay)
                            $('#editpositionpay').val(data.account.positionpay)
                            $('#edita0811').val(data.account.a0811)
                            $('#editcost_of_living').val(data.account.cost_of_living)
                            $('#edita24percent').val(data.account.a24percent)
                            $('#editot').val(data.account.ot)
                            $('#editaccount_main_id').val(data.account.account_main_id)
                        },
                    });
                });
                $('#Updatedata').click(function() {
                    var account_main_id = $('#editaccount_main_id').val();
                    var acc = $('#editacc').val();
                    var salary = $('#editsalary').val();
                    var backpay = $('#editbackpay').val();
                    var positionpay = $('#editpositionpay').val();
                    var a0811 = $('#edita0811').val();
                    var cost_of_living = $('#editcost_of_living').val();
                    var a24percent = $('#edita24percent').val();
                    var ot = $('#editot').val();
                    $.ajax({
                        url: "{{ route('acc.account_money_personupdate') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            account_main_id,
                            acc,
                            salary,
                            backpay,
                            positionpay,
                            a0811,
                            cost_of_living,
                            a24percent,
                            ot
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

                $(document).on('click', '.changstatus', function() {
                    var account_main_id = $(this).val();
                    $('#ChangstatusModal').modal('show');
                    $.ajax({
                        type: "GET",
                        url: "{{ url('changstatus') }}" + '/' + account_main_id,
                        success: function(data) {
                            $('#chang_account_main_id').val(data.accountstatus.account_main_id)
                        },
                    });
                });
                $('#ChangstatusUpdate').click(function() {
                    var account_main_id = $('#chang_account_main_id').val();

                    $.ajax({
                        url: "{{ route('acc.account_money_repupdate') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            account_main_id

                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'ส่งข้อมูลสำเร็จ',
                                    text: "You Send data success",
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
