@extends('layouts.warehouse')   
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
      font-size: 10px;
      font-size: 1.0rem;
      }

      label{
            font-family: 'Kanit', sans-serif;
            font-size: 10px;
            font-size: 1.0rem;
      } 
        @media only screen and (min-width: 1200px) {
    label {
        /* float:right; */
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
    }else{
        
        echo "<body onload=\"checklogin()\"></body>";
        exit();
    } 
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $user_id = substr($url, $pos);

   
 
?>

<center>    
    <div class="block mt-2" style="width: 95%;">
        <div class="block block-rounded block-bordered">
           
   

              <div class="block-header block-header-default">
                <h3 class="block-title text-left" style="font-family: 'Kanit', sans-serif;"><B>เปิดฟังก์ชั่นฟอร์ม</B></h3>
                &nbsp;&nbsp;
          
                <a href="{{ url('formpdf/warehouse_function_add')}}"  class="btn btn-hero-sm btn-hero-info foo14" ><i class="fas fa-plus mr-2"></i> เพิ่มข้อมูล</a>
            </div>  
    <div class="block-content">
            <div class="table-responsive">    
                <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="gwt-table table-striped table-vcenter js-dataTable-full" style="width: 100%;">
                    <thead style="background-color: #FFEBCD;">
                        <tr height="40">
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center; border: 1px solid black;" width="7%">ลำดับ</th>
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center; border: 1px solid black;" width="25%">รหัสฟังก์ชันฟอร์ม</th>    
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center; border: 1px solid black;" >ชื่อฟังก์ชันฟอร์ม</th>                                                  
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center; border: 1px solid black;" width="7%">สถานะ</th> 
                            <th  class="text-font" style="border-color:#F0FFFF;text-align: center; border: 1px solid black;" width="7%">คำสั่ง</th> 
                        </tr >
                    </thead>
                    <tbody id="myTable">
                   
                    <?php $number = 0; ?>
                        @foreach ($openforms as $openform)
                        <?php $number++; ?>
                            <tr height="20">
                                <td class="text-font" align="center" width="7%">{{$number}}</td>                        
                                <td class="text-font text-pedding" width="25%">{{$openform->WAREHOUSEFORM_CODE}}</td>  
                                <td class="text-font text-pedding" >{{$openform->WAREHOUSEFORM_NAME}}</td>  
                                <td align="center" width="7%">
                                    <div class="custom-control custom-switch custom-control-lg ">
                                        @if($openform-> WAREHOUSEFORM_STATUS == 'True' )
                                            <input type="checkbox" class="custom-control-input" id="{{ $openform-> WAREHOUSEFORM_ID }}" name="{{ $openform-> WAREHOUSEFORM_ID }}" onchange="openform_switchactive({{ $openform-> WAREHOUSEFORM_ID }});" checked>
                                        @else
                                            <input type="checkbox" class="custom-control-input" id="{{ $openform-> WAREHOUSEFORM_ID }}" name="{{ $openform-> WAREHOUSEFORM_ID }}" onchange="openform_switchactive({{ $openform-> WAREHOUSEFORM_ID}});">
                                        @endif
                                            <label class="custom-control-label" for="{{ $openform-> WAREHOUSEFORM_ID }}"></label>
                                   </div>
                                   </td>              
                                <td align="center" width="7%">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family:'Kanit',sans-serif;font-size:10px;font-weight:normal;">
                                            ทำรายการ
                                        </button>
                                    <div class="dropdown-menu" style="width:10px">                           
                                            <a class="dropdown-item"  href="{{ url('formpdf/warehouse_function_edit/'.$openform->WAREHOUSEFORM_ID)}}"  style="font-family:'Kanit',sans-serif;font-size:13px;font-weight:normal;">แก้ไข</a>
                                            <a class="dropdown-item "  href="{{ url('formpdf/warehouse_function_destroy/'.$openform->WAREHOUSEFORM_ID)}}"  style="font-family:'Kanit',sans-serif;font-size:13px;font-weight:normal;" onclick="return confirm('คุณต้องการที่จะลบ {{ $openform->WAREHOUSEFORM_CODE}} ใช่หรือไม่ ?')">ลบ</a>
                                        </div>
                                    </div>
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>
                             
    

  
@endsection

@section('footer')

<script src="{{ asset('select2/select2.min.js') }}"></script>
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
      $(document).ready(function() {
            $('select').select2();
        });
   function openform_switchactive(idfunc){
         // alert(budget);
         var checkBox=document.getElementById(idfunc);
         var onoff;
   
         if (checkBox.checked == true){
           onoff = "True";
     } else {
           onoff = "False";
     } 
    var _token=$('input[name="_token"]').val();
         $.ajax({
                 url:"{{route('form.openform_switchactive')}}",
                 method:"GET",
                 data:{onoff:onoff,idfunc:idfunc,_token:_token}
         })
    }   
</script>

<script>
    $(document).ready(function () {

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true                         //Set เป็นปี พ.ศ.
            });  //กำหนดเป็นวันปัจุบัน
        });
</script>

@endsection