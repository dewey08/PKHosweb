@extends('layouts.admin')
@section('title', 'ZOFFice || กลุ่มงาน')
<script>
  function TypeAdmin() {
      window.location.href = '{{ route('index') }}';
  }
</script>
<script> 
  function settingdep_destroy(DEPARTMENT_ID)
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
                    url:"{{url('setting_index_destroy')}}" +'/'+ DEPARTMENT_ID,  
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
                            $("#sid"+DEPARTMENT_ID).remove();     
                            window.location.reload(); 
                            // window.location = "/book/bookmake_index"; //   
                            
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
@section('menu')
<style>
  .btn{
     font-size:15px;
   }
</style>
    <div class="px-3 py-2 border-bottom">
      <div class="container d-flex flex-wrap justify-content-center">  
        <!-- Danger -->
        <div class="btn-group">
          <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-mdb-toggle="dropdown" aria-expanded="false">
            ตั้งค่าทั่วไป
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{url('setting/setting_index')}}">กลุ่มงาน</a></li>
            <li><a class="dropdown-item" href="{{url('setting/depsub_index')}}">ฝ่าย/แผนก</a></li>
            <li><a class="dropdown-item" href="{{url('setting/depsubsub_index')}}">หน่วยงาน</a></li>
            <li><a class="dropdown-item" href="{{url('setting/orginfo')}}">องค์กร</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="{{url('setting/leader')}}">กำหนดสิทธิ์การเห็นชอบ</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="{{url('setting/permiss')}}">กำหนดสิทธิ์การใช้งาน</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="{{url('setting/line_token')}}">ตั้งค่า Line Token</a></li>
          </ul>
        </div>
        <div class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto"></div>
               
        <div class="text-end">
          <button type="button" class="btn btn-danger btn-sm">กลุ่มงาน</button>
        </div>
        </div>
    </div>
@endsection
@section('content')

<div class="container-fluid" style="width: 97%">
    <div class="row">
        <div class="col-md-12">   
            <div class="card">
                <div class="card-body shadow-lg">   
                    <div class="table-responsive"> 

                      <form class="custom-validation" action="{{ route('setting.setting_depsave') }}" method="POST"
                            id="insert_depForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                                  <div class="row justify-content-center">
                                        <div class="col-md-3"> 
                                          <div class="form-group">
                                            <input id="DEPARTMENT_NAME" type="text" class="form-control" name="DEPARTMENT_NAME" required autocomplete="DEPARTMENT_NAME" autofocus placeholder="ชื่อกลุ่มงาน">   
                                          </div>
                                        </div>
                                        <div class="col-md-3"> 
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
                                            <button type="submit" class="btn btn-primary btn-sm" >
                                            เพิ่ม
                                          </button> 
                                        </div>
                                    </div>
                                    <hr>

                      </form>


                      <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example">
                          <thead>
                              <tr height="10px">
                                  <th width="5%" class="text-center">ลำดับ</th> 
                                  <th class="text-center">ชื่อกลุ่มงาน</th>
                                  <th class="text-center">หัวหน้ากลุ่ม</th>
                                  <th width="20%" class="text-center">Line Token</th> 
                                  <th width="10%" class="text-center">Manage</th>
                              </tr>
                          </thead>
                          <tbody>
                                    <?php $num = 0;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($department as $item)
                                    <?php $num++; ?>
                                        <tr id="sid{{ $item->DEPARTMENT_ID }}">
                                            <td class="text-center">{{ $num }}</td>
                                            <td class="p-2">{{ $item->DEPARTMENT_NAME }}</td>
                                            <td class="p-2" width="20%">{{ $item->fname }}  {{ $item->lname }}</td>   
                                            <td class="p-2" width="20%">{{ $item->LINE_TOKEN }}</td>                                    
                                            <td class="text-center" width="10%">
                                                <a href="{{ url('setting/setting_index_edit/' . $item->DEPARTMENT_ID) }}"
                                                    class="text-warning me-3" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข" >
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="settingdep_destroy({{ $item->DEPARTMENT_ID }})"
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
       
    </div>   
</div>

<!-- <script src="{{ asset('js/setting.js') }}"></script> -->
@endsection
