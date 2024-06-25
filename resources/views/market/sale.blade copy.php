@extends('layouts.market')
@section('title', 'ZOFFice || ทำรายการรับสินค้า')
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
    $refmaxid = MarketController::refmaxid(); 
    $count_product = StaticController::count_product(); 
    $count_service = StaticController::count_service(); 
    $count_marketproducts = StaticController::count_marketproducts(); 
    $count_market_repproducts = StaticController::count_market_repproducts();
?>
   <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">     
            
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-light btn-sm text-dark me-1">รายการขายสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("market/sale_index")}}" class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รายการขายสินค้า<span class="badge bg-danger ms-2">{{$count_market_repproducts}}</span></a>  
        <div class="text-end">
            {{-- <a href=" " class="btn btn-secondary btn-sm text-white me-2">เพิ่มรายการสินค้า </a> --}}
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
                        รายการสินค้า
                    </div>
                    <div class="card-body">

                            <form class="custom-validation" action="{{ route('mar.rep_product_addsub_save') }}" method="POST" enctype="multipart/form-data">
                                 
                                @csrf
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">
                                <input id="request_phone" type="hidden" class="form-control" name="request_phone" value="{{ Auth::user()->tel }}">
                                <input id="dep_subsubtrueid" type="hidden" class="form-control" name="dep_subsubtrueid" value="{{ Auth::user()->dep_subsubtrueid }}">
                                <input id="dep_subsubtruename" type="hidden" class="form-control" name="dep_subsubtruename" value="{{ Auth::user()->dep_subsubtruename }}">
                             
                            <div class="row text-center">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-1 text-end">
                                    <label for="request_sub_product_id">รายการสินค้า :</label>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">                                        
                                        <select id="request_sub_product_id" name="request_sub_product_id" class="form-select-lg"
                                        style="width: 100%">
                                        @foreach ($market_product as $items)
                                            <option value="{{ $items->product_id }}"> {{ $items->product_name }}
                                            </option>
                                        @endforeach
                                    </select>                                 
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <label for="request_sub_qty">จำนวน :</label>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input name="request_sub_qty" id="request_sub_qty" class="form-control" >                                      
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <label for="request_sub_price">ราคา :</label>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input name="request_sub_price" id="meetting_year" class="form-control" >                                      
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary btn-sm" >เพิ่ม</button>
                                </div>
                                                             
                            </div>
                           
                        </form>
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
                                                            {{-- <th width="12%" class="text-center">หน่วยนับ</th> --}}
                                                            <th width="12%" class="text-center">จำนวน</th>
                                                            <th class="text-center" width="12%">ราคา</th>
                                                            <th class="text-center" width="12%">รวม</th>
                                                           
                                                            <th width="10%" class="text-center">Manage</th>
                                                        </tr>
                                                    </thead>
                                                  
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-1"> </div>
                            </div>

                            <div class="modal-footer"> 
                                <a href="{{url('market/rep_product')}}" class="btn btn-danger btn-sm" > <i class="fa-solid fa-xmark me-2"></i>ปิด</a>
                               
                            </div>
                      

                        
                    </div>
                </div>
            </div>
        </div>


       
   

    @endsection
