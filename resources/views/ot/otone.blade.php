@extends('layouts.otsystem')
@section('title', 'PK-OFFICER || OT Report')
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
            border-top: 10px #d22cf3 solid;
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
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function otone_destroy(ot_one_id) {
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
                        url: "{{ url('otone_destroy') }}" + '/' + ot_one_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
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
                                    $("#sid" + ot_one_id).remove();
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
    
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    $countpermiss_ot = StaticController::countpermiss_ot($iduser);
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
        
        @if ($countpermiss_ot != 0)
            <div class="row">
                <div class="col-xl-12">
                    <form action="{{ route('ot.otone') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 text-end mt-2">ประเภท</div>
                            <div class="col-md-1 text-center">
                                <div class="input-group"> 
                                    <select id="ot_type_pk" name="ot_type_pk" class="form-control cardot" style="width: 100%"> 
                                        @foreach ($ot_type_pk as $reqshow)
                                            @if ($reqsend == $reqshow->ot_type_pk_id)
                                                <option value="{{ $reqshow->ot_type_pk_id }}" selected> {{ $reqshow->ot_type_pkname }} </option>
                                            @else
                                                <option value="{{ $reqshow->ot_type_pk_id }}"> {{ $reqshow->ot_type_pkname }} </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 text-end mt-2">วันที่</div>
                            <div class="col-md-4 text-end">
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                    <input type="text" class="form-control cardot" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $startdate }}" required/>
                                    <input type="text" class="form-control cardot" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $enddate }}"/>  
                                        <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardot" data-style="expand-left">
                                            <span class="ladda-label"><i class="fa-solid fa-magnifying-glass"></i> ค้นหา</span>
                                            <span class="ladda-spinner"></span>
                                        </button> 
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <a href="{{ url('otone_add') }}" class="ladda-button me-2 btn-pill btn cardot" style="background-color: rgb(178, 243, 227)"
                                        target="_blank"><i class="fa-solid fa-folder-plus text-white me-2"></i>
                                        <span style="color:rgb(253, 253, 253)">ลงโอที</span>
                                        
                                    </a> 
                                    <button type="button" class="ladda-button me-2 btn-pill btn cardot add_color" style="background-color: rgb(207, 168, 243)" >
                                        <i class="fa-solid fa-folder-plus text-white me-2" style="font-size:13px"></i>
                                        <span style="color:rgb(253, 253, 253)">เลือกสี</span>
                                    </button> 
                                    <a href="{{ url('export_otform1/' . $startdate . '/' . $enddate . '/' . $reqsend . '/' . $iddep) }}"
                                            class="ladda-button me-2 btn-pill btn cardot" style="background-color: rgb(243, 198, 168)" target="_blank"><i
                                                class="fa-solid fa-print text-white me-2"></i>ฟอร์ม2</a>
                                         
                                    <a href="{{ url('export_otform3/' . $startdate . '/' . $enddate . '/' . $reqsend . '/' . $iddep) }}"
                                            class="ladda-button me-2 btn-pill btn cardot" style="background-color: rgb(243, 198, 168)" target="_blank"><i
                                                class="fa-solid fa-print text-white me-2"></i>ฟอร์ม3</a>
                                        
                                    <a href="{{ url('export_otform4/' . $startdate . '/' . $enddate . '/' . $reqsend . '/' . $iddep) }}"
                                            class="ladda-button me-2 btn-pill btn cardot" style="background-color: rgb(243, 198, 168)" target="_blank"><i
                                                class="fa-solid fa-print text-white me-2"></i>ฟอร์ม4</a>

                                {{-- <div class="dropdown">
                                    <button class="btn-icon btn-shadow btn-dashed btn btn-outline-primary dropdown-toggle menu"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                    <ul class="dropdown-menu text-center">
                                        <a href="{{ url('otone_add') }}" class="btn btn-info waves-effect waves-light btn-sm"
                                            target="_blank"><i class="fa-solid fa-folder-plus text-white me-2"></i>
                                            ลงโอที
                                        </a>
                                        <br>
                                        <button type="button" class="btn add_color mt-2 btn-sm"
                                            style="background-color: blueviolet" data-bs-toggle="tooltip"
                                            data-bs-placement="left" title="เลือกสี">
                                            <i class="fa-solid fa-folder-plus text-white me-2" style="font-size:13px"></i>
                                            <span style="color:rgb(253, 253, 253)">เลือกสี</span>
                                        </button>
                                        <br> --}}

                                        {{-- <a href="{{ url('export_otform1/' . $startdate . '/' . $enddate . '/' . $reqsend . '/' . $iddep) }}"
                                            class="btn btn-warning btn-sm mt-2" target="_blank"><i
                                                class="fa-solid fa-print text-white me-2"></i>ฟอร์ม2</a>
                                        <br>
                                        <a href="{{ url('export_otform3/' . $startdate . '/' . $enddate . '/' . $reqsend . '/' . $iddep) }}"
                                            class="btn btn-warning btn-sm mt-2" target="_blank"><i
                                                class="fa-solid fa-print text-white me-2"></i>ฟอร์ม3</a>
                                        <br>
                                        <a href="{{ url('export_otform4/' . $startdate . '/' . $enddate . '/' . $reqsend . '/' . $iddep) }}"
                                            class="btn btn-warning btn-sm mt-2" target="_blank"><i
                                                class="fa-solid fa-print text-white me-2"></i>ฟอร์ม4</a> --}}
                                        {{-- <br> --}}

                                    {{-- </ul> --}}
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-xl-12">
                    <form action="{{ route('ot.otone') }}" method="GET">
                        @csrf
                        <div class="row"> 
                            <div class="col"></div>
                            <div class="col-md-1 text-end mt-2">วันที่</div>
                            <div class="col-md-4 text-end">
                                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                    <input type="text" class="form-control cardot" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $startdate }}" required/>
                                    <input type="text" class="form-control cardot" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                        data-date-language="th-th" value="{{ $enddate }}"/>  
                                        <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary cardot" data-style="expand-left">
                                            <span class="ladda-label"><i class="fa-solid fa-magnifying-glass"></i> ค้นหา</span>
                                            <span class="ladda-spinner"></span>
                                        </button> 
                                </div>
                            </div>
    

                            <div class="col-md-2">                       
                                    <a href="{{ url('otone_add') }}" class="ladda-button me-2 btn-pill btn cardot" style="background-color: rgb(178, 243, 227)"
                                        target="_blank"><i class="fa-solid fa-folder-plus text-white me-2"></i>
                                        <span style="color:rgb(253, 253, 253)">ลงโอที</span>
                                        
                                    </a> 
                                    <button type="button" class="ladda-button me-2 btn-pill btn cardot add_color" style="background-color: rgb(207, 168, 243)" >
                                        <i class="fa-solid fa-folder-plus text-white me-2" style="font-size:13px"></i>
                                        <span style="color:rgb(253, 253, 253)">เลือกสี</span>
                                    </button> 
                                
                            </div>
                    </form>
                </div>
            </div>
        @endif
      
        

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card cardot">
                    <div class="card-body">
                        <div class="table-responsive">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example"> --}}
                            {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center" width="10%" >วันที่</th>
                                        <th class="text-center" width="15%">ชื่อ-สกุล</th>
                                        <th class="text-center" width="10%">รายมือชื่อ</th>
                                        <th class="text-center" width="10%">เวลามา</th>
                                        <th class="text-center" width="10%">รายมือชื่อ</th>
                                        <th class="text-center" width="10%">เวลากลับ</th>

                                        <th class="text-center" width="10%">ขั่วโมง</th>
                                        <th class="p-2">หน้าที่ที่ปฏิบัติ</th>
                                        {{-- <th class="p-2">หน่วยงาน</th> --}}
                                        <th class="text-center" width="7%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($ot_one as $item)
                                        <?php
                                        $start = strtotime($item->ot_one_starttime);
                                        $end = strtotime($item->ot_one_endtime);
                                        $tot = ($end - $start) / 3600;
                                        $date1 = date_create($item->ot_one_starttime);
                                        $date2 = date_create($item->ot_one_endtime);
                                        
                                        $diff = date_diff($date1, $date2);
                                        $totalhr = $diff->format('%R%H ชม.');
                                        
                                        ?>
                                        <tr id="sid{{ $item->ot_one_id }}" style="font-size:13px">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="p-2" width="7%">{{ $item->ot_one_date }}</td>
                                            <td class="p-2" width="10%">{{ $item->prefix_name }} {{ $item->fname }} {{ $item->lname }}</td>
                                            <td class="p-2" width="7%">{{ $item->ot_one_sign }} </td>
                                            <td class="p-2" width="7%">{{ $item->ot_one_starttime }}</td>
                                            <td class="p-2" width="7%">{{ $item->ot_one_sign2 }} </td>
                                            <td class="p-2" width="7%">{{ $item->ot_one_endtime }} </td>

                                            <td class="p-2" width="7%">{{ $tot }} </td>
                                            <td class="p-2">{{ $item->ot_one_detail }}</td>
                                            {{-- <td class="p-2">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>  --}}

                                            <td class="text-center" width="5%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <button type="button"class="dropdown-item menu edit_data"
                                                            value="{{ $item->ot_one_id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"
                                                                style="font-size:13px"></i>
                                                            <span style="color:orange">แก้ไข</span>

                                                        </button>

                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="otone_destroy({{ $item->ot_one_id }})"
                                                            style="font-size:13px">
                                                            <i class="fa-solid fa-trash-can ms-2 me-2 text-danger"
                                                                style="font-size:13px"></i>
                                                            <span>ลบ</span>
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
    </div>
    <!--  Modal content for the add_color example -->
    <div class="modal fade" id="add_color" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มสีที่ต้องการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">สีที่ต้องการ</label>
                            <div class="form-group">
                                <input type="color" class="form-control form-control-color" id="color_ot"
                                    name="color_ot" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                <input id="user_id" name="user_id" type="hidden" class="form-control" value="{{ $iduser }}">

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="saveBtn" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Modal content for the settingform example -->
    <div class="modal fade" id="settingform" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">ตั้งค่าฟอร์ม4</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">วันที่</label>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-color" id="color_ot"
                                    name="color_ot" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                <input id="user_id" name="user_id" type="hidden" class="form-control" value="{{ $iduser }}">

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="saveBtn" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Modal content Updte -->
    <div class="modal fade" id="updteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invenModalLabel">แก้ไขลงเวลาโอที</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-2 mt-3">
                            <label for="editot_one_detail">เหตุผล </label>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="form-outline">
                                <input id="editot_one_detail" type="text" class="form-control input-rounded">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mt-3">
                            <label for="editot_one_date">วันที่ </label>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="form-outline">
                                <input id="editot_one_date" type="date" class="form-control input-rounded">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 mt-3">
                            <label for="editot_one_starttime">ตั้งแต่เวลา </label>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <input id="editot_one_starttime" type="time" class="form-control input-rounded">
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label for="ot_one_endtime">ถึงเวลา </label>
                        </div>
                        <div class="col-md-4 mt-3">
                            <div class="form-group">
                                <input id="editot_one_endtime" type="time" class="form-control input-rounded">
                            </div>
                        </div>
                    </div>

                    <input id="editot_one_id" type="hidden" class="form-control form-control-sm">
                    <input type="hidden" id="edituser_id" name="user_id" value=" {{ Auth::user()->id }}">
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="updateBtn" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                แก้ไขข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
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

            // $('select').select2();
            // $('#ECLAIM_STATUS').select2({
            //     dropdownParent: $('#detailclaim')
            // });

            // $('#users_group_id').select2({
            //     placeholder: "--เลือก-- ",
            //     allowClear: true
            // });

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


            $(document).on('click', '.add_color', function() {
                var user_id = $(this).val();
                // alert(ot_one_id);
                $('#add_color').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('otone_add_color') }}" + '/' + user_id,
                    success: function(data) {
                        $('#user_id').val(data.users_color.id)

                    },
                });

                $('#saveBtn').click(function() {

                    var color_ot = $('#color_ot').val();
                    var user_id = $('#user_id').val();
                    // alert(color_ot);
                    $.ajax({
                        url: "{{ route('ot.otone_updatecolor') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            color_ot,
                            user_id
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                // alert('gggggg');
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

            $(document).on('click', '.edit_data', function() {
                var ot_one_id = $(this).val();
                // alert(ot_one_id);
                $('#updteModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('otone_edit') }}" + '/' + ot_one_id,
                    success: function(data) {
                        $('#editot_one_starttime').val(data.ot.ot_one_starttime)
                        $('#editot_one_endtime').val(data.ot.ot_one_endtime)
                        $('#editot_one_date').val(data.ot.ot_one_date)
                        $('#editot_one_detail').val(data.ot.ot_one_detail)
                        // $('#edituser_id').val(data.ot.ot_one_nameid)
                        $('#editot_one_id').val(data.ot.ot_one_id)
                    },
                });
            });

            $('#updateBtn').click(function() {
                var ot_one_starttime = $('#editot_one_starttime').val();
                var ot_one_endtime = $('#editot_one_endtime').val();
                var ot_one_date = $('#editot_one_date').val();
                var ot_one_detail = $('#editot_one_detail').val();
                var user_id = $('#edituser_id').val();
                var ot_one_id = $('#editot_one_id').val();
                // alert(ot_one_id);
                $.ajax({
                    url: "{{ route('ot.otone_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        ot_one_id,
                        ot_one_detail,
                        ot_one_date,
                        ot_one_starttime,
                        ot_one_endtime,
                        user_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You edit data success",
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

            // settingform
            $(document).on('click', '.settingform', function() {
                var datepicker = $(this).val();
                // alert(datepicker);
                $('#settingform').modal('show');
                // $.ajax({
                //     type: "GET",
                //     url: "{{ url('otone_edit') }}" + '/' + ot_one_id,
                //     success: function(data) {
                //         $('#editot_one_starttime').val(data.ot.ot_one_starttime)
                //         $('#editot_one_endtime').val(data.ot.ot_one_endtime)
                //         $('#editot_one_date').val(data.ot.ot_one_date)
                //         $('#editot_one_detail').val(data.ot.ot_one_detail)
                //         // $('#edituser_id').val(data.ot.ot_one_nameid)
                //         $('#editot_one_id').val(data.ot.ot_one_id)
                //     },
                // });
            });

        });
    </script>

@endsection
