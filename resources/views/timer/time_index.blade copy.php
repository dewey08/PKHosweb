@extends('layouts.timesystem')
@section('title', 'PK-OFFICER || Time-Index')
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
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<?php
if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $iddep =  Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;

    $datenow = date("Y-m-d");
    $y = date('Y') + 543;
    $newweek = date('Y-m-d', strtotime($datenow . ' -1 week')); //ย้อนหลัง 1 สัปดาห์  
    $newDate = date('Y-m-d', strtotime($datenow . ' -1 months')); //ย้อนหลัง 1 เดือน 
?>
  
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
                        ลงเวลาเข้า-ออก
                        
                    </div>
                    <div class="card-body">
                        <form action="{{ route('t.time_index') }}" method="POST">
                            @csrf
                            <div class="row mt-3"> 
                                <div class="col"></div>
                                <div class="col-md-1 text-end">วันที่</div>
                                <div class="col-md-2 text-center">
                                    @if ($startdate == '')
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                value="{{ $newDate }}">                    
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    @else
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                value="{{ $startdate }}">                    
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    @endif                                    
                                </div>
                                <div class="col-md-1 text-center">ถึงวันที่</div>
                                <div class="col-md-2 text-center">
                                    @if ($enddate == '')
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                value="{{ $datenow }}">                    
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    @else
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                value="{{ $enddate }}">                    
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    @endif
                                    
                                </div>   
                                <div class="col-md-1 text-center">ฝ่าย</div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group">
                                        <select id="HR_DEPARTMENT_SUB_ID" name="HR_DEPARTMENT_SUB_ID" class="form-select form-select-lg" style="width: 100%"> 
                                            @foreach ($department_sub as $items) 
                                                <option value="{{ $items->HR_DEPARTMENT_SUB_ID }}"> {{ $items->HR_DEPARTMENT_SUB_NAME }} </option> 
                                               
                                            @endforeach
                                    </select>
                                    </div>
                                </div> 
                                <div class="col-md-2 me-2">  
                                    <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                        <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                    </button> 
                                {{-- </div>  --}}
                                {{-- <div class="col-md-1 ">   --}}
                                    <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" id="Export">
                                        <i class="fa-solid fa-file-excel me-2"></i>
                                        Excel
                                    </button> 
                                </div> 
                                
                                 {{-- <div class="col"></div>    --}}
                            </div> 
                       
                        </form>
 
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th> 
                                        <th>วันที่</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>เวลาเข้า</th> 
                                        <th>เวลาออก</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow_ as $item)  
                                        
                                        <tr>
                                            <td>{{ $ia++ }}</td>
                                            <td>{{ $item->CHEACKIN_DATE }}</td> 
                                            <td>{{ $item->hrname }}</td>   
                                            <td>{{ $item->CHEACKINTIME }}</td> 
                                            <?php 
                                                $dataout_ = DB::connection('mysql6')->select(' 
                                                        SELECT c.CHECKIN_PERSON_ID
                                                            ,c.CHEACKIN_DATE
                                                            ,c.CHECKIN_TYPE_ID
                                                            ,c.CHEACKIN_TIME as Timeout
                                                            
                                                            FROM checkin_index c
                                                            LEFT JOIN hrd_person p on p.ID = c.CHECKIN_PERSON_ID
                                                            LEFT JOIN hrd_department_sub_sub d on d.HR_DEPARTMENT_SUB_SUB_ID=p.HR_DEPARTMENT_SUB_SUB_ID
                                                            LEFT OUTER JOIN hrd_department_sub hs on hs.HR_DEPARTMENT_SUB_ID=p.HR_DEPARTMENT_SUB_ID
                                                            LEFT JOIN checkin_type t on t.CHECKIN_TYPE_ID=c.CHECKIN_TYPE_ID
                                                            LEFT JOIN operate_job j on j.OPERATE_JOB_ID=c.OPERATE_JOB_ID
                                                            LEFT JOIN operate_type ot on ot.OPERATE_TYPE_ID=j.OPERATE_JOB_TYPE_ID
                                                            LEFT JOIN hrd_prefix f on f.HR_PREFIX_ID=p.HR_PREFIX_ID
                                                            WHERE c.CHECKIN_TYPE_ID ="2" and c.CHECKIN_PERSON_ID ="'.$item->CHECKIN_PERSON_ID.'"
                                                            GROUP BY c.CHEACKIN_DATE
                                                ');
                                                foreach ($dataout_ as $it){
                                                        $timeout = $it->Timeout;
                                                    } 
                                            
                                            ?>
                                            <td>{{ $timeout }}</td>   
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
        $('#HR_DEPARTMENT_SUB_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        
    });
</script>
@endsection
 
 