@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || KTB')

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
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>
 

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                      
                        <h4 class="card-title">บริการยาเสริมธาตุเหล็ก</h4>
                        <p class="card-title-desc">รายการกิจกรรมย่อย บริการยาเม็ดเสริมธาตุเหล็กและกรดโฟลิคและการให้คำแนะนำติดตาม</p>


                        <div id="accordion" class="custom-accordion">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-1 shadow-none">
                                        <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOne">
                                            <div class="card-header" id="headingOne">
                                                <h6 class="m-0">                             
                                                   {{-- บริการคัดกรองและประเมินปัจจัยเสี่ยงต่อสุขภาพกาย/สุขภาพจิต --}}
                                                   บริการยาเม็ดเสริมธาตุเหล็กและกรดโฟลิคและการให้คำแนะนำติดตาม
                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                </h6>
                                            </div>
                                        </a>
                                        <div id="collapseOne" class="collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <form action="{{ route('k.ktb_ferrofolic_search') }}" method="POST">
                                                    @csrf 
                                                    <div class="row"> 
                                                        <div class="col-md-2 text-end">วันที่</div>
                                                        <div class="col-md-9 text-center">
                                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                                    data-date-language="th-th" value="{{ $start }}" />
                                                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                                    data-date-language="th-th" value="{{ $end }}" />
                                                                <button type="submit" class="btn btn-info">
                                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                                    ดึงข้อมูล
                                                                </button> 
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-1 text-end"></div>
                                                    </div>
                                                </form>
                                                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                           
                            
                        </div>
                        <div class="row mt-4">
                            <div class="col"></div>
                            <div class="col-md-2">
                                <a href="{{ url('anc_Pregnancy_test_export') }}" class="btn btn-danger"><i
                                    class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก 16 KTB</a>
                            </div> 
                        </div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs mt-2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#Ins" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">INS</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Pat" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">PAT</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Opd" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">OPD</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Odx" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">ODX</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Adp" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">ADP</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#Dru" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">DRU</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Ins" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center" width="5%">HN</th>
                                                <th class="text-center">INSCL</th>
                                                <th class="text-center">SUBTYPE</th>
                                                <th class="text-center">CID</th>
                                                <th class="text-center">DATEIN</th>
                                                <th class="text-center">DATEEXP</th>
                                                <th class="text-center">HOSPMAIN</th>
                                                <th class="text-center" width="7%">HOSPSUB</th>
                                                {{-- <th class="text-center">GOVCODE</th>
                                                <th class="text-center">GOVNAME </th>
                                                <th class="text-center" width="8%">PERMITNO</th>
                                                <th class="text-center" width="8%">DOCNO</th>
                                                <th class="text-center" width="10%">OWNRPID</th>
                                                <th class="text-center">OWNRNAME</th> --}}
                                                <th class="text-center">AN</th>
                                                <th class="text-center">SEQ</th>
                                                <th class="text-center">SUBINSCL</th>
                                                <th class="text-center">RELINSCL</th>
                                                <th class="text-center">HTYPE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($ins_ as $item)
                                                <tr style="font-size: 12px">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center" width="5%">{{ $item->HN }}</td>
                                                    <td class="text-center">{{ $item->INSCL }}</td>
                                                    <td class="text-center">{{ $item->SUBTYPE }}</td>
                                                    <td class="text-center">{{ $item->CID }}</td>
                                                    <td class="text-center">{{ $item->DATEIN }}</td>
                                                    <td class="text-center">{{ $item->DATEEXP }}</td>
                                                    <td class="text-center">{{ $item->HOSPMAIN }}</td>
                                                    <td class="text-center">{{ $item->HOSPSUB }}</td>
                                                    {{-- <td class="text-center">{{ $item->GOVCODE }}</td>
                                                    <td class="p-2">{{ $item->GOVNAME }}</td>
                                                    <td class="text-center">{{ $item->PERMITNO }}</td>
                                                    <td class="text-center">{{ $item->DOCNO }}</td>
                                                    <td class="text-center">{{ $item->OWNRPID }}</td>
                                                    <td class="text-center">{{ $item->OWNRNAME }}</td> --}}
                                                    <td class="text-center">{{ $item->AN }}</td>
                                                    <td class="text-center">{{ $item->SEQ }}</td>
                                                    <td class="text-center">{{ $item->SUBINSCL }}</td>
                                                    <td class="text-center">{{ $item->RELINSCL }}</td>
                                                    <td class="text-center">{{ $item->HTYPE }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="Pat" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="selection-datatable"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">HCODE</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">CHANGWAT</th>
                                                <th class="text-center">AMPHUR</th>
                                                <th class="text-center">SEX</th>
                                                <th class="text-center">MARRIAGE</th>
                                                <th class="text-center">OCCUPA</th>
                                                <th class="text-center">NATION</th>
                                                <th class="text-center">PERSON_ID</th>
                                                <th class="text-center">NAMEPAT</th>
                                                <th class="text-center">TITLE</th>
                                                <th class="text-center">FNAME</th>
                                                <th class="text-center">LNAME</th>
                                                <th class="text-center">IDTYPE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($pat_ as $item2)
                                                <tr style="font-size: 12px">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item2->HCODE }} </td>
                                                    <td class="text-center">{{ $item2->HN }}</td>
                                                    <td class="text-center">{{ $item2->CHANGWAT }} </td>
                                                    <td class="text-center">{{ $item2->AMPHUR }} </td>
                                                    <td class="text-center">{{ $item2->SEX }} </td>
                                                    <td class="text-center">{{ $item2->MARRIAGE }}</td>
                                                    <td class="text-center">{{ $item2->OCCUPA }}</td>
                                                    <td class="text-center">{{$item2->NATION }}</td>
                                                    <td class="text-center">{{ $item2->PERSON_ID}}</td>
                                                    <td class="p-2">{{ $item2->NAMEPAT }}</td>
                                                    <td class="text-center">{{ $item2->TITLE }}
                                                    </td>
                                                    <td class="text-center">{{ $item2->FNAME }}</td>
                                                    <td class="text-center">{{ $item2->LNAME }}</td>
                                                    <td class="text-center">{{ $item2->IDTYPE }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="Opd" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="key-datatable"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">CLINIC</th>
                                                <th class="text-center">DATEOPD</th>
                                                <th class="text-center">TIMEOPD</th>
                                                <th class="text-center">SEQ</th>
                                                <th class="text-center">UUC</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($opd_ as $item3)
                                                <tr style="font-size: 12px">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item3->HN }} </td>
                                                    <td class="text-center">{{ $item3->CLINIC }}</td>
                                                    <td class="text-center">{{ $item3->DATEOPD }} </td>
                                                    <td class="text-center">{{ $item3->TIMEOPD }} </td>
                                                    <td class="text-center">{{ $item3->SEQ }} </td>
                                                    <td class="text-center">{{ $item3->UUC }}</td> 
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="Odx" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">DATEDX</th>
                                                <th class="text-center">CLINIC</th>
                                                <th class="text-center">DIAG</th>
                                                <th class="text-center">DXTYPE</th>
                                                <th class="text-center">DRDX</th>
                                                <th class="text-center">PERSON_ID</th>
                                                <th class="text-center">SEQ</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($odx_ as $item4)
                                                <tr style="font-size: 12px">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item4->HN }}</td>
                                                    <td class="text-center">{{ $item4->DATEDX }} </td>
                                                    <td class="text-center">{{ $item4->CLINIC }} </td>
                                                    <td class="text-center">{{ $item4->DIAG }} </td>
                                                    <td class="p-2">{{ $item4->DXTYPE }}</td>
                                                    <td class="p-2">{{ $item4->DRDX }}</td>
                                                    <td class="text-center">{{ $item4->PERSON_ID }}</td>
                                                    <td class="p-2" width="15%">{{ $item4->SEQ }}</td>
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="Adp" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">AN</th>
                                                <th class="text-center">DATEOPD</th>
                                                <th class="text-center">TYPE</th>
                                                <th class="text-center">CODE</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">RATE</th>
                                                <th class="text-center">SEQ</th>
                                                {{-- <th class="text-center">a1</th>
                                                <th class="text-center">a2</th>
                                                <th class="text-center">a3</th>                                                
                                                <th class="text-center">a4</th>
                                                <th class="text-center">a5</th>
                                                <th class="text-center">a6</th>
                                                <th class="text-center">a7</th> --}}
                                                <th class="text-center">TMLTCODE</th>
                                                <th class="text-center">STATUS1</th>
                                                <th class="text-center">BI</th>
                                                <th class="text-center">CLINIC</th>
                                                <th class="text-center">ITEMSRC</th>
                                                <th class="text-center">PROVIDER</th>
                                                <th class="text-center">GLAVIDA</th>
                                                <th class="text-center">GA_WEEK</th>
                                                <th class="text-center">DCIP</th>
                                                <th class="text-center">LMP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($adp_ as $item5)
                                                <tr style="font-size: 12px">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item5->HN }}</td>
                                                    <td class="text-center">{{ $item5->AN }} </td>
                                                    <td class="text-center">{{ $item5->DATEOPD }} </td>
                                                    <td class="text-center">{{ $item5->TYPE }} </td>
                                                    <td class="p-2">{{ $item5->CODE }}</td>
                                                    <td class="p-2">{{ $item5->QTY }}</td>
                                                    <td class="text-center">{{ $item5->RATE }}</td>
                                                    <td class="p-2">{{ $item5->SEQ }}</td>
                                                    {{-- <td class="text-center">{{ $item5->a1 }}</td>
                                                    <td class="text-center">{{ $item5->a2 }}</td>
                                                    <td class="text-center">{{ $item5->a3 }}</td> 
                                                    <td class="text-center">{{ $item5->a4 }}</td>
                                                    <td class="text-center" width="15%">{{ $item5->a5 }}</td>
                                                    <td class="text-center" width="15%">{{ $item5->a6 }}</td>
                                                    <td class="text-center">{{ $item5->a7 }}</td> --}}
                                                    <td class="text-center">{{ $item5->TMLTCODE }}</td>
                                                    <td class="text-center">{{ $item5->STATUS1 }}</td>
                                                    <td class="text-center">{{ $item5->BI }}</td>
                                                    <td class="text-center">{{ $item5->CLINIC }}</td>
                                                    <td class="text-center">{{ $item5->ITEMSRC }}</td>
                                                    <td class="text-center">{{ $item5->PROVIDER }}</td>
                                                    <td class="text-center">{{ $item5->GLAVIDA }}</td>
                                                    <td class="text-center">{{ $item5->GA_WEEK }}</td>
                                                    <td class="text-center">{{ $item5->DCIP }}</td>
                                                    <td class="text-center">{{ $item5->LMP }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="Dru" role="tabpanel">
                                <p class="mb-0">
                                <div class="table-responsive">
                                    <table id="example3" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">HCODE</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">AN</th>
                                                <th class="text-center">CLINIC</th>
                                                <th class="text-center">PERSON_ID</th>
                                                <th class="text-center">DATE_SERV</th>

                                                <th class="text-center">DID</th>
                                                <th class="text-center">DIDNAME</th>
                                                <th class="text-center">AMOUNT</th>
                                                <th class="text-center">DRUGPRIC</th>
                                                <th class="text-center">DRUGCOST</th>
                                                <th class="text-center">DIDSTD</th>
                                                <th class="text-center">UNIT</th>
                                                <th class="text-center">UNIT_PACK</th>
                                                <th class="text-center">SEQ</th>
                                                <th class="text-center">DRUGREMARK</th>
                                                <th class="text-center">PA_NO</th>

                                                <th class="text-center">TOTCOPAY</th>
                                                <th class="text-center">USE_STATUS</th>
                                                <th class="text-center">STATUS1</th>
                                                <th class="text-center">TOTAL</th>
                                                <th class="text-center">SIGCODE</th>
                                                <th class="text-center">SIGTEXT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($dru_ as $item6)
                                                <tr style="font-size: 12px">
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-center">{{ $item6->HCODE }}</td>
                                                    <td class="text-center">{{ $item6->HN }} </td>
                                                    <td class="text-center">{{ $item6->AN }} </td>
                                                    <td class="text-center">{{ $item6->CLINIC }} </td>
                                                    <td class="text-center">{{ $item6->PERSON_ID }}</td>
                                                    <td class="text-center">{{ $item6->DATE_SERV }}</td>

                                                    <td class="text-center">{{ $item6->DID }}</td>
                                                    <td class="p-2">{{ $item6->DIDNAME }}</td>
                                                    <td class="text-center">{{ $item6->AMOUNT }}</td>
                                                    <td class="text-center">{{ $item6->DRUGPRIC }}</td>
                                                    <td class="text-center">{{ $item6->DRUGCOST }}</td>
                                                    <td class="text-center">{{ $item6->DIDSTD }}</td>
                                                    <td class="text-center">{{ $item6->UNIT }}</td>
                                                    <td class="text-center">{{ $item6->UNIT_PACK }}</td>
                                                    <td class="text-center">{{ $item6->SEQ }}</td>
                                                    <td class="text-center">{{ $item6->DRUGREMARK }}</td>
                                                    <td class="text-center">{{ $item6->PA_NO }}</td>

                                                    <td class="text-center">{{ $item6->TOTCOPAY }}</td>
                                                    <td class="text-center">{{ $item6->USE_STATUS }}</td>
                                                    <td class="text-center">{{ $item6->STATUS1 }}</td>
                                                    <td class="text-center">{{ $item6->TOTAL }}</td>
                                                    <td class="text-center">{{ $item6->SIGCODE }}</td>
                                                    <td class="text-center">{{ $item6->SIGTEXT }}</td>
                                                </tr>
                                            @endforeach
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

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });
 
            
        });
         
    </script>
@endsection
