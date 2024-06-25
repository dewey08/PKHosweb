@extends('layouts.user')
@section('title', 'ZOffice || ยานพาหนะ')
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
    use App\Http\Controllers\UsercarController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    
    $refnumber = UsercarController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
    ?>


    {{-- <div class="container-fluid "> --}}
    {{-- <div class="px-0 py-0">
      <div class="d-flex flex-wrap justify-content-center "> 
        <a href="{{url('user_car/car_calenda/'.Auth::user()->id)}}" class="btn btn-secondary btn-sm text-white me-1 mt-2">
          <i class="fa-solid fa-calendar-days me-1"></i>
          ปฎิทินการใช้รถ
      </a>
        <a href="{{url('user_car/car_narmal/'.Auth::user()->id)}}" class="btn btn-secondary btn-sm text-white me-1 mt-2">
          <i class="fa-solid fa-car-side me-1"></i>
          รถทั่วไป
      </a>
        <a href="{{url('user_car/car_ambulance/'.Auth::user()->id)}}" class="btn btn-info btn-sm text-white me-1 mt-2">
          <i class="fa-solid fa-truck-medical me-1"></i>
          รถพยาบาล</a>
        
      </div>
  </div> --}}
    <div class="container-fluid">
        <div class="row invoice-card-row">
            <div class="col-md-3 mt-2">
                <div class="card bg-info p-1 mx-0 shadow-lg">
                    <div class="panel-body px-3 py-2 text-white">
                        รายการรถยนต์ <span class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5">
                            <a href="{{ url('user_car/car_calenda/' . Auth::user()->id) }}"
                                class="btn btn-white btn-sm text-end">
                                <i class="fa-solid fa-circle-check text-white text-success"></i>
                                ทั้งหมด
                            </a>
                    </div>
                    <div class="panel-body bg-white shadow-lg">
                        <div class="row">
                            @foreach ($article_data as $items)
                                @if ($items->article_car_type_id == 2)
                                    {{-- <div class="col-md-3 text-center"> --}}
                                    <div class="col-6 col-md-6 col-xl-6 text-center mt-2">
                                        <div class="bg-image hover-overlay ripple ms-2 me-2">
                                            <a href="{{ url('user_car/car_calenda_add/' . $items->article_id) }}">
                                                <img src="{{ asset('storage/article/' . $items->article_img) }}"
                                                    height="150px" width="150px" alt="Image" class="img-thumbnail">
                                                {{-- <div class="mask" style="background-color: rgba(12, 232, 248, 0.781);"></div> --}}
                                                <br>
                                                <label for=""
                                                    style="font-size: 11px;color:#FA2A0F">{{ $items->article_register }}</label>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-6 col-md-6 col-xl-6 text-center mt-2">
                                        <div class="bg-image hover-overlay ripple ms-2 me-2">
                                            <a href="{{ url('user_car/car_calenda_add/' . $items->article_id) }}">
                                                <img src="{{ asset('storage/article/' . $items->article_img) }}"
                                                    height="150px" width="150px" alt="Image" class="img-thumbnail">
                                                {{-- <div class="mask" style="background-color: rgba(247, 2, 2, 0.603);"></div> --}}
                                                <br>
                                                <label for=""
                                                    style="font-size: 11px">{{ $items->article_register }}</label>
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
                        ปฎิทินข้อมูลการใช้บริการรถยนต์<span class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5">ทะเบียน
                            {{ $dataedits->article_register }}</span>
                    </div>
                    <div class="panel-body bg-white">

                        <div id='calendar'></div>

                    </div>
                    <div class="panel-footer text-end pr-5 py-2 bg-white ">
                        <p class="m-0 fa fa-circle me-2" style="color:#3CDF44;"></p> อนุมัติ<label class="me-3"></label>
                        <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> จัดสรร<label class="me-3"></label>
                        <p class="m-0 fa fa-circle me-2" style="color:#07D79E;"></p> จัดสรรร่วม<label
                            class="me-3"></label>
                        <p class="m-0 fa fa-circle me-2" style="color:#E80DEF;"></p> ไม่อนุมัติ<label
                            class="me-3"></label>
                        <p class="m-0 fa fa-circle me-2" style="color:#FA2A0F;"></p> แจ้งยกเลิก<label
                            class="me-3"></label>
                        <p class="m-0 fa fa-circle me-2" style="color:#ab9e9e;"></p> ยกเลิก<label class="me-3"></label>
                        <p class="m-0 fa fa-circle me-2" style="color:#fa861a;"></p>ร้องขอ <label class="me-5"></label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

