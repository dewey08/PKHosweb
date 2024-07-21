@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
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
           .align3{  
            text-align: center;  //ข้อความตรงกลาง
}

</style>
<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
$datenow = date('Y-m-d');
?>

@section('content')



<div class="container-fluid" style="width: 100%">
    <div class="row ">
        <div class="col-md-4">
            <h3 style="color:green ">บ่อปรับเสถียร</h3>
            <p class="card-title-desc"></p>
        </div>
    </div>

    <div class="row ">        
        <div class="col-md-4">
            <h2 class="card-title">ข้อมูลตรวจวัดค่าพารามิเตอร์</h2>
            <p class="card-title-desc"></p>
        </div>

    </div>

    <div class="row">
        <div class="col-md-2 text-end">
            <label for="water_date">วันที่บันทึก :</label>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <input id="water_date" type="date"
                    class="form-control form-control-sm" name="water_date" value="{{$datenow}}">
            </div>
        </div>
        <div class="col-md-2 text-end">
            <label for="water_user">ผู้บันทึก :</label>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                    <select id="water_user1" name="water_user"
                    class="form-control form-control-sm" style="width: 100%">
                    <option value="">--เลือก--</option>
                    @foreach ($users as $ue) 
                        @if ($iduser == $ue->id )
                        <option value="{{ $ue->id }}" selected> {{ $ue->fname }}  {{ $ue->lname }} </option>  
                        @else
                        <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>  
                        @endif                                     
                    @endforeach
                </select>
            </div>
        </div>        
    </div>

    <label for=""></label> 

    <div class="row">        
        <div class="col"></div>      
        <div class="col-md-10">            
            <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                <thead style="background-color: #aecefd;">
                    <tr height="40">
                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;font-family: 'Kanit', sans-serif;font-size: 13px;" width="3%">ลำดับ</td>
                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="15%">รายการพารามิเตอร์</th>                                                        
                        {{-- <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="5%">ค่าที่กำหนด</th>   --}}
                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="10%">ผลการวิเคราะห์</th>
                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="7%">หน่วย</th>                                                       
                        {{-- <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="15%">ค่ามาตรฐาน</th> --}}
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php $number = 1; ?>
                    @foreach($env_pond_sub as $items) 
                    <tr height="20">                                             
                        <td style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;"> {{ $number++}} </td>                                           
                        <td>
                            <input type="hidden" value="{{ $items->pond_id }}" name="pond_id[]" id="pond_id[]" class="form-control input-sm fo13" >
                            <input value="{{ $items->water_parameter_name }}" name="" id="" class="form-control input-sm fo13" readonly>
                        </td>
                        
                        <td><input style="text-align: center" name="water_qty[]" id="water_qty[]" class="form-control input-sm fo13" type="text" required></td>
                        
                        <td>
                            <input style="text-align: center" value="{{ $items->water_parameter_unit }}" name="water_parameter_unit[]" id="water_parameter_unit[]" class="form-control input-sm fo13" readonly >
                            {{-- <input type="hidden" value="{{ $items->water_parameter_short_name }}" name="water_parameter_short_name[]" id="water_parameter_short_name[]" class="form-control input-sm fo13" > --}}
                        </td>
                        
                        {{-- <td><input type="hidden" value="{{ $items->water_parameter_normal }}" name="water_parameter_normal[]" id="water_parameter_normal[]" class="form-control input-sm fo13" readonly></td> --}}
                    </tr>
                    
                    @endforeach 
                </tbody>
            </table> 
        </div> 
                
        <div class="col"></div>
        
    </div>
    <div class="card-footer">
        <div class="col-md-11 text-end">
            <div class="form-group">

                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    บันทึกข้อมูล
                </button>

                <a href="{{ url('env_water') }}" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-xmark me-2"></i>
                    ยกเลิก
                </a>
            </div>    
        </div>
        <div class="col"></div>
    </div>
</div>

@endsection
@section('footer')
<script>
    
    $(document).ready(function() {
        // $("#overlay").fadeIn(300);　

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        // ช่องค้นหาชื่อ
        $('#water_user1').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        // ช่องค้นหาชื่อ
            $('#env_pond').select2({
            placeholder: "--เลือก--",
            allowClear: true
        }); 
       
       
    });
</script>

@endsection
