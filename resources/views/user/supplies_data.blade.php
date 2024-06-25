@extends('layouts.user')
@section('title','ZOffice || พัสดุ')
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
  ?>
<div class="container-fluid">
  <div class="px-0 py-0 border-bottom mb-2">
    <div class="d-flex flex-wrap justify-content-center"> 
      <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>
    
      <div class="text-end">
        <a href="{{url('user/gleave_data_dashboard')}}" class="btn btn-light text-dark me-2">dashboard</a>
        <a href="{{url('user/supplies_data')}}" class="btn btn-primary text-white me-2">ขอจัดซื้อ-จัดจ้าง</a>
        {{-- <a href="{{url('user/gleave_data')}}" class="btn btn-primary text-white me-2">ข้อมูลการลา</a> --}}
        {{-- <a type="button" class="btn btn-danger">ตั้งค่าข้อมูล</a> --}}
      </div>
    </div>
  </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                  <div class="row">
                    <div class="col">
                     
                      <a href="" class="btn btn-light"> {{ __('ข้อมูลจัดซื้อ-จัดจ้าง') }}</a>
                    </div>
                    <div class="col-9">
                   
                    </div>
                    <div class="col">
                      <a href="{{ url('user/supplies_data_add/'.Auth::user()->id )}}" class="btn btn-primary"><i class="fa-solid fa-folder-plus me-2"></i> เพิ่มข้อมูล</a>
                    </div>
                  </div>
                 
                 
                </div>           
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="table_id"> 
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
                            
                                {{-- <a href="{{url('person/person_index_edit/'.$mem->id)}}" class="btn rounded-pill text-warning"
                                  data-bs-toggle="tooltip" data-bs-placement="bottom"
                              data-bs-custom-class="custom-tooltip" 
                              title="แก้ไข"
                                   value="{{$mem->id}}">
                                  <i class="fa-solid fa-pen-to-square"></i>
                               </a>  
                             
                                  <a class="btn rounded-pill text-danger" href="javascript:void(0)" onclick="person_destroy({{$mem->id}})"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    data-bs-custom-class="custom-tooltip" 
                                    title="ลบ"
                                    >
                                    <i class="fa-solid fa-trash-can"></i>
                                 </a> --}}
                                 <a href="{{url('person/person_index_edit/'.$mem->id)}}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </a>                                                                 
                                <a class="text-danger" href="javascript:void(0)" onclick="person_destroy({{$mem->id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="ลบ">
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
