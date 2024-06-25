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
        .modal-dialog {
            max-width: 55%;
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

    <div class="tabs-animation">
        {{-- <div class="container-fluid">  --}}

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div>

        <form action="{{ url('uprep_sss_all') }}" method="GET">
            @csrf
            <div class="row"> 
                <div class="col-md-3">
                    <h5 class="card-title">Detail SSS</h5>
                    <p class="card-title-desc">ลงใบเสร็จรับเงินรายตัว ประกันสังคม</p>
                </div>
                <div class="col"></div>
                <div class="col-md-2 text-end mt-2">วันที่</div>
                <div class="col-md-5 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control inputacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control inputacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            data-date-language="th-th" value="{{ $enddate }}"/>   
                    {{-- <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary cardacc"> 
                        <i class="fa-solid fa-magnifying-glass text-primary me-2"></i>
                        ค้นหาข้อมูล
                    </button>    --}}
                    <button type="submit" class="ladda-button btn-pill btn btn-primary cardacc" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button>  
                    {{-- <button type="button" class="ladda-button btn-pill btn btn-danger cardacc PulldataAll" >
                        <i class="fa-solid fa-arrows-rotate text-white me-2"></i>
                        Sync Data All 
                    </button> --}}
                </div>
                </div>
            </div>
        </form>  
        <div class="row">
            <div class="col-md-12">
                <div class="card cardacc">
                    {{-- <div class="card-header">
                    ลงใบเสร็จรับเงินรายตัว ประกันสังคม
                    <div class="btn-actions-pane-right"> --}}
                        {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger PulldataAll" >
                            <i class="fa-solid fa-arrows-rotate text-danger me-2"></i>
                            Sync Data All 
                        </button> --}}
                    {{-- </div>
                    </div> --}}
                    <div class="card-body">
                        {{-- <input type="hidden" name="startdate" id="startdate" value="{{$startdate}}">
                        <input type="hidden" name="enddate" id="enddate" value="{{$enddate}}"> --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    {{-- <th class="text-center" >vn</th> --}}
                                    <th class="text-center">an</th> 
                                    <th class="text-center" >hn</th>
                                    <th class="text-center" >cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">vstdate</th>
                                    <th class="text-center">dchdate</th>
                                    <th class="text-center">pttype</th> 
                                    <th class="text-center">ผัง</th>
                                    <th class="text-center">Sync Data / เลขหนังสือ </th>
                                    <th class="text-center">เลขที่ใบเสร็จ</th> 
                                    <th class="text-center">ลูกหนี้</th> 
                                    <th class="text-center">รับจริง</th> 
                                    <th class="text-center">ส่วนต่าง</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($data as $item)
                                    <?php $number++; ?>
                                   
                                        <tr height="20" style="font-size: 14px;">
                                            <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>  
                                            {{-- <td class="text-center" width="7%">{{ $item->vn }}</td>  --}}
                                            <td class="text-center" width="7%">{{ $item->an }}</td> 
                                            <td class="text-center" width="5%">{{ $item->hn }}</td>   
                                            <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                            <td class="p-2" >{{ $item->ptname }}</td> 
                                            <td class="text-center" width="7%">{{ $item->vstdate }}</td>  
                                            <td class="text-center" width="7%">{{ $item->dchdate }}</td>  
                                            <td class="text-center" width="5%">{{ $item->pttype }}</td> 
                                            <td class="p-2" >{{ $item->account_code }}</td> 
                                            <td class="text-center" width="3%">  
                                                @if ($item->nhso_docno == '' && $item->pttype =='ss')
                                                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning editModal" value="{{ $item->account_code.'/'.$item->id }}">
                                                        <i class="fa-solid fa-book-open text-warning me-2"></i> 
                                                        ยังไม่ได้ลงเลขหนังสือ-เลขที่ใบเสร็จ 
                                                    </button>
                                                @else
                                                    {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                                        <i class="fa-solid fa-book-open text-primary me-2"></i> 
                                                        {{$item->nhso_docno}}
                                                    </button> --}}
                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-primary editModal" value="{{ $item->account_code.'/'.$item->id }}"> 
                                                        {{-- value="$item->account_code.'/'.$item->id }}" --}}
                                                        <i class="fa-solid fa-book-open text-primary me-2"></i> 
                                                        {{$item->nhso_docno}}
                                                    </button> 
                                                @endif                                                  
                                                                                                        
                                            </td> 
                                            <td class="text-center" width="3%"> 

                                                @if ($item->pttype == 'ss')
                                                    {{-- <a href="{{url('uprep_sss_alleditpage/'.$item->account_code.'/'.$item->id)}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                                        <i class="fa-solid fa-file-invoice text-danger me-2"></i> 
                                                        ลงเลขที่ใบเสร็จ 
                                                    </a>  --}}
                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger editModal" value="{{ $item->account_code.'/'.$item->id }}"> 
                                                        {{-- value="$item->account_code.'/'.$item->id }}" --}}
                                                        <i class="fa-solid fa-file-invoice text-danger me-2"></i> 
                                                        ลงเลขที่ใบเสร็จ
                                                    </button> 
                                                @elseif ($item->nhso_docno != '' && $item->recieve_no =='' )
                                                    {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger editModal" value="{{ $item->id }}">
                                                        <i class="fa-solid fa-file-invoice text-danger me-2"></i> 
                                                        ลงเลขที่ใบเสร็จ 
                                                    </button>  --}}
                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger editModal" value="{{ $item->account_code.'/'.$item->id }}"> 
                                                        {{-- value="$item->account_code.'/'.$item->id }}" --}}
                                                        <i class="fa-solid fa-file-invoice text-danger me-2"></i> 
                                                        ลงเลขที่ใบเสร็จ
                                                    </button> 
                                                    {{-- <a href="{{url('uprep_sss_alleditpage/'.$item->account_code.'/'.$item->id)}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                                        <i class="fa-solid fa-file-invoice text-danger me-2"></i> 
                                                        ลงเลขที่ใบเสร็จ 
                                                    </a>  --}}
                                                @elseif ($item->recieve_no == '' && $item->nhso_docno =='')
                                                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger editModal" value="{{ $item->account_code.'/'.$item->id }}">
                                                        <i class="fa-solid fa-file-invoice text-danger me-2"></i> 
                                                        ยังไม่ได้ลงเลขหนังสือ-เลขที่ใบเสร็จ 
                                                    </button> 
                                                @else
                                                    {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                        <i class="fa-solid fa-book-open text-success me-2"></i> 
                                                        {{$item->recieve_no}}
                                                    </button> --}}
                                                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-success editModal" value="{{ $item->account_code.'/'.$item->id }}"> 
                                                        {{-- value="$item->account_code.'/'.$item->id }}" --}}
                                                        <i class="fa-solid fa-file-invoice text-success me-2"></i> 
                                                        {{$item->recieve_no}}
                                                    </button> 
                                                @endif
                                            </td>  
                                            
                                            <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->debit_total,2)}}</td>   
                                            <td class="text-end" style="color:rgb(53, 196, 76)" width="7%">{{$item->recieve_true}}</td>                                           
                                            <td class="text-end" style="color:rgb(247, 129, 33)" width="7%">{{$item->difference}}</td> 
                                        </tr>
                                        
                                    
 
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

     <!-- Update Modal -->
     <div class="modal fade" id="editModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <div class="row"> 
                        <div class="col-md-8">
                            <h5 class="modal-title" id="editModalLabel">ลงใบเสร็จรับเงินรายตัว</h5>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="form-group">
                                <button type="button" id="Updatedata" class="btn-icon btn-shadow btn-dashed btn btn-outline-info me-2"> 
                                    <i class="pe-7s-diskette btn-icon-wrapper me-2"></i> Save
                                </button>
                                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-xmark me-2"></i>Close
                                </button> 
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-body"> 
                    <div class="row"> 
                        <div class="col-md-3">
                            <label for="difference" class="form-label">ลูกหนี้</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editdebit_total" name="debit_total" readonly>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <label for="recieve_true" class="form-label">รับจริง</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editrecieve_true" name="recieve_true">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <label for="recieve_no" class="form-label">เลขที่ใบเสร็จ</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editrecieve_no" name="recieve_no">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="recieve_date" class="form-label">วันที่ลงรับ</label>
                            <div class="input-group input-group-sm"> 
                                {{-- <input type="date" class="form-control" id="editrecieve_date" name="recieve_date">  --}}
                                <input type="text" id="editrecieve_date" class="form-control" data-toggle="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-language="th-th" autocomplete="off">
                            </div>
                        </div> 
                    </div>
 
                    <input type="hidden" name="user_id" id="edituser_id" value="{{$iduser}}"> 
                    <input type="hidden" name="editid" id="editid"> 
                    <input type="hidden" name="editaccount_code" id="editaccount_code"> 
                </div>
              
                <div class="modal-footer">
                   
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

            $('[data-toggle="datepicker"]').datepicker({ 
                autoHide: true,
                zIndex: 2048,
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.editModal', function() {
                var id = $(this).val(); 
                // alert(id);
                $('#editModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('uprep_sss_alledit') }}" + '/' + id,
                    success: function(data) {

                        $('#editrecieve_true').val(data.data_show.nhso_ownright_pid)
                        $('#editdebit_total').val(data.data_show.debit_total)
                        // $('#editrecieve_true').val(data.data_show.recieve_true)
                        $('#editdifference').val(data.data_show.difference)
                        $('#editrecieve_no').val(data.data_show.recieve_no)
                        $('#editrecieve_date').val(data.data_show.recieve_date)
                        $('#editid').val(data.id)
                        $('#editaccount_code').val(data.data_show.account_code)
                        // editrecieve_no
                    },
                });
            });
            $('#Updatedata').click(function() {
                    var recieve_true  = $('#editrecieve_true').val();
                    var debit_total    = $('#editdebit_total').val();
                    var recieve_no    = $('#editrecieve_no').val();
                    var recieve_date  = $('#editrecieve_date').val();                    
                    var user_id       = $('#edituser_id').val();
                    var id            = $('#editid').val();
                    var account_code  = $('#editaccount_code').val(); 
                    $.ajax({
                        url: "{{ route('acc.uprep_sss_all_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            recieve_true,debit_total,recieve_no,recieve_date,user_id,id,account_code
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'ลงเลขที่ใบเสร็จรายตัวสำเร็จ',
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
                                        // window.location.reload(); 
                                        window.location="{{url('uprep_sss_all')}}";
                                    }
                                })
                            } else {

                            }

                        },
                    });
            }); 

            $('#Updatedata22').click(function() {
                    var recieve_true = $('#editrecieve_true').val();
                    var difference = $('#editdifference').val();
                    var recieve_no = $('#editrecieve_no').val();
                    var recieve_date = $('#editrecieve_date').val();                    
                    var user_id = $('#edituser_id').val();
                    var acc_1102050101_309_id = $('#editid').val();

                    $.ajax({
                        url: "{{ route('acc.uprep_sss_309_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            recieve_true,difference,recieve_no,recieve_date,user_id,acc_1102050101_309_id
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'ลงเลขที่ใบเสร็จรายตัวสำเร็จ',
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
                                        window.location.reload(); 
                                    }
                                })
                            } else {

                            }

                        },
                    });
            }); 

            $('.PulldataAll').click(function() {  
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();
                // alert(startdate);
                Swal.fire({
                        title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
                        text: "You Sync Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Sync it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show();  
                                
                                $.ajax({
                                    url: "{{ url('uprep_sss_syncall') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {startdate,enddate},
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ซิ้งค์ข้อมูลสำเร็จ',
                                                text: "You Sync data success",
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
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })

                                        } else if (data.status == 100) { 
                                            Swal.fire({
                                                title: 'ยังไม่ได้ลงเลขที่หนังสือ',
                                                text: "Please enter the number of the book.",
                                                icon: 'warning',
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
                                
                            }
                })
            });


            
            // $(document).on('click', '.Pulldata', function() {
            //     var an = $(this).val();
            //     alert(an);
                
            //     $.ajax({
            //         type: "POST",
            //         url: "{{ url('account_304_sync')}}",
            //         dataType: 'json',
            //         data: { an },
            //         success: function(data) {
            //             // if (data.status == 200) { 
            //                     // Swal.fire({
            //                     //     title: 'Sync ข้อมูลสำเร็จ',
            //                     //     text: "You Sync data success",
            //                     //     icon: 'success',
            //                     //     showCancelButton: false,
            //                     //     confirmButtonColor: '#06D177',
            //                     //     confirmButtonText: 'เรียบร้อย'
            //                     // }).then((result) => {
            //                     //     if (result
            //                     //         .isConfirmed) {
            //                     //         console.log(
            //                     //             data);
            //                     //         window.location.reload(); 
            //                     // })
            //             // } else {
                            
            //             // }
                        
            //         }
            //     });
            // });

        });
    </script>
@endsection
