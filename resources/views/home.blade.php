@extends('layouts.market')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">{{ __('Menu') }}</div> --}}

                <div class="card-body">
                  <div class="row mb-3 justify-content-center">
                    <div class="col-6 col-md-4 col-xl-2 mt-3">  
                      <div class="card">
                        <div class="card-body shadow-lg">          
                      <a href="{{url("staff/home")}}" class="nav-link text-dark text-center">
                        <i class="fa-solid fa-3x fa-chart-line text-warning"></i>
                        <br>
                         <label for="" class="mt-2">รายงาน</label>
                      </a>
                    </div>
                  </div>
                </div>
                    <div class="col-6 col-md-4 col-xl-2 mt-3">   
                      <div class="card">
                        <div class="card-body shadow-lg">         
                      <a href="{{url("customer/customer")}}" class="nav-link text-dark text-center">
                        <i class="fa-solid fa-3x fa-user-tie text-primary "></i><br>
                         <label for="" class="mt-2">สมาชิก</label>
                      </a>
                    </div>
                  </div>
                </div>
                    <div class="col-6 col-md-4 col-xl-2 mt-3"> 
                      <div class="card">
                        <div class="card-body shadow-lg">           
                      <a href="{{url("market/sale_index")}}" class="nav-link text-dark text-center"> 
                        <i class="fa-brands fa-3x fa-btc text-danger"></i>
                        <br>
                         <label for="" class="mt-2">ขายสินค้า</label>
                      </a>
                    </div>
                  </div>
                </div>
                    <div class="col-6 col-md-4 col-xl-2 mt-3">    
                      <div class="card">
                        <div class="card-body shadow-lg">        
                      <a href="{{url("car/car_narmal_index")}}" class="nav-link text-dark text-center">  
                        <i class="fa-solid fa-3x fa-truck-fast text-info"></i>
                        <br>
                         <label for="" class="mt-2">ซื้อวัสดุ</label>
                      </a>
                    </div>
                  </div>
                </div>
                    <div class="col-6 col-md-4 col-xl-2 mt-3">  
                      <div class="card">
                        <div class="card-body shadow-lg">         
                        <a href="{{url("market/rep_product")}}" class="nav-link text-dark text-center"> 
                          <i class="fa-solid fa-3x fa-boxes-packing text-success"></i>            
                          <br>
                          <label for="" class="mt-2">รับสินค้า</label>
                        </a>
                    </div>
                  </div>
            
                </div>
                    <div class="col-6 col-md-4 col-xl-2 mt-3">  
                      <div class="card">
                        <div class="card-body shadow-lg">          
                        <a href="{{url("market/product_index")}}" class="nav-link text-dark text-center"> 
                          <i class="fa-solid fa-3x fa-store text-secondary"></i>
                          <br>
                           <label for="" class="mt-2">คลังสินค้า</label>
                        </a>
                    </div>
                  </div>
                     
              </div>
            </div>
                      <!-- <div class="row">
                          @foreach ( $product_data as $items )
                              <div class="col-md-3 mt-3">
                                    <div class="bg-image hover-overlay ripple">
                                          <a href="{{url('user_meetting/meetting_choose/'.$items->product_id)}}">
                                                <img src="{{asset('storage/products/'.$items->img)}}" height="450px" width="350px" alt="Image" class="img-thumbnail"> 
                                                <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                                          </a>                                
                                    </div>
                              </div>
                          @endforeach                   
                        </div>   -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
