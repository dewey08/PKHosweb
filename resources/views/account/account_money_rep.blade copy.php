@extends('layouts.account')
@section('title', 'PK-OFFICER || Account')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
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
                        <form action="{{ route('acc.account_money_rep') }}" method="POST">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-md-1 text-start">บัญชีรับ</div> --}}
                                {{-- <div class="col"></div>  --}}
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


                                <div class="col-md-1 text-start">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#insertuserdata">
                                        {{-- <i class="fa-solid fa-folder-plus text-primary me-2"></i> --}}
                                        เพิ่มเจ้าหน้าที่
                                    </button>
                                </div>

                                <div class="col-md-2 text-start">
                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#copydata">
                                        {{-- <i class="fa-solid fa-folder-plus text-primary me-2"></i> --}}
                                        คัดลอกข้อมูลเดิม
                                    </button>

                                    {{-- <div class="col"></div> --}}
                                    {{-- <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#insertdata">
                                    <i class="fa-solid fa-folder-plus text-success me-2"></i>
                                    เพิ่มรายรับ
                                </button> --}}
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
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">เลขบัตร ปชช</th>
                                        <th class="text-center">ชื่อ-สกุล</th>
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
                                        <tr id="sid{{ $item2->account_main_id }}">
                                            <td width="5%">{{ $i++ }}</td>
                                            <td class="text-center" width="10%">{{ $item2->cid }}</td>
                                            <td class="p-2">{{ $item2->prefix_name }}{{ $item2->fname }}
                                                {{ $item2->lname }}</td>
                                            {{-- <td class="text-center" width="7%">{{ $item2->acc }}</td> --}}
                                            <td class="text-center" width="7%">
                                                <a href="" class="form-control form-control-sm update" data-name="acc" data-type="text" data-pk="{{ $item2->account_main_id }}" data-title="Enter name">{{ $item2->acc }}</a>
                                                {{-- <input id="rep{{$item2->account_main_id}}" name="rep{{$item2->account_main_id}}" class="form-control form-control-sm inputs{{$i}}" style=" font-family: 'Kanit', sans-serif;" onkeyup="accrep({{$item2->account_main_id}},{{$i}});"/> --}}
                                                
                                                {{-- <a href=""  id="inline-acc" data-name="acc" data-type="text" data-pk="{{ $item2->account_main_id }}" data-placement="right"
                                                    data-title="Enter your firstname">{{$item2->acc}}
                                                </a> --}}

                                                {{-- <a href="" class="update" data-name="name id="inline-acc" data-type="text" data-pk="{{ $item2->account_main_id }}" data-placement="right"
                                                    data-placeholder="Required" data-title="Enter your firstname">
                                                </a> --}}
                                                {{-- <input type="text" class="form-control form-control-sm" name="tacc" id="tacc" onkeyup="acc({{$item2->account_main_id}})" > --}}
                                            </td>
                                            <td class="text-center" width="7%">{{ $item2->salary }}</td>
                                            <td class="text-center" width="7%">{{ $item2->backpay }}</td>
                                            <td class="text-center" width="7%">{{ $item2->positionpay }}</td>
                                            <td class="text-center" width="7%">{{ $item2->a0811 }}</td>
                                            <td class="text-center" width="7%">{{ $item2->cost_of_living }}</td>
                                            <td class="text-center" width="7%">{{ $item2->a24percent }}</td>
                                            <td class="text-center" width="7%">{{ $item2->ot }}</td>
                                            <td class="text-center" width="10%">{{ $item2->revenue_sum }}</td>
                                        </tr>
                                        <?php  $i++;?>
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">ประเภทบุคลากร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('acc.account_money_personsave') }}" method="POST" id="money_personsave">
                        @csrf
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
                    {{-- <form action="{{ route('acc.account_money_personsave') }}" method="POST" id="money_personsave">
                         @csrf --}}
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">ปี</label>
                            <div class="form-group mt-2 text-center">
                                <select name="leave_year_id22" id="leave_year_id22" class="form-control form-control-sm"
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
                                <select name="MONTH_ID22" id="MONTH_ID22" class="form-control form-control-sm"
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
                                <select name="MONTH_ID3" id="MONTH_ID3" class="form-control form-control-sm"
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
                // var account_main_type3 = $('#account_main_type3').val();
                alert(MONTH_ID3);
                $.ajax({
                    url: "{{ route('acc.account_money_copysave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        leave_year_id22,
                        MONTH_ID22,
                        account_main_type22,
                        leave_year_id3,
                        MONTH_ID3
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
    <script>
        // $(document).ready(function() {
            $.fn.editable.defaults.mode = 'inline';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('.update').editable({
            url: "{{ route('acc.account_money_personupdate') }}",
            type: 'text',
            pk: 1,
            name: 'acc',
            title: 
            'Enter name'
        });
            // $('#example').Tabledit({
                // url:' ',
                // dataType:"json",
                // columns:{
                // identifier:[0, 'id'],
                // editable:[[1, 'first_name'], [2, 'last_name'], [3, 'gender', '{"1":"Male", "2":"Female"}']]
                // },
                // restoreButton:false,
                // onSuccess:function(data, textStatus, jqXHR)
                // {
                // if(data.action == 'delete')
                // {
                //     $('#'+data.id).remove();
                // }
                // }
            // });
            
            // $('body,.input-edit').keypress(function(e) {
            //             console.log($(this))
            //             var keycode = (e.keyCode ? e.keyCode : e.which);
            //             if (keycode == '13') {
            //                 alert('You pressed a "enter" key in textbox');

            //             }

            //         })
            // $(function() {
                // ($.fn.editableform.buttons =
                //     '<button type="submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light"><i class="mdi mdi-check"></i></button><button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect waves-light"><i class="mdi mdi-close"></i></button>'
                // ),
               
                // $("#inline-acc").editable({
                //         validate: function(e) {
                //             if ("" == $.trim(e)) return "This field is required";
                //         },
                //         mode: "inline",
                //         inputclass: "form-control-sm",
                //         url: "{{ route('acc.account_money_personupdate') }}",
                //         type: 'text',
                //         pk: 1,
                //         name: 'acc',
                //         title: 'Enter acc'
                //     })
                    // $('.update').editable({
                    //     url: "{{ route('acc.account_money_personupdate') }}",
                    //     type: 'text',
                    //     pk: 1,
                    //     name: 'acc',
                    //     title: 'Enter acc'
                    // });

                  
                    // $('body,.input-edit').keypress(function(e) {
                    //     console.log($(this))
                    //     var x = (e.keyCode ? e.keyCode : e.which);

                    //     if (x == '13') {
                    //         alert('You pressed a "enter" key in textbox');

                    //     }
                    // })
            // });
            // function accrep(id,$i){
            //     var x = event.which || event.keyCode;
            //     if(x == 13){
            //         var acc = document.getElementById('rep'+id).value;
            //         var number = i+1;
            //         alert(acc);
            //     }
            // }
        // });
    </script>

@endsection
