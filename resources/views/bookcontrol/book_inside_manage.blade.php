@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || BookControll')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function book_inside_manage_destroy(book_control_id) {
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
                        url: "{{ url('book_inside_manage_destroy') }}" + '/' + book_control_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                                if (response.status == 200) {
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
                                        $("#sid" + book_control_id).remove();
                                        window.location.reload();
                                        //   window.location = "/person/person_index"; //     
                                    }
                                })
                            } else {
                                
                            }
                           
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
        <form action="{{ route('pk.book_inside_manage') }}" method="GET">
            @csrf
        <div class="row"> 
            {{-- <div class="col"></div> --}}
            <div class="col-md-4">
                <h4 class="card-title">Detail Book Controll</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล บัญชีคุมหนังสือเข้า</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-3 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}" required/>  
                </div> 
            </div>
            <div class="col-md-2 text-start">
                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                    ค้นหา
                </button> 
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>
                    เพิ่มหนังสือเข้า
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
                                    <th class="text-center">เลขที่หนังสือ</th>
                                    <th class="text-center">ลงวันที่</th>
                                    <th class="text-center">วันที่รับหนังสือ</th>  
                                    <th class="text-center">เรื่อง</th> 
                                    <th class="text-center">จากหน่วยงาน</th> 
                                    <th class="text-center">ผู้รับ</th> 
                                    <th class="text-center">หมายเหตุ</th> 
                                    <th class="text-center">จัดการ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?> 
                                    <tr height="20" id="#sid">
                                        <td class="text-center" width="4%">{{ $number }}</td> 
                                        <td class="text-center" width="10%">  {{ $item->bookno }}</td>  
                                        <td class="text-center" width="6%" > {{ $item->datebook }}</td> 
                                        <td class="text-center" width="10%"> {{ $item->daterep }}</td>
                                        <td class="p-2"> {{ $item->bookname }}</td>
                                        <td class="text-center"> {{ $item->department_from }}</td>
                                        <td class="text-center" width="8%"> {{ $item->fname }} {{ $item->lname }}</td>
                                        <td class="text-center"> {{ $item->comment }}</td> 
                                        <td class="text-center" width="5%"> 
                                            {{-- <div class="dropdown d-inline-block">
                                                <button type="button" aria-haspopup="true" aria-expanded="false"
                                                    data-bs-toggle="dropdown"
                                                    class="me-2 dropdown-toggle btn btn-outline-primary btn-sm">
                                                    ทำรายการ
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu"> 
                                                        <button type="button"class="dropdown-item menu editModal" value="{{ $item->book_control_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for="" style="font-size:12px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </button>                                                        
                                                </div>
                                            </div> --}}
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                    type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">ทำรายการ</button>
                                                <ul class="dropdown-menu">
                                                    <button type="button"class="dropdown-item menu editModal" value="{{ $item->book_control_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                        <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                        <label for="" style="font-size:12px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                    </button>
                                                    
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                        <a class="dropdown-item menu text-danger" href="javascript:void(0)"
                                                            onclick="book_inside_manage_destroy({{ $item->book_control_id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-custom-class="custom-tooltip" title="ลบ">
                                                            <i class="fa-solid fa-trash-can ms-2 me-2 mb-1"></i>
                                                            <label for=""
                                                                style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
                                                </ul>
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
                    <h5 class="modal-title" id="exampleModalLabel">ทะเบียนคลุมหนังสือเข้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="bookno" class="form-label">เลขที่หนังสือ</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="bookno" name="bookno">  
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <label for="datebook" class="form-label">ลงวันที่</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="datebook" name="datebook">  
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <label for="daterep" class="form-label">วันรับหนังสือ</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="daterep" name="daterep">  
                            </div>
                        </div> 
                    </div>
 
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="bookname" class="form-label">เรื่อง</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="bookname" name="bookname">  
                            </div>
                        </div>  
                    </div> 
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="department_from" class="form-label">จากหน่วยงาน</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="department_from" name="department_from">  
                            </div>
                        </div>  
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="comment" class="form-label">หมายเหตุ</label>
                            <div class="input-group input-group-sm"> 
                                <textarea name="comment" id="comment" class="form-control" rows="3"></textarea> 
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
                    <h5 class="modal-title" id="editModalLabel">แก้ไขทะเบียนคลุมหนังสือเข้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="bookno" class="form-label">เลขที่หนังสือ</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editbookno" name="bookno">  
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <label for="datebook" class="form-label">ลงวันที่</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="editdatebook" name="datebook">  
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <label for="daterep" class="form-label">วันรับหนังสือ</label>
                            <div class="input-group input-group-sm"> 
                                <input type="date" class="form-control" id="editdaterep" name="daterep">  
                            </div>
                        </div> 
                    </div>
 
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="bookname" class="form-label">เรื่อง</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editbookname" name="bookname">  
                            </div>
                        </div>  
                    </div> 
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="department_from" class="form-label">จากหน่วยงาน</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editdepartment_from" name="department_from">  
                            </div>
                        </div>  
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="comment" class="form-label">หมายเหตุ</label>
                            <div class="input-group input-group-sm"> 
                                <textarea name="comment" id="editcomment" class="form-control" rows="3"></textarea> 
                            </div>
                        </div>  
                    </div>
                    
                    
                    <input type="hidden" name="user_id" id="edituser_id"> 
                    <input type="hidden" name="editbook_control_id" id="editbook_control_id"> 
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
                    var bookno = $('#bookno').val();
                    var datebook = $('#datebook').val();
                    var daterep = $('#daterep').val(); 
                    var department_from = $('#department_from').val();
                    var bookname = $('#bookname').val();
                    var comment = $('#comment').val();
                    var user_id = $('#user_id').val();

                    $.ajax({
                        url: "{{ route('pk.book_inside_manage_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            bookno,datebook,daterep,department_from,bookname,comment,user_id
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
                    var bookno = $('#editbookno').val();
                    var datebook = $('#editdatebook').val();
                    var daterep = $('#editdaterep').val(); 
                    var department_from = $('#editdepartment_from').val();
                    var bookname = $('#editbookname').val();
                    var comment = $('#editcomment').val();
                    var user_id = $('#edituser_id').val();
                    var book_control_id = $('#editbook_control_id').val();
                    $.ajax({
                        url: "{{ route('pk.book_inside_manage_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            bookno,datebook,daterep,department_from,bookname,comment,user_id,book_control_id
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
            var book_control_id = $(this).val(); 
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ url('book_inside_manage_edit') }}" + '/' + book_control_id,
                success: function(data) {
                    console.log(data.data_show.book_control_id);
                    $('#editbookno').val(data.data_show.bookno)
                    $('#editdatebook').val(data.data_show.datebook)
                    $('#editdaterep').val(data.data_show.daterep)
                    $('#editdepartment_from').val(data.data_show.department_from)
                    $('#editbookname').val(data.data_show.bookname)
                    $('#edituser_id').val(data.data_show.user_id)
                    $('#editcomment').val(data.data_show.comment)
                    $('#editbook_control_id').val(data.data_show.book_control_id)
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
