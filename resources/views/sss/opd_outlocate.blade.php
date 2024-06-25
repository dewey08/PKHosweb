@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || ประกันสังคม')
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
    <div class="container-fluid">
    
    <div class="row">
        <div class="col-xl-12">
            <form action="{{ route('sss.opd_outlocate') }}" method="POST" >
                @csrf
            <div class="row">                   
                    <div class="col"></div>
                    <div class="col-md-1 text-end">วันที่</div>

                    <div class="col-md-3 text-end"> 
                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                data-date-language="th-th" value="{{ $startdate }}" required/>
                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                data-date-language="th-th" value="{{ $enddate }}" required/>  
                        </div> 
                    </div>

                    {{-- <div class="col-md-2 text-center"> 
                        <div class="input-group" id="datepicker1">
                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate" id="startdate"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" value="{{$startdate}}">

                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>  
                    </div>
                    <div class="col-md-1 text-center">ถึงวันที่</div>
                    <div class="col-md-2 text-center"> 
                        <div class="input-group" id="datepicker1">
                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate" id="enddate"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" value="{{$enddate}}">

                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div> 
                    </div> --}}
                    <div class="col-md-2"> 
                        <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                            <i class="fa-solid fa-magnifying-glass text-primary me-2"></i>
                            ค้นหา
                        </button>
                    </div>
                    <div class="col"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <h5 class="mb-sm-0">รายงาน ปกส.นอกเขต OPD </h5>
        <div class="col-xl-12 mt-2">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive">
                        {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                            id="example"> --}}
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">ผู้ป่วย(คน)</th>
                                    <th class="text-center">ผู้ป่วยป่วย(ครั้ง)</th>
                                    <th class="text-center">ต้องเรียกเก็บ</th>
                                    <th class="text-center">คีย์เรียกเก็บฉุกเฉิน</th>
                                    <th class="text-center">ต้องเรียกเก็บทุพพลภาพ</th>
                                    <th class="text-center">คีย์เรียกเก็บทุพพลภาพ</th> 
                                    <th class="text-center">เหลือต้องเรียกเก็บ</th> 
                                    <th class="text-center">ค่าใช้จ่าย</th> 
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
                                                <a href="{{url('opd_outlocate_sub/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->hn }}</a>
                                            </td> 
                                            <td>
                                                <a href="{{url('opd_outlocate_subrep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->vn }}</a> 
                                             </td>                                            
                                            <td class="text-center" >
                                                <a href="{{url('opd_outlocate_subnorep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->sumincome }}</a> 
                                            </td>  
                                            <td class="text-center">
                                                <a href="{{url('opd_outlocate_keyrep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->sumclaim_code }}</a> 
                                            </td>                                                       
                                            <td>
                                                <a href="{{url('opd_outlocate_tupol/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->sumsix }}</a>                                           
                                             </td>  
                                            <td>
                                                <a href="{{url('opd_outlocate_tupolkey/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->sumclam }}</a> 
                                            </td>   
                                            <td>
                                                <a href="{{url('opd_outlocate_total/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->invoice }}</a>  
                                            </td> 
                                            <td>{{ $item->sumin }} </td> 
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>

@endsection
