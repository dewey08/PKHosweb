@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Detail')
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
</style>
  
<div class="tabs-animation">
    
        <div class="row text-center">  
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
              
        </div> 
        <div class="row"> 
            <div class="col-md-12"> 
                 <div class="main-card mb-3 card">
                    <div class="card-header">
                        IPD อุปกรณ์อวัยวะเที่ยม 1 เดือน
                      
                    </div>
                    <div class="card-body">
 
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th> 
                                        <th>hn</th>
                                        <th>cid</th>
                                        <th>ชื่อ-นามสกุล</th> 
                                        <th>doctor_name</th> 
                                        <th>vst_date</th>  
                                        <th>pttype_id</th>
                                        <th>pttypeno</th>  
                                        <th>refer_date</th>  
                                        <th>refer_time</th> 
                                        <th>hospcode</th> 
                                        <th>hospname</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow_ as $item)                                     
                                        <tr >
                                            <td width="5%">{{ $i++ }}</td>
                                            <td>{{ $item->hn }}</td> 
                                            <td>{{ $item->cid }}</td> 
                                            <td class="p-2" width="15%">{{ $item->pname }} {{ $item->fname }}{{ $item->lname }}</td> 
                                            <td class="p-2" width="15%"> {{ $item->doctor_name }}</td>     
                                            <td>{{ DateThai($item->vst_date) }}</td>  
                                            <td>{{ $item->pttype_id }}</td> 
                                            <td>{{ $item->pttypeno }}</td>  
                                            <td>{{ DateThai($item->refer_date) }}</td> 
                                            <td>{{ $item->refer_time }}</td> 
                                            <td>{{ $item->hospcode }}</td> 
                                            <td class="p-2">{{ $item->hospname }}</td>  
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

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        
    });
</script>
@endsection
 
 