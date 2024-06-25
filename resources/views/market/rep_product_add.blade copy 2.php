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
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber(); 
    $count_product = StaticController::count_product(); 
    $count_service = StaticController::count_service(); 
?>
   <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">     
            <a href="{{url("market/product_index")}}" class="btn btn-secondary btn-sm text-white me-2">รายการสินค้า<span class="badge bg-danger ms-2">{{$count_product}}</span></a>   
            <a href="{{url("market/rep_product")}}" class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รับสินค้า<span class="badge bg-danger ms-2">{{$count_service}}</span></a>  
        <div class="text-end">
            <a href=" " class="btn btn-light btn-sm text-dark me-2">ทำรายการรับสินค้า </a>
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
                        ทำรายการรับสินค้า
                    </div>
                    <div class="card-body shadow-lg">
                        
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="card me-1">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="table_id">
                                            <thead>
                                                <tr height="10px"> 
                                                    <th>รหัส</th>
                                                    <th>รายการวัสดุ</th>  
                                                    <th>qty</th> 
                                                    <th>ราคา</th>   
                                                    <th>หน่วย</th> 
                                                    <th>เพิ่ม</th>                                        
                                                </tr>  
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;                        
                                                $date =  date('Y');                                            
                                                ?>      
                                                @foreach ( $product_data as $items )                                                                                                      

                                                        <tr id="sid{{$items->product_id}}"> 
                                                            <td width="20%" class="text-center"> 
                                                                {{$items->product_code}}
                                                            </td>                          
                                                            <td class="p-2">{{$items->product_name}}</td>
                                                          
                                                    <form class="custom-validation" action="{{route('user.supplies_data_add_subsave')}}" method="POST">
                                                        @csrf
                                                            <td class="p-2" width="10%"><input type="text" class="form-control form-control-sm" id="request_sub_qty" name="request_sub_qty" required></td> 
                                                            <td class="p-2" width="15%"><input type="text" class="form-control form-control-sm" id="request_sub_price" name="request_sub_price"></td> 
                                                          
                                                          
                                                            <td class="text-center" width="13%">{{$items->product_unit_subname}}</td> 
                                                            <td width="5%" class="text-center">  
                                                              
                                                                    <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                                                    <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">
                                                                    {{-- <input type="hidden" name="product_id" id="product_id" value=" {{ $items->product_id }}">  
                                                                    <input type="hidden" name="request_id" id="request_id" value=" {{ $products_request->request_id }}">  --}}
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus text-white"></i> </button>
                                                            </td> 
                                                    </form>   
                                                                                         
                                                        </tr> 

                                                @endforeach                                                              
                                            </tbody>
                                            </table>
                                        
                                            {{-- <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-center">                              
                                                    {{$product_data->links()}}                            
                                                </ul>
                                            </nav> --}}
                    
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-6"> 

                                    <div class="card mt-2">                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover table-sm" style="width: 100%;" >
                                                <thead>
                                                    <tr height="10px"> 
                                                        <th width="39%" class="text-center">รายการ</th>
                                                        <th width="15%" class="text-center"> จำนวน</th>
                                                        <th width="21%" class="text-center"> ราคา</th>
                                                        <th width="25%" class="text-center"> จัดการ</th> 
                                                    </tr>  
                                                </thead>
                                                <tbody>
                                                                                             
                                                </tbody>
                                            </table>
                    
                                           
                    
                                        </div> 
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>


       
   

    @endsection
