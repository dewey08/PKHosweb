@extends('layouts.user')
@section('title','ZOffice || รถทั่วไป')
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
  <div class="px-0 py-0 mb-2">
    <div class="d-flex flex-wrap justify-content-center">  
      <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>
    
      <div class="text-end">
        {{-- <a href="{{url('user_car/car_dashboard/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2">dashboard</a> --}}
        <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลการใช้รถทั่วไป</a>
        <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2">ข้อมูลการใช้รถพยาบาล</a> 
        <a href="" class="btn btn-info btn-sm text-white me-2">เลือกรถที่ต้องการ</a> 
      </div>
    </div>
  </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">  
                  </div>
                  <div class="col-9">
                  </div>
                  <div class="col">
                    {{-- <a href="{{ url('user_meetting/meetting_add/'.Auth::user()->id )}}" class="btn btn-primary btn-sm"> <i class="fa-solid fa-circle-plus me-1"></i> จองรถ</a> --}}
                  </div>
                </div>
              </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                  @foreach ( $article_data as $items )   
                                      @if ($items->article_car_type_id == 2)
                                          <div class="col-md-3 mt-3 text-center">
                                                <div class="bg-image hover-overlay ripple">
                                                      <a href="{{url('user_car/car_narmal_calenda_add/'.$items->article_id)}}">
                                                            <img src="{{asset('storage/car/'.$items->article_img)}}" height="350px" width="250px" alt="Image" class="img-thumbnail"> 
                                                            <div class="mask" style="background-color: rgba(12, 232, 248, 0.781);"></div>
                                                            <br> 
                                                            <label for="" style="font-size: 11px">{{$items->article_register}}</label> 
                                                      </a>                     
                                                </div>
                                               
                                          </div>
                                      @else
                                          <div class="col-md-3 mt-3 text-center">
                                                <div class="bg-image hover-overlay ripple">
                                                      <a href="{{url('user_car/car_narmal_calenda_add/'.$items->article_id)}}">
                                                            <img src="{{asset('storage/car/'.$items->article_img)}}" height="350px" width="250px" alt="Image" class="img-thumbnail"> 
                                                            <div class="mask" style="background-color: rgba(247, 2, 2, 0.603);"></div>
                                                            <br> 
                                                            <label for="" style="font-size: 11px">{{$items->article_register}}</label> 
                                                      </a>                                                                                     
                                                </div> 
                                          </div>                                
                                      @endif
                                  @endforeach  
                                </div>  
                            </div>  
                        <div class="col-md-8">
                            <div id='calendar'></div>
                        </div> 
                    </div>   

                </div>
            </div>
        </div>
    </div>
</div>
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
  });
//   $(document).on('click','.edit_detail',function(){
//    var meeting_id = $(this).val();
//    // alert(meeting_id);
//    $('#detailModal').modal('show'); 
//    $.ajax({
//      type: "GET",
//      // url: "/zoffice/public/user_meetting/meetting_detail/"+ meeting_id, // กรณีอยู่บนคลาวให้ใส่พาทให้ด้วย
//      url: "/user_meetting/meetting_detail/"+ meeting_id,  //ทำในคอมตัวเอง
//      success: function(data) {
//          console.log(data.mservice.meetting_title);
//          $('#meetting_title').val(data.mservice.meetting_title)  
//          $('#meeting_date_begin').val(data.mservice.meeting_date_begin) 
//          $('#meeting_date_end').val(data.mservice.meeting_date_end) 
//          $('#meetting_yearde').val(data.mservice.meetting_year) 
//          $('#meetting_target').val(data.mservice.meetting_target) 
//          $('#meetting_person_qty').val(data.mservice.meetting_person_qty) 
//          $('#meeting_tel').val(data.mservice.meeting_tel) 
//          $('#meeting_time_begin').val(data.mservice.meeting_time_begin) 
//          $('#meeting_time_end').val(data.mservice.meeting_time_end) 
//          $('#meeting_objective_name').val(data.mservice.meeting_objective_name) 
//          $('#meeting_user_name').val(data.mservice.meeting_user_name) 
//          $('#room_name').val(data.mservice.room_name) 
//          $('#meeting_id').val(data.mservice.meeting_id)                
//      },      
//  });

//  $('#closebtn').click(function() {
//    $('#detailModal').modal('hide');
//  });
//  $('#closebtnx').click(function() {
//    $('#detailModal').modal('hide');
//  });
// });
</script>


@endsection
