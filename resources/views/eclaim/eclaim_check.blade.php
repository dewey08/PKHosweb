@extends('layouts.pkclaim')
@section('title','PK-OFFICER || Karn Report')
@section('content')
    <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
     <?php
     use App\Http\Controllers\karnController;
     use Illuminate\Support\Facades\DB; 
 ?>
  <div class="container-fluid">
        <!-- start page title -->
        {{-- <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between"> --}}
                 
                    <div class="row">                        
                        <div class="col-xl-12">
                            <form action="{{ route('claim.eclaim_check') }}" method="POST" >
                                @csrf
                            <div class="row">                   
                                    <div class="col"><h5 class="mb-sm-0">เปลี่ยนสถานะใน ECLAIM</h5></div>
                                    {{-- <div class="col-md-1 text-end">CLAIM CODE</div>
                                    <div class="col-md-2 text-center">
                                        <input id="claimcode" name="claimcode" class="form-control form-control-sm" type="text" value="{{$claimcode}}">                                                
                                    </div> --}}
                                    <div class="col-md-1 text-center">HN</div>
                                    <div class="col-md-2 text-center">
                                        <input id="hn" name="hn" class="form-control form-control-sm" type="text" value="{{$hn}} ">                             
                                    </div>
                                    <div class="col-md-2"> 
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                                            ค้นหา
                                        </button>
                                    </div>
                                    <div class="col"></div>
                                </form>
                            </div>
                        </div>
                    </div>

                {{-- </div>
            </div>
        </div> --}}
        <!-- end page title -->

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">                     
                        <div class="card-body py-0 px-2 mt-2"> 
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                    id="example"> 
                                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >    --}}
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>
                                                <th class="text-center">ECLAIM_NO</th>
                                                <th class="text-center">HCODE</th>
                                                <th class="text-center">HN</th>
                                                <th class="text-center">AN</th>
                                                <th class="text-center">DATEADM</th>
                                                <th class="text-center">PID</th>
                                                <th class="text-center">TITLES</th>
                                                <th class="text-center">FNAME</th>
                                                <th class="text-center">LNAME</th>
                                                <th class="text-center">MAININSCL</th>
                                                <th class="text-center">CLAIMCODE</th>
                                                <th class="text-center">STATUS</th>
                                                <th class="text-center">แก้ไข</th>
                                                <th class="text-center">SUMS_SERVICEITEM</th>
                                                <th class="text-center">CODE_ID</th>
                                                <th class="text-center">FILENAME_SEND</th>
                                                <th class="text-center">REP</th>
                                                <th class="text-center">TRAN_ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($claim as $item)
                                            
                                                <tr>
                                                    <td>{{$i++ }}</td>
                                                    <td>{{$item->ECLAIM_NO}}</td>
                                                    <td>{{$item->HCODE }}</td>
                                                    <td>{{$item->HN }}</td> 
                                                    <td>{{ $item->AN }} </td>                                            
                                                    <td class="text-center" >{{ $item->DATEADM }}</td>  
                                                    <td class="text-center">{{ $item->PID }}</td>                                                       
                                                    <td>{{ $item->TITLES }} </td>  
                                                    <td>{{ $item->FNAME }} </td>  
                                                    <td>{{ $item->LNAME }} </td>  
                                                    <td>{{ $item->MAININSCL }} </td>  
                                                    <td>{{ $item->CLAIMCODE }} </td> 
                                                    <td> {{ $item->STATUS }}  </td>  
                                                    <td>  
                                                        {{-- <button type="button"class="dropdown-item menu edit_claim" value="{{ $item->ECLAIM_NO }}" data-bs-toggle="tooltip" data-bs-placement="left" title="ปรับสถานะ">
                                                            <i class="fa-solid fa-pen-to-square" style="color: rgb(9, 168, 160)"></i> 
                                                          </button> --}}
                                                          <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target=".detail{{ $item->HN }}" style="color: rgb(230, 76, 5)"> 
                                                          <i class="fa-solid fa-pen-to-square" style="color: rgb(230, 76, 5)" style="font-size:13px"></i> 
                                                          {{-- <span>แก้ไข</span> --}}
                                                        </a>
                                                    </td>  
                                                    <td>{{ $item->SUMS_SERVICEITEM }} </td>  
                                                    <td>{{ $item->CODE_ID }} </td> 
                                                    <td>{{ $item->FILENAME_SEND }} </td> 
                                                    <td>{{ $item->REP }} </td> 
                                                    <td>{{ $item->TRAN_ID }} </td> 
                                                </tr>

                                                <div class="modal fade detail{{$item->HN }}" id="detailclaim"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ route('claim.eclaim_check_update') }}" id="heck_updateForm" method="POST">
                                                                @csrf
                                                                {{-- <input type="hidden" id="ECLAIM_NO" name="ECLAIM_NO" value="{{$item->ECLAIM_NO}}">  --}}
                                                                <input type="hidden" id="HN" name="HN" value="{{$item->HN}}"> 
                                                  
                                                            <div class="modal-header bg-info">
                                                                <h5 class="modal-title" id="exampleModalLabel">ปรับสถานะ</h5>               
                                                            </div>
                                                            <div class="modal-body">            
                                                                  <div class="row">
                                                                      <div class="col-md-12">
                                                                        <select name="ECLAIM_STATUS" id="ECLAIM_STATUS" class="form-control form-control-sm" style="width: 100%;"> 
                                                                            <option value="0">0</option>
                                                                            <option value="1">1</option>
                                                                            <option value="2" style="color: rgb(241, 105, 135)">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                        
                                                                        </select>
                                                                      </div>                                                               
                                                                  </div>       
                                                            </div>
                                                          
                                                            <div class="modal-footer"> 
                                                                <button type="submit" class="btn btn-info">
                                                                    <i class="fa-solid fa-floppy-disk text-white me-2"></i>
                                                                    แก้ไขข้อมูล
                                                                </button> 
                                                            </div>
                                                          </form> 
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
 
  

 

    @endsection
    @section('footer')       
        <script>
        //      $(document).on('click','.edit_claim',function(){
        //         var ECLAIM_NO = $(this).val();
        //         var ECLAIM_STATUS = $(this).val();
        //         alert(ECLAIM_STATUS);
        //                 $('#linetokenModal').modal('show');
        //                 $.ajax({
        //                 type: "GET",
        //                 url:"{{url('eclaim_check_edit')}}" +'/'+ ECLAIM_NO,  
        //                 success: function(data) {
        //                     // console.log(data.code.ECLAIM_NO);
        //                     $('#ECLAIM_NO').val(data.code.ECLAIM_NO)  
        //                     $('#ECLAIM_STATUS').val(data.code.ECLAIM_STATUS)                
        //                 },      
        //         });
        // });
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();

                $('select').select2();
                $('#ECLAIM_STATUS').select2({
                    dropdownParent: $('#detailclaim')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#heck_updateForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = this; 
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        beforeSend: function() {
                            $(form).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You Insert data success",
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
                             
                            } else {
                                // Swal.fire(
                                //     'ไม่มีข้อมูลต้องการจัดการ !',
                                //     'You clicked the button !',
                                //     'warning'
                                //     )
                            }
                        }
                    });
                });                 
            });
           
        </script>
    
       
    @endsection
