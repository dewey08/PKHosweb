@extends('layouts.user')
@section('title', 'PK-OFFICER || P4P')

     <?php
     use App\Http\Controllers\P4pController;
     use Illuminate\Support\Facades\DB;   
     $refnumberwork = P4pController::refnumberwork();
 ?>


@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    ?>
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 13px;
    
        }
    
        label {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
    
        }
    </style>
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
               border: 5px #ddd solid;
               border-top: 10px #fd12d6 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(360deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h5>แก้ไขรายการภาระงาน P4P </h5>
                        <div class="btn-actions-pane-right"> 
    
                        </div>

                       
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="row mb-3">
                            <div class="col-md-2 text-end">
                                <label for="p4p_workset_code"  style="font-family: sans-serif;font-size: 13px">รหัสรายการ </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="p4p_workset_code" type="text" class="form-control form-control-sm"
                                        name="p4p_workset_code" value="{{$data_show->p4p_workset_code}}" readonly>
                                </div>
                            </div> 
                            <div class="col-md-1 text-end">
                                <label for="p4p_workset_name" style="font-family: sans-serif;font-size: 13px">ชื่อรายการ </label>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input id="p4p_workset_name" type="text" class="form-control form-control-sm"
                                        name="p4p_workset_name" value="{{$data_show->p4p_workset_name}}">
                                </div>
                            </div>
                            <input type="hidden" id="p4p_workset_user" value="{{$iduser}}">
                            <input type="hidden" id="p4p_workset_id" value="{{$data_show->p4p_workset_id}}">

                            <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-primary btn-sm" id="Updatebtn">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    แก้ไขข้อมูล
                                </button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2 text-end">
                                <label for="p4p_workset_position" style="font-family: sans-serif;font-size: 13px">ตำแหน่งสายงาน </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"> 
                                        <select id="p4p_workset_position" name="p4p_workset_position"
                                        class="form-select form-select-sm" style="width: 100%">
                                        <option value=""> </option>
                                        @foreach ($p4p_work_position as $itewo) 
                                        @if ($data_show->p4p_workset_position == $itewo->p4p_work_position_id)
                                        <option value="{{ $itewo->p4p_work_position_id }}" selected>{{ $itewo->p4p_work_position_name }} </option> 
                                        @else
                                        <option value="{{ $itewo->p4p_work_position_id }}">{{ $itewo->p4p_work_position_name }} </option> 
                                        @endif                                        
                                                                              
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-1 text-end">
                                <label for="p4p_workset_group" style="font-family: sans-serif;font-size: 13px">หมวดภาระงาน </label>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group"> 
                                        <select id="p4p_workset_group" name="p4p_workset_group"
                                        class="form-select form-select-sm" style="width: 100%">
                                        <option value=""> </option>
                                        @foreach ($p4p_workgroupset as $itemsg)  
                                        @if ($data_show->p4p_workset_group == $itemsg->p4p_workgroupset_id)
                                        <option value="{{ $itemsg->p4p_workgroupset_id }}" selected> {{ $itemsg->p4p_workgroupset_code }}::{{ $itemsg->p4p_workgroupset_name }} </option> 
                                        @else
                                        <option value="{{ $itemsg->p4p_workgroupset_id }}"> {{ $itemsg->p4p_workgroupset_code }}::{{ $itemsg->p4p_workgroupset_name }} </option> 
                                        @endif                                       
                                                                               
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                        </div>
                        <div class="row mt-3 mb-3">                           
                            <div class="col-md-2 text-end">
                                <label for="p4p_workset_time" style="font-family: sans-serif;font-size: 13px">ระยะเวลาที่ใช้จริง </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="p4p_workset_time" type="text" class="form-control form-control-sm"
                                        name="p4p_workset_time" value="{{$data_show->p4p_workset_time}}">
                                </div>
                            </div>
                            <div class="col-md-1 text-end">
                                <label for="p4p_workset_score" style="font-family: sans-serif;font-size: 13px">คะแนน/นาที </label>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <input id="p4p_workset_score" type="text" class="form-control form-control-sm"
                                        name="p4p_workset_score" value="{{$data_show->p4p_workset_score}}">
                                </div>
                            </div>
                            <div class="col-md-1 text-end">
                                <label for="p4p_workset_unit" style="font-family: sans-serif;font-size: 13px">หน่วยนับ </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"> 
                                        <select id="p4p_workset_unit" name="p4p_workset_unit"
                                        class="form-select form-select-sm show_unit" style="width: 100%">
                                        <option value=""> </option>
                                        @foreach ($p4p_workgroupset_unit as $items) 
                                        @if ($data_show->p4p_workset_unit == $items->p4p_workgroupset_unit_id)
                                            <option value="{{ $items->p4p_workgroupset_unit_id }}" selected> {{ $items->p4p_workgroupset_unit_name }} </option> 
                                        @else
                                            <option value="{{ $items->p4p_workgroupset_unit_id }}"> {{ $items->p4p_workgroupset_unit_name }} </option> 
                                        @endif                              
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-2"> 
                                <div class="form-outline bga">
                                    <input type="text" id="UNIT_INSERT" name="UNIT_INSERT" class="form-control form-control-sm shadow" style="background-color: rgb(254, 255, 177)" placeholder="ถ้าหน่วยนับไม่มี ให้เพิ่ม"/> 
                                </div> 
                            </div>
                            <div class="col-md-1 text-end"> 
                                <div class="form-group">
                                    <button type="button" class="btn btn-info btn-sm" onclick="addunitwork();">
                                        <i class="fa-solid fa-circle-plus me-2"></i>
                                        เพิ่ม
                                    </button> 
                                </div>
                            </div> 
                           
                           
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th width="10%" class="text-center">รหัสรายการ</th>
                                                    <th class="text-center">ชื่อรายการภาระงาน</th>
                                                    <th width="5%" class="text-center">ระยะเวลาที่ใช้จริง</th>
                                                    <th width="5%" class="text-center">คะแนน/นาที</th>
                                                    <th width="5%" class="text-center">รวมคะแนน/นาที</th>
                                                    <th width="5%" class="text-center">หน่วยนับ</th>
                                                    <th width="5%" class="text-center">สถานะ</th>
                                                    <th width="5%" class="text-center">จัดการ</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($p4p_workset as $item) 
                                                    <tr id="sid{{ $item->p4p_workset_id }}">   
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>    
                                                        <td class="text-center" width="10%" style="font-size: 13px">{{ $item->p4p_workset_code }}</td> 
                                                        <td class="p-2" style="font-size: 13px">{{ $item->p4p_workset_name }}</td>
                                                        <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workset_time }}</td> 
                                                        <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workset_score }}</td> 
                                                        <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workset_wp }}</td>
                                                        <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workgroupset_unit_name }}</td> 
                                                        <td width="5%">
                                                            @if($item-> p4p_workset_active == 'TRUE' )
                                                            <input type="checkbox" id="{{ $item-> p4p_workset_id }}" name="{{ $item-> p4p_workset_id }}" switch="none" onchange="switchactive({{ $item-> p4p_workset_id }});" checked />
                                                            @else
                                                            <input type="checkbox" id="{{ $item-> p4p_workset_id }}" name="{{ $item-> p4p_workset_id }}" switch="none" onchange="switchactive({{ $item-> p4p_workset_id }});" />
                                                            @endif
                                                            <label for="{{ $item-> p4p_workset_id }}" data-on-label="On" data-off-label="Off"></label>
 
                                                        </td>
                                                        <td class="text-center" width="5%">
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">ทำรายการ</button>
                                                                <ul class="dropdown-menu">
                                                                    <a class="dropdown-item menu btn btn-outline-warning btn-sm"
                                                                       href="{{url('p4p_workset_edit/'.$item->p4p_workset_id)}}"
                                                                        data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                                        <i class="fa-solid fa-file-pen me-2"
                                                                            style="color: rgb(252, 153, 23)"></i>
                                                                        <label for=""
                                                                            style="color: rgb(252, 153, 23)">แก้ไข</label>
                                                                    </a>
                                                                </ul>
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
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group"> 
                                <a href="{{ url('p4p_work') }}"
                                    class="btn btn-danger btn-sm"> 
                                    <i class="fa-regular fa-circle-left me-2"></i>
                                    ย้อนกลับ
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  
@endsection
@section('footer')
<script>
    
    function switchactive(idfunc){
            // var nameVar = document.getElementById("name").value;
            var checkBox = document.getElementById(idfunc);
            var onoff;
            
            if (checkBox.checked == true){
                onoff = "TRUE";
            } else {
                onoff = "FALSE";
            }
 
            var _token=$('input[name="_token"]').val();
                $.ajax({
                        url:"{{route('p4.p4p_workset_switchactive')}}",
                        method:"GET",
                        data:{onoff:onoff,idfunc:idfunc,_token:_token}
                })
       }
       function addunitwork() {
          var unitnew = document.getElementById("UNIT_INSERT").value;
        //   alert(unitnew);
          var _token = $('input[name="_token"]').val();
          $.ajax({
              url: "{{url('addunitwork')}}",
              method: "GET",
              data: {
                unitnew: unitnew,
                  _token: _token
              },
              success: function (result) {
                  $('.show_unit').html(result);
              }
          })
      }
</script>
<script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_workset_unit').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            $('#p4p_workset_group').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            $('#p4p_workset_position').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#Updatebtn').click(function() {
                var p4p_workset_id = $('#p4p_workset_id').val(); 
                var p4p_workset_code = $('#p4p_workset_code').val(); 
                var p4p_workset_name = $('#p4p_workset_name').val(); 
                var p4p_workset_user = $('#p4p_workset_user').val(); 
                var p4p_workset_time = $('#p4p_workset_time').val();
                var p4p_workset_score = $('#p4p_workset_score').val();
                var p4p_workset_unit = $('#p4p_workset_unit').val();
                var p4p_workset_group = $('#p4p_workset_group').val();
                var p4p_workset_position = $('#p4p_workset_position').val();
                $.ajax({
                    url: "{{ route('user.workset_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_workset_group,
                        p4p_workset_id,
                        p4p_workset_code,
                        p4p_workset_name,
                        p4p_workset_user,
                        p4p_workset_time,
                        p4p_workset_score,
                        p4p_workset_unit,
                        p4p_workset_position
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Edit data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                    // window.location="{{url('warehouse/warehouse_index')}}";
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
