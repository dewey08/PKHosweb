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
    $refnumber = UsersuppliesController::refnumber();
    ?>
    <div class="container-fluid">
        <div class="px-0 py-0 border-bottom mb-2">
            <div class="d-flex flex-wrap justify-content-center">
                <a class="col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-white "></a>

                <div class="text-end">
                    {{-- <a href="{{ url('user/gleave_data_dashboard') }}" class="btn btn-light text-dark me-2">dashboard</a> --}}
                    <a href="{{ url('user/supplies_data') }}" class="btn btn-primary btn-sm text-white me-2 mb-2">ขอจัดซื้อ-จัดจ้าง</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <a href="" class="btn btn-light"> {{ __('รายการวัสดุ') }}</a>
                            </div>
                            <div class="col text-end"> 
                                 {{ __('เลขที่บิล') }} ==> {{$products_request->request_code}}&nbsp;&nbsp;&nbsp;
                                 {{ __('วันที่') }} ==> {{DateThai($products_request->request_date)}}&nbsp;&nbsp;&nbsp;
                                 {{-- {{ __('ผู้ร้องขอ') }} ==>  {{$products_request->request_user_name}}&nbsp;&nbsp;&nbsp;&nbsp; --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{-- <form class="custom-validation" action="{{ route('user.supplies_data_save') }}" method="POST"
                            id="insert_usersuppliesForm" enctype="multipart/form-data">
                            @csrf --}}
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <input type="hidden" name="user_id" id="user_id" value=" {{ Auth::user()->id }}">

                  
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card me-1">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="table_id">
                                            <thead>
                                                <tr height="10px">
                                                    {{-- <th width="7%">ลำดับ</th> --}}
                                                    <th>รหัส</th>
                                                    <th>รายการวัสดุ</th>  
                                                    <th>qty</th> 
                                                    <th>ราคา</th>  
                                                    {{-- <th>หน่วยบรรจุ</th> --}}
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
                                                            {{-- <td class="text-center" width="3%">{{$i++}}</td>   --}}
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
                                                                    <input type="hidden" name="product_id" id="product_id" value=" {{ $items->product_id }}">  
                                                                    <input type="hidden" name="request_id" id="request_id" value=" {{ $products_request->request_id }}"> 
                                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus text-white"></i> </button>
                                                            </td> 
                                                    </form>   
                                                                                         
                                                        </tr> 

                                                @endforeach                                                              
                                            </tbody>
                                            </table>
                                        
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-center">                              
                                                    {{$product_data->links()}}                            
                                                </ul>
                                            </nav>
                    
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
                                                    <?php $i = 1; $total = 0; ?>      
                                                    @foreach ( $products_request_sub as $items ) 
                                                                <tr id="sid{{$items->request_sub_id}}">
                                                                    {{-- <td class="text-center">{{$i++}}</td>   --}}
                                                                    {{-- <td class="p-2"> 
                                                                        {{$items->request_sub_product_code}}
                                                                    </td> --}}
                                                                    <td class="p-2" width="39%">
                                                                        {{$items->request_sub_product_name}}
                                                                    </td>
                                                                    <form class="custom-validation" action="{{route('user.supplies_data_add_subupdate')}}" method="POST">
                                                                        @csrf
                                                                        <input id="request_sub_id" type="hidden" class="form-control" name="request_sub_id" value="{{$items->request_sub_id}}">

                                                                    <td class="text-center" width="15%">
                                                                        <input id="request_sub_qty" type="text" class="form-control form-control-sm text-center" name="request_sub_qty" value="{{$items->request_sub_qty}}">
                                                                    </td>
                                                                    <td class="text-center" width="21%">
                                                                        <input id="request_sub_price" type="text" class="form-control form-control-sm text-end" name="request_sub_price" value="{{$items->request_sub_price}}">
                                                                    </td>
                                                                    <td class="text-center" width="25%">
                                                                        <button type="submit" class="btn btn-light btn-sm text-warning"> 
                                                                            <i class="fa-solid fa-pen-to-square text-warning"></i>
                                                                        </button>
                                                                        <a href="javascript:void(0)" class="btn btn-light btn-sm text-danger" onclick="repsubsupplies_destroy({{ $items->request_sub_id}})">  
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </a>

                                                                            {{-- <div class="btn-group">
                                                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                เลือก 
                                                                                </button>
                                                                                <ul class="dropdown-menu">
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="#">
                                                                                            <button type="submit" class="btn btn-light btn-sm text-warning"> 
                                                                                                แก้ไข                                                                                              
                                                                                            </button>
                                                                                        
                                                                                        </a>
                                                                                    </li>
                                                                                    <li> 
                                                                                            <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                                                            onclick="repsubsupplies_destroy({{ $items->request_sub_id}})" >
                                                                                            
                                                                                          
                                                                                            <button type="button" class="btn btn-light btn-sm text-warning"> 
                                                                                                ลบ
                                                                                               
                                                                                            </button>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div> --}}

                                                                    
                                                                        
                                                                    </td>
                                                        </form>  
                                                        {{-- <td class="text-center">
                                                            {{$items->request_sub_unit_bigname}}
                                                        </td> --}}
                                                        {{-- <td class="text-center">
                                                            {{$items->request_sub_unitname}}
                                                        </td>   --}}
                                                    </tr>    
                                                    <?php   
                                                        $total =   $total + ($items->request_sub_qty * $items->request_sub_price);    
                                                    ?>
                                                    
                                                    @endforeach  
                                                    <tr>
                                                        <td colspan="2" align="right" class="p-2">ราคารวมทั้งหมด</td> 
                                                        <td align="right" class="text-danger p-2"><b>{{number_format(($total),2)}} </b></td> 
                                                        
                                                        <td class="p-2">บาท</td>
                                                        <td class="p-2"></td>
                                                    </tr>                                                             
                                                </tbody>
                                            </table>
                    
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination justify-content-center">                              
                                                    {{$products_request_sub->links()}}                            
                                                </ul>
                                            </nav>
                    
                                        </div> 
                                    </div>
                                </div>
                               
                            </div>

                        </div>            
                    <div class="card-footer "> 
                        <div class="text-end"> 
                        <a href="{{ url('user/supplies_data_add/'.Auth::user()->id) }}" class="btn btn-primary btn-sm me-2"> <i class="fa-solid fa-arrow-left me-3"></i>{{ __('back') }}</a>
                        <a type="submit" href="{{ url('user/supplies_data_add/'.Auth::user()->id) }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-arrow-right me-3"></i>{{ __('completed') }}
                        </a>
                    </div>
                </div>
                  {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('js/user_products_request.js') }}"></script>   

@endsection
