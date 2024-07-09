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
    function env_parameter_destroy(pond_sub_id) { 
        Swal.fire({
            position: "top-end",
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('env_parameter_destroy') }}" + '/' + pond_sub_id,
                    type: 'POST',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                            if (response.status == 200) {
                                Swal.fire({  
                                position: "top-end",
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + pond_sub_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                        } else {
                            
                        }
                        
                    }
                })
            }
        })
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
            <div class="col-md-3">
                <h4 >Detail POND</h4>
                <p >รายละเอียดั้งค่าบ่อบำบัด</p>
            </div>
            <div class="col"></div> 
            <div class="col-md-2 text-end"> 
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa-solid fa-file-invoice-dollar text-primary me-2"></i>
                    เพิ่มข้อมูลบ่อบำบัด
                </button>
            </div> 
        </div>

        <div class="row"> 
            <div class="col-xl-12 col-md-6">
                <div class="main-card card p-3"> 
                    <table class="table table-sm" id="example" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th> 
                                <th class="text-center">รหัสบ่อบำบัด</th>
                                <th class="text-center">ชื่อบ่อบำบัด</th>
                                <th class="text-center">เพิ่มพารามิเตอร์</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0;
                            $total1 = 0; ?>
                            @foreach ($datashow as $item)
                                <?php $number++; ?> 
                                <tr id="#sid{{ $item->pond_sub_id }}">
                                    <td class="text-center" width="5%">{{ $number }}</td> 
                                    <td class="text-center" width="10%" > {{$item->pond_id}} </td> 
                                    <td >   
                                        <?php
                                             $data_sub_ = DB::connection('mysql')->select('
                                                SELECT * from env_pond_sub ps
                                                LEFT JOIN env_water_parameter w ON w.water_parameter_id = ps.water_parameter_id 
                                                WHERE ps.pond_id = "'.$item->pond_id.'"');
                                            
                                        ?>
                                        <div id="headingTwo" class="b-radius-0 card-header">
                                            {{-- @if ($data_subcount == '0') --}}
                                                <button type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne2{{ $item->pond_sub_id }}" aria-expanded="false"
                                                    aria-controls="collapseTwo" class="text-start m-0 p-0 btn btn-link btn-block">
                                                    <h5 style="color: rgba(207, 204, 204, 0.623)">{{ $item->pond_name }} <label for="" style="color: rgb(84, 65, 250)"> !! รายละเอียด คลิก !!</label></h5> 
                                                </button>
                                            {{-- @else
                                                <button type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne2{{ $item->acc_setpang_id }}" aria-expanded="false"
                                                    aria-controls="collapseTwo" class="text-start m-0 p-0 btn btn-link btn-block">
                                                    <h5 >{{ $item->pangname }} <label for="" style="color: red"> !! รายละเอียด คลิก !!</label></h5> 
                                                </button>
                                                    
                                            @endif --}}
                                            
                                        </div>
                                        
                                        <div data-parent="#accordion" id="collapseOne2{{ $item->pond_sub_id }}" class="collapse">
                                            <div class="card-body">
                                                <div class="row ms-2 me-2">
                                                    @foreach ($data_sub_ as $itemsub)
                                                        <div class="col-md-2">
                                                            @if ($itemsub->water_parameter_id != '')
                                                            <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info" onclick="env_parameter_destroy({{ $itemsub->pond_sub_id }})">
                                                                {{-- <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info"> --}}
                                                                    {{$itemsub->water_parameter_short_name}}
                                                                </button>                                                         
                                                            @endif
                                                            
                                                        </div>
                                                        
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div> 
                                    </td> 
                                    
                                    <td class="text-center" width="10%"> 
                                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addparameterModal" value="{{ $item->pond_sub_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="เพิ่ม Parameter">
                                            <i class="fa-solid fa-plus text-success"></i>
                                            Parameter
                                        </button>
                                    </td>
                                    {{-- <td class="text-center" width="10%"> 
                                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-success addparameterModal" data-bs-toggle="tooltip" data-bs-placement="left" title="เพิ่ม Parameter">
                                            <i class="fa-solid fa-plus text-success"></i>
                                            Parameter
                                        </button>
                                    </td> --}}
                                    
                                   
                                </tr> 
                            @endforeach
    
                        </tbody>
                    </table> 
                </div>
            </div> 
        </div>
        {{-- <div class="card card_audit_4c">
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
                                            <th>รหัสบ่อ</th>
                                            <th>ชื่อบ่อบำบบัด</th>
                                            <th>พารามิเตอร์</th>                                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $date = date('Y');
                                        ?>
                                        @foreach ($datashow as $item)
                                            <tr id="sid{{ $item->water_parameter_id }}">
                                                <td class="text-center" width="3%">{{ $i++ }}</td>
                                                <td class="p-2" width="18%">{{ $item->water_parameter_name }} </td>
                                                <td class="p-2" width="5%">{{ $item->water_parameter_unit }}</td>
                                                <td class="p-2" width="13%">{{ $item->water_parameter_results }}</td>
                                                <td class="p-2" width="5%">{{ $item->water_parameter_icon }}</td>
                                                <td class="p-2" width="5%">{{ $item->water_parameter_normal }}</td>
                                                <td class="p-2" width="5%">
                                                    @if($item-> water_parameter_active == 'TRUE' )
                                                        <input type="checkbox" id="{{ $item-> water_parameter_id }}" name="{{ $item-> water_parameter_id }}" switch="none" onchange="switchactive({{ $item-> water_parameter_id }});" checked />
                                                        @else
                                                        <input type="checkbox" id="{{ $item-> water_parameter_id }}" name="{{ $item-> water_parameter_id }}" switch="none" onchange="switchactive({{ $item-> water_parameter_id }});" />
                                                        @endif
                                                        <label for="{{ $item-> water_parameter_id }}" data-on-label="On" data-off-label="Off"></label>
                                                </td>
                                                <td class="text-center" width="7%">                                                    
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            ทำรายการ 
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item text-warning"
                                                                href="{{ url('env_water_parameter_edit/' . $item->water_parameter_id) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2"></i>
                                                                <label for=""
                                                                    style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                            </a>
    
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="{{url('env_water_parameter_delete/'.$item->water_parameter_id)}}"
                                                             
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
            
        </div> --}}
</div> 

<!-- Insert Modal -->
<div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ตั้งค่าบ่อบำบัด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <label for="pond_id" class="form-label">รหัสบ่อบำบัด</label>
                        <div class="input-group input-group-sm"> 
                            <input type="text" class="form-control" id="pond_id" name="pond_id">  
                        </div>
                    </div>  
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="pond_name" class="form-label">ชื่อบ่อบำบัด</label>
                        <div class="input-group input-group-sm"> 
                            <input type="text" class="form-control" id="pond_name" name="pond_name">  
                        </div>
                    </div>  
                </div> 
                                
                <input type="hidden" name="user_id" id="user_id" value="{{$iduser}}"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Savedata">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
            </div>
        </div>
    </div>
</div> 

<!-- addparameterModal Modal -->
<div class="modal fade" id="addparameterModal"  tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">เพิ่ม Parameter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body"> 

                    <div class="row">
                        <div class="col-md-4">
                            <label for="editpond_id" class="form-label">รหัสบ่อบำบัด</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editpond_id" name="editpond_id" readonly>  
                            </div>
                        </div>  
                        <div class="col-md-8">
                            <label for="editpond_name" class="form-label">ชื่อบ่อบำบัด</label>
                            <div class="input-group input-group-sm"> 
                                <input type="text" class="form-control" id="editpond_name" name="editpond_name" readonly>  
                            </div>
                        </div> 
                    </div>
    

                    <div class="row mt-3">
                        
                        <div class="col-md-8">
                            <label for="editwater_parameter_id" class="form-label">เพิ่ม Parameter</label>
                            <div class="input-group input-group-sm">  
                                <select name="editwater_parameter_id" id="editwater_parameter_id" class="form-control" style="width: 100%">
                                    <option value="">-Choose-</option>
                                    @foreach ($data_parameter as $item1)
                                        <option value="{{$item1->water_parameter_id}}">{{$item1->water_parameter_id}} {{$item1->water_parameter_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  
                        
                    </div> 
                
                <input type="hidden" name="user_id" id="adduser_id"> 
                <input type="hidden" name="editpond_sub_id" id="editpond_sub_id"> 
            </div>
            <div class="modal-footer">
                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="Updatetype">
                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                </button>
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

        $('#addpttype').select2({
            dropdownParent: $('#addparameterModal')
        });

 

        $("#spinner-div").hide(); //Request is complete so hide spinner

        $('#Updatetype').click(function() {
            var editpond_id       = $('#editpond_id').val();
            var editpond_name     = $('#editpond_name').val();
            var editwater_parameter_id = $('#editwater_parameter_id').val(); 
            var editpond_sub_id   = $('#editpond_sub_id').val(); 
            
            $.ajax({
                url: "{{ route('env.env_parameter_save') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    editpond_id,
                    editpond_name,
                    editwater_parameter_id,
                    editpond_sub_id
                },
                success: function(data) {
                    if (data.status == 200) { 
                        Swal.fire({
                            position: "top-end",
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
                            position: "top-end",
                            title: 'มีข้อมูลอยู่แล้ว',
                            text: "You Have data success",
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

        $(document).on('click', '.addparameterModal', function() {
        var pondsub_id = $(this).val(); 
        // alert(pondsub_id);
        $('#addparameterModal').modal('show');
        $.ajax({
            type: "GET",
            url: "{{ url('env_water_parameter_para_id') }}" + '/' + pondsub_id,
            success: function(response) {
                console.log(response.data_para.pond_sub_id); 
                $('#editpond_id').val(response.data_para.pond_id)
                $('#editpond_name').val(response.data_para.pond_name)
                $('#editpond_sub_id').val(response.data_para.pond_sub_id)
                $('#editwater_parameter_id').val(response.data_para.water_parameter_id)
                
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
 
 