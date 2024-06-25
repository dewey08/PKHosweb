@extends('layouts.person')

@section('title', 'ZOFFice || บุคลากร')
@section('content')  
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }

    function addpre() {
            var prenew = document.getElementById("PRE_INSERT").value;
            // alert(prenew);
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('person/addpre')}}",                
                method: "GET",
                data: {
                  prenew: prenew,
                    _token: _token
                },
                success: function (result) {
                    $('.show_pre').html(result);
                }
            })
    }

    function addpic(input) {
      var fileInput = document.getElementById('img');
      var url = input.value;
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
          if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
              var reader = new FileReader();    
              reader.onload = function (e) {
                  $('#add_upload_preview').attr('src', e.target.result);
              }    
              reader.readAsDataURL(input.files[0]);
          }else{    
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


    <div class="container-fluid">
        <div class="row ">            
            <div class="col-md-12">
                <div class="card"> 
                    <div class="card-header ">
                        เพิ่มข้อมูลบุคลากร
                    </div>

                    <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('person.person_save') }}" method="POST" id="insert_personForm" enctype="multipart/form-data">                       
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">                                
                                        <div class="col-md-1 ">
                                            <label for="pname">คำนำหน้า :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="pname" name="pname" class="form-select form-select-lg show_pre" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($users_prefix as $pre)
                                                        <option value="{{ $pre->prefix_id }}">{{ $pre->prefix_name }} </option>
                                                    @endforeach
                                                </select>
                                              
                                            </div>
                                        </div> 
                                       
                                        <div class="col-md-2"> 
                                            <div class="form-outline bga">
                                                <input type="text" id="PRE_INSERT" name="PRE_INSERT" class="form-control shadow"/> 
                                                {{-- <label class="form-label" for="PRE_INSERT" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่มตรงนี้ </label> --}}
                                            </div> 
                                        </div>
                                        <div class="col-md-1"> 
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addpre();">
                                                    เพิ่ม 
                                                </button> 
                                            </div>
                                        </div> 
                                        <div class="col-md-1 ">
                                            <label for="fname">ชื่อ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="fname" type="text" class="form-control" name="fname" required>
                                               
                                            </div>
                                        </div> 
                                        <div class="col-md-1 ">
                                            <label for="lname">นามสกุล :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="lname" type="text"
                                                    class="form-control @error('lname') is-invalid @enderror" name="lname"
                                                    value="{{ old('lname') }}" autocomplete="lname"  >
        
                                                @error('lname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>                         
                                    </div>

                                    <div class="row mt-3">                                
                                        <div class="col-md-1 ">
                                            <label for="username">ชื่อผู้ใช้งาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <input id="username" type="text" class="form-control" name="username" required >
                                            </div>
                                        </div> 
                                        <div class="col-md-2 ">
                                            <label for="password">รหัสผ่าน :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="password" type="password" class="form-control" name="password" required >
          
                                            </div>
                                        </div> 
                                        <div class="col-md-1">
                                            <label for="cid">บัตรประชาชน </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="cid" type="text" class="form-control" name="cid">
          
                                            </div>
                                        </div> 
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10"> 
                                                                      
                                    <div class="row mt-3">                                
                                        <div class="col-md-2">
                                            <label for="username">กลุ่มงาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <select id="dep" name="dep_id"
                                                class="form-control department" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($department as $depart)
                                                    <option value="{{ $depart->DEPARTMENT_ID }}">
                                                        {{ $depart->DEPARTMENT_NAME }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="password">ฝ่าย/แผนก :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="depsub" name="dep_subid"
                                                    class="form-control department_sub" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($department_sub as $departsub)
                                                        <option value="{{ $departsub->DEPARTMENT_SUB_ID }}">
                                                            {{ $departsub->DEPARTMENT_SUB_NAME }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="row mt-3"> 
                                        <div class="col-md-2">
                                            <label for="cid">หน่วยงาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="depsubsub" name="dep_subsubid"
                                                class="form-control department_sub_sub" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($department_sub_sub as $departsubsub)
                                                    <option value="{{ $departsubsub->DEPARTMENT_SUB_SUB_ID }}">
                                                        {{ $departsubsub->DEPARTMENT_SUB_SUB_NAME }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="cid">หน่วยงานจริง :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="depsubsubtrue" name="dep_subsubtrueid"
                                                    class="form-control" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($department_sub_sub as $departsubsubtrue)
                                                        <option value="{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_ID }}">
                                                            {{ $departsubsubtrue->DEPARTMENT_SUB_SUB_NAME }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        

                                    </div>


                                    <div class="row mt-3">                                
                                        <div class="col-md-2 ">
                                            <label for="position_id">ตำแหน่ง :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <select id="position" name="position_id" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($position as $item)
                                                        <option value="{{ $item->POSITION_ID }}">{{ $item->POSITION_NAME }}
                                                        </option>
                                                    @endforeach
                                                </select>                                                
                                            </div>
                                        </div> 
                                        <div class="col-md-2 ">
                                            <label for="start_date">วันที่บรรจุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="start_date" type="date" class="form-control datepicker" name="start_date" >
                                                @error('start_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror                                                
                                            </div>
                                        </div>  
                                    </div>
    
                                    <div class="row mt-3">                                
                                        <div class="col-md-2 ">
                                            <label for="status">สถานะทำงาน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <select id="status" name="status" class="form-control" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($status as $st)
                                                        <option value="{{ $st->STATUS_ID }}">{{ $st->STATUS_NAME }}</option>
                                                    @endforeach
                                                </select>                                              
                                            </div>
                                        </div> 
                                        <div class="col-md-2 ">
                                            <label for="end_date">วันที่ลาออก :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="end_date" type="date" class="form-control datepicker" name="end_date" >
                                                                                          
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="row mt-3">                                
                                        <div class="col-md-2 ">
                                            <label for="users_group_id">กลุ่มบุคลากร :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"> 
                                                <select id="users_group_id" name="users_group_id" class="form-control" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($users_group as $stu)
                                                        <option value="{{ $stu->users_group_id }}">{{ $stu->users_group_name }}</option>
                                                    @endforeach
                                                </select>                                              
                                            </div>
                                        </div> 
                                        <div class="col-md-2">
                                            <label for="users_type_id">ประเภทข้าราชการ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="users_type_id" name="users_type_id" class="form-control" style="width: 100%">
                                                    <option value=""></option>
                                                    @foreach ($users_kind_type as $st)
                                                        <option value="{{ $st->users_kind_type_id }}">{{ $st->users_kind_type_name }}</option>
                                                    @endforeach
                                                </select>                                                
                                            </div>
                                        </div>  
                                    </div>
    
                                </div>
                                <div class="col-md-2 mt-3">
                                    <div class="form-group">
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                        alt="Image" class="img-thumbnail" width="220px" height="400px">
                                        <br>
                                        <div class="input-group mb-3 mt-3">
                               
                                            <input type="file" class="form-control" id="img" name="img"
                                                onchange="addpic(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                 </div>

                            </div>


                            <div class="card-footer mt-3">
                                <div class="col-md-12 mt-3 text-end"> 
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            บันทึกข้อมูล
                                        </button> 
                                        <a href="{{url('person/person_index')}}" class="btn btn-danger btn-sm">
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
