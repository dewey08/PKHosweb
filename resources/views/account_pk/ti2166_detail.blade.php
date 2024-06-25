@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')

    


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
               border-top: 10px #fd6812 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(360deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>
    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
         
        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body shadow-lg">
                      
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail IPD</h4>
                                <p class="card-title-desc">รายละเอียดลูกหนี้</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                {{-- <button type="button" class="btn btn-outline-info SendMoney" data-url="{{url('acc_debtor_send')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    ส่งการเงิน
                                </button> --}}
                            </div>
                        </div>

                        <p class="mb-0">
                            <div class="table-responsive"> 
                                    {{-- <table id="example" class="table table-hover table-sm dt-responsive nowrap"
                                    style=" border-spacing: 0; width: 100%;"> --}}
                                    <table class="table table-striped table-bordered dt-responsive"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr> 
                                            <th width="5%" class="text-center">ลำดับ</th>  
                                            <th class="text-center" width="5%">vn</th> 
                                            <th class="text-center">an</th>
                                            <th class="text-center" >hn</th>
                                            <th class="text-center" >cid</th>
                                            <th class="text-center">ptname</th>
                                            <th class="text-center">vstdate</th>  
                                            <th class="text-center">pttype</th> 
                                            <th class="text-center">spsch</th>  
                                            <th class="text-center">ลูกหนี้</th>  
                                            <th class="text-center">จ่ายชดเชยสุทธิ</th> 
                                            <th class="text-center">ส่วนต่ำ</th> 
                                            <th class="text-center">ส่วนสูง</th> 
                                            <th class="text-center">Rep no</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>  
                                          @foreach ($acc_debtor as $item2) 
                                                    <?php
                                                        // $sum_data = DB::table('acc_stm_ti')->where('hn','=',$item2->hn)->first();
                                                        $sum_data = DB::table('acc_stm_ti')
                                                        ->where('cid','=',$item2->cid) 
                                                        ->whereBetween('vstdate', [$item2->vstdate, $item2->vstdate])
                                                        ->sum('price_approve'); 

                                                        $repno_ = DB::table('acc_stm_ti')
                                                        ->where('cid','=',$item2->cid)->first();
                                                        $repno = $repno_->repno;

                                                        $low = $item2->uc_money - $sum_data;
                                                        $hig = $sum_data - $item2->uc_money;
                                                    ?>
                                                <tr style="font-size: 13px">                                                  
                                                    <td class="text-center" width="5%">{{ $i++ }}</td>   
                                                    <td class="text-center" width="5%">{{ $item2->vn }}</td> 
                                                    <td class="text-center" width="5%">{{ $item2->an }}</td> 
                                                    <td class="text-center" width="5%">{{ $item2->hn }}</td>  
                                                    <td class="text-center" width="5%">{{ $item2->cid }}</td>  
                                                    <td class="p-2" width="10%">{{ $item2->ptname }}</td> 
                                                    <td class="text-center" width="5%">{{ $item2->vstdate }}</td>   
                                                    <td class="text-center" style="color:rgb(73, 147, 231)" width="5%">{{ $item2->pttype }}</td>                                                 
                                                    <td class="text-center" style="color:rgb(216, 95, 14)" width="5%">{{ $item2->pttype_spsch }}</td>    
                                                    <td class="text-center">{{ number_format($item2->uc_money, 2) }}</td>  
                                                    <td class="text-center" width="8%">{{ number_format($sum_data, 2) }}</td>
                                                    @if ($sum_data > $item2->uc_money)
                                                        <td class="text-center" width="8%">{{ number_format($hig, 2) }}</td>
                                                    @else
                                                        <td class="text-center" width="8%">0.00</td>
                                                    @endif

                                                    @if ($sum_data < $item2->uc_money)
                                                        <td class="text-center" width="8%" style="background-color: pink">{{ number_format($low, 2) }}</td>
                                                    @else
                                                        <td class="text-center" width="8%">0.00</td>
                                                    @endif
                                                                                                      
                                                    {{-- <td class="text-center" width="8%">{{ number_format(($item2->uc_money - $sum_data), 2) }}</td> --}}
                                                    <td class="text-center" width="10%">{{ $repno}}</td> 
                                                </tr>
                                            @endforeach
                                     
                                    </tbody>
                                </table>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>account_pk </h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                           
 
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
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
            $('#stamp').on('click', function(e) {
                if($(this).is(':checked',true))  
                {
                    $(".sub_chk").prop('checked', true);  
                } else {  
                    $(".sub_chk").prop('checked',false);  
                }  
            }); 
            // $.ajaxSetup({
            //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            // });
            
            $('.SendMoney').on('click', function(e) {
                // alert('oo');
                var allValls = [];
                $(".sub_chk:checked").each(function () {
                    allValls.push($(this).attr('data-id'));
                });
                if (allValls.length <= 0) {
                    // alert("SSSS");
                    Swal.fire({
                        title: 'คุณยังไม่ได้เลือกรายการ ?',
                        text: "กรุณาเลือกรายการก่อน",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33', 
                        }).then((result) => {
                        
                        })
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการส่งการเงินรายการนี้ใช่ไหม!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Send Money it.!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var check = true;
                                if (check == true) {
                                    var join_selected_values = allValls.join(",");
                                    // alert(join_selected_values);
                                    $.ajax({
                                        url:$(this).data('url'),
                                        type: 'POST',
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        data: 'ids='+join_selected_values,
                                        success:function(data){ 
                                                if (data.status == 200) {
                                                    $(".sub_chk:checked").each(function () {
                                                        $(this).parents("tr").remove();
                                                    });
                                                    Swal.fire({
                                                        title: 'ส่งการเงินสำเร็จ',
                                                        text: "You Send Money data success",
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
                                                            // window.location="{{url('warehouse/warehouse_index')}}";
                                                        }
                                                    })
                                                } else {
                                                    
                                                }
                                                

                                            // } else {
                                            //     alert("Whoops Something went worng all"); 
                                            // }
                                        }
                                    });
                                    $.each(allValls,function (index,value) {
                                        $('table tr').filter("[data-row-id='"+value+"']").remove();
                                    });
                                }
                            }
                        }) 
                    // var check = confirm("Are you want ?");  
                }
            });
             

            $("#spinner-div").hide(); //Request is complete so hide spinner

            
           
        });
    </script>
    @endsection
