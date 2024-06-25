@extends('layouts.setting')
@section('title', 'ZOFFice || ฝ่าย/แผนก')

@section('menu')
<style>
  .btn{
     font-size:15px;
   }
</style>
    <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center"> 
        <a href="{{url("setting/setting_index")}}" class="btn btn-light btn-sm text-dark me-2">กลุ่มงาน</a>
        <a href="{{url("setting/depsub_index")}}" class="btn btn-danger btn-sm text-white me-2">ฝ่าย/แผนก</a>
        <a href="{{url("setting/depsubsub_index")}}" class="btn btn-light btn-sm text-dark me-2">หน่วยงาน</a>
        <a href="{{url("setting/leader")}}" class="btn btn-light btn-sm text-dark me-2">กำหนดสิทธิ์การเห็นชอบ</a>
        <a href="{{url("setting/line_token")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">ตั้งค่า Line Token</a> 
        <div class="text-end">
            
        </div>
        </div>
    </div>
@endsection
@section('content')
<script>
  function TypeAdmin() {
      window.location.href = '{{ route('index') }}';
  }
</script>
<script> 
  function depsub_destroy(DEPARTMENT_SUB_ID)
        {
          // alert(bookrep_id);
          Swal.fire({
          title: 'ต้องการลบใช่ไหม?',
          text: "ข้อมูลนี้จะถูกลบไปเลย !!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
          cancelButtonText: 'ไม่, ยกเลิก'
          }).then((result) => {
          if (result.isConfirmed) {
                  $.ajaxSetup({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                    });
                    $.ajax({ 
                    type: "delete",
                    url:"{{url('depsub_destroy')}}" +'/'+ DEPARTMENT_SUB_ID,  
                   
                    success:function(response)
                    {          
                        Swal.fire({
                          title: 'ลบข้อมูล!',
                          text: "You Delet data success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {                  
                            $("#sid"+DEPARTMENT_SUB_ID).remove();     
                            // window.location.reload(); 
                            window.location="{{url('setting/depsub_index')}}";
                            
                          }
                        }) 
                    }
                    })        
                  }
            })
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
    <div class="row justify-content-center">
        <div class="col-md-9">   
              <div class="card">              
                    <div class="card-body shadow-lg">  
                          <div class="table-responsive"> 
                                <form class="custom-validation" action="{{ route('setting.depsub_save') }}" method="POST"
                                      id="insert_depsubForm" enctype="multipart/form-data">
                                      @csrf
                                      <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                                          <div class="row justify-content-center">
                                                <div class="col-md-3"> 
                                                  <div class="form-group">
                                                    <input id="DEPARTMENT_SUB_NAME" type="text" class="form-control" name="DEPARTMENT_SUB_NAME" required autocomplete="DEPARTMENT_SUB_NAME" autofocus placeholder="ชื่อฝ่าย/แผนก">   
                                                  </div>
                                                </div>
                                                <div class="col-md-3"> 
                                                  <select id="DEPARTMENT_ID" name="DEPARTMENT_ID" class="form-select form-select-lg" style="width: 100%">
                                                    <option value=""></option>
                                                      @foreach ($department as $dep)                                  
                                                      <option value="{{ $dep->DEPARTMENT_ID }}">{{ $dep->DEPARTMENT_NAME }}  </option>   
                                                      @endforeach
                                                  </select>
                                                </div>
                                                <div class="col-md-2"> 
                                                  <select id="LEADER_ID" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
                                                    <option value=""></option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }} </option>
                                                        @endforeach
                                                  </select>
                                                </div>
                                                <div class="col-md-3"> 
                                                  <div class="form-group">
                                                    <input id="LINE_TOKEN" type="text" class="form-control" name="LINE_TOKEN" autocomplete="LINE_TOKEN" autofocus placeholder="Line Token">
                                                  </div>
                                                </div>
                                                <div class="col-md-1"> 
                                                    <button type="submit" class="btn btn-primary " >
                                                      <i class="fa-solid fa-floppy-disk me-3"></i>เพิ่มข้อมูล
                                                  </button> 
                                                </div>
                                            </div>

                                </form>
                                <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">
                                        <thead>
                                            <tr height="10px">
                                                <th width="5%" class="text-center">ลำดับ</th> 
                                                <th class="text-center" width="25%">ชื่อกลุ่มงาน</th>
                                                <th class="text-center"  width="25%">ชื่อฝ่าย/แผนก</th>
                                                <th class="text-center" width="15%">หัวหน้ากลุ่ม</th>
                                                <th width="15%" class="text-center">Line Token</th> 
                                                <th width="10%" class="text-center">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $num = 0;                                    
                                          $date = date('Y');                                    
                                          ?>
                                          @foreach ($department_sub as $item)
                                          <?php $num++; ?>
                                              <tr id="sid{{ $item->DEPARTMENT_SUB_ID }}">
                                                  <td class="text-center" width="5%">{{ $num }}</td>
                                                  <td class="p-2" width="25%">{{ $item->DEPARTMENT_NAME }}</td>
                                                  <td class="p-2" width="30%">{{ $item->DEPARTMENT_SUB_NAME }}</td>
                                                  <td class="p-2" width="15%">{{ $item->fname }}  {{ $item->lname }}</td>   
                                                  <td class="p-2" width="15%">{{ $item->LINE_TOKEN }}</td>                                    
                                                  <td class="text-center" width="10%">
                                                      <a href="{{ url('setting/depsub_edit/' . $item->DEPARTMENT_SUB_ID) }}"
                                                          class="text-warning me-3" data-bs-toggle="tooltip"
                                                          data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                          title="แก้ไข" >
                                                          <i class="fa-solid fa-pen-to-square"></i>
                                                      </a>
                                                      <a class="text-danger" href="javascript:void(0)"
                                                          onclick="depsub_destroy({{ $item->DEPARTMENT_SUB_ID }})"
                                                          data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                          data-bs-custom-class="custom-tooltip" title="ลบ">
                                                          <i class="fa-solid fa-trash-can"></i>
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
        <div class="col-md-3"> 
              <div class="card">                 
                      <div class="card-header ">{{ __('เพิ่มข้อมูลฝ่าย/แผนก') }}</div>
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('setting.depsub_save') }}" method="POST"
                            id="insert_depsubForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
      
                        <div class="row">
                          <div class="col-md-12">
                              {{-- <div class="form-group">
                                <input id="DEPARTMENT_SUB_NAME" type="text" class="form-control" name="DEPARTMENT_SUB_NAME" required autocomplete="DEPARTMENT_SUB_NAME" autofocus placeholder="ชื่อฝ่าย/แผนก">   
                              </div> --}}
                          </div>                         
                        </div> 
                        <div class="row">
                          <div class="col-md-12 mt-3">
                              <div class="form-group">
                                {{-- <label for="">ชื่อกลุ่มงาน</label> --}}
                                {{-- <select id="DEPARTMENT_ID" name="DEPARTMENT_ID" class="form-select form-select-lg" style="width: 100%">
                                  <option value=""></option>
                                    @foreach ($department as $dep)                                  
                                    <option value="{{ $dep->DEPARTMENT_ID }}">{{ $dep->DEPARTMENT_NAME }}  </option>   
                                    @endforeach
                                </select> --}}
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                          <div class="col-md-12 mt-3">
                              <div class="form-group">
                                {{-- <select id="LEADER_ID" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
                                  <option value=""></option>
                                      @foreach ($users as $user)
                                          <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }} </option>
                                      @endforeach
                                </select> --}}
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                          <div class="col-md-12 mt-3">
                              <div class="form-group">
                                <input id="LINE_TOKEN" type="text" class="form-control" name="LINE_TOKEN" autocomplete="LINE_TOKEN" autofocus placeholder="Line Token">
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                          <div class="col-md-12 mt-3 text-end">
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary " >
                                  <i class="fa-solid fa-floppy-disk me-3"></i>เพิ่มข้อมูล
                              </button>   
                              </div>
                          </div>                         
                        </div> 
                    </form>
              </div>
          </div>

    </div>   
</div>


@endsection
