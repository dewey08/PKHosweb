@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Report')
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
       
        function addpic(input) {
            var fileInput = document.getElementById('img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#add_upload_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                fileInput.value = '';
                return false;
            }
        }
        function editpic(input) {
            var fileInput = document.getElementById('img');
            var url = input.value;
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#edit_upload_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                fileInput.value = '';
                return false;
            }
        }
        function recieve(rep_report_id)
        {
            Swal.fire({
            title: 'ต้องการรับเรื่องใช่ไหม?',
            text: "ข้อมูลนี้จะถูกรับเรื่อง !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, รับเรื่องเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url:"{{url('recieve')}}" +'/'+ rep_report_id,  
                type:'POST',
                data:{
                    _token : $("input[name=_token]").val()
                },
                success:function(response)
                {          
                    Swal.fire({
                        title: 'รับเรื่องสำเร็จ!',
                        text: "You Recieve data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {                  
                        $("#sid"+rep_report_id).remove();     
                        window.location.reload();     
                        }
                    }) 
                }
                })        
                }
            })
        }
        function inprogress(rep_report_id)
        {
            Swal.fire({
            title: 'กำลังดำเนินการใช่ไหม?',
            text: "ข้อมูลนี้จะถูกดำเนินการ !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ดำเนินการเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url:"{{url('inprogress')}}" +'/'+ rep_report_id,  
                type:'POST',
                data:{
                    _token : $("input[name=_token]").val()
                },
                success:function(response)
                {          
                    Swal.fire({
                        title: 'ดำเนินการสำเร็จ!',
                        text: "You In progress data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {                  
                        $("#sid"+rep_report_id).remove();     
                        window.location.reload();     
                        }
                    }) 
                }
                })        
                }
            })
        }
        function submitwork(rep_report_id)
        {
            Swal.fire({
            title: 'ส่งงานใช่ไหม?',
            text: "ข้อมูลนี้จะถูกส่งงาน !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ส่งงานเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url:"{{url('submitwork')}}" +'/'+ rep_report_id,  
                type:'POST',
                data:{
                    _token : $("input[name=_token]").val()
                },
                success:function(response)
                {          
                    Swal.fire({
                        title: 'ส่งงานสำเร็จ!',
                        text: "You In progress data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177',
                        // cancelButtonColor: '#d33',
                        confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                        if (result.isConfirmed) {                  
                        $("#sid"+rep_report_id).remove();     
                        window.location.reload();     
                        }
                    }) 
                }
                })        
                }
            })
        }

    </script>

  
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-xl-12">
                        <form action="{{ route('rep.request_report') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col"></div>
                                <div class="col-md-1 text-end">วันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                            id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true"
                                            value="{{ $startdate }}">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">ถึงวันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                            id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true"
                                            value="{{ $enddate }}">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i
                                            class="fa-solid fa-magnifying-gla
                                    ss me-2"></i>
                                        ค้นหา
                                    </button>
                                </div>
                                <div class="col"></div>
                                <div class="col-md-2">

                                    <button type="button"class="btn add_report" style="background-color: blueviolet"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="เพิ่มใบงาน">
                                        <i class="fa-solid fa-folder-plus text-white me-2" style="font-size:13px"></i>
                                        <span style="color:rgb(253, 253, 253)">เพิ่มใบงาน</span>
                                    </button>
                                </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
        </form>
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center" width="7%">สถานะ</th>                                    
                                        <th class="text-center" width="10%">วันที่ขอ</th>
                                        <th class="text-center" width="7%">เวลาขอ</th>
                                        <th class="text-center" width="7%">ความเร่งด่วน</th>
                                        <th class="text-center" width="7%">รูปภาพ</th>
                                        <th class="text-center">ชื่อเรื่อง</th>                                        
                                        <th class="text-center" width="10%">ผู้ร้องขอ</th>
                                        <th class="text-center" width="7%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($rep_report as $item)
                                        {{-- <?php $i++;
                                            $status =  $item->rep_report_level;
                                                if( $status === 'Normal'){
                                                    $statuslevel =  "badge badge-info";
                                                }else if($status === 'Fast'){
                                                    $statuslevel =  "badge badge-warning";
                                                }else if($status === 'NoFast'){
                                                    $statuslevel =  "badge badge-success";                                     
                                                }else{
                                                    $statuslevel =  "badge badge-danger";
                                                }
                                        ?> --}}
                                        <tr id="sid{{ $item->rep_report_id }}"> 
                                            <td class="p-2">{{ $i}}</td>
                                     
                                            @if ($item->rep_report_status == 'Request')
                                            <td class="text-center" width="7%"><div class="badge bg-warning">ร้องขอ</div></td>
                                            @elseif($item->rep_report_status == 'Recieve')
                                              <td class="text-center" width="7%"><div class="badge" style="background: #592DF7">รับเรื่อง</div></td>   
                                            @elseif($item->rep_report_status == 'Inprogress')
                                              <td class="text-center" width="7%"><div class="badge" style="background: #07D79E">กำลังดำเนินการ</div></td>  
                                              @elseif($item->rep_report_status == 'Submitwork')
                                              <td class="text-center" width="7%"><div class="badge" style="background: #E80DEF">ส่งงาน</div></td>    
                                            @elseif($item->rep_report_status == 'Cancel')
                                              <td class="text-center" width="7%"><div class="badge" style="background: #ff0606">ยกเลิก</div></td>  
                                            @else
                                              {{-- <td class="text-center" width="7%"><div class="badge" style="background: #3CDF44">อนุมัติ</div></td> --}}
                                            @endif

                                           
                                            <td class="p-2">{{ $item->rep_report_date }} </td>
                                            <td class="p-2">{{ $item->rep_report_time }}</td>

                                            {{-- <td><span class="{{$statuslevel}}" >dd</span></td> --}}
                                            {{-- @if($item->rep_report_level = "Normal")
                                                <td class="text-center" width="7%"><div class="badge bg-info">ปกติ</div></td>
                                            @elseif($item->rep_report_level = 'Fast')
                                                <td class="text-center" width="7%"><div class="badge" style="background: #f72daa">เร่งด่วน</div></td>   
                                            @elseif($item->rep_report_level == 'NoFast')
                                                <td class="text-center" width="7%"><div class="badge" style="background: #1fbe94">บ่อฟ้าวเด้อ</div></td>                                             
                                            @else
                                                <td class="text-center" width="7%"><div class="badge" style="background: #f10808">วันนี้</div></td>  
                                            @endif --}}
                                            <td>
                                                {{-- <img src="{{ asset('storage/report/'.$item->img) }}" height="70px" width="70px" alt="Image" class="img-thumbnail"> --}}
                                            </td>
                                            <td class="p-2">{{ $item->rep_report_name }} </td>
                                            <td class="p-2">{{ $item->fullname }}</td> 
                                            <td class="text-center" width="7%">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-info dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <button type="button"class="dropdown-item menu edit_data"
                                                            value="{{ $item->rep_report_id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"
                                                                style="font-size:13px"></i>
                                                            <span style="color:orange">แก้ไข</span>                                                            
                                                        </button>
                                                        @if ($item->rep_report_status == 'Request')
                                                            <a class="dropdown-item text-primary" href="javascript:void(0)"
                                                                onclick="recieve({{ $item->rep_report_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-file-pen ms-2 me-2 text-primary"
                                                                    style="font-size:13px"></i> 
                                                                <span>รับเรื่อง</span> 
                                                            </a>
                                                        @elseif ($item->rep_report_status == 'Recieve')
                                                            <a class="dropdown-item text-primary" href="javascript:void(0)"
                                                                onclick="inprogress({{ $item->rep_report_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-pen-clip ms-2 me-2 text-primary"
                                                                    style="font-size:13px"></i> 
                                                                <span>กำลังดำเนินการ</span>
                                                            </a>
                                                           
                                                        @elseif ($item->rep_report_status == 'Inprogress')
                                                            <a class="dropdown-item text-primary" href="javascript:void(0)"
                                                                onclick="submitwork({{ $item->rep_report_id }})"
                                                                style="font-size:13px">
                                                                <i class="fa-solid fa-pen-clip ms-2 me-2 text-primary"
                                                                    style="font-size:13px"></i> 
                                                                <span>ส่งงาน</span>
                                                            </a>
                                                          
                                                        @elseif ($item->rep_report_status == 'Submitwork')
                                                           
                                                        @elseif ($item->rep_report_status == 'Cancel')
                                                          
                                                        @else
                                                          {{-- <td class="text-center" width="7%"><div class="badge" style="background: #3CDF44">อนุมัติ</div></td> --}}
                                                        @endif
{{-- 
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="otone_destroy({{ $item->rep_report_id }})"
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
    <!--  Modal content for the add_color example -->
    <div class="modal fade" id="add_report" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">ยื่นใบงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <form action="{{ route('rep.request_report_save') }}" method="POST" --}}
                <form action="{{ route('rep.request_report_save') }}" method="POST" id="insert_repForm"
                enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">ชื่อเรื่อง</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="rep_report_name" name="rep_report_name"
                                    style="width: 100%">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label for="">รายละเอียด</label>
                            <div class="form-group">
                                <textarea name="rep_report_detail" id="rep_report_detail" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="">รูปภาพ</label>
                            <div class="form-group">
                                <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                    alt="Image" class="img-thumbnail" width="300px" height="300px">
                                <br>
                                <div class="input-group mb-3 mt-3">

                                    <input type="file" class="form-control" id="img" name="img"
                                        onchange="addpic(this)">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="">ระดับความต้องการ</label>
                            <select name="rep_report_status_level" id="rep_report_status_level" class="form-control">
                                <option value="Normal">ปกติ</option>
                                <option value="Fast">เร่งด่วน</option>
                                <option value="NoFast">บ่อฟ้าวเด้อ</option>
                                <option value="Now">วันนี้</option>
                            </select>
                        </div> 
                    </div>

                </div>
                <input id="rep_report_rep_userid" name="rep_report_rep_userid" type="hidden" class="form-control"
                    value="{{ $iduser }}">

                
                    <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{-- <button type="button" id="saveBtn" class="btn btn-primary btn-sm"> --}}
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!--  Modal content Updte -->
    <div class="modal fade" id="updteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">แก้ไขใบงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rep.request_report_update') }}" method="POST" id="update_repForm"
                enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">ชื่อเรื่อง</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="editrep_report_name" name="rep_report_name"
                                    style="width: 100%">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label for="">รายละเอียด</label>
                            <div class="form-group">
                                <textarea name="rep_report_detail" id="editrep_report_detail" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="">รูปภาพ</label>
                            <div class="form-group">
                                <img src="{{ asset('assets/images/default-image.jpg') }}" id="edit_upload_preview"
                                    alt="Image" class="img-thumbnail" width="300px" height="300px">
                                <br>
                                <div class="input-group mb-3 mt-3">

                                    <input type="file" class="form-control" id="editimg" name="img"
                                        onchange="editpic(this)">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="">ระดับความต้องการ</label>
                            <select name="rep_report_status_level" id="editrep_report_status_level" class="form-control">
                                <option value="Normal">ปกติ</option>
                                <option value="Fast">เร่งด่วน</option> 
                                <option value="NoFast">บ่อฟ้าวเด้อ</option> 
                                <option value="Now">วันนี้</option>
                            </select>
                        </div> 
                    </div>
                </div>

                <input id="rep_report_rep_userid" name="rep_report_rep_userid" type="hidden" class="form-control"
                    value="{{ $iduser }}">

                <input id="editrep_report_id" name="rep_report_id" type="hidden" class="form-control" >

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            {{-- <button type="button" id="updateBtn" class="btn btn-primary btn-sm"> --}}
                                <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                แก้ไขข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            $('#example').DataTable(); 

            $('select').select2();
            $('#rep_report_status_level').select2({
                dropdownParent: $('#add_report')
            });

            $('#editrep_report_status_level').select2({
                dropdownParent: $('#updteModal')
            });            

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.add_report', function() {
                $('#add_report').modal('show');

                // $('#saveBtn').click(function() {

                //     var rep_report_name = $('#rep_report_name').val();
                //     var rep_report_detail = $('#rep_report_detail').val();
                //     var rep_report_rep_userid = $('#rep_report_rep_userid').val();
                //     // alert(rep_report_name);
                //     $.ajax({
                //         url: "{{ route('ot.otone_updatecolor') }}",
                //         type: "POST",
                //         dataType: 'json',
                //         data: {
                //             rep_report_name,
                //             rep_report_detail
                //         },
                //         success: function(data) {
                //             if (data.status == 200) {
                //                 // alert('gggggg');
                //                 Swal.fire({
                //                     title: 'บันทึกข้อมูลสำเร็จ',
                //                     text: "You Insert data success",
                //                     icon: 'success',
                //                     showCancelButton: false,
                //                     confirmButtonColor: '#06D177',
                //                     confirmButtonText: 'เรียบร้อย'
                //                 }).then((result) => {
                //                     if (result
                //                         .isConfirmed) {
                //                         console.log(
                //                             data);

                //                         window.location
                //                             .reload();
                //                     }
                //                 })
                //             } else {

                //             }

                //         },
                //     });
                // });
            });           

            $(document).on('click', '.edit_data', function() {
                var rep_report_id = $(this).val();  
                $('#updteModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('request_report_edit') }}" + '/' + rep_report_id,
                    success: function(data) {
                        $('#editrep_report_name').val(data.rep.rep_report_name)
                        $('#editrep_report_detail').val(data.rep.rep_report_detail)
                        $('#editrep_report_status').val(data.rep.rep_report_status)
                        // $('#editot_one_detail').val(data.rep.ot_one_detail) 
                        $('#editrep_report_id').val(data.rep.rep_report_id)
                    },
                });
            });

            $('#updateBtn').click(function() {
                var rep_report_name = $('#editrep_report_name').val();
                var rep_report_detail = $('#editrep_report_detail').val(); 
                var rep_report_id = $('#editrep_report_id').val();
                var img = $('#editimg').val();
                // alert(img);
                $.ajax({
                    url: "{{ route('rep.request_report_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        rep_report_name,
                        rep_report_detail,
                        rep_report_id,
                        img
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
