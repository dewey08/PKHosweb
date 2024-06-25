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

    use Illuminate\Support\Facades\DB;
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
                รายระเอียดผลวิเคราะห์คุณภาพน้ำทิ้ง
                
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="{{ url('env_water_add') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">เพิ่มข้อมูล</a>                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p> 
                            <form action="{{ route('env.env_water') }}" method="GET">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col"></div> --}}
                                    <div class="col-md-2 text-end">วันที่</div>
                                    <div class="col-md-4 text-center">
                                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $startdate }}" required/>
                                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                                                    data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                                                    data-date-language="th-th" value="{{ $enddate }}" required/> 
                                        </div>
                                        {{-- <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                                id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" value="{{ $startdate }}">            
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="col-md-1 text-center">ถึงวันที่</div>
                                    <div class="col-md-2 text-center">
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                                id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" value="{{ $enddate }}">
            
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div> --}}
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
                                            <th class="text-center"width="2%">ลำดับ</th> 
                                            <th class="text-center"width="2%">วันที่บันทึก</th>
                                            <th class="text-center"width="5%">สถานที่เก็บตัวอย่าง</th>
                                            <th class="text-center"width="4%">ผู้บันทึก</th>
                                            <th class="text-center"width="5%">หมายเหตุ</th>
                                            <th class="text-center"width="2%">คำสั่ง</th>                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ia = 1; ?>
                                        @foreach ($datashow as $item)
                                            <tr>
                                                <td class="text-center">{{ $ia++ }}</td>
                                                <td class="text-center">{{DateThai ($item->water_date) }}</td> 
                                                <td class="text-center">{{ $item->water_location }}</td>   
                                                <td class="text-center">{{ $item->water_user }}</td> 
                                                <td class="text-center">{{ $item->water_comment }}</td>  
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            ทำรายการ 
                                                        </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item menu" data-bs-toggle="modal"
                                                                    data-bs-target="#waterModal{{ $item->water_id }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="รายละเอียด">
                                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                    <label for=""style="color: rgb(33, 187, 248);font-size:13px">รายละเอียด</label>
                                                                </a>
                                                                <a class="dropdown-item text-warning"
                                                                    href="{{ url('env_water_edit/' . $item->water_id) }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                    <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                    <label for=""style="color: rgb(7191, 24, 224);font-size:13px">แก้ไข</label>
                                                                </a>
                                                                <a class="dropdown-item text-danger" href="{{url('env_water_delete/'.$item->water_id)}}"
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
                                            
                                            <!--  Modal content Update -->
                                            <div class="modal fade" 
                                                id="waterModal{{ $item->water_id }}" tabindex="-1"
                                                aria-labelledby="waterModal" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="waterModal">
                                                                รายละเอียดข้อมูลระบบบำบัดน้ำเสีย
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="row">
                                                                <div class="col-md-2 ">
                                                                    <p for=""><b>วันที่บันทึก :</b></p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p for="water_date">{{ DateThai($item->water_date) }}</p>
                                                                </div>                                                               
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label for=""><b>ผู้บันทึก :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <p
                                                                            for="water_user">{{ $item->water_user }}</p>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 ">
                                                                    <label for=""><b>สถานที่เก็บตัวอย่าง :</b></label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="water_location">{{ $item->water_location }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-md-2">
                                                                    <label for=""><b>ลักษณะตัวอย่าง :</b></label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="water_group_excample">{{ $item->water_group_excample }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <label for=""><b>หมายเหตุ :</b></label>
                                                                </div>                                                                
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label
                                                                            for="water_comment">{{ $item->water_comment }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <hr>
                                                            <div class="row  mt-3">
                                                                <div class="col-md-12">
                                                               
                                                                            <?php   
                                                                                    $j = 1;
                                                                                    $data_ = DB::connection('mysql')->select('
                                                                                            SELECT *
                                                                                            FROM env_water_sub
                                                                                            WHERE water_id = "'.$item->water_id.'"
                                                                                    ');
                                                                            ?>
                                                                          
                                                                    <div class="row ">
                                                                        <div class="col-md-1 text-center">ลำดับ</div>
                                                                        <div class="col-md-4 text-center">รายการพารามิเตอร์</div>
                                                                        <div class="col-md-1 text-center">หน่วย</div>
                                                                        <div class="col-md-2 text-center">ผลการวิเคราะห์</div>
                                                                        {{-- <div class="col-md-2 text-center">วิธี่ที่ใช้วิเคราะห์</div> --}}
                                                                        <div class="col-md-2 text-center">ค่ามาตรฐาน</div>
                                                                    </div>
                                                                    @foreach ($data_ as $item2)
                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-md-1 text-center">{{$j++}}</div>
                                                                        <div class="col-md-4">{{$item2->water_list_detail}}</div>
                                                                        <div class="col-md-1 text-center">{{$item2->water_list_unit}}</div>
                                                                        <div class="col-md-2 text-center">{{$item2->water_qty}}</div>
                                                                        {{-- <div class="col-md-2">{{$item2->use_analysis_results}}</div> --}}
                                                                        <div class="col-md-2 ">{{$item2->water_results}}</div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                 
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

        // $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        // });
        // $('#HR_DEPARTMENT_ID').select2({
        //         placeholder: "--เลือก--",
        //         allowClear: true
        //     });
        // $('#HR_DEPARTMENT_SUB_ID').select2({
        //         placeholder: "--เลือก--",
        //         allowClear: true
        //     });
        // $('#HR_DEPARTMENT_SUB_SUB_ID').select2({
        //     placeholder: "--เลือก--",
        //     allowClear: true
        // });

        $("#spinner-div").hide(); //Request is complete so hide spinner

        // $('#Savetime').click(function() {
        //     var startdate = $('#datepicker').val();
        //     var enddate = $('#datepicker2').val();
        //     var HR_DEPARTMENT_SUB_ID = $('#HR_DEPARTMENT_SUB_ID').val();
        //     var HR_DEPARTMENT_SUB_SUB_ID = $('#HR_DEPARTMENT_SUB_SUB_ID').val(); 
        //     $.ajax({
        //         url: "{{ route('t.time_index_excel') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         data: {
        //             startdate,
        //             enddate,
        //             HR_DEPARTMENT_SUB_ID,
        //             HR_DEPARTMENT_SUB_SUB_ID
        //         },
        //         success: function(data) {
        //             if (data.status == 200) { 
        //                 Swal.fire({
        //                     title: 'บันทึกข้อมูลสำเร็จ',
        //                     text: "You Insert data success",
        //                     icon: 'success',
        //                     showCancelButton: false,
        //                     confirmButtonColor: '#06D177',
        //                     confirmButtonText: 'เรียบร้อย'
        //                 }).then((result) => {
        //                     if (result
        //                         .isConfirmed) {
        //                         console.log(
        //                             data);

        //                         window.location
        //                             .reload();
        //                     }
        //                 })
        //             } else {

        //             }

        //         },
        //     });
        // });  
    });
</script>
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
 
 