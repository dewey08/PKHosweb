@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || หน่วยงาน')

@section('content')
<script>
  function TypeAdmin() {
      window.location.href = '{{ route('index') }}';
  }
</script>
<script> 
  function depsubsub_destroy(DEPARTMENT_SUB_SUB_ID)
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
                    url:"{{url('depsubsub_destroy')}}" +'/'+ DEPARTMENT_SUB_SUB_ID,   
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
                            $("#sid"+DEPARTMENT_SUB_SUB_ID).remove();     
                            window.location.reload(); 
                            window.location="{{url('setting/depsubsub_index')}}"; 
                            
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
        <div class="col-md-12">   
            <div class="card">                  
                <div class="card-body shadow-lg"> 
                    <div class="table-responsive"> 

                      <form class="custom-validation" action="{{ route('setting.depsubsub_update') }}" method="POST"
                            id="update_depsubsubForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="DEPARTMENT_SUB_SUB_ID" id="DEPARTMENT_SUB_SUB_ID" value="{{$dataedits->DEPARTMENT_SUB_SUB_ID }}">

                          <div class="row">
                                <div class="col-md-4 mt-2"> 
                                  <div class="form-group">
                                    <label for="">ชื่อหน่วยงาน</label>
                                    <input id="DEPARTMENT_SUB_SUB_NAME" type="text" class="form-control" name="DEPARTMENT_SUB_SUB_NAME"  value="{{$dataedits->DEPARTMENT_SUB_SUB_NAME }}">   
                                  </div>
                                </div>
                                <div class="col-md-4 mt-2"> 
                                  <label for="">ฝ่าย/แผนก</label>
                                  <div class="form-group">
                                  <select id="DEPARTMENT_SUB_ID" name="DEPARTMENT_SUB_ID" class="form-select form-select-lg" style="width: 100%">
                                    <option value=""></option>
                                      @foreach ($department_sub as $depsub)  
                                      @if ($dataedits->DEPARTMENT_SUB_ID == $depsub->DEPARTMENT_SUB_ID)
                                      <option value="{{ $depsub->DEPARTMENT_SUB_ID }}" selected>{{ $depsub->DEPARTMENT_SUB_NAME }}  </option>   
                                      @else
                                      <option value="{{ $depsub->DEPARTMENT_SUB_ID }}">{{ $depsub->DEPARTMENT_SUB_NAME }}  </option>   
                                      @endif                                
                                     
                                      @endforeach
                                  </select>
                                </div>
                                </div>
                                <div class="col-md-4 mt-2"> 
                                  <label for="">หัวหน้าหน่วยงาน</label>
                                  <div class="form-group">
                                  <select id="LEADER_ID3" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
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
                            </div>
                            <div class="row">
                              <div class="col-md-4 mt-2"> 
                                <div class="form-group">
                                  <label for="">Line Token</label>
                                  <input id="LINE_TOKEN" type="text" class="form-control" name="LINE_TOKEN" value="{{$dataedits->LINE_TOKEN }}">
                                </div>
                              </div>
                              <div class="col-md-4 mt-2"> 
                                <div class="form-group">
                                  <label for="">Color</label><br>
                                  <input type="color" id="DSS_COLOR" class="form-control form-control-color" name="DSS_COLOR" value="{{$dataedits->DSS_COLOR }}" style="width: 100%;">
                                </div>
                              </div> 
                              <div class="col-md-4 mt-2"> 
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
                                          <th class="text-center" width="25%">ฝ่าย/แผนก</th>
                                          <th class="text-center"  width="30%">หน่วยงาน</th>
                                          <th class="text-center">หัวหน้ากลุ่ม</th>
                                          <th width="15%" class="text-center">Line Token</th> 
                                          <th width="5%" class="text-center">Color</th> 
                                          <th width="15%" class="text-center">Manage</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php $num = 0;                                    
                                    $date = date('Y');                                    
                                    ?>
                                    @foreach ($department_sub_sub as $item)
                                    <?php $num++; ?>
                                        <tr id="sid{{ $item->DEPARTMENT_SUB_SUB_ID }}">
                                            <td class="text-center" width="5%">{{ $num }}</td>
                                            <td class="p-2" width="25%">{{ $item->DEPARTMENT_SUB_NAME }}</td>
                                            <td class="p-2" width="30%">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
                                            <td class="p-2" width="15%">{{ $item->fname }}  {{ $item->lname }}</td>   
                                            <td class="p-2" width="10%">{{ $item->LINE_TOKEN }}</td>  
                                            <td class="p-2" width="5%">                                            
                                              <p style="color:red">{{$item->DSS_COLOR }}</p>   
                                            </td>                                   
                                            <td class="text-center" width="7%">
                                                <a href="{{ url('setting/depsubsub_edit/' . $item->DEPARTMENT_SUB_SUB_ID) }}"
                                                    class="text-warning me-3" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                    title="แก้ไข" >
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="depsubsub_destroy({{ $item->DEPARTMENT_SUB_SUB_ID }})"
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

 
@endsection
