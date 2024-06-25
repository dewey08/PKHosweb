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
                                    <label for="">แก้ไขข้อมูลคุณภาพน้ำ</label>
                                </div>
                                <div class="ms-auto">
    
                                </div>
                            </div>
                        </div>

                        <div class="card-body shadow-lg">
                            <form class="custom-validation" action="{{ route('env.env_water_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                <div class="row">
                               
                                        <div class="col-md-12">        
                                            <!-- <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                                <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/>
                                                <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/>
                                                <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/>
                                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> -->

                                                <input type="hidden" name="water_id" id="water_id" value="{{$water->water_id}}">
        
                                                <div class="row">
                                                    <div class="col-md-2 text-end">
                                                        <label for="water_date">วันที่บันทึก :</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input id="water_date" type="date"
                                                                {{-- class="form-control form-control-sm" name="water_date"> --}}
                                                                class="form-control form-control-sm" name="water_date" value="{{$water->water_date}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-end">
                                                        <label for="water_user">ผู้บันทึก :</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                                <select id="water_user1" name="water_user"
                                                                class="form-control form-control-sm" style="width: 100%">
                                                                <option value="">--เลือก--</option>
                                                                @foreach ($users as $ue)
                                                                @if ($water->water_user == $ue->id)
                                                                    <option value="{{ $ue->id }}" selected> {{ $ue->fname }}  {{ $ue->lname }} </option>    
                                                                @else
                                                                    <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>    
                                                                @endif                                         
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="row mt-3">
                                                    <div class="col-md-2 text-end">
                                                        <label for="water_location">สถานที่เก็บตัวอย่าง :</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select id="env_pond" name="env_pond"
                                                            class="form-control form-control-sm" style="width: 100%">
                                                            <option value="">--เลือก--</option>
                                                            @foreach ($env_pond as $ue)
                                                            @if ($water->pond_id == $ue->pond_id)
                                                                <option value="{{ $ue->pond_id }}" selected> {{ $ue->pond_name }} </option>    
                                                            @else
                                                                <option value="{{ $ue->pond_id }}"> {{ $ue->pond_name }} </option>    
                                                            @endif                                         
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-2 text-end">
                                                        <label for="water_group_excample">ลักษณะตัวอย่าง :</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input id="water_group_excample" type="text"
                                                                class="form-control form-control-sm" name="water_group_excample"value="{{$water->water_group_excample}}">
                                                        </div>
                                                    </div>                                           
                                                </div>
                                                
                                                <div class="row mt-3">                                            
                                                    <div class="col-md-2 text-end">
                                                        <label for="water_comment">หมายเหตุ :</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input id="water_comment" type="text"
                                                                class="form-control form-control-sm" name="water_comment"value="{{$water->water_comment}}">
                                                        </div>
                                                    </div>                                           
                                                </div>
                                           
                                    <div class="row">
                                        <label for="">รายการคุณภาพน้ำ</label>
                                        <div class="col-md-12">
                                            {{-- @foreach ($dataparameters as $item)
                                                <p>{{$item->parameter_list_name}}</p>
                                            @endforeach --}}
                                            <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                                                <thead style="background-color: #aecefd;">
                                                    <tr height="40">
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="3%">ลำดับ</td>
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="25%">รายการพารามิเตอร์</th>
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="10%">ผลการวิเคราะห์</th>
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="7%">หน่วย</th>                                                         
                                                        {{-- <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="20%">วิธี่ที่ใช้วิเคราะห์</th>  --}}
                                                        {{-- <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="15%">ค่ามาตรฐาน</th>                                                         --}}
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody">
                                                    <?php $number = 1; ?>
                                                    @foreach($env_water_sub as $items2)                                                   
                                                    <tr height="20">
                                                        <td style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;"> {{ $number++}} </td>
                                                        <td>
                                                            <input type="hidden" value="{{ $items2->water_sub_id }}" name="water_sub_id[]" id="water_sub_id[]" class="form-control input-sm fo13" >
                                                            <input value="{{ $items2->water_list_detail }}" name="" id="" class="form-control input-sm fo13" readonly>
                                                        </td>
                                                        <td><input value="{{ $items2->water_qty }}"  name="water_qty[]" id="water_qty[]" class="form-control input-sm fo13" ></td> 
                                                        <td><input value="{{ $items2->water_list_unit }}"  name="water_list_unit[]" id="water_list_unit[]" class="form-control input-sm fo13" readonly ></td>
                                                         
                                                        {{-- <td><input value="{{ $items2->use_analysis_results }}" name="use_analysis_results[]" id="use_analysis_results[]" class="form-control input-sm fo13" readonly></td> --}}
                                                        {{-- <td><input value="{{ $items2->water_results }}" name="water_results[]" id="water_results[]" class="form-control input-sm fo13" readonly></td>    --}}
                                                    </tr>
                                                    @endforeach 
                                                </tbody>
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
        $('#water_user2').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
        // ช่องค้นหาชื่อ
            $('#trash_sub').select2({
            placeholder: "--เลือก--",
            allowClear: true
        }); 
       
       
    });
</script>

@endsection
