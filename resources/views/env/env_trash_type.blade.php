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
                รายการพารามิเตอร์
                
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        <a href="{{ url('env_water_parameter_add') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">เพิ่มข้อมูล</a>
                        {{-- <a href="{{ url('time_nurs_depsub') }}" class="btn-pill btn-wide me-1 ms-1  btn btn-outline-alternate btn-sm">กลุ่มงาน/ฝ่าย</a>
                        <a href="{{ url('time_nurs_depsubsub') }}" class="btn-pill btn-wide  btn btn-outline-alternate btn-sm">หน่วยงาน</a> --}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-eg2-0" role="tabpanel">
                        <p> 
                            <form action="{{ route('t.time_nurs_dep') }}" method="POST">
                                @csrf

                            </form>  
                            <div class="table-responsive mt-3">
                                <table class="align-middle mb-0 table table-borderless table-striped table-hover" id="example2">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th> 
                                            <th>ชื่อพารามิเตอร์</th>
                                            <th>หน่วย</th>
                                            <th>วิธีวิเคราะห์</th> 
                                            <th>ค่ามาตรฐาน</th>
                                            <th>ตั้งค่า</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $date = date('Y');
                                        ?>
                                        @foreach ($dataparameterlist as $item)
                                            <tr id="sid{{ $item->parameter_list_id }}">
                                                <td class="text-center" width="4%">{{ $i++ }}</td>
                                                <td class="p-2" width="18%">{{ $item->parameter_list_name }} </td>
                                                <td class="p-2" width="5%">{{ $item->parameter_list_unit }}</td>
                                                <td class="p-2" width="13%">{{ $item->parameter_list_user_analysis_results }}</td>
                                                <td class="p-2" width="10%">{{ $item->parameter_list_normal }}</td>
                                                {{-- <td class="p-2" width="17%">{{ $item->parameter_list_normal }}</td> --}}
                                                <td class="text-center" width="7%">
    
                                                    {{-- <div class="dropdown">
                                                        <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                          ทำรายการ
                                                        </button>                                      
                                                            <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">
                                                              
                                                                  <li>
                                                                    <a href="{{ url('article/article_index_edit/' .$item->article_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                      <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                      <label for="" style="color: black">แก้ไข</label>
                                                                    </a>  
                                                                  </li>
                                                                  <li>
                                                                    <a class="text-danger" href="javascript:void(0)" onclick="article_destroy({{ $item->article_id }})">
                                                                      <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                      <label for="" style="color: black">ลบ</label>
                                                                    </a> 
                                                                  </li>
                                                            </ul>
                                                    </div> --}}
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            ทำรายการ 
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-warning"
                                                                href="{{ url('env_water_parameter_edit/' . $item->parameter_list_id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                <label for=""
                                                                    style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                            </a>
    
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="{{url('env_water_parameter_delete/'.$item->parameter_list_id)}}"
                                                             
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                <label for="" style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                            </a>
                                                           
                                                        </div>
                                                    </div>
                                                </td>
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
 
 