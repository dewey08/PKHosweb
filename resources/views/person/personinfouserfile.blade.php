@extends('layouts.backend')

<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

<style>
    .center {
        margin: auto;
        width: 100%;
        padding: 10px;
    }

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 13px;
    }

    label {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;
    }


    .text-pedding {
        padding-left: 10px;
    }

    .text-font {
        font-size: 13px;
    }
</style>

@section('content')
<script>
    function checklogin() {
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
<?php
  $status = Auth::user()->status; 
  $id_user = Auth::user()->PERSON_ID; 
  $url = Request::url();
  $pos = strrpos($url, '/') + 1;
   
if($status=='ADMIN'){
    $user_id = substr($url, $pos);    
}else{
    $user_id = $id_user;  
}          

?>


<!-- Advanced Tables -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">
                {{ $inforpersonusereducat -> HR_PREFIX_NAME }}   {{ $inforpersonusereducat -> HR_FNAME }}  {{ $inforpersonusereducat -> HR_LNAME }}
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">

                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="content">
@if (session('success'))
        <div class="alert alert-success" align="left">
            <ul>
                <li>{{session('success')}}</li>
            </ul>
        </div>
    @endif
    <div class="block block-rounded block-bordered">
        <div class="block-content">
            <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">ข้อมูลไฟล์เเนบ</h2>
            <a href="" data-toggle="modal" data-target="#add_file"  class="btn btn-hero-sm btn-hero-info" ><i class="fas fa-plus"></i> เพิ่มข้อมูลไฟล์เเนบ</a>
            <div class="mt-3">
                <div class="table-responsive">

                    <table class="gwt-table table-striped table-vcenter" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="100%">
                        <thead style="background-color: #FFEBCD;">

                            <tr height="40">
                                <th class="text-font"width="5%" >ลำดับ</th>
                                <th class="text-font">ชื่อเรื่อง</th>
                                <th class="text-font" width="10%">วันที่</th>
                                <th class="text-font" width="10%">AttachFile</th>
                                <th class="text-font" width="8%">คำสั่ง</th>
                            </tr>
                        </thead>
                       
                        <?php $number = 0;  ?>
                        @foreach($infouserfile as $row)
                        <?php $number++;  ?>
                         <tbody>
                            <tr height="20">
                                <td class="text-font text-pedding">{{$number}}</td>
                                <td class="text-font text-pedding" style="text-align: left;">{{$row->FILE_NAME}}</td>
                                <td class="text-font text-pedding" style="text-align: center;">{{DateThai($row->DATE_SAVE)}}</td>
                                    @if($row->FILE_PERSON == '' || $row->FILE_PERSON == null)
                                        <td  style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"></td>
                                    @else
                                        <td  style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"> <a href="{{ asset('storage/filepreson/'.$row->FILE_PERSON) }}" target="_blank"><span class="btn fa fa-1.5x" style="background-color:#0000FF;color:#F0FFFF;"><i class="fa fa-paperclip"></i></span></a></td>
                                    @endif
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle"
                                            id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false"
                                            style="font-family: 'Kanit', sans-serif; font-size: 12px;font-weight:normal;">
                                            ทำรายการ
                                        </button>
                                        <div class="dropdown-menu" style="width:10px">
                                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#edit_file{{$row->ID}}"
                                                style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;"
                                                data-toggle="modal">แก้ไขข้อมูล</a>
                                            <a class="dropdown-item"
                                                href="{{ url('person/personinfouserfile/destroy/'.$row->ID.'/'.$row->PERSON_ID)  }}"
                                                onclick="return confirm('ต้องการที่จะลบข้อมูลไฟล์แนบ ?')"
                                                style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">ลบข้อมูล</a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <!-- The Modal edit-->
                            <div class="modal fade" id="edit_file{{$row->ID}}"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;"> แก้ไขข้อมูลไฟล์เเนบ</h2>
                                    </div>
                                    <div class="modal-body">
                                        <form  method="post" id="form_edit{{$row->ID}}" action="{{ route('person.inforfile_update') }}" style=" font-family: 'Kanit', sans-serif;" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3 text">
                                                    <label >ชื่อเรื่อง</label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="hidden" name="ID" id="ID" value="{{ $row->ID }}">
                                                    <input  type="text" required name = "FILE_NAME_EDIT"  id="FILE_NAME_EDIT" placeholder="กรุณากรอกชื่อเรื่อง..." class="form-control input-lg " style=" font-family: 'Kanit', sans-serif;" value="{{ $row->FILE_NAME }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-3 text">
                                                    <label >ไฟล์เเนบ</label>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input  style="font-family: 'Kanit', sans-serif;" type="file" name="FILE_PERSON_EDIT" id="FILE_PERSON_EDIT" class="form-control" value="{{ $row->FILE_PERSON }}">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name = "PERSON_ID_EDIT"  id="PERSON_ID_EDIT"  value="{{ $inforpersonuserid ->ID }} ">
                                    </div>
                                    <div class="modal-footer">
                                        <div align="right">
                                            <button type="sumbit"  class="btn btn-hero-sm btn-hero-info  btn-submit-edit" onclick="editnumber({{ $row->ID }});" ><i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล</button>
                                            <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal" ><i class="fas fa-window-close"></i> &nbsp;ยกเลิก</button>
                                        </div>
                                    </div>              
                                    </form>  
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
        </div>
</div>

<!-- The Modal add-->
<div class="modal fade" id="add_file"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;"> เพิ่มข้อมูลไฟล์เเนบ</h2>
        </div>
        <div class="modal-body">
            <form  method="post"  id="form_add" action="{{ route('person.inforfile_save') }}" style=" font-family: 'Kanit', sans-serif;" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 text">
                        <label >ชื่อเรื่อง</label>
                    </div>
                    <div class="col-lg-9">
                        <input  type="text" required name ="FILE_NAME"  id="FILE_NAME" placeholder="กรุณากรอกชื่อเรื่อง..." class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-3 text">
                        <label >ไฟล์เเนบ</label>
                    </div>
                    <div class="col-lg-9">
                        <input  style="font-family: 'Kanit', sans-serif;" type="file" name="FILE_PERSON" id="FILE_PERSON" class="form-control">
                    </div>
                </div>
            </div>
            <input type="hidden" name = "PERSON_ID"  id="PERSON_ID"  value="{{ $inforpersonuserid ->ID }} ">
        </div>
        <div class="modal-footer">
            <div align="right">
                <button type="sumbit"  class="btn btn-hero-sm btn-hero-info btn-submit-add" ><i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล</button>
                <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal" ><i class="fas fa-window-close"></i> &nbsp;ยกเลิก</button>
            </div>
        </div>              
        </form>  
</div>
            @endsection

            @section('footer')

            <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
            <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
            <script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8">
            </script>

            <script>
                $(document).ready(function () {

                    $('.datepicker').datepicker({
                        format: 'dd/mm/yyyy',
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true //Set เป็นปี พ.ศ.
                    }).datepicker("setDate", 0); //กำหนดเป็นวันปัจุบัน
                });

                $(document).ready(function () {

                    $('.datepicker2').datepicker({
                        format: 'dd/mm/yyyy',
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true //Set เป็นปี พ.ศ.
                    }).datepicker("setDate", 0); //กำหนดเป็นวันปัจุบัน
                });

                function chkmunny(ele) {
                    var vchar = String.fromCharCode(event.keyCode);
                    if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
                    ele.onKeyPress = vchar;
                }


                $('body').on('keydown', 'input, select, textarea', function (e) {
                    var self = $(this),
                        form = self.parents('form:eq(0)'),
                        focusable, next;
                    if (e.keyCode == 13) {
                        focusable = form.find('input,a,select,button,textarea').filter(':visible');
                        next = focusable.eq(focusable.index(this) + 1);
                        if (next.length) {
                            next.focus();
                        } else {
                            form.submit();
                        }
                        return false;
                    }
                });


            </script>



            @endsection