@extends('layouts.meetting')
@section('title', 'PK-OFFICER || ห้องประชุม')

 
    <?php
        use App\Http\Controllers\StaticController;
        use Illuminate\Support\Facades\DB;   
        $count_meettingroom = StaticController::count_meettingroom();
    ?>
    {{-- <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
           
            <a href="{{ url('meetting/meettingroom_dashboard') }}" class="btn btn-light btn-sm text-dark me-2">dashboard </a>
            <a href="{{ url('meetting/meettingroom_index') }}" class="btn btn-light btn-sm text-dark me-2">รายการห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('meetting/meettingroom_check') }}" class="btn btn-light btn-sm text-dark me-2">ตรวจสอบการจองห้องประชุม <span class="badge bg-danger ms-2">{{$count_meettingroom}}</span></a>
            <a href="{{ url('meetting/meettingroom_report') }}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รายงาน</a>
            <div class="text-end">
                <a href="" class="btn btn-success btn-sm text-white me-2">แก้ไขรายการห้องประชุม </a>
               
            </div>
        </div>
    </div>
@endsection --}}

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function editroom(input) {
  var fileInput = document.getElementById('room_img');
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
   
    <div class="container-fluid">
        <div class="row"> 
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h6>แก้ไขห้องประชุม</h6>
                    </div>
                    <div class="card-body shadow-lg">
                        <form action="{{ route('meetting.meettingroom_index_save') }}" method="POST" id="insert_roomForm" enctype="multipart/form-data">
                            @csrf
                            

                        <div class="row">                          

                            <div class="col-md-4">
                                <div class="form-group">                               
                                  @if ( $dataedits->room_img == Null )
                                    <img src="{{asset('assets/images/default-image.jpg')}}" id="edit_upload_preview" height="450px" width="350px" alt="Image" class="img-thumbnail">
                                    @else
                                    <img src="{{asset('storage/meetting/'.$dataedits->room_img)}}" id="edit_upload_preview" height="450px" width="350px" alt="Image" class="img-thumbnail">                                 
                                    @endif
                                    <br>
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="room_img"></label>
                                        <input type="file" class="form-control" id="room_img" name="room_img"
                                            onchange="editroom(this)">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-8"> 

                              
                                <input type="hidden" id="room_id" name="room_id" class="form-control" value="{{$dataedits->room_id}}"/> 
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                                <div class="row">
                                    <div class="col-md-2 text-end"> 
                                        <label for="room_name">ชื่อห้องประชุม :</label>
                                    </div>
                                    <div class="col-md-5"> 
                                        <div class="form-group">
                                            <input id="room_name" type="text" class="form-control" name="room_name" value="{{$dataedits->room_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end"> 
                                        <label for="room_amount">ความจุ (คน) :</label>
                                    </div>
                                    <div class="col-md-3"> 
                                        <div class="form-group">
                                            <input id="room_amount" type="text" class="form-control"
                                                name="room_amount" value="{{$dataedits->room_amount}}">
                                        </div>
                                    </div>
                                </div>                               

                                <div class="row mt-3">
                                    <div class="col-md-2 text-end"> 
                                        <label for="room_user_id">ผู้รับผิดชอบ :</label>
                                    </div>
                                    <div class="col-md-5 text-center"> 
                                        <div class="form-group"> 
                                                <select id="room_user_id" name="room_user_id" style="width: 100%">                      
                                                    <option value=""></option>
                                                      @foreach ($users as $item )
                                                      @if ($dataedits->room_user_id == $item->id)
                                                      <option value="{{ $item->id}}" selected>{{ $item->fname}} {{ $item->lname}}</option>
                                                      @else
                                                      <option value="{{ $item->id}}">{{ $item->fname}} {{ $item->lname}}</option>
                                                      @endif
                                                        
                                                      @endforeach                             
                                                </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end"> 
                                        <label for="room_status">สถานะ :</label>
                                    </div>
                                    <div class="col-md-3 text-center"> 
                                        <div class="form-group"> 
                                                <select id="room_status" name="room_status" style="width: 100%">                      
                                                    <option value=""></option>
                                                    @foreach ($building_room_status as $itemsta )
                                                    @if ($dataedits->room_status == $itemsta->room_status_id)
                                                    <option value="{{ $itemsta->room_status_id}}" selected>{{ $itemsta->room_status_name}}</option>
                                                    @else
                                                    <option value="{{ $itemsta->room_status_id}}">{{ $itemsta->room_status_name}}</option>
                                                    @endif
                                                    
                                                  @endforeach                
                                                </select> 
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3"> 
                                    <div class="col-md-4"> 
                                       
                                    </div>
                                    <div class="col-md-5 text-center"> 
                                        <div class="form-group">
                                            <label style="color:red">สีห้อง *ควรเลือกสีให้เหมาะกับตัวอักษรสีขาว</label> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-center"> 
                                        <div class="form-group">
                                            <input name="room_color" type="color" id="room_color" class="form-control input-lg" value="{{$dataedits->room_color}}">
                                        </div>
                                    </div>
                                </div>

                            </div>                                               
                        </div> 
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end"> 
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    แก้ไขข้อมูล
                                </button> 
                                <a href="{{ url('meetting/meettingroom_index') }}"
                                    class="btn btn-danger btn-sm">
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
