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
            <form action="{{ route('sss.opd_chai_list') }}" method="POST" >
                @csrf
            <div class="row">                   
                    <div class="col"></div> 
                    <div class="col-md-1 text-end">ประเภท </div>
                    <div class="col-md-2 text-center"> 
                        <select id="typesick" name="typesick" class="form-control" style="width: 100%" required>
                            <option value="">--เลือกประเภท--</option>
                            @if ($typesick == 'OPD')
                                <option value="OPD" selected>--OPD--</option>
                                <option value="IPD">--IPD--</option>
                            @else
                                <option value="OPD">--OPD--</option>
                                <option value="IPD" selected>--IPD--</option>
                            @endif
                            
                        </select>
                    </div>
                    
                    <div class="col-md-1 text-end mt-2">วันที่</div>
                    <div class="col-md-3 text-end">
                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                data-date-language="th-th" value="{{ $startdate }}" required/>
                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                data-date-language="th-th" value="{{ $enddate }}"/>  
                        </div> 
                    </div>
                    <div class="col-md-2"> 
                        <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" > 
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            ค้นหา</button>    
                        
                    </div>
                    <div class="col"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <h5 class="mb-sm-0">ปกส.ชัยภูมิ {{$typesick}} อุปกรณ์</h5>
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
                                    {{-- <th class="text-center">ผู้ป่วย(คน)</th> --}}
                                    <th class="text-center">ผู้ป่วย/Visit</th>
                                    <th class="text-center">เรียกเก็บ/Visit</th>
                                    <th class="text-center">ไม่ได้เรียกเก็บ/Visit</th>
                                    <th class="text-center">จำนวนเงิน</th> 
                                </tr>
                            </thead>
                            @if ($typesick =='OPD')
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)   
                                    <?php 
                                        $data_claim_ = DB::connection('mysql3')->select(' 
                                                    SELECT month(o.vstdate),year(o.vstdate),count(vp.vn) as repvn 
                                                    FROM opitemrece o
                                                    left join vn_stat v on v.vn=o.vn
                                                    left outer join visit_pttype vp on vp.vn = o.vn
                                                    left outer join pttype pt on pt.pttype = o.pttype
                                                    left outer join hospcode h on h.hospcode = v.hospmain
                                                    LEFT JOIN nondrugitems n on n.icode = o.icode
                                                    LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                                                    left join patient p on p.hn = v.hn
                                                    WHERE month(o.vstdate) = "'.$item->months.'"
                                                    and o.income="02" 
                                                    and o.pttype="a7"
                                                    and n.billcode  not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                                                    and n.billcode like "8%"
                                                    and n.billcode not in ("8608","8307")
                                                    and o.an is null 
                                                    and vp.claim_code="1"
                                                    and year(o.vstdate) = "'.$item->year.'"
                                            '); 
                                            foreach ($data_claim_ as $key => $value) {
                                                $claim = $value->repvn;
                                            }
                                    ?>                                         
                                            <tr>
                                                <td>{{$i++ }}</td>
                                                <td>{{$item->year}}</td> 

                                                @if ($item->months == '1')
                                                    <td width="15%" class="p-2">มกราคม</td>
                                                @elseif ($item->months == '2')
                                                    <td width="15%" class="p-2">กุมภาพันธ์</td>
                                                @elseif ($item->months == '3')
                                                    <td width="15%" class="p-2">มีนาคม</td>
                                                @elseif ($item->months == '4')
                                                    <td width="15%" class="p-2">เมษายน</td>
                                                @elseif ($item->months == '5')
                                                    <td width="15%" class="p-2">พฤษภาคม</td>
                                                @elseif ($item->months == '6')
                                                    <td width="15%" class="p-2">มิถุนายน</td>
                                                @elseif ($item->months == '7')
                                                    <td width="15%" class="p-2">กรกฎาคม</td>
                                                @elseif ($item->months == '8')
                                                    <td width="15%" class="p-2">สิงหาคม</td>
                                                @elseif ($item->months == '9')
                                                    <td width="15%" class="p-2">กันยายน</td>
                                                @elseif ($item->months == '10')
                                                    <td width="15%" class="p-2">ตุลาคม</td>
                                                @elseif ($item->months == '11')
                                                    <td width="15%" class="p-2">พฤษจิกายน</td>
                                                @else
                                                    <td width="15%" class="p-2">ธันวาคม</td>
                                                @endif
 
                                                <td class="text-center">
                                                    <a href="{{url('opd_chai_listvn/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->vn }}</a>  
                                                </td>                                            
                                                <td class="text-center" >
                                                    <a href="{{url('opd_chai_listrep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $claim }}</a>
                                                   
                                                </td>
                                                <td class="text-center" >
                                                    <a href="{{url('opd_chai_listnorep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->vn - $claim}}</a>
                                                   
                                                </td>   
                                                
                                                <td class="text-center">{{ $item->summony }}</td>  
                                            </tr>
                                    @endforeach
                                </tbody>
                            @else
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item)  
                                    <?php 
                                        // $data_claim_ = DB::connection('mysql3')->select(' 
                                        //     SELECT year(v.dchdate) as year,month(v.dchdate) as months,count(distinct vp.an) as an 
                                               
                                        //             FROM opitemrece o
                                        //             inner join an_stat v on v.an=o.an
                                        //             left outer join ipt_pttype vp on vp.an = o.an  
                                        //             left outer join pttype pt on pt.pttype = o.pttype
                                        //             left outer join hospcode h on h.hospcode = vp.hospmain
                                        //             LEFT JOIN nondrugitems n on n.icode = o.icode
                                        //             LEFT JOIN eclaimdb.l_instrumentitem l on l.`CODE` = n.billcode and l.MAININSCL="sss" 
                                        //             WHERE month(v.dchdate) = "'.$item->months.'"  and year(v.dchdate) = "'.$item->year.'"
                                        //             and o.income="02" 
                                        //             and o.pttype="a7"
                                        //             and n.billcode not in (select `CODE` from eclaimdb.l_instrumentitem where `CODE`= l.`CODE`)
                                        //             and n.billcode like "8%"
                                        //             and n.billcode not in("8608","8628","8361","8543","8152","8660")
                                        //             and vp.nhso_docno is not null 
                                        //             group by month(v.dchdate)                                                                                               
                                                  
                                        //     '); 
                                    
                                        //     foreach ($data_claim_ as $key => $value) {
                                        //         $claim = $value->an;
                                        //     }
                                    ?>                                                   
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td>{{$item->year}}</td> 

                                            @if ($item->months == '1')
                                                <td width="15%" class="p-2">มกราคม</td>
                                            @elseif ($item->months == '2')
                                                <td width="15%" class="p-2">กุมภาพันธ์</td>
                                            @elseif ($item->months == '3')
                                                <td width="15%" class="p-2">มีนาคม</td>
                                            @elseif ($item->months == '4')
                                                <td width="15%" class="p-2">เมษายน</td>
                                            @elseif ($item->months == '5')
                                                <td width="15%" class="p-2">พฤษภาคม</td>
                                            @elseif ($item->months == '6')
                                                <td width="15%" class="p-2">มิถุนายน</td>
                                            @elseif ($item->months == '7')
                                                <td width="15%" class="p-2">กรกฎาคม</td>
                                            @elseif ($item->months == '8')
                                                <td width="15%" class="p-2">สิงหาคม</td>
                                            @elseif ($item->months == '9')
                                                <td width="15%" class="p-2">กันยายน</td>
                                            @elseif ($item->months == '10')
                                                <td width="15%" class="p-2">ตุลาคม</td>
                                            @elseif ($item->months == '11')
                                                <td width="15%" class="p-2">พฤษจิกายน</td>
                                            @else
                                                <td width="15%" class="p-2">ธันวาคม</td>
                                            @endif

                                            <td class="text-center"> 
                                                <a href="{{url('ipd_chai_vn/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->an }}</a> 
                                            </td> 
                                            <td class="text-center">
                                                <a href="{{url('ipd_chai_rep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->claim}}</a>  
                                             </td>                                            
                                            <td class="text-center" >
                                                <a href="{{url('ipd_chai_norep/'.$item->months.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{$item->noclaim}}</a> 
                                                {{-- {{ $item->disvn }} --}}
                                            </td>   
                                            <td class="text-center">{{ $item->summony }}</td>  
                                        </tr>
                                @endforeach
                            </tbody>
                            @endif
                           
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
