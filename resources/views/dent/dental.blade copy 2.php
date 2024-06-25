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

        <div class="modal fade" id="DatanadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            รายการนัดทำฟัน
                        </h5>
                        <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa-solid fa-circle-info text-white"></i>
                            รายละเอียด
                          </button>
                    </div>
                    <div class="modal-body">
                            <div class="collapse mt-1 mb-2" id="collapseExample">

                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <label for="ptname">ptname </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="ptname" type="text" class="form-control form-control-sm input-rounded" name="ptname">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <label for="cid">cid </label>
                                    </div>

                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="cid" type="text" class="form-control form-control-sm input-rounded" name="cid" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <label for="hn">hn </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="hn" type="text" class="form-control form-control-sm input-rounded" name="hn" >
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <label for="doctor_nad">นัดวันที่ </label>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <div class="form-group">
                                            <input id="doctor_nad" type="text" class="form-control form-control-sm input-rounded" name="doctor_nad" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <input id="vn" type="hidden" class="form-control form-control-sm" name="vn" >
                    <input id="oapp_id" type="hidden" class="form-control form-control-sm" name="oapp_id" >

                </div>
            </div>
        </div>


    @endsection
    @section('footer')



<script>
    $(document).ready(function() {
        // Get Site URL
        // var SITEURL = "url('/')";
        var data_nad = @json($events);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            // editable:true,
            // events:SITEURL + "dental",
            events:data_nad,
            displayEventTime:false,
            // editable:true,
            eventRender:function (event,element,view){
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDays) {
                console.log(start)
                // $('#DatanadModal').modal('toggle');
                // $('#closebtn').click(function() {
                //     $('#DatanadModal').modal('hide');
                // });
                var title = prompt('Event Title');
                    if (title) {
                        var start = $.fullCalendar.formatDate(start,"Y-MM-DD");
                        var end = $.fullCalendar.formatDate(end,"Y-MM-DD");
                    }
            },
            eventClick: function(event){
                    var oapp_id = event.oapp_id;
                    alert(oapp_id);
                    $('#DatanadModal').modal('toggle');
                    $.ajax({
                        type: "GET",
                        url:"{{url('dental_detail')}}" +'/'+ oapp_id,
                        success: function(data) {
                            console.log(data.data_nad.vn);
                            $('#vn').val(data.data_nad.vn)
                            $('#ptname').val(data.data_nad.ptname)
                            $('#cid').val(data.data_nad.cid)
                            $('#hn').val(data.data_nad.hn)
                            $('#doctor_nad').val(data.data_nad.doctor_nad)
                            $('#doctor').val(data.data_nad.doctor)
                            $('#oapp_id').val(data.data_nad.oapp_id)
                        },
                    });
                }
        });

                // $(function() {
                //     var data_nad = @json($events);
                //     $('#calendar').fullCalendar({
                //         header: {
                //             left: 'prev,next today', //  prevYear nextYea
                //             center: 'title',
                //             right: 'month,agendaWeek,agendaDay',
                //         },
                //         events: data_nad,
                //         selectable: true,
                //         selectHelper: true,
                //         select: function(start, end, allDays) {
                //             console.log(start)
                //             $('#DatanadModal').modal('toggle');
                //             $('#closebtn').click(function() {
                //                 $('#DatanadModal').modal('hide');
                //             });
                //         },
                //         eventClick: function(event){
                //             var oapp_id = event.oapp_id;
                //             alert(oapp_id);
                //             $('#DatanadModal').modal('toggle');
                //             $.ajax({
                //                 type: "GET",
                //                 url:"{{url('dental_detail')}}" +'/'+ oapp_id,
                //                 success: function(data) {
                //                     console.log(data.data_nad.vn);
                //                     $('#vn').val(data.data_nad.vn)
                //                     $('#ptname').val(data.data_nad.ptname)
                //                     $('#cid').val(data.data_nad.cid)
                //                     $('#hn').val(data.data_nad.hn)
                //                     $('#doctor_nad').val(data.data_nad.doctor_nad)
                //                     $('#doctor').val(data.data_nad.doctor)
                //                     $('#oapp_id').val(data.data_nad.oapp_id)
                //                 },
                //             });
                //         }
                //     });
                // });

    });
</script>


    @endsection
