@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER || OT')
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
    .btn {
        font-size: 15px;
    }

    .bgc {
        background-color: #264886;
    }

    .bga {
        background-color: #fbff7d;
    }
</style>
<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
?>
    <div class="container-fluid">


        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body py-0 px-2 mt-2">
                        {{-- style="color: rgb(9, 75, 129)" --}}
                        <div class="card p-1 mx-0 shadow-lg" style="background-color: rgb(9, 75, 129)">
                            <div class="panel-header text-left px-3 py-2 text-white">
                                ลงบันทึกโอที<span class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5"> </span>
                            </div>
                            <div class="panel-body bg-white">

                                <div id='calendar'></div>

                            </div>
                            {{-- <div class="panel-footer text-end pr-5 py-2 bg-white ">
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
                            </div> --}}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Insert -->
    <div class="modal fade" id="otservicessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        ลงเวลาโอที
                    </h5>
                    <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-circle-info text-info"></i>
                        รายละเอียด
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Collapsed content -->
                    <div class="collapse mt-1 mb-2" id="collapseExample">



                        <div class="row">
                            <div class="col-md-2 mt-3">
                                <label for="ot_one_detail">เหตุผล </label>
                            </div>
                            <div class="col-md-10 mt-3">
                                <div class="form-outline">
                                    <input id="ot_one_detail" type="text" class="form-control input-rounded"
                                        name="ot_one_detail">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2 mt-3">
                                <label for="ot_one_starttime">ตั้งแต่เวลา </label>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <input id="ot_one_starttime" type="time" class="form-control input-rounded"
                                        name="ot_one_starttime">
                                </div>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label for="ot_one_endtime">ถึงเวลา </label>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <input id="ot_one_endtime" type="time" class="form-control input-rounded"
                                        name="ot_one_endtime">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="user_id" name="user_id" value=" {{ Auth::user()->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveBtn" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info me-2">
                        <i class="fa-solid fa-circle-check text-info me-2"></i>
                        บันทึกข้อมูล
                    </button>
                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-dismiss="modal" id="closebtn">
                        <i class="fa-solid fa-xmark me-2"></i>
                        ปิด
                    </button>
                </div>

            </div>
        </div>
    </div>
    </div>

@endsection
@section('footer')

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(function() {

                var otservicess = @json($events);

                $('#calendar').fullCalendar({
                    // timeZone: 'Asia/Bangkok',                    

                    header: {
                        left: 'prev,next today', //  prevYear nextYea
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay',
                    },

                    // editable: true,
                    selectable: true,
                    selectHelper: true,
                    //    dayMaxEvents: true, // allow "more" link when too many events
                    events: otservicess,
                    select: function(start, end, allDays) {
                        $('#otservicessModal').modal('toggle');
                        //    $('#choosebook').modal('toggle');
                        //    $('#closebtn').click(function() {
                        //        $('#carservicessModal').modal('hide');
                        //    });

                        var start_date = moment(start).format('YYYY-MM-DD HH:mm',
                            'Asia/Bangkok')
                        var end_date = moment(end).format('YYYY-MM-DD HH:mm', 'Asia/Bangkok');

                        // var start_c = $.fullCalendar.formatDate(start,'YYYY-MM-DD HH:mm');
                        // var end_c = $.fullCalendar.formatDate(end,'YYYY-MM-DD HH:mm');

                        // alert(end_date);

                        $('#saveBtn').click(function() {

                            var ot_one_detail = $('#ot_one_detail').val();
                            var ot_one_starttime = $('#ot_one_starttime').val();
                            var ot_one_endtime = $('#ot_one_endtime').val();
                            var start_date = moment(start).format('YYYY-MM-DD', 'UTC');
                            var end_date = moment(end).format('YYYY-MM-DD');
                            var signature = $('#signature').val();
                            var user_id = $('#user_id').val();
                            // var start_date = moment(start).format('YYYY-MM-DD');
                            // var end_date = moment(end).format('YYYY-MM-DD');
                            //    alert(ot_one_detail);
                            $.ajax({
                                url: "{{ route('userot.user_otone_save') }}",
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    ot_one_detail,
                                    ot_one_starttime,
                                    ot_one_endtime,
                                    start_date,
                                    end_date,
                                    signature,
                                    user_id

                                },
                                success: function(data) {
                                    if (data.status == 100) {
                                        Swal.fire({
                                            title: 'วันนี้ได้ลงไปเรียบร้อยแล้ว',
                                            text: "You have data success",
                                            icon: 'warning',
                                            showCancelButton: false,
                                            confirmButtonColor: '#ff0606',
                                            // cancelButtonColor: '#d33',
                                            confirmButtonText: 'Close'
                                        }).then((result) => {
                                            if (result
                                                .isConfirmed) {
                                                window.location
                                                    .reload();
                                            }
                                        })

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
                                },
                            });
                        });

                    },
                     
                    selectAllow: function(event) {
                        // return moment(event.start).utcOffset().isSame(moment(event.end));
                            return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
                                
                    },
                });
                $('.fc-event').css('font-size', '10px');
                //    $('.fc-event').css('width','110px');
                //    $('.fc-event').css('border-radius','30%');
            });

        });
    </script>

@endsection
