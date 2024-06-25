@extends('layouts.userdashboard')
@section('title', 'PK-OFFICER || ช้อมูลการจองห้องประชุม')


<link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />

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
    
    date_default_timezone_set('Asia/Bangkok');
    $datenow = date('Y-m-d');
    $yy = date('Y') + 543;
    $mo = date('m');
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน
    
    ?>
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
        /* .body{
            font-family: sans-serif;
            font-size: 14px;
        } */
    </style>
    {{-- <div class="container-fluid" >
  <div class="px-0 py-0 mb-2">
    <div class="d-flex flex-wrap justify-content-center">  
      <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>
    
      <div class="text-end"> 
        <a href="{{url('user_meetting/meetting_calenda')}}" class="btn btn-light btn-sm text-dark me-2">ปฎิทิน</a>
        <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-light btn-sm text-dark me-2">ช้อมูลการจองห้องประชุม</a> 
        <a href="#" class="btn btn-info btn-sm text-white me-2">จองห้องประชุม</a> 
      </div>
    </div>
  </div> --}}
    <div class="tabs-animation">

        <div class="row text-center">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card shadow-lg">
                    {{-- {{$building_level_room->room_name}}    --}}
                    <div class="card-header">
                        บันทึกขอใช้ห้องประชุม วันที่ {{ dateThaifromFull($datenow) }} <label for=""
                            class="mt-2 ms-5" style="color: rgb(255, 0, 0)"> {{ $dataedits->room_name }}</label>
                        <div class="btn-actions-pane-right">
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('meetting.meetting_choose_linesave') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf


                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div id='calendar'></div>
                                </div>
                            </div> --}}
                            <div class="row"> 
                                <div class="col-md-5">
                                    <div id='calendar'></div>
                                </div>
                                <div class="col-md-7">

                                    <input type="hidden" id="room_id" name="room_id" value="{{ $dataedits->room_id }}">
                                    <input type="hidden" id="status" name="status" value="REQUEST">
                                    <input type="hidden" id="userid" name="userid" value="{{ Auth::user()->id }}"> 
                                    <input type="hidden" id="meetting_year" name="meetting_year" value="{{$yy}}">
                                    
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meetting_title">เรื่องการประชุม </p>
                                        </div>
                                        <div class="col-md-9 text-start">
                                            <div class="form-group">
                                                <input id="meetting_title" type="text"
                                                    class="form-control @error('meetting_title') is-invalid @enderror"
                                                    name="meetting_title" value="{{ old('meetting_title') }}"
                                                    autocomplete="meetting_title">
                                                @error('meetting_title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row mt-3">
                                        <div class="col-md-4 text-end">
                                            <label for="meetting_target">กลุ่มบุคคลเป้าหมาย </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <input id="meetting_target" type="text"
                                                    class="form-control @error('meetting_target') is-invalid @enderror"
                                                    name="meetting_target" value="{{ old('meetting_target') }}"
                                                    autocomplete="meetting_target">
                                                @error('meetting_target')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_objective_id">วัตถุประสงค์</p>
                                        </div>
                                        <div class="col-md-9 text-start">
                                            <div class="form-group">
                                                <select name="meeting_objective_id" id="meeting_objective_id"
                                                    class="form-control form-control-lg" style="width: 100%;">
                                                    <option value="" selected>--เลือก--</option>
                                                    @foreach ($meeting_objective as $listobj)
                                                        <option value="{{ $listobj->meeting_objective_id }}">
                                                            {{ $listobj->meeting_objective_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row mt-3">
                                        {{-- <div class="col-md-4 text-end">
                                            <label for="meetting_year">ปีงบประมาณ </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="meetting_year" id="meetting_year" class="form-control" 
                                                    style="width: 100%;">
                                                    <option value="" selected>--เลือก--</option>
                                                    @foreach ($budget_year as $year)
                                                        @if ($yy == $year->leave_year_id)
                                                            <option value="{{ $year->leave_year_id }}" selected>
                                                                {{ $year->leave_year_id }}</option>
                                                        @else
                                                            <option value="{{ $year->leave_year_id }}">
                                                                {{ $year->leave_year_id }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-3">
                                            <p for="meetting_person_qty">จำนวนผู้เข้าร่วม</p>
                                        </div>
                                        <div class="col-md-2 text-start">
                                            <div class="form-group">
                                                <input id="meetting_person_qty" type="text"
                                                    class="form-control @error('meetting_person_qty') is-invalid @enderror"
                                                    name="meetting_person_qty" value="{{ old('meetting_person_qty') }}"
                                                    autocomplete="meetting_person_qty" placeholder="คน">
                                                @error('meetting_person_qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-md-1">
                                            <p for="lname">คน</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_date_begin">ตั้งแต่วันที่ </p>
                                        </div>
                                        <div class="col-md-9 text-start">
                                            <div class="form-group">
                                                <input id="meeting_date_begin" type="date"
                                                    class="form-control @error('meeting_date_begin') is-invalid @enderror"
                                                    name="meeting_date_begin" value="{{ old('meeting_date_begin') }}"
                                                    autocomplete="meeting_date_begin">
                                                @error('meeting_date_begin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_date_end">ถึงวันที่ </p>
                                        </div>
                                        <div class="col-md-9 text-start">
                                            <div class="form-group">
                                                <input id="meeting_date_end" type="date"
                                                    class="form-control @error('meeting_date_end') is-invalid @enderror"
                                                    name="meeting_date_end" value="{{ old('meeting_date_end') }}"
                                                    autocomplete="meeting_date_end">
                                                @error('meeting_date_end')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-md-3 mt-3">
                                            <p for="meeting_time_begin">ตั้งแต่เวลา </p>
                                        </div>
                                        <div class="col-md-3 text-start mt-3">
                                            <div class="form-group">
                                                <input id="meeting_time_begin" type="time"
                                                    class="form-control @error('meeting_time_begin') is-invalid @enderror"
                                                    name="meeting_time_begin" value="{{ old('meeting_time_begin') }}"
                                                    autocomplete="meeting_time_begin">
                                                @error('meeting_time_begin')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-3">
                                            <p for="meeting_time_end">ถึงเวลา </p>
                                        </div>
                                        <div class="col-md-3 text-start mt-3">
                                            <div class="form-group">
                                                <input id="meeting_time_end" type="time"
                                                    class="form-control @error('meeting_time_end') is-invalid @enderror"
                                                    name="meeting_time_end" value="{{ old('meeting_time_end') }}"
                                                    autocomplete="meeting_time_end">
                                                @error('meeting_time_end')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
 
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_tel">เบอร์โทร </p>
                                        </div>
                                        <div class="col-md-9 text-start">
                                            <div class="form-group">
                                                <input id="meeting_tel" type="text" class="form-control"
                                                    name="meeting_tel" value="{{ Auth::user()->tel }}">
                                                @error('meeting_tel')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_tel">หมายเหตุ </p>
                                        </div>
                                        <div class="col-md-9 text-start">
                                            <div class="form-group">
                                                <textarea name="meeting_comment" id="meeting_comment" class="form-control" rows="3">
                                                </textarea>
                                            </div>
                                        </div> 
                                    </div>

                                </div>

                            </div>
                            
                    </div>
                        <div class="card-footer">
                            <div class="col"></div>
                            <div class="col-md-4 text-end">
                                <div class="form-group ">
                                    <button type="submit"
                                        class="mt-2 mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"> 
                                        <i class="pe-7s-diskette btn-icon-wrapper"></i>
                                        บันทึกข้อมูล
                                    </button>
                                    <a href="{{ url('user_meetting/meetting_add/' . Auth::user()->id) }}"
                                        class="mt-2 mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                        <i class="pe-7s-close btn-icon-wrapper"></i>ยกเลิก
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                   
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
@endsection
@section('footer')

    <script>
        $(document).ready(function() {

            $(function() {
                var meetting = @json($events);
                $('#calendar').fullCalendar({
                    events: meetting,
                    selectHelper: true,
                });
            });

            $('select').select2();
        });
        $('.addRow').on('click', function() {
            addRow();
            $('select').select2();
        });

        function addRow() {
            var count = $('.tbody1').children('tr').length;
            var tr = '<tr>' +
                '<td style="text-align: center;">' +
                (count + 1) +
                '</td>' +
                '<td>' +
                '<select name="MEETTINGLIST_ID[]" id="MEETTINGLIST_ID' + count +
                '" class="form-control form-control-sm" style="width: 100%;">' +
                '<option value="" selected>--รายการอุปกรณ์--</option>' +
                '@foreach ($meeting_list as $list)' +
                '<option value="{{ $list->meeting_list_id }}">{{ $list->meeting_list_name }}</option>' +
                '@endforeach' +
                '</select> ' +
                '</td>' +
                '<td>' +
                '<input name="MEETTINGLIST_QTY[]" id="MEETTINGLIST_QTY' + count +
                '" class="form-control form-control-sm">' +
                '</td>' +
                '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;"></a></td>' +
                '</tr>';
            $('.tbody1').append(tr);
        };
        $('.tbody1').on('click', '.remove1', function() {
            $(this).parent().parent().remove();

        });
    </script>
    <script>
        $('.addRow2').on('click', function() {
            addRow2();
            $('select').select2();
        });

        function addRow2() {
            var count2 = $('.tbody2').children('tr').length;
            var tr = '<tr>' +
                '<td style="text-align: center;">' +
                (count2 + 1) +
                '</td>' +
                '<td>' +
                '<select name="FOOD_LIST_ID[]" id="FOOD_LIST_ID' + count2 +
                '" class="form-control form-control-sm" style="width: 100%;">' +
                '<option value="" selected>--รายการอาหาร--</option>' +
                '@foreach ($food_list as $food)' +
                '<option value="{{ $food->food_list_id }}">{{ $food->food_list_name }}</option>' +
                '@endforeach' +
                '</select> ' +
                '</td>' +
                '<td>' +
                '<input name="FOOD_LIST_QTY[]" id="FOOD_LIST_QTY' + count2 + '" class="form-control form-control-sm">' +
                '</td>' +
                '<td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove2" style="color:#FFFFFF;"></a></td>' +
                '</tr>';
            $('.tbody2').append(tr);
        };
        $('.tbody2').on('click', '.remove2', function() {
            $(this).parent().parent().remove();

        });
    </script>

@endsection
