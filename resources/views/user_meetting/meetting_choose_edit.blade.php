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
    $date = date('Y-m-d');
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
    </style>
    <div class="tabs-animation">

        <div class="row text-center">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">

                    </div>
                </div>
            </div>

        </div>
        {{-- <div class="container-fluid" > --}}

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    {{-- {{$building_level_room->room_name}}    --}}
                    <div class="card-header">
                        บันทึกขอใช้ห้องประชุม วันที่ {{ dateThaifromFull($date) }} <label for="" class="mt-2 ms-4"
                            style="color: rgb(255, 0, 0)"> {{ $dataedits->room_name }}</label>
                        <div class="btn-actions-pane-right">
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="custom-validation" action="{{ route('meetting.meetting_choose_lineupdate') }}"
                            id="insert_chooselineupdateForm" method="POST" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-md-5">
                                    <div id='calendar'></div>
                                </div>
                                <div class="col-md-7">

                                    <input type="hidden" id="room_id" name="room_id" value="{{ $dataedits->room_id }}">
                                    <input type="hidden" id="status" name="status" value="REQUEST">
                                    <input type="hidden" id="userid" name="userid" value="{{ Auth::user()->id }}">
                                    <input type="hidden" id="meeting_id" name="meeting_id"
                                        value="{{ $dataedits->meeting_id }}">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <p for="meetting_title">เรื่องการประชุม </p>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input id="meetting_title" type="text" class="form-control"
                                                    name="meetting_title" value="{{ $dataedits->meetting_title }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row mt-3">  
                                <div class="col-md-3 text-end">
                                    <label for="meetting_target">กลุ่มบุคคลเป้าหมาย </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input id="meetting_target" type="text" class="form-control" name="meetting_target" value="{{  $dataedits->meetting_target}}">
                                        
                                    </div>
                                </div>                                  
                            </div>   --}}

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_objective_id">วัตถุประสงค์</p>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <select name="meeting_objective_id" id="meeting_objective_id"
                                                    class="form-control form-control-lg" style="width: 100%;">
                                                    <option value="" selected>--เลือก--</option>
                                                    @foreach ($meeting_objective as $listobj)
                                                        @if ($dataedits->meeting_objective_id == $listobj->meeting_objective_id)
                                                            <option value="{{ $listobj->meeting_objective_id }}" selected>
                                                                {{ $listobj->meeting_objective_name }}</option>
                                                        @else
                                                            <option value="{{ $listobj->meeting_objective_id }}">
                                                                {{ $listobj->meeting_objective_name }}</option>
                                                        @endif
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
                                      <select name="meetting_year" id="meetting_year" class="form-control" style="width: 100%;">
                                          <option value="" selected>--เลือก--</option> 
                                          @foreach ($budget_year as $year)
                                          @if ($dataedits->meetting_year == $year->leave_year_id)
                                          <option value="{{ $year->leave_year_id }}" selected>{{ $year->leave_year_id}}</option>
                                          @else
                                          <option value="{{ $year->leave_year_id }}">{{ $year->leave_year_id}}</option>
                                          @endif
                                              
                                          @endforeach                   
                                      </select>
                                    </div>
                                </div>      --}}
                                        <div class="col-md-3">
                                            <p for="meetting_person_qty">จำนวนผู้เข้าร่วม</p>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input id="meetting_person_qty" type="text" class="form-control"
                                                    name="meetting_person_qty"
                                                    value="{{ $dataedits->meetting_person_qty }}">

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
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input id="meeting_date_begin" type="date" class="form-control"
                                                    name="meeting_date_begin" value="{{ $dataedits->meeting_date_begin }}">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_date_end">ถึงวันที่ </p>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input id="meeting_date_end" type="date" class="form-control"
                                                    name="meeting_date_end" value="{{ $dataedits->meeting_date_end }}">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_time_begin">ตั้งแต่เวลา </p>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="meeting_time_begin" type="time" class="form-control"
                                                    name="meeting_time_begin"
                                                    value="{{ $dataedits->meeting_time_begin }}">

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p for="meeting_time_end">ถึงเวลา </p>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input id="meeting_time_end" type="time" class="form-control"
                                                    name="meeting_time_end" value="{{ $dataedits->meeting_time_end }}">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_tel">เบอร์โทร </p>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input id="meeting_tel" type="text" class="form-control"
                                                    name="meeting_tel" value="{{ $dataedits->meeting_tel }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <p for="meeting_tel">หมายเหตุ </p>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <textarea name="meeting_comment" id="meeting_comment" class="form-control" rows="3">{{ $dataedits->meeting_comment }}
                                        </textarea>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            </div>
                            {{-- <div class="row mt-3 mb-5">
                        <div class="col-md-12">
                            <div class="card-header shadow">
                                <label for="">อุปกรณ์ที่ต้องการ </label>
                            </div> 
                            <div class="card-body shadow">
                                <div class="table-responsive">
                                    <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                        <thead>
                                            <tr style="background-color: rgb(173, 247, 250)">
                                                <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                <td style="text-align: center;">รายการอุปกรณ์</td>                                                                      
                                                <td style="text-align: center;" width="12%">จำนวน</td>                                                   
                                                <td style="text-align: center;" width="7%">
                                                    <a class="btn btn-sm btn-success addRow" style="color:#FFFFFF;"><i class="fas fa-plus" ></i></a>
                                                </td>
                                            </tr>
                                        </thead> 
                                        <tbody class="tbody1"> 
                                            @foreach ($meeting_service_list as $key => $serlist)   
                                                <tr height="30" >  
                                                    <td style="text-align: center;"> {{$key+1}} </td>                                           
                                                    <td>
                                                        <select name="MEETTINGLIST_ID[]" id="MEETTING_LIST_ID0" class="form-control form-control-sm " style="width: 100%;">
                                                            <option value="" selected ><label class="az">--รายการอุปกรณ์--</label></option> 
                                                            @foreach ($meeting_list as $list)
                                                            @if ($serlist->meeting_list_id == $list->meeting_list_id)
                                                            <option value="{{$list ->meeting_list_id }}" selected ><label class="az">{{ $list->meeting_list_name}}</label></option>
                                                            @else
                                                            <option value="{{$list ->meeting_list_id }}"><label class="az">{{ $list->meeting_list_name}}</label></option>
                                                            @endif
                                                                
                                                            @endforeach                   
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                        <input name="MEETTINGLIST_QTY[]" id="MEETTINGLIST_QTY0" class="form-control form-control-sm" value="{{ $serlist->meeting_service_list_qty }}">
                                                    </td>                                               
                                                    <td style="text-align: center;">
                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove1" style="color:#FFFFFF;">
                                                        </a>
                                                    </td>
                                                </tr>    
                                                @endforeach 
                                        </tbody>   
                                    </table>
                                </div>
                            </div>  
                        </div> --}}

                            {{-- <div class="col-md-6">
                            <div class="card-header shadow">
                                <label for="">รายการอาหาร </label>
                            </div> 
                            <div class="card-body shadow">
                                <div class="table-responsive">
                                    <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                        <thead>
                                            <tr style="background-color: rgb(173, 247, 250)">
                                                <td style="text-align: center;"width="5%">ลำดับ</td> 
                                                <td style="text-align: center;">รายการอาหาร</td>                                                                      
                                                <td style="text-align: center;" width="10%">จำนวน</td>                                                    
                                                <td style="text-align: center;" width="7%"><a  class="btn btn-sm btn-success addRow2" style="color:#FFFFFF;"><i class="fas fa-plus" ></i></a></td>
                                            </tr>
                                        </thead> 
                                        <tbody class="tbody2"> 
                                            @foreach ($meeting_service_food as $key => $foodlist)   
                                                <tr height="30" >  
                                                    <td style="text-align: center;"> {{$key+1}} </td>                                                
                                                    <td> 
                                                        <select name="FOOD_LIST_ID[]" id="FOOD_LIST_ID0" class="form-control form-control-sm " style="width: 100%;">
                                                            <option value="" selected class="myFontselect">--รายการอาหาร--</option> 
                                                            @foreach ($food_list as $food)
                                                            @if ($foodlist->food_list_id == $food->food_list_id)
                                                            <option value="{{ $food->food_list_id }}" selected class="myFontselect">{{$food->food_list_name}}</option>
                                                            @else
                                                            <option value="{{ $food->food_list_id }}">{{$food->food_list_name}}</option>
                                                            @endif
                                                                
                                                            @endforeach  
                                                        </select>
                                                    </td>                                                                               
                                                    <td>
                                                    <input name="FOOD_LIST_QTY[]" id="FOOD_LIST_QTY0" class="form-control form-control-sm"  value="{{ $foodlist->meeting_service_food_qty }}">
                                                    </td> 
                                                    <td style="text-align: center;"><a class="btn btn-sm btn-danger fa fa-trash-alt remove2" style="color:#FFFFFF;"></a></td>
                                                </tr>  
                                            @endforeach                                                               
                                        </tbody>   
                                    </table>
                                </div> 
                            </div>  
                        </div> --}}
                            {{-- </div> --}}

                            {{-- <div class="card-footer">
                        <div class="col-md-12 text-end"> 
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    
                                    บันทึกข้อมูล
                                </button> 
                                <a href="{{url('user_meetting/meetting_index')}}" class="btn btn-danger btn-sm">
                                    ยกเลิก
                                </a>
                            </div>                   
                        </div>   
                    </div> --}}

                            <div class="card-footer">
                                <div class="col"></div>
                                <div class="col-md-4 text-end">
                                    <div class="form-group ">
                                        <button type="submit"
                                            class="mt-2 mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                            <i class="pe-7s-diskette btn-icon-wrapper"></i>
                                            บันทึกข้อมูล
                                        </button>
                                        <a href="{{ url('user_meetting/meetting_index') }}"
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

            $('select').select2({
                // templateResult: formatOutput,
                // dropdownCssClass: "myFont" 
            });
            // $('.select-results__option').css('font-weight', 'bold');

            // function formatOutput (optionElement) {
            //     if (!optionElement.id) { return optionElement.text; }
            //     var $state = $(
            //         '<span><strong>' + optionElement.element.value + '</strong> ' + optionElement.text + '</span>'
            //     );
            //     return $state;
            //     };

        });

        $('.addRow').on('click', function() {
            addRow();
            $('select').select2({
                // dropdownCssClass: "myFont" 
                // templateResult: formatOutput
            });
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
