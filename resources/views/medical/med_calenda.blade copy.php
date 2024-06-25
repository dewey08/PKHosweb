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
        @media (min-width: 950px) {
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
        }
    </style>
<style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
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
           .is-hide{
           display:none;
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
                    <div class="card p-1 mx-0 shadow-lg" style="background-color:rgb(139, 76, 223)">
                        <div class="panel-header text-left px-3 py-2 text-white">
                            ปฎิทินข้อมูลการ ยืม-คืน<span class="fw-3 fs-18 text-white bg-sl-r2 px-2 radius-5"> </span>
                        </div>
                        <div class="panel-body bg-white">

                            <div id='calendar'></div>

                        </div>
                        <div class="panel-footer text-end pr-5 py-2 bg-white ">
                            <p class="m-0 fa fa-circle me-2" style="color:rgb(235, 81, 10);"></p> ร้องขอ<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:rgb(89, 10, 235);"></p> ส่งคืน<label
                                class="me-3"></label>
                            <p class="m-0 fa fa-circle me-2" style="color:rgb(4, 117, 81);"></p> จัดสรร<label
                                class="me-3"></label>
                           

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
                            // console.log(start)
                            // $('#carservicessModal').modal('toggle');
                            // $('#closebtn').click(function() {
                            //     $('#carservicessModal').modal('hide');
                            //     window.location.reload();   
                            // });
                        },


                    });

                });



            });
        </script>


    @endsection
