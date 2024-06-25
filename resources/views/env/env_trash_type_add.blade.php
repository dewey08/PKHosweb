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
                                    <label for="">เพิ่มข้อมูลพารามิเตอร์ </label>
                                </div>
                                <div class="ms-auto">
    
                                </div>
                            </div>
                        </div>

                        <div class="card-body shadow-lg">
                            <form class="custom-validation" action="{{ route('env.env_water_parameter_save') }}" method="POST" enctype="multipart/form-data">
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
                                                <label for="land_tonnage_number">รายการพารามิเตอร์ :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="parameter_list_name" type="text"
                                                        class="form-control form-control-sm" name="parameter_list_name">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label for="article_name">หน่วย :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="parameter_list_unit" type="text" 
                                                        class="form-control form-control-sm" name="parameter_list_unit">                                                        
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row mt-3">
                                            <div class="col-md-2 text-end">
                                                <label for="land_tonnage_no">ค่ามาตรฐาน :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="parameter_list_normal" type="text"
                                                        class="form-control form-control-sm" name="parameter_list_normal">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label for="land_explore_page">วิธีที่ใช้วิเคราะห์ :</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input id="parameter_list_user_analysis_results" type="text"
                                                        class="form-control form-control-sm" name="parameter_list_user_analysis_results">
                                                </div>
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
    
                                    <a href="{{ url('env_water_parameter') }}" class="btn btn-danger btn-sm">
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
