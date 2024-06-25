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

                      <form class="custom-validation" action="{{ route('setting.depsubsub_save') }}" method="POST"
                              id="insert_depsubsubForm" enctype="multipart/form-data">
                              @csrf
                              <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">

                                  <div class="row justify-content-center">
                                        <div class="col-md-4 mt-2"> 
                                          <div class="form-group">
                                            <input id="DEPARTMENT_SUB_SUB_NAME" type="text" class="form-control" name="DEPARTMENT_SUB_SUB_NAME" required autocomplete="DEPARTMENT_SUB_SUB_NAME" autofocus placeholder="ชื่อหน่วยงาน">   
                                          </div>
                                        </div>
                                        <div class="col-md-4 mt-2"> 
                                          <select id="DEPARTMENT_SUB_ID" name="DEPARTMENT_SUB_ID" class="form-select form-select-lg" style="width: 100%">
                                            <option value=""></option>
                                              @foreach ($department_sub as $depsub)                                  
                                              <option value="{{ $depsub->DEPARTMENT_SUB_ID }}">{{ $depsub->DEPARTMENT_SUB_NAME }}  </option>   
                                              @endforeach
                                          </select>
                                        </div>
                                        <div class="col-md-4 mt-2"> 
                                          <select id="LEADER_ID3" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
                                            <option value=""></option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }} </option>
                                                @endforeach
                                          </select>
                                        </div>
                                        
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4 mt-2"> 
                                      <div class="form-group">
                                        <label for="">Line Token</label>
                                        <input id="LINE_TOKEN" type="text" class="form-control" name="LINE_TOKEN">
                                      </div>
                                    </div>
                                    <div class="col-md-4 mt-2"> 
                                      <div class="form-group">
                                        <label for="">Color</label> <br>
                                        <input type="color" class="form-control-color" id="DSS_COLOR" name="DSS_COLOR" style="width: 100%">
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
                                        <th width="7%" class="text-center">Manage</th>
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
                                          <td class="p-2" width="15%">{{ $item->LINE_TOKEN }}</td> 
                                          <td class="p-2" width="5%">
                                            <p style="color:red">{{$item->DSS_COLOR }}</p>
                                          </td>                                    
                                          <td class="text-center" width="7%">
                                            {{-- <button type="button" class="btn add_color btn-sm" value="{{ $item->DEPARTMENT_SUB_SUB_ID }}"  data-bs-toggle="tooltip" data-bs-placement="left" title="เลือกสี">
                                                <i class="fa-solid fa-palette me-2 text-success"></i> 
                                            </button> --}}
                                            {{-- <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target=".add_colorModal{{ $item->DEPARTMENT_SUB_SUB_ID }}" data-bs-toggle="tooltip" data-bs-placement="left" title="เลือกสี">
                                              <i class="fa-solid fa-palette me-2 text-success"></i> 
                                          </button> --}}
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

                                      <!--  Modal content for the add_color example -->
                                      <div class="modal fade add_colorModal{{ $item->DEPARTMENT_SUB_SUB_ID }}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
                                        aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มสีที่ต้องการ</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <form class="custom-validation" action="{{ route('setting.depsubsub_updatecolor') }}" method="POST"
                                                  id="insert_colorForm" enctype="multipart/form-data">
                                                  @csrf 
                                                  <div class="modal-body">
                                                      <div class="row">
                                                          <div class="col-md-12">
                                                              <label for="">สีที่ต้องการ</label>
                                                              <div class="form-group">
                                                                  <input type="color" class="form-control-color" id="DEPARTMENT_SUB_SUB_COLOR" name="DEPARTMENT_SUB_SUB_COLOR" style="width: 100%">
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <input id="dss_id" name="dss_id" type="hidden" class="form-control" value="{{ $item->DEPARTMENT_SUB_SUB_ID }}">

                                                  <div class="modal-footer">
                                                      <div class="col-md-12 text-end">
                                                          <div class="form-group">
                                                              {{-- <button type="button" id="saveBtn" class="btn btn-primary btn-sm"> --}}
                                                              <button type="submit" class="btn btn-primary btn-sm">
                                                                  <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                  บันทึกข้อมูล
                                                              </button>
                                                              <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                                                      class="fa-solid fa-xmark me-2"></i>Close</button>

                                                          </div>
                                                      </div>
                                                  </div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                
                                  @endforeach
                              
                                </tbody>
                            </table>
                    

                    </div>
                </div>
            </div>
        </div>
       

    </div>   
</div>

<!--  Modal content for the add_color example -->
{{-- <div class="modal fade" id="add_color" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myExtraLargeModalLabel">เพิ่มสีที่ต้องการ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label for="">สีที่ต้องการ</label>
                    <div class="form-group">
                        <input type="color" class="form-control-color" id="DEPARTMENT_SUB_SUB_COLOR" name="DEPARTMENT_SUB_SUB_COLOR" style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
        <input id="dss_id" name="dss_id" type="hidden" class="form-control">

        <div class="modal-footer">
            <div class="col-md-12 text-end">
                <div class="form-group">
                    <button type="button" id="saveBtn" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        บันทึกข้อมูล
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                            class="fa-solid fa-xmark me-2"></i>Close</button>

                </div>
            </div>
        </div>
    </div>
</div>
</div> --}}
 
@endsection
@section('footer')
 <script>
   $(document).ready(function(){
          $('#insert_colorForm').on('submit',function(e){
                e.preventDefault();            
                var form = this;
                // alert('OJJJJOL');
                $.ajax({
                      url:$(form).attr('action'),
                      method:$(form).attr('method'),
                      data:new FormData(form),
                      processData:false,
                      dataType:'json',
                      contentType:false,
                      beforeSend:function(){
                        $(form).find('span.error-text').text('');
                      },
                      success:function(data){
                        if (data.status == 200 ) {
                          Swal.fire({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            text: "You Insert data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177', 
                            confirmButtonText: 'เรียบร้อย'
                          }).then((result) => {
                            if (result.isConfirmed) {                  
                              // window.location.reload();
                              window.location="{{url('setting/depsubsub_index')}}";
                            }
                          })      
                        } else {          
                         
                        }
                      }
                });
          });
    });
 </script>
@endsection
