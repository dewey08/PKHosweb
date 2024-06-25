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
use Auth;

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
                                    <label for="">เพิ่มข้อมูลขยะ </label>
                                </div>
                                <div class="ms-auto">
    
                                </div>
                            </div>
                        </div>

                        <div class="card-body shadow-lg">
                            <form class="custom-validation" action="{{ route('env.env_trash_save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}">
                                <div class="row">
                               
                                        <div class="col-md-12">        
                                            <!-- <input type="hidden" id="article_decline_id" name="article_decline_id" class="form-control" value="6"/>
                                                <input type="hidden" id="article_categoryid" name="article_categoryid" class="form-control" value="26"/>
                                                <input type="hidden" id="article_typeid" name="article_typeid" class="form-control" value="2"/>
                                                <input type="hidden" id="article_groupid" name="article_groupid" class="form-control" value="3"/>
                                                <input type="hidden" name="store_id" id="store_id" value=" {{ Auth::user()->store_id }}"> -->
        
                                            <div class="row">
                                                <div class="col-md-1 text-end">
                                                    <label for="trash_bill_on">TRASH_NO :</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input value="{{$billNos}}" name="trash_bill_on" id="trash_bill_on"  class="form-control input-lg fo13" >                                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-1 text-end">
                                                    <label for="trash_date">วันที่บันทึก :</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <input id="trash_date" type="date"
                                                                class="form-control form-control-sm" name="trash_date">
                                                        </div>
                                                        {{-- <select id="water_user1" name="water_user" class="form-control form-control-sm" style="width: 100%">
                                                            <option value="">--เลือก--</option>
                                                            @foreach ($users as $ue)                                               
                                                                <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>                                             
                                                            @endforeach
                                                        </select> --}}
                                                    </div>
                                                </div>

                                                <div class="col-md-1 text-end">
                                                    <label for="trash_time">เวลาบันทึก :</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="time" id="time_save_trash" name="time_save_trash" class="form-control" placeholder=""/>
                                                    </div>
                                                </div>
                                            </div>
        
                                            <div class="row mt-2">
                                                {{-- <div class="col-md-2 text-end">
                                                    <label for="trash_time">เวลาบันทึก :</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input id="trash_time" type="text"
                                                            class="form-control form-control-sm" name="trash_time">
                                                    </div>
                                                </div> --}}
                                                
                                                <div class="col-md-1 text-end">
                                                    <label for="trash_sub">บริษัท :</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        {{-- <input id="trash_sub" type="text"
                                                            class="form-control form-control-sm" name="trash_sub"> --}}
                                                            <select id="trash_sub" name="trash_sub"
                                                                    class="form-control form-control-sm" style="width: 100%">
                                                                    <option value="">--เลือก--</option>
                                                                    @foreach ($products_vendor as $vendor)                                               
                                                                        <option value="{{ $vendor->vendor_id }}" selected> {{ $vendor->vendor_name }} </option>                                             
                                                                    @endforeach
                                                            </select>
                                                    </div>
                                                </div> 
                                                
                                                {{-- <div class="row mt-1"> --}}
                                                    <div class="col-md-1 text-end">
                                                        <label for="trash_user">ผู้บันทึกข้อมูล :</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            {{-- <input id="trash_user" type="date"
                                                                class="form-control form-control-sm" name="trash_user"> --}}
                                                                <select id="water_user2" name="trash_user"
                                                                    class="form-control form-control-sm" style="width: 100%">
                                                                    <option value="">--เลือก--</option>
                                                                    @foreach ($users as $ue)                                               
                                                                        <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>                                             
                                                                    @endforeach
                                                                </select>
                                                        </div>
                                                    </div>
                                                {{-- </div> --}}
                                            </div>
                                            
                                              
                                            <div class="row mt-3">
                                                {{-- <div class="col-md-2 text-end">
                                                    <label for="parameter_list_normal">ผู้วิเคราะห์ตัวอย่าง :</label>
                                                </div> --}}
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {{-- <input id="parameter_list_normal" type="text"
                                                            class="form-control form-control-sm" name="parameter_list_normal"> --}}
                                                        {{-- <select id="water_user2" name="water_user"
                                                            class="form-control form-control-sm" style="width: 100%">
                                                            <option value="">--เลือก--</option>
                                                            @foreach ($users as $ue)                                               
                                                                <option value="{{ $ue->id }}"> {{ $ue->fname }}  {{ $ue->lname }} </option>                                             
                                                            @endforeach
                                                        </select> --}}
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-2 text-end">
                                                    <label for="water_comment">หมายเหตุ :</label>
                                                </div> --}}
                                                <div class="col-md-4">
                                                    {{-- <div class="form-group">
                                                        <input id="water_comment" type="text"
                                                            class="form-control form-control-sm" name="water_comment">
                                                    </div> --}}
                                                </div>                                           
                                            </div>

                                        {{-- <div class="row push">
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
                                                    <tbody class="tbody">
                                                        <?php $number = 1; ?>
                                                        @foreach($dataparameters as $items)
                                                       
                                                        <tr height="20">                                             
                                                            <td style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;"> {{ $number++}} </td>                                           
                                                            <td>
                                                                <input type="hidden" value="{{ $items->parameter_list_id }}" name="parameter_list_id[]" id="parameter_list_id[]" class="form-control input-sm fo13" >
                                                                <input value="{{ $items->parameter_list_name }}" name="" id="" class="form-control input-sm fo13" readonly>
                                                            </td>                                
                                                            <td><input value="{{ $items->parameter_list_unit }}" name="parameter_list_unit[]" id="parameter_list_unit[]" class="form-control input-sm fo13" readonly></td>
                                                            <td><input name="ANALYSIS_RESULTS[]" id="ANALYSIS_RESULTS[]" class="form-control input-sm fo13" ></td>
                                                            <td><input value="{{ $items->parameter_list_user_analysis_results }}" name="parameter_list_user_analysis_results[]" id="parameter_list_user_analysis_results[]" class="form-control input-sm fo13" readonly></td> 
                                                            <td><input value="{{ $items->parameter_list_normal }}" name="water_qty[]" id="water_qty[]" class="form-control input-sm fo13" readonly></td>
                                                        </tr>
                                                        @endforeach 
                                                    </tbody>
                                                </table>   
                                            </div> 
                                        </div> --}}

                                    <div class="row">
                                        <label for="">รายการขยะ</label>
                                        <div class="col-md-12">
                                            {{-- @foreach ($dataparameters as $item)
                                                <p>{{$item->parameter_list_name}}</p>
                                            @endforeach --}}
                                            <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                                                <thead style="background-color: #aecefd;">
                                                    <tr height="40">
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;font-family: 'Kanit', sans-serif;font-size: 13px;" width="3%">ลำดับ</td>
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="25%">ประเภทขยะ</th>
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="7%">ปริมาณ</th> 
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="10%">หน่วย</th> 
                                                        {{-- <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="20%">วิธี่ที่ใช้วิเคราะห์</th> 
                                                        <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;" width="15%">ค่ามาตรฐาน</th>                                             --}}
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody">
                                                    <?php $number = 1; ?>
                                                    @foreach($data_trash_set as $items)                                                   
                                                    <tr height="20">
                                                        <td style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;"> {{ $number++}} </td>
                                                        <td>
                                                            <input type="hidden" value="{{ $items->trash_set_id }}" name="trash_set_id[]" id="trash_set_id[]" class="form-control input-sm fo13" >
                                                            <input value="{{ $items->trash_set_name }}" name="" id="" class="form-control input-sm fo13" readonly>
                                                        </td>
                                                        <td><input name="trash_sub_qty[]" id="trash_sub_qty[]" class="form-control input-sm fo13" ></td>  
                                                        <td><input value="{{ $items->trash_set_unit }}" name="trash_set_unit[]" id="trash_set_unit[]" class="form-control input-sm fo13" readonly></td>
                                                                                                    
                                                        {{-- <td style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;"> {{ $number++}} </td>                                           
                                                        <td>
                                                            <input type="hidden" value="{{ $items->trash_set_id }}" name="trash_set_id[]" id="trash_set_id[]" class="form-control input-sm fo13" >
                                                            <input value="{{ $items->trash_set_name }}" name="" id="" class="form-control input-sm fo13" readonly>
                                                        </td>                                
                                                        <td><input value="{{ $items->trash_set_unit }}" name="trash_set_unit[]" id="trash_set_unit[]" class="form-control input-sm fo13" readonly></td> --}}
                                                        {{-- <td><input name="ANALYSIS_RESULTS[]" id="ANALYSIS_RESULTS[]" class="form-control input-sm fo13" ></td>
                                                        <td><input value="{{ $items->parameter_list_user_analysis_results }}" name="parameter_list_user_analysis_results[]" id="parameter_list_user_analysis_results[]" class="form-control input-sm fo13" readonly></td> 
                                                        <td><input value="{{ $items->parameter_list_normal }}" name="water_qty[]" id="water_qty[]" class="form-control input-sm fo13" readonly></td> --}}
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
    
                                    <a href="{{ url('env_trash') }}" class="btn btn-danger btn-sm">
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
