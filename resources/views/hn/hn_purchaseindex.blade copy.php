@extends('layouts.userhn')
@section('title','ZOffice || หัวหน้า')
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
      <?php
      use App\Http\Controllers\UsersuppliesController;
      use App\Http\Controllers\StaticController;
      use App\Models\Products_request_sub;
      use Illuminate\Support\Facades\DB;

      $refnumber = UsersuppliesController::refnumber();    
      $checkhn = StaticController::checkhn($iduser);
      $checkhnshow = StaticController::checkhnshow($iduser);
      ?>
      <style>
        .btn{
           font-size:15px;
         }
         .xl{
          font-size:15px;
         }
         .bgc{
          background-color: #264886;
         }
         .bga{
          background-color: #FCFF9A;
         }
         .bgon{
          background-color: #FFF48F;
         }
        
         /* .page{
              width: 100%;
              margin: 5px;
              /* box-shadow: 0px 0px 10px #000; */
              /* animation: pageIn 3s ease; */
              /* transition: all 1s ease, width 0.2s ease; */
          /* } */ */
          
      
</style>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="" class="btn btn-light btn-sm"> {{ __('รายการจัดซื้อ-จัดจ้าง') }}</a>
                                    </div>
                                    <div class="col-md-7">
                                    </div>
                                    <div class="col">
                                        <a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#saexampleModal">อนุมัติทั้งหมด</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="examplesup">
                                        <thead>
                                            <tr height="10px">
                                            <th width="5%">ลำดับ</th>
                                            <th width="7%">สถานะ</th>
                                            <th>เลขที่บิล</th>
                                            <th>ปีงบประมาณ</th>
                                            <th>วันที่ต้องการ</th>
                                            <th>หน่วยงานที่ขอเบิก</th>   
                                            <th>ผู้ร้องขอ</th>  
                                            <th>ทำรายการ</th>                                          
                                            </tr>  
                                        </thead>
                                        <tbody>
                                            
                                                @foreach ( $products_request as $key=>$items ) 
                                                        <?php 
                                                            $status =  $items->request_status;                    
                                                            if( $status === 'REQUEST'){
                                                                $statuscol =  "badge bg-info";                    
                                                            }else if($status === 'PENDING'){
                                                                $statuscol =  "badge bg-warning";                        
                                                            }else if($status === 'VERIFY'){
                                                                $statuscol =  "badge bg-primary";
                                                            }else if($status === 'APPROVE'){
                                                                $statuscol =  "badge bg-success";
                                                            }else if($status === 'CANCEL'){
                                                                $statuscol =  "badge bg-danger";
                                                            }else if($status === 'APPROVECANCEL'){
                                                                $statuscol =  "badge bg-success";
                                                            }else{
                                                                $statuscol =  "badge bg-secondary";
                                                            }                    
                                                        ?>
                                                        <tr id="sid{{$items->request_id}}">
                                                            <td class="text-center" width="5%">{{$key+1}}</td> 
                                                            <td class="text-center" width="7%">
                                                                <?php                                                    
                                                                    $datacount = Products_request_sub::where('request_id','=',$items->request_id )->count();
                                                                ?>                                                  
                                                                @if ($datacount > 0)
                                                                <span class="badge bg-warning">รอเห็นชอบ</span>
                                                                @else
                                                                <span class="{{$statuscol}}">{{ $items->products_status_name }}</span>
                                                                @endif
                                                                
                                                            </td>  
                                                            <td class="text-center" width="12%"> {{$items->request_code}}</td>                          
                                                            <td class="text-center" width="10%">{{$items->request_year}}</td>
                                                            <td class="text-center" width="12%">{{DateThai($items->request_date)}}</td>
                                                            <td class="p-2">{{$items->request_debsubsub_name}}</td>  
                                                            <td class="text-center" width="14%">{{$items->request_user_name}}</td>
                                                            <td class="text-center" width="10%">
                                                            
                                                                <a href=""
                                                                        {{-- class="btn btn-light btn-sm text-warning edithn_suprep" --}}
                                                                        class="btn btn-light btn-sm text-warning"
                                                                        data-bs-toggle="modal"
                                                                        {{-- data-bs-target="#editexampleModal{{$items->request_id}}"  --}}
                                                                        data-bs-target="#editexampleModal" onclick="detail({{$items->request_id}})"
                                                                        data-request_id="{{$items->request_id}}"
                                                                        data-request_code="{{$items->request_code}}"
                                                                        data-request_year="{{$items->request_year}}"
                                                                        data-request_date="{{$items->request_date}}"
                                                                        data-request_debsubsub_name="{{$items->request_debsubsub_name}}"
                                                                        data-request_user_name="{{$items->request_user_name}}"
                                                                        data-request_because="{{$items->request_because}}"
                                                                        data-request_hn_id="{{$items->request_hn_id}}"
                                                                        data-request_hn_name="{{$items->request_hn_name}}"
                                                                        data-user_id="{{Auth::user()->id}}"
                                                                >
                                                                    <i class="fa-solid fa-highlighter"></i>
                                                                </a>                                                                 
                                                            
                                                            </td>                                               
                                                        </tr>    

                                                        <?php  
                                                            $idsub = DB::table('products_request_sub')->where('request_id','=',$items->request_id)->first();
                                                        ?>
                                                                
                                                                <!--Edit Modal -->
                                                                {{-- <div class="modal fade" id="editexampleModal{{$items->request_id}}" tabindex="-1" aria-labelledby="editexampleModal" aria-hidden="true">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editexampleModal">รายละเอียดขอซื้อ-ขอจ้าง</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form class="custom-validation" action="{{ route('user.supplies_data_update') }}" method="POST"
                                                                                        id="update_upplies_repForm" enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                                                                        <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">
                                                                                        <input id="request_phone" type="hidden" class="form-control" name="request_phone" value="{{ Auth::user()->tel }}">
                                                                                        <input id="dep_subsubtrueid" type="hidden" class="form-control" name="dep_subsubtrueid" value="{{ Auth::user()->dep_subsubtrueid }}">
                                                                                        <input id="dep_subsubtruename" type="hidden" class="form-control" name="dep_subsubtruename" value="{{ Auth::user()->dep_subsubtruename }}">
                                                                                        <input type="hidden" name="request_id" id="up_request_id" >

                                                                                <div class="row">
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-outline bgon">
                                                                                        <input type="text" id="up_request_code" class="form-control form-control-lg" name="request_code" value="{{$items->request_code}}"/>
                                                                                        <label class="form-label" for="up_request_code">เลขที่บิล</label>
                                                                                        </div>
                                                                                        
                                                                                    </div>                               
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-outline bgon">
                                                                                            <input type="text" id="up_request_year" class="form-control form-control-lg " name="request_year" value="{{$items->request_year}}"/>
                                                                                            <label class="form-label" for="up_request_year">ปีงบประมาณ</label>
                                                                                        </div>
                                                                                    </div>   
                                                                                    <div class="col-md-2">
                                                                                        <div class="form-outline bgon">
                                                                                        <input type="text" id="up_request_date" class="form-control form-control-lg " name="request_date" value="{{DateThai($items->request_date)}}"/>
                                                                                        <label class="form-label" for="up_request_year">วันที่ต้องการ</label>
                                                                                        </div>
                                                                                    </div>                             
                                                                                    <div class="col-md-3">
                                                                                    <div class="form-outline bgon">
                                                                                        <input type="text" id="up_request_because" class="form-control form-control-lg " name="request_because" value="{{$items->request_because}}"/>
                                                                                        <label class="form-label" for="up_request_year">เหตุผล</label>
                                                                                    </div>
                                                                                </div> 
                                                                                <div class="col-md-3"> 
                                                                                    <div class="form-outline bgon">
                                                                                        <input type="text" id="up_request_because" class="form-control form-control-lg " name="request_because" value="{{$items->request_hn_name}}"/>
                                                                                        <label class="form-label" for="up_request_year">ผู้เห็นชอบ</label>
                                                                                    </div>
                                                                                </div>

                                                                                </div>
                                                                                <hr>
                                                                                    <div class="row mt-2 text-center">
                                                                                            <div class="col-md-2">ลำดับ  </div>
                                                                                            <div class="col-md-5"> รายการ </div>
                                                                                            <div class="col-md-2"> จำนวน </div>
                                                                                            <div class="col-md-3"> ราคา </div>  
                                                                                    </div>
                                                                                
                                                                                    <hr> 
                                                                                        
                                                                                   
                                                                                    <div class="row text-center" style="height: 3px">
                                                                                            <div class="col-md-2">  </div>
                                                                                            <div class="col-md-5"> รายการ </div>
                                                                                            <div class="col-md-2"> 10 </div>
                                                                                            <div class="col-md-3"> 95 </div>  
                                                                                        </div>
                                                                                    </div>
 
                                                                                <hr>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div> --}}



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

