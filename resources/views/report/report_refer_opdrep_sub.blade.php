{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.user')
@section('title','PK-OFFICER || ผู้ใช้งานทั่วไป')
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
<?php
    use App\Http\Controllers\karnController;
    use Illuminate\Support\Facades\DB;
?>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">ผู้ป่วยนอกรับ Refer แยก รพ.</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">ผู้ป่วยนอกรับ Refer แยก รพ.</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
       
 
     
        <div class="row">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase">ผู้ป่วยนอกรับ Refer แยก รพ. (visit ซ้ำ) </h6>
                <hr />
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example3" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th> 
                                        <th class="text-center">VN</th> 
                                        <th class="text-center">HN</th> 
                                        <th class="text-center">วันที่รักษา</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td> 
                                            <td>{{ $item->vn }}</td> 
                                            <td>{{ $item->hn }}</td>
                                            <td> {{ DateThai($item->vstdate) }}</td>   
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <h6 class="mb-0 text-uppercase"> ผู้ป่วยนอกรับ Refer แยก รพ. </h6>
                <hr />
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th> 
                                        <th class="text-center">VN</th> 
                                        <th class="text-center">วันที่รักษา</th> 
                                        <th class="text-center">HN</th> 
                                        <th class="text-center">pdx</th>
                                        <th class="text-center">หัตการ</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center">CID</th>
                                        <th class="text-center">ค่าบริการตรวจทั่วไป</th>
                                        <th class="text-center">ค่าเตียงสังเกตอาการ</th>
                                        <th class="text-center">ชันสูตร</th>
                                        <th class="text-center">รังสีรักษา</th>
                                        <th class="text-center">ตรวจวินิจฉัย</th>
                                        <th class="text-center">ผ่าตัดหัถการ</th>
                                        <th class="text-center">อุปกรณ์ อวัยะเทียม</th>
                                        <th class="text-center">ตรวจพิเศษ</th>
                                        <th class="text-center">เวชภัณฑ์มิใช่ยา</th>
                                        <th class="text-center">ยาและเวชภัณฑ์</th>
                                        <th class="text-center">เวชกรรมฟื้นฟู</th>
                                        <th class="text-center">ฝังเข็มบำบัดอื่นๆ</th>
                                   
                                        <th class="text-center">ค่าบริการทางทันตกรรม</th>
                                        <th class="text-center">รวมทั้งสิ้น</th>
                                        <th class="text-center">tran_id</th>
                                        <th class="text-center">CTลบออก</th>
                                        <th class="text-center">MRIลบออก</th>
                                        <th class="text-center">อุปกรณ์ลบออก</th>
                                        <th class="text-center">ฟอกเลือดลบออก</th>
                                        <th class="text-center">lab ฟอกเลือดลบออก</th>
                                        <th class="text-center">b24 ถ้ามีต้องลบออก</th>
                                        <th class="text-center">Covid 19 ถ้ามีต้องลบออก</th>
                                        <th class="text-center">IVP รวมเข้าหลังคิด 700</th>
                                        <th class="text-center">REFER รวมเข้าหลังคิด 700</th>
                                        <th class="text-center">ค่าใช้จ่ายเงื่อนไขข้อตกลงในจังหวัด</th>
                                     
                                        <th class="text-center">เรียกเก็บ eclaim</th>
                                        <th class="text-center">ประมวลจ่าย สปสช</th>
                                        <th class="text-center">จ่ายจาก excel สสจ</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php 
                                    // $data = DB::connection('mysql3')->select('');
                                    $inst =  DB::connection('mysql3')
                                          ->select('
                                          select sum(oo.sum_price) as total 
                                            from eclaimdb.opitemrece_refer oo 
                                            LEFT JOIN nondrugitems n on n.icode = oo.icode
                                            LEFT JOIN vn_stat v on v.vn = oo.vn
                                            where oo.vn = "640803073318"
                                            and oo.icode in(select icode from hos.nondrugitems where income="02") limit 1
                                          ');
                                  ?>
                                 
                                    @foreach ($datashow2 as $item2)
                                    
                                        <tr>
                                            <td>{{ $i++ }}</td> 
                                            <td>{{ $item2->vn }}</td>                                            
                                            <td>{{ DateThai($item2->vstdate) }}</td>
                                            <td>{{ $item2->hn }}</td>
                                            <td>{{ $item2->pdx }} </td>
                                            <td>{{ $item2->op0 }} </td>
                                            <td>{{ $item2->fullname }} </td>
                                            <td>{{ $item2->cid }} </td>
                                            <td class="ms-3">
                                                <a href="{{url('report_refer_opdrep_subsub/'.$item2->vn)}}" target="_blank"> {{ $item2->serall }}</a>                                               
                                             </td>
                                            <td>{{ $item2->bed }} </td>
                                            <td>{{ $item2->chun }} </td>
                                            <td>{{ $item2->rn }} </td>
                                            <td>{{ $item2->tru }} </td>
                                            <td>{{ $item2->pha }} </td>
                                            <td>{{ $item2->tiam }} </td>
                                            <td>{{ $item2->spe }} </td>
                                            <td>{{ $item2->nondrug }} </td>
                                            <td>{{ $item2->drug }} </td>
                                            <td>{{ $item2->wet }} </td>
                                            <td>{{ $item2->khem }} </td>                                            
                                            <td>{{ $item2->den }} </td>
                                            <td>
                                                <a href="{{url('report_refer_opdrep_subsubtotal/'.$item2->vn)}}" target="_blank"> {{ $item2->sums_serviceitem }}</a> 
                                            </td>
                                            <td>
                                                <a href="{{url('report_refer_opdrep_subsubtran/'.$item2->tran_id)}}" target="_blank"> {{$item2->tran_id}} 
                                                </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> {{number_format($item2->sum_price)}}</td>                                         
                                            {{-- <td> {{number_format(ReportController::ins($item->vn))}}</td> --}} 
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$item2->tran_id}}  </td>
                                            <td>{{$item2->sums_serviceitem}}</td>
                                            <td>  </td>
                                            <td>   </td> 
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
            $('#example3').DataTable();

            $('#year_id').select2({
                placeholder: "== เลือกปีที่ต้องการ ==",
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
