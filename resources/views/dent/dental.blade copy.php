@extends('layouts.dentalnew')
@section('title', 'PK-OFFICER || ทันตกรรม')
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
                <div class="col-md-2 mt-2">
                    <div class="card p-1 mx-0 shadow" style="background-color: rgb(247, 229, 195)">
                        <div class="panel-header px-3 py-2 text-white">
                            ทันตแพทย์
                        </div>
                        <div class="panel-body bg-white ">
                            <div class="row">
                                @foreach ($data_doctor as $item)
                                    {{-- @if ($items->article_car_type_id == 2)
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
                                    @else --}}
                                        <div class="col-12 col-md-12 col-xl-12 text-start mt-2 ms-2">
                                            <div class="bg-image hover-overlay ripple ms-2 me-2 mb-2">
                                                <a href="">
                                                    {{-- <img src="" height="150px" width="150px" alt="Image" class="img-thumbnail"> --}}
                                                    {{-- <img src="{{ asset('storage/article/' . $item->article_img) }}" height="150px" width="150px" alt="Image" class="img-thumbnail"> --}}
                                                    {{-- <br> --}}
                                                    {{-- <p style="font-size: 13px;font-family: sans-serif">{{ $item->dentname }}</p> --}}
                                                    {{ $item->dentname }}
                                                </a>
                                            </div>
                                        </div>
                                    {{-- @endif --}}
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-10 mt-2">
                    <div class="card p-1 mx-0 shadow" style="background-color: rgb(247, 229, 195)">
                        <div class="panel-header text-left px-3 py-2 text-white">
                            ปฎิทินข้อมูลการนัดทำฟัน<span class="fw-3 fs-18 text-primary bg-sl-r2 px-2 radius-5">
                            </span>
                        </div>
                        <div class="panel-body bg-white">

                            <div id='calendar'></div>

                        </div>
                        <div class="panel-footer text-end pr-5 py-2 bg-white ">
                            <p class="m-0 fa fa-circle me-2" style="color:#3CDF44;"></p> อนุมัติ<label class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#814ef7;"></p> จัดสรร<label class="me-3"></label>
                            {{-- <p class="m-0 fa fa-circle me-2" style="color:#07D79E;"></p> จัดสรรร่วม<label class="me-3"></label> --}}
                            {{-- <p class="m-0 fa fa-circle me-2" style="color:#E80DEF;"></p> ไม่อนุมัติ<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#FA2A0F;"></p> แจ้งยกเลิก<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#ab9e9e;"></p> ยกเลิก<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:#fa861a;"></p>ร้องขอ <label
                                class="me-5"></label> --}}
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
                $('#car_service_status').select2({
                    dropdownParent: $('#carservicessModal')
                });
                $('#car_service_status').select2({
                    dropdownParent: $('#carservicessModal')
                });
                $('#car_drive_user_id').select2({
                    dropdownParent: $('#carservicessModal')
                });
                $('#DRIVE_INSERT').select2({
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
                                    $('#car_service_id').val(data.carservice.car_service_id)
                                },
                            });
                        }


                    });

                });

                $('#update_allocateForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = this;
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'บันทึกข้อมูลสำเร็จ',
                                    text: "You Insert data success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    // cancelButtonColor: '#d33',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else if (data.status == 100) {
                                Swal.fire(
                                    'กรุณารอการจัดสรรก่อน !',
                                    'You clicked the button !',
                                    'warning'
                                    )
                            }else if (data.status == 150) {
                                Swal.fire(
                                    'กรุณาเลือกความคิดเห็น !',
                                    'You clicked the button !',
                                    'warning'
                                    )
                            }else if (data.status == 50) {
                                Swal.fire(
                                    'กรุณาลงลายชื่อ !',
                                    'You clicked the button !',
                                    'warning'
                                    )
                            }else if (data.status == 20) {
                                Swal.fire(
                                    'รายการนี้ถูกอนุมัติไปแล้ว !',
                                    'You clicked the button !',
                                    'warning'
                                    )
                            } else {
                                Swal.fire(
                                    'ไม่มีข้อมูลต้องการจัดการ !',
                                    'You clicked the button !',
                                    'warning'
                                    )
                            }
                        }
                    });
                });



    });
</script>
<script>
    function adddrive() {
       var drivenew = document.getElementById("DRIVE_INSERT").value;
       var _token = $('input[name="_token"]').val();
    //    alert(drivenew);
       $.ajax({
           url: "{{route('car.adddrive')}}",
           method: "POST",
           data: {
            drivenew: drivenew,
               _token: _token
           },
           success: function (result) {
               $('.show_drive').html(result);
           }
       })
     }
</script>

    @endsection
