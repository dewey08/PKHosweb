@extends('layouts.report_font')
@section('title', 'PK-OFFICER || REFER')
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
                        Report REFER BACKOFFice
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">  
                                {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="pe-7s-science btn-icon-wrapper"></i>Token
                                </button> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('rep.report_refer') }}" method="GET" >
                            @csrf
                            <div class="row mt-3"> 
                                <div class="col"></div>
                                <div class="col-md-1 text-end">วันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $start }}">
                    
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-1 text-center">ถึงวันที่</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                            value="{{ $end }}">
                    
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>    
                                <div class="col-md-4">
                                
                                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                    </button>
                                    {{-- <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" id="PullChecksitbtn"> id="UpdateVN"
                                        <i class="pe-7s-shuffle btn-icon-wrapper"></i>ดึงข้อมูล
                                    </button> --}}
                                    {{-- <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                        <i class="pe-7s-check btn-icon-wrapper"></i>Update VN TO Authen_report
                                    </button> --}}

                                </div>  
                                 <div class="col"></div>   
                            </div> 
                        </form>
                        
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        {{-- <th>สถานะ</th>  --}}
                                        <th>ทะเบียน</th>
                                        <th>ประเภท</th> 
                                        <th>บันทึกไป</th>
                                        <th>บันทึกกลับ</th>
                                        <th>วันที่ไป</th> 
                                        <th>เวลา</th> 
                                        <th>ถึงวันที่</th>
                                        <th>เวลา</th> 
                                        <th>พนักงานขับรถ</th> 
                                        <th>หมายเหตุ</th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0; ?>
                                    @foreach ($datashow_ as $inforefer)
                                    <?php $number++; ?>
    
                                        <tr height="20">
                                            <td class="text-font" style="text-align: center;">{{$number}}</td>
    
                                            {{-- @if($inforefer->REFER == 'CANCEL')
                                            <td style="border-color:#000000;text-align: center;"><span class="badge badge-danger" >ยกเลิก</span></td>
                                            @else
                                            <td  style="border-color:#000000;text-align: center;"><span class="badge badge-success" >ส่งต่อ</span></td>                            
                                            @endif --}}
    
    
                                            <td class="text-font text-pedding" style="border-color:#000000;text-align:left;">{{ $inforefer->CAR_REG }}</td>
    
                                            
                                            @if($inforefer->REFER_TYPE_ID == '1')
                                            <td class="text-font text-pedding" style="border-color:#000000;text-align: left;">REFER</td>
                                            @elseif($inforefer->REFER_TYPE_ID== '2')
                                            <td  class="text-font text-pedding" style="border-color:#000000;text-align: left;">EMS</td>
                                            @elseif($inforefer->REFER_TYPE_ID == '3')
                                            <td  class="text-font text-pedding" style="border-color:#000000;text-align: left;">รับ-ส่ง [ไม่ฉุกเฉิน]</td>
                                           @else
                                           <td class="text-font" style="border-color:#000000;text-align: left;" ></td>
                                            @endif
    
                                            @if($inforefer->CAR_GO_MILE <> '')
                                            <td class="text-font" style="text-align: center;">{{$inforefer->CAR_GO_MILE}}</td>
                                            @else
                                            <td class="text-font text-pedding" style="text-align: left;"></td>
                                            @endif
    
                                            @if($inforefer->CAR_BACK_MILE <> '')
                                            <td class="text-font" style="text-align: center;">{{$inforefer->CAR_BACK_MILE}}</td>
                                            @else
                                            <td class="text-font text-pedding" style="text-align: left;"></td>
                                            @endif 
    
                                            <td class="text-font" style="text-align: center;">{{ DateThai($inforefer->OUT_DATE) }}</td>
                                            <td class="text-font" style="text-align: center;">{{ formatetime($inforefer->OUT_TIME) }}</td>
                                          
                                            
                                            <td class="text-font" style="text-align: center;">{{ DateThai($inforefer->BACK_DATE) }}</td>
                                            <td class="text-font" style="text-align: center;">{{ formatetime($inforefer->BACK_TIME) }}</td>
    
    
                                            <td class="text-font text-pedding" style="text-align: left;">{{ $inforefer->DRIVER_NAME }}</td>
                                            {{-- <td class="text-font text-pedding" style="text-align: left;">{{ $inforefer->USER_REQUEST_NAME }}</td> --}}
                                         
                                            {{-- <td class="text-font text-pedding" style="text-align: right;">{{number_format($inforefer->ADD_OIL_BATH,2)}}</td> --}}
                                            <td class="text-font text-pedding" style="text-align: left;">{{$inforefer->COMMENT}}</td>
                                            
                                           
    
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
     window.setTimeout(function() {             
            window.location.reload();
        },500000);
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#example').DataTable();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner
         
        
    });
</script>
@endsection
 
 