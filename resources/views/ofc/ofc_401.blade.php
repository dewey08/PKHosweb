@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || OFC')
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
    .modal-dis {
        width: 1350px;
        margin: auto;
    }
    @media (min-width: 1200px) {
        .modal-xlg {
            width: 90%; 
        }
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
    <div id="preloader">
        <div id="status">
            <div class="spinner"> 
            </div>
        </div>
    </div>
    <form action="{{ url('ofc_401') }}" method="POST">
        @csrf
    <div class="row">      
        <div class="col-md-3">
            <h4 class="card-title" style="color:rgb(252, 161, 119)">Detail OFC OPD</h4>
            <p class="card-title-desc">รายละเอียดข้อมูล OFC OPD ข้าราชการ</p>
        </div> 
        <div class="col"></div>
        <div class="col-md-1 text-end mt-2">วันที่</div>
        <div class="col-md-7 text-end">
            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                <input type="text" class="form-control cardclaim" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $startdate }}" required/>
                <input type="text" class="form-control cardclaim" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $enddate }}"/>          
                <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                    ค้นหา
                </button>  

            </form>

                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success cardacc ProcessChoi" data-url="{{url('ofc_401_process')}}">
                    <i class="fa-solid fa-spinner text-success me-2"></i>
                    ประมวลผล
                </button>                  
                <a href="{{url('ofc_401_export')}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                    <i class="fa-solid fa-file-export text-danger me-2"></i>
                    Export Txt
                </a>                   
                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger" id="ExportdataAPI">
                    <i class="fa-solid fa-upload text-danger me-2"></i>
                    Export Api
                </button>
                <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-primary" id="SenddataAPI">
                    <i class="fa-solid fa-upload text-primary me-2"></i>
                    ส่ง New Eclaim
                </button>

            </div> 
        </div>          
    </div>
 
    <div class="row">
        <div class="col-xl-12">
            <div class="card cardclaim"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                             <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#Main" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Detail OFC</span>    
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
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">ORF</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#OOP" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">OOP</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ODX" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">OOP</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#IDX" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">IDX</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#IPD" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">IPD</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#IRF" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">IRF</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#AER" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">AER</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#IOP" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">IOP</span>    
                                    </a>
                                </li>                           
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ODX" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">ODX</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#PAT" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">PAT</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#CHT" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">CHT</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#CHA" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">CHA</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#INS" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">INS</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ADP" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">ADP</span>    
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#DRU" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">DRU</span>    
                                    </a>
                                </li>                                
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">

                                <div class="tab-pane active" id="Main" role="tabpanel">
                                    <p class="mb-0">
                                        {{-- id="example"  --}}
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th width="5%" class="text-center"><input type="checkbox" class="dcheckbox" name="stampchoi" id="stampchoi"> </th> 
                                                    <th class="text-center">
                                                        <span class="bg-success badge me-2">{{ $count_no }}</span> 
                                                        Approve Code
                                                        <span class="bg-danger badge me-2">{{ $count_null }}</span> 
                                                    </th>
                                                    <th class="text-center">cid</th>
                                                    <th class="text-center">hn</th>
                                                    <th class="text-center">ptname</th>  
                                                    <th class="text-center">pttype</th> 
                                                    <th class="text-center">vstdate</th> 
                                                    <th class="text-center">icd10</th> 
                                                    <th class="text-center">pdx</th>                                                     
                                                    <th class="text-center">Price OFC</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $number = 0; ?>
                                                @foreach ($d_ofc_401 as $item1)
                                                <?php $number++; ?>
                    
                                                <tr id="tr_{{$item1->d_ofc_401_id}}">
                                                    <td class="text-font" style="text-align: center;" width="5%">{{ $number }}</td>
                                                    {{-- @if ($item1->price_ofc == '')
                                                        <td class="text-center" width="5%">
                                                            <input class="form-check-input" type="checkbox" id="flexCheckDisabled" disabled> 
                                                        </td> 
                                                    @else --}}
                                                        <td class="text-center" width="5%"><input type="checkbox" class="dcheckbox choisub_chk" data-id="{{$item1->d_ofc_401_id}}"> </td> 
                                                    {{-- @endif --}}
                                                    <td class="text-center" width="15%">
                                                        @if ($item1->Apphos != NULL)
                                                            <span class="bg-success badge me-2">{{ $item1->Apphos }}</span> 
                                                        @else
                                                            <span class="bg-danger badge me-2">{{ $item1->Apphos }}</span> 
                                                        @endif
                                                        
                                                    </td> 
                                                    <td class="text-center" width="7%">  {{ $item1->cid }}  </td>
                                                    <td class="text-center" width="8%">{{ $item1->hn }}</td>
                                                    <td class="text-start">{{ $item1->ptname }}</td>  
                                                    <td class="text-center" width="5%">{{ $item1->pttype }}</td> 
                                                    <td class="text-center" width="7%">{{ $item1->vstdate }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->icd10 }}</td>
                                                    <td class="text-center" width="5%">{{ $item1->pdx }}</td>                                                    
                                                    <td class="text-end" width="7%" style="font-size: 15px;color:blue">{{ number_format($item1->price_ofc, 2) }}</td> 
                                                </tr>
                    
                    
                    
                                                @endforeach
                    
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="OPD" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example2" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">DATEOPD</th>  
                                                    <th class="text-center">TIMEOPD</th> 
                                                    <th class="text-center">SEQ</th> 
                                                    <th class="text-center">UUC</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($data_opd as $itemo)
                                                <?php $i++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $i }}</td>
                                                        <td class="text-center" width="10%">  {{ $itemo->HN }}  </td>
                                                        <td class="text-center" width="10%">{{ $itemo->CLINIC }}</td>
                                                        <td class="text-center" width="10%">{{ $itemo->DATEOPD }}</td>  
                                                        <td class="text-center" width="10%">{{ $itemo->TIMEOPD }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemo->SEQ }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemo->UUC }}</td> 
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="ORF" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example3" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">DATEOPD</th>  
                                                    <th class="text-center">REFER</th> 
                                                    <th class="text-center">SEQ</th> 
                                                    <th class="text-center">REFERTYPE</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $a = 0; ?>
                                                @foreach ($data_orf as $itemorf)
                                                <?php $a++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $a }}</td>
                                                        <td class="text-center" width="10%"> {{ $itemorf->HN }}  </td>
                                                        <td class="text-center" width="10%">{{ $itemorf->CLINIC }}</td>
                                                        <td class="text-center" width="10%">{{ $itemorf->DATEOPD }}</td>  
                                                        <td class="text-center" width="10%">{{ $itemorf->REFER }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemorf->SEQ }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemorf->REFERTYPE }}</td> 
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="OOP" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example4" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">DATEOPD</th>  
                                                    <th class="text-center">OPER</th> 
                                                    <th class="text-center">DROPID</th> 
                                                    <th class="text-center">PERSON_ID</th> 
                                                    <th class="text-center">SEQ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $b = 0; ?>
                                                @foreach ($data_oop as $itemoop)
                                                <?php $b++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $b }}</td>
                                                        <td class="text-center" width="10%">{{ $itemoop->HN }}</td>
                                                        <td class="text-center" width="10%">{{ $itemoop->CLINIC }}</td>
                                                        <td class="text-center" width="10%">{{ $itemoop->DATEOPD }}</td>  
                                                        <td class="text-center" width="10%">{{ $itemoop->OPER }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemoop->DROPID }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemoop->PERSON_ID }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemoop->SEQ }}</td> 
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="ODX" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example5" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">DATEDX</th>  
                                                    <th class="text-center">DIAG</th> 
                                                    <th class="text-center">DXTYPE</th> 
                                                    <th class="text-center">DRDX</th> 
                                                    <th class="text-center">PERSON_ID</th>
                                                    <th class="text-center">SEQ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $c = 0; ?>
                                                @foreach ($data_odx as $itemodx)
                                                <?php $c++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $c }}</td>
                                                        <td class="text-center" width="10%">{{ $itemodx->HN }}</td>
                                                        <td class="text-center" width="10%">{{ $itemodx->CLINIC }}</td>
                                                        <td class="text-center" width="10%">{{ $itemodx->DATEDX }}</td>  
                                                        <td class="text-center" width="10%">{{ $itemodx->DIAG }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemodx->DXTYPE }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemodx->DRDX }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemodx->PERSON_ID }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemodx->SEQ }}</td> 
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="IDX" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example6" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">DIAG</th>
                                                    <th class="text-center">DXTYPE</th>
                                                    <th class="text-center">DRDX</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $d = 0; ?>
                                                @foreach ($data_idx as $itemidx)
                                                <?php $d++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $d }}</td>
                                                        <td class="text-center" width="10%">{{ $itemidx->AN }}</td>
                                                        <td class="text-center" width="10%">{{ $itemidx->DIAG }}</td>
                                                        <td class="text-center" width="10%">{{ $itemidx->DXTYPE }}</td>
                                                        <td class="text-center" width="10%">{{ $itemidx->DRDX }}</td>  
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="IPD" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example7" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">DATEADM</th>
                                                    <th class="text-center">TIMEADM</th>  
                                                    <th class="text-center">DATEDSC</th>
                                                    <th class="text-center">TIMEDSC</th>
                                                    <th class="text-center">DISCHS</th>
                                                    <th class="text-center">DISCHT</th>
                                                    <th class="text-center">DEPT</th>
                                                    <th class="text-center">ADM_W</th>
                                                    <th class="text-center">UUC</th>
                                                    <th class="text-center">SVCTYPE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $e = 0; ?>
                                                @foreach ($data_ipd as $itemipd)
                                                <?php $e++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $e }}</td>
                                                        <td class="text-center" width="10%">{{ $itemipd->AN }}</td>
                                                        <td class="text-center" width="10%">{{ $itemipd->HN }}</td>
                                                        <td class="text-center" width="5%">{{ $itemipd->DATEADM }}</td>
                                                        <td class="text-center" width="5%">{{ $itemipd->TIMEADM }}</td> 
                                                        <td class="text-center" width="5%">{{ $itemipd->DATEDSC }}</td>  
                                                        <td class="text-center" width="5%">{{ $itemipd->TIMEDSC }}</td> 
                                                        <td class="text-center" width="10%">{{ $itemipd->DISCHS }}</td> 
                                                        <td class="text-center" width="5%">{{ $itemipd->DISCHT }}</td> 
                                                        <td class="text-center" width="5%">{{ $itemipd->DEPT }}</td> 
                                                        <td class="text-center" width="5%">{{ $itemipd->ADM_W }}</td>
                                                        <td class="text-center" width="5%">{{ $itemipd->UUC }}</td>
                                                        <td class="text-center" width="5%">{{ $itemipd->SVCTYPE }}</td>
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="IRF" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example8" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">REFER</th>
                                                    <th class="text-center">REFERTYPE</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $f = 0; ?>
                                                @foreach ($data_irf as $itemirf)
                                                <?php $f++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $f }}</td>
                                                        <td class="text-center" width="10%">{{ $itemirf->AN }}</td>
                                                        <td class="text-center" width="10%">{{ $itemirf->REFER }}</td>
                                                        <td class="text-center" width="5%">{{ $itemirf->REFERTYPE }}</td> 
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="AER" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example9" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">DATEOPD</th>
                                                    <th class="text-center">AUTHAE</th> 
                                                    <th class="text-center">AEDATE</th> 
                                                    <th class="text-center">AETIME</th> 
                                                    <th class="text-center">AETYPE</th> 
                                                    <th class="text-center">REFER_NO</th> 
                                                    <th class="text-center">REFMAINI</th> 
                                                    <th class="text-center">IREFTYPE</th> 
                                                    <th class="text-center">REFMAINO</th> 
                                                    <th class="text-center">OREFTYPE</th> 
                                                    <th class="text-center">UCAE</th> 
                                                    <th class="text-center">EMTYPE</th> 
                                                    <th class="text-center">SEQ</th> 
                                                    <th class="text-center">AESTATUS</th> 
                                                    <th class="text-center">DALERT</th> 
                                                    <th class="text-center">TALERT</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $g = 0; ?>
                                                @foreach ($data_aer as $itemaer)
                                                <?php $g++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $g}}</td>
                                                        <td class="text-center" width="7%">{{ $itemaer->HN }}</td>
                                                        <td class="text-center" width="7%">{{ $itemaer->AN }}</td>
                                                        <td class="text-center" width="7%">{{ $itemaer->DATEOPD }}</td>
                                                        <td class="text-center" >{{ $itemaer->AUTHAE }}</td> 
                                                        <td class="text-center" >{{ $itemaer->AEDATE }}</td> 
                                                        <td class="text-center" >{{ $itemaer->AETIME }}</td> 
                                                        <td class="text-center" >{{ $itemaer->AETYPE }}</td> 
                                                        <td class="text-center">{{ $itemaer->REFER_NO }}</td> 
                                                        <td class="text-center" >{{ $itemaer->REFMAINI }}</td> 
                                                        <td class="text-center" >{{ $itemaer->IREFTYPE }}</td> 
                                                        <td class="text-center" >{{ $itemaer->REFMAINO }}</td> 
                                                        <td class="text-center" >{{ $itemaer->OREFTYPE }}</td> 
                                                        <td class="text-center" >{{ $itemaer->UCAE }}</td> 
                                                        <td class="text-center" >{{ $itemaer->EMTYPE }}</td> 
                                                        <td class="text-center" width="7%">{{ $itemaer->SEQ }}</td> 
                                                        <td class="text-center" >{{ $itemaer->AESTATUS }}</td> 
                                                        <td class="text-center" >{{ $itemaer->DALERT }}</td> 
                                                        <td class="text-center" >{{ $itemaer->TALERT }}</td>  
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="IOP" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example10" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">OPER</th>
                                                    <th class="text-center">OPTYPE</th> 
                                                    <th class="text-center">DROPID</th> 
                                                    <th class="text-center">DATEIN</th> 
                                                    <th class="text-center">TIMEIN</th> 
                                                    <th class="text-center">DATEOUT</th> 
                                                    <th class="text-center">TIMEOUT</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $e = 0; ?>
                                                @foreach ($data_iop as $itemiop)
                                                <?php $e++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $e }}</td>
                                                        <td class="text-center" width="10%">{{$itemiop->AN }}</td>
                                                        <td class="text-center" width="10%">{{$itemiop->OPER }}</td>
                                                        <td class="text-center" width="5%">{{ $itemiop->OPTYPE }}</td>  
                                                        <td class="text-center" width="10%">{{$itemiop->DROPID }}</td>
                                                        <td class="text-center" width="10%">{{$itemiop->DATEIN }}</td>
                                                        <td class="text-center" width="10%">{{$itemiop->TIMEIN }}</td>
                                                        <td class="text-center" width="10%">{{$itemiop->DATEOUT }}</td>
                                                        <td class="text-center" width="10%">{{$itemiop->TIMEOUT }}</td> 
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="PAT" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example12" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HCODE</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CHANGWAT</th> 
                                                    <th class="text-center">AMPHUR</th> 
                                                    <th class="text-center">DOB</th> 
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
                                                <?php $f = 0; ?>
                                                @foreach ($data_pat as $pat)
                                                <?php $f++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-center" style="text-align: center;" width="5%">{{ $f }}</td>
                                                        <td class="text-center" width="5%">{{$pat->HCODE }}</td>
                                                        <td class="text-center" width="5%">{{$pat->HN }}</td>
                                                        <td class="text-center" width="5%">{{ $pat->CHANGWAT }}</td>  
                                                        <td class="text-center" width="5%">{{$pat->AMPHUR }}</td>
                                                        <td class="text-center" width="10%">{{$pat->DOB }}</td>
                                                        <td class="text-center" width="5%">{{$pat->SEX }}</td>
                                                        <td class="text-center" width="5%">{{$pat->MARRIAGE }}</td>
                                                        <td class="text-center" width="5%">{{$pat->OCCUPA }}</td> 
                                                        <td class="text-center" width="5%">{{$pat->NATION }}</td> 
                                                        <td class="text-center" width="5%">{{$pat->PERSON_ID }}</td> 
                                                        <td class="text-start" >{{$pat->NAMEPAT }}</td> 
                                                        <td class="text-center" width="5%">{{$pat->TITLE }}</td> 
                                                        <td class="text-start" width="5%">{{$pat->FNAME }}</td> 
                                                        <td class="text-start" width="5%">{{$pat->LNAME }}</td> 
                                                        <td class="text-center" width="5%">{{$pat->IDTYPE }}</td>  
                                                    </tr>  
                                                @endforeach 
                                                
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="CHT" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example13" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th> 
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">AN</th> 
                                                    <th class="text-center">DATE</th> 
                                                    <th class="text-center">TOTAL</th> 
                                                    <th class="text-center">PAID</th> 
                                                    <th class="text-center">PTTYPE</th> 
                                                    <th class="text-center">PERSON_ID</th>  
                                                    <th class="text-center">SEQ</th>  
                                                    <th class="text-center">OPD_MEMO</th>  
                                                    <th class="text-center">INVOICE_NO</th>  
                                                    <th class="text-center">INVOICE_LT</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $g = 0; ?>
                                                @foreach ($data_cht as $cht)
                                                <?php $g++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-center" style="text-align: center;" width="5%">{{ $g }}</td> 
                                                        <td class="text-center" width="10%">{{$cht->HN }}</td>
                                                        <td class="text-center" width="5%">{{ $cht->AN }}</td>  
                                                        <td class="text-center" width="10%">{{$cht->DATE }}</td>
                                                        <td class="text-center" width="10%">{{$cht->TOTAL }}</td>
                                                        <td class="text-center" width="5%">{{$cht->PAID }}</td>
                                                        <td class="text-center" width="5%">{{$cht->PTTYPE }}</td>
                                                        <td class="text-center" >{{$cht->PERSON_ID }}</td> 
                                                        <td class="text-center" width="10%">{{$cht->SEQ }}</td> 
                                                        <td class="text-center" width="5%">{{$cht->OPD_MEMO }}</td> 
                                                        <td class="text-start" width="5%">{{$cht->INVOICE_NO }}</td> 
                                                        <td class="text-center" width="5%">{{$cht->INVOICE_LT }}</td>  
                                                    </tr>  
                                                @endforeach 
                                                
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="CHA" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example14" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">DATE</th> 
                                                    <th class="text-center">CHRGITEM</th> 
                                                    <th class="text-center">AMOUNT</th> 
                                                    <th class="text-center">PERSON_ID</th> 
                                                    <th class="text-center">SEQ</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $h = 0; ?>
                                                @foreach ($data_cha as $cha)
                                                <?php $h++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-center" style="text-align: center;" width="5%">{{ $h}}</td> 
                                                        <td class="text-center" width="10%">{{$cha->HN }}</td>
                                                        <td class="text-center" width="10%">{{ $cha->AN }}</td>  
                                                        <td class="text-center" width="10%">{{$cha->DATE }}</td>
                                                        <td class="text-center" width="10%">{{$cha->CHRGITEM }}</td>
                                                        <td class="text-center" width="10%">{{$cha->AMOUNT }}</td>
                                                        <td class="text-center">{{$cha->PERSON_ID }}</td> 
                                                        <td class="text-center" >{{$cha->SEQ }}</td>  
                                                    </tr>  
                                                @endforeach 
                                                
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="INS" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example15" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">INSCL</th>
                                                    <th class="text-center">SUBTYPE</th> 
                                                    <th class="text-center">CID</th> 
                                                    <th class="text-center">DATEIN</th> 
                                                    <th class="text-center">DATEEXP</th> 
                                                    <th class="text-center">HOSPMAIN</th> 
                                                    <th class="text-center">HOSPSUB</th> 
                                                    <th class="text-center">PERMITNO</th> 
                                                    <th class="text-center">SEQ</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ($data_ins as $ins)
                                                <?php $i++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-center" style="text-align: center;" width="5%">{{ $i}}</td> 
                                                        <td class="text-center" width="10%">{{$ins->HN }}</td>
                                                        <td class="text-center" width="10%">{{$ins->INSCL }}</td>  
                                                        <td class="text-center" width="10%">{{$ins->SUBTYPE }}</td>
                                                        <td class="text-center" width="10%">{{$ins->CID }}</td>
                                                        <td class="text-center" width="10%">{{$ins->DATEIN }}</td>
                                                        <td class="text-center">{{$ins->DATEEXP }}</td> 
                                                        <td class="text-center" >{{$ins->HOSPMAIN }}</td>  
                                                        <td class="text-center" >{{$ins->HOSPSUB }}</td> 
                                                        <td class="text-center" >{{$ins->PERMITNO }}</td> 
                                                        <td class="text-center" >{{$ins->SEQ }}</td> 
                                                    </tr>  
                                                @endforeach 
                                                
                                            </tbody>
                                        </table>
                                    </p>
                                </div> 
                                <div class="tab-pane" id="ADP" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example16" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">DATEOPD</th> 
                                                    <th class="text-center">TYPE</th> 
                                                    <th class="text-center">CODE</th> 
                                                    <th class="text-center">QTY</th> 
                                                    <th class="text-center">RATE</th> 
                                                    <th class="text-center">SEQ</th> 
                                                    {{-- <th class="text-center">CAGCODE</th> --}}
                                                    {{-- <th class="text-center">DOSE</th> --}}
                                                    {{-- <th class="text-center">CA_TYPE</th> --}}
                                                    {{-- <th class="text-center">SERIALNO</th> --}}
                                                    <th class="text-center">TOTCOPAY</th>
                                                    {{-- <th class="text-center">USE_STATUS</th> --}}
                                                    <th class="text-center">TOTAL</th>
                                                    {{-- <th class="text-center">QTYDAY</th> --}}
                                                    {{-- <th class="text-center">TMLTCODE</th> --}}
                                                    {{-- <th class="text-center">STATUS1</th> --}}
                                                    {{-- <th class="text-center">BI</th> --}}
                                                    {{-- <th class="text-center">CLINIC</th> --}}
                                                    {{-- <th class="text-center">ITEMSRC</th> --}}
                                                    {{-- <th class="text-center">PROVIDER</th> --}}
                                                    <th class="text-center">GRAVIDA</th>
                                                    <th class="text-center">GA_WEEK</th>
                                                    <th class="text-center">DCIP</th>
                                                    <th class="text-center">LMP</th>
                                                    <th class="text-center">SP_ITEM</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $k = 0; ?>
                                                @foreach ($data_adp as $itemadp)
                                                <?php $k++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $k }}</td>
                                                        <td class="text-center" width="5%">{{$itemadp->HN }}</td>
                                                        <td class="text-center" width="7%">{{$itemadp->AN }}</td>
                                                        <td class="text-center" width="5%">{{ $itemadp->DATEOPD }}</td>  
                                                        <td class="text-center" >{{$itemadp->TYPE }}</td>
                                                        <td class="text-center" >{{$itemadp->CODE }}</td>
                                                        <td class="text-center" >{{$itemadp->QTY }}</td>
                                                        <td class="text-center" >{{$itemadp->RATE }}</td>
                                                        <td class="text-center" >{{$itemadp->SEQ }}</td> 
                                                        {{-- <td class="text-center" >{{$itemadp->CAGCODE }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->DOSE }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->CA_TYPE }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->SERIALNO }}</td>  --}}
                                                        <td class="text-center" >{{$itemadp->TOTCOPAY }}</td> 
                                                        {{-- <td class="text-center" >{{$itemadp->USE_STATUS }}</td>  --}}
                                                        <td class="text-center" >{{$itemadp->TOTAL }}</td> 
                                                        {{-- <td class="text-center" >{{$itemadp->QTYDAY }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->TMLTCODE }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->STATUS1 }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->BI }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->CLINIC }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->ITEMSRC }}</td>  --}}
                                                        {{-- <td class="text-center" >{{$itemadp->PROVIDER }}</td>  --}}
                                                        <td class="text-center">{{$itemadp->GRAVIDA }}</td> 
                                                        <td class="text-center" >{{$itemadp->GA_WEEK }}</td> 
                                                        <td class="text-center" >{{$itemadp->DCIP }}</td> 
                                                        <td class="text-center" >{{$itemadp->LMP }}</td> 
                                                        <td class="text-center" >{{$itemadp->SP_ITEM }}</td>  
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                                <div class="tab-pane" id="DRU" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example17" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">HCODE</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">CLINIC</th> 
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $k = 0; ?>
                                                @foreach ($data_dru as $dru)
                                                <?php $k++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $k }}</td>
                                                        <td class="text-center" width="5%">{{$dru->HCODE }}</td>
                                                        <td class="text-center" width="5%">{{$dru->HN }}</td>
                                                        <td class="text-center" width="7%">{{$dru->AN }}</td>
                                                        <td class="text-center" width="5%">{{ $dru->CLINIC }}</td>  
                                                        <td class="text-center" >{{$dru->DATE_SERV }}</td>
                                                        <td class="text-center" >{{$dru->DID }}</td>
                                                        <td class="text-start" >{{$dru->DIDNAME }}</td>
                                                        <td class="text-center" >{{$dru->AMOUNT }}</td>
                                                        <td class="text-center" >{{$dru->DRUGPRIC }}</td>  
                                                        <td class="text-center">{{$dru->DRUGCOST }}</td> 
                                                        <td class="text-center" >{{$dru->DIDSTD }}</td> 
                                                        <td class="text-center" >{{$dru->UNIT }}</td> 
                                                        <td class="text-center" >{{$dru->UNIT_PACK }}</td> 
                                                        <td class="text-center" >{{$dru->SEQ }}</td>  
                                                    </tr>  
                                                @endforeach 
                                            </tbody>
                                        </table>
                                    </p>
                                </div>

                            </div>

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
        $("#spinner-div").hide(); //Request is complete so hide spinner
        $('#Processdata').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการประมวลผลข้อมูลใช่ไหม ?',
                        text: "You Warn Process Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('claim.ofc_401_process') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ประมวลผลข้อมูลสำเร็จ',
                                                text: "You Process data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
        });

        $('#SenddataAPI').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการส่งข้อมูลไป New Eclaim ใช่ไหม ?',
                        text: "You Warn Send Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, send it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('claim.ofc_401_sendapi') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ส่งข้อมูลไป New Eclaim สำเร็จ',
                                                text: "You Send data New Eclaim success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
        });

        $('#ExportdataAPI').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการส่งออก ใช่ไหม ?',
                        text: "You Warn Send Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, send it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('claim.ofc_401_exportapi') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ส่งออกสำเร็จ',
                                                text: "You Export data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
        });

        $('#stampchoi').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".choisub_chk").prop('checked', true);  
                    } else {  
                        $(".choisub_chk").prop('checked',false);  
                    }  
        }); 

        $('.ProcessChoi').on('click', function(e) {
            //alert('oo');
            var allValls = [];
            $(".choisub_chk:checked").each(function () {
                allValls.push($(this).attr('data-id'));
            });
            if (allValls.length <= 0) {
                // alert("SSSS");
                Swal.fire({
                    title: 'คุณยังไม่ได้เลือกรายการ ?',
                    text: "กรุณาเลือกรายการก่อน",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33', 
                    }).then((result) => {
                    
                    })
            } else {
                Swal.fire({
                        title: 'Are you sure Choose in Box?',
                        text: "คุณต้องการประมวลผลตามที่เลือกใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Choose it.!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var check = true;
                        if (check == true) {
                            var join_selected_values = allValls.join(","); 
                            $("#overlay").fadeIn(300);　
                            $("#spinner").show(); //Load button clicked show spinner 
                            $.ajax({
                                url:$(this).data('url'),
                                type: 'POST',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: 'ids='+join_selected_values,
                                success:function(data){ 
                                        if (data.status == 200) {
                                            $(".sub_chk:checked").each(function () {
                                                $(this).parents("tr").remove();
                                            });
                                            Swal.fire({
                                                title: 'ประมวลผลสำเร็จ',
                                                text: "You Process data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                setTimeout(function(){
                                                    $("#overlay").fadeOut(300);
                                                },500);
                                                }
                                            })
                                        } else {                                                    
                                        } 
                                }
                            });
                            $.each(allValls,function (index,value) {
                                $('table tr').filter("[data-row-id='"+value+"']").remove();
                            });
                        }
                    }
                })                     
            }
        });
        
    });
</script>
@endsection