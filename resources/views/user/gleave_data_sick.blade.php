@extends('layouts.user')
@section('title', 'ZOffice || ลาป่วย')
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
    ?>
    <div class="container-fluid">
        <div class="px-0 py-0 border-bottom mb-2">
            <div class="d-flex flex-wrap justify-content-center">
                <a href="{{ url('user/gleave_data_add') }}"
                    class="btn btn-light col-4 col-lg-auto mb-2 mb-lg-0 me-lg-auto text-dark me-2">
                    <i class="fa-solid fa-angles-left text-danger"> </i>
                    ย้อนกลับ
                </a>

                <div class="text-end">
                    <a type="button" class="btn btn-primary"> ลาป่วย</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('ลาป่วย') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">ปีงบประมาณ</label>
                                    <select id="depsub" name="dep_subid" class="form-control form-control department_sub"
                                        style="width: 100%">
                                        <option value=""></option>
                                        <option value="STAFF">STAFF</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="CUSTOMER">CUSTOMER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">ลาตั้งแต่วันที่</label>
                                    <input id="start_date" type="date" class="form-control datepicker" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">ถึงวันที่</label>
                                    <input id="start_date" type="date" class="form-control datepicker" name="start_date">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">สถานที่ไป</label>
                                    <select id="depsub" name="dep_subid" class="form-control form-control department_sub"
                                        style="width: 100%">
                                        <option value=""></option>
                                        <option value="1">ภายในจังหวัด</option>
                                        <option value="2">ต่างจังหวัด</option>
                                        <option value="3">ต่างประเทศ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">ลาเต็มวัน/ครึ่งวัน</label>
                                    <select id="depsub" name="dep_subid" class="form-control form-control department_sub"
                                        style="width: 100%">
                                        <option value=""></option>
                                        <option value="1">เต็มวัน</option>
                                        <option value="2">ครึ่งวันเช้า</option>
                                        <option value="CUSTOMER">ครึ่งวันบ่าย</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">เบอร์โทรติดต่อ</label>
                                    <input id="start_date" type="text" class="form-control" name="start_date">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">มอบหมายงานไห้</label>
                                    <select id="depsub" name="dep_subid" class="form-control form-control department_sub"
                                        style="width: 100%">
                                        <option value=""></option>
                                        <option value="STAFF">STAFF</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="CUSTOMER">CUSTOMER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">หัวหน้างาน </label>
                                    <select id="depsub" name="dep_subid" class="form-control form-control department_sub"
                                        style="width: 100%">
                                        <option value=""></option>
                                        <option value="STAFF">STAFF</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="CUSTOMER">CUSTOMER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">หัวหน้าฝ่าย/กลุ่มงาน </label>
                                    <select id="depsub" name="dep_subid" class="form-control form-control department_sub"
                                        style="width: 100%">
                                        <option value=""></option>
                                        <option value="STAFF">STAFF</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="CUSTOMER">CUSTOMER</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">เหตุผลการลา</label>
                                    <textarea id="start_date" class="form-control" name="start_date" style="height: 100px"> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary ">
                                <i class="fa-solid fa-floppy-disk me-3"></i>Save
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
