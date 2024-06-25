@extends('layouts.otsystem')
@section('title', 'PK-OFFICER || OT Report')
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
{{-- <style>
    .btn {
        font-size: 15px;
    }
    .bgc {
        background-color: #264886;
    }
    .bga {
        background-color: #fbff7d;
    }
</style> --}}
<style>
    #button {
        display: block;
        margin: 20px auto;
        padding: 30px 30px;
        background-color: #eee;
        border: solid #ccc 1px;
        cursor: pointer;
    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
    }

    .cv-spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 250px;
        height: 250px;
        border: 10px #ddd solid;
        border-top: 10px #d22cf3 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }

    @keyframes sp-anime {
        100% {
            transform: rotate(390deg);
        }
    }

    .is-hide {
        display: none;
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
        <div class="tabs-animation">
            <div class="row text-center">
                <div id="overlay">
                    <div class="cv-spinner">
                        <span class="spinner"></span>
                    </div>
                </div> 
            </div> 
            <div id="preloader">
                <div id="status">
                    <div class="spinner"> 
                    </div>
                </div>
            </div>


        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card cardot">
                    <div class="card-body">
                        {{-- <div class="card bg-info p-1 mx-0 shadow-lg"> --}}
                        <div class="card">
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
                    <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-circle-info text-white"></i>
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
                    <button type="button" id="saveBtn" class="btn btn-info btn-sm me-2">
                        <i class="fa-solid fa-circle-check text-white me-2"></i>
                        บันทึกข้อมูล
                    </button>
                    <button type="button" class="btn btn-danger btn-sm me-2" data-bs-dismiss="modal" id="closebtn">
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
                        // left: "BackwardButton, ForwardButton",
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
                                url: "{{ route('ot.otone_save') }}",
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
                                    // $('#meettingModal').modal('hide')

                                },
                            });
                        });

                    },
                    //    editable: true,
                    //    eventDrop: function(event) {
                    //        console.log(event)
                    //        var id = event.id;
                    //        // var title = event.meetting_title;
                    //        var start_date = moment(event.start).format('YYYY-MM-DD');
                    //        var end_date = moment(event.end).format('YYYY-MM-DD');
                    //        // alert(id);
                    //        $.ajax({
                    //            url: "{{ route('user_car.car_calenda_edit', '') }}" + '/' +
                    //                id,
                    //            type: "POST",
                    //            dataType: 'json',
                    //            data: {
                    //                start_date,
                    //                end_date
                    //            },
                    //            success: function(response) {
                    //                if (response.status == 200) {
                    //                    Swal.fire({
                    //                        title: 'แก้ไขข้อมูลสำเร็จ',
                    //                        text: "You Edit data success",
                    //                        icon: 'success',
                    //                        showCancelButton: false,
                    //                        confirmButtonColor: '#06D177',
                    //                        confirmButtonText: 'เรียบร้อย'
                    //                    }).then((result) => {
                    //                        if (result.isConfirmed) {
                    //                            // window.location.reload();     
                    //                        }
                    //                    })
                    //                } else if (response.status == 100) {
                    //                    Swal.fire({
                    //                        title: 'ไม่สามารถแก้ไขได้ เนื่องจากสถานะไม่ใช่ร้องขอ!',
                    //                        text: "You Insert data success",
                    //                        icon: 'warning',
                    //                        showCancelButton: false,
                    //                        confirmButtonColor: '#06D177',
                    //                        confirmButtonText: 'เรียบร้อย'
                    //                    }).then((result) => {
                    //                        if (result.isConfirmed) {
                    //                            window.location.reload();
                    //                        }
                    //                    })

                    //                } else {

                    //                }

                    //            },
                    //            error: function(error) {
                    //                console.log(error)
                    //            },
                    //        });
                    //    },
                    //    eventClick: function(event){
                    //                var id = event.ot_one_id;

                    //                var start_date = moment(event.start).format('YYYY-MM-DD');
                    //                var end_date = moment(event.end).format('YYYY-MM-DD');  

                    //                    $('#EditcarservicessModal').modal('toggle');
                    //                    $.ajax({
                    //                        type: "GET",
                    //                        url:"{{ url('user_car/car_narmal_editshow') }}" +'/'+ id,  
                    //                        success: function(data) {
                    //                            // alert(start_date);  
                    //                            $('#car_service_no2').val(data.carservice.car_service_no) 
                    //                            $('#car_service_article_id2').val(data.carservice.car_service_article_id) 
                    //                            $('#car_service_book2').val(data.carservice.car_service_book)  
                    //                            $('#car_service_year2').val(data.carservice.car_service_year) 
                    //                            $('#car_service_reason2').val(data.carservice.car_service_reason) 
                    //                            $('#car_service_location2').val(data.carservice.car_service_location) 
                    //                            $('#car_service_length_godate2').val(data.carservice.car_service_date)  
                    //                            $('#car_service_length_backdate2').val(data.carservice.car_service_date)  
                    //                            $('#car_service_length_gotime2').val(data.carservice.car_service_length_gotime)  
                    //                            $('#car_service_length_backtime2').val(data.carservice.car_service_length_backtime)  
                    //                            $('#car_service_id2').val(data.carservice.car_service_id)  
                    //                            $('#user_id2').val(data.carservice.car_service_user_id)
                    //                            // $('#car_service_location').val(data.carservice.car_service_location_name) 
                    //                            // $('#car_service_location').html('<option value="'+ data.carservice.car_location_id +'"> '+ data.carservice.car_service_location_name +'</option>');  /// OK
                    //                            // $('#car_service_location').append('<option value="'+ data.carservice.car_location_id +'" > '+ data.carservice.car_location_name +'</option>');  // Dropdown show

                    //                            $('#person_join_id2').val(data.carservice.person_join_id) 
                    //                        },   
                    //                    });
                    //                    $('#saveBtn2').click(function() {
                    //                        var person_join_id2 = $('#person_join_id2').val(); // aray mutiselect2                           
                    //                        var user_id2 = $('#user_id2').val();
                    //                        var car_service_book2 = $('#car_service_book2').val();
                    //                        var car_service_year2 = $('#car_service_year2').val();
                    //                        var car_service_location2 = $('#car_service_location2').val();
                    //                        var car_service_reason2 = $('#car_service_reason2').val();
                    //                        var car_service_length_godate2 = $('#car_service_length_godate2').val();
                    //                        var car_service_length_backdate2 = $('#car_service_length_backdate2').val();
                    //                        var car_service_length_gotime2 = $('#car_service_length_gotime2').val();
                    //                        var car_service_length_backtime2 = $('#car_service_length_backtime2').val();
                    //                        var car_service_article_id2 = $('#car_service_article_id2').val();
                    //                        var car_service_no2 = $('#car_service_no2').val();  
                    //                        var car_service_id2 = $('#car_service_id2').val(); 
                    //                        var user_id = $('#user_id').val(); 
                    //                        $.ajax({
                    //                                    url: "{{ route('user_car.car_calenda_update') }}",
                    //                                    type: "POST",
                    //                                    dataType: 'json',
                    //                                    data: {
                    //                                        person_join_id2,
                    //                                        car_service_book2,
                    //                                        car_service_year2,
                    //                                        car_service_location2,
                    //                                        car_service_reason2,
                    //                                        car_service_length_godate2,
                    //                                        car_service_length_backdate2,
                    //                                        car_service_length_gotime2,
                    //                                        car_service_length_backtime2,
                    //                                        car_service_article_id2,
                    //                                        car_service_no2, 
                    //                                        car_service_id2,
                    //                                        user_id2

                    //                                    },
                    //                                    success: function(data) {
                    //                                        if (data.status == 120) {
                    //                                            Swal.fire({
                    //                                                title: 'กรุณาเลือกวันที่',
                    //                                                text: "You Insert data success",
                    //                                                icon: 'warning',
                    //                                                showCancelButton: false,
                    //                                                confirmButtonColor: '#06D177',
                    //                                                // cancelButtonColor: '#d33',
                    //                                                confirmButtonText: 'เรียบร้อย'
                    //                                            }).then((result) => {
                    //                                                if (result
                    //                                                    .isConfirmed) {

                    //                                                }
                    //                                            })                                                    
                    //                                        } else {
                    //                                            // alert('gggggg');
                    //                                            Swal.fire({
                    //                                                title: 'แก้ไขข้อมูลสำเร็จ',
                    //                                                text: "You Edit data success",
                    //                                                icon: 'success',
                    //                                                showCancelButton: false,
                    //                                                confirmButtonColor: '#06D177',
                    //                                                confirmButtonText: 'เรียบร้อย'
                    //                                            }).then((result) => {
                    //                                                if (result
                    //                                                    .isConfirmed) {                                              
                    //                                                    window.location
                    //                                                        .reload();
                    //                                                }
                    //                                            })
                    //                                        } 
                    //                                },
                    //                        }); 
                    //                    });



                    //    },
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
