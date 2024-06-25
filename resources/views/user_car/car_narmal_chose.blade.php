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
        {{-- <a href="{{url('user_car/car_dashboard/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2">dashboard</a> --}}
        <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลการใช้รถทั่วไป</a>
        <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลการใช้รถพยาบาล</a> 
        <a href="" class="btn btn-info btn-sm text-white me-2">เพิ่มข้อมูลขอใช้รถ</a> 
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
                    {{-- บันทึกขอใช้ห้องประชุม วันที่ {{dateThaifromFull($date)}} <label for="" style="color: rgb(255, 0, 0)">  {{$dataedits->room_name}}</label>  --}}
                  </div>
                  <div class="col-1">
                  </div>
                  <div class="col">
                    {{-- <label for="" style="color: rgb(255, 0, 0)">  {{$dataedits->room_name}}</label>  --}}
                  </div>
                </div>
              </div>
                <div class="card-body"> 
                    <form class="custom-validation" action="{{ route('meetting.meetting_choose_linesave') }}" id="insert_chooselinesaveForm" method="POST" enctype="multipart/form-data">
                        {{-- id="insert_chooselinesaveForm" enctype="multipart/form-data"> --}}
                        @csrf


                    <div class="row">
                        <div class="col-md-6">
                            <div id='calendar'></div>
                        </div> 
                          <div class="col-md-6">                           
                            
                            {{-- <input type="hidden" id="room_id" name="room_id" value="{{$dataedits->room_id}}" >  --}}
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
                                      <select name="meeting_objective_id" id="meeting_objective_id" class="form-control form-control-lg" style="width: 100%;">
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
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input id="meeting_date_begin" type="date" class="form-control @error('meeting_date_begin') is-invalid @enderror" name="meeting_date_begin" value="{{ old('meeting_date_begin') }}" autocomplete="meeting_date_begin">
                                        @error('meeting_date_begin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                                
                              </div> 

                              <div class="row mt-3">
                                <div class="col-md-3 text-end">
                                    <label for="meeting_date_end">ถึงวันที่ </label>
                                </div>
                                <div class="col-md-8">
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
                                <div class="col-md-8">
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
                         
                    </div>     
                  
                    <div class="card-footer">
                        <div class="col-md-12 text-end"> 
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    {{-- <button type="submit" id="saveBtn" class="btn btn-primary btn-sm"> --}}
                                    บันทึกข้อมูล
                                </button> 
                                <a href="{{url('user_meetting/meetting_add/'.Auth::user()->id)}}" class="btn btn-danger btn-sm">
                                    ยกเลิก
                                </a>
                            </div>                   
                        </div>   
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
@endsection
@section('footer') 

<script>
    $(document).ready(function() {

        $(function() {
            var meetting = @json($events);
            $('#calendar').fullCalendar({
                events: meetting, 
                selectHelper: true,                       
            });
        });
               
            $('select').select2();
        });
            $('.addRow').on('click',function(){
                addRow();
                $('select').select2();
            });
                function addRow(){
                var count = $('.tbody1').children('tr').length;
                var tr ='<tr>'+
                        '<td style="text-align: center;">'+
                        (count+1)+
                        '</td>'+
                        '<td>'+
                        '<select name="MEETTINGLIST_ID[]" id="MEETTINGLIST_ID'+count+'" class="form-control form-control-sm" style="width: 100%;">'+               
                        '<option value="" selected>--รายการอุปกรณ์--</option>'+ 
                        '@foreach ($meeting_list as $list)'+
                        '<option value="{{ $list->meeting_list_id }}">{{$list->meeting_list_name}}</option>'+
                        '@endforeach'+
                        '</select> '+
                        '</td>'+               
                        '<td>'+
                        '<input name="MEETTINGLIST_QTY[]" id="MEETTINGLIST_QTY'+count+'" class="form-control form-control-sm">'+
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
                        '<select name="FOOD_LIST_ID[]" id="FOOD_LIST_ID'+count2+'" class="form-control form-control-sm" style="width: 100%;">'+               
                        '<option value="" selected>--รายการอาหาร--</option>'+ 
                        '@foreach ($food_list as $food)'+
                        '<option value="{{ $food->food_list_id }}">{{$food->food_list_name}}</option>'+
                        '@endforeach'+
                        '</select> '+
                        '</td>'+               
                        '<td>'+
                        '<input name="FOOD_LIST_QTY[]" id="FOOD_LIST_QTY'+count2+'" class="form-control form-control-sm">'+
                        '</td>'+ 
                        '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove2" style="color:#FFFFFF;"></a></td>'+
                        '</tr>';
                $('.tbody2').append(tr);
                };
                $('.tbody2').on('click','.remove2', function(){
            $(this).parent().parent().remove(); 
                        
            });
</script>

@endsection
