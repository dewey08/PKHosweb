@extends('layouts.envnew')
@section('title', 'PK-OFFICER || ENV')
@section('content')
<style>
    #button {
        display: block;
        margin: 20px auto;
        padding: 30px 30px;
        background-color: #eee;
        border: solid #ccc 1px;
        cursor: pointer;
    }

    #overlay {
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height: 100%;
        display: none;
        background: rgba(0, 0, 0, 0.6);
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

    .is-hide {
        display: none;
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
                            <label for="">เพิ่มข้อมูลขยะ </label>
                        </div>
                        <div class="ms-auto">

                        </div>
                    </div>
                </div>

                <div class="card-body shadow-lg">
                    <form class="custom-validation" action="{{ route('env.env_trash_save') }}" method="POST"
                        enctype="multipart/form-data">
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
                                            <input value="{{$billNos}}" name="trash_bill_on" id="trash_bill_on"
                                                class="form-control input-lg fo13" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-1 text-end">
                                        <label for="trash_date">วันที่บันทึก :</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <input id="trash_date" type="date" class="form-control form-control-sm"
                                                    name="trash_date">
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-1 text-end">
                                        <label for="trash_time">เวลาบันทึก :</label>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="time" id="trash_time" name="trash_time" class="form-control"
                                                placeholder="" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 text-end">
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
                                                    <option value="{{ $ue->id }}"> {{ $ue->fname }} {{ $ue->lname }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                                    
                                    
                                </div>

                                <div class="row">
                                    <label for="">รายการขยะ</label>
                                    <div class="col-md-12">
                                        {{-- @foreach ($dataparameters as $item)
                                        <p>{{$item->parameter_list_name}}</p>
                                        @endforeach --}}
                                        <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                                            <thead style="background-color: #aecefd;">
                                                <tr height="40">
                                                    <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;font-family: 'Kanit', sans-serif;font-size: 13px;"
                                                        width="3%">ลำดับ</td>
                                                    <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;"
                                                        width="25%">ประเภทขยะ</th>
                                                    <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;"
                                                        width="7%">ปริมาณ</th>
                                                    <th style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 14px;"
                                                        width="10%">หน่วย</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody">
                                                <?php $number = 1; ?>
                                                @foreach($trash_parameter as $items)
                                                <tr height="20">
                                                    <td
                                                        style="text-align: center;font-family: 'Kanit', sans-serif;font-size: 13px;">
                                                        {{ $number++}} </td>
                                                    <td>
                                                        <input type="hidden" value="{{ $items->trash_parameter_id }}"
                                                            name="trash_parameter_id[]" id="trash_parameter_id[]"
                                                            class="form-control input-sm fo13">
                                                        <input value="{{ $items->trash_parameter_name }}" name="" id=""
                                                            class="form-control input-sm fo13" readonly>
                                                    </td>
                                                    <td><input name="trash_sub_qty[]" id="trash_sub_qty[]"
                                                            class="form-control input-sm fo13" required></td>
                                                    <td><input value="{{ $items->trash_parameter_unit }}"
                                                            name="trash_parameter_unit[]" id="trash_parameter_unit[]"
                                                            class="form-control input-sm fo13" readonly></td>

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