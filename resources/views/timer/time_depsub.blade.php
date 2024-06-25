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
                <div class="btn-actions-pane-right">
                    <div class="nav"> 
                        <a href="{{ url('time_dep') }}" class="btn-pill btn-wide btn btn-outline-alternate btn-sm">กลุ่มภารกิจ</a>
                        <a href="{{ url('time_depsub') }}" class="btn-pill btn-wide me-1 ms-1 active btn btn-outline-alternate btn-sm">กลุ่มงาน/ฝ่าย</a>
                        <a href="{{ url('time_depsubsub') }}" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm">หน่วยงาน</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p> 
                            <form action="{{ route('t.time_depsub') }}" method="POST">
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
                                        <div class="col-md-1 text-center">ฝ่าย/แผนก</div>
                                        <div class="col-md-2 text-center">
                                            <div class="input-group">
                                                {{-- <select id="HR_DEPARTMENT_SUB_ID" name="HR_DEPARTMENT_SUB_ID" class="form-select form-select-lg department_sub" style="width: 100%">  --}}
                                                    <select name="department_sub_id" id="department_sub_id" class="form-control form-control-sm" style="width: 100%"> 
                                                    @foreach ($department_sub as $items) 
                                                    @if ($debsub == $items->HR_DEPARTMENT_SUB_ID)
                                                        <option value="{{ $items->HR_DEPARTMENT_SUB_ID }}" selected> {{ $items->HR_DEPARTMENT_SUB_NAME }} </option> 
                                                    @else
                                                        <option value="{{ $items->HR_DEPARTMENT_SUB_ID }}"> {{ $items->HR_DEPARTMENT_SUB_NAME }} </option> 
                                                    @endif
                                                    
                                                    
                                                    @endforeach
                                            </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-2 me-2">  
                                            <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                <i class="pe-7s-search btn-icon-wrapper"></i>ค้นหา
                                            </button> 
                                        
                                            <a href="{{url('time_depsub_excel/'.$debsub.'/'.$startdate.'/'.$enddate)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                Export
                                            </a>
                                        
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
                                            <th>หน่วยงาน</th> 
                                            <th>เวลาเข้า</th> 
                                            <th>เวลาออก</th> 
                                            <th>ประเภท</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ia = 1; ?>
                                        @foreach ($datashow_ as $item)  
                                            
                                            <tr>
                                                <td>{{ $ia++ }}</td>
                                                <td>{{ Datethai($item->CHEACKIN_DATE )}}</td> 
                                                <td class="p-2">{{ $item->hrname }}</td>   
                                                <td class="p-2">{{ $item->HR_DEPARTMENT_SUB_SUB_NAME }}</td> 
                                                <td>{{ $item->CHEACKINTIME }}</td>  
                                                <td>{{ $item->CHEACKOUTTIME }}</td>  
                                                <td>{{ $item->OPERATE_TYPE_NAME }}</td>   
                                            </tr>    
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
        $('#HR_DEPARTMENT_SUB_ID').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        $('#HR_DEPARTMENT_SUB_SUB_ID').select2({
            placeholder: "--เลือก--",
            allowClear: true
        });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#Savetime').click(function() {
            var startdate = $('#datepicker').val();
            var enddate = $('#datepicker2').val();
            var HR_DEPARTMENT_SUB_ID = $('#HR_DEPARTMENT_SUB_ID').val();
            var HR_DEPARTMENT_SUB_SUB_ID = $('#HR_DEPARTMENT_SUB_SUB_ID').val(); 
            $.ajax({
                url: "{{ route('t.time_index_excel') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    startdate,
                    enddate,
                    HR_DEPARTMENT_SUB_ID,
                    HR_DEPARTMENT_SUB_SUB_ID
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
<script>
    $('.department').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.department')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });

    $('.department_sub').change(function () {
            if ($(this).val() != '') {
                    var select = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                            url: "{{route('person.departmenthsub')}}",
                            method: "GET",
                            data: {
                                    select: select,
                                    _token: _token
                            },
                            success: function (result) {
                                    $('.department_sub_sub').html(result);
                            }
                    })
                    // console.log(select);
            }
    });
</script>
@endsection
 
 