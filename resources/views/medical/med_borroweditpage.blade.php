@extends('layouts.medicalslide')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
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
    $date = date('Y-m-d');
    ?>
    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div>
        <div class="main-card mb-3 card">
            <div class="card-header">
                แก้ไขทะเบียนยืม-คืน เครื่องมือแพทย์
                <div class="btn-actions-pane-right">
                    <div class="nav">
                        {{-- <a href="{{ url('medical/med_add') }}"
                            class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                            <i class="fa-solid fa-folder-plus text-primary me-2"></i>
                            เพิ่มเครื่องมือแพทย์
                        </a> --}}
                    </div>
                </div>
            </div>
                   
                    <div class="card-body mt-2">
                        <form class="custom-validation" action="{{ route('med.med_borrowupdate_Noalert') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="">วันที่ยืม</label>
                                    <div class="form-group mt-2">
                                        <input type="date" name="medical_borrow_date"
                                            id="edit_medical_borrow_date"
                                            class="form-control form-control-sm"
                                            value="{{ $borrow->medical_borrow_date }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">รายการ</label>
                                    <div class="form-group mt-2">
                                        <select name="medical_borrow_article_id"
                                            id="edit_medical_borrow_article_id"
                                            class="form-control form-control-sm "
                                            style="width: 100%" required>
                                            <option value="">=เลือก=</option>
                                            @foreach ($article_data as $ar)
                                                @if ($borrow->medical_borrow_article_id == $ar->article_id)
                                                    <option value="{{ $ar->article_id }}"
                                                        selected>{{ $ar->article_num }}
                                                        {{ $ar->article_name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $ar->article_id }}">
                                                        {{ $ar->article_num }}
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
                                        <input type="number" name="medical_borrow_qty"
                                            id="edit_medical_borrow_qty"
                                            class="form-control form-control-sm text-end"
                                            value="{{ $borrow->medical_borrow_qty }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">หน่วยงานที่ยืม</label>
                                    <div class="form-group mt-2">
                                        <select name="medical_borrow_debsubsub_id"
                                            id="edit_medical_borrow_debsubsub_id"
                                            class="form-control form-control-sm"
                                            style="width: 100%" required>
                                            <option value="">=เลือก=</option>
                                            @foreach ($department_sub_sub as $deb)
                                                @if ($borrow->medical_borrow_debsubsub_id == $deb->DEPARTMENT_SUB_SUB_ID)
                                                    <option
                                                        value="{{ $deb->DEPARTMENT_SUB_SUB_ID }}"
                                                        selected>
                                                        {{ $deb->DEPARTMENT_SUB_SUB_NAME }}
                                                    </option>
                                                @else
                                                    <option
                                                        value="{{ $deb->DEPARTMENT_SUB_SUB_ID }}">
                                                        {{ $deb->DEPARTMENT_SUB_SUB_NAME }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div> 

                            <input type="hidden" id="edit_medical_borrow_users_id" name="medical_borrow_users_id" value="{{ $iduser }}">
                            <input type="hidden" id="edit_medical_borrow_id" name="medical_borrow_id" value="{{ $borrow->medical_borrow_id }}"> 
            
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 text-end"> 
                            <div class="form-group">
                                <button type="submit" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    แก้ไขข้อมูล
                                </button> 
                                <a href="{{ url('medical/med_borrow') }}"
                                    class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                    <i class="fa-solid fa-xmark me-2"></i>
                                    ยกเลิก
                                </a>
                            </div>
                   
                        </div>   
                    </div>


                    <form>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer')
 <script>
       
        $('#edit_medical_borrow_debsubsub_id').select2({ 
        });

        $('#edit_medical_borrow_article_id').select2({ 
        });

        
 </script>
 

@endsection
