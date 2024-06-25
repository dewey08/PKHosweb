@extends('layouts.market')
@section('title', 'ZOFFice || เพิ่มรายการสินค้า')
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
    $count_marketproducts = StaticController::count_marketproducts(); 
    $count_market_repproducts = StaticController::count_market_repproducts();
?>
   <div class="px-3 py-2 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">     
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-secondary btn-sm text-white me-2">รายการสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("market/product_index")}}" class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-secondary btn-sm text-white me-2">รายการสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>  
        <div class="text-end">
            <a href="{{ url('market/product_add') }}" class="btn btn-light btn-sm text-dark me-2">เพิ่มสินค้า </a>
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
                        เพิ่มสินค้า
                    </div>
                    <div class="card-body shadow-lg">
                        <form class="custom-validation" action="{{ route('mar.product_save') }}" method="POST"
                            id="save_productForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value="{{ Auth::user()->store_id }}">

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <img src="{{ asset('assets/images/default-image.jpg') }}" id="add_upload_preview"
                                            alt="Image" class="img-thumbnail" width="450px" height="350px">
                                        <br>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="img">Upload</label>
                                            <input type="file" class="form-control" id="img" name="img"
                                                onchange="addpic(this)">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-2 text-end">
                                            <label for="product_code">รหัสสินค้า :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="product_code" type="text" class="form-control" name="product_code">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="product_name">รายการสินค้า :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="product_name" type="text" class="form-control"
                                                    name="product_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="product_qty">จำนวน :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="product_qty" type="number" class="form-control" name="product_qty">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="product_price">ราคา :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="product_price" type="text" class="form-control"
                                                    name="product_price">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3"> 
                                        
                                        <div class="col-md-2 text-end">
                                            <label for="product_categoryid">หมวดสินค้า :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_categoryid" name="product_categoryid"
                                                    class="form-select form-select-lg show_cat" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($market_product_category as $procat)
                                                        <option value="{{ $procat->category_id }}">
                                                            {{ $procat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>     
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="form-outline bga">
                                                    <input type="text" id="CAT_INSERT" name="CAT_INSERT" class="form-control shadow"/>
                                                    <label class="form-label" for="CAT_INSERT" style="color: rgb(255, 72, 0)">เพิ่มหมวดสินค้า</label>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-md-1"> 
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addcategory();">
                                                    เพิ่ม
                                                </button> 
                                            </div>
                                        </div> 
                                        <div class="col-md-1">   </div> 

                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="product_unit_bigid">หน่วยบรรจุ :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_unit_bigid" name="product_unit_bigid"
                                                        class="form-select form-select-lg show_unit" style="width: 100%">
                                                        <option value="">--เลือก--</option>
                                                        @foreach ($product_unit as $prounit)
                                                            <option value="{{ $prounit->unit_id }}">
                                                                {{ $prounit->unit_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="form-outline bga">
                                                    <input type="text" id="UNIT_INSERT" name="UNIT_INSERT" class="form-control shadow"/>
                                                    <label class="form-label" for="UNIT_INSERT" style="color: rgb(255, 72, 0)">เพิ่มหน่วยนับ</label>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-md-1"> 
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addunit();">
                                                    เพิ่ม
                                                </button> 
                                            </div>
                                        </div> 
                                        <div class="col-md-1">   </div> 

                                    </div>

                                  

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="product_unit_subid">หน่วยย่อย :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select id="product_unit_subid" name="product_unit_subid"
                                                    class="form-select form-select-lg show_unitsub" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($product_unit as $uni)
                                                        <option value="{{ $uni->unit_id }}">
                                                            {{ $uni->unit_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                      <div class="col-md-2 text-end">
                                            <label for="" style="color: rgb(255, 145, 0)">* ถ้าไม่มีให้เพิ่ม </label>
                                        </div> 
                                        <div class="col-md-3"> 
                                            <div class="form-outline bga">
                                                <input type="text" id="UNIT_SUBINSERT" name="UNIT_SUBINSERT" class="form-control shadow"/>
                                                <label class="form-label" for="UNIT_SUBINSERT" style="color: rgb(255, 72, 0)">เพิ่มหน่วยนับ</label>
                                            </div> 
                                        </div>
                                        <div class="col-md-1"> 
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="addunitsub();">
                                                    เพิ่ม
                                                </button> 
                                            </div>
                                        </div> 


                                    </div>                                   


                                </div>
                                       
                                    <div class="card-footer mt-3">
                                        <div class="col-md-12 mt-3 text-end">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                                    บันทึกข้อมูล
                                                </button>
                                                <a href="{{ url('market/product_index') }}"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-xmark me-2"></i>
                                                    ยกเลิก
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


       
   

    @endsection
