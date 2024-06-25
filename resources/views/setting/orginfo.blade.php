@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || องค์กร')
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
            reader.onload = function (e) {
                $('#edit_upload_preview').attr('src', e.target.result);
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

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">   
            <div class="card">                  
                <div class="card-body shadow-lg">
                    <form action="{{route('setting.orginfo_update')}}" method="POST" id="update_infoorgForm" enctype="multipart/form-data">                 
                        @csrf        
                        <input id="orginfo_id" type="hidden" class="form-control" name="orginfo_id" value="{{ $orginfo->orginfo_id}}" >

                    <div class="row">
                        <div class="col-md-3"> 
                            <div class="form-group"> 
                                @if ( $orginfo->orginfo_img == Null )
                                <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="550px" width="350px" alt="Image" class="img-thumbnail">
                                @else
                                <img src="{{asset('storage/org/'.$orginfo->orginfo_img)}}" id="edit_upload_preview" height="550px" width="350px" alt="Image" class="img-thumbnail">                                 
                                @endif
                                <br>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="img"></label>
                                    <input type="file" class="form-control" id="orginfo_img" name="orginfo_img"
                                        onchange="editpic(this)">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9"> 
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_name">ชื่อโรงพยาบาล :</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <input id="orginfo_name" type="text"
                                            class="form-control" name="orginfo_name" value="{{ $orginfo->orginfo_name}}" >
                                    </div>
                                </div> 
                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_code">รหัสโรงพยาบาล :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="orginfo_code" type="text"
                                            class="form-control" name="orginfo_code"  value="{{ $orginfo->orginfo_code}}">
                                    </div>
                                </div> 
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_address">ที่อยู่ :</label>
                                </div>
                                <div class="col-md-10"> 
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="orginfo_address" name="orginfo_address">{{ $orginfo->orginfo_address}}</textarea>
                                      <!-- <label for="orginfo_address">ที่อยู่</label> -->
                                      </div>
                                </div>                                
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_email">อีเมล์ :</label>
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <input id="orginfo_email" type="text"
                                        class="form-control" name="orginfo_email"  value="{{ $orginfo->orginfo_email}}">
                                      </div>
                                </div>        
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_tel">Tel :</label>
                                </div>
                                <div class="col-md-2"> 
                                    <div class="form-group">
                                        <input id="orginfo_tel" type="text"
                                        class="form-control" name="orginfo_tel"  value="{{ $orginfo->orginfo_tel}}">
                                      </div>
                                </div>                        
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_link">Link :</label>
                                </div>
                                <div class="col-md-10"> 
                                    <div class="form-group">
                                        <input id="orginfo_link" type="text"
                                        class="form-control" name="orginfo_link"  value="{{ $orginfo->orginfo_link}}">
                                      </div>
                                </div>                                
                            </div>
                            <div class="row mt-3">                                
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_manage_id">หัวหน้าบริหาร :</label>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">                                        
                                        <select id="orginfo_manage_id" name="orginfo_manage_id" class="form-control form-control-lg" style="width: 100%">
                                            <option value=""></option>
                                                @foreach ($users as $item1 )  
                                                @if ($orginfo->orginfo_manage_id == $item1->id)
                                                <option value="{{ $item1->id}}" selected>{{ $item1->fname}}  {{ $item1->lname}}</option> 
                                                @else
                                                <option value="{{ $item1->id}}">{{ $item1->fname}}  {{ $item1->lname}}</option> 
                                                @endif                                      
                                                                                                                      
                                                @endforeach 
                                        </select>
                                      </div>
                                </div> 
                                <div class="col-md-2 text-end">
                                    <label for="orginfo_po_id">ผู้อำนวยการ :</label>
                                </div>
                                <div class="col-md-4"> 
                                    <div class="form-group">                                        
                                        <select id="orginfo_po_id" name="orginfo_po_id" class="form-control form-control-lg" style="width: 100%">
                                            <option value=""></option>
                                                @foreach ($users as $item2 ) 
                                                @if ($orginfo->orginfo_po_id == $item2->id)
                                                <option value="{{ $item2->id}}" selected>{{ $item2->fname}}  {{ $item2->lname}}</option>    
                                                @else
                                                <option value="{{ $item2->id}}">{{ $item2->fname}}  {{ $item2->lname}}</option>    
                                                @endif                                       
                                                                                                                   
                                                @endforeach 
                                        </select>
                                      </div>
                                </div> 
                            </div>
                            <div class="card-footer mt-3">
                                <div class="col-md-12 mt-3 text-end"> 
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            บันทึกข้อมูล
                                        </button>   
                                    </div>                   
                                </div>   
                            </div>
                           

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>  
    </div>   
</div>



@endsection
