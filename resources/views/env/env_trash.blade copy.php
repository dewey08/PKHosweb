@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
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
                รายระเอียดข้อมูลขยะ
                
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="{{ url('env_trash_add') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">เพิ่มข้อมูล</a>
                        {{-- <a href="{{ url('time_nurs_depsub') }}" class="btn-pill btn-wide me-1 ms-1  btn btn-outline-alternate btn-sm">กลุ่มงาน/ฝ่าย</a>
                        <a href="{{ url('time_nurs_depsubsub') }}" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm">หน่วยงาน</a> --}}
                    </div>
                </div>
            </div>
           
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p>
                             
                            <form action="{{ route('env.env_trash') }}" method="POST">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col"></div> --}}
                                    <div class="col-md-1 text-end">วันที่</div>
                                    <div class="col-md-2 text-center">
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                                id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" value="{{ $startdate }}">
            
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center">ถึงวันที่</div>
                                    <div class="col-md-2 text-center">
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                                id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" value="{{ $enddate }}">
            
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                                            ค้นหา
                                        </button>
                                        
                                            {{-- <a href="{{url('time_dep_excel/'.$deb.'/'.$startdate.'/'.$enddate)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                <i class="fa-solid fa-file-excel me-2"></i>
                                                Export
                                            </a> --}}
                                        
                                        </div>
                                        
                                    </div>
                            </form> 
                            {{-- <div class="table-responsive mt-3"> --}}
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <th class="text-center"width="5%">ลำดับ</th> 
                                            <th class="text-center"width="10%">TRASH NO</th>
                                            <th class="text-center"width="10%">วันที่บันทึก</th>
                                            <th class="text-center"width="8%">เวลา</th> 
                                            <th class="text-center"width="12%">บริษัท</th>
                                            {{-- <th class="text-center"width="8%">ขยะติดเชื้อ(kg)</th>
                                            <th class="text-center"width="8%">ขยะทั่วไป(kg)</th>   --}}
                                            <th class="text-center"width="20%">ผู้บันทึก</th>
                                            <th class="text-center"width="6%">คำสั่ง</th> 
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        // $date = date('Y');
                                        ?>
                                        @foreach ($datashow as $item)
                                        
                                            <tr>                                            
                                                <td class="text-center" width="4%">{{ $i++ }}</td>
                                                <td class="text-center" width="7%">{{ $item->trash_bill_on }}</td>
                                                <td class="text-center" width="7%">{{DateThai( $item->trash_date )}}</td>
                                                <td class="text-center" width="5%">{{ $item->trash_time }}</td>
                                                <td class="p-2" width="18%">{{ $item->vendor_name }}</td>
                                                <td class="text-center" width="5%">{{ $item->trash_user }}</td>
                                                <td class="text-center" width="7%">    
                                                    
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            ทำรายการ 
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item menu" data-bs-toggle="modal"
                                                                data-bs-target="#trashetailModal{{ $item->trash_id }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="รายละเอียด">
                                                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                <label for=""style="color: rgb(33, 187, 248);font-size:13px">รายละเอียด</label>
                                                            </a>
                                                            <a class="dropdown-item text-warning"
                                                                href="{{ url('env_trash_edit/' . $item->trash_id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                <label for=""style="color: rgb(7191, 24, 224);font-size:13px">แก้ไข</label>
                                                            </a>
                                                            <a class="dropdown-item text-danger" href="{{url('env_trash_parameter_delete/'.$item->trash_id)}}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                <label for="" style="color: rgb(255, 22, 22);font-size:13px">ลบ</label>
                                                            </a>    
                                                            {{-- <div class="dropdown-divider"></div> --}}
                                                            {{-- <a class="dropdown-item text-danger" href="{{url('env_trash_parameter_delete/'.$item->trash_id)}}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                <label for="" style="color: rgb(70, 70, 70);font-size:13px">ลบ</label>
                                                            </a>                                                            --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php  

                                        
                                        ?>
                                            <!--  Modal content Update -->
                                            <div class="modal fade" 
                                                id="trashetailModal{{ $item->trash_id }}" tabindex="-1"
                                                aria-labelledby="trashetailModal" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="trashetailModal">
                                                                รายระเอียดข้อมูลขยะ
                                                                {{-- {{ $item->trash_id }}</h5> --}}
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="row">
                                                                <div class="col-md-2 ">
                                                                    <p for=""><b>Trash_bill_on :</b></p>
                                                                </div>
                                                                <div class="col-md-4">

                                                                    <p for="trash_bill_on">{{ $item->trash_bill_on }}</p>

                                                                </div>
                                                                {{-- <div class="col-md-2 ">
                                                                    <label for=""><b>ปีงบประมาณ
                                                                            :</b></label>
                                                                </div>
                                                                <div class="col-md-3">

                                                                    <label
                                                                        for="com_repaire_year">{{ $item->com_repaire_year }}</label>

                                                                </div> --}}
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label for=""><b>วันที่แจ้ง
                                                                            :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <p
                                                                            for="trash_date">{{ DateThai($item->trash_date) }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 ">
                                                                    <label for=""><b>เวลา :</b></label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="trash_time">{{ formatetime($item->trash_time) }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label for=""><b>บริษัท :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="trash_sub">{{ $item->vendor_name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for=""><b>ผู้บันทึกข้อมูล :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="trash_user">{{ $item->trash_user }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label for=""><b>ความเร่งด่วน
                                                                            :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_user_name">{{ $item->status_name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for=""><b>รายการที่แจ้งซ่อม
                                                                            :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_user_name">{{ $item->article_name }}</label>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <hr> --}}

                                                            {{-- <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label for=""><b>วันที่ซ่อม
                                                                            :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_date">{{ DateThai($item->com_repaire_work_date) }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 ">
                                                                    <label for=""><b>เวลา :</b></label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_time">{{ formatetime($item->com_repaire_work_time) }}</label>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label for=""><b>ช่างซ่อม :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_user_name">{{ $item->com_repaire_tec_name }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for=""><b>รายละเอียดซ่อม
                                                                            :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_debsubsub_name">{{ $item->com_repaire_detail_tech }}</label>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            {{-- <hr> --}}

                                                            {{-- <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label
                                                                        for=""><b>วันที่ส่งงาน:</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_date">{{ DateThai($item->com_repaire_send_date) }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 ">
                                                                    <label for=""><b>เวลา :</b></label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="com_repaire_time">{{ formatetime($item->com_repaire_send_time) }}</label>
                                                                    </div>
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label
                                                                        for=""><b>ลายมือผู้แจ้ง:</b></label>
                                                                </div>
                                                                <div class="col-md-1 text-start">
                                                                    <div class="form-group ">
                                                                    <img src="data:image/png;base64,{{$singuser}}" alt="" width="120px">
                                                                    </div>
                                                                </div>
                                                                <div class="col"></div>
                                                                <div class="col-md-2 ">
                                                                    <label for=""><b>ลายมือผู้รับ:</b></label>
                                                                </div>
                                                                <div class="col-md-1 text-start">
                                                                    <div class="form-group ">
                                                                    <img src="data:image/png;base64,{{$singrep}}" alt="" width="120px">
                                                                    </div>
                                                                </div>
                                                                <div class="col"></div>

                                                                <div class="col-md-2 ">
                                                                <label for=""><b>ลายมือผู้ส่งงาน:</b></label>
                                                            </div>
                                                            <div class="col-md-1 text-start">
                                                                <div class="form-group ">
                                                                    <img src="data:image/png;base64,{{$singstaff}}" alt="" width="120px">
                                                                </div>
                                                            </div>
                                                                <div class="col"></div>
                                                            </div> --}}
                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                data-bs-dismiss="modal" id="closebtn">
                                                                <i class="fa-solid fa-xmark me-2"></i>
                                                                ปิด
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div> 

                                        @endforeach
                                    </tbody>
                                    {{-- <tbody>
                                        <?php $ia = 1; ?>
                                        @foreach ($datashow_ as $item)  
                                            
                                            <tr>
                                                <td>{{ $ia++ }}</td>
                                                <td>{{ $item->CHEACKIN_DATE }}</td> 
                                                <td class="p-2">{{ $item->hrname }}</td>   
                                                <td class="p-2">{{ $item->HR_DEPARTMENT_SUB_SUB_NAME }}</td> 
                                                <td>{{ $item->CHEACKINTIME }}</td>  
                                                <td>{{ $item->CHEACKOUTTIME }}</td>  
                                                <td>{{ $item->OPERATE_TYPE_NAME }}</td>   
                                            </tr>    
                                        @endforeach
                                        
                                    </tbody> --}}
                                </table>
                            {{-- </div>  --}}
                        </p>
                    </div>
                     
                </div>
            </div>
            
        </div>
</div> 

 
      
@endsection
@section('footer')

{{-- <script>
    
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
</script> --}}
{{-- <script>
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
</script> --}}
@endsection
 
 