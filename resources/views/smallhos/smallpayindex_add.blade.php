@extends('layouts.backend_small')
   
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />
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
  
?>
<!-- Advanced Tables -->
<div class="bg-body-light">
    <div class="content">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
             <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;"></h1> 
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">                                           
                <div class="row">

                                            <div>
                                                <a href="{{ url('smallhos_warehouse/smallwithdrawindex/'.$idsmallhos)}}" class="btn " style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">เบิกจากคลังรพ.</a>
                                               </div>
                                               <div>&nbsp;</div>
                                               
                                            <div>
                                            <a href="{{ url('smallhos_warehouse/smallstockcard/'.$idsmallhos)}}" class="btn " style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">คลังรพสต.

                                                <span class="badge badge-light" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;"></span>

                                            </a>
                                            </div>
                                            <div>&nbsp;</div>


                                    
                                          

                                            <div>
                                             <a href="{{ url('smallhos_warehouse/smallpayindex/'.$idsmallhos)}}" class="btn  btn-info" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">จ่ายวัสดุ</a>
                                            </div>
                                            <div>&nbsp;</div>



                                            </ol>
                   
                </nav>
        </div>
    </div>
    </div>
    <div class="content">
    <!-- Dynamic Table Simple -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>จ่ายวัสดุ | รพสต.</B></h3>
            <br>
           
        </div>
        <br>
<form  method="post" action="{{ route('smallhos.saveinfopaysmall') }}" enctype="multipart/form-data">
@csrf

    
        <div class="col-sm-12" style="text-align: left">
        <div class="row">
     
        <div class="col-lg-1" style="text-align: left">
        <label >                           
                            วันที่ :              
        </label>
        </div> 
        <div class="col-lg-2">
        <input name="TREASURT_PAY_SMALL_DATE" id="TREASURT_PAY_SMALL_DATE" class="form-control input-sm datepicker" style=" font-family: 'Kanit', sans-serif;" value="{{formate($date)}}" readonly>
        </div> 
        <div class="col-lg-1" style="text-align: left">
        <label >                           
                            เหตุผล:              
        </label>
        </div> 
        <div class="col-lg-4" >
        <input name="TREASURT_PAY_SMALL_COMMENT" id="TREASURT_PAY_SMALL_COMMENT" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;" >
        </div> 
      

        <div class="col-lg-1" style="text-align: left">
            <label >                           
                                วัตถุประสงค์:              
            </label>
            </div> 
            <div class="col-lg-2" >
            
                <select name="TREASURT_PAY_SMALL_REQUEST_OBJ" id="TREASURT_PAY_SMALL_REQUEST_OBJ" class="form-control input-sm " style=" font-family: 'Kanit', sans-serif;" >
                    <option value="" >--เลือกวัตถุประสงค์--</option>  
            
                                @foreach ($infoobjs as $infoobj)  
                                                                        
                                    <option value="{{ $infoobj->OBJECTIVEPAY_ID }}" >{{ $infoobj->OBJECTIVEPAY_NAME }}</option> 
                                                                                                                                                
                                @endforeach  
                                                      
                    </select> 



            </div> 
            </div>

       
       <br>
      
        <div class="row">
     
        <div class="col-lg-1" style="text-align: left">
        <label>คลัง :</label>
        </div> 
        <div class="col-lg-4">

        {{$infohos->WAREHOUSE_SMALLHOS_NAME}}
        <input type="hidden" name="TREASURT_PAY_SMALL_NAME" id="TREASURT_PAY_SMALL_NAME" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;" value="{{$infohos->WAREHOUSE_SMALLHOS_NAME}}">
        <input type="hidden" name="TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID" id="TREASURT_PAY_SMALL_REQUEST_SUB_SUB_ID" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;" value="{{$idsmall}}">
    </div>
       
       </div>
    </div>
       <br>

       <table class="table-striped table-vcenter " style="width: 100%;border: 1px solid black;">
                    <thead style="background-color: #FFEBCD;">
                                     
                                            <tr>
                                            <td style="text-align: center; font-size: 13px;  border: 1px solid black;">ลำดับ</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" width="20%">รายการรับเข้า</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" >LOT</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" >ล็อตผลิต</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" >คงเหลือ</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" width="5%">หน่วย</td>
                                                
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" width="8%">จำนวนจ่าย</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" >ราคาต่อหน่วย</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" width="10%" >มูลค่า</td>
                                                
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" >วันที่ผลิต</td>
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" >วันที่หมดอายุ</td>
                                               
                                               
                                              
                                                <td style="text-align: center; font-size: 13px;  border: 1px solid black;" width="5%"><a  class="btn btn-success addRow2" style="color:#FFFFFF;"><i class="fa fa-plus"></i></a></td>
                                            </tr>
                                        </thead> 
                                     
                                             <tbody class="tbody2"> 
                                        
                                                   
                                            </tbody>   
                                      
                                         
                                      
                                        </table>
                                      
                          
         



        <div class="modal-footer">
        <div align="right">
        <button type="submit" name = "SUBMIT"  class="btn btn-info btn-lg" value="approved" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">บันทึก</button>
        <a href="{{ url('smallhos_warehouse/smallpayindex/'.$idsmall)  }}" class="btn btn-danger btn-lg" onclick="return confirm('ต้องการที่จะยกเลิกการจ่ายวัสดุ ?')" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">ยกเลิก</a>
        </div>

       
        </div>
        </form>  


       
       
    
