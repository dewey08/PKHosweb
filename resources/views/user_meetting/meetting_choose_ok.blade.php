@extends('layouts.user')
@section('title','ZOffice || ช้อมูลการจองห้องประชุม')


<link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />

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

  date_default_timezone_set("Asia/Bangkok");
  $date =  date('Y-m-d');


  
  ?>
  <style>
    .btn{
       font-size:15px;
     }
  </style>
<div class="container-fluid" >
  <div class="px-0 py-0 mb-2">
    <div class="d-flex flex-wrap justify-content-center">  
      <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>
    
      <div class="text-end">
        <a href="{{url('user_meetting/meetting_dashboard')}}" class="btn btn-light btn-sm text-dark me-2">dashboard</a>
        <a href="{{url('user_meetting/meetting_calenda')}}" class="btn btn-light btn-sm text-dark me-2">ปฎิทิน</a>
        <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-light btn-sm text-dark me-2">ช้อมูลการจองห้องประชุม</a> 
        <a href="#" class="btn btn-info btn-sm text-white me-2">จองห้องประชุม</a> 
      </div>
    </div>
  </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
              {{-- {{$building_level_room->room_name}}    --}}
              <div class="card-header">
                <div class="row">
                  <div class="col"> 
                    บันทึกขอใช้ห้องประชุม วันที่ {{dateThaifromFull($date)}} 
                  </div>
                  <div class="col-4">
                  </div>
                  <div class="col">
                    <label for="" style="color: rgb(255, 0, 0)">  {{$dataedits->room_name}}</label> 
                  </div>
                </div>
              </div>
                <div class="card-body"> 
                    <div class="row">
                          <div class="col-md-6">
                            {{-- <form class="custom-validation" action="{{ route('meetting.meetting_choose_save') }}" method="POST" enctype="multipart/form-data"> --}}
                            {{-- id="insert_meetingForm" enctype="multipart/form-data"> --}}
                            {{-- @csrf --}}
                            <input type="hidden" id="room_id" name="room_id" value="{{$dataedits->room_id}}" > 
                            <input type="hidden" id="status" name="status" value="REQUEST">
                            <input type="hidden" id="userid" name="userid" value="{{Auth::user()->id}}">
                            
                              <div class="row">  

                                  <div class="col-md-3 text-end">
                                      <label for="meetting_title">เรื่องการประชุม </label>
                                  </div>
                                  <div class="col-md-8">
                                      <div class="form-group">
                                          <input id="meetting_title" type="text" class="form-control @error('meetting_title') is-invalid @enderror" name="meetting_title" value="{{ old('meetting_title') }}" autocomplete="meetting_title">
                                          @error('meetting_title')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                 
                                </div>  

                                <div class="row mt-3">  
                                    <div class="col-md-3 text-end">
                                        <label for="meetting_target">กลุ่มบุคคลเป้าหมาย </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input id="meetting_target" type="text" class="form-control @error('meetting_target') is-invalid @enderror" name="meetting_target" value="{{ old('meetting_target') }}" autocomplete="meetting_target" >
                                            @error('meetting_target')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>                                  
                                </div>  

                                <div class="row mt-3">  
                                  <div class="col-md-3 text-end">
                                      <label for="meeting_objective_id">วัตถุประสงค์</label>
                                  </div>
                                  <div class="col-md-8">
                                      <div class="form-group">
                                        <select name="meeting_objective_id" id="meeting_objective_id" class="form-control" style="width: 100%;">
                                            <option value="" selected>--เลือก--</option> 
                                            @foreach ($meeting_objective as $listobj)
                                                <option value="{{ $listobj->meeting_objective_id }}">{{ $listobj->meeting_objective_name}}</option>
                                            @endforeach                   
                                        </select>
                                      </div>
                                  </div> 
                                 
                                </div> 
                                
                                <div class="row mt-3">  
                                    <div class="col-md-3 text-end">
                                        <label for="meetting_year">ปีงบประมาณ </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                          <select name="meetting_year" id="meetting_year" class="form-control" style="width: 100%;">
                                              <option value="" selected>--เลือก--</option> 
                                              @foreach ($budget_year as $year)
                                                  <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id}}</option>
                                              @endforeach                   
                                          </select>
                                        </div>
                                    </div>     
                                    <div class="col-md-2 text-end">
                                        <label for="meetting_person_qty">จำนวน :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input id="meetting_person_qty" type="text" class="form-control @error('meetting_person_qty') is-invalid @enderror" name="meetting_person_qty" value="{{ old('meetting_person_qty') }}" autocomplete="meetting_person_qty" >
                                            @error('meetting_person_qty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>  
                                    <div class="col-md-1">
                                      <label for="lname">คน</label>
                                  </div>      
                                  </div>

                                <div class="row mt-3">  
                                  <div class="col-md-3 text-end">
                                      <label for="meeting_date_begin">ตั้งแต่วันที่ </label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="meeting_date_begin" type="date" class="form-control @error('meeting_date_begin') is-invalid @enderror" name="meeting_date_begin" value="{{ old('meeting_date_begin') }}" autocomplete="meeting_date_begin">
                                          @error('meeting_date_begin')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                  <div class="col-md-2 text-end">
                                      <label for="meeting_date_end">ถึงวันที่ </label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="meeting_date_end" type="date" class="form-control @error('meeting_date_end') is-invalid @enderror" name="meeting_date_end" value="{{ old('meeting_date_end') }}" autocomplete="meeting_date_end">
                                          @error('meeting_date_end')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                </div> 

                                <div class="row mt-3">  
                                  <div class="col-md-3 text-end">
                                      <label for="meeting_time_begin">ตั้งแต่เวลา </label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="meeting_time_begin" type="time" class="form-control @error('meeting_time_begin') is-invalid @enderror" name="meeting_time_begin" value="{{ old('meeting_time_begin') }}" autocomplete="meeting_time_begin" >
                                          @error('meeting_time_begin')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                  <div class="col-md-2 text-end">
                                      <label for="meeting_time_end">ถึงเวลา </label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="meeting_time_end" type="time" class="form-control @error('meeting_time_end') is-invalid @enderror" name="meeting_time_end" value="{{ old('meeting_time_end') }}" autocomplete="meeting_time_end" >
                                          @error('meeting_time_end')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                </div>

                                <div class="row mt-3">  
                                    <div class="col-md-3 text-end">
                                        <label for="meeting_tel">เบอร์โทร </label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input id="meeting_tel" type="text" class="form-control" name="meeting_tel" value="{{Auth::user()->tel}}">
                                            @error('meeting_tel')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="col-md-2 text-end">
                                        
                                    </div>
                                   
                                  </div>

                            </div>

                          <div class="col-md-6">
                            <div id='calendar'></div>
                              <!-- <div class="bg-image hover-overlay ripple">
                                    <a href="#">
                                          <img src="{{asset('storage/meetting/'.$dataedits->room_img)}}" height="450px" width="350px" alt="Image" class="img-thumbnail"> 
                                          <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                                    </a>                                
                              </div> -->
                          </div>
                    </div>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card-header shadow">
                                <label for="">อุปกรณ์ที่ต้องการ </label>
                            </div> 
                            <div class="card-body shadow">
                                <div class="table-responsive">
                                    <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                <td style="text-align: center;">รายการอุปกรณ์</td>                                                                      
                                                <td style="text-align: center;" width="12%">จำนวน</td>                                                   
                                                <td style="text-align: center;" width="7%">
                                                    <a class="btn btn-sm btn-info addRow1" style="color:#FFFFFF;"><i class="fas fa-plus" ></i></a>
                                                </td>
                                            </tr>
                                        </thead> 
                                        <tbody class="tbody1"> 
                                                <tr height="40">
                                                    <td style="text-align: center;"> 1 </td>                                                
                                                    <td> 
                                                        <select name="MEETTINGLIST_ID[]" id="MEETTING_LIST_ID0" class="form-control" style="width: 100%;">
                                                            <option value="" selected>--รายการอุปกรณ์--</option> 
                                                            @foreach ($meeting_list as $list)
                                                                <option value="{{ $list -> meeting_list_id }}">{{ $list->meeting_list_name}}</option>
                                                            @endforeach                   
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                        <input name="MEETTINGLIST_QTY[]" id="MEETTINGLIST_QTY0" class="form-control">
                                                    </td>                                               
                                                    <td style="text-align: center;">
                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;">
                                                        </a>
                                                    </td>
                                                </tr>                                                                 
                                        </tbody>   
                                    </table>
                                </div>
                            </div>  
                        </div>

                        <div class="col-md-6">
                            <div class="card-header shadow">
                                <label for="">รายการอาหาร </label>
                            </div> 
                            <div class="card-body shadow">
                                <div class="table-responsive">
                                    <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                <td style="text-align: center;">รายการอาหาร</td>                                                                      
                                                <td style="text-align: center;" width="10%">จำนวน</td>                                                    
                                                <td style="text-align: center;" width="7%"><a  class="btn btn-sm btn-info addRow2" style="color:#FFFFFF;"><i class="fas fa-plus" ></i></a></td>
                                            </tr>
                                        </thead> 
                                        <tbody class="tbody2"> 
                                                <tr>
                                                    <td style="text-align: center;"> 1 </td>                                                
                                                    <td> 
                                                        <select name="meeting_service_food_id[]" id="FOOD_LIST_ID0" class="form-control" style="width: 100%;">
                                                            <option value="" selected>--รายการอาหาร--</option> 
                                                            @foreach ($food_list as $food)
                                                                <option value="{{ $food->food_list_id }}">{{$food->food_list_name}}</option>
                                                            @endforeach  
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                    <input name="meeting_service_food_qty[]" id="food_list_qty0" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                                                    </td> 
                                                    <td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove2" style="color:#FFFFFF;"></a></td>
                                                </tr>                                                                 
                                        </tbody>   
                                    </table>
                                </div> 
                            </div>  
                        </div>
                    </div>
                        
                    <div class="card-footer">
                        <div class="col-md-12 mt-3 text-end"> 
                            <div class="form-group">
                                <button type="submit" id="saveBtn" class="btn btn-primary btn-sm">
                                    บันทึกข้อมูล
                                </button> 
                                <a href="{{url('user_meetting/meetting_add/'.Auth::user()->id)}}" class="btn btn-danger btn-sm">
                                    ยกเลิก
                                </a>
                            </div>
                   
                        </div>   
                    </div>
                {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')
{{-- <script src="{{ asset('js/jquery-3.2.1.0.min.js') }}"></script> --}}
<script src="{{ asset('select2/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('select').select2();
        $('#meetting_year').select2({
            dropdownParent: $('#meettingModal')
        });
        $('#meeting_objective_id').select2({
            dropdownParent: $('#meettingModal')
        });
    });
    $('.addRow1').on('click',function(){
        addRow1();
        $('select').select2();
        });
        function addRow1(){
        var count = $('.tbody1').children('tr').length;
        var tr ='<tr>'+
                '<td style="text-align: center;">'+
                (count+1)+
                '</td>'+
                '<td>'+
                '<select name="MEETTINGLIST_ID[]" id="MEETTING_LIST_ID'+count+'" class="form-control" style="width: 100%;">'+               
                '<option value="" selected>--รายการอุปกรณ์--</option>'+ 
                '@foreach ($meeting_list as $list)'+
                '<option value="{{ $list->meeting_list_id }}">{{$list->meeting_list_name}}</option>'+
                '@endforeach'+
                '</select> '+
                '</td>'+               
                '<td>'+
                '<input name="MEETTINGLIST_QTY[]" id="MEETTINGLIST_QTY'+count+'" class="form-control">'+
                '</td>'+ 
                '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;"></a></td>'+
                '</tr>';
        $('.tbody1').append(tr);
        };
        $('.tbody1').on('click','.remove1', function(){
    $(this).parent().parent().remove(); 
                
});
</script>
<script>
    $(document).ready(function() {
        $('select').select2();
    });
    $('.addRow2').on('click',function(){
            addRow2();
        $('select').select2();
        });
        function addRow2(){
        var count2 = $('.tbody2').children('tr').length;
        var tr ='<tr>'+
                '<td style="text-align: center;">'+
                (count2+1)+
                '</td>'+
                '<td>'+
                '<select name="meeting_service_food_id[]" id="FOOD_LIST_ID'+count2+'" class="form-control" style="width: 100%;">'+ 
                '<option value="" selected>--รายการอาหาร--</option>'+ 
                '@foreach ($food_list as $food)'+
                '<option value="{{ $food->food_list_id }}">{{$food->food_list_name}}</option>'+
                '@endforeach'+
                '</select> '+
                '</td>'+               
                '<td>'+
                '<input name="meeting_service_food_qty[]" id="food_list_qty'+count2+'" class="form-control">'+
                '</td>'+ 
                '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove2" style="color:#FFFFFF;"></a></td>'+
                '</tr>';
        $('.tbody2').append(tr);
        };

    $('.tbody2').on('click','.remove2', function(){
        $(this).parent().parent().remove(); 
           
    });
