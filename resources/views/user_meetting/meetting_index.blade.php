@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER || ช้อมูลการจองห้องประชุม')
@section('content')
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
           }
           .cv-spinner {
           height: 100%;
           display: flex;
           justify-content: center;
           align-items: center;  
           }
           .spinner {
           width: 250px;
           height: 250px;
           border: 10px #ddd solid;
           border-top: 10px #1fdab1 solid;
           border-radius: 50%;
           animation: sp-anime 0.8s infinite linear;
           }
           @keyframes sp-anime {
           100% { 
               transform: rotate(390deg); 
           }
           }
           .is-hide{
           display:none;
           }
</style>
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function meetting_choose_cancel(meeting_id)
        {
        // alert(bookrep_id);
        Swal.fire({
        title: 'ต้องการยกเลิกรายการนี้ใช่ไหม?',
        text: "ข้อมูลนี้จะถูกส่งไปยังผู้ดูแลห้องประชุม",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่ ',
        cancelButtonText: 'ไม่'
        }).then((result) => {
        if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                    $.ajax({ 
                    type: "POST",
                    url:"{{url('meetting_choose_cancel')}}" +'/'+ meeting_id, 
                    success:function(response)
                    {          
                        Swal.fire({
                        title: 'รอการยืนยันจากผู้ดูแลงาน',
                        text: "Wait for confirmation from the supervisor",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#06D177', 
                        confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                        if (result.isConfirmed) {                  
                            
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
        $iddep =  Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน 
?>
  
<div class="tabs-animation">
    
        <div class="row text-center">  
            <div id="preloader">
                <div id="status">
                    <div class="spinner">
                        
                    </div>
                </div>
            </div>
              
        </div> 
    
        <div class="row"> 
            <div class="col-md-12"> 
                 <div class="main-card mb-3 card">
                    <div class="card-header">
                        ข้อมูลการใช้ห้องประชุม
                        <div class="btn-actions-pane-right">
                            <form action="{{ route('meetting.meetting_index') }}" method="POST">
                                @csrf
                                <div class="row"> 
                                    <div class="col-md-1 text-end">วันที่</div> 
                                    <div class="col-md-7 text-end">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                            @if ($startdate != '')
                                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                data-date-language="th-th" value="{{ $startdate }}" required/>
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                data-date-language="th-th" value="{{ $enddate }}"/> 
                                            @else
                                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $datenow }}" required/>
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $datenow }}"/> 
                                            @endif   
                                        </div> 
                                    </div>
                                    
                                    {{-- <div class="col-md-1 text-end">วันที่</div>
                                    <div class="col-md-3 text-center">
                                        @if ($startdate == '')
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                    value="{{ $datenow }}">                    
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        @else
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                    value="{{ $startdate }}">                    
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        @endif                                    
                                    </div>
                                    <div class="col-md-1 text-center">ถึงวันที่</div>
                                    <div class="col-md-3 text-center">
                                        @if ($enddate == '')
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                    value="{{ $datenow }}">                    
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        @else
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                    value="{{ $enddate }}">                    
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        @endif
                                        
                                    </div>  --}}
                                    <div class="col-md-2 me-2">  
                                        <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="pe-7s-search btn-icon-wrapper"></i> ค้นหา
                                        </button>  
  
                                        {{-- @if ($startdate == '')
                                            <a href="{{url('user_timeindex_excel/'.$datenow.'/'.$datenow)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                3 Export
                                            </a>
                                        @else
                                            <a href="{{url('user_timeindex_excel/'.$startdate.'/'.$enddate)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                3 Export
                                            </a>
                                        @endif --}}

                                        <a href="{{ url('user_meetting/meetting_add/'.Auth::user()->id )}}"  class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                            {{-- <i class="pe-7s-news-paper btn-icon-wrapper"></i>  --}}
                                            <i class="fa-regular fa-square-plus me-2"></i>เพิ่มข้อมูล
                                        </a>  
                                     
                                    </div> 
                                    
                                </div> 
                            </form>
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    {{-- <tr style="font-size: 14px;"> --}}
                                <tr style="font-family: sans-serif;font-size: 13px;">
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
                                    <?php $ia = 1; ?>
                                    @foreach ($meeting_service as $item)  
                                        
                                        <tr style="font-size: 13px;" id="sid{{ $item->meeting_id }}">
                                            <td>{{ $ia++ }}</td>
                                            {{-- <td>{{ dateThaifromFull($item->CHEACKIN_DATE) }}</td>  --}}
                                            @if ($item->meetting_status == 'REQUEST')
                                            <td class="text-center" width="5%"><div class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning">ร้องขอ</div></td>
                                            @elseif ($item->meetting_status == 'ALLOCATE')
                                            <td class="text-center" width="5%"><div class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">จัดสรร</div></td>  
                                            @elseif ($item->meetting_status == 'CANCEL')
                                            <td class="text-center" width="5%"><div class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">ยกเลิก</div></td>                                             
                                            @else
                                            <td class="text-center" width="5%"><div class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">อนุมัติ</div></td>
                                            @endif


                                            <td class="text-center" width="7%">{{ $item->meetting_year }}</td>                                         
                                            <td class="p-2">{{ $item->room_name }}</td>
                                            <td class="p-2" width="10%">{{ DateThai($item->meeting_date_begin) }}</td>
                                            <td class="p-2" width="7%">{{ $item->meeting_time_begin }}</td>
                                            <td class="p-2" width="10%">{{ DateThai($item->meeting_date_end )}}</td>
                                            <td class="p-2" width="7%">{{ $item->meeting_time_end }}</td>
                                            <td class="p-2" width="12%">{{ $item->meeting_user_name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                        type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">ทำรายการ</button>
                                                    <ul class="dropdown-menu">
                                                        <a class="dropdown-item menu btn btn-outline-warning btn-sm"
                                                           href="{{url('user_meetting/meetting_choose_edit/'.$item->meeting_id)}}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                            <i class="fa-solid fa-file-pen me-2"
                                                                style="color: rgb(252, 153, 23)"></i>
                                                            <label for=""
                                                                style="color: rgb(252, 153, 23)">แก้ไข</label>
                                                        </a>
                                                        <a class="dropdown-item menu" href="javascript:void(0)" onclick="meetting_choose_cancel({{$item->meeting_id}})" data-bs-toggle="tooltip" data-bs-placement="left" title="แจ้งยกเลิก">
                                                          
                                                            <i class="fa-solid fa-xmark me-2 text-danger"></i>
                                                            <label for="" style="color: rgb(255, 22, 22)">แจ้งยกเลิก</label> 
                                                          </a>
                                                         
                                                    </ul>
                                                </div>
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
              <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" id="closebtn" data-bs-dismiss="modal">ปิด</button>             
          </div>
          <!-- </form> -->
      </div>
  </div>
</div> 
      
@endsection
@section('footer')

<script> 
    $(document).ready(function() { 
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        }); 
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $('#HR_DEPARTMENT_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            }); 
        $("#spinner-div").hide(); //Request is complete so hide spinner
       
    });

</script>
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
 
 