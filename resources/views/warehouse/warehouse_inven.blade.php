@extends('layouts.warehouse_new')
@section('title', 'PK-OFFICER || คลังวัสดุ')
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
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function warehouse_inven_destroy(warehouse_inven_id) {
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
                        url: "{{ url('warehouse_inven_destroy') }}" + '/' + warehouse_inven_id,
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
                                    $("#sid" + warehouse_inven_id).remove();
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
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    ?>
    <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        รายการคลังวัสดุ
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">

                                <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                                    data-bs-toggle="modal" data-bs-target=".inven">
                                    <i class="pe-7s-shuffle btn-icon-wrapper"></i>เพิ่มคลังวัสดุ
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered myTable" style="width: 100%;"
                                id="example">
                                <thead>
                                    <tr height="10px">
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ชื่อคลังวัสดุ</th>
                                        <th class="text-center" width="20%">ผู้สั่งจ่าย</th>
                                        <th class="text-center" width="10%">ผู้ดูแล</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouse_inven as $key => $item)
                                        <tr id="sid{{ $item->warehouse_inven_id }}">
                                            <td class="text-center" width="5%">{{ $key + 1 }}</td>
                                            <td class="p-2">{{ $item->warehouse_inven_name }}</td>
                                            <td class="p-2" width="20%">{{ $item->fname }} {{ $item->lname }}</td>

                                            <td class="text-center" width="10%">
                                                {{-- <button type="button"
                                                    class="btn btn-success waves-effect waves-light btn-sm add_user"
                                                    value="{{ $item->warehouse_inven_id }}">
                                                    <i class="fa-solid fa-user-plus"></i>
                                                </button> --}}
                                                <a class="btn btn-success waves-effect waves-light btn-sm"
                                                    href="{{ url('warehouse/warehouse_inven_addper/' . $item->warehouse_inven_id) }}">
                                                    <i class="fa-solid fa-user-plus"></i>
                                                </a>


                                            </td>
                                            <td class="text-center" width="10%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <button type="button"class="dropdown-item menu edit_data"
                                                            value="{{ $item->warehouse_inven_id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="แก้ไข">
                                                            <i
                                                                class="fa-solid fa-pen-to-square mt-2 ms-2 mb-2 me-2 text-warning"></i>
                                                            <label for=""
                                                                style="color: rgb(243, 168, 7)">แก้ไข</label>
                                                        </button>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="warehouse_inven_destroy({{ $item->warehouse_inven_id }})"
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
    <!--  Modal content for the above example -->
    <div class="modal fade inven" id="invenModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มคลังวัสดุ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">ชื่อคลังวัสดุ</label>
                            <div class="form-group">
                                <input id="warehouse_inven_name" name="warehouse_inven_name"
                                    class="form-control form-control-sm" style="width: 100%">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="">ผู้สั่งจ่าย</label>
                            <div class="form-group">
                                {{-- <select name="warehouse_inven_userid" id="warehouse_inven_userid" class="form-control"
                                multiple="multiple" style="width: 100%;"> --}}
                                <select name="warehouse_inven_userid" id="warehouse_inven_userid"
                                    class="form-control form-control-sm" style="width: 100%;">
                                    <option>--เลือก--</option>
                                    @foreach ($users as $item1)
                                        <option value="{{ $item1->id }}"> {{ $item1->fname }} {{ $item1->lname }}
                                        </option>
                                    @endforeach
                                </select>
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

    <!--  Modal content Updte -->
    <div class="modal fade" id="updteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invenModalLabel">แก้ไขคลังวัสดุ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="editwarehouse_inven_id" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">ชื่อคลังวัสดุ</label>
                            <div class="form-group">
                                <input id="editwarehouse_inven_name" type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="">ผู้สั่งจ่าย</label>
                            <div class="form-group">
                                {{-- <select name="warehouse_inven_userid" id="warehouse_inven_userid" class="form-control"
                            multiple="multiple" style="width: 100%;"> --}}
                                <select id="editwarehouse_inven_userid" class="form-control form-control-sm"
                                    style="width: 100%;">
                                    <option>--เลือก--</option>
                                    @foreach ($users as $item1)
                                        <option value="{{ $item1->id }}"> {{ $item1->fname }} {{ $item1->lname }}
                                        </option>
                                    @endforeach
                                </select>
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
    </div>


@endsection
@section('footer')
    <script>
        $(document).ready(function() {

            $('select').select2();
            $('#warehouse_inven_person_userid').select2({
                dropdownParent: $('#inven_adduser')
            });

            $('#warehouse_inven_userid').select2({
                dropdownParent: $('#invenModal')
            });

            $('#editwarehouse_inven_userid').select2({
                dropdownParent: $('#updteModal')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#saveBtn').click(function() {

                var warehouse_inven_name = $('#warehouse_inven_name').val();
                var warehouse_inven_userid = $('#warehouse_inven_userid').val();
                // alert(warehouse_inven_userid);
                $.ajax({
                    url: "{{ route('ware.warehouse_invensave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        warehouse_inven_name,
                        warehouse_inven_userid
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
            $('#updateBtn').click(function() {
                var warehouse_inven_id = $('#editwarehouse_inven_id').val();
                var warehouse_inven_name = $('#editwarehouse_inven_name').val();
                var warehouse_inven_userid = $('#editwarehouse_inven_userid').val();
                $.ajax({
                    url: "{{ route('ware.warehouse_invenupdate') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        warehouse_inven_id,
                        warehouse_inven_name,
                        warehouse_inven_userid
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

        $(document).on('click', '.edit_data', function() {
            var warehouse_inven_id = $(this).val();
            $('#updteModal').modal('show');
            $.ajax({
                type: "GET",
                url: "{{ url('warehouse/warehouse_inven_edit') }}" + '/' + warehouse_inven_id,
                success: function(data) {
                    $('#editwarehouse_inven_name').val(data.inven.warehouse_inven_name)
                    $('#warehouse_inven_userid').val(data.inven.warehouse_inven_userid)
                    $('#editwarehouse_inven_id').val(data.inven.warehouse_inven_id)
                },
            });
        });
    </script>
@endsection
