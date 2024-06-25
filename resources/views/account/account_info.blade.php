@extends('layouts.accountnew')
@section('title', 'PK-OFFICER || Account')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
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

        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('acc.account_info') }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col"></div>

                        <div class="col-md-1 text-end mt-2">วันที่</div>
                        <div class="col-md-4 text-end">
                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control inputmedsalt" name="startdate" id="datepicker" placeholder="Start Date"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                <input type="text" class="form-control inputmedsalt" name="enddate" placeholder="End Date" id="datepicker2"
                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                    data-date-language="th-th" value="{{ $enddate }}" required/>
                                <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary inputmedsalt" data-style="expand-left" id="Pulldata">
                                    <span class="ladda-label"><i class="pe-7s-search btn-icon-wrapper me-2"></i>ค้นหา</span>
                                    <span class="ladda-spinner"></span>
                                </button> 
                            {{-- <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                            </button> --}}
                        </div>
                    </div>
                        <div class="col"></div>
                </form>
            </div>
       
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-2"> </div>
        <div class="col-xl-8">
            <label for="">รายงานจำนวนผู้ป่วยนอก OFC  ไม่มีเลข ใน HOSxP </label>
            <div class="card cardfinan">
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <table id="datatable-buttons2" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <table style="width: 100%;" id="example"
                            class="table table-hover table-striped table-bordered myTable">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    {{-- <th class="text-center">คนไข้ที่มารับบริการ</th> --}}
                                    <th class="text-center">ไม่มี approve code HOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item2)
 

                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td class="text-center">{{$item2->monyear }}</td>

                                        @if ($item2->months == '1')
                                            <td width="15%" class="text-center">มกราคม</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '2')
                                            <td width="15%" class="text-center">กุมภาพันธ์</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '3')
                                            <td width="15%" class="text-center">มีนาคม</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '4')
                                            <td width="15%" class="text-center">เมษายน</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '5')
                                            <td width="15%" class="text-center">พฤษภาคม</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '6')
                                            <td width="15%" class="text-center">มิถุนายน</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '7')
                                            <td width="15%" class="text-center">กรกฎาคม</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '8')
                                            <td width="15%" class="text-center">สิงหาคม</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '9')
                                            <td width="15%" class="text-center">กันยายน</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '10')
                                            <td width="15%" class="text-center">ตุลาคม</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @elseif ($item2->months == '11')
                                            <td width="15%" class="text-center">พฤษจิกายน</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @else
                                            <td width="15%" class="text-center">ธันวาคม</td>
                                            <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td>
                                        @endif
                                            {{-- <td class="text-center">
                                                <a href="{{url('account_info_vnall/'.$item2->monyear.'/'.$item2->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td> --}}
                                            {{-- <td class="text-center">
                                                <a href="{{url('account_info_vn/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item2->vn}}</a>
                                            </td> --}}
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-2"> </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-2"> </div>
        <div class="col-xl-8">
            <label for=""> รายงานจำนวนผู้ป่วยนอก OFC&nbsp;&nbsp;ไม่มีเลข ใน HOSxP&nbsp;&nbsp;ให้ขอ EDC 1000 บาท ทุกราย</label>
            <div class="card cardfinan">
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <table id="datatable-buttons2" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            <table style="width: 100%;height:2%" id="example"
                            class="table table-hover table-striped table-bordered myTable">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">จำนวนผู้ป่วยนอก</th>
                                    <th class="text-center">ไม่มี approve code HOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow2 as $item3)
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td class="text-center">{{$item3->monyear }}</td>

                                        @if ($item3->months == '1')
                                            <td width="15%" class="text-center">มกราคม</td>
                                        @elseif ($item3->months == '2')
                                            <td width="15%" class="text-center">กุมภาพันธ์</td>
                                        @elseif ($item3->months == '3')
                                            <td width="15%" class="text-center">มีนาคม</td>
                                        @elseif ($item3->months == '4')
                                            <td width="15%" class="text-center">เมษายน</td>
                                        @elseif ($item3->months == '5')
                                            <td width="15%" class="text-center">พฤษภาคม</td>
                                        @elseif ($item3->months == '6')
                                            <td width="15%" class="text-center">มิถุนายน</td>
                                        @elseif ($item3->months == '7')
                                            <td width="15%" class="text-center">กรกฎาคม</td>
                                        @elseif ($item3->months == '8')
                                            <td width="15%" class="text-center">สิงหาคม</td>
                                        @elseif ($item3->months == '9')
                                            <td width="15%" class="text-center">กันยายน</td>
                                        @elseif ($item3->months == '10')
                                            <td width="15%" class="text-center">ตุลาคม</td>
                                        @elseif ($item3->months == '11')
                                            <td width="15%" class="text-center">พฤษจิกายน</td>
                                        @else
                                            <td width="15%" class="text-center">ธันวาคม</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="{{url('account_info_vn_subofc/'.$item3->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item3->vn}}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{url('account_info_noapproveofc/'.$item3->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item3->no_appprove}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-2"> </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-2"> </div>
        <div class="col-xl-8">
            <label for="">  รายงานจำนวนผู้ป่วยนอก OFC ส่งเบิก ติด C    </label>
            <div class="card cardfinan">
                <div class="card-body">
                    <div class="table-responsive">
                            <table style="width: 100%;height:2%" id="example"
                            class="table table-hover table-striped table-bordered myTable">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">ส่งเบิก ติด C</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow3 as $item4)
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td class="text-center">{{$item4->monyear }}</td>

                                        @if ($item4->months == '1')
                                            <td width="15%" class="text-center">มกราคม</td>
                                        @elseif ($item4->months == '2')
                                            <td width="15%" class="text-center">กุมภาพันธ์</td>
                                        @elseif ($item4->months == '3')
                                            <td width="15%" class="text-center">มีนาคม</td>
                                        @elseif ($item4->months == '4')
                                            <td width="15%" class="text-center">เมษายน</td>
                                        @elseif ($item4->months == '5')
                                            <td width="15%" class="text-center">พฤษภาคม</td>
                                        @elseif ($item4->months == '6')
                                            <td width="15%" class="text-center">มิถุนายน</td>
                                        @elseif ($item4->months == '7')
                                            <td width="15%" class="text-center">กรกฎาคม</td>
                                        @elseif ($item4->months == '8')
                                            <td width="15%" class="text-center">สิงหาคม</td>
                                        @elseif ($item4->months == '9')
                                            <td width="15%" class="text-center">กันยายน</td>
                                        @elseif ($item4->months == '10')
                                            <td width="15%" class="text-center">ตุลาคม</td>
                                        @elseif ($item4->months == '11')
                                            <td width="15%" class="text-center">พฤษจิกายน</td>
                                        @else
                                            <td width="15%" class="text-center">ธันวาคม</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="{{url('account_info_vn_subofc_vn/'.$item4->monyear.'/'.$item4->months.'/'.$strdateadmit.'/'.$enddateadmit)}}" target="_blank">{{ $item4->errorc}}</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xl-2"> </div>
    </div>



@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>

@endsection
