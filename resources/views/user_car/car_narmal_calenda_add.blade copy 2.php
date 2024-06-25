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
    <a href="{{url('user_car/car_calenda/'.Auth::user()->id)}}" class="btn btn-info btn-sm text-white me-2 mt-2">ปฎิทินการใช้รถ<span class="badge bg-danger ms-2">{{$count_bookrep_po}}</span></a>   
    <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">รถทั่วไป<span class="badge bg-danger ms-2">{{$count_bookrep_po}}</span></a>   
    <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="btn btn-light btn-sm text-dark me-2 mt-2">รถพยาบาล<span class="badge bg-danger ms-2">0</span></a> 
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
                        <div class="col-md-3 ">
                            <div class="card bg-info p-1 mx-0">
                                <div class="card-header px-3 py-2 text-white">
                                    รายการรถยนต์
                                </div>
                                <div class="card-body bg-white">
                                        <div class="row">                               
                                            @foreach ( $article_data as $items )   
                                                @if ($items->article_car_type_id == 2)
                                                    {{-- <div class="col-md-3 text-center"> --}}
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
                                        class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5">ทะเบียน {{$dataedits->article_register}}</span>
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
          {{-- <form id="saveMeetting" action="{{ route('user_car.car_narmal_calenda_save') }}" id="Carcalenda_save" method="POST">
              @csrf --}}
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">จองรถยนต์</h5> 
          </div>
          <div class="modal-body"> 
              <div class="row">
                  <div class="col-md-2 mt-2">
                      <label for="car_service_book">ตามหนังสือเลขที่ </label>
                  </div>
                  <div class="col-md-4 mt-2">
                      <div class="form-outline">
                          <input id="car_service_book" type="text" class="form-control" name="car_service_book">
                          <label class="form-label" for="car_service_book">ตามหนังสือเลขที่</label>
                      </div>
                  </div>
                  
                  <div class="col-md-1 mt-2">
                      <label for="car_service_year">ปีงบประมาณ </label>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <select name="car_service_year" id="car_service_year" class="form-control"
                              style="width: 100%;">
                              <option value="" selected>--เลือก--</option>
                              @foreach ($budget_year as $year)
                                  <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="col-md-3 mt-2"> </div>
                 
              </div>

              <div class="row ">
                    <div class="col-md-2 mt-2">
                        <label for="car_service_location">สถานที่ไป </label>
                    </div>
                    <div class="col-md-4 mt-2"> 
                        <div class="form-group">
                            <select name="car_service_location" id="car_service_location" class="form-control show_location" style="width: 100%;">
                            @foreach ($car_location as $itemlo)
                                <option value="{{ $itemlo->car_location_id}}">{{ $itemlo->car_location_name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 mt-2">
                        <label for="" style="color: rgb(255, 145, 0)">* กรณีไม่มี </label>
                    </div>
                    <div class="col-md-3 mt-2">
                        <div class="form-outline bga">
                            <input type="text" id="CAR_LOCATION_INSERT" name="CAR_LOCATION_INSERT" class="form-control shadow"/>
                            <label class="form-label" for="CAR_LOCATION_INSERT">เพิ่มสถานที่ไป</label>
                        </div> 
                    </div>
                    <div class="col-md-1 mt-2"> 

                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm" onclick="addlocation();">
                                เพิ่ม
                            </button> 
                        </div>
                    </div> 
              </div>

                <div class="row">
                        <div class="col-md-2 mt-2">
                            <label for="car_service_reason">เหตุผล </label>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="form-outline">
                                <input id="car_service_reason" type="text" class="form-control" name="car_service_reason">
                                <label class="form-label" for="meetting_title">เหตุผล</label>
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="car_service_length_godate">ตั้งแต่วันที่ </label>
                        </div> 
                        <div class="col-md-2 mt-2">
                            <div class="form-group">
                                <input id="car_service_length_godate" type="date" class="form-control"
                                    name="car_service_length_godate">
                            </div>
                        </div>
                        <div class="col-md-1 mt-2">
                            <label for="car_service_length_backdate">ถึงวันที่ </label>
                        </div>
                        
                        <div class="col-md-2 mt-2">
                            <div class="form-group">
                                <input id="car_service_length_backdate" type="date" class="form-control"
                                    name="car_service_length_backdate">
                            </div>
                        </div>
                       
                </div>

                <div class="row">
                    <div class="col-md-2 mt-2">
                        <label for="personjoin1">ผู้ร่วมเดินทางคนที่ 1 </label>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="form-outline">
                            <select name="personjoin1" id="personjoin1" class="form-control" style="width: 100%;">
                                <option value="">--เลือก--</option>
                                @foreach ($users as $item1)
                                    <option value="{{ $item1->id}}">{{ $item1->fname}}  {{ $item1->lname}}</option>
                                @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-1 mt-2">
                        <label for="car_service_length_gotime">ตั้งแต่เวลา </label>
                    </div> 
                    <div class="col-md-2 mt-2">
                        <div class="form-group">
                            <input id="car_service_length_gotime" type="time" class="form-control"
                              name="car_service_length_gotime">
                        </div>
                    </div>
                    <div class="col-md-1 mt-2">
                        <label for="car_service_length_backtime">ถึงเวลา </label>
                    </div>
                    
                    <div class="col-md-2 mt-2">
                        <div class="form-group">
                            <input id="car_service_length_backtime" type="time" class="form-control"
                            name="car_service_length_backtime">
                        </div>
                    </div>                   
            </div>

            <div class="row">
                <div class="col-md-2 mt-2">
                    <label for="personjoin2">ผู้ร่วมเดินทางคนที่ 2 </label>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-outline">
                        <select name="personjoin2" id="personjoin2" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item2)
                                    <option value="{{ $item2->id}}">{{ $item2->fname}}  {{ $item2->lname}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-md-2 mt-2">
                    <label for="personjoin6">ผู้ร่วมเดินทางคนที่ 6 </label>
                </div> 
                <div class="col-md-4 mt-2">
                    <div class="form-group">
                        <select name="personjoin6" id="personjoin6" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item6)
                                    <option value="{{ $item6->id}}">{{ $item6->fname}}  {{ $item6->lname}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="col-md-2 mt-2">
                    <label for="personjoin3">ผู้ร่วมเดินทางคนที่ 3 </label>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-outline">
                        <select name="personjoin3" id="personjoin3" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item3)
                                    <option value="{{ $item3->id}}">{{ $item3->fname}}  {{ $item3->lname}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-md-2 mt-2">
                    <label for="personjoin7">ผู้ร่วมเดินทางคนที่ 7 </label>
                </div> 
                <div class="col-md-4 mt-2">
                    <div class="form-group">
                        <select name="personjoin7" id="personjoin7" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item7)
                                    <option value="{{ $item7->id}}">{{ $item7->fname}}  {{ $item7->lname}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="col-md-2 mt-2">
                    <label for="personjoin4">ผู้ร่วมเดินทางคนที่ 4 </label>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-outline">
                        <select name="personjoin4" id="personjoin4" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item4)
                            <option value="{{ $item4->id}}">{{ $item4->fname}}  {{ $item4->lname}}</option>
                        @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-md-2 mt-2">
                    <label for="personjoin8">ผู้ร่วมเดินทางคนที่ 8 </label>
                </div> 
                <div class="col-md-4 mt-2">
                    <div class="form-group">
                        <select name="personjoin8" id="personjoin8" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item8)
                            <option value="{{ $item8->id}}">{{ $item8->fname}}  {{ $item8->lname}}</option>
                        @endforeach
                            </select>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-md-2 mt-2">
                    <label for="personjoin5">ผู้ร่วมเดินทางคนที่ 5 </label>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="form-outline">
                        <select name="personjoin5" id="personjoin5" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item5)
                                    <option value="{{ $item5->id}}">{{ $item5->fname}}  {{ $item5->lname}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
                <div class="col-md-2 mt-2">
                    <label for="personjoin9">ผู้ร่วมเดินทางคนที่ 9 </label>
                </div> 
                <div class="col-md-4 mt-2">
                    <div class="form-group">
                        <select name="personjoin9" id="personjoin9" class="form-control" style="width: 100%;">
                            <option value="">--เลือก--</option>
                            @foreach ($users as $item9)
                                    <option value="{{ $item9->id}}">{{ $item9->fname}}  {{ $item9->lname}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>                
            </div>
              


          </div>
          <input type="hidden" id="status" name="status" value="REQUEST">
          <input type="hidden" id="userid" name="userid" value="{{ Auth::user()->id }}">
        
          <div class="modal-footer">
             
              <button type="button" id="saveBtn" class="btn btn-primary btn-sm" >
                <i class="fa-solid fa-floppy-disk me-2"></i>
                บันทึก
            </button>
              <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">
                <i class="fa-solid fa-xmark me-2"></i>
                ปิด
            </button>
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
            $('#car_service_year').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#car_service_location').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin1').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin2').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin3').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin4').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin5').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin6').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin7').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin8').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#personjoin9').select2({
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
                select: function(start, end, allDays) {
                            console.log(start)
                        $('#carservicessModal').modal('toggle');
                        $('#choosebook').modal('toggle');
                        $('#closebtn').click(function() {
                          $('#carservicessModal').modal('hide');
                         });
                         $('#saveBtn').click(function() {                           
                            // alert('gggggg');
                            // var meettingtitle = $('#meetting_title').val();
                            // var status = $('#status').val();
                            // var meettingyear = $('#meetting_year').val();
                            // var meettingtarget = $('#meetting_target').val();
                            // var meettingpersonqty = $('#meetting_person_qty').val(); 
                            // var meetingobj = $('#meeting_objective_id').val();
                            // var meetingtel = $('#meeting_tel').val();
                            var userid = $('#userid').val();
                            // var roomid = $('#room_id').val();
                            // var timbegin = $('#meeting_time_begin').val();
                            // var timeend = $('#meeting_time_end').val();
                            // var sta_d = $('#startdate').val();
                            // var end_d = $('#enddate').val(); 
                            // var start_date = moment(start).format('YYYY-MM-DD');
                            // var end_date = moment(end).format('YYYY-MM-DD');

                            $.ajax({
                                url: "{{ route('meetting.calendar_save') }}",
                                type: "POST",
                                dataType: 'json',
                                data: { 
                                    userid
                                    // roomid,
                                    // timbegin,
                                    // timeend,
                                    // sta_d,
                                    // end_d
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
                                            confirmButtonText: 'เรียบร้อย'
                                        }).then((result) => {
                                            if (result
                                                .isConfirmed) {
                                                console.log(
                                                    response);
                                                $('#calendar')

                                                    // .fullCalendar(
                                                    //     'renderEvent', {
                                                    //         'title': response
                                                    //             .title,
                                                    //         'start': response
                                                    //             .start,
                                                    //         'end': response
                                                    //             .end,
                                                    //         'color': response
                                                    //             .color
                                                    //     });
                                                window.location
                                                    .reload();
                                            }
                                        })
                                    }
                                    // $('#meettingModal').modal('hide')

                                },                                
                            });
                        });
                },
                selectAllow: function(event) {
                            return moment(event.start).utcOffset(false).isSame(moment(event.end)
                                .subtract(1, 'second').utcOffset(false), 'day');
                },        
            });           
      });

     



  });
</script>


@endsection
