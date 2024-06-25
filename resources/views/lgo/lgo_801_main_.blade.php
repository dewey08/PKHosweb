@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || LGO')
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
    <form action="{{ url('lgo_801_main') }}" method="GET">
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
              
                    <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>  
                    
                </div> 
            </div>
          
        </div>
    </form>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                     OFC ข้าราชการ
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
                                        <span class="d-none d-sm-block">LGO OPD</span>    
                                    </a>
                                </li>    
                                
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
                                                    <th class="text-center">ptname</th>  
                                                    <th class="text-center">pttype</th> 
                                                    <th class="text-center">vstdate</th> 
                                                    <th class="text-center">sum_price</th> 
                                                    <th class="text-center">ค่ารักษา</th> 
                                                    <th class="text-center">PP</th> 
                                                    <th class="text-center">เบิกได้</th> 
                                                    <th class="text-center">เบิกไม่ได้</th> 
                                                    <th class="text-center">ชำระเอง</th> 
                                                    <th class="text-center">pay_ai</th>
                                                    <th class="text-center">IPCS</th> 
                                                    <th class="text-center">IPCS_ORS</th> 
                                                    <th class="text-center">OPCS</th> 
                                                    <th class="text-center">PACS</th> 
                                                    <th class="text-center">INSTCS</th> 
                                                    <th class="text-center">OTCS</th> 
                                                    <th class="text-center">PP</th> 
                                                    <th class="text-center">DRUG</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $number = 0; ?>
                                                @foreach ($d_claim as $item1)
                                                <?php $number++; ?>
                    
                                                <tr height="20" style="font-size: 12px;">
                                                    <td class="text-font" style="text-align: center;" width="5%">{{ $number }}</td>
                                                    <td class="text-center" width="7%">  {{ $item1->vn }}  </td>
                                                    <td class="text-center" width="5%">{{ $item1->hn }}</td>
                                                    <td class="p-2">{{ $item1->ptname }}</td>  
                                                    <td class="text-center" width="5%">{{ $item1->pttype }}</td> 
                                                    <td class="text-center" width="7%">{{ $item1->vstdate }}</td> 
                                                    <td class="text-center" width="7%">{{ $item1->sum_price }}</td> 
                                                    <td class="text-center" width="7%">{{ $item1->income_ad }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->pp_gep_ae }}</td> 
                                                    <td class="text-center" width="5%" style="color: rgb(8, 212, 110)">{{ $item1->claim_true_af }}</td> 
                                                    <td class="text-center" width="5%" style="color: rgb(253, 100, 62)">{{ $item1->claim_false_ag }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->cash_money_ah }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->pay_ai }}</td>
                                                    <td class="text-center" width="5%">{{ $item1->IPCS_ao }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->IPCS_ORS_ap }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->OPCS_aq }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->PACS_ar }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->INSTCS_as }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->OTCS_at }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->PP_au }}</td> 
                                                    <td class="text-center" width="5%">{{ $item1->DRUG_av }}</td>  
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
        var table = $('#example').DataTable({
                scrollY: '60vh',
                scrollCollapse: true,
                scrollX: true,
                "autoWidth": false,
                "pageLength": 100,
                "lengthMenu": [10,100,150,200,300,400,500],
        });

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