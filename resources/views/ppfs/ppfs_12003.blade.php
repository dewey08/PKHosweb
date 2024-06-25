@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || 12002')
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
    <form action="{{ url('ppfs_12003') }}" method="POST">
            @csrf
    <div class="row"> 
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                </div> 
            </div>
            <div class="col-md-3"> 
                    <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button> 
                    {{-- <a href="{{url('ppfs_12001_process')}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" >
                        <i class="fa-solid fa-spinner text-success me-2"></i>
                        ประมวลผล
                    </a> --}}
                    <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" id="Processdata">
                        <i class="fa-solid fa-spinner text-success me-2"></i>
                        ประมวลผล
                    </button>
                    <a href="{{url('ppfs_12003_export')}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                        <i class="fa-solid fa-file-export text-danger me-2"></i>
                        Export
                    </a>
                  
            </div>
          
        </div>
    </form>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    บริการเจาะเลือดจากหลอดเลือดดำภายหลังอดอาหาร8ชั่วโมง-12003 35-59 ปี
                    <div class="btn-actions-pane-right">
                        {{-- <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary Updatedata" >
                            <i class="fa-solid fa-spinner text-info me-2"></i> 
                            Update Ucep24
                        </button> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                             <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#Main" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">PPFS-12003</span>    
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
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IDX" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">IDX</span>    
                                </a>
                            </li> --}}
                            
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Main" role="tabpanel">
                                <p class="mb-0">
                                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr style="font-size: 13px">
                                                <th class="text-center">ลำดับ</th>
                                                <th class="text-center">vn</th>
                                                <th class="text-center">hn</th>
                                                <th class="text-center">an</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $number = 0; ?>
                                            @foreach ($data_main as $item1)
                                            <?php $number++; ?>
                
                                            <tr height="20" style="font-size: 12px;">
                                                <td class="text-font" style="text-align: center;" width="5%">{{ $number }}</td>
                                                <td class="text-center" width="10%">  {{ $item1->vn }}  </td>
                                                <td class="text-center" width="10%">{{ $item1->hn }}</td>
                                                <td class="text-center" width="10%">{{ $item1->an }}</td>  
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
                                    <table id="example11" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                             
                                        </tbody>
                                    </table>
                                </p>
                            </div>
                            <div class="tab-pane" id="CHT" role="tabpanel">
                                <p class="mb-0">
                                    <table id="example12" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                             
                                        </tbody>
                                    </table>
                                </p>
                            </div>
                            <div class="tab-pane" id="CHA" role="tabpanel">
                                <p class="mb-0">
                                    <table id="example13" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                             
                                        </tbody>
                                    </table>
                                </p>
                            </div>
                            <div class="tab-pane" id="INS" role="tabpanel">
                                <p class="mb-0">
                                    <table id="example14" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                             
                                        </tbody>
                                    </table>
                                </p>
                            </div>
                            
                            
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#ADP" role="tab">
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
                            <div class="tab-content p-3 text-muted">
                                {{-- <div class="tab-pane active" id="ADP" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example11" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                    <th class="text-center">CAGCODE</th>
                                                    <th class="text-center">DOSE</th>
                                                    <th class="text-center">CA_TYPE</th>
                                                    <th class="text-center">SERIALNO</th>
                                                    <th class="text-center">TOTCOPAY</th>
                                                    <th class="text-center">USE_STATUS</th>
                                                    <th class="text-center">TOTAL</th>
                                                    <th class="text-center">QTYDAY</th>
                                                    <th class="text-center">TMLTCODE</th>
                                                    <th class="text-center">STATUS1</th>
                                                    <th class="text-center">BI</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">ITEMSRC</th>
                                                    <th class="text-center">PROVIDER</th>
                                                    <th class="text-center">GRAVIDA</th>
                                                    <th class="text-center">GA_WEEK</th>
                                                    <th class="text-center">DCIP</th>
                                                    <th class="text-center">LMP</th>
                                                    <th class="text-center">SP_ITEM</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $f = 0; ?>
                                                @foreach ($data_adp as $itemadp)
                                                <?php $f++; ?> 
                                                    <tr height="20" style="font-size: 12px;">
                                                        <td class="text-font" style="text-align: center;" width="5%">{{ $f }}</td>
                                                        <td class="text-center" width="5%">{{$itemadp->HN }}</td>
                                                        <td class="text-center" width="7%">{{$itemadp->AN }}</td>
                                                        <td class="text-center" width="5%">{{ $itemadp->DATEOPD }}</td>  
                                                        <td class="text-center" >{{$itemadp->TYPE }}</td>
                                                        <td class="text-center" >{{$itemadp->CODE }}</td>
                                                        <td class="text-center" >{{$itemadp->QTY }}</td>
                                                        <td class="text-center" >{{$itemadp->RATE }}</td>
                                                        <td class="text-center" >{{$itemadp->SEQ }}</td> 
                                                        <td class="text-center" >{{$itemadp->CAGCODE }}</td> 
                                                        <td class="text-center" >{{$itemadp->DOSE }}</td> 
                                                        <td class="text-center" >{{$itemadp->CA_TYPE }}</td> 
                                                        <td class="text-center" >{{$itemadp->SERIALNO }}</td> 
                                                        <td class="text-center" >{{$itemadp->TOTCOPAY }}</td> 
                                                        <td class="text-center" >{{$itemadp->USE_STATUS }}</td> 
                                                        <td class="text-center" >{{$itemadp->TOTAL }}</td> 
                                                        <td class="text-center" >{{$itemadp->QTYDAY }}</td> 
                                                        <td class="text-center" >{{$itemadp->TMLTCODE }}</td> 
                                                        <td class="text-center" >{{$itemadp->STATUS1 }}</td> 
                                                        <td class="text-center" >{{$itemadp->BI }}</td> 
                                                        <td class="text-center" >{{$itemadp->CLINIC }}</td> 
                                                        <td class="text-center" >{{$itemadp->ITEMSRC }}</td> 
                                                        <td class="text-center" >{{$itemadp->PROVIDER }}</td> 
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
                                </div> --}}
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
                                    url: "{{ route('claim.ppfs_12003_process') }}",
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
         

    });
</script>
@endsection