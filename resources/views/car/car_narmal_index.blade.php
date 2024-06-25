 
@extends('layouts.car')
@section('title', 'PK-OFFICER || ยานพาหนะ')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function car_narmal_updatecancel(car_service_id)
        {
                // alert(bookrep_id);
                Swal.fire({
                title: 'ต้องการยกเลิกรายการนี้ใช่ไหม?',
                text: "ข้อมูลนี้จะถูกยกเลิก !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ',
                cancelButtonText: 'ไม่'
                }).then((result) => {
                if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            });
                            $.ajax({ 
                            type: "POST",
                            url:"{{url('car/car_narmal_updatecancel')}}" +'/'+ car_service_id, 
                            success:function(response)
                            {          
                                Swal.fire({
                                title: 'ยืนยันการยกเลิกสำเร็จ',
                                text: "Cancel Data Success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                if (result.isConfirmed) {   
                                    window.location.reload(); 
                                }
                                }) 
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
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    use App\Http\Controllers\UsercarController;
        use App\Http\Controllers\StaticController;
        use App\Models\Products_request_sub; 
        use Illuminate\Support\Facades\DB;   
        $count_article_car = StaticController::count_article_car();
        $count_car_service = StaticController::count_car_service();
        $refnumber = UsercarController::refnumber();    
        $checkhn = StaticController::checkhn($iduser);
        $checkhnshow = StaticController::checkhnshow($iduser);
        $count_suprephn = StaticController::count_suprephn($iduser);
        $count_bookrep_po = StaticController::count_bookrep_po();
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

    @keyframes pageIn {
        0% {
            transform: translateX(-300px);
            opacity: 0;
        }

        100% {
            transform: translateX(0px);
            opacity: 1;
        }
    }

    @media (min-width: 500px) {
        .modal {
            --bs-modal-width: 500px;
        }
    }

    @media (min-width: 950px) {
        .modal-lg {
            --bs-modal-width: 950px;
        }
    }

    @media (min-width: 1500px) {
        .modal-xls {
            --bs-modal-width: 1500px;
        }
    }

    @media (min-width: auto; ) {
        .container-fluids {
            width: auto;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: auto;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right
        }

        .dataTables_wrapper .dataTables_length {
            float: left
        }

        .dataTables_info {
            float: left;
        }

        .dataTables_paginate {
            float: right
        }

        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
        }

        .table thead tr th {
            font-size: 14px;
        }

        .table tbody tr td {
            font-size: 13px;
        }

        .menu {
            font-size: 13px;
        }
    }

    .hrow {
        height: 2px;
        margin-bottom: 9px;
    }

    .custom-tooltip {
        --bs-tooltip-bg: var(--bs-primary);
    }

    .colortool {
        background-color: red;
    }
</style>
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header ">
                    {{-- <form action="{{ url('account_money_rep/'.$id) }}" method="POST">
                        @csrf --}}
                    <div class="row">
                        <div class="col-md-3 text-left">
                            <h6>ข้อมูลการขอใช้รถยนต์ทั้งหมด</h6>
                        </div>
                       
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" name="startdate" id="datepicker"
                                    data-date-container='#datepicker1' data-provide="datepicker"
                                    data-date-language="th-th" data-date-autoclose="true" {{-- value="{{ $startdate }} " --}}>
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-1 text-end">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" name="enddate" id="datepicker2"
                                    data-date-container='#datepicker1' data-provide="datepicker"
                                    data-date-language="th-th" data-date-autoclose="true" {{-- value="{{ $enddate }} " --}}>
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
 
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                        </div>
                        <div class="col"></div>

                        <div class="col-md-2 text-end">
                            {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#insertuserdata"> 
                                    เพิ่มเจ้าหน้าที่
                                </button> --}}
                            {{-- <a href="{{ url('car/car_data_index_add') }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-car-on text-primary me-2"></i>
                                เพิ่มข้อมูลยานพาหนะ
                            </a> --}}
                        </div>

                        {{-- <div class="col-md-1 text-start">
                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#copydata"> 
                                    คัดลอกข้อมูลเดิม
                                </button>
                            </div> --}}
                    </div>

                </div>
                {{-- </form> --}}
                <div class="card-body shadow-lg">
                          <div class="table-responsive">
                                <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> 
                                      <thead>
                                          <tr height="10px">
                                              <th width="7%">ลำดับ</th>
                                              <th width="10%">สถานะ</th>
                                              <th width="10%">วันที่ไป</th>
                                              <th>เหตุผล</th> 
                                              <th width="25%">สถานที่ไป</th> 
                                              <th width="15%">ผู้ร้องขอ</th>
                                              <th width="10%">จัดการ</th>
                                          </tr>  
                                      </thead>
                                      <tbody>
                                        <?php $i = 1; ?>
                                            @foreach ($car_service as $item)
                                                <tr id="sid{{ $item->car_service_id }}" height="30">
                                                    <td class="text-center" width="3%">{{ $i++ }}</td>    
                                                   
                                                    @if ($item->car_service_status == 'request')
                                                    <td class="text-center" width="7%"><div class="badge bg-warning">ร้องขอ</div></td>
                                                    @elseif ($item->car_service_status == 'allocate')
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #592DF7">จัดสรร</div></td>   
                                                    @elseif ($item->car_service_status == 'allocateall')
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #07D79E">จัดสรรร่วม</div></td>  
                                                      @elseif ($item->car_service_status == 'noallow')
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #E80DEF">ไม่อนุมัติ</div></td>    
                                                    @elseif ($item->car_service_status == 'cancel')
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #ff0606">แจ้งยกเลิก</div></td>  
                                                    @elseif ($item->car_service_status == 'confirmcancel')
                                                    <td class="text-center" width="7%"><div class="badge " style="background: #ab9e9e">ยกเลิก</div></td>                                                                                       
                                                    @else
                                                      <td class="text-center" width="7%"><div class="badge" style="background: #3CDF44">อนุมัติ</div></td>
                                                    @endif

  
                                                    <td class="p-2">{{ dateThai($item->car_service_date)}} </td> 
                                                    <td class="p-2">{{ $item->car_service_reason }}</td> 
                                                    <td class="p-2" width="25%">{{ $item->car_location_name }}</td>
                                                    <td class="p-2" width="15%">{{ $item->car_service_user_name }}</td>
                                                    <td class="text-center" width="10%">                                                    
                                                        <div class="dropdown">
                                                          <button class="btn btn-outline-info dropdown-toggle menu" type="button" data-bs-toggle="dropdown" aria-expanded="false">ทำรายการ</button>
                                                          <ul class="dropdown-menu">
                                                                <li>
                                                                  <a class="dropdown-item menu" data-bs-toggle="modal" data-bs-target="#cardetailModal{{$item->car_service_id}}" data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด">
                                                                    <i class="fa-solid fa-file-pen mt-2 ms-2 mb-2 me-2 text-info" style="font-size: 13px;"></i>
                                                                    <label for="" style="font-size: 13px;color: rgb(33, 187, 248)">รายละเอียด</label> 
                                                                  </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item menu" href="{{ url('user_car/car_narmal_print/'. $item->car_service_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Print" >
                                                                      <i class="fa-solid fa-print mt-2 ms-2 mb-2 me-2 text-primary" style="font-size: 13px;"></i>
                                                                      <label for="" style="font-size: 13px;color: rgb(24, 115, 252)">Print</label> 
                                                                    </a>
                                                                  </li>
                                                                  <li>
                                                                    <a class="dropdown-item menu" href="javascript:void(0)" onclick="car_narmal_updatecancel({{$item->car_service_id}})" data-bs-toggle="tooltip" data-bs-placement="left" title="แจ้งยกเลิก">
                                                          
                                                                      <i class="fa-solid fa-xmark me-2 mt-2 ms-2 mb-2 text-danger" style="font-size: 13px;"></i>
                                                                      <label for="" style="font-size: 13px;color: rgb(255, 22, 22)">ยืนยันการยกเลิก</label> 
                                                                    </a>
                                                                  </li>        
                                                                {{-- <li>
                                                                  <a class="dropdown-item menu" href="{{ url('po/allow_all_add/'. $item->car_service_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="จัดการ" >
                                                                    <i class="fa-solid fa-file-pen mt-2 ms-2 mb-2 me-2 text-primary"></i>
                                                                    <label for="" style="color: rgb(8, 111, 228)">จัดการ</label> 
                                                                  </a>
                                                                </li> --}}
                                                                 
                                                          </ul>
                                                        </div>
                                                    </td>
                                              </tr> 

                                              <div class="modal fade" id="cardetailModal{{$item->car_service_id}}" tabindex="-1" aria-labelledby="cardetailModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">                                                        
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="cardetailModalLabel">รายละเอียดจองรถยนต์ทะเบียน {{$item->car_service_register}}</h5>
                                                              
                                                            </div>
                                                            <div class="modal-body">
                                                              
                                                                <div class="row">
                                                                    <div class="col-md-2 ">
                                                                        <label for=""><b>ตามหนังสือเลขที่ :</b></label>
                                                                    </div>
                                                                    <div class="col-md-4">                                                                     
                                                                          <label for="car_service_reason">{{$item->car_service_book}}</label>                                                                     
                                                                    </div>
                                                                    <div class="col-md-2 ">
                                                                        <label for=""><b>ปีงบประมาณ :</b></label>
                                                                    </div>
                                                                    <div class="col-md-3">                                                                      
                                                                          <label for="car_service_reason">{{$item->car_service_year}}</label>                                                                    
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-2">
                                                                        <label for=""><b>สถานที่ไป :</b></label>
                                                                    </div>
                                                                    <div class="col-md-4"> 
                                                                        <div class="form-group">
                                                                          <label for="car_service_reason">{{$item->car_location_name}}</label>
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-md-2 ">
                                                                      <label for="" ><b>เหตุผล :</b></label>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                      <div class="form-group">
                                                                        <label for="car_service_reason">{{$item->car_service_reason}}</label>
                                                                      </div> 
                                                                    </div>                                                                   
                                                                </div>                                                             

                                                                <div class="row mt-3">
                                                                    <div class="col-md-2">
                                                                        <label for=""><b>วันที่ไป :</b></label>
                                                                    </div> 
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                          <label for="car_service_year">{{ dateThai($item->car_service_date)}}</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                      <label for=""><b>ตั้งแต่เวลา :</b></label>
                                                                  </div> 
                                                                  <div class="col-md-1">
                                                                      <div class="form-group">
                                                                        <label for="car_service_year">{{formatetime($item->car_service_length_gotime)}}</label>
                                                                      </div>
                                                                  </div>
                                                                    <div class="col-md-1">
                                                                        <label for=""><b>ถึงเวลา :</b></label>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                          <label for="car_service_year">{{formatetime($item->car_service_length_backtime)}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                              
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="closebtn">
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

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('js/gcpdfviewer.js') }}"></script> 

<script> 
var wrapper = document.getElementById("signature-pad");
var clearButton = wrapper.querySelector("[data-action=clear]");
var savePNGButton = wrapper.querySelector("[data-action=save-png]");
var canvas = wrapper.querySelector("canvas");
var el_note = document.getElementById("note");
var signaturePad;
signaturePad = new SignaturePad(canvas);
clearButton.addEventListener("click", function (event) {
document.getElementById("note").innerHTML="The signature should be inside box";
signaturePad.clear();
});
savePNGButton.addEventListener("click", function (event){
if (signaturePad.isEmpty()){
    alert("Please provide signature first.");
    event.preventDefault();
}else{
    var canvas  = document.getElementById("the_canvas");
    var dataUrl = canvas.toDataURL();
    document.getElementById("signature").value = dataUrl;

    // ข้อความแจ้ง
        Swal.fire({
            title: 'สร้างสำเร็จ',
            text: "You create success",
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#06D177',               
            confirmButtonText: 'เรียบร้อย'
        }).then((result) => {
            if (result.isConfirmed) {}
        })  
}
});
function my_function(){
document.getElementById("note").innerHTML="";
} 

</script>
<script>
    function adddrive() {
       var drivenew = document.getElementById("DRIVE_INSERT").value; 
       var _token = $('input[name="_token"]').val();
       alert(drivenew);
       $.ajax({
           url: "{{route('car.adddrive')}}",
           method: "POST",
           data: {
            drivenew: drivenew,
               _token: _token
           },
           success: function (result) {
               $('.show_drive').html(result);
           }
       })
     }
</script>
<script>
    $(document).on('click','.edit_car',function(){
                  var id = $(this).val();
                  alert(id);
                          $('#carModal').modal('show');
                          $.ajax({
                          type: "GET",
                          url:"{{url('car/car_narmal_allocate')}}" +'/'+ id,  
                          success: function(data) {
                            //   console.log(data.carservice.car_service_id);
                              // $('#line_token_name').val(data.carservice.line_token_name)  
                              // $('#line_token_code').val(data.carservice.line_token_code) 
                              // $('#line_token_id').val(data.carservice.car_service_id)                
                          },      
                  });
          });
  </script>
@endsection