@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')

@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }

        function acc106destroy(acc_doc_id) {
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
                        url: "{{ url('acc107destroy') }}" + '/' + acc_doc_id,
                        type: 'POST',
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            // if (response.status == 200) {
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
                                    // $("#sid" + acc_doc_id).remove();
                                    window.location.reload();
                                    //   window.location = "/person/person_index"; //     
                                }
                            })
                            // } else {

                            // }

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
    $ynow = date('Y') + 543;
    $yb = date('Y') + 542;
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
            border-top: 10px #fd6812 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }

        .modal-dialog {
            max-width: 50%;
        }

        .modal-dialog-slideout {
            min-height: 100%;
            margin: 0 0 0 auto;
            background: #fff;
        }

        .modal.fade .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(100%, 0)scale(1);
            transform: translate(100%, 0)scale(1);
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout {
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
            display: flex;
            align-items: stretch;
            -webkit-box-align: stretch;
            height: 100%;
        }

        .modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        .modal-dialog-slideout .modal-content {
            border: 0;
        }

        .modal-dialog-slideout .modal-header,
        .modal-dialog-slideout .modal-footer {
            height: 4rem;
            display: block;
        }
    </style>
    <?php
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;
    $count_meettingroom = StaticController::count_meettingroom();
    ?>
    <div class="tabs-animation">
        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h4 class="card-title">Detail Attach File</h4>
                <p class="card-title-desc">รายละเอียดข้อมูล แนบไฟล์</p>
            </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy"
                    data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                        data-date-language="th-th" value="{{ $startdate }}" required />
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2"
                        data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true"
                        data-date-language="th-th" value="{{ $enddate }}" required />

                    <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card card p-2">
                    <div class="grid-menu-col">
                        <table id="example" class="table table-striped table-bordered "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">vn</th>
                                    <th class="text-center">an</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ptname</th>
                                    {{-- <th class="text-center">vstdate</th> --}}
                                    <th class="text-center">dchdate</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">debit_total</th>
                                    <th class="text-center">file</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                $total1 = 0; ?>
                                @foreach ($datashow as $item)
                                    <?php $number++; ?>
                                    <tr height="20">
                                    <td class="text-center" width="4%">{{ $number }}</td>
                                    <td class="text-center" width="8%">{{ $item->vn }}</td>
                                    <td class="text-center" width="7%" > {{ $item->an }} </td> 
                                    <td class="text-center" width="5%"> {{ $item->hn }}</td> 
                                    <td class="text-center" width="10%"> {{ $item->cid }}</td> 
                                    <td class="text-start"> {{ $item->ptname }}</td> 
                                    {{-- <td class="text-center" width="10%" > {{ $item->vstdate }}</td>  --}}
                                    <td class="text-center" width="10%" > {{ $item->dchdate }}</td> 
                                    <td class="text-center" width="10%" > {{ $item->pttype }}</td>
                                    <td class="text-end" width="10%" > {{ number_format($item->debit_total, 2) }}</td>  
                                    <td class="text-center" width="10%" > 
                                        @if ($item->file == '')
                                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                            <img src="{{ asset('assets/images/defailt_img.jpg' ) }}" height="30px;" width="30px" ></img>  
                                        </button> 
                                        @else
                                        <button type="button" class="btn-icon btn-shadow btn-dashed btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#FileModalshow{{ $item->acc_1102050102_107_id }}">
                                            <img src="{{ asset('storage/account_107/'.$item->filename) }}" height="30px;" width="30px" ></img> 
                                        </button> 
                                        @endif 
                                    </td>
                                    <td class="text-center" width="7%"> 
                                        <div class="dropdown d-inline-block">
                                            <button type="button" aria-haspopup="true" aria-expanded="false"
                                                data-bs-toggle="dropdown"
                                                class="me-2 dropdown-toggle btn btn-outline-primary btn-sm">
                                                ทำรายการ
                                            </button>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu"> 
                                                    {{-- <button type="button"class="dropdown-item menu editModal" value="{{ $item->acc_1102050102_107_id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="แก้ไข">
                                                        <i class="fa-solid fa-pen-to-square ms-2 me-2 text-warning"></i>
                                                        <label for="" style="font-size:12px;color: rgb(255, 185, 34)">แก้ไข</label>
                                                    </button>
                                                    <div class="dropdown-divider"></div>  --}}
                                                    <button type="button"class="dropdown-item menu"  
                                                        data-bs-toggle="modal" data-bs-target="#FileModal{{ $item->acc_1102050102_107_id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="left" title="แนบไฟล์">
                                                        <i class="fa-solid fa-clipboard-check ms-2 me-2 text-primary"></i>
                                                        <label for="" style="font-size:12px;color: rgb(40, 87, 241)">แนบไฟล์</label>
                                                    </button> 
                                                    
                                            </div>
                                        </div>
                                    </td>
                                </tr> 

                                <div class="modal fade" id="FileModalshow{{ $item->acc_1102050102_107_id }}"  tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-slideout" role="document">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addFileModalLabel">ไฟล์หนังสือยอมรับสภาพหนี้</h5>
                                                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button> --}}
                                            </div>
                                            <div class="modal-body">
                             
                            
                                                        <div class="row">
                                                    
                                                            <div class="col-md-12">
                                                                <div class="input-group text-center">  
                                                                        
                                                                        
                                                                                <?php
                                                                                $data_file_ = DB::table('acc_doc')
                                                                                    ->where('acc_doc_pangid', $item->acc_1102050102_107_id)
                                                                                    ->get();
                                                                                ?> 
                                                                                    @foreach ($data_file_ as $item3) 
                                                                                    
                                                                                        <div id="sid{{ $item3->acc_doc_id }}">
                                                                                            <iframe src="{{ asset('storage/account_107/'.$item3->filename) }}" height="900px" width="100%" ></iframe>  
                                                                                             
                                                                                        </div>
                                                                                    @endforeach
                                                                                
                                                                            
                                                                </div>                            
                                                            </div> 
                                                        </div>
                                 
                                            </div>
                                            {{-- <div class="modal-footer">
                                                <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                                                </button>
                                            </div> --}}
                            
                                        </form>
                            
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="FileModal{{ $item->acc_1102050102_107_id }}"  tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-slideout" role="document">
                                        <div class="modal-content ">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addFileModalLabel">ไฟล์หนังสือยอมรับสภาพหนี้</h5>
                                                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button> --}}
                                            </div>
                                            <div class="modal-body">
                            
                                                <form action="{{ route('acc.acc_107_file_updatefile') }}" method="POST" enctype="multipart/form-data"> 
                                                    <input type="hidden" name="account_code" id="account_code" value="{{$item->account_code}}"> 
                                                    @csrf
                                                        <div class="row">
                                                            <div class="col"></div>
                                                            <div class="col-md-8">
                                                                <div class="mb-3 mt-2">
                                                                    <label for="formFileLg" class="form-label">ไฟล์หนังสือยอมรับสภาพหนี้</label>
                                                                    <input class="form-control form-control-lg" id="formFileLg" name="file"
                                                                        type="file" required>
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>
                            
                            
                                                        <div class="row">
                                                    
                                                            <div class="col-md-12">
                                                                <div class="input-group text-center">  
                                                                        
                                                                        
                                                                                <?php
                                                                                $data_file_ = DB::table('acc_doc')
                                                                                    ->where('acc_doc_pangid', $item->acc_1102050102_107_id)
                                                                                    ->get();
                                                                                ?> 
                                                                                    @foreach ($data_file_ as $item3) 
                                                                                    
                                                                                        <div id="sid{{ $item3->acc_doc_id }}">
                                                                                            <iframe src="{{ asset('storage/account_107/'.$item3->filename) }}" height="900px" width="100%" ></iframe>  
                                                                                            
                                                                                            <a class="dropdown-item menu btn btn-outline-danger btn-sm"
                                                                                                    href="javascript:void(0)"
                                                                                                    onclick="acc106destroy({{ $item3->acc_doc_id }})"
                                                                                                    data-bs-toggle="tooltip" data-bs-toggle="custom-tooltip"
                                                                                                    data-bs-placement="top" title="ลบ">
                                                                                                    <i class="fa-solid fa-trash-can text-danger me-2"></i>
                                                                                                    <label for=""
                                                                                                        style="color: rgb(212, 10, 3)">ลบ</label>
                                                                                                </a>
                                                                                        </div>
                                                                                    @endforeach
                                                                                
                                                                            
                                                                </div>                            
                                                            </div> 
                                                        </div>
                                
                                                
                                                <input type="hidden" name="user_id" id="edituser_id"> 
                                                <input type="hidden" name="acc_1102050102_107_id" id="acc_1102050102_107_id" value="{{ $item->acc_1102050102_107_id }}"> 
                                            </div>
                                            <div class="modal-footer text-center">
                                                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                                    <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                                                </button>
                                            </div>
                            
                                        </form>
                            
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        

        <!-- Insert Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ลงใบเสร็จรับเงิน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_tri" class="form-label">ไตรมาส</label>
                                <div class="input-group input-group-sm">
                                    <select name="acc_stm_repmoney_tri" id="acc_stm_repmoney_tri"
                                        class="form-select form-control" style="width: 100%">
                                        <option value="">เลือก</option>
                                        @foreach ($trimart as $item)
                                            <option value="{{ $item->acc_trimart_id }}">{{ $item->acc_trimart_name }}
                                                {{ $item->acc_trimart_start_date }} ถึง {{ $item->acc_trimart_end_date }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_book" class="form-label">เล่มใบเสร็จ</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="acc_stm_repmoney_book"
                                        name="acc_stm_repmoney_book">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_date" class="form-label">วันที่ลงรับ</label>
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control" id="acc_stm_repmoney_date"
                                        name="acc_stm_repmoney_date">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_no" class="form-label">เลขที่ใบเสร็จ</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="acc_stm_repmoney_no"
                                        name="acc_stm_repmoney_no">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_price301" class="form-label">ยอดชดเชย 301</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="acc_stm_repmoney_price301"
                                        name="acc_stm_repmoney_price301">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_price302" class="form-label">ยอดชดเชย 302</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="acc_stm_repmoney_price302"
                                        name="acc_stm_repmoney_price302">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_price310" class="form-label">ยอดชดเชย 310</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="acc_stm_repmoney_price310"
                                        name="acc_stm_repmoney_price310">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="{{ $iduser }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                            id="Savedata">
                            <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">แก้ไขใบเสร็จรับเงิน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_tri" class="form-label">ไตรมาส</label>
                                <div class="input-group input-group-sm">
                                    <select name="acc_stm_repmoney_tri" id="editacc_stm_repmoney_tri"
                                        class="form-control" style="width: 100%">
                                        <option value="">เลือก</option>
                                        @foreach ($trimart as $item)
                                            <option value="{{ $item->acc_trimart_id }}">{{ $item->acc_trimart_name }}
                                                {{ $item->acc_trimart_start_date }} ถึง {{ $item->acc_trimart_end_date }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_book" class="form-label">เล่มใบเสร็จ</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="editacc_stm_repmoney_book"
                                        name="acc_stm_repmoney_book">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_date" class="form-label">วันที่ลงรับ</label>
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control" id="editacc_stm_repmoney_date"
                                        name="acc_stm_repmoney_date">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_no" class="form-label">เลขที่ใบเสร็จ</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="editacc_stm_repmoney_no"
                                        name="acc_stm_repmoney_no">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_price" class="form-label">ยอดชดเชย 301</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="editacc_stm_repmoney_price301"
                                        name="acc_stm_repmoney_price301">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_price" class="form-label">ยอดชดเชย 302</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="editacc_stm_repmoney_price302"
                                        name="acc_stm_repmoney_price302">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="acc_stm_repmoney_price" class="form-label">ยอดชดเชย 310</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="editacc_stm_repmoney_price310"
                                        name="acc_stm_repmoney_price310">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" id="edituser_id">
                        <input type="hidden" name="acc_stm_repmoney_id" id="editacc_stm_repmoney_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"
                            id="Updatedata">
                            <i class="pe-7s-diskette btn-icon-wrapper"></i>Update changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('footer')
        <script src="{{ asset('pdfupload/pdf_up.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script src="{{ asset('js/gcpdfviewer.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd'
                });
                $('#datepicker2').datepicker({
                    format: 'yyyy-mm-dd'
                });

                $('#datepicker3').datepicker({
                    format: 'yyyy-mm-dd'
                });


                $('#Savedata').click(function() {
                    var acc_stm_repmoney_tri = $('#acc_stm_repmoney_tri').val();
                    var acc_stm_repmoney_book = $('#acc_stm_repmoney_book').val();
                    var acc_stm_repmoney_no = $('#acc_stm_repmoney_no').val();
                    var acc_stm_repmoney_price301 = $('#acc_stm_repmoney_price301').val();
                    var acc_stm_repmoney_price302 = $('#acc_stm_repmoney_price302').val();
                    var acc_stm_repmoney_price310 = $('#acc_stm_repmoney_price310').val();
                    var acc_stm_repmoney_date = $('#acc_stm_repmoney_date').val();
                    var user_id = $('#user_id').val();

                    $.ajax({
                        url: "{{ route('acc.uprep_money_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            acc_stm_repmoney_tri,
                            acc_stm_repmoney_book,
                            acc_stm_repmoney_no,
                            acc_stm_repmoney_price301,
                            acc_stm_repmoney_price302,
                            acc_stm_repmoney_price310,
                            acc_stm_repmoney_date,
                            user_id
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
                                        // window.location="{{ url('warehouse/warehouse_index') }}";
                                    }
                                })
                            } else {

                            }

                        },
                    });
                });

                $(document).on('click', '.editModal', function() {
                    var acc_stm_repmoney_id = $(this).val();
                    $('#editModal').modal('show');
                    $.ajax({
                        type: "GET",
                        url: "{{ url('uprep_money_edit') }}" + '/' + acc_stm_repmoney_id,
                        success: function(data) {
                            console.log(data.data_show.acc_stm_repmoney_id);
                            $('#editacc_stm_repmoney_tri').val(data.data_show.acc_trimart_id)
                            $('#editacc_stm_repmoney_book').val(data.data_show
                                .acc_stm_repmoney_book)
                            $('#editacc_stm_repmoney_no').val(data.data_show.acc_stm_repmoney_no)
                            $('#editacc_stm_repmoney_price301').val(data.data_show
                                .acc_stm_repmoney_price301)
                            $('#editacc_stm_repmoney_price302').val(data.data_show
                                .acc_stm_repmoney_price302)
                            $('#editacc_stm_repmoney_price310').val(data.data_show
                                .acc_stm_repmoney_price310)
                            $('#editacc_stm_repmoney_date').val(data.data_show
                                .acc_stm_repmoney_date)
                            $('#edituser_id').val(data.data_show.user_id)
                            $('#editacc_stm_repmoney_id').val(data.data_show.acc_stm_repmoney_id)
                        },
                    });
                });

                $('#Updatedata').click(function() {
                    var acc_stm_repmoney_tri = $('#editacc_stm_repmoney_tri').val();
                    var acc_stm_repmoney_book = $('#editacc_stm_repmoney_book').val();
                    var acc_stm_repmoney_no = $('#editacc_stm_repmoney_no').val();
                    var acc_stm_repmoney_price301 = $('#editacc_stm_repmoney_price301').val();
                    var acc_stm_repmoney_price302 = $('#editacc_stm_repmoney_price302').val();
                    var acc_stm_repmoney_price310 = $('#editacc_stm_repmoney_price310').val();
                    var acc_stm_repmoney_date = $('#editacc_stm_repmoney_date').val();
                    var user_id = $('#edituser_id').val();
                    var acc_stm_repmoney_id = $('#editacc_stm_repmoney_id').val();

                    $.ajax({
                        url: "{{ route('acc.uprep_money_update') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            acc_stm_repmoney_tri,
                            acc_stm_repmoney_book,
                            acc_stm_repmoney_no,
                            acc_stm_repmoney_price301,
                            acc_stm_repmoney_price302,
                            acc_stm_repmoney_price310,
                            acc_stm_repmoney_date,
                            user_id,
                            acc_stm_repmoney_id
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    text: "You Update data success",
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
            });


            $(document).on('click', '.addFileModal', function() {
                var acc_stm_repmoney_id = $(this).val();
                // alert(acc_stm_repmoney_id);
                $('#addFileModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ url('uprep_money_edit') }}" + '/' + acc_stm_repmoney_id,
                    success: function(data) {
                        console.log(data.data_show.acc_stm_repmoney_id);
                        $('#edituser_id').val(data.data_show.user_id)
                        $('#addfileacc_stm_repmoney_id').val(data.data_show.acc_stm_repmoney_id)
                    },
                });
            });

            $('#SaveFileModal').on('submit', function(e) {
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
                                title: 'Up File สำเร็จ',
                                text: "You Up File data success",
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
        </script>


    @endsection
