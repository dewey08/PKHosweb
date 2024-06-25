@extends('layouts.backend_small')

    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">



@section('content')
<style>
.center {
  margin: auto;
  width: 100%;
  padding: 10px;
}
body {
      font-family: 'Kanit', sans-serif;
      font-size: 14px;
   
      }

      label{
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
       
      }

      @media only screen and (min-width: 1200px) {
label {
    float:right;
  }

      }

      .text-pedding{
   padding-left:10px;
   padding-right:10px;
                    }

        .text-font {
    font-size: 13px;
                  }
      

      .form-control {
    font-size: 13px;
                  }
                  table, td, th {
            border: 1px solid black;
            } 
</style>
<script>
    function checklogin(){
     window.location.href = '{{route("index")}}';
    }
    </script>
<?php
if(Auth::check()){
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;
    $idsmallhos = Auth::user()->SMALL_ID; 
}else{
    echo "<body onload=\"checklogin()\"></body>";
    exit();
}

$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos);



?>
<?php
  date_default_timezone_set("Asia/Bangkok");
$date = date('Y-m-d');
use App\Http\Controllers\SmallhosController;
?>
<!-- Advanced Tables -->
<div class="bg-body-light">
    <div class="block-header block-header-default">
        <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลสถานะคลังพัสดุ รพสต.</B></h3>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <div class="row">
                                     

                                            <div>
                                                <a href="{{ url('smallhos_warehouse/smallwithdrawindex/'.$idsmallhos)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">เบิกจากคลังรพ.</a>
                                               </div>
                                               <div>&nbsp;</div>
                                               
                                            <div>
                                            <a href="{{ url('smallhos_warehouse/smallstockcard/'.$idsmallhos)}}" class="btn btn-success loadscreen" >คลังรพสต.

                                                <span class="badge badge-light" ></span>

                                            </a>
                                            </div>
                                            <div>&nbsp;</div>


                                    
                                           

                                            <div>
                                             <a href="{{ url('smallhos_warehouse/smallpayindex/'.$idsmallhos)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">จ่ายวัสดุ</a>
                                            </div>
                                            <div>&nbsp;</div>




                                            </ol>

                </nav>
        </div>
    </div>

    <div class="content">
    <!-- Dynamic Table Simple -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>คลังย่อย</B></h3>

        </div>
        <div class="block-content block-content-full">
      
  
        <div class="table-responsive"> 
            
                <table class="gwt-table table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                    <thead style="background-color: #F08080;">
                        <tr height="40">
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >รหัสวัสดุ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >รายการ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">ประเภทวัสดุ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">หน่วย</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >รับเข้า</th> 
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">จ่ายออก</th> 
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >คงเหลือ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">มูลค่าคงคลัง</th>  
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">เรียกดู</th> 
                            
                        </tr >
                    </thead>
                    <tbody>
                        <?php $number=1; ?>
                        @foreach ($infowarehousetreasurys as $infowarehousetreasury)

                        <?php
                                    $num1 = SmallhosController::sumtreasuryreceivesmall($infowarehousetreasury->TREASURY_SMALL_ID);
                                    $num2 = SmallhosController::sumtreasuryexportsmall($infowarehousetreasury->TREASURY_SMALL_ID);  
                                     $resultnum = $num1-  $num2;
                        ?> 
                       
                        <tr height="20">
                        <td class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">{{$number}}</td>

                        <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;">{{$infowarehousetreasury->TREASURY_SMALL_CODE}}</td>
                        <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;">{{$infowarehousetreasury->TREASURY_SMALL_NAME}}</td>
                        <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;">{{$infowarehousetreasury->SUP_TYPE_NAME}}</td>
                        <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;">{{$infowarehousetreasury->SUP_UNIT_NAME}}</td>

                        <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;">{{number_format(SmallhosController::sumtreasuryreceivesmall($infowarehousetreasury->TREASURY_SMALL_ID))}}</td>
                        <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;">{{number_format(SmallhosController::sumtreasuryexportsmall($infowarehousetreasury->TREASURY_SMALL_ID))}}</td>
                        <td class="text-font text-pedding" style="text-align: center;center;border: 1px solid black;">{{number_format($resultnum)}}</td>
                        <td class="text-font text-pedding" style="text-align: right;border: 1px solid black;">{{number_format(SmallhosController::sumvaluetreasurysmall($infowarehousetreasury->TREASURY_SMALL_ID),5)}}</td>
                     
                        
                        <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;">
                                        ทำรายการ
                                    </button>
                                <div class="dropdown-menu" style="width:10px">
                                    <a class="dropdown-item" href="{{ url('smallhos_warehouse/smallinfostockcard_sub/'.$infowarehousetreasury->TREASURY_SMALL_ID.'/'.$idsmallhos)}}" style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">เรียกดู</a>
                                </div>
                                </div>
                            </td> 
                        
                        </tr>
                        <?php $number++; ?>
                        @endforeach  


                  


                      
                  

                    </tbody>
                </table>
                <br>
               

         </div>

@endsection

@section('footer')

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>



 <!-- Page JS Plugins -->
<script src="{{ asset('asset/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('asset/js/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Page JS Code -->
<script src="{{ asset('asset/js/pages/be_comp_charts.min.js') }}"></script>
<script>jQuery(function(){ Dashmix.helpers(['easy-pie-chart', 'sparkline']); });</script>


 <!-- Page JS Plugins -->
 <script src="{{ asset('asset/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
<!-- Page JS Code -->
 <script src="{{ asset('asset/js/pages/be_tables_datatables.min.js') }}"></script>


 <script>

    function detail(id){
    
    
    $.ajax({
               url:"{{route('warehouse.detailappall')}}",
              method:"GET",
               data:{id:id},
               success:function(result){
                   $('#detail').html(result);
    
    
                  //alert("Hello! I am an alert box!!");
               }
    
       })
    
    }
    
    
       $(document).ready(function () {
                
                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    todayBtn: true,
                    language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                    thaiyear: true,
                    autoclose: true                         //Set เป็นปี พ.ศ.
                }).datepicker();  //กำหนดเป็นวันปัจุบัน
        });
    
        $('.budget').change(function(){
                 if($(this).val()!=''){
                 var select=$(this).val();
                 var _token=$('input[name="_token"]').val();
                 $.ajax({
                         url:"{{route('admin.selectbudget')}}",
                         method:"GET",
                         data:{select:select,_token:_token},
                         success:function(result){
                            $('.date_budget').html(result);
                            datepick();
                         }
                 })
                // console.log(select);
                 }        
         });
     
    </script>



@endsection
