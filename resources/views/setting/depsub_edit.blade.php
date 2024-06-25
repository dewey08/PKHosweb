@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || ฝ่าย/แผนก')

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
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-12">   
              <div class="card">
                  {{-- <div class="card-header">{{ __('ตั้งค่ากลุ่มงาน') }}</div> --}}
                    <div class="card-body shadow-lg">
                      @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                    

                    <div class="table-responsive"> 


                      <form class="custom-validation" action="{{ route('setting.depsub_update') }}" method="POST"
                            id="update_depsubForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="DEPARTMENT_SUB_ID" id="DEPARTMENT_SUB_IDS" value="{{$dataedits->DEPARTMENT_SUB_ID }}">

                          <div class="row justify-content-center">
                                <div class="col-md-3 mt-2"> 
                                  <label for="">ชื่อฝ่าย/แผนก</label>
                                  <div class="form-group">
                                 
                                    <input id="DEPARTMENT_SUB_NAME" type="text" class="form-control" name="DEPARTMENT_SUB_NAME" value="{{$dataedits->DEPARTMENT_SUB_NAME }}">   
                                  </div>
                                </div>
                                <div class="col-md-3 mt-2"> 
                                  <label for="">ชื่อกลุ่มงาน</label>
                                  <div class="form-group">
                                  
                                    <select id="DEPARTMENT_ID" name="DEPARTMENT_ID" class="form-select form-select-lg" style="width: 100%">
                                      <option value=""></option>
                                      @foreach ($department as $dep)  
                                        @if ($dataedits->DEPARTMENT_ID == $dep->DEPARTMENT_ID)
                                        <option value="{{ $dep->DEPARTMENT_ID }}" selected>{{ $dep->DEPARTMENT_NAME }}  </option>   
                                        @else
                                        <option value="{{ $dep->DEPARTMENT_ID }}">{{ $dep->DEPARTMENT_NAME }}  </option>   
                                        @endif                                      
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2 mt-2"> 
                                  <label for="">หัวหน้าฝ่าย/แผนก</label>
                                  <div class="form-group">
                                
                                    <select id="LEADER_ID2" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
                                      <option value=""></option>
                                        @foreach ($users as $user)
                                        @if ($dataedits->LEADER_ID == $user->id)
                                        <option value="{{ $user->id }}" selected>{{ $user->fname }} {{ $user->lname }} </option>
                                        @else
                                        <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }} </option>
                                        @endif
                                          
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-3 mt-2"> 
                                  <label for="">Line Token</label>
                                  <div class="form-group">
                                  
                                    <input id="LINE_TOKEN" type="text" class="form-control" name="LINE_TOKEN" value="{{$dataedits->LINE_TOKEN }}">
                                  </div>
                                </div>
                                <div class="col-md-1 mt-2"> 
                                    <button type="submit" class="btn btn-primary btn-sm mt-4" >
                                     แก้ไข
                                  </button> 
                                </div>
                            </div>
                            <hr>

                </form>



                <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                          {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                                    <thead>
                                        <tr height="10px">
                                            <th width="5%" class="text-center">ลำดับ</th> 
                                            <th class="text-center" width="25%">ชื่อกลุ่มงาน</th>
                                            <th class="text-center"  width="30%">ชื่อฝ่าย/แผนก</th>
                                            <th class="text-center">หัวหน้ากลุ่ม</th>
                                            <th width="15%" class="text-center">Line Token</th> 
                                            <th width="15%" class="text-center">Manage</th>
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
      

    </div>   
</div>

<script src="{{ asset('js/setting.js') }}"></script>
@endsection
