@extends('layouts.nurse')
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
        
        <div class="row"> 
            <div class="col-md-4"> 
                <h5 class="card-title" style="color:green">Process data Nurse</h5> 
            </div>
            <div class="col"></div> 
            <div class="col-md-2 text-end">
                <button type="button" class="ladda-button me-2 btn-pill btn btn-primary card_audit_4c" id="Pulldata">
                    <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ประมวลผล</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>
        </div>
         
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card card_audit_4c">
                    <div class="card-body">
                        <div class="table-responsive"> 
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center" width="10%" >วันที่</th>
                                        <th class="text-center" width="15%">ward</th>
                                        <th class="text-center" width="10%">AN</th> 
                                        <th class="text-center" width="10%">Np</th>
                                        <th class="text-center" width="10%">7.30</th>
                                        <th class="text-center" width="10%">Total 7.30</th> 
                                        <th class="text-center" width="10%">Np</th>
                                        <th class="text-center" width="10%">15.30</th>
                                        <th class="text-center" width="10%">Total 15.30</th> 
                                        <th class="text-center" width="10%">Np</th>
                                        <th class="text-center" width="10%">23.30</th> 
                                        <th class="text-center" width="10%">Total 23.30</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <?php
                                      
                                        ?>
                                        <tr style="font-size:13px">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="text-center" width="7%">{{ Datethai($item->datesave )}}</td>
                                            <td class="p-2" width="10%"> {{ $item->ward_name }}</td>
                                            <td class="text-center" width="7%">{{ $item->count_an }} </td>
                                            <td class="text-center" width="7%">
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </td>
                                            <td class="text-center" width="7%">{{ $item->soot_a }} </td>
                                            <td class="text-center" width="7%">Total 7.30</td>
                                            <td class="text-center" width="7%"> 
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </td>
                                            <td class="text-center" width="7%">{{ $item->soot_b }} </td> 
                                            <td class="text-center" width="7%">Total 15.30</td>
                                            <td class="text-center" width="7%"> 
                                                <input type="text" class="form-control form-control-sm" id="" name="">
                                            </td>
                                            <td class="text-center" width="7%">{{ $item->soot_c}} </td>
                                            <td class="text-center" width="7%">Total 23.30</td>
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
