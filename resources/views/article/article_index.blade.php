@extends('layouts.articleslide')

@section('title', 'PK-OFFICER || ครุภัณฑ์')
{{-- @section('menu') --}}
<style>
    .btn {
        font-size: 15px;
    }
</style>
<?php
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\DB;
$count_land = StaticController::count_land();
$count_building = StaticController::count_building();
$count_article = StaticController::count_article();
?>

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function article_destroy(article_id) {
            Swal.fire({
                title: 'ต้องการลบใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบไปเลย !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('article/article_destroy') }}" + '/' + article_id,
                        type: 'DELETE',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'ลบข้อมูล!',
                                text: "You Delet data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                // cancelButtonColor: '#d33',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#sid" + article_id).remove();
                                    // window.location.reload();
                                    window.location = "{{ url('article/article_index') }}";
                                }
                            })
                        }
                    })
                }
            })
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
    <?php
    use App\Http\Controllers\ArticleController;
    $refnumber = ArticleController::refnumber();
    ?>
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
     <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>

        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">

                                <label for="">ข้อมูลครุภัณฑ์</label>

                            <div class="btn-actions-pane-right">
                                <a href="{{ url('article/article_index_add') }}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                    <i class="fa-solid fa-folder-plus text-info me-2"></i>
                                เพิ่มข้อมูลครุภัณฑ์
                            </a>
                            </div>

                    </div>

                    <div class="card-body shadow">

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            {{-- <table class="table table-hover table-bordered table-sm myTable" style="wproduct_idth: 100%;"
                                id="table_id"> --}}
                                {{-- <table class="table table-hover table-bordered border-primary" style="wproduct_idth: 100%;" product_id="table_id"> เส้นสีฟ้า --}}
                                <thead>
                                    <tr height="10px" style="font-size: 14px;">
                                        <th width="4%" class="text-center">ลำดับ</th>
                                        <th width="14%" class="text-center">รหัสครุภัณฑ์</th>
                                        <th class="text-center">รายการครุภัณฑ์</th>
                                        {{-- <th width="15%" class="text-center">ประเภทค่าเสื่อม</th> --}}
                                        <th width="15%" class="text-center">หมวดครุภัณฑ์</th>
                                        <th width="20%" class="text-center">ประจำหน่วยงาน</th>
                                        <th width="10%" class="text-center">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    $date = date('Y');
                                    ?>
                                    @foreach ($article_data as $item)
                                       <tr height="20" style="font-size: 14px;" id="sid{{ $item->article_id }}">
                                            <td class="text-center" width="4%">{{ $i++ }}</td>
                                            <td class="p-2" width="20%">{{ $item->article_num }} </td>
                                            <td class="p-2">{{ $item->article_name }}</td>
                                            {{-- <td class="p-2" width="15%">{{ $item->article_decline_name }}</td> --}}
                                            <td class="p-2" width="19%">{{ $item->article_categoryname }}</td>
                                            <td class="p-2" width="19%">{{ $item->article_deb_subsub_name }}</td>
                                            <td class="text-center" width="7%">

                                                {{-- <div class="dropdown">
                                                    <button class="dropdown-toggle btn btn-sm text-secondary" href="#" id="dropdownMenuLink" data-mdb-toggle="dropdown" aria-expanded="false" >
                                                      ทำรายการ
                                                    </button>
                                                        <ul class="dropdown-menu " aria-labelledby="dropdownMenuLink">

                                                              <li>
                                                                <a href="{{ url('article/article_index_edit/' .$item->article_id) }}" class="text-warning me-3" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" title="แก้ไข" >
                                                                  <i class="fa-solid fa-pen-to-square me-2 mt-3 ms-4"></i>
                                                                  <label for="" style="color: black">แก้ไข</label>
                                                                </a>
                                                              </li>
                                                              <li>
                                                                <a class="text-danger" href="javascript:void(0)" onclick="article_destroy({{ $item->article_id }})">
                                                                  <i class="fa-solid fa-trash-can me-2 mt-3 ms-4 mb-4"></i>
                                                                  <label for="" style="color: black">ลบ</label>
                                                                </a>
                                                              </li>
                                                        </ul>
                                                </div> --}}
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        ทำรายการ
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning"
                                                            href="{{ url('article/article_index_edit/' . $item->article_id) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-custom-class="custom-tooltip" title="แก้ไข">
                                                            <i class="fa-solid fa-pen-to-square me-2"></i>
                                                            <label for=""
                                                                style="color: rgb(252, 185, 0);font-size:13px">แก้ไข</label>
                                                        </a>

                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                            onclick="article_destroy({{ $item->article_id }})"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            data-bs-custom-class="custom-tooltip" title="ลบ">
                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                            <label for=""
                                                                style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">



                <!-- Modal -->
                <div class="modal fade" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="articleModalLabel">เลขหมวดครุภัณฑ์</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input class="form-control" id="myInput" type="text" placeholder="ค้นหา..">
                                <br>
                                <div style='overflow:scroll; height:300px;'>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td style="text-align: center;" width="20%">เลข FSN</td>
                                                <td style="text-align: center;">ชื่อพัสดุ</th>
                                                <td style="text-align: center;" width="5%">เลือก</td>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">
                                            @foreach ($product_prop as $prop)
                                                <tr>
                                                    <td>{{ $prop->fsn }}</td>
                                                    <td>{{ $prop->prop_name }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info"
                                                            onclick="selectfsn({{ $prop->prop_id }})">เลือก</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            </div>
                        </div>
                    </div>
                </div>




                @endsection
                @section('footer')

                    <script>
                        $(document).ready(function() {

                            $('#datepicker').datepicker({
                                format: 'yyyy-mm-dd'
                            });
                            $('#datepicker2').datepicker({
                                format: 'yyyy-mm-dd'
                            });

                            $('#example').DataTable();
                            $('#hospcode').select2({
                                placeholder: "--เลือก--",
                                allowClear: true
                            });
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                        });
                    </script>
                @endsection
