@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || กลุ่มงาน')

@section('content')
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
                            // window.location.reload(); 
                            window.location="{{url('setting/setting_index')}}";
                            
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


                      <form class="custom-validation" action="{{ route('setting.setting_depupdate') }}" method="POST"
                      id="update_depForm" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                      <input type="hidden" name="DEPARTMENT_ID" id="DEPARTMENT_IDS" value="{{$dataedits->DEPARTMENT_ID }}">

                                  <div class="row ">
                                        <div class="col-md-3 mt-2"> 
                                          <label for="">ชื่อกลุ่มงาน</label>
                                          <div class="form-group">
                                          
                                            <input id="DEPARTMENT_NAME" type="text" class="form-control" name="DEPARTMENT_NAME"  value="{{$dataedits->DEPARTMENT_NAME }}">   
                                          </div>
                                        </div>
                                        <div class="col-md-3 mt-2"> 
                                          <label for="">หัวหน้ากลุ่มงาน</label>
                                            <div class="form-group">
                                                 
                                                  <select id="LEADER_ID" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
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
                                        <div class="col-md-5 mt-2"> 
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
                                  <th class="text-center">ชื่อกลุ่มงาน</th>
                                  <th class="text-center">หัวหน้ากลุ่ม</th>
                                  <th width="20%" class="text-center">Line Token</th> 
                                  <th width="15%" class="text-center">Manage</th>
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
        {{-- <div class="col-md-3"> 
              <div class="card">                 
                      <div class="card-header ">{{ __('แก้ไขข้อมูลกลุ่มงาน') }}</div>
                      <div class="card-body shadow">
                        <form class="custom-validation" action="{{ route('setting.setting_depupdate') }}" method="POST"
                            id="update_depForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="DEPARTMENT_ID" id="DEPARTMENT_IDS" value="{{$dataedits->DEPARTMENT_ID }}">

                        <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                <label for="">ชื่อกลุ่มงาน</label>
                                <input id="DEPARTMENT_NAME" type="text" class="form-control" name="DEPARTMENT_NAME"  value="{{$dataedits->DEPARTMENT_NAME }}">   
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                          <div class="col-md-12 mt-3">
                              <div class="form-group">
                                <label for="">หัวหน้ากลุ่มงาน</label>
                                <select id="LEADER_ID" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
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
                          <div class="col-md-12 mt-3">
                              <div class="form-group">
                                <label for="">Line Token</label>
                                <input id="LINE_TOKEN" type="text" class="form-control" name="LINE_TOKEN" value="{{$dataedits->LINE_TOKEN }}">
                              </div>
                          </div>                         
                        </div> 
                        <div class="row">
                          <div class="col-md-12 mt-3 text-end">
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary " >
                                  <i class="fa-solid fa-floppy-disk me-3"></i>แก้ไขข้อมูล
                              </button>   
                              </div>
                          </div>                         
                        </div> 
                    </form>
              </div>
          </div> --}}

    </div>   
</div>


@endsection
