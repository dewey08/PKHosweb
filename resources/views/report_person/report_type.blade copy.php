@extends('layouts.person')
@section('title', 'PK-OFFICER || บัญชีรายงานวันลา')
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

        /* .table td {
            font-family: sans-serif;
            font-size: 12px;
        } */
        table,tr, th, td {
  border: 1px solid black;
  border-collapse: collapse;
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
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('sss.ipd_outlocate') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                    id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $startdate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                    id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $enddate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-gla
                            ss me-2"></i>
                                ค้นหา
                            </button>
                        </div>
                        <div class="col"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <h5 class="mb-sm-0">บัญชีรายงานวันลา ประจำเดือน โรงพยาบาลภูเขียวเฉลิมพระเกียรติ</h5>
        <div class="col-xl-12 mt-2">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tr>
                                <th rowspan="2">ลำดับ</th>
                                <th rowspan="2">ชื่อ-สกุล</th>
                                <th colspan="3">ลาป่วย</th>
                                <th colspan="3">ลากิจ</th>
                                <th colspan="6">ลาพักผ่อน</th>
                                <th rowspan="2">หมายเหตุ</th>
                                
                            </tr>
                            <tr>
                                <td>จำนวนวันที่ลา</td>
                                <td>ตั้งแต่วันที่-วันที่</td>
                                <td>รวม</td> 
                                <td>จำนวนวันที่ลา(กิจ)</td>
                                <td>ตั้งแต่วันที่-วันที่(กิจ)</td>
                                <td>รวม(กิจ)</td>
                                <td>วันลาสะสม</td>
                                <td>รวมมีสิทธิลาทั้งสิ้นในปีนี้</td>
                                <td>จำนวนวันที่ลา(พักผ่อน)</td>
                                <td>ตั้งแต่วันที่-วันที่(พักผ่อน)</td>
                                <td>รวม(พักผ่อน)</td>
                                <td>คงเหลือ</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>สายยย</td>
                                <td>Jackson</td>
                                <td>2021-10-01</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                            </tr>
                          </table>
                        {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center" rowspan="2">ลำดับ</th>
                                        <th class="text-center" rowspan="2">ชื่อ-สกุล</th>
                                        <th class="text-center">เดือน</th>
                                        <th class="text-center">จำนวนผู้ป่วยใน</th>
                                        <th class="text-center">คีย์เบิกแล้ว</th>
                                        <th class="text-center">ยังไม่คีย์</th>
                                        <th class="text-center">RW</th>
                                        <th class="text-center">เรียกเก็บ</th>
                                        <th class="text-center">ชดเชย</th> 
                                    </tr>                                   
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)                                            
                                            <tr>
                                                <td>{{$i++ }}</td>
                                                <td>{{$item->monyear}}</td> 

                                                @if ($item->months == '1')
                                                    <td width="15%" class="text-center">มกราคม</td>
                                                @elseif ($item->months == '2')
                                                    <td width="15%" class="text-center">กุมภาพันธ์</td>
                                                @elseif ($item->months == '3')
                                                    <td width="15%" class="text-center">มีนาคม</td>
                                                @elseif ($item->months == '4')
                                                    <td width="15%" class="text-center">เมษายน</td>
                                                @elseif ($item->months == '5')
                                                    <td width="15%" class="text-center">พฤษภาคม</td>
                                                @elseif ($item->months == '6')
                                                    <td width="15%" class="text-center">มิถุนายน</td>
                                                @elseif ($item->months == '7')
                                                    <td width="15%" class="text-center">กรกฎาคม</td>
                                                @elseif ($item->months == '8')
                                                    <td width="15%" class="text-center">สิงหาคม</td>
                                                @elseif ($item->months == '9')
                                                    <td width="15%" class="text-center">กันยายน</td>
                                                @elseif ($item->months == '10')
                                                    <td width="15%" class="text-center">ตุลาคม</td>
                                                @elseif ($item->months == '11')
                                                    <td width="15%" class="text-center">พฤษจิกายน</td>
                                                @else
                                                    <td width="15%" class="text-center">ธันวาคม</td>
                                                @endif

                                                <td> 
                                                    <a href="{{url('ipd_outlocate_sub/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->an }}</a>
                                                </td> 
                                                <td>
                                                    <a href="{{url('ipd_outlocate_subrep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->noman1 }}</a> 
                                                </td>                                            
                                                <td class="text-center" >
                                                    <a href="{{url('ipd_outlocate_subnorep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->noman2 }}</a> 
                                                </td>  
                                                <td class="text-center">{{ $item->adjrw }}</td>                                                       
                                                <td>{{ $item->nhso_ownright_pid }} </td>  
                                                <td>{{ $item->nhso_ownright_name }} </td>   
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                        {{-- <table width="100%"> --}}
                            {{-- <div class="container"> 
                                <div class="row">
                                  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1" style="background-color:rgb(235, 180, 180);">ลำดับ</div>
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="background-color:rgb(142, 142, 231)">ชื่อ-สกุล</div> 
                                  <div class="col-lg-2 col-md-2 col-sm-3 col-xs-2" style="padding:0px">
                                    <div class="short-div" style="background-color:rgb(128, 253, 128)">จำนวนวันที่ลา</div>
                                    <div class="short-div" style="background-color:rgb(255, 160, 255)">จำนวนวันที่ลา</div>
                                  </div>
                                  <div class="col-lg-2 col-md-2 col-sm-3 col-xs-2" style="background-color:yellow">Span 2</div>
                                </div>
                              </div>
                              <div class="container-fluid">
                                <div class="row-fluid">
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="short-div" style="background-color:#999">Span 6</div>
                                    <div class="short-div">Span 6</div>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="background-color:#ccc">Span 6</div>
                                </div>
                              </div> --}}
                            {{-- <thead>
                                <tr>
                                  <th>Month</th>
                                  <th>Savings</th>
                                  <th rowspan="3">Savings for holiday!</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>January</td>
                                  <td>$100</td>
                                  <td rowspan="0">$100</td>
                                </tr>
                                <tr>
                                  <td>February</td>
                                  <td>$80</td>
                                </tr>
                              </tbody> --}}
                            {{-- <tr>
                                <td rowspan="2" width="10%"> ลำดับ  </td>
                            </tr>
                            <tr>
                                <td rowspan="2" width="20%">ชื่อ-สกุล </td>
                            </tr>
                            <tr>
                                <td colspan="3" rowspan="2" width="40%">ลาป่วย </td>
                            </tr> --}}
                            {{-- <tr>
                                <td width="10%">จำนวนวันที่ลา </td>
                            </tr> --}}
                            {{-- <tr>
                                <td width="10%">ตั้งแต่วันที่-วันที่ </td>
                            </tr> --}}
                            {{-- <tr>
                                <td width="10%">รวม </td>
                            </tr> --}}
                            {{-- <tr>
                                <td colspan="1"> <label for="" style="font-size: 19px"><b></b></label> </td>
                                <td colspan="4"> <label for="" style="font-size: 22px"><b>&nbsp;
                                            บันทึกข้อความ</b></label></td>
                            </tr> --}}

                        {{-- </table> --}}
                    </div>
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

            $('select').select2();
            $('#ECLAIM_STATUS').select2({
                dropdownParent: $('#detailclaim')
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>

@endsection
