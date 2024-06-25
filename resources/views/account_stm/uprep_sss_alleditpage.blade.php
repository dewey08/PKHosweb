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
    </style>

    <div class="tabs-animation p-3 ">
        {{-- <div class="container-fluid">  --}}

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div>
{{-- 
        <form action="{{ route('acc.uprep_sss_all_update') }}" method="POST">
            @csrf --}}
            
        <div class="row mt-2">
            <div class="col"></div>
            <div class="col-md-6">
                <div class="main-card card">
                    <div class="card-header">
                       ลงใบเสร็จรับเงินรายตัว ประกันสังคม ผัง {{$account}}
                        <div class="btn-actions-pane-right">                        
                        </div>
                    </div>
                    <div class="card-body">                    
                            <div class="row">                                
                                <div class="col-md-3">
                                    <label for="recieve_true" class="form-label">รับจริง</label>
                                    <div class="input-group input-group-sm">  
                                        <input type="text" class="form-control" id="editrecieve_true" name="recieve_true" value="{{$data_show->recieve_true}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="difference" class="form-label">ส่วนต่าง</label>
                                    <div class="input-group input-group-sm"> 
                                        <input type="text" class="form-control" id="editdifference" name="difference" value="{{$data_show->difference}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="recieve_no" class="form-label">เลขที่ใบเสร็จ</label>
                                    <div class="input-group input-group-sm"> 
                                        <input type="text" class="form-control" id="editrecieve_no" name="recieve_no" value="{{$data_show->recieve_no}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="recieve_date" class="form-label">วันที่ลงรับ</label>
                                    <div class="input-group input-group-sm"> 
                                        <input type="date" class="form-control" id="editrecieve_date" name="recieve_date" value="{{$data_show->recieve_date}}"> 
                                    </div>
                                </div> 
                            </div>         
                            <input type="hidden" name="user_id" id="edituser_id" value="{{$iduser}}"> 
                            <input type="hidden" name="id" id="editid" value="{{$id}}">  
                            <input type="hidden" name="account" id="editaccount_code" value="{{$account}}">                         
                    </div>
                    <div class="card-footer">
                        <div class="btn-actions-pane-right">
                            <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatedata">
                                <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col"></div>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 

            $('#Updatedata').click(function() {
                    var recieve_true  = $('#editrecieve_true').val();
                    var difference    = $('#editdifference').val();
                    var recieve_no    = $('#editrecieve_no').val();
                    var recieve_date  = $('#editrecieve_date').val();                    
                    var user_id       = $('#edituser_id').val();
                    var id            = $('#editid').val();
                    var account_code  = $('#editaccount_code').val();
                // alert(recieve_true);
                    $.ajax({
                        url: "{{ route('acc.uprep_sss_all_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            recieve_true,difference,recieve_no,recieve_date,user_id,id,account_code
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

            // $('.PulldataAll').click(function() {  
            //     var startdate = $('#startdate').val();
            //     var enddate = $('#enddate').val();
            //     // alert(startdate);
            //     Swal.fire({
            //             title: 'ต้องการซิ้งค์ข้อมูลใช่ไหม ?',
            //             text: "You Sync Data!",
            //             icon: 'warning',
            //             showCancelButton: true,
            //             confirmButtonColor: '#3085d6',
            //             cancelButtonColor: '#d33',
            //             confirmButtonText: 'Yes, Sync it!'
            //             }).then((result) => {
            //                 if (result.isConfirmed) {
            //                     $("#overlay").fadeIn(300);　
            //                     $("#spinner").show();  
                                
            //                     $.ajax({
            //                         url: "{{ url('account_304_syncall') }}",
            //                         type: "POST",
            //                         dataType: 'json',
            //                         data: {startdate,enddate},
            //                         success: function(data) {
            //                             if (data.status == 200) { 
            //                                 Swal.fire({
            //                                     title: 'ซิ้งค์ข้อมูลสำเร็จ',
            //                                     text: "You Sync data success",
            //                                     icon: 'success',
            //                                     showCancelButton: false,
            //                                     confirmButtonColor: '#06D177',
            //                                     confirmButtonText: 'เรียบร้อย'
            //                                 }).then((result) => {
            //                                     if (result
            //                                         .isConfirmed) {
            //                                         console.log(
            //                                             data);
            //                                         window.location.reload();
            //                                         $('#spinner').hide();//Request is complete so hide spinner
            //                                             setTimeout(function(){
            //                                                 $("#overlay").fadeOut(300);
            //                                             },500);
            //                                     }
            //                                 })

            //                             } else if (data.status == 100) { 
            //                                 Swal.fire({
            //                                     title: 'ยังไม่ได้ลงเลขที่หนังสือ',
            //                                     text: "Please enter the number of the book.",
            //                                     icon: 'warning',
            //                                     showCancelButton: false,
            //                                     confirmButtonColor: '#06D177',
            //                                     confirmButtonText: 'เรียบร้อย'
            //                                 }).then((result) => {
            //                                     if (result
            //                                         .isConfirmed) {
            //                                         console.log(
            //                                             data);
            //                                         window.location.reload();
                                                   
            //                                     }
            //                                 })
                                            
            //                             } else {
                                            
            //                             }
            //                         },
            //                     });
                                
            //                 }
            //     })
            // });


            
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
