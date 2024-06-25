@extends('layouts.user')
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
                <div class="card shadow">
                    <div class="card-header ">
                        แก้ไขข้อมูล Profile
                    </div>

                    <div class="card-body">
                        <form action="{{ route('user.profile_update') }}" method="POST" id="update_personForm"
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
                                                            <option value="{{ $pre->prefix_id }}" selected> {{ $pre->prefix_name }} </option>
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
                                                <input id="fname" type="text" class="form-control" name="fname" value="{{ $dataedits->fname }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="lname">นามสกุล :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="lname" type="text"
                                                    class="form-control @error('lname') is-invalid @enderror" name="lname"
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
                                                    class="form-control @error('username') is-invalid @enderror"
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
                                                    class="form-control @error('password') is-invalid @enderror"
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
                                                    class="form-control @error('cid') is-invalid @enderror" name="cid"
                                                    value="{{ $dataedits->cid }}">

                                                @error('cid')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
  
                                </div>
                                <div class="col-md-3">

                                    <div class="form-group">
                                        @if ($dataedits->img == null)
                                            <img src="{{ asset('assets/images/default-image.jpg') }}"
                                                id="edit_upload_preview" height="450px" width="350px" alt="Image"
                                                class="img-thumbnail">
                                        @else
                                            <img src="{{ asset('storage/person/' . $dataedits->img) }}"
                                                id="edit_upload_preview" height="450px" width="350px" alt="Image"
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
                    </div>

                    <div class="card-footer mt-3">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <a href="{{ url('person/person_index') }}" class="btn btn-danger">
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
        $(document).ready(function() {
            $('#dep').select2({
                placeholder: "กลุ่มงาน",
                allowClear: true
            });
            $('#depsub').select2({
                placeholder: "ฝ่าย/แผนก",
                allowClear: true
            });
            $('#depsubsub').select2({
                placeholder: "หน่วยงาน",
                allowClear: true
            });
            $('#depsubsubtrue').select2({
                placeholder: "หน่วยงานที่ปฎิบัติจริง",
                allowClear: true
            });
            $('#position').select2({
                placeholder: "ตำแหน่ง",
                allowClear: true
            });
            $('#statusA').select2({
                placeholder: "สถานะ",
                allowClear: true
            });
            $('#pname').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#users_group_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#users_type_id').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });




        });
    </script>

@endsection
