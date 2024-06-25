@extends('layouts.plannew')
@section('title','PK-OFFICER || Plan')
{{-- @section('menu') --}}
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
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
?>

@section('content')

    <div class="container-fluid " style="width: 97%">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> 
                        เพิ่มข้อมูลแผนงานโครงการ
                        <div class="btn-actions-pane-right">
                            <label for="plan_project_no">เลขที่โครงการ :</label>
                            <a class="me-2 btn-icon btn-shadow btn-dashed btn btn-sm btn-outline-info"  > 
                                <input id="plan_project_no" type="text" class="form-control form-control-sm"
                                                name="plan_project_no" value="{{ $refnumber }}" readonly>
                                </a> 
                        </div> 
                        {{-- <div class="d-flex">
                            <div class="">
                                <label for="">เพิ่มข้อมูลแผนงานโครงการ </label>
                            </div>
                            <div class="ms-auto"> 
                                <div class="row">
                                    <div class="col-md-5 text-end">
                                        <label for="plan_project_no">เลขที่โครงการ :</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input id="plan_project_no" type="text" class="form-control form-control-sm"
                                                name="plan_project_no" value="{{ $refnumber }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="card-body shadow-lg">                       
                            
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2 text-end">
                                            <label for="plan_project_year">ปีงบประมาณ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="plan_project_year" name="plan_project_year"
                                                class="form-select form-select-lg" style="width: 100%">
                                                <option value="">--เลือก--</option>
                                                @foreach ($budget_year as $y)
                                                    <option value="{{ $y->leave_year_id }}">
                                                        {{ $y->leave_year_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="plan_project_startdate">ระยะเวลาตั้งแต่วันที่ :</label>
                                        </div>
                                        <div class="col-md-2"> 
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" placeholder="วัน-เดือน-ปี" name="plan_project_startdate"
                                                    data-date-format="dd MM, yyyy" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true">

                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div> 
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="plan_project_enddate">ถึงวันที่ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group" id="datepicker1">
                                                <input type="text" class="form-control" placeholder="วัน-เดือน-ปี" name="plan_project_enddate"
                                                    data-date-format="dd MM, yyyy" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true">

                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="plan_project_nameplan">ชื่อโครงการ :</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <input id="plan_project_nameplan" type="text" class="form-control" name="plan_project_nameplan">
                                                {{-- <input id="product_attribute" type="text" class="form-control form-control-sm" name="product_attribute"> --}}
                                            </div>
                                        </div>                                         
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_num">รายละเอียดโครงการ :</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="card-body shadow-lg">
                                                    <div class="table-responsive">
                                                        <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                                            <thead>
                                                                <tr
                                                                    style="background-color: rgb(65, 168, 168);color:#FFFFFF;font-size:14px">
                                                                    <td style="text-align: center;"width="3%">ลำดับ</td>
                                                                    <td style="text-align: center;">รายละเอียดโครงการ</td> 
                                                                    <td style="text-align: center;" width="20%">รายละเอียดย่อย</td> 
                                                                    <td style="text-align: center;" width="4%">
                                                                        <a class="btn btn-sm btn-success addRow1" style="color:#FFFFFF;"><i
                                                                                class="fas fa-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tbody1">
                                                                <tr height="30" style="font-size:13px">
                                                                    <td style="text-align: center;"> 1 </td> 
                                                                    <td>
                                                                        <input name="plan_project_detail_id[]" id="plan_project_detail_id0" type="text" class="form-control form-control-sm">
                                                                    </td> 
                                                                    <td style="text-align: center;" width="20%">
                                                                        <a class="btn btn-sm btn-success fa fa-plus "
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                        {{-- <i class="fa-solid fa-folder-plus text-white me-2"></i> --}}
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove1"
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                    </td>
                                                                   
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_num">วัตถุประสงค์ :</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="card-body shadow-lg">
                                                    <div class="table-responsive">
                                                        <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                                            <thead>
                                                                <tr
                                                                    style="background-color: rgb(65, 168, 168);color:#FFFFFF;font-size:14px">
                                                                    <td style="text-align: center;"width="3%">ลำดับ</td>
                                                                    <td style="text-align: center;">วัตถุประสงค์</td> 
                                                                    <td style="text-align: center;" width="4%">
                                                                        <a class="btn btn-sm btn-success addRow2" style="color:#FFFFFF;"><i
                                                                                class="fas fa-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tbody2">
                                                                <tr height="30" style="font-size:13px">
                                                                    <td style="text-align: center;"> 1 </td> 
                                                                    <td>
                                                                        <input name="plan_project_objective_id[]" id="plan_project_objective_id0" type="text" class="form-control form-control-sm">
                                                                    </td> 
                                                                    <td style="text-align: center;">
                                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove2"
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                    </td>
                                                                   
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_num">กลุ่มเป้าหมาย :</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="card-body shadow-lg">
                                                    <div class="table-responsive">
                                                        <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                                            <thead>
                                                                <tr
                                                                    style="background-color: rgb(65, 168, 168);color:#FFFFFF;font-size:14px">
                                                                    <td style="text-align: center;"width="3%">ลำดับ</td>
                                                                    <td style="text-align: center;">กลุ่มเป้าหมาย</td> 
                                                                    <td style="text-align: center;" width="4%">
                                                                        <a class="btn btn-sm btn-success addRow3" style="color:#FFFFFF;"><i
                                                                                class="fas fa-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tbody3">
                                                                <tr height="30" style="font-size:13px">
                                                                    <td style="text-align: center;"> 1 </td> 
                                                                    <td>
                                                                        <input name="plan_project_target_id[]" id="plan_project_target_id0" type="text" class="form-control form-control-sm">
                                                                    </td> 
                                                                    <td style="text-align: center;">
                                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove3"
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                    </td>
                                                                   
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_num">ตัวชี้วัด :</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="card-body shadow-lg">
                                                    <div class="table-responsive">
                                                        <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                                            <thead>
                                                                <tr
                                                                    style="background-color: rgb(65, 168, 168);color:#FFFFFF;font-size:14px">
                                                                    <td style="text-align: center;"width="3%">ลำดับ</td>
                                                                    <td style="text-align: center;">ตัวชี้วัด</td> 
                                                                    <td style="text-align: center;" width="20%">รายละเอียด</td> 
                                                                    <td style="text-align: center;" width="4%">
                                                                        <a class="btn btn-sm btn-success addRow4" style="color:#FFFFFF;"><i
                                                                                class="fas fa-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tbody4">
                                                                <tr height="30" style="font-size:13px">
                                                                    <td style="text-align: center;"> 1 </td> 
                                                                    <td>
                                                                        <input name="plan_project_kpi_id[]" id="plan_project_kpi_id0" type="text" class="form-control form-control-sm">
                                                                    </td> 
                                                                    <td style="text-align: center;" width="20%">
                                                                        <a class="btn btn-sm btn-success fa fa-plus "
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                        {{-- <i class="fa-solid fa-folder-plus text-white me-2"></i> --}}
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove4"
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                    </td>
                                                                   
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="article_num">งบประมาณ :</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="card-body shadow-lg">
                                                    <div class="table-responsive">
                                                        <table class="table-bordered table-striped table-vcenter" style="width: 100%;">
                                                            <thead>
                                                                <tr
                                                                    style="background-color: rgb(65, 168, 168);color:#FFFFFF;font-size:14px">
                                                                    <td style="text-align: center;"width="3%">ลำดับ</td>
                                                                    <td style="text-align: center;">รายละเอียด</td> 
                                                                    <td style="text-align: center;" width="20%">จำนวนเงิน</td> 
                                                                    <td style="text-align: center;" width="4%">
                                                                        <a class="btn btn-sm btn-success addRow5" style="color:#FFFFFF;"><i
                                                                                class="fas fa-plus"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="tbody5">
                                                                <tr height="30" style="font-size:13px">
                                                                    <td style="text-align: center;"> 1 </td> 
                                                                    <td>
                                                                        <input name="plan_project_budget_id[]" id="plan_project_budget_id0" type="text" class="form-control form-control-sm">
                                                                    </td> 
                                                                    <td style="text-align: center;" width="20%">
                                                                        <input name="plan_project_budget_price[]" id="plan_project_budget_price0" type="text" class="form-control form-control-sm">
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <a class="btn btn-sm btn-danger fa fa-trash-alt remove5"
                                                                            style="color:#FFFFFF;">
                                                                        </a>
                                                                    </td>
                                                                   
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                         
                                    </div>

 

                                    <div class="row mt-3">
                                        <div class="col-md-2 text-end">
                                            <label for="plan_project_budgetsource">แหล่งงบประมาณ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="plan_project_budgetsource" name="plan_project_budgetsource"
                                                    class="form-select form-select-lg show_unit" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    {{-- @foreach ($product_unit as $prounit)
                                                        <option value="{{ $prounit->unit_id }}">
                                                            {{ $prounit->unit_name }}
                                                        </option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <label for="plan_project_userid">ผู้รับผิดชอบ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="plan_project_userid" name="plan_project_userid"
                                                    class="form-select form-select-lg" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    @foreach ($users as $u)
                                                        <option value="{{ $u->id }}">
                                                            {{ $u->fname }}  {{ $u->lname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <label for="plan_project_hnid">ผู้ตรวจสอบ :</label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="plan_project_hnid" name="plan_project_hnid"
                                                    class="form-select form-select-lg show_unitsub" style="width: 100%">
                                                    <option value="">--เลือก--</option>
                                                    {{-- @foreach ($product_unit as $uni)
                                                        <option value="{{ $uni->unit_id }}">
                                                            {{ $uni->unit_name }}
                                                        </option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>

                                    </div>


                                    <input type="hidden" name="plan_project_makeid" id="plan_project_makeid" value="{{ Auth::user()->id }}">
                                  
                                    

                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    บันทึกข้อมูล
                                </button>
                                <a href="{{ url('supplies/supplies_index') }}" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>
                            </div>
                        </div>
                    </div>

                    </form>
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
                $('#example3').DataTable();

                $('#plan_project_budgetsource').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#plan_project_userid').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#plan_project_hnid').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                $('#plan_project_year').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });
                
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                              
            });
           
        </script>    
       
    @endsection
