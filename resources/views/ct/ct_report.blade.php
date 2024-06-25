@extends('layouts.ctnew')
@section('title', 'PK-OFFICER || CT')
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
            border-top: 10px #17c993 solid;
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
            max-width: 75%;
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
        <form action="{{ url('ct_report') }}" method="GET">
            @csrf
        <div class="row"> 
            <div class="col-md-2"> 
                <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail CT Report</h4>
                <p class="card-title-desc">รายละเอียด รายงานCT </p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-5 text-end"> 
             
            <div class="input-daterange input-group" id="datepicker1" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    
                <input type="text" class="form-control d-shadow" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datetimepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $startdate }}" required/>
                <input type="text" class="form-control d-shadow" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datetimepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $enddate }}"/>  
                  
                        <button type="submit" class="ladda-button btn-pill btn btn-primary d-shadow" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>  
                </div> 
            </div>
        </div>      
        </form>
        <div class="row">
            <div class="col-xl-12">
                <div class="card cardshadow">
                    <div class="card-body">  
                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                                style=" border-spacing: 0; width: 100%;"> --}}
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center">vn</th>
                                            <th class="text-center" >hn</th>
                                            <th class="text-center" >cid</th>
                                            <th class="text-center">ptname</th>
                                            <th class="text-center">request_date</th> 
                                            <th class="text-center">สิทธิ์</th>  
                                            {{-- <th class="text-center">spsch</th>  --}}
                                            <th class="text-center">xray_price</th> 
                                            <th class="text-center">ค่าใช้จ่ายรวม</th> 
                                            <th class="text-center">สถานะ</th> 
                                            <th class="text-center">STMdoc</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($datashow as $item) 
                                            <tr id="tr_{{$item->vn}}">                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td>    
                                                <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td>  
                                                <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                <td class="p-2" >{{ $item->ptname }}</td> 
                                                <td class="text-center" width="10%">{{ $item->request_date }}</td>   
                                                <td class="text-center" width="10%">{{ $item->pttype }}</td> 
                                                {{-- <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item->ptty_spsch }}</td>   --}}
                                                {{-- <td class="text-center" width="10%">{{ $item->qty }}</td>  --}}
                                                <td class="text-center" width="10%">{{ number_format($item->xray_price, 2) }}</td>  
                                                {{-- <td class="text-center" width="10%">{{ number_format($item->total_price, 2) }}</td>   --}}
                                                {{-- <td class="text-center" width="10%">{{ number_format($item->before_price, 2) }}</td>   --}}
                                                <td class="text-center" width="7%">
                                                    {{-- <button type="button" style="width: 100%" class="btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#MoneyModal_2{{ $item->vn }}" data-bs-toggle="tooltip" data-bs-placement="right" title="รายละเอียด">  --}}
                                                        {{-- <i class="fa fa-lungs-virus" style="font-size:17px;color: rgb(255, 34, 89)"></i>  --}}
                                                        {{-- <i class="fa-regular fa-heart me-2" style="font-size:17px;color: rgb(12, 161, 124)"></i> --}}
                                                        {{ number_format($item->total_price, 2) }}
                                                    {{-- </button>  --}}
                                                </td>  
                                                @if ($item->active == 'Y')
                                                    <td class="text-center" style="color:rgb(247, 34, 98)" width="5%"> 
                                                        <span class="bg-success badge me-2">{{ $item->active }}</span> 
                                                    </td> 
                                                @else
                                                    <td class="text-center" style="color:rgb(247, 34, 98)" width="5%">  
                                                        <span class="bg-danger badge me-2">{{ $item->active }}</span> 
                                                    </td> 
                                                @endif
                                                <td class="p-2" >{{ $item->STMdoc }}</td> 
                                            </tr>
 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div> 
    </div>

   
</div>

@endsection
@section('footer')

