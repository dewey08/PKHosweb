@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
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
    $datenow = date('Y-m-d');
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
    </style>

    <div class="tabs-animation mb-5">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        </div>
        <form action="{{ url('uprep_money_plbhn') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col"></div>
                <div class="col-md-2 text-end mt-2">วันที่รักษา</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            data-date-language="th-th" value="{{ $startdate }}" required />
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            data-date-language="th-th" value="{{ $enddate }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                        <i class="fa-solid fa-magnifying-glass text-primary me-2"></i>
                        ค้นหาข้อมูล
                    </button>
                    
                </div>
                <div class="col"></div>
            </div>
        </form>
 
        <div class="row mt-2"> 
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        รายละเอียด Patient
                        <div class="btn-actions-pane-right">
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width: 100%">
                            <thead>
                                <th>vn</th>
                                <th>hn</th> 
                                <th>cid</th> 
                                <th>ptname</th> 
                                <th>vstdate</th> 
                                <th>income</th> 
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($patient as $itemp)
                                <?php $i++; ?>
                                    <tr height="20" style="font-size: 13px;">
                                        <td>{{$itemp->vn}}</td>
                                        <td>{{$itemp->hn}}</td> 
                                        <td>{{$itemp->cid}}</td> 
                                        <td>{{$itemp->ptname}}</td> 
                                        <td>{{$itemp->vstdate}}</td> 
                                        <td>{{ number_format($itemp->income,2)}}</td> 
                                    </tr>  
                                @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
 


@endsection
@section('footer')

    <script>
        $(document).ready(function() {

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });

            $('#editwarehouse_inven_userid').select2({
                dropdownParent: $('#updteModal')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#updateBtn').click(function() {
                var acc_1102050102_602_id = $('#editacc_1102050102_602_id').val();
                var vn = $('#editvn').val();
                var hn = $('#edithn').val();
                var cid = $('#editcid').val(); 
                var ptname = $('#editptname').val();
                var req_no = $('#req_no').val();
                var claim_no = $('#claim_no').val();
                var vendor = $('#vendor').val();
                var money_billno = $('#money_billno').val();
                var paytype = $('#paytype').val();
                var no = $('#no').val();
                var payprice = $('#payprice').val();
                var paydate = $('#paydate').val();
                var savedate = $('#savedate').val();
                $.ajax({
                    url: "{{ route('acc.account_602_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        acc_1102050102_602_id,vn,hn,
                        cid,
                        ptname,
                        req_no,
                        claim_no,
                        vendor,
                        money_billno,
                        paytype,
                        no,
                        payprice,
                        paydate,
                        savedate
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'ตัด STM สำเร็จ',
                                text: "You Update STM success",
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

                        }

                    },
                });
            });

            $(document).on('click', '.edit_data', function() {
                var acc_1102050102_602_id = $(this).val();
                alert(acc_1102050102_602_id);
                $('#updteModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('account_602_edit') }}" + '/' + acc_1102050102_602_id,
                    success: function(data) {
                        $('#editvn').val(data.acc602.vn)
                        $('#edithn').val(data.acc602.hn)
                        $('#editcid').val(data.acc602.cid)
                        $('#editptname').val(data.acc602.ptname)
                        $('#editacc_1102050102_602_id').val(data.acc602.acc_1102050102_602_id)

                        $('#no').val(data.acc602.no)
                        $('#req_no').val(data.acc602.req_no)
                        $('#vendor').val(data.acc602.vendor)
                        $('#money_billno').val(data.acc602.money_billno)
                        $('#paytype').val(data.acc602.paytype)
                        $('#payprice').val(data.acc602.payprice)
                        $('#paydate').val(data.acc602.paydate)
                        // $('#savedate').val(data.acc602.savedate)
                    },
                });
            });

        });
    </script>
@endsection
