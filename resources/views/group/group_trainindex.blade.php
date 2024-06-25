@extends('layouts.usergroup')
@section('title','ZOffice || หัวหน้ากลุ่ม')
@section('content')
<script>
  function TypeAdmin() {
      window.location.href = '{{ route('index') }}';
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
  use App\Http\Controllers\UsersuppliesController;
        use App\Http\Controllers\StaticController;
        use App\Models\Products_request_sub;
    
        $refnumber = UsersuppliesController::refnumber();    
        $checkhn = StaticController::checkhn($iduser);
        $checkhnshow = StaticController::checkhnshow($iduser);
        $count_suprephn = StaticController::count_suprephn($iduser);
        $count_bookrep_rong = StaticController::count_bookrep_rong();
  ?>
@section('menu')
<style>
  body{
      font-size:14px;
  }
  .btn{
     font-size:15px;
   }
 
   .page{
        width: 90%;
        margin: 10px;
        box-shadow: 0px 0px 5px #000;
        animation: pageIn 1s ease;
        transition: all 1s ease, width 0.2s ease;
    }
    @keyframes pageIn{
    0%{
        transform: translateX(-300px);
        opacity: 0;
    }
    100%{
        transform: translateX(0px);
        opacity: 1;
    }
    }
   
 

</style>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">   
        <a href="{{url('group/group_bookindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หนังสือราชการ<span class="badge bg-danger ms-2">{{$count_bookrep_rong}}</span>&nbsp;&nbsp;&nbsp;</a>   
        <a href="{{url('group/group_leaveindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;การลา<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
        <a href="{{url('group/group_trainindex/'.Auth::user()->id)}}" class="btn btn-dark btn-sm text-white me-2 mt-2">ประชุม/อบรม/ดูงาน<span class="badge bg-danger ms-2">0</span></a> 
        <a href="{{url('group/group_purchaseindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;จัดซื้อจัดจ้าง<span class="badge bg-danger ms-2">{{$count_suprephn}}</span>&nbsp;</a> 
        <a href="{{url('group/group_storeindex/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;คลังวัสดุ<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;</a>  
        <div class="text-end"> 
        </div>
        </div>
    </div>
@endsection

<div class="container-fluid " style="width: 97%">
  <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="d-flex">
                    <div class="p-2">{{ __('ประชุม/อบรม/ดูงาน') }}
                    </div> 
                    <div class="ms-auto p-2">
                      <a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#saexampleModal">อนุมัติทั้งหมด</a> 
                    </div>
                </div>
                </div>

                <div class="card-body shadow-lg">
                    

                    {{ __('You are logged in!  USER_INDEX') }}

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saexampleModal">
                      เห็นชอบประชุม/อบรม/ดูงาน
                      </button>
                      
                      <!-- Modal -->
                      <div class="modal fade" id="saexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              ...
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary">Save changes</button>
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
