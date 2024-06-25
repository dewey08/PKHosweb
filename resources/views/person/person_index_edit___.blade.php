@extends('layouts.person') 

@section('title','ZOFFice || บุคลากร')
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
@section('menu')
<style>
    .btn{
       font-size:15px;
     }
  </style>
      <div class="px-3 py-2 border-bottom">
          <div class="container"> 
            <a href="{{url("person/person_index")}}" class="btn btn-info btn-sm text-white me-2">ข้อมูลบุคลากร</a>
            <a href="{{url("person/depsub_index")}}" class="btn btn-light btn-sm text-dark me-2">ประชุมภายนอก</a>
            <a href="{{url("person/depsubsub_index")}}" class="btn btn-light btn-sm text-dark me-2">ประชุมภายใน</a>          
          </div>
      </div>
@endsection
@section('content')  
    <div class="container-fluid" style="width: 97%">
    <div class="row ">
        <div class="col-md-10">
            <div class="card shadow">                                         
                <div class="card-body shadow">                    
                        <div class="table-responsive"> 
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">
                            <thead>
                              <tr>
                                 <th width="5%" class="text-center">ลำดับ</th>
                                 <th class="text-center" width="13%">ชื่อ-นามสกุล</th>
                                 <th class="text-center" width="17%">ตำแหน่ง</th>
                                 <th class="text-center" width="20%">กลุ่มงาน</th>
                                 <th class="text-center">ฝ่าย/แผนก</th>
                                 <th class="text-center">หน่วยงาน</th>
                                 <th width="10%" class="text-center">Manage</th>
                              </tr>  
                            </thead>
                            <tbody>
                              <?php $i = 1; 
         
                               $date =  date('Y');
                              
                              ?>      
                               @foreach ( $users as $mem ) 
                               <tr id="sid{{$mem->id}}">
                                   <td class="text-center" width="5%">{{$i++}}</td>  
                                   <td class="p-2" width="13%">{{$mem->fname}} {{$mem->lname}}</td>                          
                                   <td class="p-2" width="17%">{{$mem->position_name}}</td>
                                   <td class="p-2" width="20%">{{$mem->dep_name}}</td>
                                   <td class="p-2">{{$mem->dep_subname}}</td>
                                   <td class="p-2">{{$mem->dep_subsubname}}</td>                                  
                                   
                                  <!-- @if ($mem->type == 'ADMIN')
                                     <td class="font-weight-medium text-center"><div class="badge bg-danger">{{$mem->type}}</div></td>
                                   @elseif ($mem->type == 'STAFF')
                                     <td class="font-weight-medium text-center"><div class="badge bg-success">{{$mem->type}}</div></td>
                                     @elseif ($mem->type == 'CUSTOMER')
                                     <td class="font-weight-medium text-center"><div class="badge bg-info">{{$mem->type}}</div></td>
                                   @else
                                     <td class="font-weight-medium text-center"><div class="badge bg-warning">{{$mem->type}}</div></td>
                                   @endif -->

                                   <td class="text-center" width="10%">   
                                
                                     <a href="{{url('person/person_index_edit/'.$mem->id)}}" class="text-warning"
                                      data-bs-toggle="tooltip" data-bs-placement="bottom"
                                  data-bs-custom-class="custom-tooltip" 
                                  title="แก้ไข"  
                                      >
                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                     </a>      
                                     <!-- <button type="button" class="text-info edit_type" 
                                     data-bs-toggle="tooltip" data-bs-placement="bottom"
                                  data-bs-custom-class="custom-tooltip" 
                                  title="กำหนดสิทธิ์การเข้าถึง"  
                                     value="{{$mem->id}}">
                                      <i class="fa-solid fa-layer-group me-2"></i>
                                    </button> -->
                                      <a class="text-danger" href="javascript:void(0)" onclick="person_destroy({{$mem->id}})"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        data-bs-custom-class="custom-tooltip" 
                                        title="ลบ">
                                        <i class="fa-solid fa-trash-can me-2"></i>
                                     </a>

                                     <a href="{{url('person/person_index_addsub/'.$mem->id)}}" class="text-primary" 
                                      data-bs-toggle="tooltip" data-bs-placement="bottom"
                                      data-bs-custom-class="custom-tooltip" 
                                      title="เพิ่มข้อมูลรายละเอียดส่วนบุคคล"
                                      >
                                      <i class="fa-solid fa-person-circle-plus"></i>
                                   </a>
         
                                   </td>
                                 </tr> 
                                                                  
                                @endforeach
                                                
                            </tbody>
                          </table>

                       </div>         
                  
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow"> 
              <div class="card-header shadow-lg text-center">
                แก้ไขข้อมูลบุคลากร
            </div>

                <div class="card-body shadow">
                  <form action="{{route('person.person_update')}}" method="POST" id="update_personForm" enctype="multipart/form-data">                 
                    @csrf

                    <input id="id" type="hidden" class="form-control" name="id" value="{{ $dataedits->id}}" >

                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">ชื่อ</label> 
                            <input id="fname" type="text" class="form-control" name="fname" value="{{ $dataedits->fname}}" >

                            @error('fname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                  </div> 
                  <div class="row mt-1"> 
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">นามสกุล</label> 
                            <input id="lname" type="text" class="form-control" name="lname" value="{{ $dataedits->lname}}" >

                            @error('lname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                  </div>
              

                <div class="row mt-1">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="">ชื่อผู้ใช้งาน</label> 
                      <input id="username" type="text" class="form-control" name="username" value="{{ $dataedits->username}}">

                      @error('username')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                  </div>
                  </div>

                  <div class="row mt-1">
                    <div class="col-md-12">
                          <div class="form-group">
                            <label for="">รหัสผ่าน</label> 
                              <input id="password" type="password" class="form-control" name="password" value="{{ $dataedits->password}}">
  
                                  @error('password')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                          </div>
                    </div>
                    </div>


                  <div class="row mt-1">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="">กลุ่มงาน</label> 
                            <select id="dep" name="dep_id" class="form-control input-lg department" style="width: 100%">                      
                              <option value=""></option>
                                @foreach ($department as $depart )
                                @if ($dataedits->dep_id == $depart->DEPARTMENT_ID)
                                  <option value="{{ $depart->DEPARTMENT_ID}}" selected>{{ $depart->DEPARTMENT_NAME}}</option>
                                @else
                                  <option value="{{ $depart->DEPARTMENT_ID}}">{{ $depart->DEPARTMENT_NAME}}</option>
                                @endif                                  
                                @endforeach                             
                          </select>   
                          </div>
                      </div>                  
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="form-group">  
                          <label for="">ฝ่าย/แผนก</label>                       
                            <select id="depsub" name="dep_subid" class="form-control input-lg department_sub" style="width: 100%">                      
                              <option value=""></option>
                                @foreach ($department_sub as $departsub )
                                @if ($dataedits->dep_subid == $departsub->DEPARTMENT_SUB_ID)
                                    <option value="{{ $departsub->DEPARTMENT_SUB_ID}}" selected>{{ $departsub->DEPARTMENT_SUB_NAME}}</option>
                                @else
                                    <option value="{{ $departsub->DEPARTMENT_SUB_ID}}">{{ $departsub->DEPARTMENT_SUB_NAME}}</option>
                                @endif                                  
                                @endforeach                             
                          </select>                         
                        </div>
                    </div>                  
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">หน่วยงาน</label> 
                          <select id="depsubsub" name="dep_subsubid" class="form-control input-lg department_sub_sub" style="width: 100%">                      
                            <option value=""></option>
                              @foreach ($department_sub_sub as $departsubsub )
                              @if ($dataedits->dep_subsubid == $departsubsub->DEPARTMENT_SUB_SUB_ID)
                                  <option value="{{ $departsubsub->DEPARTMENT_SUB_SUB_ID}}" selected>{{ $departsubsub->DEPARTMENT_SUB_SUB_NAME}}</option>
                              @else
                                  <option value="{{ $departsubsub->DEPARTMENT_SUB_SUB_ID}}">{{ $departsubsub->DEPARTMENT_SUB_SUB_NAME}}</option>
                              @endif                                
                              @endforeach                             
                        </select> 
                        </div>
                    </div>                  
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">หน่วยงานที่ปฎิบัติจริง</label> 
                          <select id="depsubsubtrue" name="dep_subsubtrueid" style="width: 100%">                      
                            <option value=""></option>
                              @foreach ($department_sub_sub as $departsubsubtrue )
                              @if ($dataedits->dep_subsubtrueid == $departsubsubtrue->DEPARTMENT_SUB_SUB_ID)
                                  <option value="{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_ID}}" selected>{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_NAME}}</option>
                              @else
                                  <option value="{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_ID}}">{{ $departsubsubtrue->DEPARTMENT_SUB_SUB_NAME}}</option>
                              @endif                                
                              @endforeach                             
                        </select> 
                        </div>
                    </div>                  
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">ตำแหน่ง</label> 
                          <select id="position" name="position_id" style="width: 100%">                      
                            <option value=""></option>
                              @foreach ($position as $item )
                              @if ($dataedits->position_id == $item->POSITION_ID)
                              <option value="{{ $item->POSITION_ID}}" selected>{{ $item->POSITION_NAME}}</option>
                              @else
                              <option value="{{ $item->POSITION_ID}}">{{ $item->POSITION_NAME}}</option>
                              @endif                                
                              @endforeach                             
                        </select> 
                        </div>
                    </div>                  
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">วันที่บรรจุ</label> 
                          <input id="start_date" type="date" class="form-control datepicker" name="start_date"value="{{ $dataedits->start_date}}">

                          @error('start_date')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>                       

                    </div>                  
                  </div>
                    <div class="row mt-1">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="">สถานะ</label> 
                            <select id="status" name="status" style="width: 100%">                      
                              <option value=""></option>
                                @foreach ($status as $st )
                                @if ($dataedits->status == $st->STATUS_ID)
                                  <option value="{{ $st->STATUS_ID}}" selected>{{ $st->STATUS_NAME}}</option>
                                @else
                                  <option value="{{ $st->STATUS_ID}}">{{ $st->STATUS_NAME}}</option>
                                @endif
                                  
                                @endforeach                             
                          </select> 
                          </div>
                      </div>                  
                  </div>

                    
                <div class="form-group mt-3">             
                    <button type="submit" class="btn btn-primary " >
                        <i class="fa-solid fa-floppy-disk me-3"></i>แก้ไขข้อมูล
                    </button>                    
                </div>

                  </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Edit  Modal update_type -->
<div class="modal fade" id="editexampleModal" tabindex="-1" aria-labelledby="editexampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editexampleModalLabel">กำหนดการสิทธิ์เข้าถึง</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">        
        <form method="POST" id="update_type">  
          @csrf
          @method('PUT')
          <input type="hidden" class="form-control" id="edittype_id" name="edittype_id" />
        
    
            <div class="col-md-12">
              <div class="form-group">              
              {{-- <input type="text" class="form-control" id="edittype_name" name="type" placeholder=""> --}}
              <select class="form-control" id="edittype_name" name="type" style="width: 100%">                      
                {{-- <option value=""></option> --}}
                <option value="STAFF">STAFF</option>
                <option value="ADMIN">ADMIN</option>
                <option value="CUSTOMER">CUSTOMER</option>
                <option value="MANAGE">MANAGE</option>   
                <option value="USER">USER</option> 
                <option value="NOTUSER">NOTUSER</option>         
            </select> 
              </div>
          </div>       
   
                    
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-outline-success rounded-pill">
          <i class="ri-save-3-fill me-1"></i>                                                    
          Save
        </button>
        <button type="button" class="btn btn-outline-danger rounded-pill" data-bs-dismiss="modal">
          <i class="ri-shut-down-line me-1"></i>                                                   
          Cancel
        </button>
       
      </div>
    </form>
    </div>
  </div>
</div>
<script src="{{ asset('js/person.js') }}"></script>


@endsection