<!-------------------------------------------------------รายละเอียด---------------------------------------->
{{-- <div id="detail_appall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">

        <div class="row">
        <div><h3  style="font-family: 'Kanit', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;เห็นชอบขอซื้อขอจ้างพัสดุ&nbsp;&nbsp;</h3></div>
        </div>
            </div>
            <div class="modal-body" >
            <form  method="post" action=" " enctype="multipart/form-data">
            @csrf


             <div id="detail"></div>



            </div>
            <div class="modal-footer">
            <div align="right">
            <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal" ><i class="fas fa-window-close mr-2"></i>ปิดหน้าต่าง</button>

            </div>
            </div>
            </form>
    </body>


        </div>
        </div>
    </div> --}}


        <!--Edit Modal -->
        <div class="modal fade" id="editexampleModal" tabindex="-1" aria-labelledby="editexampleModal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editexampleModal">รายละเอียดขอซื้อ-ขอจ้าง</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body"> 
                                            
                            <div id="detail"></div>
                          
                                           
                           </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                        </div>
              
             
                </div>
            </div>
        </div>
        </div>
    </body>
        {{-- <script>
             function detail_sub(request_id){
            // alert(request_id);
            $.ajax({
                        url:"/hn/hn_purchaseindex_detail/" + request_id,
                        // url:"/hn/hn_purchaseindex_detail",
                        method:"GET",
                        // data:{id:id},
                        success:function(result){
                            $('#detail').html(result);                
                        }  
                })  
            }
        </script> --}}

<script src="{{ asset('js/hn.js') }}"></script>   

    {{-- <script type="text/javascript">
        $(document).ready(function() { 
           
            // $('#mySelect2').select2({
            //     dropdownParent: $('#saexampleModal')
            // });

            // $('#up_request_hn_id').select2({
            //     dropdownParent: $('#editexampleModal')
            // });

            // $('#table_id').DataTable();

            // $('#request_year').select2({
            //     dropdownParent: $('#saexampleModal')
            //     // placeholder: "ปีงบประมาณ",
            //     // allowClear: true
            // });
            // $('#request_year2').select2({
            //     dropdownParent: $('#editexampleModal')
            //     // placeholder: "ปีงบประมาณ",
            //     // allowClear: true
            // });
            // $('#request_user_id').select2({
            //     placeholder: "ผู้รายงาน",
            //     allowClear: true
            // });
            // $('#request_hn_id').select2({
            //     placeholder: "ผู้เห็นชอบ",
            //     allowClear: true
            // });
            // $('#request_vendor_id').select2({
            //     placeholder: "บริษัทแนะนำ",
            //     allowClear: true
            // });
       });
    </script> --}}
@endsection
