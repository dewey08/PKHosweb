@extends('layouts.person')
@section('title', 'PK-OFFICER || Day-Off')

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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>เพิ่มรายการวันหยุด </h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="row mb-3">
                            <div class="col-md-1 text-end">
                                <label for="date_holiday" style="font-family: sans-serif;font-size: 13px">วันที่ </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group"> 
                                        <div class="input-group" id="datepicker1">
                                            <input type="text" class="form-control" name="date_holiday" id="datepicker"  data-date-container='#datepicker1'
                                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{$data_p4p_dayoff->date_holiday}}"> 
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                </div>
                            </div> 
                            <div class="col-md-1 text-end">
                                <label for="date_detail" style="font-family: sans-serif;font-size: 13px">รายละเอียด </label>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input id="date_detail" type="text" class="form-control form-control-sm"
                                        name="date_detail" value="{{$data_p4p_dayoff->date_detail}}">
                                </div>
                            </div>
                            <div class="col-md-1 text-end">
                                <label for="date_type" style="font-family: sans-serif;font-size: 13px">ประเภทวันหยุด </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="date_type" type="text" class="form-control form-control-sm"
                                        name="date_type" value="{{$data_p4p_dayoff->date_type}}">
                                </div>
                            </div>
                            <input type="hidden" id="" value="{{$iduser}}">
                            <input type="hidden" id="p4p_dayoff_id" name="p4p_dayoff_id" value="{{$data_p4p_dayoff->p4p_dayoff_id}}">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-sm" id="Updatebtn">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    แก้ไขข้อมูล
                                </button>
                            </div>
                            <div class="col"></div>
                        </div>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-hover table-sm table-light dt-responsive nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th width="15%" class="text-center">วันที่</th>
                                                    <th class="text-center">รายการวันหยุด</th>
                                                    <th width="20%" class="text-center">ประเภทวันหยุด</th>
                                                    <th width="5%" class="text-center">จัดการ</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($p4p_dayoff as $item) 
                                                    <tr id="sid{{ $item->p4p_dayoff_id }}">   
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>    
                                                        <td class="text-center" width="15%" style="font-size: 13px">{{ $item->date_holiday }}</td> 
                                                        <td class="p-2" style="font-size: 13px">{{ $item->date_detail }}</td>
                                                        <td width="20%"> {{ $item->date_type }} </td>
                                                        <td class="text-center" width="5%">
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-primary dropdown-toggle menu btn-sm"
                                                                    type="button" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">ทำรายการ</button>
                                                                <ul class="dropdown-menu">
                                                                    <a class="dropdown-item menu btn btn-outline-warning btn-sm"
                                                                       href="{{url('p4p_dayoff_edit/'.$item->p4p_dayoff_id)}}"
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
                    
                </div>
            </div>
        </div>
    </div>
    </div>
  
@endsection
@section('footer')
 
<script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();

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
            $('#Updatebtn').click(function() {
                var date_holiday = $('#datepicker').val(); 
                var date_detail = $('#date_detail').val(); 
                var date_type = $('#date_type').val(); 
                var p4p_dayoff_id = $('#p4p_dayoff_id').val(); 
                
                $.ajax({
                    url: "{{ route('person.p4p_dayoff_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        date_holiday, 
                        date_detail,
                        date_type,
                        p4p_dayoff_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Update data success",
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
