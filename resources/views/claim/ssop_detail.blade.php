@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || SSOP')
 
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
 
    <div class="tabs-animation">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Detail Tabs</h4>
                        <p class="card-title-desc">รายละเอียด 16 แฟ้ม </p>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#INS" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">INS</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#PAT" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">PAT</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#OPD" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
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
                            <div class="tab-pane active" id="INS" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center" >HN</th>
                                                    <th class="text-center">INSCL</th>
                                                    <th class="text-center">SUBTYPE</th>
                                                    <th class="text-center">CID</th>
                                                    <th class="text-center" width="10%">DATEIN</th>
                                                    <th class="text-center" width="10%">DATEEXP</th>   
                                                    <th class="text-center" >HOSPMAIN</th>
                                                    <th class="text-center" >HOSPSUB</th>
                                                    <th class="text-center" >GOVCODE</th>
                                                    <th class="text-center" >GOVNAME</th>
                                                    <th class="text-center" >PERMITNO</th>
                                                    <th class="text-center" >DOCNO</th>
                                                    <th class="text-center" >OWNRPID</th>
                                                    <th class="text-center" >OWNRNAME</th>
                                                    <th class="text-center" >AN</th>
                                                    <th class="text-center" >SEQ</th>
                                                    <th class="text-center" >SUBINSCL</th>
                                                    <th class="text-center" >RELINSCL</th>
                                                    <th class="text-center" >HTYPE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($claim_sixteen_ins as $item) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="p-2">{{ $item->HN }}</td>
                                                        <td class="text-center">{{ $item->INSCL }} </td>
                                                        <td class="text-center">{{ $item->SUBTYPE }}</td>
                                                        <td class="text-center">{{ $item->CID }} </td>
                                                        <td class="text-center" width="10%">{{ $item->DATEIN }} </td>
                                                        <td class="text-center" width="10%">{{ $item->DATEEXP }} </td>
                                                        <td class="text-center" >{{ $item->HOSPMAIN }}</td>   
                                                        <td class="text-center" >{{ $item->HOSPSUB }}</td> 
                                                        <td class="text-center" >{{ $item->GOVCODE }}</td> 
                                                        <td class="text-center" >{{ $item->GOVNAME }}</td> 
                                                        <td class="text-center" >{{ $item->PERMITNO }}</td> 
                                                        <td class="text-center" >{{ $item->DOCNO }}</td> 
                                                        <td class="text-center" >{{ $item->OWNRPID }}</td> 
                                                        <td class="text-center" >{{ $item->OWNRNAME }}</td> 
                                                        <td class="text-center" >{{ $item->AN }}</td> 
                                                        <td class="text-center" >{{ $item->SEQ }}</td> 
                                                        <td class="text-center" >{{ $item->SUBINSCL }}</td> 
                                                        <td class="text-center" >{{ $item->RELINSCL }}</td> 
                                                        <td class="text-center" >{{ $item->HTYPE }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="PAT" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center" >HCODE</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CHANGWAT</th>
                                                    <th class="text-center">AMPHUR</th>
                                                    <th class="text-center" width="10%">DOB</th>
                                                    <th class="text-center" width="10%">SEX</th>   
                                                    <th class="text-center" >MARRIAGE</th>
                                                    <th class="text-center" >OCCUPA</th>
                                                    <th class="text-center" >NATION</th>
                                                    <th class="text-center" >PERSON_ID</th>
                                                    <th class="text-center" >NAMEPAT</th>
                                                    <th class="text-center" >TITLE</th>
                                                    <th class="text-center" >FNAME</th>
                                                    <th class="text-center" >LNAME</th>
                                                    <th class="text-center" >IDTYPE</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($claim_sixteen_pat as $item2) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="p-2">{{ $item2->HCODE }}</td>
                                                        <td class="text-center">{{ $item2->HN }} </td>
                                                        <td class="text-center">{{ $item2->CHANGWAT }}</td>
                                                        <td class="text-center">{{ $item2->AMPHUR }} </td>
                                                        <td class="text-center" width="10%">{{ $item2->DOB }} </td>
                                                        <td class="text-center" width="10%">{{ $item2->SEX }} </td>
                                                        <td class="text-center" >{{ $item2->MARRIAGE }}</td>   
                                                        <td class="text-center" >{{ $item2->OCCUPA }}</td> 
                                                        <td class="text-center" >{{ $item2->NATION }}</td> 
                                                        <td class="text-center" >{{ $item2->PERSON_ID }}</td> 
                                                        <td class="p-2" >{{ $item2->NAMEPAT }}</td> 
                                                        <td class="text-center" >{{ $item2->TITLE }}</td> 
                                                        <td class="text-center" >{{ $item2->FNAME }}</td> 
                                                        <td class="text-center" >{{ $item2->LNAME }}</td> 
                                                        <td class="text-center" >{{ $item2->IDTYPE }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="OPD" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="selection-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center" width="15%">DATEOPD</th>
                                                    <th class="text-center" width="15%">TIMEOPD</th>
                                                    <th class="text-center">SEQ</th>   
                                                    <th class="text-center" >UUC</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($claim_sixteen_opd as $item3) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item3->HN }} </td>
                                                        <td class="text-center">{{ $item3->CLINIC }}</td>
                                                        <td class="text-center" width="15%">{{ $item3->DATEOPD }} </td>
                                                        <td class="text-center" width="15%">{{ $item3->TIMEOPD }} </td>
                                                        <td class="text-center" >{{ $item3->SEQ }} </td>
                                                        <td class="text-center" >{{ $item3->UUC }}</td>   
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="ORF" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">DATEOPD</th>
                                                    <th class="text-center" width="15%">CLINIC</th>
                                                    <th class="text-center" width="15%">REFER</th>
                                                    <th class="text-center">REFERTYPE</th>   
                                                    <th class="text-center" >SEQ</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($claim_sixteen_orf as $item4) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item4->HN }} </td>
                                                        <td class="text-center">{{ $item4->DATEOPD }}</td>
                                                        <td class="text-center" >{{ $item4->CLINIC }} </td>
                                                        <td class="text-center" >{{ $item4->REFER }} </td>
                                                        <td class="text-center" >{{ $item4->REFERTYPE }} </td>
                                                        <td class="text-center" >{{ $item4->SEQ }}</td>   
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="ODX" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">DATEDX</th>
                                                    <th class="text-center" width="15%">CLINIC</th>
                                                    <th class="text-center" width="15%">DIAG</th>
                                                    <th class="text-center">DXTYPE</th>   
                                                    <th class="text-center" >DRDX</th> 
                                                    <th class="text-center" >PERSON_ID</th> 
                                                    <th class="text-center" >SEQ</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($claim_sixteen_odx as $item5) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item5->HN }} </td>
                                                        <td class="text-center">{{ $item5->DATEDX }}</td>
                                                        <td class="text-center" >{{ $item5->CLINIC }} </td>
                                                        <td class="text-center" >{{ $item5->DIAG }} </td>
                                                        <td class="text-center" >{{ $item5->DXTYPE }} </td>
                                                        <td class="text-center" >{{ $item5->DRDX }}</td>   
                                                        <td class="text-center" >{{ $item5->PERSON_ID }}</td>  
                                                        <td class="text-center" >{{ $item5->SEQ }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="OOP" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.OOP
                                </p>
                            </div>
                            <div class="tab-pane" id="CHT" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="CHA" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="ADP" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="DRU" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="IDX" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="IOP" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="IPD" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="IRF" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                            <div class="tab-pane" id="AER" role="tabpanel">
                                <p class="mb-0">
                                    Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                    art party before they sold out master cleanse gluten-free squid
                                    scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                    art party locavore wolf cliche high life echo park Austin. Cred
                                    vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                    farm-to-table VHS.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
                {{-- <div class="row mt-3">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body py-0 px-2 mt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                        id="example"> 
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>  
                                                <th class="text-center" width="15%">HN</th> 
                                                <th class="text-center" width="15%">SEQ</th> 
                                                <th class="text-center" width="10%">CLINIC</th>
                                                <th class="text-center" width="10%">DATEOPD</th>
                                                <th class="text-center" width="10%">TIMEOPD</th>   
                                                <th class="text-center" width="10%">UUC</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($ssop_data as $item) 
                                                <tr id="sid{{ $item->SEQ }}">   
                                                    <td class="text-center">{{ $i++ }}</td>   
                                                    <td class="text-center">{{ $item->HN }} </td> 
                                                    <td class="text-center">{{ $item->SEQ }} </td> 
                                                    <td class="text-center">{{ $item->CLINIC }} </td>
                                                    <td class="text-center">{{ $item->DATEOPD }} </td>        
                                                    <td class="text-center">{{ $item->TIMEOPD }} </td>
                                                    <td class="text-center">{{ $item->UUC }}</td>   
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
               
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
    });
</script>
@endsection
