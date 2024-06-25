@extends('layouts.car')
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
    use App\Http\Controllers\UsersuppliesController;
    use App\Http\Controllers\StaticController;
    use App\Models\Products_request_sub;
    
    $refnumber = UsersuppliesController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
    ?>



    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="row invoice-card-row">
                <div class="col-md-3 mt-2">
                    <div class="card bg-secondary p-1 mx-0 shadow-lg">
                        <div class="panel-header px-3 py-2 text-white">
                            รายการรถยนต์
                        </div>
                        <div class="panel-body bg-white ">
                            <div class="row">
                                @foreach ($article_data as $items)
                                    @if ($items->article_car_type_id == 2)
                                        <div class="col-6 col-md-6 col-xl-6 text-center mt-2">
                                            <div class="bg-image hover-overlay ripple ms-2 me-2">
                                                <a href="{{ url('car/car_narmal_calenda_add/' . $items->article_id) }}">
                                                    <img src="{{ asset('storage/article/' . $items->article_img) }}"
                                                        height="150px" width="150px" alt="Image" class="img-thumbnail">
                                                    <br>
                                                    <label for=""
                                                        style="font-size: 11px;color:#FA2A0F">{{ $items->article_register }}</label>
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-6 col-md-6 col-xl-6 text-center mt-2">
                                            <div class="bg-image hover-overlay ripple ms-2 me-2">
                                                <a href="{{ url('car/car_narmal_calenda_add/' . $items->article_id) }}">
                                                    <img src="{{ asset('storage/article/' . $items->article_img) }}"
                                                        height="150px" width="150px" alt="Image" class="img-thumbnail">
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
                    <div class="card bg-secondary p-1 mx-0 shadow-lg">
                        <div class="panel-header text-left px-3 py-2 text-white">
                            ปฎิทินข้อมูลการใช้บริการรถยนต์<span class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5">
                            </span>
                        </div>
                        <div class="panel-body bg-white">

                            <div id='calendar'></div>

                        </div>
                        <div class="panel-footer text-end pr-5 py-2 bg-white ">
                            <p class="m-0 fa fa-circle me-2" style="color:#3CDF44;"></p> อนุมัติ<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> จัดสรร<label
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
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">จัดสรรการใช้รถยนต์ทั่วไป</h5>
                    </div>
                    <div class="modal-body">
    
                        <div class="row">
                            <div class="col-md-8">
    
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_book">ตามหนังสือเลขที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                         <input id="car_service_book" type="text" class="form-control form-control-sm input-rounded" name="car_service_book" readonly> 
                                        </div>
                                    </div>
    
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_year">ปีงบประมาณ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="car_service_year" type="text" class="form-control form-control-sm input-rounded" name="car_service_year" readonly>  
                                        </div>
                                    </div>
    
                                </div>
    
                                <div class="row ">
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_location">สถานที่ไป </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="car_service_location" type="text" class="form-control form-control-sm input-rounded" name="car_service_location" readonly>  
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_register">ทะเบียนรถยนต์ </label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="car_service_register" type="text" class="form-control form-control-sm input-rounded" name="car_service_register" readonly>  
                                        </div>
                                    </div>
                                     
                                </div>
    
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_reason">เหตุผล </label>
                                    </div>
                                    <div class="col-md-10 mt-2">
                                        <div class="form-outline">
                                            <input id="car_service_reason" type="text"
                                                class="form-control form-control-sm input-rounded" name="car_service_reason" readonly>
    
                                        </div>
                                    </div>
    
                                </div>
    
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_date">ตั้งแต่วันที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="car_service_date" type="text"
                                                class="form-control form-control-sm input-rounded"
                                                name="car_service_date" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_date2">ถึงวันที่ </label>
                                    </div>
    
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="car_service_date2" type="text"
                                                class="form-control form-control-sm input-rounded"
                                                name="car_service_date2" readonly>
                                        </div>
                                    </div>
    
                                </div>
    
                                <div class="row"> 
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_length_gotime">ตั้งแต่เวลา </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="car_service_length_gotime" type="text"
                                                class="form-control form-control-sm input-rounded"
                                                name="car_service_length_gotime" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <label for="car_service_length_backtime">ถึงเวลา </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="car_service_length_backtime" type="text"
                                                class="form-control form-control-sm input-rounded"
                                                name="car_service_length_backtime" readonly>
                                        </div>
                                    </div>
                                </div>
     
                                <input type="hidden" id="status" name="status" value="REQUEST">
                                <input type="hidden" id="userid" name="userid" value="{{ Auth::user()->id }}">
                                <input type="hidden" id="car_service_article_id" name="car_service_article_id"  >
    
    
                            </div>
                            <div class="col-md-4">
                                <div class="row ">
    
                                    <div class="col-md-12 ">
                                        <h3 class="mt-2 text-center">Digital Signature</h3>
                                        <div id="signature-pad">
                                            <div
                                                style="border:solid 1px teal; width:320px;height:120px;padding:3px;position:relative;">
                                                <div id="note" onmouseover="my_function();" class="text-center">The
                                                    signature should be inside box</div>
                                                <canvas id="the_canvas" width="320px" height="100px"></canvas>
                                            </div>
                                            <input type="hidden" id="signature" name="signature">
                                            <input type="hidden" id="user_id" name="user_id"
                                                value=" {{ Auth::user()->id }}">
                                            <input type="hidden" name="store_id" id="store_id"
                                                value=" {{ Auth::user()->store_id }}">
                                            <input type="hidden" id="car_service_no" name="car_service_no"
                                                value="{{ $refnumber }}">
                                            {{-- <input type="hidden" name="bookrep_id" id="bookrep_id" value=" {{ $dataedits->bookrep_id }}"> --}}
    
                                            <button type="button" id="clear_btn"
                                                class="btn btn-danger btn-sm mt-3 text-center" data-action="clear"><span
                                                    class="glyphicon glyphicon-remove"></span> Clear</button>
                                            <button type="button" id="save_btn"
                                                class="btn btn-info btn-sm mt-3 text-center" data-action="save-png"
                                                onclick="create()"><span class="glyphicon glyphicon-ok"></span>
                                                Create</button>
    
                                        </div>
                                    </div>
    
                                </div>
    
                            </div>
                        </div>
    
    
    
                    </div>
    
                    <div class="modal-footer">
                        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa-solid fa-person-circle-plus"></i>
                        </button>
                        <button type="submit" id="saveBtn" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-floppy-disk me-2"></i>
                            บันทึก
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">
                            <i class="fa-solid fa-xmark me-2"></i>
                            ปิด
                        </button>
                    </div>
    
                    <!-- Collapsed content -->
                    <div class="collapse mt-1 mb-2" id="collapseExample">
                        <div class="row mt-3">
                            <div class="col-md-1"> </div>
                            <div class="col-md-10">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                        id="crud_table">
                                        <thead>
                                            <tr>
                                                <th> ชื่อ-สกุล</th>
                                                <th width="10%"><button type="button" name="addRow" id="addRow"
                                                        class="btn btn-success btn-sm"><i
                                                            class="fa-solid fa-square-plus"></i></button></th>
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
    
                                                <td width="10%" class="text-center"><a
                                                        class="btn btn-danger btn-sm remove"><i
                                                            class="fa-solid fa-trash-can"></i></a></td>
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
        alert("Please provide signature first.");
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

                $('select').select2();
                $('#meetting_year').select2({
                    dropdownParent: $('#carservicessModal')
                });
                $('#car_location_name').select2({
                    dropdownParent: $('#carservicessModal')
                });

                $('#person_join_id').select2({
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
                        eventClick: function(event){
                            var id = event.id;
                            // alert(id);
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
                                    // car_service_register         
                                },   
                            });
                        }
                       

                    });

                });





            });
        </script>


    @endsection
