@extends('layouts.userdashboard')
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
                        <div class="btn-actions-pane-right">
                            <form action="{{ route('usertime.user_timeindex_nurh') }}" method="POST">
                                @csrf
                                <div class="row"> 
                                    <div class="col"></div>
                                    <div class="col-md-1 text-end">วันที่</div>
                                    {{-- <div class="col-md-2 text-center">
                                        @if ($startdate == '')
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                                    value="{{ $datenow }}">                    
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
                                    <div class="col-md-1 text-center">ถึงวันที่</div> --}}
                                    <div class="col-md-6 text-end">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                                            @if ($startdate != '')
                                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                data-date-language="th-th" value="{{ $startdate }}" required/>
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                                data-date-language="th-th" value="{{ $enddate }}"/> 
                                            @else
                                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $datenow }}" required/>
                                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                                            data-date-language="th-th" value="{{ $datenow }}"/> 
                                            @endif   
                                        </div> 
                                    </div>
                                    {{-- <div class="col-md-2 text-center">
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
                                        
                                    </div>  --}}
                                    <div class="col-md-4 me-2">  
                                        <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info">
                                            <i class="pe-7s-search btn-icon-wrapper"></i>1 ค้นหา
                                        </button> 
                                        
                                        <a href="{{url('user_exportexcel')}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-success">
                                            <i class="fa-solid fa-file-excel me-2"></i>
                                            2 Export
                                        </a>

                                       
                                        {{-- @if ($startdate == '')
                                            <a href="{{url('user_timeindex_nurh_excel/'.$datenow.'/'.$datenow)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                2 Export
                                            </a>
                                        @else
                                            <a href="{{url('user_timeindex_nurh_excel/'.$startdate.'/'.$enddate)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                2 Export
                                            </a>
                                        @endif --}}
                                        {{-- <button type="button" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#Bookdata">
                                            <i class="pe-7s-news-paper btn-icon-wrapper"></i> คู่มือการใช้งาน
                                        </button>   --}}
                                       
                                    </div> 
                                    <div class="col"></div>
                                </div> 
                            </form>
                        </div>
                    </div> 
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example">
                                <thead>
                                    <tr style="font-size: 14px;">
                                        <th>ลำดับ</th> 
                                        <th>วันที่</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>เวลาเข้า</th> 
                                        <th>เวลาออก</th> 
                                        <th>ประเภท</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ia = 1; ?>
                                    @foreach ($datashow_ as $item)  
                                        
                                        <tr style="font-size: 13px;">
                                            <td>{{ $ia++ }}</td>
                                            {{-- <td>{{ dateThaifromFull($item->CHEACKIN_DATE) }}</td>  --}}
                                            <td>{{ Datethai($item->CHEACKIN_DATE )}}</td> 
                                            <td>{{ $item->hrname }}</td>   
                                            <td>{{ $item->CHEACKINTIME }}</td>  
                                            <td>{{ $item->CHEACKOUTTIME }}</td>  
                                            <td>{{ $item->OPERATE_TYPE_NAME }}</td>   
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

  <!--  Modal content for the Keypassword example -->
  <div class="modal fade" id="Bookdata" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">คู่มือการใช้งาน </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"> 
                <div class="row"> 
                    <div class="col-md-12"> 
                        <div class="form-group ">
                            <img src="{{ asset('images/nurs_1.jpg') }}" alt="Image" class="img-thumbnail" height="600px">
                        </div>
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-end">
                    <div class="form-group">  
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><i
                                class="fa-solid fa-xmark me-2"></i>ปิด</button>

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
        $('#HR_DEPARTMENT_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_SUB_ID').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner
        $('#ExportExcel').click(function() {
            var startdate = $('#datepicker').val();
            var enddate = $('#datepicker2').val();
            alert(startdate);
            $.ajax({
                url: "{{ route('t.time_index_excel') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    startdate,
                    enddate
                    // HR_DEPARTMENT_SUB_ID,
                    // HR_DEPARTMENT_SUB_SUB_ID
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
                        Swal.fire({
                            title: 'กรุณาเลือกวันที่',
                            text: "You Choose Date",
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
                    }

                },
            });
        });  
    });
</script>
<script>
    
</script>
@endsection
 
 