@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function uprepdestroy(acc_stm_repmoney_file_id) {
            Swal.fire({
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('uprepdestroy') }}" + '/' + acc_stm_repmoney_file_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                                // if (response.status == 200) {
                                    Swal.fire({
                                    title: 'ลบข้อมูล!',
                                    text: "You Delet data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // $("#sid" + acc_stm_repmoney_file_id).remove();
                                        window.location.reload();
                                        //   window.location = "/person/person_index"; //     
                                    }
                                })
                            // } else {
                                
                            // }
                           
                        }
                    })
                }
            })
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
            border-top: 10px #fd6812 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>
    <?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
        <div class="row"> 
            {{-- <div class="col"></div> --}}
            <div class="col-md-4">
                <h4 class="card-title">Detail ลงรับใบเสร็จ</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล ลงรับใบเสร็จ</p>
            </div>
            <div class="col"></div>
            {{-- <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-3 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                        data-date-language="th-th" value="{{ $enddate }}" required/>  
                </div> 
            </div> --}}
            <div class="col-md-2 text-start">
                {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                    ค้นหา
                </button>  --}}
                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  
                    <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>
                    เพิ่มไตรมาส
                </button>
            </div>
            {{-- <div class="col"></div> --}}
        </div>

        <div class="row"> 
            <div class="col-xl-12 col-md-6">
                <div class="main-card card p-3">
                    <div class="grid-menu-col"> 
                            <table id="example" class="table table-striped table-bordered "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center">ไตรมาสเดือน</th>
                                    <th class="text-center">วันที่เริ่ม</th>
                                    <th class="text-center">วันที่สิ้นสุด</th>  
                                    <th class="text-center">จัดการ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?> 
                                    <tr height="20">
                                        <td class="text-center" width="4%">{{ $number }}</td> 
                                        <td class="text-center">  {{ $item->acc_trimart_name }}</td>  
                                        <td class="text-center" width="15%" > {{ $item->acc_trimart_start_date }}</td> 
                                        <td class="text-center" width="15%"> {{ $item->acc_trimart_end_date }}</td>
                                        <td class="text-center" width="7%"> 
                                            <div class="dropdown d-inline-block">
                                                <button type="button" aria-haspopup="true" aria-expanded="false"
                                                    data-bs-toggle="dropdown"
                                                    class="me-2 dropdown-toggle btn btn-outline-primary btn-sm">
                                                    ทำรายการ
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu"> 
                                                        <button type="button"class="dropdown-item menu editModal" value="{{ $item->acc_trimart_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for="" style="font-size:12px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </button>
                                                        {{-- <div class="dropdown-divider"></div>  --}}
                                                        {{-- <button type="button"class="dropdown-item menu addFileModal" value="{{ $item->acc_trimart_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แนบไฟล์">
                                                            <i class="fa-solid fa-clipboard-check ms-2 me-2 text-primary"></i>
                                                            <label for="" style="font-size:12px;color: rgb(40, 87, 241)">แนบไฟล์</label>
                                                        </button>  --}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr> 
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div> 
        </div>

         

    </div>

    <!-- Insert Modal -->
    <div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มไตรมาส</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="acc_trimart_start" class="form-label">ไตรมาส</label>
                            <div class="input-group input-group-sm"> 
                                <select name="acc_trimart_start" id="acc_trimart_start" class="form-select form-control" style="width: 100%">
                                    <option value="">เลือก</option>
                                    @foreach ($acc_trimart_liss as $item)
                                        <option value="{{$item->acc_trimart_liss_id}}">{{$item->acc_trimart_liss_start}} - {{$item->acc_trimart_liss_end}} </option>
                                    @endforeach
                                </select> 
                            </div>
                        </div> 
                    </div>
 
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="acc_trimart_start_date" class="form-label">วันที่เริ่ม</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="acc_trimart_start_date" name="acc_trimart_start_date">  
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <label for="acc_trimart_end_date" class="form-label">วันที่เริ่มสิ้นสุด</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="acc_trimart_end_date" name="acc_trimart_end_date">  
                            </div>
                        </div> 
                    </div> 
                    <input type="hidden" name="user_id" id="user_id" value="{{$iduser}}"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Savedata">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="editModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">แก้ไขไตรมาส</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="acc_trimart_start" class="form-label">ไตรมาส</label>
                            <div class="input-group input-group-sm"> 
                                <select name="acc_trimart_start" id="editacc_trimart_start" class="form-select form-control" style="width: 100%">
                                    <option value="">เลือก</option>
                                    @foreach ($acc_trimart_liss as $item)
                                        <option value="{{$item->acc_trimart_liss_id}}">{{$item->acc_trimart_liss_start}} - {{$item->acc_trimart_liss_end}} </option>
                                    @endforeach
                                </select> 
                            </div>
                        </div> 
                    </div>
 
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="acc_trimart_start_date" class="form-label">วันที่เริ่ม</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="editacc_trimart_start_date" name="acc_trimart_start_date">  
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <label for="acc_trimart_end_date" class="form-label">วันที่เริ่มสิ้นสุด</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="editacc_trimart_end_date" name="acc_trimart_end_date">  
                            </div>
                        </div> 
                    </div> 
                    
                    <input type="hidden" name="user_id" id="edituser_id"> 
                    <input type="hidden" name="acc_trimart_id" id="editacc_trimart_id"> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatedata">
                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                    </button>
                </div>
            </div>
        </div>
    </div>
 

@endsection
@section('footer')
<script src="{{ asset('pdfupload/pdf_up.js') }}"></script> 
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            }); 
            // $('#acc_stm_repmoney_tri').select2({
            //     dropdownParent: $('#editModal')
            // });

            // $('#editacc_stm_repmoney_tri').select2({
            //     dropdownParent: $('#editModal')
            // });

            $('#Savedata').click(function() {
                    var acc_trimart_start = $('#acc_trimart_start').val();
                    var acc_trimart_start_date = $('#acc_trimart_start_date').val();
                    var acc_trimart_end_date = $('#acc_trimart_end_date').val(); 
                    var user_id = $('#user_id').val();

                    $.ajax({
                        url: "{{ route('acc.aset_trimart_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            acc_trimart_start,acc_trimart_start_date,acc_trimart_end_date,user_id
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
                                        console.log(
                                            data);
                                        window.location.reload();
                                        // window.location="{{ url('warehouse/warehouse_index') }}";
                                    }
                                })
                            } else {

                            }

                        },
                    });
            }); 
            $('#Updatedata').click(function() {
                    var acc_trimart_start_date = $('#editacc_trimart_start_date').val();
                    var acc_trimart_code = $('#editacc_trimart_start').val();
                    var acc_trimart_end_date = $('#editacc_trimart_end_date').val();
                    // var acc_stm_repmoney_price = $('#editacc_stm_repmoney_price').val();
                    // var acc_stm_repmoney_date = $('#editacc_stm_repmoney_date').val();
                    var user_id = $('#edituser_id').val();
                    var acc_trimart_id = $('#editacc_trimart_id').val();

                    $.ajax({
                        url: "{{ route('acc.aset_trimart_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            acc_trimart_start_date,acc_trimart_code,acc_trimart_end_date
                            ,acc_trimart_id,user_id
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You Update data success",
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

        $(document).on('click', '.editModal', function() {
            var acc_trimart_id = $(this).val();
            // alert(acc_trimart_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ url('aset_trimart_edit') }}" + '/' + acc_trimart_id,
                success: function(data) {
                    console.log(data.data_show.acc_trimart_id);
                    $('#editacc_trimart_start_date').val(data.data_show.acc_trimart_start_date)
                    $('#editacc_trimart_start').val(data.data_show.acc_trimart_code)
                    $('#editacc_trimart_end_date').val(data.data_show.acc_trimart_end_date)
                    // $('#editacc_stm_repmoney_price').val(data.data_show.acc_stm_repmoney_price)
                    // $('#editacc_stm_repmoney_date').val(data.data_show.acc_stm_repmoney_date)
                    $('#edituser_id').val(data.data_show.user_id)
                    $('#editacc_trimart_id').val(data.data_show.acc_trimart_id)
                },
            });
        });
    
        // $('#SaveFileModal').on('submit', function(e) {
        //     e.preventDefault();
        //     var form = this;
        //     // alert('OJJJJOL');
        //     $.ajax({
        //         url: $(form).attr('action'),
        //         method: $(form).attr('method'),
        //         data: new FormData(form),
        //         processData: false,
        //         dataType: 'json',
        //         contentType: false,
        //         beforeSend: function() {
        //             $(form).find('span.error-text').text('');
        //         },
        //         success: function(data) {
        //             if (data.status == 200) {
        //                 Swal.fire({
        //                     title: 'Up File สำเร็จ',
        //                     text: "You Up File data success",
        //                     icon: 'success',
        //                     showCancelButton: false,
        //                     confirmButtonColor: '#06D177',
        //                     // cancelButtonColor: '#d33',
        //                     confirmButtonText: 'เรียบร้อย'
        //                 }).then((result) => {
        //                     if (result.isConfirmed) {
        //                         window.location.reload();
        //                     }
        //                 })

        //             } else {
                        
        //             }
        //         }
        //     });
        // });
    </script>
 
@endsection
