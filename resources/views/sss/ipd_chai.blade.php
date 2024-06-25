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
            <form action="{{ route('sss.ipd_chai') }}" method="POST" >
                @csrf
            <div class="row">                   
                    <div class="col"></div>
                    <div class="col-md-1 text-end">วันที่</div>
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
                    <div class="col-md-4 text-end">
                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                data-date-language="th-th" value="{{ $startdate }}" required/>
                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                data-date-language="th-th" value="{{ $enddate }}"/>  
                        </div> 
                    </div>
                    <div class="col-md-2"> 
                        <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            ค้นหา
                        </button>
                    </div>
                    <div class="col"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <h5 class="mb-sm-0">รายงานจำนวนผู้ป่วยใน สิทธิประกันสังคม </h5>
        <div class="col-xl-12 mt-2">
            <div class="card">
                <div class="card-body py-0 px-2 mt-2">
                    <div class="table-responsive"> 
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ปี</th>
                                    <th class="text-center">เดือน</th>
                                    <th class="text-center">จำนวนผู้ป่วยใน</th>
                                    <th class="text-center">คีย์เบิกแล้ว</th>
                                    <th class="text-center">ยังไม่คีย์</th>
                                    <th class="text-center">RW</th>
                                    <th class="text-center">เรียกเก็บ</th> 
                                    <th class="text-center">ชดเชย</th> 
                                    <th class="text-center">ร้อยละ</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item)  
                                    <?php 
                                            // $data_claim_ = DB::connection('mysql3')->select('  
                                            //             select year(a.dchdate) as year
                                            //             ,month(a.dchdate) as months
                                            //             ,count(distinct a.an) as an
                                            //             ,sum(a.an and a.an in (select an from ipt_pttype where an is not null and claim_code ="1")) as noman
                                            //             ,sum(a.an and a.an in (select an from ipt_pttype where an is not null and claim_code is null)) as nonoman
                                            //             ,round(sum(ii.adjrw),2) as adjrw
                                            //             ,sum(vp.nhso_ownright_pid) as nhso_ownright_pid,sum(vp.nhso_ownright_name) as nhso_ownright_name
                                            //             ,100*sum(a.an and a.an in (select an from ipt_pttype where an is not null and claim_code ="1"))/count(distinct a.an) as sumclaim_code
                                            //             from an_stat a
                                            //             left outer join pttype p on p.pttype = a.pttype
                                            //             left outer join icd9cm1 i on i.code in("op0","op1","op2","op3","op4","op5","op6")
                                            //             left outer join ipt_pttype vp on vp.an = a.an
                                            //             left outer join ipt ii on ii.an = a.an
                                            //             where and year(a.dchdate) = "'.$item->year.'"
                                            //             and a.pttype in("a7")
                                            //             and month(a.dchdate) = "'.$item->months.'"
                                            //     '); 
                                            //     foreach ($data_claim_ as $key => $value) {
                                            //         $claim = $value->repvn;
                                            //     }
                                        ?>                                             
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td>{{$item->year}}</td> 

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
                                                <a href="{{url('ipd_chai_an/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->an }}</a>                                           
                                             </td>                                            
                                            <td class="text-center" >
                                                <a href="{{url('ipd_chairep/'.$item->months.'/'.$item->year)}}" target="_blank">{{ $item->noman }}</a> 
                                            </td>  
                                            <td class="text-center">
                                                <a href="{{url('ipd_chaino/'.$item->months.'/'.$item->year)}}" target="_blank">{{ $item->nonoman }}</a>   
                                            </td> 
                                            <td class="text-center">{{ $item->adjrw }}</td> 
                                            <td class="text-center">{{ $item->nhso_ownright_pid }}</td> 
                                            <td class="text-center">{{ $item->nhso_ownright_name }}</td>  
                                            <td class="text-center">{{ $item->sumclaim_code }}</td> 
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
