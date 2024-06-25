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

  {{-- @section('header')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"> 
        <div class="ps-3">
           
        </div>
        <div class="ms-auto">
            <div class="btn-group"> 
                <a href="{{url('user_car/car_calenda/'.Auth::user()->id)}}" class="btn btn-info text-white me-2">ปฎิทินการใช้รถ<i class="las la-signal me-2"></i></a>
                <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="btn btn-secondary me-2">รถทั่วไป<i class="las la-signal me-2"></i></a>
                <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="btn btn-secondary me-2">รถพยาบาล<i class="las la-signal me-4"></i></a>
            </div>
        </div>
    </div>
 
    @endsection --}}

    <div class="container-fluid">
        {{-- <div class="px-0 py-0">
          <div class="d-flex flex-wrap justify-content-center">
            <a href="{{url('user_car/car_calenda/'.Auth::user()->id)}}" class="btn btn-info btn-sm text-white me-2 mt-2">
                <i class="fa-solid fa-calendar-days me-1"></i>
                ปฎิทินการใช้รถ
            </a>
              <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="btn btn-secondary btn-sm text-white me-2 mt-2">
                <i class="fa-solid fa-car-side me-1"></i>
                รถทั่วไป
            </a>
              <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="btn btn-secondary btn-sm text-white me-2 mt-2">
                <i class="fa-solid fa-truck-medical me-1"></i>
                รถพยาบาล</a> 
              <div class="text-end"> 
                  
              </div>
          </div>
        </div> --}}
      <div class="row justify-content-center">
        <div class="row invoice-card-row">      
            <div class="col-md-3 mt-2">
                <div class="card bg-info p-1 mx-0 shadow-lg">
                    <div class="panel-header px-3 py-2 text-white">
                        รายการรถยนต์
                    </div>
                    <div class="panel-body bg-white ">
                        <div class="row">                               
                            @foreach ( $article_data as $items )   
                                @if ($items->article_car_type_id == 2)
                                <div class="col-6 col-md-6 col-xl-6 text-center mt-2">                                                 
                                            <div class="bg-image hover-overlay ripple ms-2 me-2">
                                                <a href="{{url('user_car/car_calenda_add/'.$items->article_id)}}">
                                                    <img src="{{asset('storage/article/'.$items->article_img)}}" height="150px" width="150px" alt="Image" class="img-thumbnail"> 
                                                        {{-- <div class="mask" style="background-color: rgba(12, 232, 248, 0.781);"></div> --}}
                                                        <br> 
                                                        <label for="" style="font-size: 11px;color:#FA2A0F">{{$items->article_register}}</label> 
                                                </a>                     
                                            </div>
                                    </div>
                                    
                                @else
                                <div class="col-6 col-md-6 col-xl-6 text-center mt-2">
                                            <div class="bg-image hover-overlay ripple ms-2 me-2">
                                                <a href="{{url('user_car/car_calenda_add/'.$items->article_id)}}">
                                                    <img src="{{asset('storage/article/'.$items->article_img)}}" height="150px" width="150px" alt="Image" class="img-thumbnail"> 
                                                        {{-- <div class="mask" style="background-color: rgba(247, 2, 2, 0.603);"></div> --}}
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
                <div class="card bg-info p-1 mx-0 shadow-lg">
                    <div class="panel-header text-left px-3 py-2 text-white">
                        ปฎิทินข้อมูลการใช้บริการรถยนต์<span
                            class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5"> </span>
                    </div>
                    <div class="panel-body bg-white">

                        <div id='calendar'></div>

                    </div>
                    <div class="panel-footer text-end pr-5 py-2 bg-white ">
                        <p class="m-0 fa fa-circle me-2" style="color:#3CDF44;"></p> อนุมัติ<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> จัดสรร<label
                                class="me-3"></label>
                                <p class="m-0 fa fa-circle me-2" style="color:#07D79E;"></p> จัดสรรร่วม<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#E80DEF;"></p> ไม่อนุมัติ<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#FA2A0F;"></p> แจ้งยกเลิก<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#ab9e9e;"></p> ยกเลิก<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#fa861a;"></p>ร้องขอ <label
                                class="me-5"></label>
                            
                    </div>
                </div>
            </div>                   
    </div>
