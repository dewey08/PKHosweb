@extends('layouts.plannew')
@section('title', 'PK-OFFICER || Plan')
@section('content')
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
    <script>
        

        function plan_mission_destroy(plan_mission_id) {
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
                        url: "{{ url('plan_mission_destroy') }}" + '/' + plan_mission_id,
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
                                    $("#sid" + plan_mission_id).remove();
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
    
    <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
    <?php
    use App\Http\Controllers\karnController;
    use Illuminate\Support\Facades\DB;
    ?>
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-sm-0">พันธกิจ </h5>
                    </div>
                    <div class="col-md-3 text-center"></div>
                    <div class="col-md-6 text-center"></div>
                    <div class="col">
                        <button type="button" class="btn btn-info btn-sm waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#insertdata">
                            <i class="fa-solid fa-folder-plus text-white me-2"></i>
                            เพิ่มพันธกิจ
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header ">
                        พันธกิจ                      
                        <div class="btn-actions-pane-right">
                            <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info"
                                    data-bs-toggle="modal" data-bs-target="#insertdata">
                                    <i class="fa-solid fa-folder-plus text-info me-2"></i>
                                    เพิ่มพันธกิจ
                            </button> 
                        </div>                        
                    </div>  
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        {{-- <th class="p-2">วิสัยทัศน์</th> --}}
                                        <th class="p-2">พันธกิจ</th>
                                        <th class="text-center" width="10%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($plan_mission as $item)
                                        <tr id="sid{{ $item->plan_mission_id }}">
                                            <td class="text-center">{{ $i++ }}</td>
                                            {{-- <td class="p-2">{{ $item->plan_vision_name }}</td> --}}
                                            <td class="p-2">{{ $item->plan_mission_name }}</td>
                                            <td class="text-center" width="10%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        {{-- <button type="button"class="dropdown-item menu edit_data"
                                                            value="{{ $item->plan_mission_id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for=""
                                                                style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </button> --}}
                                                        <button type="button"class="dropdown-item menu"
                                                            data-bs-toggle="modal" data-bs-target="#updateModal{{ $item->plan_mission_id }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                            <label for=""
                                                                style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                        </button>

                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="plan_mission_destroy({{ $item->plan_mission_id }})"
                                                            style="font-size:13px">
                                                            <i class="fa-solid fa-trash-can ms-2 me-2 text-danger"
                                                                style="font-size:13px"></i>
                                                            <span>ลบ</span>
                                                        </a>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <!--  Modal content Update -->
                                        <div class="modal fade" id="updateModal{{ $item->plan_mission_id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="invenModalLabel">แก้ไขวิสัยทัศน์</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input id="editplan_mission_id" type="hidden" class="form-control form-control-sm" value="{{ $item->plan_mission_id }}">
                                                        <div class="row">
                                                            <div class="col-md-12 mt-3">
                                                                <label for="">วิสัยทัศน์</label>
                                                                <div class="form-group"> 
                                                                        <select id="editplan_vision_id" name="editplan_vision_id js-example-theme-single" class="form-control form-control-sm"
                                                                        style="width: 100%">
                                                                        <option value="">=เลือก=</option>
                                                                        @foreach ($plan_vision as $vision)
                                                                        @if ( $item->plan_vision_id == $vision->plan_vision_id)
                                                                        <option value="{{ $vision->plan_vision_id }}" selected>{{ $vision->plan_vision_name }} </option>
                                                                        @else
                                                                        <option value="{{ $vision->plan_vision_id }}">{{ $vision->plan_vision_name }} </option>
                                                                        @endif
                                                                            
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mt-3">
                                                                <label for="">พันธกิจ</label>
                                                                <div class="form-group">
                                                                    <input id="editplan_mission_name" name="editplan_mission_name" type="text"
                                                                        class="form-control form-control-sm" value="{{ $item->plan_mission_name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 text-end">
                                                            <div class="form-group">
                                                                <button type="button" id="updateBtn"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                    แก้ไขข้อมูล
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark me-2"></i>Close</button>

                                                            </div>
                                                        </div>
                                                    </div>
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

    <!--  Modal content for the insert example -->
    <div class="modal fade" id="insertdata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มพันธกิจ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">วิสัยทัศน์</label>
                            <div class="form-group">
                                <select name="plan_vision_id" id="plan_vision_id" class="form-control form-control-sm"
                                    style="width: 100%">
                                    <option value="">=เลือก=</option>
                                    @foreach ($plan_vision as $vision)
                                        <option value="{{ $vision->plan_vision_id }}">{{ $vision->plan_vision_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label for="">พันธกิจ</label>
                            <div class="form-group">
                                <input id="plan_mission_name" class="form-control form-control-sm" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>

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

    <!--  Modal content Update -->
    {{-- <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invenModalLabel">แก้ไขวิสัยทัศน์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="editplan_mission_id" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">วิสัยทัศน์</label>
                            <div class="form-group">
                                <input id="editplan_vision_id" type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">พันธกิจ</label>
                            <div class="form-group">
                                <input id="editplan_mission_name" type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
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
    </div> --}}


@endsection
@section('footer')
    <script>
       $(".js-example-theme-single").select2({
            theme: "classic"
            });
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('select').select2();
            $('#plan_vision_id').select2({
                dropdownParent: $('#insertdata')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#saveBtn').click(function() {

                var plan_vision_id = $('#plan_vision_id').val();
                var plan_mission_name = $('#plan_mission_name').val();
                // alert(plan_vision_id);
                $.ajax({
                    url: "{{ route('p.plan_mission_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        plan_vision_id,
                        plan_mission_name
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

            // $(document).on('click', '.edit_data', function() {
            //     var plan_mission_id = $(this).val();
            //     $('#updteModal').modal('show');
            //     $.ajax({
            //         type: "GET",
            //         url: "{{ url('plan_mission_edit') }}" + '/' + plan_mission_id,
            //         success: function(data) {
            //             console.log(data.mission.plan_vision_name);
            //             $('#editplan_vision_name').val(data.mission.plan_vision_name)
            //             $('#editplan_vision_id').val(data.mission.plan_vision_id)
            //             $('#editplan_mission_id').val(data.mission.plan_mission_id)
            //         },
            //     });
            // });
            $('#updateBtn').click(function() {
                    var editplan_vision_id = $('#editplan_vision_id').val();
                    // alert(plan_vision_id);
                    var editplan_mission_id = $('#editplan_mission_id').val();
                    var editplan_mission_name = $('#editplan_mission_name').val();
                    $.ajax({
                        url: "{{ route('p.plan_mission_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            editplan_vision_id,
                            editplan_mission_id,
                            editplan_mission_name
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


        });
    </script>

@endsection