<!--    เมนูเลือก   -->
       
<div class="modal fade addsup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modeladdsup">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">          
                            <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;">เลือกพัสดุที่ต้องการจ่าย</h2>
                        </div>
                    <div class="modal-body">
                <body>
                    <div class="container mt-3">
                        <input class="form-control" id="myInput" type="text" placeholder="Search..">
                <br>
                        <div style='overflow:scroll; height:300px;'>
                
                        <div id="detailsup"></div>

                    </div>
                </div>
                </div>
                    <div class="modal-footer">
                        <div align="right">
                                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">ปิดหน้าต่าง</button>
                        </div>
                    </div>
                </body>
            </div>
          </div>
        </div>

@endsection

@section('footer')
<script src="{{ asset('select2/select2.min.js') }}"></script>
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
        $(document).ready(function(){
          $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
        </script>

<script>

$(document).ready(function() {
    $('select').select2({
        width: '100%'
});
});

function datepicker(number){
        
        $('.datepicker'+number).datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true                         //Set เป็นปี พ.ศ.
            }).datepicker("setDate", 0);  //กำหนดเป็นวันปัจุบัน
   }


    $('.addRow').on('click',function(){
        addRow();
        var count = $('.tbody1').children('tr').length;
        var number =  (count).valueOf();
        datepicker(number);
    });

   


    function addRow(){
    var count = $('.tbody1').children('tr').length;
    
    var number =  (count).valueOf();

    
        var tr =   '<tr style="text-align: center; font-size: 13px;border: 1px solid black;">'+
                '<td style="text-align: center;">'+
                +number+
                '</td>'+
                '<td style="text-align: left;" class="infosupselect'+count+' text-pedding">'+            
                '</td>'+
                '<td>'+
                '<button type="button" class="btn btn-info" data-toggle="modal" data-target=".addsup" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="detailsup({{$idsmall}},'+count+');" >LOT</button>'+
                '</td>'+
                '<td class="infosupselectlot'+count+'">'+
                '</td>'+
                '<td class="infosupselecttotal'+count+'">'+  
                '</td>'+                  
                '<td class="infosupselectunit'+count+'">'+
                '</td>'+
                '<td >'+
                '<input style="text-align: center; " name="TREASURY_EXPORT_SMALL_AMOUNT[]" id="TREASURY_EXPORT_SMALL_AMOUNT'+count+'" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;"  onkeyup="checksummoney('+count+'),checktotal('+count+')"   required>'+
                '</td>'+
                '<td class="infosupselectpiceunit'+count+'">'+
                '</td>'+
                '<td style="text-align: center; font-size: 13px;">'+
                '<div class="summoney'+count+'"></div>'+ 
                '</td>'+
                '<td class="infosupselectdatget'+count+'">'+
                '</td>'+
                '<td class="infosupselectdatexp'+count+'">'+
                '</td>'+
                '<td style="text-align: center;"><a class="btn btn-danger remove" style="color:#FFFFFF;"><i class=" fa fa-trash-alt"></i></a></td>'+
                '</tr>';
                                  
    $('.tbody1').append(tr);
    };

    $('.tbody1').on('click','.remove', function(){
        $(this).parent().parent().remove();
    });





    $('body').on('keydown', 'input, select, textarea', function(e) {
    var self = $(this)
      , form = self.parents('form:eq(0)')
      , focusable
      , next
      ;
    if (e.keyCode == 13) {
        focusable = form.find('input,a,select,button,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
        if (next.length) {
            next.focus();
        } else {
            form.submit();
        }
        return false;
    }
});




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

 //------------------------------------------function-----------------

 function detailsup(iddep,count){


$.ajax({
           url:"{{route('smallhos.detailsupsmall')}}",
          method:"GET",
           data:{iddep:iddep,count:count},
           success:function(result){
               $('#detailsup').html(result);
           }

   })
   

}






function selectsup(idsup,count){

var _token=$('input[name="_token"]').val();



            $.ajax({
               url:"{{route('smallhos.selectsup')}}",
               method:"GET",
               data:{idsup:idsup,_token:_token},
               success:function(result){
                $('.infosupselect'+count).html(result);
               }
             })



       $.ajax({
                   url:"{{route('smallhos.selectsuplot')}}",
                   method:"GET",
                   data:{idsup:idsup,_token:_token},
                   success:function(result){
                    $('.infosupselectlot'+count).html(result);
                   }
           })

           $.ajax({
                   url:"{{route('smallhos.selectsuptotal')}}",
                   method:"GET",
                   data:{idsup:idsup,count:count,_token:_token},
                   success:function(result){
                    $('.infosupselecttotal'+count).html(result);
                   }
           })

           $.ajax({
                   url:"{{route('smallhos.selectsupunit')}}",
                   method:"GET",
                   data:{idsup:idsup,_token:_token},
                   success:function(result){
                    $('.infosupselectunit'+count).html(result);
                   }
           })


           $.ajax({
                   url:"{{route('smallhos.selectsuppiceunit')}}",
                   method:"GET",
                   data:{idsup:idsup,count:count,_token:_token},
                   success:function(result){
                    $('.infosupselectpiceunit'+count).html(result);
                   }
           })

           $.ajax({
                   url:"{{route('smallhos.selectsupdatget')}}",
                   method:"GET",
                   data:{idsup:idsup,_token:_token},
                   success:function(result){
                    $('.infosupselectdatget'+count).html(result);
                   }
           })


           $.ajax({
                   url:"{{route('smallhos.selectsupdatexp')}}",
                   method:"GET",
                   data:{idsup:idsup,_token:_token},
                   success:function(result){
                    $('.infosupselectdatexp'+count).html(result);
                   }
           })

    
     
       $('#modeladdsup').modal('hide');

}



//-----------------------------------------------------



function checksummoney(number){
      
    
      var SUP_TOTAL=document.getElementById("RECEIVE_SMALL_AMOUNT"+number).value;
      var PRICE_PER_UNIT=document.getElementById("RECEIVE_SMALL_PICE_UNIT"+number).value;
      
      //alert(PERSON_ID);
      
      var _token=$('input[name="_token"]').val();
           $.ajax({
                   url:"{{route('msupplies.checksummoney')}}",
                   method:"GET",
                   data:{SUP_TOTAL:SUP_TOTAL,PRICE_PER_UNIT:PRICE_PER_UNIT,_token:_token},
                   success:function(result){
                      $('.summoney'+number).html(result);
                      findTotal();
                   }
           })
           
           
  }


  function checktotal(number){
      
 
      var SUP_TOTAL= Number(document.getElementById("RECEIVE_SMALL_AMOUNT"+number).value);

      var TREASURY_EXPORT_SUB_VALUE= Number(document.getElementById("TREASURY_EXPORT_SMALL_VALUE"+number).value);
      
    //   alert(TREASURY_EXPORT_SUB_VALUE);
      if(TREASURY_EXPORT_SUB_VALUE < SUP_TOTAL){
        alert("ของในคลังมีไม่เพียงพอในการจ่าย !!");
        document.getElementById('RECEIVE_SUB_AMOUNT'+number).value = TREASURY_EXPORT_SUB_VALUE;
      }
     

     
           
  }


  function findTotal(){
    var arr = document.getElementsByName('sum');
    var tot=0;

    count = $('.tbody1').children('tr').length;
    for(var i=0;i<count;i++){
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('total').value =tot.toFixed(5);
}
  




$('.addRow2').on('click',function(){
        addRow2();
        var count = $('.tbody2').children('tr').length;
        var number =  (count).valueOf();
        datepicker(number);
    });

   


    function addRow2(){
    var count = $('.tbody2').children('tr').length;
    
    var number =  (count+1).valueOf();

    
        var tr =   '<tr style="text-align: center; font-size: 13px;border: 1px solid black;">'+
                '<td style="text-align: center;">'+
                +number+
                '</td>'+
                '<td style="text-align: left;" class="infosupselect'+count+' text-pedding">'+            
                '</td>'+
                '<td>'+
                '<button type="button" class="btn btn-info" data-toggle="modal" data-target=".addsup" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="detailsup({{$idsmall}},'+count+');" >LOT</button>'+
                '</td>'+
                '<td class="infosupselectlot'+count+'">'+
                '</td>'+
                '<td class="infosupselecttotal'+count+'">'+  
                '</td>'+                  
                '<td class="infosupselectunit'+count+'">'+
                '</td>'+
                '<td >'+
                '<input style="text-align: center; " name="TREASURY_EXPORT_SMALL_AMOUNT[]" id="RECEIVE_SMALL_AMOUNT'+count+'" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;"  onkeyup="checksummoney('+count+'),checktotal('+count+')"   required>'+
                '</td>'+
                '<td class="infosupselectpiceunit'+count+'">'+
                '</td>'+
                '<td style="text-align: center; font-size: 13px;">'+
                '<div class="summoney'+count+'"></div>'+ 
                '</td>'+
                '<td class="infosupselectdatget'+count+'">'+
                '</td>'+
                '<td class="infosupselectdatexp'+count+'">'+
                '</td>'+
                '<td style="text-align: center;"><a class="btn btn-danger remove" style="color:#FFFFFF;"><i class=" fa fa-trash-alt"></i></a></td>'+
                '</tr>';
                                  
    $('.tbody2').append(tr);
    };

    $('.tbody2').on('click','.remove', function(){
        $(this).parent().parent().remove();
});
</script>



@endsection