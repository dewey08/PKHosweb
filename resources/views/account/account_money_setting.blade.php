@extends('layouts.account')
@section('title', 'PK-OFFICER || Account')
@section('content')
    <script>
        function account_money_destroy(account_listpercen_id) {
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
                        url: "{{ url('account_money_destroy') }}" + '/' + account_listpercen_id,
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
                                    $("#sid" + account_listpercen_id).remove();
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
        <div class="row">
            
            <div class="col-xl-6">
                <div class="row mb-2">
                    <div class="col">
                        <h5 class="mb-sm-0">ตั้งค่า กบข./กสจ./สมทบ </h5>
                    </div>
                    <div class="col"></div>
                    <div class="col-md-3">
                        {{-- <button type="button" class="btn btn-outline-info btn-sm waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#Insertdata">
                            <i class="fa-solid fa-folder-plus text-info me-2"></i>
                            กำหนดรายการ
                        </button> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                        id="example">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="p-2">รายการที่ใช้คำนวณ</th>
                                                <th class="p-2">เปอร์เซ็นต์ที่ใช้คำนวณ</th>
                                                <th class="text-center" width="10%">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($account_listpercen as $item)
                                                <tr id="sid{{ $item->account_listpercen_id }}">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="p-2">{{ $item->account_listpercen_name }}</td>
                                                    <td class="p-2">{{ $item->account_listpercen_percent }} %</td>
                                                    <td class="text-center" width="10%">
                                                        <div class="dropdown">
                                                            <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">ทำรายการ</button>
                                                            <ul class="dropdown-menu">
                                                                <button type="button"class="dropdown-item menu edit_data"
                                                                    value="{{ $item->account_listpercen_id }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    title="แก้ไข">
                                                                    <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                                    <label for=""
                                                                        style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                                </button>
        
                                                                {{-- <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                                    onclick="account_money_destroy({{ $item->account_listpercen_id }})"
                                                                    style="font-size:13px">
                                                                    <i class="fa-solid fa-trash-can ms-2 me-2 text-danger"
                                                                        style="font-size:13px"></i>
                                                                    <span>ลบ</span>
                                                                </a> --}}
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
            <div class="col-xl-6">
                <div class="row mb-2">
                    <div class="col">
                        <h5 class="mb-sm-0">ตั้งค่าเจ้าหนี้ </h5>
                    </div>
                    <div class="col"></div>
                    <div class="col-md-3">
                        {{-- <button type="button" class="btn btn-outline-info btn-sm waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#Insertdata2">
                            <i class="fa-solid fa-folder-plus text-info me-2"></i>
                            เพิ่มเจ้าหนี้
                        </button> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                        id="example2">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="p-2">รหัสหนี้</th>
                                                <th class="p-2">รายการเจ้าหนี้</th>
                                                <th class="text-center" width="10%">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($account_creditor as $item2)
                                                <tr id="sid{{ $item2->account_creditor_id }}">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="p-2">{{ $item2->account_creditor_code }}</td>
                                                    <td class="p-2">{{ $item2->account_creditor_name }}</td>
                                                    <td class="text-center" width="10%">
                                                        <div class="dropdown">
                                                            <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">ทำรายการ</button>
                                                            <ul class="dropdown-menu">
                                                                <button type="button"class="dropdown-item menu edit_data2"
                                                                    value="{{ $item2->account_creditor_id }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    title="แก้ไข">
                                                                    <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                                    <label for=""
                                                                        style="font-size:13px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                                </button>
         
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
            
        </div> 
    </div>
    <!--  Modal content for the above example -->
    <div class="modal fade" id="Insertdata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มรายการที่ใช้คำนวณ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">รายการ</label>
                            <div class="form-group">
                                <input id="account_percen_name" class="form-control form-control-sm" style="width: 100%">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="">คิดเป็น %</label>
                            <div class="form-group">
                                <input id="account_listpercen_percent" class="form-control form-control-sm"
                                    style="width: 100%">
                                {{-- <select name="account_percen_id" id="account_percen_id" class="form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($account_percen as $per) 
                                            <option value="{{ $per->account_percen_id }}">{{ $per->account_percen_name }} </option>                                 
                                    @endforeach
                                </select> --}}
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
                    <h5 class="modal-title" id="invenModalLabel">แก้ไขรายการที่ใช้คำนวณ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="editaccount_listpercen_id" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">รายการ</label>
                            <div class="form-group">
                                <input id="editaccount_listpercen_name" class="form-control form-control-sm"
                                    style="width: 100%">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="">คิดเป็น %</label>
                            <div class="form-group">
                                <input id="editaccount_listpercen_percent" class="form-control form-control-sm"
                                    style="width: 100%">
                                {{-- <select name="account_percen_id" id="account_percen_id" class="form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($account_percen as $per) 
                                            <option value="{{ $per->account_percen_id }}">{{ $per->account_percen_name }} </option>                                 
                                    @endforeach
                                </select> --}}
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

    <!--  Modal content for the above example -->
    <div class="modal fade" id="Insertdata2" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มรายการเจ้าหนี้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">รหัสหนี้</label>
                            <div class="form-group">
                                <input id="account_creditor_code" name="account_creditor_code" class="form-control form-control-sm" style="width: 100%">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label for="">ชื่อเจ้าหนี้</label>
                            <div class="form-group">
                                <input id="account_creditor_name" name="account_creditor_name" class="form-control form-control-sm"
                                    style="width: 100%">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="saveBtn2" class="btn btn-primary btn-sm">
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
     <div class="modal fade" id="updteModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invenModalLabel">แก้ไขรายการเจ้าหนี้</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="editaccount_creditor_id" type="hidden" class="form-control form-control-sm">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">รหัสหนี้</label>
                            <div class="form-group">
                                <input id="editaccount_creditor_code" name="editaccount_creditor_code" class="form-control form-control-sm" style="width: 100%">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label for="">ชื่อเจ้าหนี้</label>
                            <div class="form-group">
                                <input id="editaccount_creditor_name" name="editaccount_creditor_name" class="form-control form-control-sm"
                                    style="width: 100%">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="updateBtn2" class="btn btn-primary btn-sm">
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
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('select').select2();
            $('#account_percen_id').select2({
                dropdownParent: $('#Insertdata')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveBtn').click(function() {

                var account_percen_name = $('#account_percen_name').val();
                var account_listpercen_percent = $('#account_listpercen_percent').val();
                // alert(account_percen_id);
                $.ajax({
                    url: "{{ route('acc.account_money_settingsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_percen_name,
                        account_listpercen_percent
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

            $(document).on('click', '.edit_data', function() {
                var editaccount_listpercen_id = $(this).val();
                // alert(editaccount_listpercen_id);
                $('#updteModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('account_money_settingedit') }}" + '/' + editaccount_listpercen_id,
                    success: function(data) {
                        console.log(data.listpercen.account_listpercen_name);
                        $('#editaccount_listpercen_name').val(data.listpercen
                            .account_listpercen_name)
                        $('#editaccount_listpercen_percent').val(data.listpercen
                            .account_listpercen_percent)
                        $('#editaccount_listpercen_id').val(data.listpercen
                            .account_listpercen_id)
                    },
                });
            });

            $('#updateBtn').click(function() {
                var account_listpercen_id = $('#editaccount_listpercen_id').val();
                var account_listpercen_name = $('#editaccount_listpercen_name').val();
                var account_listpercen_percent = $('#editaccount_listpercen_percent').val();
                $.ajax({
                    url: "{{ route('acc.account_money_settingupdate') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_listpercen_id,
                        account_listpercen_name,
                        account_listpercen_percent
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

            $('#saveBtn2').click(function() {

                var account_creditor_code = $('#account_creditor_code').val();
                var account_creditor_name = $('#account_creditor_name').val(); 
                $.ajax({
                    url: "{{ route('acc.account_money_creditorsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_creditor_code,
                        account_creditor_name
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

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });
            $(document).on('click', '.edit_data2', function() {
                var editaccount_creditor_id = $(this).val();             
                $('#updteModal2').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('account_money_creditoredit') }}" + '/' + editaccount_creditor_id,
                    success: function(data) {
                        console.log(data.creditor.account_creditor_code);
                        $('#editaccount_creditor_code').val(data.creditor.account_creditor_code)
                        $('#editaccount_creditor_name').val(data.creditor.account_creditor_name)
                        $('#editaccount_creditor_id').val(data.creditor.account_creditor_id)
                    },
                });
            });
            $('#updateBtn2').click(function() {
                var account_creditor_id = $('#editaccount_creditor_id').val();
                var account_creditor_name = $('#editaccount_creditor_name').val();
                var account_creditor_code = $('#editaccount_creditor_code').val();
                $.ajax({
                    url: "{{ route('acc.account_money_creditorupdate') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        account_creditor_id,
                        account_creditor_name,
                        account_creditor_code
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
