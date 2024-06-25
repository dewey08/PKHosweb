@extends('layouts.user')
@section('title','ZOffice || ยานพาหนะ')
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
    use App\Http\Controllers\UsersuppliesController;
          use App\Http\Controllers\StaticController;
          use App\Models\Products_request_sub;
      
          $refnumber = UsersuppliesController::refnumber();    
          $checkhn = StaticController::checkhn($iduser);
          $checkhnshow = StaticController::checkhnshow($iduser);
          $count_suprephn = StaticController::count_suprephn($iduser);
          $count_bookrep_po = StaticController::count_bookrep_po();
    ?>
  @section('menu')
  <style>
        body{
            font-size:14px;
        }
        .btn{
          font-size:15px;
        }
        .bgc{
          background-color: #264886;
        }
        .bga{
            background-color: #FCFF9A;
          }
          .bgon{
            background-color: #FFF48F;
          }
        .boxpdf{
          /* height: 1150px; */
          height: auto;
        }
        .fpdf{
              width:auto;
              height:695px;
              /* height: auto; */
              margin:0;
              
              overflow:scroll;
              background-color: #FFFFFF;
          }
     
  </style>
      <div class="px-3 py-2 border-bottom">
          <div class="container d-flex flex-wrap justify-content-center">  
            <a href="{{url('user_car/car_calenda/'.Auth::user()->id)}}" class="btn btn-info btn-sm text-white me-2 mt-2"> ปฎิทินการใช้รถ<span class="badge bg-danger ms-2">{{$count_bookrep_po}}</span> </a>   
          <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2"> รถทั่วไป<span class="badge bg-danger ms-2">{{$count_bookrep_po}}</span> </a>   
          <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2"> รถพยาบาล<span class="badge bg-danger ms-2">0</span> </a> 
   
          <div class="text-end"> 
          </div>
          </div>
      </div>
  @endsection
  
  <div class="container-fluid " style="width: 97%">
    <div class="row">
 
        <div class="col-md-12">
            <div class="card shadow-lg">
              
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-info p-1 mx-0">
                                <div class="card-header px-3 py-2 text-white">
                                    รายการรถยนต์
                                </div>
                                <div class="card-body bg-white">
                                    <div class="row">                               
                                        @foreach ( $article_data as $items )   
                                            @if ($items->article_car_type_id == 2)
                                            <div class="col-6 col-md-6 col-xl-6 text-center mt-2">                                                 
                                                        <div class="bg-image hover-overlay ripple">
                                                            <a href="{{url('user_car/car_narmal_calenda_add/'.$items->article_id)}}">
                                                                <img src="{{asset('storage/car/'.$items->article_img)}}" height="150px" width="150px" alt="Image" class="img-thumbnail"> 
                                                                    <div class="mask" style="background-color: rgba(12, 232, 248, 0.781);"></div>
                                                                    <br> 
                                                                    <label for="" style="font-size: 11px">{{$items->article_register}}</label> 
                                                            </a>                     
                                                        </div>
                                                </div>
                                             
                                            @else
                                            <div class="col-6 col-md-6 col-xl-6 text-center mt-2">
                                                        <div class="bg-image hover-overlay ripple">
                                                            <a href="{{url('user_car/car_narmal_calenda_add/'.$items->article_id)}}">
                                                                <img src="{{asset('storage/car/'.$items->article_img)}}" height="150px" width="150px" alt="Image" class="img-thumbnail"> 
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
                        </div>  
                    </div>  
                        <div class="col-md-9 mt-2">
                            <div class="card bg-info p-1 mx-0">
                                <div class="panel-header text-left px-3 py-2 text-white">
                                    ปฎิทินข้อมูลการใช้บริการรถยนต์<span
                                        class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5"> </span>
                                </div>
                                <div class="panel-body bg-white">

                                    <div id='calendar'></div>

                                </div>
                                <div class="panel-footer text-end pr-5 py-2 bg-white ">
                                    <p class="m-0 fa fa-circle me-2" style="color:#A3DCA6;"></p> อนุมัติ<label
                                        class="me-3"></label>
                                    <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> จัดสรร<label
                                        class="me-3"></label>
                                    <p class="m-0 fa fa-circle me-2" style="color:#fa861a;"></p>ร้องขอ <label
                                        class="me-5"></label>
                                </div>
                            </div>
                        </div> 
                    </div>   

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="carservicessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          {{-- <form id="saveMeetting" action="{{ route('meetting.calendar_save') }}" method="POST">
              @csrf --}}
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">จองรถยนต์</h5>
              {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
          </div>
          <div class="modal-body">
              {{-- <input type="text" class="form-control" id="meetting_title" name="meetting_title">
                  <span id="meetting_title" class="text-danger"></span> --}}
              <div class="row">
                  <div class="col-md-2 text-end">
                      <label for="meetting_title">ตามหนังสือเลขที่ </label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-outline">
                          <input id="meetting_title" type="text" class="form-control" name="meetting_title">
                          <label class="form-label" for="meetting_title">ตามหนังสือเลขที่</label>
                      </div>
                  </div>
                  <div class="col-md-2 text-end">
                      <label for="meetting_year">ปีงบประมาณ </label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <select name="meetting_year" id="meetting_year" class="form-control"
                              style="width: 100%;">
                            
                          </select>
                      </div>
                  </div>
              </div>

              <div class="row mt-3">
                  <div class="col-md-2 text-end">
                      <label for="car_location_name">สถานที่ไป </label>
                  </div>
                  <div class="col-md-4"> 
                      <div class="form-group">
                        <select name="car_location_name" id="car_location_name" class="form-control show_location" style="width: 100%;">
                          @foreach ($car_location as $itemlo)
                            <option value="{{ $itemlo->car_location_id}}">{{ $itemlo->car_location_name}}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-md-2 text-end">
                    <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่มตรงนี้ </label>
                  </div>
                  <div class="col-md-3">
                    <div class="form-outline bga">
                        <input type="text" id="CAR_LOCATION_INSERT" name="CAR_LOCATION_INSERT" class="form-control shadow"/>
                        <label class="form-label" for="CAR_LOCATION_INSERT">เพิ่มสถานที่ไป</label>
                    </div> 
                  </div>
                  <div class="col-md-1"> 
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addlocation();">
                            เพิ่ม
                        </button> 
                    </div>
                </div> 
              </div>

              <div class="row mt-3">
                  <div class="col-md-2 text-end">
                      <label for="meeting_objective_id">เหตุผล </label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-outline">
                        <input id="meetting_person_qty" type="text" class="form-control" name="meetting_person_qty">
                        <label class="form-label" for="meetting_title">เหตุผล</label>
                      </div>
                  </div>
                  <div class="col-md-2 text-end">
                      <label for="meeting_tel">เบอร์โทร </label>
                  </div>
                  <div class="col-md-3">
                      <div class="form-outline">
                          <input id="meeting_tel" type="text"
                              class="form-control @error('meeting_tel') is-invalid @enderror" name="meeting_tel"
                              value="{{ Auth::user()->tel }}" autocomplete="meeting_tel">
                          @error('meeting_tel')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
              </div>

              <div class="row mt-3">
                  <div class="col-md-2 text-end">
                      <label for="meeting_time_begin">ตั้งแต่เวลา </label>
                  </div> 
                  <div class="col-md-2">
                      <div class="form-group">
                          <input id="meeting_time_begin" type="time" class="form-control"
                              name="meeting_time_begin">
                      </div>
                  </div>
                  <div class="col-md-1 text-end">
                      <label for="meeting_time_end">ถึงเวลา </label>
                  </div>
                  
                  <div class="col-md-2">
                      <div class="form-group">
                          <input id="meeting_time_end" type="time" class="form-control"
                              name="meeting_time_end">
                      </div>
                  </div>
              </div>


          </div>
          <input type="hidden" id="status" name="status" value="REQUEST">
          <input type="hidden" id="userid" name="userid" value="{{ Auth::user()->id }}">
        
          <div class="modal-footer">
              
              <button type="button" id="#saveBtn" class="btn btn-primary btn-sm" data-mdb-toggle="collapse"
              href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">ต่อไป</button>
              <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">ปิด</button>
          </div>

          <!-- Collapsed content -->
          <div class="collapse mt-3 mb-5" id="collapseExample">
                <div class="row text-center">
                      <div class="col-md-4 text-end">
                        <label for="meeting_time_begin">ผู้ร่วมเดินทาง :</label>
                      </div> 
                      <div class="col-md-3">
                        <div class="form-group">
                              <select name="meetting_year" id="meetting_year" class="form-control"
                              style="width: 100%;">
                            
                            </select>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <button type="button" id="closebtn" class="btn btn-primary btn-sm" >เพิ่มผู้ร่วมเดินทาง</button>
                      </div>
                      <div class="col-md-3">
                      </div>
                </div>
             
              <div class="row mt-3">
                    <div class="col-md-1"> </div>
                    <div class="col-md-10"> 
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"> 
                                <thead>
                                        <tr>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>11</td>
                                            <td>22</td>
                                            <td>33</td>
                                        </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-1"> </div>
              </div>


          </div>
         
          

      </div>
  </div>
</div>


@endsection
@section('footer') 
<script>
     function addlocation() {
        var locationnew = document.getElementById("CAR_LOCATION_INSERT").value; 
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{route('user_car.addlocation')}}",
            method: "POST",
            data: {
                locationnew: locationnew,
                _token: _token
            },
            success: function (result) {
                $('.show_location').html(result);
            }
        })
      }
</script>

<script>
  $(document).ready(function() {

            $('select').select2();
            $('#meetting_year').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#car_location_name').select2({
                dropdownParent: $('#carservicessModal')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           

      $(function() {

          var carservicess = @json($events);

          $('#calendar').fullCalendar({
            header: {
                        left: 'prev,next today', //  prevYear nextYea
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay',
                    },
              events: carservicess, 
              selectable: true,
                    selectHelper: true, 
            //   select: function(start, end, allDays) {
            //             console.log(start)
            //             $('#carservicessModal').modal('toggle');

            //             $('#closebtn').click(function() {

            //               $('#carservicessModal').modal('hide');
            //              });
            //   },
            //   selectAllow: function(event) {
            //             return moment(event.start).utcOffset(false).isSame(moment(event.end)
            //                 .subtract(1, 'second').utcOffset(false), 'day');
            //   },  
                           
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
