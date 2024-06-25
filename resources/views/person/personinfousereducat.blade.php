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

  .form-control {
    font-family: 'Kanit', sans-serif;
    font-size: 13px;
  }

  label {
    font-family: 'Kanit', sans-serif;
    font-size: 14px;
  }

  th {
    text-align: center;
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
<!-- Advanced Tables -->
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
      <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">
        {{ $inforpersonusereducat -> HR_PREFIX_NAME }} {{ $inforpersonusereducat -> HR_FNAME }}
        {{ $inforpersonusereducat -> HR_LNAME }}</h1>
      <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
        <ol class="breadcrumb">

        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="content">
  <div class="block block-rounded block-bordered">

    <div class="block-content">
      <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">ข้อมูลการศึกษา</h2>

      <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add"><i
          class="fas fa-plus"></i> เพิ่มข้อมูลการศึกษา</button>
      <div class="mt-3">
        <div class="table-responsive">
          <table class="gwt-table table-striped table-vcenter" width="100%">
            <thead style="background-color: #FFEBCD;">

              <tr height="40">
                <th class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">การศึกษา
                </th>
                <th class="text-font" width="10%"
                  style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">วันเริ่มศึกษา</th>
                <th class="text-font" width="10%"
                  style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">วันที่สำเร็จ</th>
                <th class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                  เกรดเฉลี่ย</th>
                <th class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                  จบจากสถาบัน</th>
                <th class="text-font" width="15%"
                  style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">คณะ</th>
                <th class="text-font" width="15%"
                  style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">สาขา</th>
                <th class="text-font" width="8%"
                  style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">คำสั่ง</th>

              </tr>
              </tr>
            </thead>
            <tbody class="tbody1">
              <?php $number=0; ?>
              @foreach ($infoeducations as $infoeducation)
              <tr height="20">
                <td class="text-font text-pedding"
                  style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">
                  {{ $infoeducation -> VUT_NAME }}</td>
                <td class="text-font text-pedding"
                  style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">
                  {{ DateThai($infoeducation -> START_DATE) }}</td>
                <td class="text-font text-pedding"
                  style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">
                  {{ DateThai($infoeducation -> CON_DATE) }}</td>
                <td class="text-font text-pedding"
                  style="border-color:#F0FFFF;text-align: left;border: 1px solid black;"> {{ $infoeducation -> GRADE }}
                </td>
                <td class="text-font text-pedding"
                  style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">
                  {{ $infoeducation -> UNIVER_NAME }}</td>
                <td class="text-font text-pedding"
                  style="border-color:#F0FFFF;text-align: left;border: 1px solid black;">
                  {{ $infoeducation -> FAUCULTY }}</td>
                <td class="text-font text-pedding"
                  style="border-color:#F0FFFF;text-align: left;border: 1px solid black;"> {{ $infoeducation -> LAVEL }}
                </td>

                <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">
                  <div class="dropdown">
                    <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                      style="font-family: 'Kanit', sans-serif; font-size: 12px;font-weight:normal;">
                      ทำรายการ
                    </button>
                    <div class="dropdown-menu" style="width:10px">
                      <a class="dropdown-item" href="#edit_modal{{ $infoeducation -> ID }}" data-toggle="modal"
                        style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">แก้ไขข้อมูล</a>
                      <a class="dropdown-item"
                        href="{{ url('addpersoninfousereducat/destroy/'.$infoeducation->ID.'/'.$infoeducation->PERSON_ID)  }}"
                        onclick="return confirm('ต้องการที่จะลบข้อมูลการศึกษา ?')"
                        style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">ลบข้อมูล</a>

                    </div>
                  </div>
                </td>


              </tr>




              <div id="edit_modal{{ $infoeducation -> ID }}" class="modal fade edit" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">

                      <h2 class="modal-title"
                        style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;">
                        แก้ไขข้อมูลการศึกษา</h2>
                    </div>
                    <div class="modal-body">

                      <body>
                        <form method="post" id="form_edit{{ $infoeducation -> ID }}"
                          action="{{ route('addedu.edit') }}">
                          @csrf
                          <input type="hidden" name="ID" value="{{ $infoeducation -> ID }}" />
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-3 text-left">
                                <label>การศึกษา</label>
                              </div>
                              <div class="col-sm-9">
                                <select name="VUT_ID_edit" id="VUT_ID_edit"
                                  class="form-control input-lg {{ $errors->has('VUT_ID_edit') ? 'is-invalid' : '' }}"
                                  style=" font-family: 'Kanit', sans-serif;font-size: 14px;" request>

                                  @foreach ($infoprevuts as $infoprevut)

                                  @if($infoprevut -> VUT_ID == $infoeducation -> VUT_ID )
                                  <option value=" {{ $infoprevut -> VUT_ID }}" selected>{{ $infoprevut -> VUT_NAME }}
                                  </option>
                                  @else
                                  <option value=" {{ $infoprevut -> VUT_ID }}">{{ $infoprevut -> VUT_NAME }}</option>
                                  @endif
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-3 text-left">
                                <label>จบจากสถาบัน</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="UNIVER_NAME_edit" id="UNIVER_NAME_edit"
                                  class="form-control input-lg {{ $errors->has('UNIVER_NAME_edit') ? 'is-invalid' : '' }}"
                                  style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                                  value="{{ $infoeducation -> UNIVER_NAME }}" request>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-3 text-left">
                                <label>คณะ</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="FAUCULTY_edit" id="FAUCULTY_edit"
                                  class="form-control input-lg {{ $errors->has('FAUCULTY_edit') ? 'is-invalid' : '' }}"
                                  style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                                  value="{{ $infoeducation -> FAUCULTY }}">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-3 text-left">
                                <label>สาขา</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="LAVEL_edit" id="LAVEL_edit"
                                  class="form-control input-lg {{ $errors->has('LAVEL_edit') ? 'is-invalid' : '' }}"
                                  style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                                  value="{{ $infoeducation -> LAVEL }}">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-3 text-left">
                                <label>เกรดเฉลี่ย</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="GRADE_edit" id="GRADE_edit"
                                  class="form-control input-lg {{ $errors->has('GRADE_edit') ? 'is-invalid' : '' }}"
                                  OnKeyPress="return chkmunny(this)"
                                  style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                                  value="{{ $infoeducation -> GRADE }}">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-3 text-left">
                                <label>วันเริ่มศึกษา</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="START_DATE_edit" id="START_DATE_edit"
                                  class="form-control input-lg datepicker3 {{ $errors->has('START_DATE_edit') ? 'is-invalid' : '' }}"
                                  data-date-format="mm/dd/yyyy"
                                  style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                                  value="{{ formate($infoeducation -> START_DATE) }}" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-3 text-left">
                                <label>วันสำเร็จการศึกษา</label>
                              </div>
                              <div class="col-sm-9">
                                <input name="CON_DATE_edit" id="CON_DATE_edit"
                                  class="form-control input-lg datepicker4 {{ $errors->has('CON_DATE_edit') ? 'is-invalid' : '' }}"
                                  data-date-format="mm/dd/yyyy"
                                  style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                                  value="{{ formate($infoeducation -> CON_DATE) }}" readonly>
                              </div>
                            </div>
                          </div>

                          <input type="hidden" name="PERSON_ID" id="PERSON_ID"
                            value="{{ $inforpersonusereducatid ->ID }} ">
                          <input type="hidden" name="USER_EDIT_ID" id="USER_EDIT_ID" value="{{ $id_user }} ">


                    </div>
                    <div class="modal-footer">
                      <div align="right">
                        <span type="button" class="btn btn-hero-sm btn-hero-info btn btn-submit-edit"
                          onclick="editnumber({{ $infoeducation -> ID }});"><i class="fas fa-save"></i>
                          &nbsp;บันทึกแก้ไขข้อมูล</span>
                        <span type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal"><i
                            class="fas fa-window-close"></i> &nbsp;ยกเลิก</span>
                      </div>
                    </div>
                    </form>
                    </body>


                  </div>
                </div>
              </div>
              <?php $number++; ?>

              @endforeach
            </tbody>
          </table>



          <div class="modal fade add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <div class="modal-header">

                  <h2 class="modal-title"
                    style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;">
                    เพิ่มข้อมูลการศึกษา</h2>
                </div>
                <div class="modal-body">

                  <body>
                    <form method="post" id="form_add" action="{{ route('addedu.save') }}">
                      @csrf
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3 text-left">
                            <label>การศึกษา</label>
                          </div>
                          <div class="col-sm-9">
                            <select name="VUT_ID" id="VUT_ID"
                              class="form-control input-lg {{ $errors->has('VUT_ID') ? 'is-invalid' : '' }}"
                              style=" font-family: 'Kanit', sans-serif;font-size: 14px;">
                              <option value="">--กรุณาเลือกการศึกษา--</option>
                              @foreach ($infoprevuts as $infoprevut)
                              <option value="{{ $infoprevut ->VUT_ID  }}">{{ $infoprevut->VUT_NAME  }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3 text-left">
                            <label>จบจากสถาบัน</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="UNIVER_NAME" id="UNIVER_NAME"
                              class="form-control input-lg {{ $errors->has('UNIVER_NAME') ? 'is-invalid' : '' }}"
                              style=" font-family: 'Kanit', sans-serif;font-size: 14px;" request>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3 text-left">
                            <label>คณะ</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="FAUCULTY" id="FAUCULTY"
                              class="form-control input-lg {{ $errors->has('FAUCULTY') ? 'is-invalid' : '' }}"
                              style=" font-family: 'Kanit', sans-serif;font-size: 14px;" request>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3 text-left">
                            <label>สาขา</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="LAVEL" id="LAVEL"
                              class="form-control input-lg {{ $errors->has('LAVEL') ? 'is-invalid' : '' }}"
                              style=" font-family: 'Kanit', sans-serif;font-size: 14px;" request>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3 text-left">
                            <label>เกรดเฉลี่ย</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="GRADE" id="GRADE"
                              class="form-control input-lg {{ $errors->has('GRADE') ? 'is-invalid' : '' }}"
                              OnKeyPress="return chkmunny(this)"
                              style=" font-family: 'Kanit', sans-serif;font-size: 14px;" request>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3 text-left">
                            <label>วันเริ่มศึกษา</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="START_DATE" id="START_DATE"
                              class="form-control input-lg datepicker {{ $errors->has('START_DATE') ? 'is-invalid' : '' }}"
                              data-date-format="mm/dd/yyyy" style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                              value=" " request readonly>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3 text-left">
                            <label>วันสำเร็จการศึกษา</label>
                          </div>
                          <div class="col-sm-9">
                            <input name="CON_DATE" id="CON_DATE"
                              class="form-control input-lg datepicker2 {{ $errors->has('CON_DATE') ? 'is-invalid' : '' }}"
                              data-date-format="mm/dd/yyyy" style=" font-family: 'Kanit', sans-serif;font-size: 14px;"
                              value=" " request readonly>
                          </div>
                        </div>
                      </div>

                      <input type="hidden" name="PERSON_ID" id="PERSON_ID" value="{{ $inforpersonusereducatid ->ID }} ">
                      <input type="hidden" name="USER_EDIT_ID" id="USER_EDIT_ID" value="{{ $id_user }} ">

                </div>
                <div class="modal-footer">
                  <div align="right">
                    <span type="button" class="btn btn-hero-sm btn-hero-info btn-submit-add"><i class="fas fa-save"></i>
                      &nbsp; บันทึกข้อมูล</span>
                    <span type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> &nbsp;ยกเลิก</span>
                  </div>
                </div>
                </form>
                </body>


              </div>
            </div>
          </div>
          <br>


        </div>

      </div>





      @endsection

      @section('footer')

      <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
      <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
      <script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

      <script>
        $('#edit_modal').on('show.bs.modal', function (e) {
          var Id = $(e.relatedTarget).data('id');
          var VUTId = $(e.relatedTarget).data('vutid');
          $(e.currentTarget).find('input[name="ID"]').val(Id);
          $(e.currentTarget).find('select[id="VUT_ID_edit[]"]').val(VUTId);

        });
      </script>

      <script>
        $(document).ready(function () {

          $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true,
            autoclose: true //Set เป็นปี พ.ศ.
          }).datepicker("setDate", 0); //กำหนดเป็นวันปัจุบัน
        });

        $(document).ready(function () {

          $('.datepicker2').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true,
            autoclose: true //Set เป็นปี พ.ศ.
          }).datepicker("setDate", 0); //กำหนดเป็นวันปัจุบัน
        });

        $(document).ready(function () {

          $('.datepicker3').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true,
            autoclose: true //Set เป็นปี พ.ศ.
          }); //กำหนดเป็นวันปัจุบัน
        });

        $(document).ready(function () {

          $('.datepicker4').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true,
            autoclose: true //Set เป็นปี พ.ศ.
          }); //กำหนดเป็นวันปัจุบัน
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

        function editnumber(number) {
          var form = $('#form_edit' + number);
          formSubmit(form)
        }


        $('.btn-submit-add').click(function (e) {


          // เมื่อไม่มีค่าว่าง.o9kik'
          var form = $('#form_add');
          formSubmit(form)

        });



        // $('.btn-submit-edit').click(function (e) { 
        //             var form = $('#form_edit');
        //             formSubmit(form)      
        //             });
      </script>



      @endsection