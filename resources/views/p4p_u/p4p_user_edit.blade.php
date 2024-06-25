@extends('layouts.user')
@section('title', 'PK-OFFICER || P4P')

     


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
               border-top: 10px #128bfd solid;
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
    <?php
    use App\Http\Controllers\P4pController;
    use Illuminate\Support\Facades\DB;   
    $refnumberwork = P4pController::refnumberwork();
    $refwork = P4pController::refwork();
    $y = $data_show->p4p_work_year+543;
?>
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
                        <h5>บันทึกรายการภาระงาน P4P </h5>
                        <div class="btn-actions-pane-right"> 
    
                        </div>

                         
                    </div>
                    <div class="card-body shadow-lg">
                         {{-- <div class="row mb-3 mt-3"> 
                            <div class="col"></div>
                            <div class="col-md-1 text-end">
                                <label for="p4p_work_code" style="font-family: sans-serif;font-size: 13px">รหัส</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="p4p_work_code" type="text" class="form-control form-control-sm"
                                        name="p4p_work_code" value="{{$data_show->p4p_work_code}}" readonly>
                                </div>
                            </div> 
                            <div class="col-md-1 text-end">
                                <label for="p4p_work_year" style="font-family: sans-serif;font-size: 13px">ปี </label>
                            </div>
                            <div class="col-md-2">  
                                <select id="p4p_work_year" name="p4p_work_year"
                                        class="form-select form-select-sm" style="width: 100%">
                                        <option value=""> </option>
                                        @foreach ($budget_year as $its)  
                                        @if ($y == $its->leave_year_id)
                                        <option value="{{ $its->leave_year_id }}" selected> {{ $its->leave_year_id }} </option>
                                        @else
                                        <option value="{{ $its->leave_year_id }}"> {{ $its->leave_year_id }} </option>
                                        @endif                                              
                                        @endforeach
                                    </select>
                            </div>  
                            <div class="col-md-1 text-end">
                                <label for="p4p_work_month" style="font-family: sans-serif;font-size: 13px">เดือน </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select id="p4p_work_month" name="p4p_work_month"
                                        class="form-select form-select-sm" style="width: 100%">
                                        <option value=""> </option>
                                        @foreach ($leave_month as $items)  
                                        @if ($data_show->p4p_work_month == $items->MONTH_ID)
                                        <option value="{{ $items->MONTH_ID }}" selected> {{ $items->MONTH_NAME }} </option>
                                        @else
                                        <option value="{{ $items->MONTH_ID }}"> {{ $items->MONTH_NAME }} </option>
                                        @endif                                              
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="p4p_work_user" value="{{$iduser}}"> 
                            <input type="hidden" id="p4p_work_id" value="{{$data_show->p4p_work_id}}"> 

                            <div class="col-md-2"> 
                                <button type="button" class="btn btn-primary btn-sm" id="Updatebtn">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    แก้ไขข้อมูล
                                </button>

                            </div>
                            <div class="col"></div>
                        </div> 
                        <hr> --}}
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th width="15%" class="text-center">รหัสรายการ</th>
                                                    <th width="10%" class="text-center">ปี</th>
                                                    <th class="text-center">เดือน</th> 
                                                    <th width="5%" class="text-center">จัดการ</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($p4p_work as $item) 
                                                    <tr id="sid{{ $item->p4p_work_id }}">   
                                                        <td class="text-center" width="5%">{{ $i++ }}</td>    
                                                        <td class="text-center" width="15%" style="font-size: 13px">{{ $item->p4p_work_code }}</td> 
                                                        <td class="text-center" style="font-size: 13px" width="10%">{{ $item->p4p_work_year }}</td>
                                                        <td class="p-2" style="font-size: 13px">{{ $item->MONTH_NAME }}</td>                                                          
                                                        <td class="text-center" width="10%">
                                                            {{-- <a href="{{url('p4p_user_edit/'.$item->p4p_work_id)}}" class="btn btn-outline-warning btn-sm" data-bs-toggle="tooltip" >
                                                                <i class="fa-solid fa-circle-info me-2 text-info" style="font-size:13px"></i> 
                                                                   แก้ไข P4P
                                                            </a> --}}
                                                            <a href="{{url('work_choose/'.$item->p4p_work_id)}}" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" >
                                                                <i class="fa-solid fa-circle-info me-2 text-info" style="font-size:13px"></i> 
                                                                บันทึก P4P
                                                            </a>
                                                            {{-- <button type="button" class="btn btn-outline-primary btn-sm" 
                                                                value="{{ $item->p4p_work_id }}" data-bs-toggle="tooltip" >
                                                                <i class="fa-solid fa-circle-info me-2 text-info" style="font-size:13px"></i> 
                                                                    บันทึก P4P
                                                            </button> --}}
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
{{-- <script>
     $(document).on('click', '.detail', function() {
            var id = $(this).val(); 
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
</script> --}}
<script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#p4p_work_month').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            $('#p4p_work_year').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
            
            $('#p4p_workset_group').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });

            $('#Updatebtn').click(function() {
                var p4p_work_id = $('#p4p_work_id').val();
                var p4p_work_user = $('#p4p_work_user').val(); 
                var p4p_work_month = $('#p4p_work_month').val(); 
                var p4p_work_year = $('#p4p_work_year').val(); 
                var p4p_work_code = $('#p4p_work_code').val(); 
                $.ajax({
                    url: "{{ route('user.p4p_user_update') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        p4p_work_id,
                        p4p_work_user,
                        p4p_work_month,
                        p4p_work_year,
                        p4p_work_code 
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
