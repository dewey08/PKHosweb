@extends('layouts.user')
@section('title','ZOffice || ข้อมูลการลา')
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
        
        <a href="{{url('user/gleave_data_add/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;เพิ่มข้อมูลการลา<span class="badge bg-danger ms-2">{{$count_suprephn}}</span>&nbsp;</a> 
        <a href="{{url('user/gleave_data/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">&nbsp;&nbsp;ข้อมูลการลา<span class="badge bg-danger ms-2">0</span>&nbsp;&nbsp;</a> 
        <div class="text-end"> 
        </div>
        </div>
    </div>
@endsection

<div class="container-fluid " style="width: 97%">
  <div class="row"> 
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header"> 
                  <div class="d-flex">
                    <div class="p-2">{{ __('ข้อมูลการลา') }}
                    </div> 
                    <div class="ms-auto p-2">
                      {{-- <a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#saexampleModal">อนุมัติทั้งหมด</a>  --}}
                    </div>
                </div>
                </div>

                <div class="card-body shadow-lg">
                     

                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">
                        <thead>
                          <tr height="10px">
                             <th width="7%">ลำดับ</th>
                             <th>ชื่อ-นามสกุล</th>
                             <th>ตำแหน่ง</th>
                             <th>หน่วยงาน</th>
                             <th>username</th>
                             <th width="10%">สถานะ</th>
                             <th width="10%">จัดการ</th>
                          </tr>  
                        </thead>
                        <tbody>
                          <?php $i = 1; 
     
                           $date =  date('Y');
                          
                          ?>      
                           @foreach ( $users as $mem ) 
                           <tr id="sid{{$mem->id}}">
                               <td>{{$i++}}</td>  
                               <td>  {{$mem->fname}} {{$mem->lname}}</td>                          
                               <td class="font-weight-bold">{{$mem->position_name}}</td>
                               <td>{{$mem->dep_subsubname}}</td>
                               <td>{{$mem->username}}</td>
                               
                               @if ($mem->type == 'ADMIN')
                                 <td class="font-weight-medium"><div class="badge bg-danger">{{$mem->type}}</div></td>
                               @elseif ($mem->type == 'STAFF')
                                 <td class="font-weight-medium"><div class="badge bg-success">{{$mem->type}}</div></td>
                                 @elseif ($mem->type == 'CUSTOMER')
                                 <td class="font-weight-medium"><div class="badge bg-info">{{$mem->type}}</div></td>
                               @else
                                 <td class="font-weight-medium"><div class="badge bg-warning">{{$mem->type}}</div></td>
                               @endif
                               <td>   
                            
                                <a href="{{url('person/person_index_edit/'.$mem->id)}}" class="btn rounded-pill text-warning"
                                  data-bs-toggle="tooltip" data-bs-placement="bottom"
                              data-bs-custom-class="custom-tooltip" 
                              title="แก้ไข"
                                   value="{{$mem->id}}">
                                  <i class="fa-solid fa-pen-to-square"></i>
                               </a>  
                              {{-- <button type="button" class="btn btn-secondary rounded-pill edit_type" 
                              data-bs-toggle="tooltip" data-bs-placement="bottom"
                              data-bs-custom-class="custom-tooltip" 
                              title="กำหนดสิทธิ์การเข้าถึง"                                  
                              value="{{$mem->id}}">
                                <i class="fa-solid fa-layer-group"></i>
                              </button>                                  --}}
                                  <a class="btn rounded-pill text-danger" href="javascript:void(0)" onclick="person_destroy({{$mem->id}})"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    data-bs-custom-class="custom-tooltip" 
                                    title="ลบ"
                                    >
                                    <i class="fa-solid fa-trash-can"></i>
                                 </a>

                                 {{-- <a href="{{url('person/person_index_addsub/'.$mem->id)}}" class="btn btn-primary rounded-pill" 
                                  data-bs-toggle="tooltip" data-bs-placement="bottom"
                              data-bs-custom-class="custom-tooltip" 
                              title="เพิ่มข้อมูลรายละเอียดส่วนบุคคล"
                                  >
                                  <i class="fa-solid fa-person-circle-plus"></i>
                               </a> --}}
                               
                               </td>
                             </tr> 
                           
                                                              
                            @endforeach
                                            
                        </tbody>
                      </table>

                      <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">                              
                              {{$users->links()}}                            
                          </ul>
                      </nav>

                    </div> 

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
