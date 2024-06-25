@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')

     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>


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
    <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{	
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
               }
               .cv-spinner {
               height: 100%;
               display: flex;
               justify-content: center;
               align-items: center;  
               }
               .spinner {
               width: 250px;
               height: 250px;
               border: 10px #ddd solid;
               border-top: 10px #1fdab1 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(390deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
     
    <div class="container-fluid">
          <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                
            </div>
        </div>
    </div>
        <form action="{{ route('acc.acc_stm') }}" method="POST">
            @csrf
            <div class="row"> 
                <div class="col"></div>
                <div class="col-md-1 text-end">ชื่อไฟล์</div>
                <div class="col-md-3 text-center">
                    <div class="input-group">
                        {{-- <input type="text" class="form-control" name="filename" id="filename">  
                        <span class="input-group-text">
                            <i class="fa-solid fa-file-excel"></i> 
                        </span> --}}
                        <select name="filename" id="filename" class="form-select form-select-lg" style="width: 100%">
                            <option value=""></option>
                            @foreach ($filen_ as $item_)
                                @if ($filen_ == $item_->pang_stamp_stm_file_name)
                                    <option value="{{$item_->pang_stamp_stm_file_name}}" selected>{{$item_->pang_stamp_stm_file_name}}</option>
                                @else
                                    <option value="{{$item_->pang_stamp_stm_file_name}}">{{$item_->pang_stamp_stm_file_name}}</option>
                                @endif                               
                            @endforeach
                        </select>
                    </div>
                </div>
                                      
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-magnifying-glass me-2"></i> 
                        ค้นหา 
                    </button>   
                     
                </div>
                <div class="col"></div>
            </div> 
        </form>
        <div class="row mt-3 text-center">  
            <div id="overlay">
                <div class="cv-spinner">
                  <span class="spinner"></span>
                </div>
              </div>
        </div> 
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                      
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail STM</h4>
                                <p class="card-title-desc">รายละเอียด STM </p>
                                {{-- <p class="card-title-desc">รายละเอียด STM ==> File {{$file_n}}</p> --}}
                            </div>
                            <div class="col"></div>
                            {{-- <div class="col-md-2 text-end">
                                <button type="button" class="btn btn-warning Savestamp" data-url="{{url('account_pk_debtor')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ตั้งลูกหนี้
                                </button>
                            </div> --}}
                        </div>

                        <p class="mb-0">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                {{-- <table id="example" class="table table-striped table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                {{-- <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                
                                    {{-- <table id="example" class="table table-hover table-sm table-light dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                    <thead>
                                        <tr>
                                          
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center" width="15%">ชื่อ-สกุล</th> 
                                            <th class="text-center">vn</th>
                                            <th class="text-center" >hn</th>
                                            <th class="text-center" >an</th>
                                            <th class="text-center">วันที่</th> 
                                            <th class="text-center">stamp_uc_money</th>
                                            <th class="text-center" width="8%">ชดเชย</th>  
                                            <th class="text-center">ส่วนต่าง</th>
                                            <th class="text-center">ส่วนสูง</th>  
                                            {{-- <th class="text-center">stm</th> --}}
                                            <th class="text-center">เลขที่หนังสือ</th>
                                            <th class="text-center">ใบเสร็จรับเงิน</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($acc_stm as $item) 
                                        <?php 
                                                    $uc = $item->pang_stamp_uc_money;
                                                    $st = $item->stm;
                                                    if ($st >=  $uc) {
                                                        $saun =  - ($st - $uc);
                                                    } else {
                                                        $saun =  '';
                                                    }
                                                    // $sauntang = $sauntang_;
                                                ?>
                                            <tr >                                                  
                                                <td class="text-center" width="5%">{{ $i++ }}</td> 
                                                <td class="p-2" >{{ $item->pt_name }}</td>   
                                                <td class="text-center" width="5%">{{ $item->vn }}</td> 
                                                <td class="text-center" width="5%">{{ $item->hn }}</td> 
                                                <td class="text-center" width="5%">{{ $item->an }}</td>  
                                                <td class="text-center" width="8%">{{ $item->pang_stamp_vstdate }}</td>   
                                                {{-- <td class="text-center" width="5%">{{ $item->pang_stamp_uc_money }}</td>  
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item->stm}}</td>  --}} 
                                                {{-- <td class="p-2" style="color:rgb(236, 43, 227)" width="10%">{{ ($item->stm)-($item->pang_stamp_uc_money)}} </td>  --}}
                                                <td class="text-center" width="7%">{{ number_format($item->pang_stamp_uc_money, 2)}}</td>  
                                                <td class="text-center" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->stm, 2)}}</td> 
                                                <td class="p-2" style="color:rgb(236, 43, 227)" width="7%">{{$saun}} </td>  
                                                @if ($item->pang_stamp_uc_money_minut_stm_money < 0)
                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="7%">0.00</td> 
                                                @else
                                                <td class="text-center" style="color:rgb(216, 95, 14)" width="7%">{{ $item->pang_stamp_uc_money_minut_stm_money }}</td> 
                                                @endif
                                               
                                                {{-- <td class="p-2">{{ $item->pang_stamp_stm_file_name }}</td>   --}}
                                                <td class="text-center">{{ $item->pang_stamp_send }}</td> 
                                                <td class="text-center">{{ $item->pang_stamp_rcpt }}</td>   
                                            </tr>
                                        @endforeach
                                    </tbody>
                                            <tr style="background-color: #f3fca1">
                                                <td colspan="6" class="text-end" style="background-color: #fca1a1"></td>
                                                <td class="text-center" style="background-color: #f3fca1">{{ number_format($sum_uc_money, 2)}}</td>
                                                <td class="text-center" style="background-color: #b5eb82">{{ number_format($sum_stmuc_money, 2)}}</td>
                                                <td class="text-center" style="background-color: #fca1a1"></td>
                                                <td class="text-center" style="background-color: #f3fca1"> {{ number_format($sum_hiegt_money, 2)}}</td>
                                                <td colspan="2" class="text-end" style="background-color: #fca1a1"></td>
                                            </tr>  
                                </table>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
    </div>
  

    @endsection
    @section('footer')
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#filename').select2({
                placeholder:"--เลือก--",
                allowClear:true
            });
              
            $("#spinner-div").hide(); //Request is complete so hide spinner

            $('#Save_opd').click(function() {
                var datepicker = $('#datepicker').val(); 
                var datepicker2 = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You Check Sit Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                $.ajax({
                                    url: "{{ route('acc.account_pksave') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        datepicker,
                                        datepicker2                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Pull data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                            }
                })
            });
            
        });
    </script>
    @endsection
