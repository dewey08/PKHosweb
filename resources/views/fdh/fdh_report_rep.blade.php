 
@extends('layouts.fdh')
@section('title', 'PK-OFFICER || FDH')
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
        border-top: 10px #0ca886 solid;
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
    <form action="{{ url('fdh_report_rep') }}" method="GET">
        @csrf
    <div class="row"> 
            <div class="col-md-3">
                <h4 class="card-title" style="color:rgba(21, 177, 164, 0.871)">Detail Financial Data Hub REP</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล FDH REP</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control card_fdh_4" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control card_fdh_4" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
        
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>  
                    </form>

                  
                </div> 
            </div>          
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card_fdh_4">
                {{-- <div class="card-header">
                    Financial Data Hub
                    <div class="btn-actions-pane-right">
                       
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                             <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#Main" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">OPD IPD REP LIST</span>    
                                    </a>
                                </li>   
                                 
                                
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content text-muted">
                                <div class="tab-pane active" id="Main" role="tabpanel">
                                    <p class="mb-0">
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                            <thead>
                                                <tr style="font-size: 13px">
                                                    {{-- <th width="5%" class="text-center"><input type="checkbox" class="fdhcheckbox" name="stamp" id="stamp"> </th>  --}}
                                                    {{-- <th class="text-center">ลำดับ</th> --}}
                                                    <th class="text-center">vn</th>
                                                    {{-- <th class="text-center">an</th> --}}
                                                    <th class="text-center">hn</th>
                                                    <th class="text-center">cid</th>  
                                                    <th class="text-center">vstdate</th> 
                                                    {{-- <th class="text-center">dchdate</th>  --}}
                                                    <th class="text-center">pttype</th>   
                                                    <th class="text-center">ptname</th>  
                                                    <th class="text-center">icd10</th> 
                                                    <th class="text-center">authen</th> 
                                                    <th class="text-center">debit</th> 
                                                    <th class="text-center">debit_rep</th> 
                                                    <th class="text-center">error</th> 
                                                    <th class="text-center">STMdoc</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $number = 0; ?>
                                                @foreach ($d_fdh as $item)
                                                <?php $number++; ?>

                                                @if ($item->STMdoc == '')
                                                <tr height="20" style="font-size: 12px;background-color: rgb(255, 193, 193)"> 
                                                    <td class="text-center" width="8%">{{ $item->vn }}  </td> 
                                                        <td class="text-center" width="5%">{{ $item->hn }}</td>
                                                        <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                        <td class="text-center" width="7%">{{ $item->vstdate }}</td>  
                                                        <td class="text-center" width="5%">{{ $item->pttype }}</td>    
                                                        <td class="text-start">{{ $item->ptname }}</td>  
                                                        <td class="text-center" width="5%">{{ $item->icd10 }}</td> 
                                                        <td class="text-center" width="7%">{{ $item->authen }}</td> 
                                                        <td class="text-center" width="7%">{{ $item->debit }}</td> 
                                                        @if ($item->debit != $item->debit_rep)
                                                        <td class="text-center" width="7%" style="color:#E9540F">{{ $item->debit_rep }}</td> 
                                                        @else
                                                        <td class="text-center" width="7%" style="color:#05978b">{{ $item->debit_rep }}</td> 
                                                        @endif
                                                       
                                                        <td class="text-center" width="5%">{{ $item->error_code }}</td> 
                                                        <td class="text-center" width="10%">{{ $item->STMdoc }}</td> 
                                                    </tr> 
                                                @else
                                                    <tr height="20" style="font-size: 12px;"> 
                                                        <td class="text-center" width="8%">{{ $item->vn }}  </td> 
                                                        <td class="text-center" width="5%">{{ $item->hn }}</td>
                                                        <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                        <td class="text-center" width="7%">{{ $item->vstdate }}</td>  
                                                        <td class="text-center" width="5%">{{ $item->pttype }}</td>    
                                                        <td class="text-start">{{ $item->ptname }}</td>  
                                                        <td class="text-center" width="5%">{{ $item->icd10 }}</td> 
                                                        <td class="text-center" width="7%">{{ $item->authen }}</td> 
                                                        <td class="text-center" width="7%">{{ $item->debit }}</td> 
                                                        @if ($item->debit != $item->debit_rep)
                                                        <td class="text-center" width="7%" style="color:#E9540F">{{ $item->debit_rep }}</td> 
                                                        @else
                                                        <td class="text-center" width="7%" style="color:#05978b">{{ $item->debit_rep }}</td> 
                                                        @endif
                                                    
                                                        <td class="text-center" width="5%">{{ $item->error_code }}</td> 
                                                        <td class="text-center" width="10%">{{ $item->STMdoc }}</td> 
                                                    </tr> 
                                                @endif
                    
                                                    
                    
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

        var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthMenu": [10,25,100,150,200,300,400,500],
        });
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        // $('#example').DataTable();
        $('#hospcode').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });
        $('#stamp').on('click', function(e) {
                    if($(this).is(':checked',true))  
                    {
                        $(".sub_chk").prop('checked', true);  
                    } else {  
                        $(".sub_chk").prop('checked',false);  
                    }  
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