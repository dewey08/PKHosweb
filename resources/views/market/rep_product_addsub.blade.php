@extends('layouts.market')
@section('title', 'ZOFFice || ทำรายการรับสินค้า')
@section('menu')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
    function rep_product_addsub_destroy(request_sub_id)
    {
      Swal.fire({
      title: 'ต้องการลบใช่ไหม?',
      text: "ข้อมูลนี้จะถูกลบไปเลย !!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
      cancelButtonText: 'ไม่, ยกเลิก'
      }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({ 
          url:"{{url('market/rep_product_addsub_destroy')}}" +'/'+ request_sub_id, 
          type:'DELETE',
          data:{
              _token : $("input[name=_token]").val()
          },
          success:function(response)
          {          
              Swal.fire({
                title: 'ลบข้อมูล!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  $("#sid"+request_sub_id).remove();     
                  window.location.reload(); 
                //   window.location = "{{url('market/rep_product')}}"; //     
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
            
            {{-- <a href="{{url("market/product_index")}}" class="btn btn-light btn-sm text-dark me-1">รายการสินค้า<span class="badge bg-danger ms-2">{{$count_marketproducts}}</span></a>    --}}
            <a href="{{url("market/rep_product")}}" class="col-4 col-lg-auto mb-lg-0 me-lg-auto btn btn-light btn-sm text-dark me-2">รับสินค้า<span class="badge bg-danger ms-2">{{$count_market_repproducts}}</span></a>  
        <div class="text-end">
            <a href=" " class="btn btn-secondary btn-sm text-white me-2">เพิ่มรายการสินค้า </a>
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
                                {{-- <input type="text" name="request_id" id="request_id" value=" {{ $refmaxid }}">  --}}
                                <input type="hidden" name="request_id" id="request_id" value=" {{ $dataedits-> request_id}}">
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
                               <!-- <div class="col-md-1 text-end">
                                    <label for="request_sub_unitid">หน่วยนับ :</label>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">                                        
                                        <select id="request_sub_unitid" name="request_sub_unitid" class="form-select-lg"
                                        style="width: 100%">
                                        @foreach ($product_unit as $item)
                                            <option value="{{ $item->unit_id }}"> {{ $item->unit_name }}
                                            </option>
                                        @endforeach
                                    </select>                                 
                                    </div>
                                </div> -->
                                
                            </div>
                            <div class="row mt-3">
                                {{-- <div class="col-md-1 text-end">
                                    <label for="request_sub_lot">Lot :</label>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input name="request_sub_lot" id="request_sub_lot" class="form-control" value="{{$lot}}">                                      
                                    </div>
                                </div> --}}
                                <div class="col-md-5">
                                </div> 
                                <div class="col-md-1 text-end">
                                    <label for="request_sub_lot">Lot :</label>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input name="request_sub_lot" id="request_sub_lot" class="form-control" value="{{$lot}}">                                      
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <label for="request_sub_date_exp">EXP :</label>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input name="request_sub_date_exp" id="request_sub_date_exp" class="form-control" type="date">                                      
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
                                                                        <a class="text-danger" href="javascript:void(0)" onclick="rep_product_addsub_destroy({{ $itemsub->request_sub_id }})">
                                                                          <i class="fa-solid fa-trash-can"></i> 
                                                                        </a> 
                                                                  
                                                                   
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
                                <a href="{{url('market/rep_product')}}" class="btn btn-danger btn-sm" > <i class="fa-solid fa-xmark me-2"></i>ปิด</a>
                                {{-- <button type="button" id="#saveBtn" class="btn btn-primary btn-sm" data-mdb-toggle="collapse"
                                href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa-solid fa-circle-right me-2"></i>ต่อไป</button> --}}
                                {{-- <a type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-right me-2"></i>เสร็จ</a> --}}
                            </div>
                      

                         <!-- Collapsed content -->
                       <!-- <div class="collapse mt-3 mb-5" id="collapseExample">
                            <div class="row text-center">
                                <div class="col-md-4 text-end">
                                    <label for="meeting_time_begin">ผู้ร่วมเดินทาง :</label>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="meetting_year" id="meetting_year" class="form-control"
                                        style="width: 100%;">
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="closebtn" class="btn btn-primary btn-sm" >เพิ่มผู้ร่วมเดินทาง</button>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                    
                            <div class="row mt-3">
                                    <div class="col-md-1"> </div>
                                    <div class="col-md-10"> 
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"> 
                                                <thead>
                                                        <tr>
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>11</td>
                                                            <td>22</td>
                                                            <td>33</td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-1"> </div>
                            </div>
                        </div>
                          -->  
                    </div>
                </div>
            </div>
        </div>


       
   

    @endsection
