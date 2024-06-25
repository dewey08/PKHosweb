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
  {{-- <div class="px-0 py-0 mb-2">
    <div class="d-flex flex-wrap justify-content-center">  
      <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>
    
      <div class="text-end"> 
        <a href="{{url('user_meetting/meetting_calenda')}}" class="btn btn-light btn-sm text-dark me-2">ปฎิทิน</a>
        <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-light btn-sm text-dark me-2">ช้อมูลการจองห้องประชุม</a> 
        <a href="#" class="btn btn-info btn-sm text-white me-2">จองห้องประชุม</a> 
      </div>
    </div>
  </div> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg">
              {{-- {{$building_level_room->room_name}}    --}}
              <div class="card-header">
                <div class="row">
                  <div class="col"> 
                    บันทึกขอใช้ห้องประชุม วันที่ {{dateThaifromFull($date)}} <label for="" style="color: rgb(255, 0, 0)">  {{$dataedits->room_name}}</label> 
                  </div>
                  <div class="col-1">
                  </div>
                  <div class="col">
                    {{-- <label for="" style="color: rgb(255, 0, 0)">  {{$dataedits->room_name}}</label>  --}}
                  </div>
                </div>
              </div>
                <div class="card-body"> 
                    <form class="custom-validation" action="{{ route('meetting.meetting_choose_lineupdate') }}" id="insert_chooselineupdateForm" method="POST" enctype="multipart/form-data">
                        @csrf


                    <div class="row">
                        <div class="col-md-6">
                            <div id='calendar'></div>
                        </div> 
                          <div class="col-md-6">                           
                            
                            <input type="hidden" id="room_id" name="room_id" value="{{$dataedits->room_id}}" > 
                            <input type="hidden" id="status" name="status" value="REQUEST">
                            <input type="hidden" id="userid" name="userid" value="{{Auth::user()->id}}">
                            <input type="hidden" id="meeting_id" name="meeting_id" value="{{$dataedits->meeting_id}}" > 

                            <div class="row"> 
                                <div class="col-md-3 text-end">
                                    <label for="meetting_title">เรื่องการประชุม </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input id="meetting_title" type="text" class="form-control @error('meetting_title') is-invalid @enderror az" name="meetting_title" value="{{ $dataedits->meetting_title }}" autocomplete="meetting_title">
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
                                        <input id="meetting_target" type="text" class="form-control @error('meetting_target') is-invalid @enderror az" name="meetting_target" value="{{  $dataedits->meetting_target}}" autocomplete="meetting_target" >
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
                                          @if ($dataedits->meeting_objective_id == $listobj->meeting_objective_id )
                                          <option value="{{ $listobj->meeting_objective_id }}" selected>{{ $listobj->meeting_objective_name}}</option>
                                          @else
                                          <option value="{{ $listobj->meeting_objective_id }}">{{ $listobj->meeting_objective_name}}</option>
                                          @endif
                                              
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
                                          @if ($dataedits->meetting_year == $year->leave_year_id)
                                          <option value="{{ $year->leave_year_id }}" selected>{{ $year->leave_year_id}}</option>
                                          @else
                                          <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id}}</option>
                                          @endif
                                              
                                          @endforeach                   
                                      </select>
                                    </div>
                                </div>     
                                <div class="col-md-2 text-end">
                                    <label for="meetting_person_qty">จำนวน :</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="meetting_person_qty" type="text" class="form-control @error('meetting_person_qty') is-invalid @enderror az" name="meetting_person_qty" value="{{ $dataedits->meetting_person_qty}}" autocomplete="meetting_person_qty" >
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
                                        <input id="meeting_date_begin" type="date" class="form-control @error('meeting_date_begin') is-invalid @enderror az" name="meeting_date_begin" value="{{ $dataedits->meeting_date_begin }}" autocomplete="meeting_date_begin">
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
                                        <input id="meeting_date_end" type="date" class="form-control @error('meeting_date_end') is-invalid @enderror az" name="meeting_date_end" value="{{ $dataedits->meeting_date_end }}" autocomplete="meeting_date_end">
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
                                        <input id="meeting_time_begin" type="time" class="form-control @error('meeting_time_begin') is-invalid @enderror az" name="meeting_time_begin" value="{{ $dataedits->meeting_time_begin }}" autocomplete="meeting_time_begin" >
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
                                        <input id="meeting_time_end" type="time" class="form-control @error('meeting_time_end') is-invalid @enderror az" name="meeting_time_end" value="{{ $dataedits->meeting_time_end }}" autocomplete="meeting_time_end" >
                                        @error('meeting_time_end')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> 
                              </div>

                              

                             <!-- <div class="row mt-3">  
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
                              </div> -->

                              <div class="row mt-3">  
                                <div class="col-md-3 text-end">
                                    <label for="meeting_tel">เบอร์โทร </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input id="meeting_tel" type="text" class="form-control az" name="meeting_tel" value="{{ $dataedits->meeting_tel }}">
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
                    <div class="row mt-3 mb-5">
                        <div class="col-md-6">
                            <div class="card-header shadow">
                                <label for="">อุปกรณ์ที่ต้องการ </label>
                            </div> 
                            <div class="card-body shadow">
                                <div class="table-responsive">
                                    <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                        <thead>
                                            <tr style="background-color: rgb(173, 247, 250)">
                                                <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                <td style="text-align: center;">รายการอุปกรณ์</td>                                                                      
                                                <td style="text-align: center;" width="12%">จำนวน</td>                                                   
                                                <td style="text-align: center;" width="7%">
                                                    <a class="btn btn-sm btn-success addRow" style="color:#FFFFFF;"><i class="fas fa-plus" ></i></a>
                                                </td>
                                            </tr>
                                        </thead> 
                                        <tbody class="tbody1"> 
                                            @foreach ($meeting_service_list as $key=>$serlist)   
                                                <tr height="30" >  
                                                    <td style="text-align: center;"> {{$key+1}} </td>                                           
                                                    <td>
                                                        <select name="MEETTINGLIST_ID[]" id="MEETTING_LIST_ID0" class="form-control form-control-sm " style="width: 100%;">
                                                            <option value="" selected ><label class="az">--รายการอุปกรณ์--</label></option> 
                                                            @foreach ($meeting_list as $list)
                                                            @if ($serlist->meeting_list_id ==$list ->meeting_list_id)
                                                            <option value="{{$list ->meeting_list_id }}" selected ><label class="az">{{ $list->meeting_list_name}}</label></option>
                                                            @else
                                                            <option value="{{$list ->meeting_list_id }}"><label class="az">{{ $list->meeting_list_name}}</label></option>
                                                            @endif
                                                                
                                                            @endforeach                   
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                        <input name="MEETTINGLIST_QTY[]" id="MEETTINGLIST_QTY0" class="form-control form-control-sm" value="{{ $serlist->meeting_service_list_qty }}">
                                                    </td>                                               
                                                    <td style="text-align: center;">
                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;">
                                                        </a>
                                                    </td>
                                                </tr>    
                                                @endforeach 
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
                                            <tr style="background-color: rgb(173, 247, 250)">
                                                <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                <td style="text-align: center;">รายการอาหาร</td>                                                                      
                                                <td style="text-align: center;" width="10%">จำนวน</td>                                                    
                                                <td style="text-align: center;" width="7%"><a  class="btn btn-sm btn-success addRow2" style="color:#FFFFFF;"><i class="fas fa-plus" ></i></a></td>
                                            </tr>
                                        </thead> 
                                        <tbody class="tbody2"> 
                                            @foreach ($meeting_service_food as $key=>$foodlist)   
                                                <tr height="30" >  
                                                    <td style="text-align: center;"> {{$key+1}} </td>                                                
                                                    <td> 
                                                        <select name="FOOD_LIST_ID[]" id="FOOD_LIST_ID0" class="form-control form-control-sm " style="width: 100%;">
                                                            <option value="" selected class="myFontselect">--รายการอาหาร--</option> 
                                                            @foreach ($food_list as $food)
                                                            @if ($foodlist->food_list_id ==  $food->food_list_id)
                                                            <option value="{{ $food->food_list_id }}" selected class="myFontselect">{{$food->food_list_name}}</option>
                                                            @else
                                                            <option value="{{ $food->food_list_id }}">{{$food->food_list_name}}</option>
                                                            @endif
                                                                
                                                            @endforeach  
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                    <input name="FOOD_LIST_QTY[]" id="FOOD_LIST_QTY0" class="form-control form-control-sm"  value="{{ $foodlist->meeting_service_food_qty }}">
                                                    </td> 
                                                    <td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove2" style="color:#FFFFFF;"></a></td>
                                                </tr>  
                                            @endforeach                                                               
                                        </tbody>   
                                    </table>
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
                                <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-danger btn-sm">
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
               
        $('select').select2({ 
            // templateResult: formatOutput,
            // dropdownCssClass: "myFont" 
        });
        // $('.select-results__option').css('font-weight', 'bold');

        // function formatOutput (optionElement) {
        //     if (!optionElement.id) { return optionElement.text; }
        //     var $state = $(
        //         '<span><strong>' + optionElement.element.value + '</strong> ' + optionElement.text + '</span>'
        //     );
        //     return $state;
        //     };

        });
    
            $('.addRow').on('click',function(){
                addRow();
                $('select').select2({ 
                    // dropdownCssClass: "myFont" 
                    // templateResult: formatOutput
                });
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