</script> 





<script>
    $(document).ready(function() {      

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            var meetting = @json($events);
            $('#calendar').fullCalendar({
                events: meetting, 
                selectHelper: true,                       
            });
        });

        $(function() {
            $('#saveBtn').click(function() {
              var meettingtitle = $('#meetting_title').val();
              var status = $('#status').val();
              var meettingyear = $('#meetting_year').val();
              var meettingtarget = $('#meetting_target').val();
              var meettingpersonqty = $('#meetting_person_qty').val();
              var meetingdatebegin = $('#meeting_date_begin').val();
              var meetingdateend = $('#meeting_date_end').val();
              var meetingobj = $('#meeting_objective_id').val();
              var userid = $('#userid').val();
              var roomid = $('#room_id').val();
              var timbegin = $('#meeting_time_begin').val();
              var timeend = $('#meeting_time_end').val();
              var meetingtel = $('#meeting_tel').val();
            //   alert(meetingtel);
              $.ajax({
                url: "{{ route('meetting.meetting_choose_save') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    meettingtitle,
                    meetingdatebegin,
                    meetingdateend,
                    status,
                    meettingyear,
                    meettingtarget,
                    meettingpersonqty,
                    meetingobj,
                    userid,
                    roomid,
                    timbegin,
                    timeend,
                    meetingtel
                },
                success: function(response) {

                    if (response.status == 0) {

                    } else {
                        Swal.fire({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            text: "You Insert data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            // cancelButtonColor: '#d33',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    response);
                                    window.location="/user_meetting/meetting_index"; //
                                // window.location
                                //     .reload();

                                
                            }
                        })
                    }
                    // $('#meettingModal').modal('hide')

                },                
            });
            });
          });

    });
</script>

{{-- <script src="{{ asset('js/user_meetting.js') }}"></script>  --}}

@endsection