{{-- <script src="{{ asset('js/jquery-1.9.1.min.js') }}"></script> --}}
    <script>
       
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();
 

            $('#startdate').datepicker({
                format: 'yyyy-mm-dd ' 
            });
            $('#enddate').datepicker({
                format: 'yyyy-mm-dd' 
            });

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
             
            $('select').select2();
            $('#plan_control_moneyuser_id').select2({
                dropdownParent: $('#MoneyModal')
            });

            $('#edit_plan_type').select2({
                dropdownParent: $('#UpdateModal')
            });
            
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           

            $(document).on('click', '.MoneyModal', function() {
                var a_stm_ct_id = $(this).val();
                // $('#plan_control_moneydate').datepicker();
                // alert(a_stm_ct_id);
                $('#MoneyModal').modal('show');
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('ct_rep_edit') }}" + '/' + a_stm_ct_id,
                    success: function(data) { 
                        $('#ct_check_edit').val(data.data_show.ct_check)
                        $('#price_check_edit').val(data.data_show.price_check)
                        $('#total_price_check_edit').val(data.data_show.total_price_check)
                        $('#opaque_price_edit').val(data.data_show.opaque_price)
                        $('#before_price_edit').val(data.data_show.before_price)
                        $('#total_edit').val(data.data_show.total)
                        $('#sumprice_edit').val(data.data_show.sumprice)
                        $('#paid_edit').val(data.data_show.paid)
                        $('#remain_edit').val(data.data_show.remain)
                        $('#ct_date_edit').val(data.data_show.ct_date)
                        $('#cid_edit').val(data.data_show.cid)
                        // $('#a_stm_ct_id_edit').val(data.data_show.a_stm_ct_id)
                    },
                });
            });
            
            $('.Syncdata').click(function() {
                var startdate = $('#datepicker').val();
                var enddate = $('#datepicker2').val(); 
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
                            url: "{{ url('ct_rep_sync') }}",
                            type: "POST",
                            dataType: 'json',
                            data: { startdate,enddate},
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
                                            $('#spinner')
                                        .hide(); //Request is complete so hide spinner
                                            setTimeout(function() {
                                                $("#overlay").fadeOut(
                                                    300);
                                            }, 500);
                                        }
                                    })

                                } else if (data.status == 100) {
                                    Swal.fire({
                                        title: 'ข้อมูลไม่ตรง',
                                        text: "Data Can not.",
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

            $('.Finish').click(function() {
                // var id = $(this).val();
                var a_stm_ct_id = $('#a_stm_ct_id_tt').val(); 
                alert(a_stm_ct_id);
                Swal.fire({
                    title: 'ยืนยันข้อมูลครบถ้วนใช่ไหม ?',
                    text: "You Confirm Data Success!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Sync it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#overlay").fadeIn(300);
                        $("#spinner").show();

                        // $.ajax({
                        //     url: "{{ route('ct.ct_rep_confirm') }}",
                        //     type: "POST",
                        //     dataType: 'json',
                        //     data: {a_stm_ct_id},
                        //     success: function(data) {
                        //         if (data.status == 200) {
                        //             Swal.fire({
                        //                 title: 'ยืนยันข้อมูลสำเร็จ',
                        //                 text: "You Confirm data success",
                        //                 icon: 'success',
                        //                 showCancelButton: false,
                        //                 confirmButtonColor: '#06D177',
                        //                 confirmButtonText: 'เรียบร้อย'
                        //             }).then((result) => {
                        //                 if (result
                        //                     .isConfirmed) {
                        //                     console.log(
                        //                         data);
                        //                     window.location.reload();
                        //                     $('#spinner')
                        //                 .hide(); //Request is complete so hide spinner
                        //                     setTimeout(function() {
                        //                         $("#overlay").fadeOut(
                        //                             300);
                        //                     }, 500);
                        //                 }
                        //             })

                        //         } else if (data.status == 100) {
                                     

                        //         } else {

                        //         }
                        //     },
                        // });

                    }
                })
            });


            $('.CheckSit').click(function() {
                var datestart = $('#datepicker').val(); 
                var dateend = $('#datepicker2').val(); 
                //    alert(datestart);
                Swal.fire({
                        title: 'ต้องการตรวจสอบสอทธิ์ใช่ไหม ?',
                        text: "You Check Sit Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner-div").show(); //Load button clicked show spinner 
                            $.ajax({
                                url: "{{ route('ct.ct_rep_checksit') }}",
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    datestart,
                                    dateend                        
                                },
                                success: function(data) {
                                    if (data.status == 200) { 
                                        Swal.fire({
                                            title: 'เช็คสิทธิ์สำเร็จ',
                                            text: "You Check sit success",
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
                                                $('#spinner-div').hide();//Request is complete so hide spinner
                                                    setTimeout(function(){
                                                        $("#overlay").fadeOut(300);
                                                    },500);
                                            }
                                        })
                                    } else {
                                        
                                    }

                                },
                            });
                        }
                })
            });

            $('#Pulldata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You Warn Pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('ct.ct_rep_pull') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Pull data success",
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
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });

           

           

        });
    </script>

@endsection
