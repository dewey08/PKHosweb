@extends('layouts.user')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function med_borrowupdate_status(medical_borrow_id)
        {
        Swal.fire({
        title: 'ต้องการจัดสรรให้ยืมใช่ไหม?',
        text: "จัดสรรให้ยืมได้ !!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, จัดสรรเดี๋ยวนี้ !',
        cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            url:"{{url('medical/med_borrowupdate_status')}}" +'/'+ medical_borrow_id,  
            type:'POST',
            data:{
                _token : $("input[name=_token]").val()
            },
            success:function(response)
            {          
                Swal.fire({
                    title: 'จัดสรรสำเร็จ!',
                    text: "You Update data success",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#06D177',
                    // cancelButtonColor: '#d33',
                    confirmButtonText: 'เรียบร้อย'
                }).then((result) => {
                    if (result.isConfirmed) {                  
                    $("#sid"+medical_borrow_id).remove();     
                    window.location.reload();  
                    }
                }) 
            }
            })        
            }
            })
        }
    </script>
    <style>
        .table th {
            font-family: sans-serif;
            font-size: 12px;
        }

        .table td {
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
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
    $date = date('Y-m-d');
    ?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <form action="{{ url('user_article_borrow') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="startdate"
                                    id="startdate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $startdate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd" name="enddate"
                                    id="enddate" data-date-format="yyyy-mm-dd" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" value="{{ $enddate }}">

                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>
                                ค้นหา
                            </button>
                        </div>
                        <div class="col"></div>
                         
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        {{-- <div class="col-xl-2"> </div> --}}
        <div class="col-xl-12">
            {{-- <label for="">รายงานจำนวนผู้ป่วยนอก OFC  ไม่มีเลข ใน HOSxP </label> --}}
            <div class="card shadow-lg">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>ทะเบียนยืม-คืน </h5>
                        </div>
                        <div class="col"></div>
                        {{-- <div class="col-md-1 text-end">
                             <label for="" style="font-size: 17px">สถานะสี</label>
                        </div>
                        <div class="col-md-2">
                           <button type="button" class="btn ms-3 text-white" style="background-color: rgb(181, 218, 236)">ร้องขอ</button>
                           <button type="button" class="btn ms-3 text-white" style="background-color: rgb(38, 202, 194)">อนุมัติ</button> 
                       </div> --}}
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#insertborrowdata">
                                <i class="fa-solid fa-microscope me-2"></i> 
                                ยืม
                            </button>
                            {{-- <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#insertuserdata">
                                คืน
                            </button> --}}
                        </div>

                    </div>
                </div>
                <div class="card-body shadow-lg mt-2">
                    <div class="table-responsive">
                        <table style="width: 100%;" id="example"
                            class="table table-hover table-striped table-bordered myTable">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">วันที่ยืม</th>
                                    <th class="text-center">วันที่คืน</th>
                                    <th class="text-center">รายการ</th>
                                    <th class="text-center">หน่วยงานที่ยืม</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($medical_borrow as $item)
                                    <?php
                                    
                                    $colorstatus = $item->medical_borrow_active;
                                    if ($colorstatus == 'REQUEST') {
                                        $color_new = 'background-color: rgb(181, 236, 234)';
                                    } elseif ($colorstatus == 'APPROVE') {
                                        $color_new = 'background-color: rgb(38, 202, 194)';
                                        // } elseif ($colorstatus == 'REPFINISH') {
                                        //     $color_new = 'background-color: rgb(156, 219, 7)';
                                        // } elseif ($colorstatus == 'REQUEST') {
                                        //     $color_new = ' ';
                                    } else {
                                        $color_new = 'background-color: rgb(107, 180, 248)';
                                    }
                                    
                                    ?>
                                    <tr id="sid{{ $item->medical_borrow_id }}">
                                        <td width="5%">{{ $i++ }}</td>
                                        <td class="text-center" width="5%">

                                            @if ($item->medical_borrow_active == 'REQUEST')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color: rgb(235, 81, 10);font-size:13px;color:white">ร้องขอ
                                                </button>
                                            @elseif ($item->medical_borrow_active == 'SENDEB')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color: rgb(89, 10, 235);font-size:13px;color:white">ส่งคืน
                                                </button>
                                            @elseif ($item->medical_borrow_active == 'APPROVE')
                                                <button type="button" class="btn btn-sm"
                                                    style="background-color:rgb(10, 235, 160);font-size:13px;color:white">จัดสรร
                                                </button>
                                            @else
                                               
                                            @endif
                                        </td>
                                        <td width="9%" class="text-center"> {{ $item->medical_borrow_date }}</td>
                                        <td width="9%" class="text-center">{{ $item->medical_borrow_backdate }}</td>
                                        <td class="p-2">{{ $item->article_name }}</td>
                                        <td class="p-2">{{ $item->DEPARTMENT_SUB_SUB_NAME }}</td>
                                        <td class="text-center" width="10%">
                                            @if ($item->medical_borrow_active == 'REQUEST')
                                            <a class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editdata{{ $item->medical_borrow_id }}" 
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                            <i class="fa-solid fa-file-pen text-info"></i>
                                            <label for="" style="color: rgb(33, 187, 248)">แก้ไข</label>
                                        </a>
                                            {{-- <a class="btn btn-outline-warning btn-sm" href="javascript:void(0)"
                                            onclick="med_borrowupdate_status({{ $item->medical_borrow_id }})"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="จัดสรร">
                                            <i class="fa-solid fa-file-pen text-info"></i>
                                            <label for="" style="color: rgb(33, 187, 248)">จัดสรร</label>
                                        </a> --}}
                                        {{-- @elseif ($item->medical_borrow_active == 'APPROVE')
                                        <button type="button" class="btn btn-outline-warning btn-sm editData" value="{{ $item->medical_borrow_id }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="ส่งคืน"> 
                                            <i class="fa-solid fa-file-pen text-primary"></i>
                                            <label for="" style="color: rgb(33, 108, 248)">ส่งคืน</label>
                                        </button> --}}
                                        @else
                                        <button type="button" class="btn btn-outline-warning btn-sm editData2" value="{{ $item->medical_borrow_id }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด"> 
                                            <i class="fa-solid fa-file-pen" style="color: rgb(135, 19, 202)"></i>
                                            <label for="" style="color: rgb(135, 19, 202)">รายละเอียด</label>
                                        </button>
                                        @endif
                                              
                                        </td>
                                    </tr>

                                        <!--  Modal content for the editdata example -->
                                        <div class="modal fade" id="editdata{{ $item->medical_borrow_id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myExtraLargeModalLabel">แก้ไขบันทึกทะเบียนยืม</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <form class="custom-validation" action="{{ route('article.user_article_borrowupdate') }}" method="POST"
                                                        id="Update_borrowbtnForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-md-2">
                                                            <label for="">วันที่ยืม</label>
                                                            <div class="form-group mt-2">
                                                                <input type="date" name="medical_borrow_date" id="edit_medical_borrow_date"
                                                                    class="form-control form-control-sm" value="{{$item->medical_borrow_date}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">รายการ</label>
                                                            <div class="form-group mt-2">
                                                                <select name="medical_borrow_article_id" id="edit_medical_borrow_article_id"
                                                                    class="form-control form-control-sm" style="width: 100%" required>
                                                                    <option value="">=เลือก=</option>
                                                                    @foreach ($article_data as $ar)
                                                                    @if ($item->medical_borrow_article_id == $ar->article_id)
                                                                    <option value="{{ $ar->article_id }}" selected>{{ $ar->article_num }}
                                                                        {{ $ar->article_name }}
                                                                    </option>
                                                                    @else
                                                                    <option value="{{ $ar->article_id }}">{{ $ar->article_num }}
                                                                        {{ $ar->article_name }}
                                                                    </option>
                                                                    @endif
                                                                        
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label for="">จำนวน</label>
                                                            <div class="form-group mt-2">
                                                                <input type="number" name="medical_borrow_qty" id="edit_medical_borrow_qty"
                                                                    class="form-control form-control-sm text-end" value="{{$item->medical_borrow_qty}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">หน่วยงานที่ยืม</label>
                                                            <div class="form-group mt-2">
                                                                <select name="medical_borrow_debsubsub_id" id="edit_medical_borrow_debsubsub_id"
                                                                    class="form-control form-control-sm" style="width: 100%" required>
                                                                    <option value="">=เลือก=</option>
                                                                    @foreach ($department_sub_sub as $deb)
                                                                    @if ($item->medical_borrow_debsubsub_id == $deb->DEPARTMENT_SUB_SUB_ID)
                                                                    <option value="{{ $deb->DEPARTMENT_SUB_SUB_ID }}" selected>
                                                                        {{ $deb->DEPARTMENT_SUB_SUB_NAME }}
                                                                    </option>
                                                                    @else
                                                                    <option value="{{ $deb->DEPARTMENT_SUB_SUB_ID }}">
                                                                        {{ $deb->DEPARTMENT_SUB_SUB_NAME }}
                                                                    </option>
                                                                    @endif
                                                                       
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <input type="hidden" id="medical_borrow_users_id" name="edit_medical_borrow_users_id" value="{{ $iduser }}">

                                                <div class="modal-footer">
                                                    <div class="col-md-12 text-end">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                {{-- <button type="button" id="Update_borrowbtn" class="btn btn-primary btn-sm"> --}}
                                                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                                                บันทึกข้อมูล
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        </div>

                                    </form>

                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--  Modal content for the insertborrowdata example -->
    <div class="modal fade" id="insertborrowdata" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">บันทึกทะเบียนยืม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-2">
                            <label for="">วันที่ยืม</label>
                            <div class="form-group mt-2">
                                <input type="date" name="medical_borrow_date" id="medical_borrow_date"
                                    class="form-control form-control-sm" value="{{$date}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">รายการ</label>
                            <div class="form-group mt-2">
                                <select name="medical_borrow_article_id" id="medical_borrow_article_id"
                                    class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($article_data as $ar)
                                        <option value="{{ $ar->article_id }}">{{ $ar->article_num }}
                                            {{ $ar->article_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="">จำนวน</label>
                            <div class="form-group mt-2">
                                <input type="number" name="medical_borrow_qty" id="medical_borrow_qty"
                                    class="form-control form-control-sm text-end">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">หน่วยงานที่ยืม</label>
                            <div class="form-group mt-2">
                                <select name="medical_borrow_debsubsub_id" id="medical_borrow_debsubsub_id"
                                    class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($department_sub_sub as $deb)
                                        <option value="{{ $deb->DEPARTMENT_SUB_SUB_ID }}">
                                            {{ $deb->DEPARTMENT_SUB_SUB_NAME }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" id="medical_borrow_users_id" name="medical_borrow_users_id"
                    value="{{ $iduser }}">
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="Savebtn" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

     <!--  Modal content for the updateborrowdata example -->
     <div class="modal fade" id="updateborrowdata"
        tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">ส่งคืน
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">  
                    <div class="row mt-3"> 
                        <div class="col-md-3">
                            <label for="">วันที่ยืม :</label>
                            <div class="form-group mt-2">  
                                <input type="date" name="medical_borrow_date" id="editmedical_borrow_date" class="form-control form-control-sm" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="">วันที่ส่งคืน</label>
                            <div class="form-group mt-2">
                                <input type="date" name="medical_borrow_backdate"
                                    id="editmedical_borrow_backdate"
                                    class="form-control form-control-sm" >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="">ผู้ส่งคืน</label>
                            <div class="form-group mt-2">
                                <select name="medical_borrow_backusers_id"
                                    id="editmedical_borrow_backusers_id"
                                    class="form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">=เลือก=</option>
                                    @foreach ($users as $ut)
                                        <option value="{{ $ut->id }}">
                                            {{ $ut->fname }} {{ $ut->lname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                
                <input type="hidden" id="medical_borrow_users_id" name="editmedical_borrow_users_id" value="{{ $iduser }}">
                    
                <input type="hidden" id="editmedical_borrow_id" name="medical_borrow_id" >
                    

                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <div class="form-group">
                            <button type="button" id="Updatebtn"
                                class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-floppy-disk me-2"></i>
                                บันทึกข้อมูล
                            </button>
                            <button type="button" class="btn btn-danger btn-sm"
                                data-bs-dismiss="modal"><i
                                    class="fa-solid fa-xmark me-2"></i>Close</button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

      <!--  Modal content for the detailborrowdata example -->
      <div class="modal fade" id="detailborrowdata" tabindex="-1" role="dialog"
      aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="myExtraLargeModalLabel">รายละเอียดทะเบียนยืม-คืน</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-md-2">
                          <label for="">วันที่ยืม</label>
                          <div class="form-group mt-2">
                              <input type="text" name="medical_borrow_date" id="detailmedical_borrow_date"
                                  class="form-control form-control-sm" readonly>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <label for="">รายการ</label>
                          <div class="form-group mt-2">
                            <input type="text" name="medical_borrow_article_id" id="detailmedical_borrow_article_id"
                            class="form-control form-control-sm" readonly>
                              
                          </div>
                      </div>

                      <div class="col-md-2">
                          <label for="">จำนวน</label>
                          <div class="form-group mt-2">
                              <input type="text" name="medical_borrow_qty" id="detailmedical_borrow_qty"
                                  class="form-control form-control-sm text-end" readonly>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <label for="">หน่วยงานที่ยืม</label>
                          <div class="form-group mt-2">
                            <input type="text" name="medical_borrow_debsubsub_id" id="detailmedical_borrow_debsubsub_id"
                                  class="form-control form-control-sm" readonly>
                              
                          </div>
                      </div>

                  </div>
                  <div class="row mt-3">
                    <div class="col-md-2">
                        <label for="">วันที่คืน</label>
                        <div class="form-group mt-2">
                            <input type="text" name="medical_borrow_backdate" id="detailmedical_borrow_backdate"
                                class="form-control form-control-sm" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">ผู้ส่งคืน</label>
                        <div class="form-group mt-2">
                          <input type="text" name="medical_borrow_backusers_id" id="detailmedical_borrow_backusers_id"
                          class="form-control form-control-sm" readonly>
                            
                        </div>
                    </div>
  
                </div>
              </div>
              <input type="hidden" id="medical_borrow_users_id" name="detailmedical_borrow_users_id"
                  value="{{ $iduser }}">
              <div class="modal-footer">
                  <div class="col-md-12 text-end">
                      <div class="form-group">
                          
                          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                  class="fa-solid fa-xmark me-2"></i>Close</button>

                      </div>
                  </div>
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
            
            $('#medical_borrow_article_id').select2({
                dropdownParent: $('#insertborrowdata')
            });
            $('#medical_borrow_debsubsub_id').select2({
                dropdownParent: $('#insertborrowdata')
            });

            $('#editmedical_borrow_backusers_id').select2({
                dropdownParent: $('#updateborrowdata')
            });
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#Savebtn').click(function() {
                var medical_borrow_date = $('#medical_borrow_date').val();
                var medical_borrow_article_id = $('#medical_borrow_article_id').val();
                var medical_borrow_qty = $('#medical_borrow_qty').val();
                var medical_borrow_debsubsub_id = $('#medical_borrow_debsubsub_id').val();
                var medical_borrow_users_id = $('#medical_borrow_users_id').val();
                $.ajax({
                    url: "{{ route('article.user_article_borrowsave') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        medical_borrow_date,
                        medical_borrow_article_id,
                        medical_borrow_qty,
                        medical_borrow_debsubsub_id,
                        medical_borrow_users_id
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'บันทึกข้อมูลสำเร็จ',
                                text: "You Insert data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);
                                    window.location.reload();
                                }
                            })
                        } else {

                        }

                    },
                });
            });

            // $(document).on('click', '.editData', function() {
            //     var medical_borrow_id = $(this).val();

            //     // alert(medical_borrow_id);
            //     $('#updateborrowdata').modal('show');
            //     $.ajax({
            //         type: "GET",
            //         url: "{{ url('medical/med_borrowedit') }}" + '/' + medical_borrow_id,
            //         success: function(data) { 
            //             $('#editmedical_borrow_date').val(data.borrow.medical_borrow_date)
            //             $('#editmedical_borrow_backdate').val(data.borrow.medical_borrow_backdate)
            //             $('#editmedical_borrow_backusers_id').val(data.borrow.medical_borrow_backusers_id) 
            //             $('#editmedical_borrow_id').val(data.borrow.medical_borrow_id)
            //         },
            //     });
            // });
            // $('#Update_borrowbtn').click(function() {
            //     var medical_borrow_date = $('#edit_medical_borrow_date').val();
            //     var medical_borrow_qty = $('#edit_medical_borrow_qty').val(); 
            //     var medical_borrow_debsubsub_id = $('#edit_medical_borrow_debsubsub_id').val();
            //     var medical_borrow_article_id = $('#edit_medical_borrow_article_id').val();
            //     var medical_borrow_id = $('#editmedical_borrow_id').val();                
           
            //     $.ajax({
            //         url: "{{ route('article.user_article_borrowupdate') }}",
            //         type: "POST",
            //         dataType: 'json',
            //         data: {
            //             medical_borrow_date,
            //             medical_borrow_qty,
            //             medical_borrow_debsubsub_id,
            //             medical_borrow_article_id,
            //             medical_borrow_id
            //         },
            //         success: function(data) {
            //             if (data.status == 200) {
            //                 Swal.fire({
            //                     title: 'บันทึกข้อมูลสำเร็จ',
            //                     text: "You Insert data success",
            //                     icon: 'success',
            //                     showCancelButton: false,
            //                     confirmButtonColor: '#06D177',
            //                     confirmButtonText: 'เรียบร้อย'
            //                 }).then((result) => {
            //                     if (result
            //                         .isConfirmed) {
            //                         console.log(
            //                             data);
            //                         window.location.reload();
            //                     }
            //                 })
            //             } else {

            //             }

            //         },
            //     });
            // });

            // $(document).on('click', '.editData2', function() {
            //     var medical_borrow_id = $(this).val();

            //     // alert(medical_borrow_id);
            //     $('#detailborrowdata').modal('show');
            //     $.ajax({
            //         type: "GET",
            //         url: "{{ url('medical/med_borrowedit') }}" + '/' + medical_borrow_id,
            //         success: function(data) { 
            //             $('#detailmedical_borrow_date').val(data.borrow.medical_borrow_date)
            //             $('#detailmedical_borrow_backdate').val(data.borrow.medical_borrow_backdate)
            //             $('#detailmedical_borrow_backusers_id').val(data.borrow.fname) 
            //             $('#detailmedical_borrow_id').val(data.borrow.medical_borrow_id)

            //             $('#detailmedical_borrow_article_id').val(data.borrow.article_name)
            //             $('#detailmedical_borrow_qty').val(data.borrow.medical_borrow_qty)
            //             $('#detailmedical_borrow_debsubsub_id').val(data.borrow.DEPARTMENT_SUB_SUB_NAME)
            //         },
            //     });
            // });
          

        });
    </script>
    <script>
         $(document).ready(function() {
        $('#Update_borrowbtnForm').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                // alert('OJJJJOL');
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You Edit data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        } else {

                        }
                    }
                });
            });
        });
    </script>

@endsection
