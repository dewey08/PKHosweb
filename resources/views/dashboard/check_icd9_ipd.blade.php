@extends('layouts.report_font')
@section('title', 'PK-OFFICER || ICD9')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@200&family=Srisakdi:wght@400;700&display=swap" rel="stylesheet">
@section('content')
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
           .detail{
                font-size: 13px;
            }
            .headtable{
                font-size: 14px;
            }
            .modal-dialog {
            max-width: 90%;
        }

        .modal-dialog-slideout {
            min-height: 100%;
            margin: 0 0 0 auto;
            background: #fff;
        }

        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(1);
            transform: translate(100%, 0)scale(1);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
        .cardreport{
            border-radius: 3em 3em 3em 3em;
            box-shadow: 0 0 10px rgb(235, 192, 255);
            /* box-shadow: 0 0 10px rgb(247, 198, 176); */
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
    <form action="{{ route('rep.check_icd9_ipd') }}" method="GET">
        @csrf
    <div class="row"> 
        <div class="col-md-4">
            <h5 class="card-title">อุปกรณ์อวัยวะเที่ยม ICD9 IPD</h5>
            {{-- <p class="card-title-desc">อุปกรณ์อวัยวะเที่ยม ICD9 IPD</p> --}}
        </div>
        <div class="col"></div>
        {{-- <div class="col-md-1 text-end mt-2">วันที่</div> --}}
        <div class="col-md-6 text-end">
            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                {{-- <label for="" class="mt-2 me-2" style="font-size: 13px;">รหัสหัตถการ</label> --}}
                <input type="text" class="form-control cardreport" id="icd9" name="icd9" placeholder="ใส่ ICD9 ที่ต้องการค้นหา" value="{{$icd9}}" required>
                <input type="text" class="form-control cardreport" name="startdate" id="datepicker" placeholder="Start Date"
                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $startdate }}" required/>
                <input type="text" class="form-control cardreport" name="enddate" placeholder="End Date" id="datepicker2"
                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                    data-date-language="th-th" value="{{ $enddate }}" required/>  
          
                <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                    <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                </button> 
            </div> 

        </div>
    </form>
    </div>

     
        <div class="row"> 
            <div class="col-md-12">
                 <div class="card cardreport">
                    {{-- <div class="card-header">
                         อุปกรณ์อวัยวะเที่ยม ICD9 IPD
                         <div class="btn-actions-pane-right">

                            <form action="{{ route('rep.check_icd9_ipd') }}" method="GET">
                                @csrf
                                   
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                        <label for="" class="mt-2 me-2" style="font-size: 13px;">รหัสหัตถการ</label>
                                        <input type="text" class="form-control" id="icd9" name="icd9" placeholder="ใส่ ICD9 ที่ต้องการค้นหา" value="{{$icd9}}" required>
                                        <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $startdate }}" required/>
                                        <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                            data-date-language="th-th" value="{{ $enddate }}" required/>  
                                  
                                        <button class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                        </button> 
                                    </div> 
                                </form>
                                
                            </div>
                    </div> --}}
                    <div class="card-body">
                        
 
                        <div class="table-responsive">
                            {{-- <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example"> --}}
                                {{-- <table id="example" class="table table-striped table-bordered "
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap myTable"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr class="headtable text-center">
                                        <th class="text-center">ลำดับ</th> 
                                        <th>hn</th>
                                        <th>an</th> 
                                        <th>dchdate</th>
                                        <th>pttype</th>
                                        <th>ptname</th>  
                                        <th>Adjrw</th>  
                                        <th>detail inst</th> 
                                        <th>inst hos</th>  
                                        <th>ชดเชย inst</th> 
                                        <th>ชดเชยทั้งหมด</th> 
                                        <th>ไฟล์ STM</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow_ as $item)  
                                   
                                        <tr >
                                            <td width="3%" class="text-center">{{ $ia++ }}</td>
                                            <td width="5%" class="text-center">{{ $item->hn }}</td> 
                                            <td width="8%" class="text-center">{{ $item->an }}</td>   
                                           
                                            <td width="8%" class="text-center">{{ $item->dchdate }}</td>  
                                            <td width="5%" class="text-center">{{ $item->pttype }}</td> 
                                            <td class="p-2" width="10%">{{ $item->ptname }}</td>   
                                            <td width="5%" class="text-center">{{ $item->adjrw }}</td>    
                                            <td class="text-center" > 
                                                <button class="btn-icon btn-sm btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" target="_blank" data-bs-target="#exampleModal{{$item->an}}" >  
                                                   
                                                        Detail inst 
                                               
                                                </button>
                                            </td>  
                                            <td class="text-center" width="10%">{{ $item->inc08 }}</td> 
                                            <td class="text-center" width="9%"> 
                                                @if ($item->inst =='')
                                                    <span class="badge bg-danger rounded-pill"> 0.00 </span>
                                                @else
                                                    <span class="badge bg-success rounded-pill">{{$item->inst}} </span>
                                                @endif
                                            </td> 
                                            <td class="text-center" width="9%"> 
                                                @if ($item->total_approve =='')
                                                    <span class="badge bg-danger rounded-pill"> 0.00 </span>
                                                @else
                                                    <span class="badge bg-success rounded-pill">{{$item->total_approve}} </span>
                                                @endif
                                            </td> 
                                            <td class="text-center" width="12%">{{ $item->STMdoc }}</td> 
                                        </tr>  
                                        
                                        <?php 
                                                $datas = DB::connection('mysql2')->select('
                                                    SELECT o.icode,n.name as nname,n.unitcost,o.unitprice,o.qty,o.sum_price,n.nhso_adp_code
                                                        FROM
                                                        opitemrece o 
                                                        LEFT OUTER JOIN nondrugitems n ON n.icode = o.icode
                                                        WHERE o.an ="'.$item->an.'" AND n.income ="02" 
                                                ');
                                                  
                                        ?>
                                        <div class="modal fade" id="exampleModal{{$item->an}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                {{-- <div class="modal-dialog modal-dialog-slideout"> --}}
                                                <div class="modal-content"> 
                                                        <div class="modal-body p-3">
                                                            <div class="row">
                                                                <div class="col-md-2 ms-2">รหัส</div>
                                                                <div class="col-md-5">ชื่อรายการ</div>
                                                                <div class="col-md-1">unitcost</div>
                                                                <div class="col-md-1">unitprice</div>
                                                                <div class="col-md-1">จำนวน</div>
                                                                <div class="col-md-1">รวม</div>
                                                                <div class="col-md-1"></div>
                                                            </div>
                                                            <hr>
                                                            @foreach ($datas as $item_s)
                                                                <div class="row">
                                                                    <div class="col-md-2 ms-2">{{$item_s->icode}}</div>
                                                                    <div class="col-md-5">{{$item_s->nname}}</div>
                                                                    <div class="col-md-1">{{$item_s->unitcost}}</div>
                                                                    <div class="col-md-1">{{$item_s->unitprice}}</div>
                                                                    <div class="col-md-1">{{$item_s->qty}}</div>
                                                                    <div class="col-md-1">{{$item_s->sum_price}}</div>
                                                                    <div class="col-md-1"></div>
                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                        </div>         
                                                    </div>
                                                </div>
                                            </div>  
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
        // $("#overlay").fadeIn(300);　

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

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        
    });
</script>
@endsection
 
 