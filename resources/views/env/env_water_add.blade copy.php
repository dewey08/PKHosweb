@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
@section('content')
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
<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\StaticController;
$refnumber = SuppliesController::refnumber();
$count_product = StaticController::count_product();
$count_service = StaticController::count_service();
?>

@section('content')



<div class="container-fluid" style="width: 97%">
    <div class="row ">
        <div class="col-md-12">
            <div class="card shadow">
                 
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="">
                                    <label for="">เพิ่มข้อมูลผลวิเคราะห์คุณภาพน้ำทิ้ง </label>
                                </div>
                                <div class="ms-auto">
    
                                </div>
                            </div>
                        </div>

                        <div class="card-body shadow-lg">
                            <form class="custom-validation" action="{{ route('land.land_index_save') }}" method="POST"
                            id="insert_landForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                            <div class="row">

                           
                                    <div class="col-md-8">
    
                                        <!-- <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                            <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/>
                                            <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/>
                                            <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/>
                                            <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> -->
    
                                        <div class="row">
                                            <div class="col-md-2 text-end">
                                                <label for="land_tonnage_number">วันที่บันทึก :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="water_date" type="text"
                                                        class="form-control form-control-sm" name="water_date">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label for="article_name">ผู้บันทึก :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="water_user" type="text" 
                                                        class="form-control form-control-sm" name="water_user">                                                        
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row mt-3">
                                            <div class="col-md-2 text-end">
                                                <label for="land_tonnage_no">สถานที่เก็บตัวอย่าง :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="water_location" type="text"
                                                        class="form-control form-control-sm" name="water_location">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label for="land_explore_page">ลักษณะตัวอย่าง :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="water_group_excample" type="text"
                                                        class="form-control form-control-sm" name="water_group_excample">
                                                </div>
                                            </div>                                           
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-2 text-end">
                                                <label for="land_tonnage_no">วันที่รับตัวอย่าง :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="parameter_list_normal" type="text"
                                                        class="form-control form-control-sm" name="parameter_list_normal">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label for="land_explore_page">วันที่วิเคราะห์ตัวอย่าง :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="parameter_list_user_analysis_results" type="text"
                                                        class="form-control form-control-sm" name="parameter_list_user_analysis_results">
                                                </div>
                                            </div>                                           
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-2 text-end">
                                                <label for="land_tonnage_no">ผู้วิเคราะห์ตัวอย่าง :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="parameter_list_normal" type="text"
                                                        class="form-control form-control-sm" name="parameter_list_normal">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label for="land_explore_page">หมายเหตุ :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="water_comment" type="text"
                                                        class="form-control form-control-sm" name="water_comment">
                                                </div>
                                            </div>                                           
                                        </div>

                                        <div class="row push">
                                            <div class="col-sm-2 ">
                                                <div align="left" style=" font-family:'Kanit', sans-serif;font-size: 13px;font-weight:bold;">
                                                    รายการพารามิเตอร์ :
                                                </div>
                                            </div>
                                            <div class="col-lg-9 ">
                                                <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                                                    <thead style="background-color: #BDFBC9;">
                                                        <tr height="40">
                                                            <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;font-family: 'Kanit', sans-serif;font-size: 13px;" width="5%">ลำดับ</td>
                                                            <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;">รายการพารามิเตอร์</th>
                                                            <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="10%">หน่วย</th> 
                                                            <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="20%">ผลการวิเคราะห์</th> 
                                                            <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="20%">วิธี่ที่ใช้วิเคราะห์</th> 
                                                            <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="20%">ค่ามาตรฐาน</th>                                            
                                                        </tr>
                                                    </thead>
                                                    {{-- <tbody class="tbody">
                                                        <?php $number = 0; ?>
                                                        @foreach($list_parameters as $list_parameter)
                                                        <?php $number++;  ?>
                                                        <tr height="20">                                             
                                                            <td style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;"> {{ $number}} </td>                                           
                                                            <td>
                                                                <input type="hidden" value="{{ $list_parameter->LIST_PARAMETER_ID }}" name="LIST_PARAMETER_ID[]" id="LIST_PARAMETER_ID[]" class="form-control input-sm fo13" >
                                                                <input value="{{ $list_parameter->LIST_PARAMETER_DETAIL }}" name="" id="" class="form-control input-sm fo13" readonly>
                                                            </td>                                
                                                            <td><input value="{{ $list_parameter->LIST_PARAMETER_UNIT }}" name="LIST_PARAMETER_UNIT[]" id="LIST_PARAMETER_UNIT[]" class="form-control input-sm fo13" readonly></td>
                                                            <td><input name="ANALYSIS_RESULTS[]" id="ANALYSIS_RESULTS[]" class="form-control input-sm fo13" ></td>
                                                            <td><input value="{{ $list_parameter->LIST_USEANALYSIS_RESULTS }}" name="USEANALYSIS_RESULTS[]" id="USEANALYSIS_RESULTS[]" class="form-control input-sm fo13" readonly></td> 
                                                            <td><input value="{{ $list_parameter->LIST_PARAMETER_NORMAL }}" name="PARAMETER_QTY[]" id="PARAMETER_QTY[]" class="form-control input-sm fo13" readonly></td>
                                                        </tr>
                                                        @endforeach 
                                                    </tbody> --}}
                                                </table>   
                                            </div> 
                                        </div>
  
    
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
    
                                    <a href="{{ url('env_water') }}" class="btn btn-danger btn-sm">
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
</div>





@endsection
