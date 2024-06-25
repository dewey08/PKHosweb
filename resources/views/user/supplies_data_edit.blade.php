@extends('layouts.user')
@section('title', 'ZOffice || พัสดุ')


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
    use App\Models\Products_request_sub;
    $refnumber = UsersuppliesController::refnumber();
    ?>
    <div class="container-fluid">
        <div class="px-0 py-0 border-bottom mb-2">
            <div class="d-flex flex-wrap justify-content-center">
                <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white me-2"></a>

                <div class="text-end">
                    <a href="{{ url('user/gleave_data_dashboard') }}" class="btn btn-light text-dark me-2">dashboard</a>
                    <a href="{{ url('user/supplies_data') }}" class="btn btn-primary text-white me-2">ขอจัดซื้อ-จัดจ้าง</a>                   
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card ">
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
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="custom-validation" action="{{ route('user.supplies_data_update') }}" method="POST"
                            id="update_usersuppliesForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">
                            <input id="request_id" type="hidden" class="form-control" name="request_id" value="{{ $products_request->request_id }}">
                            <input id="tel" type="hidden" class="form-control" name="tel" value="{{ Auth::user()->tel }}">
                            <input id="dep_subsubtrueid" type="hidden" class="form-control" name="dep_subsubtrueid" value="{{ Auth::user()->dep_subsubtrueid }}">
                            <input id="dep_subsubtruename" type="hidden" class="form-control" name="dep_subsubtruename" value="{{ Auth::user()->dep_subsubtruename }}">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">เลขที่บิล</label>
                                        <input id="request_code" type="text" class="form-control" name="request_code"
                                            value="{{ $products_request->request_code }}" readonly>
                                    </div>
                                </div>                               
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">ปีงบประมาณ</label>
                                        <select id="request_year" name="request_year" class="form-select-lg"
                                            style="width: 100%">
                                            @foreach ($budget_year as $year)
                                            @if ($products_request->request_year == $year->leave_year_id)
                                            <option value="{{ $year->leave_year_id }}" selected> {{ $year->leave_year_id }} </option>
                                            @else
                                            <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }} </option>
                                            @endif                                               
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">วันที่ต้องการ</label>
                                        <input id="request_date" type="date" class="form-control" name="request_date" value="{{ $products_request->request_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">เหตุผล</label>
                                        <input id="request_because" type="text" class="form-control" name="request_because" value="{{ $products_request->request_because }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">บริษัทแนะนำ</label>
                                        <select id="request_vendor_id" name="request_vendor_id"
                                            class="form-select form-select-lg" style="width: 100%">
                                            @foreach ($products_vendor as $ven)
                                            @if ($products_request->request_vendor_id == $ven->vendor_id)
                                            <option value="{{ $ven->vendor_id }}" selected> {{ $ven->vendor_name }} </option>
                                            @else
                                            <option value="{{ $ven->vendor_id }}"> {{ $ven->vendor_name }} </option>
                                            @endif
                                               
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary mt-4"><i class="fa-solid fa-arrow-left me-3"></i>  แก้ไข </button>
                                    </div>
                                </div>

                            </div>
                           
                    </div>                   
                  </form>
                </div>
            </div>
        </div>
            <br>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <a href="" class="btn btn-light"> {{ __('ข้อมูลจัดซื้อ-จัดจ้าง') }}</a>
                            </div>
                            <div class="col-7">
                            </div>
                            <div class="col">
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
                                <?php $i = 1;                        
                                $date =  date('Y');                                            
                                ?>      
                                    @foreach ( $dataedit_data as $items ) 
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
                                                <td class="text-center" width="5%">{{$i++}}</td> 
                                                <td class="text-center" width="7%">
                                                    <?php                                                    
                                                    $datacount = Products_request_sub::where('request_id','=',$items->request_id )->count();
                                                    ?>                                                  
                                                    @if ($datacount > 0)
                                                    <span class="badge bg-warning">รอเห็นชอบ</span>
                                                    @else
                                                    <span class="{{$statuscol}}">{{ $items->products_status_name }}</span>
                                                    @endif
                                                    {{-- <span class="{{$statuscol}}">{{ $items->products_status_name }}</span>     --}}
                                                </td>  
                                                <td class="text-center" width="10%"> {{$items->request_code}}</td>                          
                                                <td class="text-center" width="10%">{{$items->request_year}}</td>
                                                <td class="text-center" width="10%">{{DateThai($items->request_date)}}</td>
                                                <td class="p-2">{{$items->request_debsubsub_name}}</td>  
                                                <td class="text-center" width="15%">{{$items->request_user_name}}</td>
                                                <td class="text-center" width="20%">
                                                    <a href="{{ url('user/supplies_data_add_sub/'.Auth::user()->id.'/' .$items->request_id) }}"
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
                                                    {{-- <a class="btn rounded-pill text-danger" href="javascript:void(0)"
                                                        onclick="repsupplies_destroy({{ $items->request_id}})"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        data-bs-custom-class="custom-tooltip" title="ลบ">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a> --}}
                                                </td>                                               
                                            </tr>                           
                                    @endforeach                                                              
                            </tbody>
                            </table>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">                              
                                    {{$dataedit_data->links()}}   
                                </ul>
                            </nav>
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

    <script src="{{ asset('js/user_products_request.js') }}"></script>   

    <script type="text/javascript">
        $(document).ready(function() {

            $('#table_id').DataTable();

            $('#request_year').select2({
                placeholder: "ปีงบประมาณ",
                allowClear: true
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
