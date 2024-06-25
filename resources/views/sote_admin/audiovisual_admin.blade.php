@extends('layouts.audiovi')
@section('title', 'PK-OFFICER || Sot')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function audiovisual_admin_cancel(audiovisual_id) {
            Swal.fire({
                title: 'ต้องการยกเลิกใช่ไหม?',
                text: "ยืนยันการยกเลิก !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ยกเลิกเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('audiovisual_admin_cancel') }}" + '/' + audiovisual_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ยืนยันการแจ้งยกเลิกสำเร็จ!',
                                text: "You Cancel data ",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + audiovisual_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        }
                    })
                }
            })
        }

        function audiovisual_admin_going(audiovisual_id) {
            Swal.fire({
                title: 'กำลังดำเนินการใช่ไหม?',
                text: "กำลังดำเนินการ !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ดำเนินการเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ดำเนินการ'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('audiovisual_admin_going') }}" + '/' + audiovisual_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ยืนยันการแจ้งกำลังดำเนินการสำเร็จ!',
                                text: "You Confirm Cancel data ",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + audiovisual_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        }
                    })
                }
            })
        }

        function audiovisual_admin_sendcheck(audiovisual_id) {
            Swal.fire({
                title: 'ส่งงานตรวจสอบใช่ไหม?',
                text: "ส่งงานตรวจสอบ !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ส่งงานตรวจสอบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ส่งงานตรวจสอบ'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('audiovisual_admin_sendcheck') }}" + '/' + audiovisual_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ยืนยันการส่งงานตรวจสอบสำเร็จ!',
                                text: "You Confirm Cancel data ",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + audiovisual_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
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
        $tel_ = Auth::user()->tel;
        $debsubsub = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $datenow = date('Y-m-d');
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SoteController;
    $refnumber = SoteController::refnumber();
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

        .modal-dis {
            width: 1350px;
            margin: auto;
        }

        @media (min-width: 1200px) {
            .modal-xlg {
                width: 90%;
            }
        }
    </style>
    <div class="tabs-animation">

        <div id="preloader">
            <div id="status">
                <div class="spinner">
    
                </div>
            </div>
        </div>

        <form action="{{ url('audiovisual_admin') }}" method="GET">
            @csrf
            <div class="row mb-3">
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-4 text-end">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                        data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            autocomplete="off" data-date-language="th-th" value="{{ $startdate }}" required />
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                            autocomplete="off" data-date-language="th-th" value="{{ $enddate }}" />

                        <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                            <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                            ค้นหา
                        </button>
                    </div>
                </div>
                {{-- <div class="col-md-2"> 

                    <a href="{{url('audiovisual_work_add')}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary "  data-bs-toggle="tooltip" data-bs-placement="top" title="เพิ่มข้อมูล">
                    
                        <i class="fa-solid fa-square-plus me-2"></i>
                     เพิ่มข้อมูล
                    </a> 
 
                </div> --}}
            </div>
        </form>


        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card card_sote_4 p-3">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr style="font-size: 13px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center" width="5%">สถานะ</th>
                                        <th class="text-center" width="13%">ชื่อ-สกุล</th>
                                        <th class="text-center" width="7%">Line ID</th>
                                        <th class="text-center" width="7%">เบอร์โทร</th>
                                        <th class="text-center" width="7%">วันที่สั่งงาน</th>
                                        <th class="text-center" width="7%">วันที่ขอรับงาน</th>
                                        {{-- <th class="text-center" width="12%">ชนิดของงาน</th>  --}}
                                        <th class="p-2">ชื่อชิ้นงาน</th>
                                        <th class="p-2">รายละเอียดงาน</th>
                                        <th class="p-2" width="10%">หน่วยงาน</th>
                                        <th class="text-center" width="7%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($audiovisual as $item)
                                        <tr id="sid{{ $item->audiovisual_id }}" style="font-size: 13px">
                                            <td class="text-center">{{ $i++ }}</td>

                                            @if ($item->audiovisual_status == 'REQUEST')
                                                <td class="text-center" width="5%">
                                                    <div class="badge bg-info" style="font-size:12px">ร้องขอ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'ACCEPTING')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background-color: #592DF7;font-size:12px"
                                                        style="font-size:12px">รับทราบ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'INPROGRESS')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background: rgb(96, 221, 243);font-size:12px"
                                                         >กำลังดำเนินการ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'VERIFY')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background: rgb(232,13,239);font-size:12px"
                                                         >ตรวจสอบ</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'FINISH')
                                                <td class="text-center" width="5%">
                                                    <div class="badge" style="background: rgb(4, 190, 144);font-size:12px"
                                                        >เสร็จสิ้น</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'CANCEL')
                                                <td class="text-center" width="5%">
                                                    <div class="badge bg-danger" style="font-size:12px">แจ้งยกเลิก</div>
                                                </td>
                                            @elseif ($item->audiovisual_status == 'CONFIRM_CANCEL')
                                                <td class="text-center" width="5%">
                                                    <div class="badge " style="background: rgb(141, 140, 138)"
                                                        style="font-size:12px">ยกเลิก</div>
                                                </td>
                                            @else
                                                <td class="text-center" width="5%">
                                                    <div class="badge bg-success" style="font-size:12px">ซ่อมเสร็จ</div>
                                                </td>
                                            @endif

                                            <td class="p-2" width="13%"> {{ $item->fname }} {{ $item->lname }} </td>
                                            <td class="text-center" width="6%">{{ $item->lineid }}</td>
                                            <td class="text-center" width="6%">{{ $item->tel }}</td>
                                            <td class="text-center" width="7%">{{ Datethai($item->work_order_date) }} </td>
                                            <td class="text-center" width="7%">{{Datethai($item->job_request_date )}}</td>
                                            {{-- <td class="p-2">{{ $item->audiovisual_typename }} </td> --}}
                                            <td class="p-2">{{ $item->audiovisual_name }} </td>
                                            <td class="p-2">{{ $item->audiovisual_detail }} </td>
                                            <td class="p-2" width="10%">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">

                                                        {{-- <a href="{{url('audiovisual_admin_check/'.$item->audiovisual_id)}}"  class="dropdown-item menu "
                                                         data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="รับงาน">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2" style="font-size:13px;color:rgb(39, 134, 241)"></i>
                                                            <span style="color:rgb(39, 134, 241)">รับงาน</span> 
                                                    </a> --}}
                                                        <button type="button"class="dropdown-item menu"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#UpdateModal_in{{ $item->audiovisual_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="รับงาน">
                                                            <i class="fa-solid fa-file-pen ms-2 me-2 text-info"
                                                                style="font-size:13px"></i>
                                                            <span class="text-info">รับงาน</span>

                                                        </button>

                                                        {{-- <button type="button"class="dropdown-item menu"
                                                        data-bs-toggle="modal" data-bs-target="#UpdateModal_in{{ $item->audiovisual_id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="รายละเอียด">
                                                            <i class="fa-solid fa-file-pen ms-2 me-2 text-info"
                                                                style="font-size:13px"></i>
                                                            <span class="text-info">รายละเอียด</span>
                                                        
                                                        </button> --}}
                                                        <a class="dropdown-item text-info" href="javascript:void(0)"
                                                        onclick="audiovisual_admin_going({{ $item->audiovisual_id }})"
                                                        style="font-size:13px">
                                                        <i class="fa-solid fa-file-pen ms-2 me-2 text-info"
                                                            style="font-size:13px"></i>
                                                        <span>กำลังดำเนินการ</span>
                                                    </a>
                                                    <a class="dropdown-item text-success" href="javascript:void(0)"
                                                    onclick="audiovisual_admin_sendcheck({{ $item->audiovisual_id }})"
                                                    style="font-size:13px">
                                                    <i class="fa-solid fa-file-pen ms-2 me-2 text-success"
                                                        style="font-size:13px"></i>
                                                    <span>ส่งงาน</span>
                                                </a>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="audiovisual_admin_cancel({{ $item->audiovisual_id }})"
                                                            style="font-size:13px">
                                                            <i class="fa-solid fa-xmark ms-2 me-2 text-danger"
                                                                style="font-size:13px"></i>
                                                            <span>ยืนยันการยกเลิก</span>
                                                        </a>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="UpdateModal_in{{ $item->audiovisual_id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content ">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title me-3" id="editModalLabel">
                                                            รายละเอียดการขอใช้บริการ</h5>
                                                        <h6 class="mt-2"> </h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-2">  <label for="edit_ptname" class="form-label">ชื่อ-นามสกุล</label> </div>
                                                            <div class="col-md-2 text-start"> <label for="" style="color: gray"> {{ $item->fname }} {{ $item->lname }}</label> </div>
                                                            <div class="col-md-1"> <label for="tel" style="color: gray">เบอร์โทร</label>  </div>
                                                            <div class="col-md-3 text-start"> <label for="" style="color: gray"> {{$item->tel}}</label>  </div>
                                                            <div class="col-md-1"> <label for="work_order_date" class="form-label" >วันที่สั่งงาน </label></div>
                                                            <div class="col-md-3 text-start"> <label for="" style="color: gray"> {{$item->work_order_date}}</label>  </div> 
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-2"> <label for="job_request_date" class="form-label" >วันที่ขอรับงาน </label></div>
                                                            <div class="col-md-2 text-start"> <label for="" style="color: gray"> {{$item->job_request_date}}</label>  </div>
                                                            <div class="col-md-1"> <label for="DEPARTMENT_SUB_SUB_NAME" class="form-label" >หน่วยงาน </label></div>
                                                            <div class="col-md-3 text-start"> <label for="" style="color: gray"> {{$item->DEPARTMENT_SUB_SUB_NAME}}</label>  </div>
                                                            <div class="col-md-1"> <label for="audiovisual_typename" class="form-label" >ชนิดงาน </div>
                                                            <div class="col-md-3 text-start"> <label for="" style="color: gray"> {{$item->audiovisual_typename}}</label>  </div> 
                                                        </div>

                                                        <div class="row mt-2">
                                                            <div class="col-md-2"> <label for="audiovisual_name" class="form-label" >ชื่อชิ้นงาน </label></div>
                                                            <div class="col-md-6 text-start"> <label for="" style="color: gray"> {{$item->audiovisual_name}}</label>  </div>
                                                            <div class="col-md-1"> <label for="audiovisual_qty" class="form-label" >จำนวน </label></div>
                                                            <div class="col-md-3 text-start"> <label for="" style="color: gray"> {{$item->audiovisual_qty}}</label>  </div> 
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-4"> <label for="audiovisual_name" class="form-label" >รายละเอียดงาน (เช่นขนาดงาน สถานที่ ) </label></div>
                                                            <div class="col-md-8 text-start"> <label for="" style="color: gray"> {{$item->audiovisual_detail}}</label>  </div> 
                                                        </div>
                                                    </div>
                                                {{-- <form action="{{ route('user.audiovisual_admin_save') }}" method="POST" > --}}
                                                    <form action="{{ route('user.audiovisual_admin_save') }}" method="POST">
                                                        @csrf
                                                    {{-- id="AcceptdataForm" id="AcceptdataForm"--}}
                                                    <input type="hidden" id="audiovisual_id" name="audiovisual_id" value="{{$item->audiovisual_id}}">
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                            <i class="pe-7s-diskette btn-icon-wrapper"></i>Accept
                                                        </button>
                                                        {{-- id="Acceptdata" --}}
                                                        {{-- <button type="button" id="updateBtn"
                                                        class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-primary">
                                                        <i class="fa-solid fa-floppy-disk me-2"></i>
                                                        Accept
                                                    </button> --}}
                                                        <button type="button"
                                                        class="btn-icon btn-shadow btn-dashed btn btn-outline-danger"
                                                        data-bs-dismiss="modal"><i
                                                            class="fa-solid fa-xmark me-2"></i>Close</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
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
            $('#example3').DataTable();
            // collapseTwo
            // $('select').select2();
            $('#ptname').select2({
                dropdownParent: $('#collapseTwo')
            });
            $('#department').select2({
                dropdownParent: $('#collapseTwo')
            });
            $('#audiovisual_type').select2({
                dropdownParent: $('#collapseTwo')
            });

            // $('#ptname').select2({
            //     dropdownParent: $('#addicodeModal')
            // });

            $("#edit_ptname").select2({
                // tags: true,
                dropdownParent: $('#UpdateModal'),
                // tokenSeparators: [',', ' ']
            })
            $('#edit_department').select2({
                dropdownParent: $('#UpdateModal')
            });
            // $(".js-example-theme-multiple").select2({
            //     theme: "classic"
            // });
            // $('#department').select2({
            //     dropdownParent: $('#addicodeModal')
            // });
            // $('#audiovisual_type').select2({
            //     dropdownParent: $('#addicodeModal')
            // });
            $('#edit_audiovisual_type').select2({
                dropdownParent: $('#UpdateModal')
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

            $(document).on('click', '#printBtn', function() {
                var month_id = $(this).val();
                alert(month_id);

            });
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#updateBtn').click(function() {                
                var audiovisual_id = $('#audiovisual_id').val(); 
                alert(audiovisual_id);
                $.ajax({
                    url: "{{ route('user.audiovisual_admin_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        audiovisual_id 
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            // alert('gggggg');
                            Swal.fire({
                                title: 'รับงานสำเร็จ',
                                text: "You Accept data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            $(document).on('click', '.edit_data', function() {
                var audiovisual_id = $(this).val();
                $('#UpdateModal').modal('show');
                // alert(audiovisual_id);
                // $("#overlay").fadeIn(300);　
                // $("#spinner").show(); //Load button clicked show spinner 
                $.ajax({
                    type: "GET",
                    url: "{{ url('audiovisual_work_detail') }}" + '/' + audiovisual_id,
                    success: function(data) {
                        $('#edit_ptname').val(data.work.ptname)
                        $('#edit_tel').val(data.work.tel)
                        $('#edit_work_order_date').val(data.work.work_order_date)
                        $('#edit_job_request_date').val(data.work.job_request_date)
                        $('#edit_department').val(data.work.department)
                        $('#edit_audiovisual_type').val(data.work.audiovisual_type)
                        $('#edit_audiovisual_name').val(data.work.audiovisual_name)
                        $('#edit_audiovisual_qty').val(data.work.audiovisual_qty)
                        $('#edit_audiovisual_detail').val(data.work.audiovisual_detail)
                        $('#edit_audiovisual_id').val(data.work.audiovisual_id)
                    },
                });
            });

            $('#Insertdata').click(function() {
                var ptname = $('#ptname').val();
                var tel = $('#tel').val();
                var work_order_date = $('#work_order_date').val();
                var job_request_date = $('#job_request_date').val();
                var department = $('#department').val();
                var audiovisual_type = $('#audiovisual_type').val();
                var audiovisual_name = $('#audiovisual_name').val();
                var audiovisual_qty = $('#audiovisual_qty').val();
                var audiovisual_detail = $('#audiovisual_detail').val();

                $.ajax({
                    url: "{{ route('user.audiovisual_work_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        ptname,
                        tel,
                        work_order_date,
                        job_request_date,
                        department,
                        audiovisual_type,
                        audiovisual_name,
                        audiovisual_qty,
                        audiovisual_detail
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'เพิ่มข้อมูลสำเร็จ',
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

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            
        });
    </script>

@endsection
