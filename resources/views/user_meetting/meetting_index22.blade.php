@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER || ช้อมูลการจองห้องประชุม')
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
  <style>
    .btn{
       font-size:15px;
     }
  </style>
<div class="container-fluid" >
 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header">
                  <div class="row">
                    <div class="col">  
                    </div>
                    <div class="col-9">
                    </div>
                    <div class="col">
                      <a href="{{ url('user_meetting/meetting_add/'.Auth::user()->id )}}" class="btn btn-primary btn-sm"> <i class="fa-solid fa-circle-plus me-1"></i> เพิ่มข้อมูล</a>
                    </div>
                  </div>
                </div>

                <div class="card-body">  
                  <div class="table-responsive">
                      <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example_user"> 
                            <thead>
                                <tr height="10px">
                                    <th width="7%">ลำดับ</th>
                                    <th width="10%">สถานะ</th>
                                    <th>ปี</th>
                                    <th>ห้องประชุม</th>
                                    <th>วันที่จอง</th>
                                    <th>เวลา</th>
                                    <th>ถึงวันที่</th>
                                    <th>เวลา</th>
                                    <th width="10%">ผู้ร้องขอ</th>
                                    <th width="10%">ทำรายการ</th>
                                </tr>  
                            </thead>
                            <tbody>
                              <?php $i = 1; $date = date('Y'); ?>
                                  @foreach ($meeting_service as $item)
                                      <tr id="sid{{ $item->meeting_id }}" height="30">
                                          <td class="text-center" width="3%">{{ $i++ }}</td>    

                                          @if ($item->meetting_status == 'REQUEST')
                                          <td class="text-center" width="5%"><div class="badge bg-warning">ร้องขอ</div></td>
                                        @elseif ($item->meetting_status == 'ALLOCATE')
                                          <td class="text-center" width="5%"><div class="badge bg-success">จัดสรร</div></td>                                         
                                        @else
                                          <td class="text-center" width="5%"><div class="badge bg-success">อนุมัติ</div></td>
                                        @endif


                                          <td class="text-center" width="7%">{{ $item->meetting_year }}</td>                                         
                                          <td class="p-2">{{ $item->room_name }}</td>
                                          <td class="p-2" width="10%">{{ DateThai($item->meeting_date_begin) }}</td>
                                          <td class="p-2" width="7%">{{ $item->meeting_time_begin }}</td>
                                          <td class="p-2" width="10%">{{ DateThai($item->meeting_date_end )}}</td>
                                          <td class="p-2" width="7%">{{ $item->meeting_time_end }}</td>
                                          <td class="p-2" width="12%">{{ $item->meeting_user_name }}</td>
                                          <td class="text-center" width="10%">
                                            <!-- Info -->                                               
                                                <div class="dropdown">
                                                  <a class="dropdown-toggle text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                    เลือก
                                                  </a>
                                                
                                                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <li>
                                                      <button class="dropdown-item edit_detail" href="#" value="{{ $item->meeting_id }}">รายละเอียด</button>
                                                      {{-- <a class="dropdown-item edit_detail" href="#" value="{{ $item->meeting_id }}">รายละเอียด</a> --}}
                                                    </li>
                                                    <li><a class="dropdown-item" href="{{ url('user_meetting/meetting_choose_edit/'. $item->meeting_id) }}">แก้ไข</a></li>
                                                    {{-- <li><a class="dropdown-item" href="#">Something else here</a></li> --}}
                                                  </ul>
                                                </div>
                                            <!-- <a href="{{ url('user_meetting/meetting_choose_edit/'. $item->meeting_id) }}"
                                                  class="text-warning me-3" data-bs-toggle="tooltip"
                                                  data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                  title="แก้ไข">   
                                                  <i class="fa-solid fa-pen-to-square me-2"></i>
                                              </a> -->  
                                              <!-- <a href="{{ url('user_meetting/meetting_choose_edit/'. $item->meeting_id) }}" class="btn btn-warning btn-sm" 
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                title="แก้ไข" >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                              </a>  -->                                            
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

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="detailModalLabel">รายละเอียดจองห้องประชุม</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" id="closebtnx" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="row ">
                  <div class="col-md-2 text-end">
                      <label for="room_name">ห้องประชุม :</label>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group">
                          <input id="room_name" type="text" class="form-control" name="room_name" readonly>
                      </div>
                  </div>   
                  <div class="col-md-2 text-end">
                    <label for="meetting_year">ปีงบประมาณ :</label>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <input id="meetting_yearde" type="text" class="form-control" readonly> 
                    </div>
                </div>   
                       
              </div>

              <div class="row mt-3">
                  <div class="col-md-2 text-end">
                      <label for="meetting_title">เรื่องการประชุม :</label>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group"> 
                          <input id="meetting_title" type="text" class="form-control" readonly>  
                      </div>
                  </div>
                  <div class="col-md-2 text-end">
                    <label for="meeting_user_name">ผู้ร้องขอ :</label>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input id="meeting_user_name" type="text" class="form-control" name="meeting_user_name" readonly>                         
                    </div>
                </div>    



              </div>

              <div class="row mt-3">
                  <div class="col-md-2 text-end">
                      <label for="meetting_target">กลุ่มบุคคลเป้าหมาย :</label>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group">
                          <input id="meetting_target" type="text" class="form-control" name="meetting_target" readonly>
                      </div>
                  </div>
                  <div class="col-md-2 text-end">
                    <label for="meeting_tel">เบอร์โทร :</label>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input id="meeting_tel" type="text" class="form-control" name="meeting_tel" readonly>                         
                    </div>
                </div>



              </div>

              <div class="row mt-3">
                  <div class="col-md-2 text-end">
                      <label for="meeting_objective_name">วัตถุประสงค์การขอใช้ :</label>
                  </div>
                  <div class="col-md-5">
                      <div class="form-group">
                        <input id="meeting_objective_name" type="text" class="form-control"
                              name="meeting_objective_name" readonly> 
                      </div>
                  </div>
                  <div class="col-md-2 text-end">
                    <label for="meetting_person_qty">จำนวน :</label>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input id="meetting_person_qty" type="text" class="form-control"
                            name="meetting_person_qty" readonly>
                    </div>
                </div>
                <div class="col-md-1">
                    <label for="lname">คน</label>
                </div>
                  
              </div>

              <div class="row mt-3">  
                <div class="col-md-2 text-end">
                    <label for="meeting_date_begin">ตั้งแต่วันที่ </label>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input id="meeting_date_begin" type="date" class="form-control" name="meeting_date_begin" readonly> 
                       
                    </div>
                </div>  
                <div class="col-md-1 text-end">
                  <label for="meeting_date_end">ถึงวันที่ </label>
              </div>
              <div class="col-md-2">
                  <div class="form-group">
                      <input id="meeting_date_end" type="date" class="form-control" name="meeting_date_end" readonly>
                     
                  </div>
              </div>  
              <!-- <div class="col-md-2 text-end">
                <label for="meeting_user_name">ผู้ร้องขอ :</label>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input id="meeting_user_name" type="text" class="form-control" name="meeting_user_name" readonly>                         
                </div>
            </div> -->

              </div> 


              <div class="row mt-3">
                  <div class="col-md-2 text-end">
                      <label for="meeting_time_begin">ตั้งแต่เวลา :</label>
                  </div> 
                  <div class="col-md-2">
                      <div class="form-group">
                          <input id="meeting_time_begin" type="time" class="form-control"
                              name="meeting_time_begin" readonly>
                      </div>
                  </div>
                  <div class="col-md-1 text-end">
                      <label for="meeting_time_end">ถึงเวลา :</label>
                  </div>
                  
                  <div class="col-md-2">
                      <div class="form-group">
                          <input id="meeting_time_end" type="time" class="form-control"
                              name="meeting_time_end" readonly>
                      </div>
                  </div>
              </div>
          </div>
      
          <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-sm" id="closebtn" data-bs-dismiss="modal">ปิด</button>             
          </div>
          <!-- </form> -->
      </div>
  </div>
