@extends('layouts.market')
@section('title', 'ZOFFice || รายละเอียดรับสินค้า')
@section('menu')
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
    .btn {
        font-size: 15px;
    }
    .bgc {
            background-color: #264886;
        }

        .bga {
            background-color: #fbff7d;
        }
</style>
<?php
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\MarketController;
use App\Http\Controllers\StaticController;
    $refnumber = MarketController::refnumber(); 
    $refmaxidfirst = MarketController::refmaxidfirst(); 
    $count_product = StaticController::count_product(); 
    $count_service = StaticController::count_service(); 
    $count_marketproducts = StaticController::count_marketproducts(); 
    $count_market_repproducts = StaticController::count_market_repproducts();
?>
   <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">     
            
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-light btn-sm text-dark me-1">รายการสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("market/rep_product")}}" class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รับสินค้า<span class="badge bg-danger ms-2">{{$count_market_repproducts}}</span></a>  
        <div class="text-end">
            <a href=" " class="btn btn-secondary btn-sm text-white me-2">รายละเอียดรับสินค้า </a>
        </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="container-fluid " style="width: 97%">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        รายละเอียดรับสินค้า
                    </div>
                    <div class="card-body shadow-lg">

                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">
                            <input id="request_phone" type="hidden" class="form-control" name="request_phone" value="{{ Auth::user()->tel }}">
                            <input id="dep_subsubtrueid" type="hidden" class="form-control" name="dep_subsubtrueid" value="{{ Auth::user()->dep_subsubtrueid }}">
                            <input id="dep_subsubtruename" type="hidden" class="form-control" name="dep_subsubtruename" value="{{ Auth::user()->dep_subsubtruename }}">
                            <input type="hidden" name="refmaxid" id="refmaxid" value=" {{ $refmaxidfirst }}">
                            <input type="hidden" name="request_id" id="request_id" value=" {{ $dataedits->request_id}}">

                            <div class="row ">
                                <div class="col-md-1 text-end">
                                    <div class="form-group text-right">
                                        <label for="" class="">เลขที่</label>
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input id="request_code" type="text" class="form-control" name="request_code" value="{{ $dataedits->request_code }}" readonly>
                                    </div>
                                </div>  
                                <div class="col-md-2 text-end">
                                    <div class="form-group">
                                        <label for="">เลขที่บิล </label>
                                    </div>
                                </div>                        
                                <div class="col-md-2">
                                    <div class="form-group">
                                    
                                        <input id="request_no_bill" type="text" class="form-control" name="request_no_bill" value="{{ $dataedits->request_no_bill }}">
                                    </div>
                                </div>   
                                <div class="col-md-2 text-end">
                                    <div class="form-group">
                                        <label for="">ปี</label>
                                    </div>
                                </div>                                          
                                <div class="col-md-2">
                                    <div class="form-group">
                                     
                                        <select id="request_year" name="request_year" class="form-select-lg"
                                            style="width: 100%">
                                            @foreach ($budget_year as $year)
                                            @if ($dataedits->request_year == $year->leave_year_id)
                                            <option value="{{ $year->leave_year_id }}" selected> {{ $year->leave_year_id }}</option>
                                            @else
                                            <option value="{{ $year->leave_year_id }}"> {{ $year->leave_year_id }}</option>
                                            @endif
                                               
                                            @endforeach
                                        </select>
                                    </div>
                                </div>         
                               
                                                  
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-1 text-end">
                                    <div class="form-group">
                                        <label for="">วันที่ </label>
                                    </div>
                                </div>                        
                                <div class="col-md-2">
                                    <div class="form-group">
                                    
                                        <input id="request_date" type="date" class="form-control" name="request_date" value="{{ $dataedits->request_date }}">
                                    </div>
                                </div> 
                             
                                <div class="col-md-2 text-end">
                                    <div class="form-group">
                                        <label for="">ผู้รับ </label>
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                       
                                        
                                        <input id="" type="text" class="form-control" name="" value="{{ $dataedits->request_user_name }}" readonly>
                                    </div>
                                </div>  
                                <div class="col-md-2 text-end">
                                    <div class="form-group">
                                        <label for="">ตัวแทนจำหน่าย</label>
                                    </div>
                                </div>                                          
                                <div class="col-md-2">
                                    <div class="form-group">
                                     
                                        <select id="request_vendor_id" name="request_vendor_id" class="form-select-lg shwo_ven"
                                            style="width: 100%">
                                            @foreach ($products_vendor as $ven)
                                            @if ($dataedits->request_vendor_id == $ven->vendor_id )
                                            <option value="{{ $ven->vendor_id }}" selected> {{ $ven->vendor_name }} </option>
                                            @else
                                            <option value="{{ $ven->vendor_id }}"> {{ $ven->vendor_name }} </option>
                                            @endif
                                                
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  
                            </div>
                            <hr>                           
                           
                            <div class="row mt-3">
                                {{-- <div class="col-md-1"> </div> --}}
                                <div class="col-md-12"> 
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"> 
                                            <thead>
                                                    <tr>
                                                        <th width="4%" class="text-center">ลำดับ</th>
                                                        <th width="12%" class="text-center">รหัสสินค้า</th>
                                                        <th  class="text-center">รายการสินค้า</th>  
                                                        <th width="12%" class="text-center">หน่วยนับ</th>                             
                                                        <th width="12%" class="text-center">จำนวน</th>
                                                        <th class="text-center" width="12%">ราคา</th>
                                                        <th class="text-center" width="12%">รวม</th>
                                                       
                                                        <th width="10%" class="text-center">Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; $total = 0; ?>
                                                    @foreach ($repsubs as $itemsub)
                                                        <tr id="sid{{ $itemsub->request_sub_id }}">
                                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                                            <td class="text-center" width="12%">{{ $itemsub->request_sub_product_code }} </td>
                                                            <td class="p-2" >{{ $itemsub->request_sub_product_name }}</td> 
                                                            <td class="text-center" width="12%">{{ $itemsub->request_sub_unitname }}</td>
                                                            <td class="text-center" width="12%">{{ $itemsub->request_sub_qty }}</td>
                                                            <td class="text-end" width="12%">{{ $itemsub->request_sub_price }}</td>
                                                            <td class="text-end" width="12%">{{ $itemsub->request_sub_sum_price }}</td>
                                                            
                                                            <td class="text-center" width="10%">
                                                                
                                                               
                                                            </td>
                                                        </tr>
                                                        <?php   
                                                            $total =   $total + ($itemsub->request_sub_qty * $itemsub->request_sub_price);    
                                                        ?>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="6" align="right" class="p-2">ราคารวมทั้งหมด</td> 
                                                        <td align="right" class="text-danger p-2"><b>{{number_format(($total),2)}} </b></td> 
                                                        
                                                        <td class="p-2">บาท</td>
                                                        
                                                    </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-1"> </div>
                        </div>
                            <div class="modal-footer"> 
                                <a href="{{url('market/rep_product')}}" class="btn btn-danger btn-sm" ><i class="fa-solid fa-circle-left me-2"></i>ย้อนกลับ</a>
                              
                            </div>
                       

                            
                    </div>
                </div>
            </div>
        </div>


       
   

    @endsection
