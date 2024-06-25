@extends('layouts.person')

@section('title', 'PK-OFFICER || บุคลากร')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
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


@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <label for="">แก้ไขข้อมูลบุคลากร</label> 
                        
                    </div>

                    <div class="card-body shadow">
                        <form action="{{ route('person.person_update') }}" method="POST" id="update_personForm"
                            enctype="multipart/form-data">
                            @csrf
                            <input id="id" type="hidden" class="form-control" name="id"
                                value="{{ $dataedits->id }}">

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-2 text-end">
                                            <label for="pname">คำนำหน้า :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="pname" name="pname" class="form-select form-select-lg"
                                                    style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($users_prefix as $pre)
                                                        @if ($dataedits->pname == $pre->prefix_id)
                                                            <option value="{{ $pre->prefix_id }}" selected>
                                                                {{ $pre->prefix_name }} </option>
                                                        @else
                                                            <option value="{{ $pre->prefix_id }}">{{ $pre->prefix_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="fname">ชื่อ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="fname" type="text" class="form-control form-control-sm" name="fname"
                                                    value="{{ $dataedits->fname }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="lname">นามสกุล :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="lname" type="text"
                                                    class="form-control form-control-sm @error('lname') is-invalid @enderror" name="lname"
                                                    value="{{ $dataedits->lname }}">

                                                @error('lname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="username">ชื่อผู้ใช้งาน :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="username" type="text"
                                                    class="form-control form-control-sm @error('username') is-invalid @enderror"
                                                    name="username" value="{{ $dataedits->username }}">

                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="password">รหัสผ่าน :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="password" type="password"
                                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                    name="password" required>


                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="cid">เลขบัตรประชาชน :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="cid" type="text"
                                                    class="form-control form-control-sm @error('cid') is-invalid @enderror" name="cid"
                                                    value="{{ $dataedits->cid }}">

                                                @error('cid')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="dep_id">กลุ่มงาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="dep" name="dep_id"
                                                    class="form-control form-control-lg department" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($department as $depart)
                                                        @if ($dataedits->dep_id == $depart->DEPARTMENT_ID)
                                                            <option value="{{ $depart->DEPARTMENT_ID }}" selected>
                                                                {{ $depart->DEPARTMENT_NAME }}</option>
                                                        @else
                                                            <option value="{{ $depart->DEPARTMENT_ID }}">
                                                                {{ $depart->DEPARTMENT_NAME }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="password">ฝ่าย/แผนก :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="depsub" name="dep_subid"
                                                    class="form-control form-control-lg department_sub"
                                                    style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($department_sub as $departsub)
                                                        @if ($dataedits->dep_subid == $departsub->DEPARTMENT_SUB_ID)
                                                            <option value="{{ $departsub->DEPARTMENT_SUB_ID }}" selected>
                                                                {{ $departsub->DEPARTMENT_SUB_NAME }}</option>
                                                        @else
                                                            <option value="{{ $departsub->DEPARTMENT_SUB_ID }}">
                                                                {{ $departsub->DEPARTMENT_SUB_NAME }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="cid">หน่วยงาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="depsubsub" name="dep_subsubid"
                                                    class="form-control form-control-lg department_sub_sub"
                                                    style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($department_sub_sub as $departsubsub)
                                                        @if ($dataedits->dep_subsubid == $departsubsub->DEPARTMENT_SUB_SUB_ID)
                                                            <option value="{{ $departsubsub->DEPARTMENT_SUB_SUB_ID }}"
                                                                selected>{{ $departsubsub->DEPARTMENT_SUB_SUB_NAME }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $departsubsub->DEPARTMENT_SUB_SUB_ID }}">
                                                                {{ $departsubsub->DEPARTMENT_SUB_SUB_NAME }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="cid">หน่วยงานจริง :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="depsubsubtrue" name="dep_subsubtrueid"
                                                    class="form-control form-control-lg" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($department_sub_sub as $departsubsubtrue)
                                                        @if ($dataedits->dep_subsubtrueid == $departsubsubtrue->DEPARTMENT_SUB_SUB_ID)
                                                            <option value="{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_ID }}"
                                                                selected>{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_NAME }}
                                                            </option>
                                                        @else
                                                            <option
                                                                value="{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_ID }}">
                                                                {{ $departsubsubtrue->DEPARTMENT_SUB_SUB_NAME }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="position_id">ตำแหน่ง :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="position" name="position_id" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($position as $item)
                                                        @if ($dataedits->position_id == $item->POSITION_ID)
                                                            <option value="{{ $item->POSITION_ID }}" selected>
                                                                {{ $item->POSITION_NAME }}</option>
                                                        @else
                                                            <option value="{{ $item->POSITION_ID }}">
                                                                {{ $item->POSITION_NAME }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="start_date">วันที่บรรจุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="start_date" type="date" class="form-control form-control-sm datepicker"
                                                    name="start_date" value="{{ $dataedits->start_date }}">
                                                @error('start_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="status">สถานะทำงาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="statusA" name="status" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($status as $st)
                                                        @if ($dataedits->status == $st->STATUS_ID)
                                                            <option value="{{ $st->STATUS_ID }}" selected>
                                                                {{ $st->STATUS_NAME }}</option>
                                                        @else
                                                            <option value="{{ $st->STATUS_ID }}">{{ $st->STATUS_NAME }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="end_date">วันที่ลาออก :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="end_date" type="date" class="form-control form-control-sm datepicker"
                                                    name="end_date" value="{{ $dataedits->end_date }}">
                                                @error('start_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="users_group_id">กลุ่มบุคลากร :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="users_group_id" name="users_group_id" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($users_group as $stu)
                                                        @if ($dataedits->users_group_id == $stu->users_group_id)
                                                            <option value="{{ $stu->users_group_id }}" selected>
                                                                {{ $stu->users_group_name }}</option>
                                                        @else
                                                            <option value="{{ $stu->users_group_id }}">
                                                                {{ $stu->users_group_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="users_type_id">ประเภทข้าราชการ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="users_type_id" name="users_type_id" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($users_kind_type as $st)
                                                        @if ($dataedits->users_type_id == $st->users_kind_type_id)
                                                            <option value="{{ $st->users_kind_type_id }}" selected>
                                                                {{ $st->users_kind_type_name }}</option>
                                                        @else
                                                            <option value="{{ $st->users_kind_type_id }}">
                                                                {{ $st->users_kind_type_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">


                                    <div class="form-group">
                                        @if ($dataedits->img == null)
                                            <img src="{{ asset('assets/images/default-image.jpg') }}"
                                                id="edit_upload_preview" height="300px" width="300px" alt="Image"
                                                class="img-thumbnail">
                                        @else
                                            <img src="{{ asset('storage/person/' . $dataedits->img) }}"
                                                id="edit_upload_preview" height="300px" width="300px" alt="Image"
                                                class="img-thumbnail">
                                        @endif
                                        <br>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="img"></label>
                                            <input type="file" class="form-control" id="img" name="img"
                                                onchange="editpic(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="card-footer mt-3">
                                <div class="col-md-12 mt-3 text-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-floppy-disk me-2"></i>
                                            บันทึกข้อมูล
                                        </button>
                                        <a href="{{ url('person/person_index') }}" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-xmark me-2"></i>
                                            ยกเลิก
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footer')
     <script>
         $(document).ready(function(){
              $('#update_personForm').on('submit',function(e){
                e.preventDefault();
              //   alert('Person');
                var form = this;
              
                $.ajax({
                  url:$(form).attr('action'),
                  method:$(form).attr('method'),
                  data:new FormData(form),
                  processData:false,
                  dataType:'json',
                  contentType:false,
                  beforeSend:function(){
                    $(form).find('span.error-text').text('');
                  },
                  success:function(data){
                    if (data.status == 0 ) {  
                      Swal.fire({
                        icon: 'error',
                        title: 'Username...!!',
                        text: 'Username นี้ได้ถูกใช้ไปแล้ว!',
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                        
                        }
                      })   
                    } else {                         
                      Swal.fire({
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: "You Edit data success",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177', 
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {                  
                          window.location="{{route('person.person_index')}}"; //
                        }
                      })      
                    }
                  }
                });
            }); 
        });
     </script>
     
    @endsection
 
