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
                        <form action="{{ url('account_money_report') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-1 text-left">รวมบัญชีรับและบัญชีจ่าย</div>
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
                    </form>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="3%" class="text-center">ลำดับ</th>
                                        <th class="text-center">เดือน/ปี</th>
                                        <th class="text-center">เลขบัตร ปชช</th>
                                        <th class="text-center">ชื่อ-สกุล</th> 
                                        <th class="text-center">เลขที่บัญชี</th>
                                        <th class="text-center">เงินเดือน</th>
                                        <th class="text-center">ตกเบิก</th> 
                                        <th class="text-center">OT</th> 
                                        <th class="text-center">กบข./กสจ./สมทบ</th>
                                        <th class="text-center">กบข.</th>
                                        <th class="text-center">ส่วนเพิ่ม.</th> 
                                        <th class="text-center">รวมรับ</th>
                                        <th class="text-center">รวมจ่าย</th>
                                        <th class="text-center">คงเหลือรับ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;  
                                    $totalrep = 0;
                                    $totalpay = 0;
                                    $total = 0;
                                    ?>
                                    @foreach ($datashow as $item2)
                                    <?php $yearthai = $item2->account_main_year ?>

                                        <tr id="sid{{ $item2->account_main_id }}">
                                            <td width="3%">{{ $i++ }}</td> 

                                            @if ($item2->account_main_mounts == '1')
                                                <td width="10%" class="text-center">มกราคม / {{$yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '2')
                                                <td width="10%" class="text-center">กุมภาพันธ์ / {{$yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '3')
                                                <td width="10%" class="text-center">มีนาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '4')
                                                <td width="10%" class="text-center">เมษายน / {{$yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '5')
                                                <td width="10%" class="text-center">พฤษภาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '6')
                                                <td width="10%" class="text-center">มิถุนายน / {{ $yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '7')
                                                <td width="10%" class="text-center">กรกฎาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '8')
                                                <td width="10%" class="text-center">สิงหาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '9')
                                                <td width="10%" class="text-center">กันยายน / {{ $yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '10')
                                                <td width="10%" class="text-center">ตุลาคม / {{ $yearthai}}</td>
                                            @elseif ($item2->account_main_mounts == '11')
                                                <td width="10%" class="text-center">พฤษจิกายน / {{ $yearthai}}</td>
                                            @else
                                                <td width="10%" class="text-center">ธันวาคม / {{ $yearthai}}</td>
                                            @endif  

                                            <td class="text-center" width="10%">{{ $item2->cid }}</td>
                                            <td class="p-2">{{ $item2->prefix_name }}{{ $item2->fname }} {{ $item2->lname }}</td> 
                                            <td class="text-center" width="10%">{{$item2->acc}}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->salary, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->backpay, 2) }} </td>                                           
                                            <td class="text-end" width="5%">{{ number_format($item2->ot, 2) }} </td>
                                            <td class="text-end" width="5%">{{ number_format($item2->fund, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->fundbackpay, 2) }}</td>
                                            <td class="text-end" width="5%">{{ number_format($item2->add, 2) }}</td>
                                            <td class="text-end" width="8%">{{ number_format($item2->revenue_sum, 2) }}</td>
                                            <td class="text-end" width="8%">{{ number_format($item2->expend_sum, 2) }}</td>
                                            <td class="text-end" width="8%">{{ number_format($item2->balance, 2) }}</td> 
                                        </tr>
                                            <?php
                                                $totalrep = $totalrep + $item2->revenue_sum;
                                                $totalpay = $totalpay + $item2->expend_sum;
                                                $total = $totalrep - $totalpay;
                                            ?>
                                    @endforeach
                                    
                                </tbody>
                                <tr>
                                    <td colspan="11" class="text-end">Total</td>
                                    <td class="text-end text-danger"> <b>{{ number_format($totalrep, 2) }}</b></td>
                                    <td class="text-end text-danger"><b>{{ number_format($totalpay, 2) }}</b></td>
                                    <td class="text-end text-danger"><b>{{ number_format($total, 2) }}</b></td>
                                </tr>
                            </table>
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
                        account_main_id, tax, fund, fundbackpay,add,installment,
                        flat,share,loan,food,water,electric,coop,F24,F25,F26,F27,
                        F28,F29,other  
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
        });
    </script>
    

@endsection
