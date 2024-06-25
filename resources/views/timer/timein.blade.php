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
 
        <div class="main-card mb-3 card">
            <div class="card-header">
                ลงเวลาเข้า-ออก 
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="pe-7s-science btn-icon-wrapper"></i>IN-OUT
                        </button>
                        <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#otModal">
                            <i class="pe-7s-science btn-icon-wrapper"></i>INOT-OUTOT
                        </button>
                        {{-- <a data-bs-toggle="tab" href="{{ url('time_dep') }}" class="btn-pill btn-wide active btn btn-outline-alternate btn-sm">กลุ่มภารกิจ</a> --}}
                        {{-- <a href="{{ url('time_depsub') }}" class="btn-pill btn-wide me-1 ms-1  btn btn-outline-alternate btn-sm">กลุ่มงาน/ฝ่าย</a> --}}
                        {{-- <a href="{{ url('time_depsubsub') }}" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm">หน่วยงาน</a> --}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p> 
                            <form action="{{ route('TT.timein') }}" method="GET">
                                @csrf
                                    <div class="row"> 
                                        <div class="col-md-2 text-end">วันที่</div>
                                        <div class="col-md-4 text-center">
                                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                    data-date-language="th-th" value="{{ $enddate }}" required/> 
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-2 me-2">  
                                            <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                            </button> 
                                         
                                        </div>
                                        
                                    </div>
                            </form>  
                            <div class="table-responsive mt-3">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th> 
                                            <th>วันที่</th>
                                            <th>ชื่อ-นามสกุล</th> 
                                            <th>เวลาเข้า</th> 
                                            <th>CHECKIN_TYPE_ID</th>  
                                            <th>OPERATE_TYPE_NAME</th>
                                            <th>OPERATE_JOB_ID</th>  
                                            <th>OPERATE_JOB_NAME</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ia = 1; ?>
                                        @foreach ($datashow_ as $item)  
                                            
                                            <tr >
                                                <td>{{ $ia++ }}</td>
                                                <td>{{ $item->CHEACKIN_DATE }}</td> 
                                                <td class="p-2">{{ $item->hrname }}</td>    
                                                <td>
                                                    <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$item->CHECKIN_ID}}">
                                                        <i class="pe-7s-science btn-icon-wrapper"></i> {{ $item->CHEACKIN_TIME }}
                                                    </button>                                                   
                                                </td>  
                                                <td>{{ $item->CHECKIN_TYPE_ID }}</td>  
                                                <td>{{ $item->OPERATE_TYPE_NAME }}</td>  
                                                <td>{{ $item->OPERATE_JOB_ID }}</td>  
                                                <td>{{ $item->OPERATE_JOB_NAME }}</td> 
                                            </tr> 

                                             <!-- Modal -->
                                            <div class="modal fade" id="editModal{{$item->CHECKIN_ID}}"  tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">แก้ไข เข้า-ออก</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body"> 
                                                            {{-- <form action="{{ route('TT.timein_save') }}" method="POST">
                                                                @csrf --}}
                                                            
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">
                                                                            <span class="">วันที่</span>
                                                                        </div>
                                                                        <input type="datetime-local" id="CHEACKIN_DATE" name="CHEACKIN_DATE" class="form-control" value="{{$item->CHEACKIN_DATE}}">
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            {{-- <div class="row mt-3">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">
                                                                            <span class="">ประเภท</span>
                                                                        </div>
                                                                        <select name="CHECKIN_TYPE_ID" id="CHECKIN_TYPE_ID" class="form-control">
                                                                            <option value="1">เข้า</option>
                                                                            <option value="2">ออก</option>
                                                                        </select> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <div class="input-group-text">
                                                                            <span class="">วันทำการ</span>
                                                                        </div>
                                                                        <select name="OPERATE_JOB_ID" id="OPERATE_JOB_ID" class="form-control">
                                                                            <option value="">-เลือก-</option> 
                                                                            @foreach ($oper_ as $item)
                                                                                <option value="{{$item->OPERATE_JOB_ID}}">{{$item->OPERATE_JOB_NAME}}</option> 
                                                                            @endforeach
                                                                        </select>  
                                                                    </div>
                                                                </div>
                                                            </div>  --}}
                                                        </div>

                                                        <div class="modal-footer"> 
                                                            <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="TimeUpdate">
                                                            {{-- <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"> --}}
                                                                <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                                                            </button>
                                                        </div>
                                                    </div>
                                                {{-- </form> --}}
                                                </div>
                                            </div>

                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div> 
                        </p>
                    </div>
                     
                </div>
            </div>
            
        </div>
</div> 

 <!-- Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">เข้า-ออก</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body"> 
            {{-- <form action="{{ route('TT.timein_save') }}" method="POST">
                @csrf --}}
            
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="">วันที่</span>
                        </div>
                        {{-- <input type="datetime-local" id="INSERTCHEACKIN_DATE" name="CHEACKIN_DATE" class="form-control"> --}}
                        <input type="date" id="INSERTCHEACKIN_DATE" name="CHEACKIN_DATE" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="">เวลา</span>
                        </div>
                        {{-- <input type="datetime-local" id="INSERTCHEACKIN_DATE" name="CHEACKIN_DATE" class="form-control"> --}}
                        <input type="time" id="INSERTCHEACKIN_TIME" name="CHEACKIN_TIME" class="form-control">
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="">เวลา</span>
                        </div>
                        <input type="time" id="CHEACKIN_TIME" name="CHEACKIN_TIME" class="form-control">
                    </div>
                </div> --}}
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="">ประเภท</span>
                        </div>
                        <select name="CHECKIN_TYPE_ID" id="CHECKIN_TYPE_ID" class="form-control">
                            <option value="1">เข้า</option>
                            <option value="2">ออก</option>
                        </select> 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="">วันทำการ</span>
                        </div>
                        <select name="OPERATE_JOB_ID" id="OPERATE_JOB_ID" class="form-control">
                            <option value="">-เลือก-</option> 
                            @foreach ($oper_ as $item)
                                <option value="{{$item->OPERATE_JOB_ID}}">{{$item->OPERATE_JOB_NAME}}</option> 
                            @endforeach
                        </select>  
                    </div>
                </div>
            </div> 
        </div>

        <div class="modal-footer"> 
            <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="TimeSave">
            {{-- <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"> --}}
                <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
            </button>
        </div>
    </div>
{{-- </form> --}}
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
        $('#HR_DEPARTMENT_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
          
        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#TimeSave').click(function() {
            var CHEACKIN_DATE = $('#INSERTCHEACKIN_DATE').val();
            var CHEACKIN_TIME = $('#INSERTCHEACKIN_TIME').val();
            var CHECKIN_TYPE_ID = $('#CHECKIN_TYPE_ID').val();
            var OPERATE_JOB_ID = $('#OPERATE_JOB_ID').val(); 
            $.ajax({
                url: "{{ route('TT.timein_save') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    CHEACKIN_DATE,
                    CHEACKIN_TIME,
                    CHECKIN_TYPE_ID,
                    OPERATE_JOB_ID
                },
                success: function(data) {
                    if (data.status == 200) { 
                        Swal.fire({
                            title: 'บันทึกข้อมูลสำเร็จ',
                            text: "You Insert data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result
                                .isConfirmed) {
                                console.log(
                                    data);

                                window.location
                                    .reload();
                            }
                        })
                    } else {

                    }

                },
            });
        });  
    });
</script>
 
@endsection
 
 