</div>
@endsection
@section('footer') 

<script>
   $(document).on('click','.edit_detail',function(){
    var meeting_id = $(this).val();
    // alert(meeting_id);
    $('#detailModal').modal('show');
    // $('#detailModal').modal('show');
    $.ajax({
      type: "GET",
      // url: "/zoffice/public/user_meetting/meetting_detail/"+ meeting_id, // กรณีอยู่บนคลาวให้ใส่พาทให้ด้วย
      url: "/user_meetting/meetting_detail/"+ meeting_id,  //ทำในคอมตัวเอง
      success: function(data) {
          console.log(data.mservice.meetting_title);
          $('#meetting_title').val(data.mservice.meetting_title)  
          $('#meeting_date_begin').val(data.mservice.meeting_date_begin) 
          $('#meeting_date_end').val(data.mservice.meeting_date_end) 
          $('#meetting_yearde').val(data.mservice.meetting_year) 
          $('#meetting_target').val(data.mservice.meetting_target) 
          $('#meetting_person_qty').val(data.mservice.meetting_person_qty) 
          $('#meeting_tel').val(data.mservice.meeting_tel) 
          $('#meeting_time_begin').val(data.mservice.meeting_time_begin) 
          $('#meeting_time_end').val(data.mservice.meeting_time_end) 
          $('#meeting_objective_name').val(data.mservice.meeting_objective_name) 
          $('#meeting_user_name').val(data.mservice.meeting_user_name) 
          $('#room_name').val(data.mservice.room_name) 
          $('#meeting_id').val(data.mservice.meeting_id)                
      },      
  });

  $('#closebtn').click(function() {
    $('#detailModal').modal('hide');
  });
  $('#closebtnx').click(function() {
    $('#detailModal').modal('hide');
  });
 });
</script>




@endsection