@extends('layouts.report_font')
@section('title', 'PK-OFFICER || REFER')
@section('content')
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
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Referข้าม CUP ภายในจังหวัด
                        <div class="btn-actions-pane-right">

                        </div>
                    </div>
                    <div class="card-body">
                            <form action="{{ route('rep.refer_opds_cross') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col-md-1 text-end">วันที่</div>
                                    <div class="col-md-4 text-center">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" autocomplete="off"
                                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                data-date-language="th-th" value="{{ $startdate }}" />
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                data-date-language="th-th" value="{{ $enddate }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center mt-1">โรงพยาบาล</div>
                                        <div class="col-md-2 text-center mt-1">
                                            <div class="input-group">
                                                <select id="hospcode" name="hospcode" class="form-select form-select-lg" style="width: 100%">
                                                    @foreach ($hosshow as $items)
                                                        @if ($hospcode == $items->hospcode)
                                                            <option value="{{ $items->hospcode }}" selected> {{ $items->hosname }} </option>
                                                        @else
                                                            <option value="{{ $items->hospcode }}"> {{ $items->hosname }} </option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                        </button>
                                        {{-- <a href="{{url('cross_exportexcel')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                            <i class="fa-solid fa-file-excel me-2"></i>
                                            Export
                                        </a> --}}
                                    </div>
                                    <div class="col"></div>
                                </div>
                            </form>
                            <br>
                            {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                            {{-- <table id="example" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">เลขรับ</th>
                                    <th class="text-center">โรงพยาบาล</th>
                                    <th class="text-center">สิทธิ์</th>
                                    <th class="text-center">vstdate</th> 
                                    <th class="text-center">pdx</th>
                                    <th class="text-center">dx0</th> 
                                    <th class="text-center">income</th>
                                    <th class="text-center">inst</th>
                                    <th class="text-center">CT</th>
                                    <th class="text-center">คงเหลือ</th>
                                    <th class="text-center">ยอดเรียกเก็บ</th> 
                                    <th class="text-center">Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 1;$total1 = 0; $total2 = 0;$total3 = 0;$total4 = 0;$total5 = 0;$total6 = 0;$total7 = 0; ?>
                                @foreach ($datashow_ as $item)
                                    <?php  
                                    $data_ = DB::connection('mysql3')->select('
                                        SELECT sum(sum_price) as sum_price 
                                            FROM vn_stat v  
                                            left join opitemrece op ON op.vn = v.vn
                                            WHERE v.vn="'.$item->vn.'"
                                            and op.income ="02" 
                                        '); 
                                        foreach ($data_ as $key => $value) {
                                            $inst_income = $value->sum_price;
                                        }

                                    $data2_ = DB::connection('mysql3')->select('
                                        SELECT sum(sum_price) as sum_price 
                                            FROM vn_stat v  
                                            left join opitemrece op ON op.vn = v.vn
                                            left join s_drugitems s ON s.icode = op.icode
                                            WHERE v.vn="'.$item->vn.'"
                                            AND s.name LIKE "CT%"
                                           
                                        '); 
                                        foreach ($data2_ as $key => $value2) {
                                            $ct_income = $value2->sum_price;
                                        }
                                        
                                    ?>
                                     {{-- AND op.icode in("3009186","3009187","3009147","3009188","3010113","3009176","3009158","3009148","3009173","3009178","3009160","3009157"
                                     ,"3009191","3009139","3009155","3009193","3009180","3009159","3009167","3009162","3009140","3010044","3009172","3009165","3009166","3009161")  --}}
                                    <tr height="20"> 
                                        <td class="text-font" style="text-align: center;width: 5%;">{{ $number++ }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 7%;" > {{ $item->cid }}</td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 5%;"> {{ $item->hn }}</td>
                                        <td class="text-font text-pedding" style="text-align: left;width: 10%;"> {{ $item->ptname }} </td>
                                        <td class="text-font text-pedding" style="text-align: left;width: 10%;"> {{ $item->icd }} </td>
                                        <td class="text-font text-pedding" style="text-align: left;width: 12%;"> {{ $item->hospmain }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 5%;"> {{ $item->pttype }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 7%;"> {{ $item->vstdate }}</td> 
                                        <td class="text-font text-pedding" style="text-align: center;width: 5%;"> {{ $item->pdx }} </td>
                                        <td class="text-font text-pedding" style="text-align: center;width: 5%;"> {{ $item->dx0 }} </td> 
                                        <td class="text-font text-pedding" style="text-align: right;width: 5%;color:#b00ec5">&nbsp; {{ number_format($item->income,2) }} </td>
                                        <td class="text-font text-pedding" style="text-align: right;width: 5%;color:#36a9f7">&nbsp; {{ number_format($inst_income,2) }} </td>
                                        <td class="text-font text-pedding" style="text-align: right;width: 5%;color:#6187f0">&nbsp; {{ number_format($ct_income,2) }} </td>
                                        <td class="text-font text-pedding" style="text-align: right;width: 7%;color:#f50d79">&nbsp; {{ number_format($item->income-$item->sum_inst-$ct_income,2) }} </td>
                                       
                                        @if ($item->income-$item->sum_inst-$ct_income < 700)
                                        <td class="text-font text-pedding" style="text-align: right;width: 7%;color:#f1632b">&nbsp;{{ number_format($item->income-$item->sum_inst-$ct_income,2) }} </td>
                                        @elseif($item->income-$item->sum_inst-$ct_income > 1000)
                                        <td class="text-font text-pedding" style="text-align: right;width: 7%;color:#f1632b">1,000.00 </td>
                                        @else 
                                        <td class="text-font text-pedding" style="text-align: right;width: 7%;color:#f1632b">0.00 </td>
                                        @endif
                                   
                                        <td class="text-font text-pedding" style="text-left: center;width: 15%;">
                                             {{ $item->er_emergency_level_id }}
                                             @if ($item->er_emergency_level_id == '1')
                                                แดง Resuscitate (กู้ชีพทันที)
                                            @elseif ($item->er_emergency_level_id == '2')
                                                ชมพู Emergency (ฉุกเฉินเร่งด่วน)
                                            @elseif ($item->er_emergency_level_id == '3')
                                            เหลือง Urgency (ด่วนมาก)
                                            @elseif ($item->er_emergency_level_id == '4')
                                            เขียว Semi Urgency (ด่วน)
                                             @else
                                             ขาว Non Urgency (รอได้) 
                                             @endif
                                            </td>
                                    </tr>
                                        <?php
                                            $total1 = $total1 + ($item->income);
                                            $total2 = $total2 + $item->refer;
                                            $total3 = $total3 + $item->total;
                                            $total4 = $total4 + $inst_income;
                                            $total5 = $total5 + ($item->income-$item->sum_inst-$ct_income);
                                            $total6 = $total6 + $ct_income;                                          

                                            if ($item->income-$item->sum_inst-$ct_income > 1000) {
                                                $itemtotal = 1000;
                                            } else {
                                                $itemtotal = $item->income-$item->sum_inst-$ct_income;
                                            }
                                            $total7 = $total7 + $itemtotal;
                                            
                                        ?>
                                @endforeach

                            </tbody>
                            <tr style="background-color: #f3fca1">
                                <td colspan="10" class="text-end" style="background-color: #ff9d9d"></td>
                                <td class="text-end" style="background-color: #e09be9">{{ number_format($total1,2)}}</td>
                                <td class="text-end" style="background-color: #36a9f7">{{ number_format($total4,2)}}</td>
                                <td class="text-end" style="background-color: #6187f0">{{ number_format($total6,2)}}</td>
                                <td class="text-end" style="background-color: #fd7fba">{{ number_format($total5,2)}}</td>
                                {{-- @if ($total5 < 700) --}}
                                <td class="text-end" style="background-color: #f5a382">{{ number_format($total7,2)}}</td> 
                                {{-- @else
                                <td class="text-end" style="background-color: #f5a382"></td> 
                                @endif --}}
                                                              
                                {{-- <td class="text-end" style="background-color: #bbf0e3">{{ number_format($total3,2)}}</td> --}}
                                <td class="text-end" style="background-color: #ff9d9d"></td>
                            </tr>
                        </table>


                    </div>
                </div>
            </div> 
        </div>
    </div>



@endsection
@section('footer')

    <script>
        $(document).ready(function() {

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#example').DataTable();
            $('#hospcode').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
@endsection