<!-- Insert --> 
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
                                            <select name="car_service_year" id="car_service_year" class="form-control form-control-sm" style="width: 100%;"> 
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
                                            <select name="car_service_location" id="car_service_location" class="form-control form-control-sm show_location" style="width: 100%;">
                                            @foreach ($car_location as $itemlo)                                            
                                                <option value="{{ $itemlo->car_location_id }}" > {{ $itemlo->car_location_name }}</option>
                                            @endforeach
                                        </select>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="" style="color: rgb(255, 145, 0)">* กรณีไม่มี </label>
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <div class="form-outline bga">
                                            <input type="text" id="CAR_LOCATION_INSERT" name="CAR_LOCATION_INSERT"
                                                class="form-control form-control-sm shadow"
                                                placeholder="เพิ่มสถานที่ไป" />
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="addlocation();">
                                                เพิ่ม
                                            </button>
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
                                        <label for="car_service_length_godate">ตั้งแต่วันที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_godate" type="date"
                                                class="form-control input-rounded"
                                                name="car_service_length_godate" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_backdate">ถึงวันที่ </label>
                                    </div>
    
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_backdate" type="date"
                                                class="form-control input-rounded"
                                                name="car_service_length_backdate" >
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
                                        </div>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="col-md-12 mt-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                                id="crud_table">
                                                <thead>
                                                    <tr>
                                                        <th> ผู้ร่วมเดินทาง ชื่อ-สกุล</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody">
                                                    <tr>
                                                        <td>
                                                            <select name="person_join_id" id="person_join_id" class="form-control"
                                                                multiple="multiple" style="width: 100%;">
                                                                <option>--เลือก--</option>
                                                                @foreach ($users as $item1)
                                                                    <option value="{{ $item1->id }}" class="person_join_id">
                                                                        {{ $item1->fname }} {{ $item1->lname }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>            
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                                    
                    </div>
             
                    <div class="row"> 
                       
                                   
                                    <h3 class="mt-1 text-center">Digital Signature</h3>
                                    <div id="signature-pad" class="mt-2 text-center"> 
                                            <div style="border:solid 1px teal;height:120px;"> 
                                            <div id="note" onmouseover="my_function();" class="text-center">The
                                                signature should be inside box</div>
                                            <canvas id="the_canvas" width="320px" height="120px"></canvas>
                                        </div>
                                
                                        <input type="hidden" id="signature" name="signature">
                                        <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                        <input type="hidden" id="car_service_no" name="car_service_no" value="{{$refnumber}}">   
                                        <input type="hidden" id="car_service_id" name="car_service_id">
                                        <input type="hidden" id="car_service_article_id" name="car_service_article_id" value="{{$dataedits->article_id}}">
                                        
                                        <button type="button" id="clear_btn"
                                        class="btn btn-secondary btn-sm mt-3 ms-3 me-2" data-action="clear"><span
                                            class="glyphicon glyphicon-remove"></span> Clear</button>
                                    
                                        <button type="button" id="save_btn"
                                        class="btn btn-info btn-sm mt-3 me-2 text-white" data-action="save-png"
                                        onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                        Create</button>
                                    
                                        <button type="button" id="saveBtn" class="btn btn-success btn-sm mt-3 me-2">
                                            <i class="fa-solid fa-circle-check text-white me-2"></i>
                                            บันทึกข้อมูล
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm mt-3 me-2" data-bs-dismiss="modal" id="closebtn">
                                        {{-- <button type="button" class="btn btn-danger btn-sm mt-3 me-2" id="closebtn"> --}}
                                            <i class="fa-solid fa-xmark me-2"></i>
                                            ปิด
                                        </button>
                                
                                        </div>
                                    </div>                                                                       
                    </div>
                            

            </div>

        </div>
    </div>
</div>
</div>

<!-- Update -->
<div class="modal fade" id="EditcarservicessModal" tabindex="-1" aria-labelledby="EditcarservicessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditcarservicessModalLabel">
                    แก้ไขการจองรถยนต์
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
                                        <label for="car_service_book2">ตามหนังสือเลขที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                         <input id="car_service_book2" type="text" class="form-control input-rounded" name="car_service_book2" > 
                                        </div>
                                    </div>
    
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_year2">ปีงบประมาณ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group"> 
                                            <select name="car_service_year2" id="car_service_year2" class="form-control form-control-sm" style="width: 100%;"> 
                                            @foreach ($budget_year as $year)
                                                <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>    
                                </div>                                  

                                <div class="row ">
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_location2">สถานที่ไป </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <select name="car_service_location2" id="car_service_location2" class="form-control form-control-sm show_location" style="width: 100%;">
                                            @foreach ($car_location as $itemlo)                                            
                                                <option value="{{ $itemlo->car_location_id }}" > {{ $itemlo->car_location_name }}</option>
                                            @endforeach
                                        </select>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="" style="color: rgb(255, 145, 0)">* กรณีไม่มี </label>
                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <div class="form-outline bga">
                                            <input type="text" id="CAR_LOCATION_INSERT" name="CAR_LOCATION_INSERT"
                                                class="form-control form-control-sm shadow"
                                                placeholder="เพิ่มสถานที่ไป" />
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="addlocation();">
                                                เพิ่ม
                                            </button>
                                        </div>
                                    </div>
                                     
                                </div>
    
                                <div class="row">
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_reason2">เหตุผล </label>
                                    </div>
                                    <div class="col-md-10 mt-3">
                                        <div class="form-outline">
                                            <input id="car_service_reason2" type="text"
                                                class="form-control input-rounded" name="car_service_reason2" >    
                                        </div>
                                    </div>    
                                </div>

                                 <div class="row">
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_godate2">ตั้งแต่วันที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_godate2" type="date"
                                                class="form-control input-rounded"
                                                name="car_service_length_godate2" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_backdate2">ถึงวันที่ </label>
                                    </div>
    
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_backdate2" type="date"
                                                class="form-control input-rounded"
                                                name="car_service_length_backdate2" >
                                        </div>
                                    </div>    
                                </div> 
                                   
                                <div class="row"> 
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_gotime2">ตั้งแต่เวลา </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_gotime2" type="time"
                                                class="form-control input-rounded"
                                                name="car_service_length_gotime2" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="car_service_length_backtime2">ถึงเวลา </label>
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <div class="form-group">
                                            <input id="car_service_length_backtime2" type="time"
                                                class="form-control input-rounded"
                                                name="car_service_length_backtime2" >                                              
                                        </div>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="col-md-12 mt-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                                id="crud_table">
                                                <thead>
                                                    <tr>
                                                        <th> ผู้ร่วมเดินทาง ชื่อ-สกุล</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody">
                                                    <tr>
                                                        <td>
                                                            <select name="person_join_id2" id="person_join_id2" class="form-control"
                                                                multiple="multiple" style="width: 100%;">
                                                                <option>--เลือก--</option>
                                                                @foreach ($users as $item1)
                                                                    <option value="{{ $item1->id }}" class="person_join_id">
                                                                        {{ $item1->fname }} {{ $item1->lname }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>            
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>  
                                

                                <input type="hidden" id="user_id2" name="user_id2" value=" {{ Auth::user()->id }}">
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                <input type="text" id="car_service_no2" name="car_service_no2" >   
                                <input type="hidden" id="car_service_id2" name="car_service_id2">
                                <input type="hidden" id="car_service_article_id2" name="car_service_article_id2">


                                <div class="row"> 
                                    <div class="col">

                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="saveBtn2" class="btn btn-success btn-sm mt-3 me-2">
                                            <i class="fa-solid fa-circle-check text-white me-2"></i>
                                            แก้ไขข้อมูล
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm mt-3 me-2" data-bs-dismiss="modal" id="closebtn"> 
                                            <i class="fa-solid fa-xmark me-2"></i>
                                            ปิด
                                        </button>
                                    </div>
                                    
                                    <div class="col">

                                    </div>

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
        clearButton.addEventListener("click", function(event) {
            document.getElementById("note").innerHTML = "The signature should be inside box";
            signaturePad.clear();
        });
        savePNGButton.addEventListener("click", function(event) {
            if (signaturePad.isEmpty()) {
                // alert("Please provide signature first.");
                Swal.fire(
                'กรุณาลงลายเซนต์ก่อน !',
                'You clicked the button !',
                'warning'
                )
                event.preventDefault();
            } else {
                var canvas = document.getElementById("the_canvas");
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

        function my_function() {
            document.getElementById("note").innerHTML = "";
        }
    </script>


    <script>
        function addlocation() {
            var locationnew = document.getElementById("CAR_LOCATION_INSERT").value;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('user_car.addlocation') }}",
                method: "POST",
                data: {
                    locationnew: locationnew,
                    _token: _token
                },
                success: function(result) {
                    $('.show_location').html(result);
                }
            })
        }
    </script>

    <script>
        $(document).ready(function() {
            // $('.js-example-basic-multiple').select2();
            $('#mySelect2').select2({
                dropdownParent: $('#carservicessModal')
            });

            $('select').select2();
            $('#car_service_year').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#car_service_location').select2({
                dropdownParent: $('#carservicessModal')
            });
            $('#person_join_id').select2({
                dropdownParent: $('#carservicessModal')
            });

            $('#car_service_year2').select2({
                dropdownParent: $('#EditcarservicessModal')
            });
            $('#car_service_location2').select2({
                dropdownParent: $('#EditcarservicessModal')
            });
            $('#person_join_id2').select2({
                dropdownParent: $('#EditcarservicessModal')
            });

            $('#songs').select2({
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
                    // timeZone: 'Asia/Bangkok',                    
                 
                    header: {
                        left: 'prev,next today', //  prevYear nextYea
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay',
                    },
                    
                    // navLinks: true, // can click day/week names to navigate views                   
                    // timeFormat: 'H:mm',
                    // displayEventTime: true,
                    // displayEventTime: false,                
                    editable: true,                  
                    selectable: true,
                    selectHelper: true,
                    dayMaxEvents: true, // allow "more" link when too many events
                    events: carservicess,
                    select: function(start, end, allDays) {   
                        $('#carservicessModal').modal('toggle');
                        $('#choosebook').modal('toggle');
                        $('#closebtn').click(function() {
                            $('#carservicessModal').modal('hide');
                        });
                        
                            var initialTimeZone = "Asia/Bangkok";
                            var timeZoneSelectorEl = document.getElementById("calendar");
                            var calendarEl = document.getElementById("calendar");
                            var todayDate = moment().startOf("day");
                            var YM = todayDate.format("YYYY-MM");
                            var YESTERDAY = todayDate.clone().subtract(1, "day").format("YYYY-MM-DD");
                            var TODAY = todayDate.format("YYYY-MM-DD");
                            var TOMORROW = todayDate.clone().add(1, "day").format("YYYY-MM-DD");

                            var start_date = moment(start).format('YYYY-MM-DD HH:mm','Asia/Bangkok') 
                            var end_date = moment(end).format('YYYY-MM-DD HH:mm','Asia/Bangkok');
                            
                            // var start_c = $.fullCalendar.formatDate(start,'YYYY-MM-DD HH:mm');
                            // var end_c = $.fullCalendar.formatDate(end,'YYYY-MM-DD HH:mm');
                             
                        // alert(end_date);

                        $('#saveBtn').click(function() {
                            
                            var person_join_id = $('#person_join_id').val(); // aray mutiselect2
                           
                            var userid = $('#user_id').val();
                            var car_service_book = $('#car_service_book').val();
                            var car_service_year = $('#car_service_year').val();
                            var car_service_location = $('#car_service_location').val();
                            var car_service_reason = $('#car_service_reason').val();
                            var car_service_length_godate = $('#car_service_length_godate').val();
                            var car_service_length_backdate = $('#car_service_length_backdate').val();
                            var car_service_length_gotime = $('#car_service_length_gotime').val();
                            var car_service_length_backtime = $('#car_service_length_backtime').val();
                            var car_service_article_id = $('#car_service_article_id').val();
                            var car_service_no = $('#car_service_no').val();
                            var start_date = moment(start).format('YYYY-MM-DD','UTC');
                            var end_date = moment(end).format('YYYY-MM-DD');  
                            var signature = $('#signature').val();
                            var user_id = $('#user_id').val(); 
                            // var start_date = moment(start).format('YYYY-MM-DD');
                            // var end_date = moment(end).format('YYYY-MM-DD');
                            // alert(signature);
                            $.ajax({
                                url: "{{ route('user_car.car_calenda_addsave') }}",
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    person_join_id,
                                    car_service_book,
                                    car_service_year,
                                    car_service_location,
                                    car_service_reason,
                                    car_service_length_godate,
                                    car_service_length_backdate,
                                    car_service_length_gotime,
                                    car_service_length_backtime,
                                    car_service_article_id,
                                    car_service_no,
                                    start_date,
                                    end_date,
                                    signature,
                                    user_id
                               
                                },
                                success: function(data) {
                                    if (data.status == 0) {
                                        Swal.fire({
                                            title: 'กรุณาเลือกรถก่อน',
                                            text: "You Insert data success",
                                            icon: 'warning',
                                            showCancelButton: false,
                                            confirmButtonColor: '#06D177',
                                            // cancelButtonColor: '#d33',
                                            confirmButtonText: 'เรียบร้อย'
                                        }).then((result) => {
                                            if (result
                                                .isConfirmed) {
                                                window.location
                                                    .reload();
                                            }
                                        })
                                    } else if (data.status == 120) {
                                        Swal.fire(
                                            'กรุณาระบุวันที่ก่อน !',
                                            'You clicked the button !',
                                            'warning'
                                        )
                                    } else if (data.status == 50) {
                                        Swal.fire(
                                            'กรุณาลงลายชื่อ !',
                                            'You clicked the button !',
                                            'warning'
                                        )
                                   
                                    } else {
                                        // alert('gggggg');
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
                                                    data);
                                                $('#calendar')

                                                    .fullCalendar(
                                                        'renderEvent', {
                                                            'title': data
                                                                .title,
                                                            'start': data
                                                                .start,
                                                            'end': data
                                                                .end,
                                                            'color': data
                                                                .color
                                                        });
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
                    editable: true,
                    eventDrop: function(event) {
                        console.log(event)
                        var id = event.id;
                        // var title = event.meetting_title;
                        var start_date = moment(event.start).format('YYYY-MM-DD');
                        var end_date = moment(event.end).format('YYYY-MM-DD');
                        // alert(id);
                        $.ajax({
                            url: "{{ route('user_car.car_calenda_edit', '') }}" + '/' +
                                id,
                            type: "POST",
                            dataType: 'json',
                            data: {
                                start_date,
                                end_date
                            },
                            success: function(response) {
                                if (response.status == 200) {
                                    Swal.fire({
                                        title: 'แก้ไขข้อมูลสำเร็จ',
                                        text: "You Edit data success",
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#06D177',
                                        confirmButtonText: 'เรียบร้อย'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // window.location.reload();     
                                        }
                                    })
                                } else if (response.status == 100) {
                                    Swal.fire({
                                        title: 'ไม่สามารถแก้ไขได้ เนื่องจากสถานะไม่ใช่ร้องขอ!',
                                        text: "You Insert data success",
                                        icon: 'warning',
                                        showCancelButton: false,
                                        confirmButtonColor: '#06D177',
                                        confirmButtonText: 'เรียบร้อย'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    })
                                } else if (response.status == 150) {
                                    Swal.fire({
                                        title: 'ไม่สามารถแก้ไขได้ เนื่องจากอนุมัติแล้ว!',
                                        text: "You Cant not Update data ",
                                        icon: 'warning',
                                        showCancelButton: false,
                                        confirmButtonColor: '#06D177',
                                        confirmButtonText: 'เรียบร้อย'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    })
                                } else if (response.status == 250) {
                                    Swal.fire({
                                        title: 'ไม่สามารถแก้ไขได้ เนื่องจากจัดสรรแล้ว!',
                                        text: "You Cant not Update data ",
                                        icon: 'warning',
                                        showCancelButton: false,
                                        confirmButtonColor: '#06D177',
                                        confirmButtonText: 'เรียบร้อย'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    })
                                } else if (response.status == 300) {
                                    Swal.fire({
                                        title: 'สถานะไม่อนุมัติและยกเลิกไม่สามารถแก้ไขได้ !',
                                        text: "You Cant not Update data ",
                                        icon: 'warning',
                                        showCancelButton: false,
                                        confirmButtonColor: '#06D177',
                                        confirmButtonText: 'เรียบร้อย'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    })

                                } else {

                                }

                            },
                            error: function(error) {
                                console.log(error)
                            },
                        });
                    },
                    eventClick: function(event){
                                var id = event.id;
                             
                                var start_date = moment(event.start).format('YYYY-MM-DD');
                                var end_date = moment(event.end).format('YYYY-MM-DD');  
                                                             
                                    $('#EditcarservicessModal').modal('toggle');
                                    $.ajax({
                                        type: "GET",
                                        url:"{{url('user_car/car_narmal_editshow')}}" +'/'+ id,  
                                        success: function(data) {
                                            // alert(start_date);  
                                            $('#car_service_no2').val(data.carservice.car_service_no) 
                                            $('#car_service_article_id2').val(data.carservice.car_service_article_id) 
                                            $('#car_service_book2').val(data.carservice.car_service_book)  
                                            $('#car_service_year2').val(data.carservice.car_service_year) 
                                            $('#car_service_reason2').val(data.carservice.car_service_reason) 
                                            $('#car_service_location2').val(data.carservice.car_service_location) 
                                            $('#car_service_length_godate2').val(data.carservice.car_service_date)  
                                            $('#car_service_length_backdate2').val(data.carservice.car_service_date)  
                                            $('#car_service_length_gotime2').val(data.carservice.car_service_length_gotime)  
                                            $('#car_service_length_backtime2').val(data.carservice.car_service_length_backtime)  
                                            $('#car_service_id2').val(data.carservice.car_service_id)  
                                            $('#user_id2').val(data.carservice.car_service_user_id)
                                            // $('#car_service_location').val(data.carservice.car_service_location_name) 
                                            // $('#car_service_location').html('<option value="'+ data.carservice.car_location_id +'"> '+ data.carservice.car_service_location_name +'</option>');  /// OK
                                            // $('#car_service_location').append('<option value="'+ data.carservice.car_location_id +'" > '+ data.carservice.car_location_name +'</option>');  // Dropdown show
                                       
                                            $('#person_join_id2').val(data.carservice.person_join_id) 
                                        },   
                                    });
                                    $('#saveBtn2').click(function() {
                                        var person_join_id2 = $('#person_join_id2').val(); // aray mutiselect2                           
                                        var user_id2 = $('#user_id2').val();
                                        var car_service_book2 = $('#car_service_book2').val();
                                        var car_service_year2 = $('#car_service_year2').val();
                                        var car_service_location2 = $('#car_service_location2').val();
                                        var car_service_reason2 = $('#car_service_reason2').val();
                                        var car_service_length_godate2 = $('#car_service_length_godate2').val();
                                        var car_service_length_backdate2 = $('#car_service_length_backdate2').val();
                                        var car_service_length_gotime2 = $('#car_service_length_gotime2').val();
                                        var car_service_length_backtime2 = $('#car_service_length_backtime2').val();
                                        var car_service_article_id2 = $('#car_service_article_id2').val();
                                        var car_service_no2 = $('#car_service_no2').val();  
                                        var car_service_id2 = $('#car_service_id2').val(); 
                                        var user_id = $('#user_id').val(); 
                                        $.ajax({
                                                    url: "{{ route('user_car.car_calenda_update') }}",
                                                    type: "POST",
                                                    dataType: 'json',
                                                    data: {
                                                        person_join_id2,
                                                        car_service_book2,
                                                        car_service_year2,
                                                        car_service_location2,
                                                        car_service_reason2,
                                                        car_service_length_godate2,
                                                        car_service_length_backdate2,
                                                        car_service_length_gotime2,
                                                        car_service_length_backtime2,
                                                        car_service_article_id2,
                                                        car_service_no2, 
                                                        car_service_id2,
                                                        user_id2
                                                
                                                    },
                                                    success: function(data) {
                                                        if (data.status == 120) {
                                                            Swal.fire({
                                                                title: 'กรุณาเลือกวันที่',
                                                                text: "You Insert data success",
                                                                icon: 'warning',
                                                                showCancelButton: false,
                                                                confirmButtonColor: '#06D177',
                                                                // cancelButtonColor: '#d33',
                                                                confirmButtonText: 'เรียบร้อย'
                                                            }).then((result) => {
                                                                if (result
                                                                    .isConfirmed) {
                                                                 
                                                                }
                                                            })                                                    
                                                        } else {
                                                            // alert('gggggg');
                                                            Swal.fire({
                                                                title: 'แก้ไขข้อมูลสำเร็จ',
                                                                text: "You Edit data success",
                                                                icon: 'success',
                                                                showCancelButton: false,
                                                                confirmButtonColor: '#06D177',
                                                                confirmButtonText: 'เรียบร้อย'
                                                            }).then((result) => {
                                                                if (result
                                                                    .isConfirmed) {                                              
                                                                    window.location
                                                                        .reload();
                                                                }
                                                            })
                                                        } 
                                                },
                                        }); 
                                    });


                                                            
                    },
                    selectAllow: function(event) {
                        // return moment(event.start).utcOffset().isSame(moment(event.end));
                            return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
                            // moment(event.start).isSame(event.end, 'day');   // false, different month

                            // moment().format('MMMM Do YYYY, h:mm:ss a'); // กันยายน 6 2022, 6:47:33 หลังเที่ยง
                            // moment().format('dddd');                    // อังคาร
                            // moment().format("MMM Do YY");               // ก.ย. 6 22
                            // moment().format('YYYY [escaped] YYYY');     // 2022 escaped 2022
                            // moment().format();                          moment().format('MMMM Do YYYY, h:mm:ss a'); // กันยายน 6 2022, 6:47:33 หลังเที่ยง
 
                            // moment("20111031", "YYYYMMDD").fromNow(); // 11 ปีที่แล้ว
                            // moment("20120620", "YYYYMMDD").fromNow(); // 10 ปีที่แล้ว
                            // moment().startOf('day').fromNow();        // 19 ชั่วโมงที่แล้ว
                            // moment().endOf('day').fromNow();          // อีก 5 ชั่วโมง
                            // moment().startOf('hour').fromNow();      

                            // moment().subtract(10, 'days').calendar(); // 27/08/2022
                            // moment().subtract(6, 'days').calendar();  // วันพุธที่แล้ว เวลา 18:46
                            // moment().subtract(3, 'days').calendar();  // วันเสาร์ที่แล้ว เวลา 18:46
                            // moment().subtract(1, 'days').calendar();  // เมื่อวานนี้ เวลา 18:46
                            // moment().calendar();                      // วันนี้ เวลา 18:46
                            // moment().add(1, 'days').calendar();       // พรุ่งนี้ เวลา 18:46
                            // moment().add(3, 'days').calendar();       // ศุกร์หน้า เวลา 18:46
                            // moment().add(10, 'days').calendar();     
                    },
                });
                $('.fc-event').css('font-size','10px');
                // $('.fc-event').css('width','110px');
                // $('.fc-event').css('border-radius','30%');
            });


        });
    </script>


@endsection
