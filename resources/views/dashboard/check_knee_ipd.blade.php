@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Detail')
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
</style>
  
<div class="tabs-animation">

    <div class="row text-center">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>  

    </div>
    
     
        <div class="row"> 
            <div class="col-md-12"> 
                 <div class="main-card mb-3 card">
                    <div class="card-header">
                         อุปกรณ์อวัยวะเที่ยม IPD
                         <div class="btn-actions-pane-right">

                            <form action="{{ route('rep.check_knee_ipd') }}" method="POST">
                                @csrf
                                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
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
                    </div>
                    <div class="card-body">
                        
 
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover myTable" id="example">
                                <thead>
                                    <tr class="headtable">
                                        <th>ลำดับ</th> 
                                        <th>hn</th>
                                        <th>an</th>
                                        <th>regdate</th> 
                                        <th>dchdate</th>
                                        <th>pttype</th>
                                        <th>ptname</th> 
                                        <th>icode</th> 
                                        <th>ราคา</th>  
                                        <th>อุปกรณ์</th> 
                                        <th>INCOME</th> 
                                        <th>ชดเชย</th> 
                                        <th>ชดเชย Total</th> 
                                        <th>ไฟล์ STM</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow_ as $item)  
                                        <tr>
                                            <td>{{ $ia++ }}</td>
                                            <td>{{ $item->hn }}</td> 
                                            <td>{{ $item->an }}</td>   
                                            <td>{{ $item->regdate }}</td> 
                                            <td>{{ $item->dchdate }}</td>  
                                            <td>{{ $item->pttype }}</td> 
                                            <td>{{ $item->ptname }}</td>   
                                            <td>{{ $item->icode }}</td>                                            
                                            <td>{{ number_format($item->Priceknee,2) }}</td> 
                                            <td class="p-2">{{ $item->Nameknee }}</td> 
                                            <td>{{ number_format($item->INCOME ,2)}}</td>  
                                            {{-- <td>{{ $item->total_approve }}</td> 
                                            <td>{{ $item->STMdoc }}</td>  --}}
                                            <td> 
                                                @if ($item->inst =='')
                                                    <span class="badge bg-danger rounded-pill"> 0.00 </span>
                                                @else
                                                    <span class="badge bg-success rounded-pill">{{$item->inst}} </span>
                                                @endif
                                            </td> 
                                            <td> 
                                                @if ($item->total_approve =='')
                                                    <span class="badge bg-danger rounded-pill"> 0.00 </span>
                                                @else
                                                    <span class="badge bg-success rounded-pill">{{$item->total_approve}} </span>
                                                @endif
                                            </td> 
                                            <td>{{ $item->STMdoc }}</td> 
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
 
 