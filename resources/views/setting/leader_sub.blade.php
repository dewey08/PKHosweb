@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || กำหนดสิทธิ์การเห็นชอบ')


@section('content')
<script>
  function TypeAdmin() {
      window.location.href = '{{ route('index') }}';
  }
</script>
<script> 
      function leader_destroy(leave_id)
            { 
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
                        url:"{{url('leader_destroy')}}" +'/'+ leave_id,  
                        success:function(response)
                        {          
                            Swal.fire({
                              title: 'ลบข้อมูล!',
                              text: "You Delet data success",
                              icon: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#06D177', 
                              confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                              if (result.isConfirmed) {                  
                                $("#sid"+leave_id).remove();   
                                // window.location="{{url('setting/leader')}}"; 
                                window.location.reload();
                              }
                            }) 
                        }
                        })        
                      }
                })
            }
  
      function leadersub_destroy(leave_sub_id)
            { 
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
                        url:"{{url('leadersub_destroy')}}" +'/'+ leave_sub_id,   
                        success:function(response)
                        {          
                            Swal.fire({
                              title: 'ลบข้อมูล!',
                              text: "You Delet data success",
                              icon: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#06D177', 
                              confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                              if (result.isConfirmed) {                  
                                $("#sid"+leave_sub_id).remove();   
                                // window.location="{{url('setting/leader')}}"; 
                                window.location.reload();
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

  use App\Http\Controllers\StaticController;
  use Illuminate\Support\Facades\DB; 
  use App\Models\Leave_leader;  
  use App\Models\Leave_leader_sub; 

  ?>
<div class="container-fluid"> 
      
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">             
                    <div class="card-body shadow-lg">
                        <form class="custom-validation" action="{{ route('setting.leader_save') }}" method="POST" id="insert_leader2Form" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                
                            <div class="row">
                              <div class="col-md-4 mt-2 text-center"> 
                                <label for="">เพิ่มข้อมูลผู้อนุมัติเห็นชอบ</label>
                              </div>
                            
                              <div class="col-md-5 mt-2 text-center">
                                  <div class="form-group">
                                    <select id="LEADER_ID4" name="LEADER_ID" class="form-select form-select-lg" style="width: 100%">
                                      <option value=""></option>                                          
                                          @foreach ($users as $user)
                                              <?php $countcheck =  Leave_leader::where('leader_id','=',$user ->id)->count();?>  
                                                  @if($user ->leader_id == '' && $countcheck == 0  )
                                                      <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }} </option>
                                                  @endif
                                        @endforeach
                                    </select>
                                  </div>
                              </div>    
                              <div class="col-md-3 mt-2 "> 
                                  <div class="form-group">
                                      <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-circle-plus me-2"></i>
                                        เพิ่ม
                                      </button>  
                                </div>
                            </div>          
                        </form>
                        <hr class="mt-3">
                        <div class="table-responsive"> 
                          <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                              {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                                  <thead>
                                      <tr height="10px">
                                          <th width="5%" class="text-center">ลำดับ</th>  
                                          <th class="text-center">ผู้อนุมัติเห็นชอบ</th> 
                                          <th width="15%" class="text-center">Manage</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $num = 0; $date = date('Y'); ?>
                                      @foreach ($leave_leader as $item)
                                        <?php $num++; ?>
                                        
                                          <tr id="sid{{ $item->leave_id }}" >
                                            
                                                      <td class="text-center" width="5%">{{ $num }}</td>
                                                      <td class="p-2" width="25%">{{ $item->leader_name }}</td>    
                                                    <!-- <td class="p-2" width="25%"><a href="{{ url('setting/leader_addsub/' . $item->leave_id) }}">{{ $item->leader_name }}  </a> </td> -->                                                                  
                                                      <td class="text-center" width="10%">
                                                          <a href="{{ url('setting/leader_addsub/' . $item->leave_id) }}"
                                                              class="text-success me-3" data-bs-toggle="tooltip"
                                                              data-bs-placement="left" data-bs-custom-class="custom-tooltip"
                                                              title="เพิ่มผู้ถูกเห็นชอบ" >                                         
                                                              <i class="fa-solid fa-user-plus me-3"></i>
                                                          </a>
                                                          <!--<a class="text-danger" href="javascript:void(0)"
                                                              onclick="leader_destroy({{ $item->leave_id }})"
                                                              data-bs-toggle="tooltip" data-bs-placement="left"
                                                              data-bs-custom-class="custom-tooltip" title="ลบ">
                                                              <i class="fa-solid fa-trash-can"></i>
                                                          </a>-->
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
            <div class="col-md-6 ">
              <div class="card shadow">
                 
                    <div class="card-body shadow-lg">
                        <form class="custom-validation" action="{{ route('setting.leader_addsub_save') }}" method="POST" id="insert_leadersubForm" >
                          @csrf
                              <input type="hidden" name="leave_id" id="leave_id" value=" {{$datasubs->leave_id}}">
                              <input type="hidden" name="leader_id" id="leader_id" value=" {{$datasubs->leader_id}}">
                              
                              <div class="row">
                                  <div class="col-md-4 mt-2 text-center"> 
                                    <label for="">เพิ่มข้อมูลผู้ถูกเห็นชอบ</label>
                                  </div> 
                                  <div class="col-md-5 mt-2 text-center">                                 
                                      <div class="form-group">
                                          <select id="USER_ID" name="USER_ID" class="form-select form-select-lg" style="width: 100%">
                                            <option value=""></option> 
                                                @foreach ($users as $user)
                                                      <?php $countchecksub =  Leave_leader_sub::where('user_id','=',$user->id)->count();?>  
                                                    
                                                      @if($user->user_id == '' && $countchecksub == 0  )
                                                          <option value="{{ $user->id }}">{{ $user->fname }} {{ $user->lname }} </option>
                                                      @endif
                                                @endforeach 
                                          </select>
                                        </div>
                                      </div>    
                                  
                                      <div class="col-md-3 mt-2 "> 
                                          <div class="form-group">
                                              <button type="submit" class="btn btn-primary btn-sm" >
                                                <i class="fa-solid fa-circle-plus me-2"></i>
                                                เพิ่ม
                                              </button>  
                                        </div>           
                                    </div> 

                              </div>
                          </form>
                          <hr class="mt-3">
                            <div class="table-responsive"> 
                                <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example2">
                                      <thead>
                                          <tr height="10px">
                                              <th width="5%" class="text-center">ลำดับ</th>  
                                              <th class="text-center">ผู้ถูกเห็นชอบ</th> 
                                              <th width="15%" class="text-center">Manage</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php $num = 0;                                    
                                        $date = date('Y');                                    
                                        ?>
                                        @foreach ($leave_leader_sub as $items)
                                        <?php $num++; ?>
                                            <tr id="sid{{ $items->leave_sub_id }}">
                                                <td class="text-center" width="5%">{{ $num }}</td>
                                                <td class="p-2" width="25%">{{ $items->user_name }}</td>                                                                      
                                                <td class="text-center" width="10%">
                                                  
                                                    <a class="text-danger" href="javascript:void(0)"
                                                        onclick="leadersub_destroy({{ $items->leave_sub_id }})"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
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
 
@endsection
