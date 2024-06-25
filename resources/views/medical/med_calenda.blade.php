@extends('layouts.medicalslide')
{{-- @extends('layouts.medicalhozi') --}}

@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
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
    use App\Models\Car_service;
    
    $refnumber = UsersuppliesController::refnumber();
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    $count_suprephn = StaticController::count_suprephn($iduser);
    $count_bookrep_po = StaticController::count_bookrep_po();
    //   $idselect = StaticController::idselect();
    ?>
    <style>
        /* @media (min-width: 950px) {
                    .modal {
                        --bs-modal-width: 950px;
                    }
                }

                @media (min-width: 1500px) {
                    .modal-xls {
                        --bs-modal-width: 1500px;
                    }
                }

                @media (min-width: 1500px) {
                    .container-fluids {
                        width: 1500px;
                        margin-left: auto;
                        margin-right: auto;
                        margin-top: auto;
                    }

                    .dataTables_wrapper .dataTables_filter {
                        float: right
                    }

                    .dataTables_wrapper .dataTables_length {
                        float: left
                    }

                    .dataTables_info {
                        float: left;
                    }

                    .dataTables_paginate {
                        float: right
                    }

                    .custom-tooltip {
                        --bs-tooltip-bg: var(--bs-primary);


                    }

                    .table thead tr th {
                        font-size: 14px;
                    }

                    .table tbody tr td {
                        font-size: 13px;
                    }

                    .menu {
                        font-size: 13px;
                    }
                }

                .hrow {
                    height: 2px;
                    margin-bottom: 9px;
                } */
        body {
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        #top,
        #calendar.fc-unthemed {
            font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
        }

        #top {
            background: #eee;
            border-bottom: 1px solid #ddd;
            padding: 0 5px;
            line-height: 10px;
            font-size: 12px;
            color: #000;
        }

        #top .selector {
            display: inline-block;
            margin-right: 10px;
        }

        #top select {
            font: inherit;
            /* mock what Boostrap does, don't compete  */
        }

        .left {
            float: left
        }

        .right {
            float: right
        }

        .clear {
            clear: both
        }

        #calendar {
            /* max-width: 1200px; */
            max-width: auto;
            margin: 40px auto;
            padding: 0 10px;
        }
    </style>
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
            border-top: 10px #1fdab1 solid;
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
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="row invoice-card-row">
                <div class="col-md-12 mt-2">
                    <div class="card p-1 mx-0 shadow-lg" style="background-color:rgb(147, 111, 194)">
                        <div class="panel-header text-left px-3 py-2 text-white">
                            ปฎิทินข้อมูลการ ยืม-คืน<span class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5"> </span>
                        </div>
                        <div class="panel-body bg-white">

                            <div id='calendar'></div>

                        </div>
                        <div class="panel-footer text-end pr-5 py-2 bg-white ">
                            {{-- <p class="m-0 fa fa-circle me-2" style="color:rgb(230, 143, 103);"></p> ร้องขอ<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:rgb(137, 183, 235);"></p> ส่งคืน<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:rgb(89, 196, 162);"></p> จัดสรร<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:rgb(247, 46, 106);"></p> ส่งซ่อม<label
                                class="me-3"></label> --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="DetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            รายละเอียดข้อมูลการ ยืม-คืนเครื่องมือแพทย์
                        </h5>
                        {{-- <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa-solid fa-circle-info text-white"></i>
                            ดูรายละเอียด
                        </button> --}}
                    </div>
                    <div class="modal-body"> 

                        {{-- <div class="collapse mt-1 mb-2" id="collapseExample"> --}}
                            <div class="row">

                                <div class="col-md-2">
                                    <label for="">วันที่ยืม</label>
                                    <div class="form-group mt-2">
                                        <input type="text" name="medical_borrow_date" id="medical_borrow_date" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="">วันที่คืน</label>
                                    <div class="form-group mt-2">
                                        <input type="text" name="medical_borrow_backdate" id="medical_borrow_backdate" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">รายการ</label>
                                    <div class="form-group mt-2">
                                        <input type="text" name="medical_borrow_article_id" id="medical_borrow_article_id" class="form-control form-control-sm">
                                        
                                    </div>
                                </div>
        
                                <div class="col-md-2">
                                    <label for="">จำนวน</label>
                                    <div class="form-group mt-2">
                                        <input type="text" name="medical_borrow_qty" id="medical_borrow_qty" class="form-control form-control-sm ">
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <label for="">หน่วยงานที่ยืม</label>
                                    <div class="form-group mt-2">
                                        <input type="text" name="medical_borrow_debsubsub_id" id="medical_borrow_debsubsub_id" class="form-control form-control-sm"> 
                                    </div>
                                </div> --}}
        
                            </div> 
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <label for="">หน่วยงานที่ยืม</label>
                                    <div class="form-group mt-2">
                                        <textarea name="medical_borrow_debsubsub_id" id="medical_borrow_debsubsub_id" cols="30" rows="10" class="form-control form-control-sm"></textarea>
                                        {{-- <input type="text" name="medical_borrow_debsubsub_id" id="medical_borrow_debsubsub_id" class="form-control form-control-sm">  --}}
                                    </div>
                                </div>
                            </div> 
                        {{-- </div>  --}}

                    </div>
 
                </div>
            </div>
        </div>


    @endsection
    @section('footer')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script src="{{ asset('js/gcpdfviewer.js') }}"></script>



        <script>
            $(document).ready(function() {

                $('select').select2();
                $('#car_location_name').select2({
                    dropdownParent: $('#carservicessModal')
                });
                $('#car_service_location').select2({
                    dropdownParent: $('#carservicessModal')
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(function() {
                    var borrowservicess = @json($events);
                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today', //  prevYear nextYea
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay',
                        },
                        events: borrowservicess,
                        selectable: true,
                        selectHelper: true,
                        select: function(start, end, allDays) { 
                            $('#DetailModal').modal('toggle');
                            $('#closebtn').click(function() {
                                $('#DetailModal').modal('hide'); 
                            });
                        },
                        eventClick: function(event){
                            var id = event.id;
                            // alert(id);
                            $('#DetailModal').modal('toggle');
                            $.ajax({
                                type: "GET",
                                url:"{{ url('med_calenda_detail') }}" +'/'+ id,  
                                success: function(data) { 
                                    $('#medical_borrow_date').val(data.med_calenda.medical_borrow_date)  
                                    $('#medical_borrow_backdate').val(data.med_calenda.medical_borrow_backdate) 
                                    $('#medical_borrow_article_id').val(data.med_calenda.article_name) 
                                    $('#medical_borrow_qty').val(data.med_calenda.medical_borrow_qty) 
                                    $('#medical_borrow_debsubsub_id').val(data.med_calenda.DEPARTMENT_SUB_SUB_NAME)   
                                    // $('#car_service_id').val(data.med_calenda.car_service_id)        
                                },   
                            });
                        }

                    });

                });



            });
        </script>


    @endsection
