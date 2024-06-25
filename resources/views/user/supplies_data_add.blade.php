@extends('layouts.user')
@section('title', 'ZOffice || พัสดุ')

@section('content')

<style>
    .btn{
       font-size:15px;
     }
     .bgc{
      background-color: #264886;
     }
     .bga{
      background-color: #fbff7d;
     }
     .boxpdf{
      /* height: 1150px; */
      height: auto;
     }
   
      .fpdf{
          /* width:1024px; */
          height:650px;
          width:1024px;
          /* height:auto; */
          margin:0;
          
          overflow:scroll;
          background-color: #DAD8D8;
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

    $refnumber = UsersuppliesController::refnumber();    
    $checkhn = StaticController::checkhn($iduser);
    $checkhnshow = StaticController::checkhnshow($iduser);
    ?>
    <div class="container-fluid">
        {{-- <div class="px-0 py-0 border-bottom mb-2"> --}}
            <div class="d-flex flex-wrap justify-content-center">
                <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>

                <div class="text-end">
                    {{-- <a href="{{ url('user/gleave_data_dashboard') }}" class="btn btn-light btn-sm text-dark me-2">dashboard</a> --}}
                    <a href="{{ url('user/supplies_data') }}" class="btn btn-primary btn-sm text-white me-2 mb-2">ขอจัดซื้อ-จัดจ้าง</a>                   
                </div>
            </div>
        {{-- </div> --}}
        {{-- <div class="row justify-content-center">
            <div class="col-md-12"> --}}
                {{-- <div class="card "> --}}
                    {{-- <div class="card-header">
                        <div class="row">
                            <div class="col">

                                <a href="" class="btn btn-light"> {{ __('เพิ่มข้อมูลจัดซื้อ-จัดจ้าง') }}</a>
                            </div>
                            <div class="col-7">
                            </div>
                            <div class="col">
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif --}}
                        {{-- <form class="custom-validation" action="{{ route('user.supplies_data_save') }}" method="POST"
                            id="insert_usersuppliesForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">
                            <input id="request_phone" type="hidden" class="form-control" name="request_phone" value="{{ Auth::user()->tel }}">
                            <input id="dep_subsubtrueid" type="hidden" class="form-control" name="dep_subsubtrueid" value="{{ Auth::user()->dep_subsubtrueid }}">
                            <input id="dep_subsubtruename" type="hidden" class="form-control" name="dep_subsubtruename" value="{{ Auth::user()->dep_subsubtruename }}"> --}}

                            {{-- <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">เลขที่บิล</label>
                                        <input id="request_code" type="text" class="form-control" name="request_code"
                                            value="{{ $refnumber }}" readonly>
                                    </div>
                                </div>                               
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">ปีงบประมาณ</label>
                                        <select id="request_year" name="request_year" class="form-select-lg"
                                            style="width: 100%">
                                            @foreach ($budget_year as $year)
                                                <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">วันที่ต้องการ</label>
                                        <input id="request_date" type="date" class="form-control" name="request_date" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">เหตุผล</label>
                                        <input id="request_because" type="text" class="form-control" name="request_because">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">บริษัทแนะนำ</label>
                                        <select id="request_vendor_id" name="request_vendor_id"
                                            class="form-select form-select-lg" style="width: 100%">
                                            @foreach ($products_vendor as $ven)
                                                <option value="{{ $ven->vendor_id }}"> {{ $ven->vendor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary mt-4"> <i class="fa-solid fa-arrow-down me-3"></i>  เพิ่ม </button>
                                    </div>
                                </div>

                            </div> --}}
                           
                    {{-- </div> --}}
                    {{-- <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary "> <i class="fa-solid fa-arrow-down me-3"></i>  เพิ่ม </button>
                    </div> --}}
                  {{-- </form> --}}
                {{-- </div>
            </div>
        </div>
            <br> --}}
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
                                <a href="" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#saexampleModal">เพิ่มขอซื้อ-ขอจ้าง</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="table_id">
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
                                                <td class="text-center" width="17%">
                                                    {{-- <a href="{{ url('user/supplies_data_add_sub/'.Auth::user()->id.'/' .$items->request_id) }}"
                                                        class="btn rounded-pill text-primary" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                        title="เพิ่มรายการวัสดุ" >
                                                        <i class="fa-solid fa-circle-plus me-3"></i>เพิ่มรายการวัสดุ
                                                    </a>
                                                    <a href="{{ url('user/supplies_data_edit/'.Auth::user()->id.'/'.$items->request_id) }}"
                                                        class="btn rounded-pill text-warning" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                        title="แก้ไข">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a class="btn rounded-pill text-danger" href="javascript:void(0)"
                                                        onclick="repsupplies_destroy({{ $items->request_id}})"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a> --}}

                                                    <a href="{{ url('user/supplies_data_add_sub/'.Auth::user()->id.'/' .$items->request_id) }}" class="btn btn-light btn-sm text-primary " data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุ" >
                                                        <i class="fa-solid fa-circle-plus "></i>
                                                    </a>
                                                    {{-- <a href="" class="text-primary me-3" data-bs-toggle="modal" data-bs-target="#editexampleModal{{Auth::user()->id.'/'.$items->request_id}}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="เพิ่มรายการวัสดุ">
                                                        <i class="fa-solid fa-circle-plus me-3"></i>
                                                    </a> --}}
                                                    {{-- <a class="btn btn-light btn-sm text-warning" data-bs-toggle="modal" data-bs-target="#editexampleModal">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a> --}}
                                                    <a href=""
                                                            class="btn btn-light btn-sm text-warning edit_suprep"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editexampleModal"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="bottom" 
                                                            data-bs-custom-class="custom-tooltip" 
                                                            title="แก้ไข"
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
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>                                                                 
                                                    <a class="btn btn-light btn-sm text-danger" href="javascript:void(0)" onclick="repsupplies_destroy({{ $items->request_id}})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="ลบ">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a> 
                                                </td>                                               
                                            </tr>                           
                                    @endforeach                                                              
                            </tbody>
                            </table>

                            {{-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">                              
                                    {{$products_request->links()}}   
                                </ul>
                            </nav> --}}
                        </div> 
                    </div> 
                    <div class="card-footer text-end">
                        {{-- <button class="btn btn-light"></button> --}}
                    </div>
                </div>

            </div>


        </div>
    </div>
    </div>

 <!-- Modal -->
 <div class="modal fade" id="saexampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มขอซื้อ-ขอจ้าง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="custom-validation" action="{{ route('user.supplies_data_save') }}" method="POST"
                            id="insert_usersuppliesForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">
                            <input id="request_phone" type="hidden" class="form-control" name="request_phone" value="{{ Auth::user()->tel }}">
                            <input id="dep_subsubtrueid" type="hidden" class="form-control" name="dep_subsubtrueid" value="{{ Auth::user()->dep_subsubtrueid }}">
                            <input id="dep_subsubtruename" type="hidden" class="form-control" name="dep_subsubtruename" value="{{ Auth::user()->dep_subsubtruename }}">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">เลขที่บิล</label>
                                <input id="request_code" type="text" class="form-control" name="request_code"
                                    value="{{ $refnumber }}" readonly>
                            </div>
                        </div>                               
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ปีงบประมาณ</label>
                                <select id="request_year" name="request_year" class="form-select-lg"
                                    style="width: 100%">
                                    @foreach ($budget_year as $year)
                                        <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">วันที่ต้องการ</label>
                                <input id="request_date" type="date" class="form-control" name="request_date" required>
                            </div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">เหตุผล</label>
                                <input id="request_because" type="text" class="form-control" name="request_because">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ผู้เห็นชอบ</label>
                                <select id="mySelect2" name="request_hn_id"
                                    class="form-select form-select-lg" style="width: 100%">
                                    @foreach ($datashows as $itemuser)
                                    @if ($leave_leader_sub->leader_id == $itemuser->id)
                                        <option value="{{ $itemuser->id }}" selected> {{ $itemuser->fname }}  {{ $itemuser->lname }}</option>
                                    @else
                                        <option value="{{ $itemuser->id }}"> {{ $itemuser->fname }}  {{ $itemuser->lname }}</option>
                                    @endif                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- {{$checkhnshow}} --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


 <!--Edit Modal -->
 <div class="modal fade" id="editexampleModal" tabindex="-1" aria-labelledby="editexampleModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editexampleModal">แก้ไขขอซื้อ-ขอจ้าง</h5>
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">เลขที่บิล</label>
                                <input id="up_request_code" type="text" class="form-control" name="request_code" readonly>
                            </div>
                        </div>                               
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ปีงบประมาณ</label>
                                <select id="request_year2" name="request_year" class="form-select-lg"
                                    style="width: 100%">
                                    @foreach ($budget_year as $year)
                                        <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">วันที่ต้องการ</label>
                                <input id="up_request_date" type="date" class="form-control" name="request_date">
                            </div>
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">เหตุผล</label>
                                <input id="up_request_because" type="text" class="form-control" name="request_because">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">ผู้เห็นชอบ</label>
                             <select id="up_request_hn_id" name="request_hn_id"
                                    class="form-select form-select-lg" style="width: 100%">
                                    @foreach ($datashows as $itemuser)
                                    @if ($leave_leader_sub->leader_id == $itemuser->id)
                                        <option value="{{ $itemuser->id }}" selected> {{ $itemuser->fname }}  {{ $itemuser->lname }}</option>
                                    @else
                                        <option value="{{ $itemuser->id }}"> {{ $itemuser->fname }}  {{ $itemuser->lname }}</option>
                                    @endif                                        
                                    @endforeach
                                </select> 
                                  <!-- <input id="up_request_hn_id" type="text" class="form-control" name="up_request_hn_id"> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


    <script src="{{ asset('js/user_products_request.js') }}"></script>   

    <script type="text/javascript">
        $(document).ready(function() {
            
            $('#mySelect2').select2({
                dropdownParent: $('#saexampleModal')
            });

            $('#up_request_hn_id').select2({
                dropdownParent: $('#editexampleModal')
            });

            $('#table_id').DataTable();

            $('#request_year').select2({
                dropdownParent: $('#saexampleModal')
                // placeholder: "ปีงบประมาณ",
                // allowClear: true
            });
            $('#request_year2').select2({
                dropdownParent: $('#editexampleModal')
                // placeholder: "ปีงบประมาณ",
                // allowClear: true
            });
            $('#request_user_id').select2({
                placeholder: "ผู้รายงาน",
                allowClear: true
            });
            $('#request_hn_id').select2({
                placeholder: "ผู้เห็นชอบ",
                allowClear: true
            });
            $('#request_vendor_id').select2({
                placeholder: "บริษัทแนะนำ",
                allowClear: true
            });
        });
    </script>
@endsection
