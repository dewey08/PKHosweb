@extends('layouts.p4pnew')
@section('title', 'PK-OFFICER || P4P')

     <?php
     use App\Http\Controllers\P4pController;
     use Illuminate\Support\Facades\DB;   
     $refnumber = P4pController::refnumber();
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
               border-top: 10px #cafd12 solid;
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
                        <div class="row">
                            <div class="col-md-4">
                                <h5>เพิ่มหมวดภาระงาน P4P </h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="row mb-3">
                            <div class="col-md-2 text-end">
                                <label for="p4p_workgroupset_code" style="font-family: sans-serif;font-size: 13px">รหัสหมวด </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="p4p_workgroupset_code" type="text" class="form-control form-control-sm"
                                        name="p4p_workgroupset_code" value="{{$refnumber}}" readonly>
                                </div>
                            </div> 
                            <div class="col-md-2 text-end">
                                <label for="p4p_workgroupset_name" style="font-family: sans-serif;font-size: 13px">ชื่อหมวด </label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="p4p_workgroupset_name" type="text" class="form-control form-control-sm"
                                        name="p4p_workgroupset_name">
                                </div>
                            </div>
                            <input type="hidden" id="p4p_workgroupset_user" value="{{$iduser}}">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-sm" id="Savebtn">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
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
                                                    <th width="10%" class="text-center">รหัสหมวด</th>
                                                    <th class="text-center">ชื่อหมวดภาระงาน</th>
                                                    <th width="10%" class="text-center">สถานะ</th>
                                                    <th width="5%" class="text-center">จัดการ</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($p4p_workgroupset as $item) 
                                                    <tr id="sid{{ $item->p4p_workgroupset_id }}">   
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>    
                                                        <td class="text-center" width="10%" style="font-size: 13px">{{ $item->p4p_workgroupset_code }}</td> 
                                                        <td class="p-2" style="font-size: 13px">{{ $item->p4p_workgroupset_name }}</td>
                                                        <td width="10%">
                                                            @if($item-> p4p_workgroupset_active == 'TRUE' )
                                                            <input type="checkbox" id="{{ $item-> p4p_workgroupset_id }}" name="{{ $item-> p4p_workgroupset_id }}" switch="none" onchange="switchactive({{ $item-> p4p_workgroupset_id }});" checked />
                                                            @else
                                                            <input type="checkbox" id="{{ $item-> p4p_workgroupset_id }}" name="{{ $item-> p4p_workgroupset_id }}" switch="none" onchange="switchactive({{ $item-> p4p_workgroupset_id }});" />
                                                            @endif
                                                            <label for="{{ $item-> p4p_workgroupset_id }}" data-on-label="On" data-off-label="Off"></label>

                                                            {{-- @if($item-> p4p_workgroupset_active == 'TRUE' )
                                                            <input type="checkbox" switch="none" id="{{ $item-> p4p_workgroupset_id }}" name="{{ $item-> p4p_workgroupset_id }}" onchange="switchactive({{ $item-> p4p_workgroupset_id }});" checked>
                                                            @else
                                                            <input type="checkbox" switch="none" id="{{ $item-> p4p_workgroupset_id }}" name="{{ $item-> p4p_workgroupset_id }}" onchange="switchactive({{ $item-> p4p_workgroupset_id}});">
                                                            @endif --}}
                                                            {{-- <label class="custom-control-label" for="{{ $item-> p4p_workgroupset_id }}"></label> --}}

                                                        </td>
                                                        <td class="text-center" width="5%">
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">ทำรายการ</button>
                                                                <ul class="dropdown-menu">
                                                                    <a class="dropdown-item menu btn btn-outline-warning btn-sm"
                                                                       href="{{url('p4p_workgroupset_edit/'.$item->p4p_workgroupset_id)}}"
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
                                {{-- <button type="button" class="btn btn-primary btn-sm" id="Savebtn">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button> --}}
                                <a href="{{ url('p4p_work') }}"
                                    class="btn btn-danger btn-sm">
                                    {{-- <i class="fa-solid fa-xmark me-2"></i> --}}
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
                        url:"{{route('p4.p4p_workgroupset_switchactive')}}",
                        method:"GET",
                        data:{onoff:onoff,idfunc:idfunc,_token:_token}
                })
       }
</script>
<script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#Savebtn').click(function() {
                var p4p_workgroupset_code = $('#p4p_workgroupset_code').val(); 
                var p4p_workgroupset_name = $('#p4p_workgroupset_name').val(); 
                var p4p_workgroupset_user = $('#p4p_workgroupset_user').val(); 
                $.ajax({
                    url: "{{ route('p4.p4p_workgroupset_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_workgroupset_code,
                        p4p_workgroupset_name,
                        p4p_workgroupset_user
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
