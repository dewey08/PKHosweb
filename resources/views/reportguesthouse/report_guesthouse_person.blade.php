@extends('layouts.guesthouse')  
    
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

@section('content')

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
<style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
          
            }
            label{
                    font-family: 'Kanit', sans-serif;
                    font-size: 14px;            
            }  
            .form-control {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
            }

                .table-fixed tbody {
        height: 300px;
        overflow-y: auto;
        width: 100%;
    }
            table {
        border: 1px solid black;
        }
        td {
        border: 1px solid black;
        font-family: 'Kanit', sans-serif;
        font-size: 13px !important;
        }
        th {
        border: 1px solid black;
        font-family: 'Kanit', sans-serif;
        font-weight:normal;
        font-size: 15px !important;
        }

    .table-fixed thead,
    .table-fixed tbody,
    .table-fixed tr,
    .table-fixed td,
    .table-fixed th {
        display: block;
    }

    .table-fixed tbody td,
    .table-fixed tbody th,
    .table-fixed thead > tr > th {
        float: left;
        position: relative;

        &::after {
            content: '';
            clear: both;
            display: block;
        }
    }
</style>

<center>    
    <div class="block mt-5 shadow-lg" style="width: 95%;">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                {{-- <div align="left"> --}}
                    <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>รายงานรายชื่อบุคลากรที่เข้าพักอาศัยในแฟลตและบ้านพัก</B></h3>
                {{-- </div> --}}
                <div align="right">
                    <a href="{{url('reportguesthouse/report_guesthouse_person_excel')}}"  class="btn btn-hero-sm btn-hero-success"  ><li class="fa fa-file-excel mr-2"></li>Export Excel</a>
                </div>
            </div>
            <div class="block-content block-content-full"> 
             <div class="table-responsive"> 
                <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                    <thead style="background-color: #FFEBCD;">
                        <tr height="40">
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="15%">ชื่อแฟลต / บ้านพัก</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="10%">หมายเลขห้องพักหรือชื่อห้องพัก</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">ชื่อ-สุกล ผู้ที่พัก</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">ตำแหน่ง</th>
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="20%">หน่วยงาน</th> 
                            <th class="text-font" style="text-align: center;border: 1px solid black;" width="8%">สถานะ</th>      
                        </tr >
                    </thead>
                    <tbody>  
                        <?php $number = 0; ?>
                        @foreach ($report_gesthpers as $reportgesthper)
                            <?php $number++;?>  
                                
                                    <?php $checkhom = DB::table('guesthous_infomation_person')->where('INFMATION_ID','=',$reportgesthper->INFMATION_ID)->where('INFMATION_PERSON_STATUS','=','1')->count(); ?>
                                   
                                    @if($checkhom !== 0) 
                                        <tr height="20">                                   
                                            <td class="text-font" style="text-align:center;border: 1px solid black;" width="5%">&nbsp;{{$number}}</td>
                                            <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="15%">&nbsp;&nbsp;{{$reportgesthper->INFMATION_NAME}}</td>
                                            <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="10%">&nbsp;&nbsp;{{$reportgesthper->LEVEL_ROOM_NAME}}</td>
                                            <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_FNAME}} &nbsp;{{$reportgesthper->HR_LNAME}}</td>
                                            <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_POSITION_NAME}}</td>                                                             
                                            <td class="text-font text-pedding" style="text-align: left;border: 1px solid black;" width="20%">&nbsp;&nbsp;{{$reportgesthper->HR_DEPARTMENT_SUB_SUB_NAME}}</td>   
                                            <td class="text-font text-pedding" style="text-align: center;border: 1px solid black;" width="8%">
                                            @if($reportgesthper->INFMATION_PERSON_STATUS == '2')
                                                <span class="badge badge-info">ย้ายออกแล้ว</span>
                                            @else
                                                <span class="badge badge-success">ปกติ</span>
                                            @endif
                                            
                                            </td>   
                                        </tr> 
                                    @else
                                           
                                    @endif
                                                                                          
                               
                        @endforeach   
                    </tbody>
                </table>



            </div>
        </div>
    </div>

@endsection

@section('footer')



<script src="{{ asset('asset/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script>jQuery(function(){ Dashmix.helpers(['masked-inputs']); });</script>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>




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