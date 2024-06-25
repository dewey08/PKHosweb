@extends('layouts.p4pnew')
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
           font-size: 13px;
       }
       .btn {
           font-size: 13px;
       }
       .bgc {
           background-color: #264886;
       }
       .bga {
           background-color: #fbff7d;
       }
       .boxpdf {
           /* height: 1150px; */
           height: auto;
       }
       .page {
           width: 90%;
           margin: 10px;
           box-shadow: 0px 0px 5px #000;
           animation: pageIn 1s ease;
           transition: all 1s ease, width 0.2s ease;
       }
       
       @media (min-width: 1500px) {
           .modal-xls {
               --modal-width: 1500px;
           }
       }
        
       
   </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>บันทึกรายการภาระงาน P4P </h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                         <div class="row mb-3"> 
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                <label for="p4p_workset_name" style="font-family: sans-serif;font-size: 13px">ปี </label>
                            </div>
                            <div class="col-md-1">
                                <label for="p4p_workset_name" style="font-family: sans-serif;font-size: 12px">{{$y}} </label>
                            </div>  
                            <div class="col-md-1 text-end">
                                <label for="p4p_workset_name" style="font-family: sans-serif;font-size: 13px">เดือน </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="p4p_workset_unit" name="p4p_workset_unit"
                                        class="form-select form-select-sm show_unit" style="width: 100%">
                                        <option value=""> </option>
                                        @foreach ($leave_month as $items)  
                                        @if ($month == $items->MONTH_ID)
                                        <option value="{{ $items->MONTH_ID }}" selected> {{ $items->MONTH_NAME }} </option>
                                        @else
                                        <option value="{{ $items->MONTH_ID }}"> {{ $items->MONTH_NAME }} </option>
                                        @endif                                              
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="p4p_workset_user" value="{{$iduser}}">

                            <div class="col-md-2">
                                <a class="btn btn-primary btn-sm" href="{{url('p4p_work_choose/'.$y.'/'.$month)}}">
                                    <i class="fa-solid fa-circle-plus me-2"></i>
                                    บันทึก P4P
                                </a>
                            </div>
                            <div class="col"></div>
                        </div> 
                        
                        {{-- <hr> --}}
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th width="10%" class="text-center">รหัสรายการ</th>
                                                    <th class="text-center">ชื่อรายการภาระงาน</th>
                                                    <th width="5%" class="text-center">ระยะเวลาที่ใช้จริง</th>
                                                    <th width="5%" class="text-center">คะแนน/นาที</th>
                                                    <th width="5%" class="text-center">หน่วยนับ</th> 
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
                                                        <td class="text-center" width="5%" style="font-size: 13px">{{ $item->p4p_workgroupset_unit_name }}</td> 
                                                        
                                                        <td class="text-center" width="5%">
                                                            <button type="button" class="btn btn-outline-primary btn-sm detail" 
                                                            value="{{ $item->p4p_workset_id }}" data-bs-toggle="tooltip" >
                                                            <i class="fa-solid fa-circle-info me-2 text-info" style="font-size:13px"></i> 
                                                                บันทึก P4P
                                                            </button>
                                                        </td>
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table> --}}
                                    </div>
                                </p>     

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group"> 
                                {{-- <a href="{{ url('p4p_work') }}"
                                    class="btn btn-danger btn-sm"> 
                                    <i class="fa-regular fa-circle-left me-2"></i>
                                    ย้อนกลับ
                                </a> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--  Modal content for the above example -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">บันทึกรายการภาระงาน P4P</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Cras mattis consectetur purus sit amet fermentum.
                        Cras justo odio, dapibus ac facilisis in,
                        egestas eget quam. Morbi leo risus, porta ac
                        consectetur ac, vestibulum at eros.</p>
                    <p>Praesent commodo cursus magna, vel scelerisque
                        nisl consectetur et. Vivamus sagittis lacus vel
                        augue laoreet rutrum faucibus dolor auctor.</p>
                    
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
     $(document).on('click', '.detail', function() {
            var id = $(this).val();
            // alert(line_token_id);
            $('#detailModal').modal('show');
            $('#Savebtn').click(function() {
                var p4p_workset_code = $('#p4p_workset_code').val(); 
                var p4p_workset_name = $('#p4p_workset_name').val(); 
                var p4p_workset_user = $('#p4p_workset_user').val(); 
                var p4p_workset_time = $('#p4p_workset_time').val();
                var p4p_workset_score = $('#p4p_workset_score').val();
                var p4p_workset_unit = $('#p4p_workset_unit').val();
                var p4p_workset_group = $('#p4p_workset_group').val();
                $.ajax({
                    url: "{{ route('p4.p4p_workset_save') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_workset_code,
                        p4p_workset_name,
                        p4p_workset_user,
                        p4p_workset_time,
                        p4p_workset_score,
                        p4p_workset_unit,
                        p4p_workset_group
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

            $('#Savebtn').click(function() {
                var p4p_workset_code = $('#p4p_workset_code').val(); 
                var p4p_workset_name = $('#p4p_workset_name').val(); 
                // var p4p_workset_user = $('#p4p_workset_user').val(); 
                // var p4p_workset_time = $('#p4p_workset_time').val();
                // var p4p_workset_score = $('#p4p_workset_score').val();
                // var p4p_workset_unit = $('#p4p_workset_unit').val();
                // var p4p_workset_group = $('#p4p_workset_group').val();
                // $.ajax({
                //     url: "{{ route('p4.p4p_workset_save') }}",
                //     type: "POST",
                //     dataType: 'json',
                //     data: {
                //         p4p_workset_code,
                //         p4p_workset_name,
                //         p4p_workset_user,
                //         p4p_workset_time,
                //         p4p_workset_score,
                //         p4p_workset_unit,
                //         p4p_workset_group
                //     },
                //     success: function(data) {
                //         if (data.status == 200) {
                //             Swal.fire({
                //                 title: 'บันทึกข้อมูลสำเร็จ',
                //                 text: "You Insert data success",
                //                 icon: 'success',
                //                 showCancelButton: false,
                //                 confirmButtonColor: '#06D177',
                //                 confirmButtonText: 'เรียบร้อย'
                //             }).then((result) => {
                //                 if (result
                //                     .isConfirmed) {
                //                     console.log(
                //                         data);
                //                     window.location.reload();
                //                     // window.location="{{url('warehouse/warehouse_index')}}";
                //                 }
                //             })
                //         } else {

                //         }

                //     },
                // });
            });
        });
        
</script>

@endsection
