@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || ส่งออก 16 แฟ้ม')

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
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    ?>
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
    <div class="tabs-animation">

        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        <form action="{{ route('data.ofc') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-2 text-end">วันที่</div>
                <div class="col-md-7 text-center">
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $startdate }}"/>
                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                        data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $enddate }}"/>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            ค้นหา
                        </button>
                        <a href="{{url('ofc_pull_a')}}" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ประมวลผล 1</a>
                        <a href="{{url('ofc_pull_b')}}" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ประมวลผล 2</a>
                        <a href="{{url('ofc_pull_c')}}" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ประมวลผล 3</a>
                        <a href="{{url('ofc_pull_d')}}" class="btn btn-info"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ประมวลผล 4</a>
                        <a href="{{url('ofc_send')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>Export</a>
                    </div>
                </div>
                <div class="col"></div>
            </div>

        </form>

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail ส่งออก 16 แฟ้ม OFC 401</h4>
                                <p class="card-title-desc">รายละเอียดส่งออก 16 แฟ้ม OFC 401</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                {{-- <button class="btn btn-secondary" id="Changbillitems"><i class="fa-solid fa-wand-magic-sparkles me-3"></i>ปรับ bilitems</button>  --}}
                            </div>
                        </div>

                        {{-- <div id="accordion" class="custom-accordion">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-1 shadow-none">
                                        <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                            <div class="card-header" id="headingOne">
                                                <h6 class="m-0">
                                                    การทดสอบการตั้งครรภ์ (Pregnancy test)***B17=>30014,31101=>Z321,Z320
                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                </h6>
                                            </div>
                                        </a>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <a href="{{url('six_pull')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ดึงข้อมูล</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-1 shadow-none">
                                        <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse"
                                                        aria-expanded="false"
                                                        aria-controls="collapseTwo">
                                            <div class="card-header" id="headingTwo">
                                                <h6 class="m-0">
                                                    ค่าตรวจทางห้องปฏิบัติการ (ตรวจ VDRL และ HIV) ***B55
                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                </h6>
                                            </div>
                                        </a>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <a href="{{url('six_pull')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ดึงข้อมูล</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#DATA" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">DATA</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#INS" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">INS</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#PAT" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">PAT</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#OPD" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">OPD</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ORF" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">ORF</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ODX" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">ODX</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#OOP" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">OOP</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#CHT" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">CHT</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#CHA" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">CHA</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ADP" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">ADP</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#DRU" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">DRU</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IDX" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IDX</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IOP" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IOP</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPD" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IPD</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IRF" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IRF</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#AER" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">AER</span>
                                </a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            {{-- <div class="tab-pane" id="BillItems" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="selection-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">sequence</th>
                                                    <th class="text-center">ServDate</th>
                                                    <th class="text-center">ServTime</th>
                                                    <th class="text-center">BillGr</th>
                                                    <th class="text-center">BillGrCS</th>
                                                    <th class="text-center">CodeSys</th>
                                                    <th class="text-center">CSCode</th>
                                                    <th class="text-center">STDCode</th>
                                                    <th class="text-center">ClaimCat</th>
                                                    <th class="text-center">LCCode</th>
                                                    <th class="text-center">Descript</th>
                                                    <th class="text-center">QTY</th>
                                                    <th class="text-center">UnitPrice</th>
                                                    <th class="text-center">ChargeAmt</th>
                                                    <th class="text-center">Discount</th>
                                                    <th class="text-center">ClaimUP</th>
                                                    <th class="text-center">ClaimAmt</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($aipn_billitems as $item2)
                                                    <tr id="sidb{{$item2->aipn_billitems_id }}">
                                                        <td class="text-center">{{ $i++ }}</td>
                                                        <td class="text-center">{{ $item2->AN }} </td>
                                                        <td class="text-center">{{ $item2->sequence }}</td>
                                                        <td class="text-center">{{ $item2->ServDate }} </td>
                                                        <td class="text-center">{{ $item2->ServTime }} </td>
                                                        <td class="text-center">{{ $item2->BillGr }} </td>
                                                        <td class="p-2">{{ $item2->BillGrCS }}</td>
                                                       @if ($item2->CodeSys == 'TMT' && $item2->STDCode == '')
                                                            <td class="text-center" style="background-color: pink">{{ $item2->CodeSys }} </td>
                                                        @elseif ($item2->CodeSys == 'TMLT' && $item2->STDCode == '')
                                                            <td class="text-center" style="background-color: pink">{{ $item2->CodeSys }} </td>
                                                       @else
                                                            <td class="text-center">{{ $item2->CodeSys }} </td>
                                                       @endif
                                                        <td class="p-2">{{ $item2->CSCode }}</td>
                                                        <td class="text-center">{{ $item2->STDCode }} </td>
                                                        <td class="text-center">{{ $item2->ClaimCat }} </td>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0)" onclick="aipn_billitems_destroy({{ $item2->aipn_billitems_id }})" data-bs-toggle="tooltip" data-bs-placement="left" title="ลบ" class="btn btn-outline-danger btn-sm">
                                                                <i class="fa-solid fa-trash-can text-danger me-2"></i>
                                                                {{ $item2->LCCode }}
                                                            </a>
                                                        </td>
                                                        <td class="p-2">{{ $item2->Descript }}</td>
                                                        <td class="text-center">{{ $item2->QTY }}</td>
                                                        <td class="text-center">{{ number_format($item2->UnitPrice, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ChargeAmt, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->Discount, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ClaimUP, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ClaimAmt, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div> --}}
                            <div class="tab-pane active" id="DATA" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr style="font-family: sans-serif;font-size:12px">
                                                    <th width="5%" class="text-center">ลำดับ</th>
                                                    <th class="text-center" width="5%">VN</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center" >HN</th>
                                                    <th class="text-center" >CID</th>
                                                    <th class="text-center">VSTDATE</th>
                                                    <th class="text-center">PTTYPE</th>
                                                    <th class="text-center">PTNAME</th>
                                                    <th class="text-center" width="5%">icd10</th>
                                                    <th class="text-center">Apphos</th>
                                                    <th class="text-center">Appktb</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($data_show as $item)
                                                    <tr style="font-size: 13px;">
                                                        <td class="text-center">{{ $i++ }}</td>
                                                        <td class="text-center" width="5%">{{ $item->vn }}</td>
                                                        <td class="text-center">{{ $item->an }}</td>
                                                        <td class="text-center">{{ $item->hn }}</td>
                                                        <td class="text-center">{{ $item->cid }}</td>
                                                        <td class="text-center">{{ $item->vstdate }}</td>
                                                        <td class="text-center">{{ $item->pttype }}</td>
                                                        <td class="p-2">{{ $item->fullname }}</td>
                                                        <td class="text-center">{{ $item->icd10 }}</td>
                                                        <td class="text-center">{{ $item->Apphos }}</td>
                                                        <td class="p-2">{{ $item->Appktb }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                             <div class="tab-pane" id="INS" role="tabpanel">
                                 <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr style="font-family: sans-serif;font-size:12px">
                                                    <th width="5%" class="text-center">ลำดับ</th>
                                                    <th class="text-center" width="5%">AN</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center" >INSCL</th>
                                                    <th class="text-center" >SUBTYPE</th>
                                                    <th class="text-center">CID</th>
                                                    <th class="text-center">DATEIN</th>
                                                    <th class="text-center">DATEEXP</th>
                                                    <th class="text-center" width="5%">HOSPMAIN</th>
                                                    <th class="text-center">HOSPSUB</th>
                                                    <th class="text-center">GOVCODE</th>
                                                    <th class="text-center" width="5%">GOVNAME</th>
                                                    <th class="text-center" width="5%">PERMITNO</th>
                                                    <th class="text-center" width="5%">DOCNO</th>
                                                    <th class="text-center">OWNRPID</th>
                                                    <th class="text-center">OWNRNAME</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">SEQ</th>
                                                    <th class="text-center">SUBINSCL</th>
                                                    <th class="text-center">RELINSCL</th>
                                                    <th class="text-center">HTYPE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                {{-- @foreach ($aipn_data as $item)
                                                    <tr style="font-size: 12px;">
                                                        <td class="text-center">{{ $i++ }}</td>
                                                        <td class="text-center" width="5%">{{ $item->AN }}</td>
                                                        <td class="text-center">{{ $item->HN }}</td>
                                                        <td class="text-center">{{ $item->IDTYPE }}</td>
                                                        <td class="text-center">{{ $item->PIDPAT }}</td>
                                                        <td class="text-center">{{ $item->TITLE }}</td>
                                                        <td class="text-center">{{ $item->NAMEPAT }}</td>
                                                        <td class="text-center">{{ $item->DOB }}</td>
                                                        <td class="text-center">{{ $item->SEX }}</td>
                                                        <td class="text-center">{{ $item->MARRIAGE }}</td>
                                                        <td class="p-2">{{ $item->CHANGWAT }}</td>
                                                        <td class="text-center">{{ $item->AMPHUR }}</td>
                                                        <td class="text-center">{{ $item->NATION }}</td>
                                                        <td class="text-center">{{ $item->AdmType }}</td>
                                                        <td class="text-center">{{ $item->AdmSource }}</td>
                                                        <td class="text-center">{{ $item->DTAdm_d }}</td>
                                                        <td class="text-center">{{ $item->DTDisch_d }}</td>
                                                        <td class="text-center">{{ $item->LeaveDay }}</td>
                                                        <td class="text-center">{{ $item->DischStat }}</td>
                                                        <td class="text-center">{{ $item->DishType }}</td>
                                                        <td class="text-center">{{ $item->AdmWt }}</td>
                                                        <td class="text-center">{{ $item->DishWard }}</td>
                                                        <td class="text-center">{{ $item->Dept }}</td>
                                                        <td class="text-center">{{ $item->HMAIN }}</td>
                                                        <td class="text-center">{{ $item->ServiceType }}</td>
                                                    </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>



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
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#ex_1').DataTable();
        $('#ex_2').DataTable();
        $('#ex_3').DataTable();

        // $("#spinner-div").hide(); //Request is complete so hide spinner





    });
</script>
@endsection
