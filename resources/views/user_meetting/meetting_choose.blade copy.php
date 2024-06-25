@extends('layouts.user')
@section('title','ZOffice || ช้อมูลการจองห้องประชุม')
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
        <a href="{{url('user/meetting_dashboard/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2">dashboard</a>
        <a href="{{url('user/meetting_index/'.Auth::user()->id)}}" class="btn btn-info btn-sm text-white me-2">ช้อมูลการจองห้องประชุม</a> 
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
                  <div class="col-2">
                  </div>
                  <div class="col">
                    
                  </div>
                </div>
              </div>
                <div class="card-body"> 
                    <div class="row">
                          <div class="col-md-9">
                              <div class="row">  
                                  <div class="col-md-3 text-end">
                                      <label for="fname">เรื่องการประชุม :</label>
                                  </div>
                                  <div class="col-md-5">
                                      <div class="form-group">
                                          <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" autocomplete="fname">
                                          @error('fname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                  <div class="col-md-2 text-end">
                                      <label for="lname">ปีงบประมาณ :</label>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" autocomplete="lname">
                                          @error('lname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>                         
                                </div>  

                                <div class="row mt-3">  
                                  <div class="col-md-3 text-end">
                                      <label for="fname">กลุ่มบุคคลเป้าหมาย :</label>
                                  </div>
                                  <div class="col-md-5">
                                      <div class="form-group">
                                          <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" autocomplete="fname" >
                                          @error('fname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                  <div class="col-md-2 text-end">
                                      <label for="lname">จำนวน :</label>
                                  </div>
                                  <div class="col-md-1">
                                      <div class="form-group">
                                          <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" autocomplete="lname" >
                                          @error('lname')
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
                                      <label for="fname">วัตถุประสงค์การขอใช้ :</label>
                                  </div>
                                  <div class="col-md-5">
                                      <div class="form-group">
                                          <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" autocomplete="fname" >
                                          @error('fname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                  <div class="col-md-2 text-end">
                                      <label for="lname">เบอร์โทร :</label>
                                  </div>
                                  <div class="col-md-2">
                                      <div class="form-group">
                                          <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" autocomplete="lname" >
                                          @error('lname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div>                 
                                </div>  

                                <div class="row mt-3">  
                                  <div class="col-md-3 text-end">
                                      <label for="fname">ตั้งแต่วันที่ :</label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="fname" type="date" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" autocomplete="fname" >
                                          @error('fname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                  <div class="col-md-2 text-end">
                                      <label for="lname">ถึงวันที่ :</label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="lname" type="date" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" autocomplete="lname" >
                                          @error('lname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                </div> 

                                <div class="row mt-3">  
                                  <div class="col-md-3 text-end">
                                      <label for="fname">ตั้งแต่เวลา :</label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="fname" type="time" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" autocomplete="fname" >
                                          @error('fname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                  <div class="col-md-2 text-end">
                                      <label for="lname">ถึงเวลา :</label>
                                  </div>
                                  <div class="col-md-3">
                                      <div class="form-group">
                                          <input id="lname" type="time" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" autocomplete="lname" >
                                          @error('lname')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                      </div>
                                  </div> 
                                </div>

                            </div>
                          <div class="col-md-3">
                              <div class="bg-image hover-overlay ripple">
                                    <a href="#">
                                          <img src="{{asset('storage/meetting/'.$building_level_room->room_img)}}" height="450px" width="350px" alt="Image" class="img-thumbnail"> 
                                          <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                                    </a>                                
                              </div>
                          </div>
                    </div>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card-header shadow">
                                <label for="lname">อุปกรณ์ที่ต้องการ </label>
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
                                                <tr>
                                                    <td style="text-align: center;"> 1 </td>                                                
                                                    <td> 
                                                        <select name="meeting_list_id[]" id="MEETTING_LIST_ID0" class="form-control">
                                                            <option value="" selected>--รายการอุปกรณ์--</option> 
                                                            @foreach ($meeting_list as $list)
                                                                <option value="{{ $list -> meeting_list_id }}">{{ $list->meeting_list_name}}</option>
                                                            @endforeach                   
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                        <input name="meeting_list_qty[]" id="meeting_list_qty0" class="form-control">
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
                                <label for="lname">รายการอาหาร </label>
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
                                                        <select name="food_list_id[]" id="food_list_id[]" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                                                            <option value="">--รายการอาหาร--</option> 
                                                            @foreach ($food_list as $food)
                                                                <option value="{{ $food->food_list_id }}">{{$food->food_list_name}}</option>
                                                            @endforeach  
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                    <input name="food_list_qty[]" id="food_list_qty[]" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                                                    </td> 
                                                    <td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove2" style="color:#FFFFFF;"></a></td>
                                                </tr>                                                                 
                                        </tbody>   
                                    </table>
                                </div> 
                            </div>  
                        </div>

                    </div>
 
                </div>
            </div>
        </div>
    </div>
</div>

@include('/user/meetting_choose_modal')

<script>
    $(document).ready(function() {
        $('select').select2();
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
           '<select name="meeting_list_id[]" id="MEETTING_LIST_ID'+count+'" class="form-control">'+               
           '<option value="" selected>--รายการอุปกรณ์--</option>'+ 
           '@foreach ($meeting_list as $list)'+
           '<option value="{{ $list->meeting_list_id }}">{{$list->meeting_list_name}}</option>'+
           '@endforeach'+
           '</select> '+
           '</td>'+               
           '<td>'+
           '<input name="meeting_list_qty[]" id="meeting_list_qty'+count+'" class="form-control">'+
           '</td>'+ 
           '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;"></a></td>'+
           '</tr>';
   $('.tbody1').append(tr);
};

$('.tbody1').on('click','.remove1', function(){
       $(this).parent().parent().remove(); 
           
});
</script>
<script src="{{ asset('js/user_meetting.js') }}"></script>  
@endsection
