@extends('layouts.report_font')
@section('title', 'PK-OFFICER || ทาลัสซีเมีย')
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
    <form action="{{ url('thalassemia_ipd') }}" method="POST">
            @csrf
    <div class="row"> 
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-6 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                {{-- </div>  --}}
            {{-- </div> --}}
            {{-- <div class="col-md-4">  --}}
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>  
                    {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success" id="Processdata">
                        <i class="fa-solid fa-spinner text-success me-2"></i>
                        ประมวลผล
                    </button>
                    <a href="{{url('thalassemia_opd_export')}}" class="btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                        <i class="fa-solid fa-file-export text-danger me-2"></i>
                        Export
                    </a> --}}
                </div> 
            </div>
          
        </div>
    </form>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    Thalassemia IPD
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
                                        <span class="d-none d-sm-block">Thalassemia ipd</span>    
                                    </a>
                                </li>   
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="Main" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    <th class="text-center">ลำดับ</th>
                                                    <th class="text-center">an</th>
                                                    <th class="text-center">hn</th>
                                                    <th class="text-center">cid</th>
                                                    <th class="text-center">ptname</th>  
                                                    <th class="text-center">pttype</th> 
                                                    <th class="text-center">dchdate</th> 
                                                    <th class="text-center">icd10</th> 
                                                    <th class="text-center">drugname</th> 
                                                    <th class="text-center">sum_price</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $number = 0; ?>
                                                @foreach ($d_talassemia as $item1)
                                                <?php $number++; ?>
                    
                                                <tr height="20" style="font-size: 12px;">
                                                    <td class="text-font" style="text-align: center;" width="5%">{{ $number }}</td>
                                                    <td class="text-center" width="10%"> {{ $item1->an }}  </td>
                                                    <td class="text-center" width="5%">{{ $item1->hn }}</td>
                                                    <td class="text-center" width="10%">{{ $item1->cid }}</td>
                                                    <td class="text-start" width="10%">{{ $item1->ptname }}</td>  
                                                    <td class="text-center" width="5%">{{ $item1->pttype }}</td> 
                                                    <td class="text-center" width="10%">{{ $item1->dchdate }}</td> 
                                                    <td class="text-start" width="5%">{{ $item1->icd10 }}</td> 
                                                    <td class="text-start" width="35%">{{ $item1->drugname }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->sum_price }}</td>  
                                                </tr>
                    
                    
                    
                                                @endforeach
                    
                                            </tbody>
                                        </table>
                                    </p>
                                </div>
                   
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
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
                                <div class="tab-pane active" id="ADP" role="tabpanel">
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
                                </div>
                            </div>
                        </div>
                    </div>
                        --}}

                   
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
       
        
    });
</script>
@endsection