</div>

<div class="modal fade" id="carservicessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    จองรถยนต์
                </h5>
                <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa-solid fa-circle-info text-white"></i>
                    รายละเอียด
                </button> 
            </div>
            <div class="modal-body">
                 <!-- Collapsed content -->
                    <div class="collapse mt-1 mb-2" id="collapseExample">             
                       
                                <div class="row">
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_book">ตามหนังสือเลขที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                         <input id="car_service_book" type="text" class="form-control input-rounded" name="car_service_book" > 
                                        </div>
                                    </div>
    
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_year">ปีงบประมาณ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            {{-- <input id="car_service_year" type="text" class="form-control input-rounded" name="car_service_year" >   --}}
                                            <select name="car_service_year" id="car_service_year" class="form-control form-control-sm"
                                            style="width: 100%;">
                                            <option value="" selected>--เลือก--</option>
                                            @foreach ($budget_year as $year)
                                                <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>    
                                </div>
    
                                <div class="row ">
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_location">สถานที่ไป </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_location" type="text" class="form-control input-rounded" name="car_service_location" >  
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_register">ทะเบียนรถยนต์ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_register" type="text" class="form-control input-rounded" name="car_service_register" >  
                                        </div>
                                    </div>
                                     
                                </div>
    
                                <div class="row">
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_reason">เหตุผล </label>
                                    </div>
                                    <div class="col-md-10 mt-3">
                                        <div class="form-outline">
                                            <input id="car_service_reason" type="text"
                                                class="form-control input-rounded" name="car_service_reason" >
    
                                        </div>
                                    </div>    
                                </div>
    
                                <div class="row">
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_date">ตั้งแต่วันที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_date" type="date"
                                                class="form-control input-rounded"
                                                name="car_service_date" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_date2">ถึงวันที่ </label>
                                    </div>
    
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_date2" type="date"
                                                class="form-control input-rounded"
                                                name="car_service_date2" >
                                        </div>
                                    </div>    
                                </div>
    
                                <div class="row"> 
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_gotime">ตั้งแต่เวลา </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_gotime" type="time"
                                                class="form-control input-rounded"
                                                name="car_service_length_gotime" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_backtime">ถึงเวลา </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_backtime" type="time"
                                                class="form-control input-rounded"
                                                name="car_service_length_backtime" >
                                                {{-- <input type="text" class="form-control timepicker" />
                                                <input class="result form-control" type="text" id="time" placeholder="Date Picker..."> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_gotime">พนักงานขับ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_userdrive_name" type="text"
                                                class="form-control input-rounded"
                                                name="car_service_userdrive_name" >
                                        </div>
                                    </div>                                     
                                </div>                           
                    </div>
             
                    <div class="row"> 
                        <form action="{{ route('po.po_carcalenda_allowpo') }}" method="POST" id="update_allowpoForm" enctype="multipart/form-data"> 
                            {{-- <form action="{{ route('po.po_carcalenda_allowpo') }}" method="POST" enctype="multipart/form-data">  --}}
                            @csrf
                                   
                                    <h3 class="mt-2 text-center">Digital Signature</h3>
                                    <div id="signature-pad" class="mt-2 text-center"> 
                                            <div style="border:solid 1px teal;height:120px;"> 
                                            <div id="note" onmouseover="my_function();" class="text-center">The
                                                signature should be inside box</div>
                                            <canvas id="the_canvas" width="320px" height="100px"></canvas>
                                        </div>
                                
                                        <input type="hidden" id="signature" name="signature">
                                        <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                        <input type="hidden" id="car_service_no" name="car_service_no" value="{{ $refnumber }}">   
                                        <input type="hidden" id="car_service_id" name="car_service_id">

                                        <button type="button" id="clear_btn"
                                        class="btn btn-secondary btn-sm mt-3 ms-3 me-2" data-action="clear"><span
                                            class="glyphicon glyphicon-remove"></span> Clear</button>
                                    
                                        <button type="button" id="save_btn"
                                        class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png"
                                        onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                        Create</button>
                                    
                                        <button type="submit" class="btn btn-success btn-sm mt-3 me-2">
                                            <i class="fa-solid fa-circle-check text-white me-2"></i>
                                            บันทึกข้อมูล
                                        </button>
                                
                                        <button type="button" class="btn btn-danger btn-sm mt-3 me-2" data-bs-dismiss="modal" id="closebtn">
                                            <i class="fa-solid fa-xmark me-2"></i>
                                            ปิด
                                        </button>
                                
                                        </div>
                                    </div>                                                                       
                    </div>
                </form> 
              

            </div>

        </div>
    </div>
</div>
</div>


@endsection
@section('footer') 
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 

<script> 
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("canvas");
    var el_note = document.getElementById("note");
    var signaturePad;
    signaturePad = new SignaturePad(canvas);
    clearButton.addEventListener("click", function (event) {
    document.getElementById("note").innerHTML="The signature should be inside box";
    signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function (event){
    if (signaturePad.isEmpty()){
        // alert("Please provide signature first.");
        Swal.fire(
                'กรุณาลงลายเซนต์ก่อน !',
                'You clicked the button !',
                'warning'
                )

        event.preventDefault();
    }else{
        var canvas  = document.getElementById("the_canvas");
        var dataUrl = canvas.toDataURL();
        document.getElementById("signature").value = dataUrl;

        // ข้อความแจ้ง
            Swal.fire({
                title: 'สร้างสำเร็จ',
                text: "You create success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',               
                confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
                if (result.isConfirmed) {}
            })  
    }
    });
    function my_function(){
    document.getElementById("note").innerHTML="";
        } 

</script>
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
                    select: function(start, end, allDays) {
                            console.log(start)
                            $('#carservicessModal').modal('toggle');
                            $('#closebtn').click(function() {
                                $('#carservicessModal').modal('hide');
                            });
                        },
                        editable: true,
                        eventDrop: function(event) {
                                console.log(event)
                            var id = event.id;
                            // var title = event.meetting_title;
                            var start_date = moment(event.start).format('YYYY-MM-DD');
                            var end_date = moment(event.end).format('YYYY-MM-DD');
                            // alert(id);
                            $.ajax({
                                    url:"{{ route('user_car.car_calenda_edit', '') }}" +'/'+ id,
                                    type:"PATCH",
                                    dataType:'json',
                                    data:{ start_date, end_date  },
                                    success:function(response)
                                    {
                                        console.log(response)
                                           
                                    }, 
                                    error:function(error)
                                {
                                    console.log(error)
                                },                                  
                            });
                        },
                        eventClick: function(event){
                            var id = event.id;
                            // var start_date = moment(event.start).format('YYYY-MM-DD');
                            if (id != '') {
                                //   alert(id);
                                $('#carservicessModal').modal('toggle');
                                    $.ajax({
                                        type: "GET",
                                        url:"{{url('car/car_narmal_editallocate')}}" +'/'+ id,  
                                        success: function(data) {
                                            console.log(data.carservice.car_service_book);
                                            $('#car_service_book').val(data.carservice.car_service_book)  
                                            $('#car_service_year').val(data.carservice.car_service_year) 
                                            $('#car_service_reason').val(data.carservice.car_service_reason) 
                                            $('#car_service_location').val(data.carservice.car_location_name)  
                                            $('#car_service_register').val(data.carservice.car_service_register)      
                                            $('#car_service_date').val(data.carservice.car_service_date)  
                                            $('#car_service_date2').val(data.carservice.car_service_date)  
                                            $('#car_service_length_gotime').val(data.carservice.car_service_length_gotime)  
                                            $('#car_service_length_backtime').val(data.carservice.car_service_length_backtime) 
                                            $('#car_service_userdrive_name').val(data.carservice.car_service_userdrive_name)   
                                            $('#car_service_id').val(data.carservice.car_service_id)       

                                        },   
                                    });
                            } else {
                                // alert('No');
                                //   $('#carservicessModal').modal('toggle');
                            }
                            
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
