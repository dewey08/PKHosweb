{{-- @extends('layouts.pkclaim_refer') --}}
@extends('layouts.pkclaim')
@section('title','PK-OFFICER || Karn Report')
@section('content')
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
     use App\Http\Controllers\karnController;
     use Illuminate\Support\Facades\DB;   
    //  $checkcipid = karnController::checkcipid();
    // $checkhicipid = karnController::checkhicipid();
 ?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <div class="text-end">                    
                    <a href=" " class="btn btn-warning waves-effect waves-light text-white" data-bs-toggle="modal" data-bs-target=".bs-ci-modal-lg"><i class="fa-solid fa-file-excel me-2 text-white"></i> Import Excel CI </a>
                   <a href=" " class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"><i class="fa-solid fa-file-excel me-2"></i>Import Excel PT</a>
                   <a href=" " class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-hici-modal-lg"><i class="fa-solid fa-file-excel me-2"></i>Import Excel HICI</a>
                </div>
              
                <hr />
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive">
                            {{-- <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                                <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example"> 
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">ci_code</th>
                                        <th class="text-center">ci_hn</th>
                                        <th class="text-center">ci_pid</th>
                                        <th class="text-center">ci_fullname</th>
                                        <th class="text-center">karn_pt</th>
                                        <th class="text-center">karn_hici</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data as $item)
                                    <?php
                                    $color_ptpid = karnController::checkptpid($item->ci_pid);
                                    $color_hicipid = karnController::checkhicipid($item->ci_pid);

                                    if ($color_ptpid > 0 || $color_hicipid > 0) {
                                        $showcolor = "background-color:#F7FA23";
                                        // $showstatus = 'มีรายการซ้ำ';
                                    } else {
                                        $showcolor = '';
                                        // $showstatus = 'ไม่มีรายการซ้ำ';
                                    }   
                                    if ($color_ptpid > 0) {
                                        $showcolorptpid = "background-color:#FA2D23";
                                        $showstatus = 'มีรายการซ้ำ';
                                    } else {
                                        $showcolorptpid = '';
                                        $showstatus = 'ไม่มีรายการซ้ำ';
                                    }  

                                    if ($color_hicipid > 0) {
                                        $showcolorhicipid = "background-color:#FA2D23";
                                        $showstatushicipid = 'มีรายการซ้ำ';
                                    } else {
                                        $showcolorhicipid = '';
                                        $showstatushicipid = 'ไม่มีรายการซ้ำ';
                                    }        
                                                                        
                                    ?>
                                        <tr style="{{$showcolor}}">
                                            <td>{{$i++ }}</td>
                                            <td>{{$item->ci_code}}</td>
                                            <td>{{$item->ci_hn }}</td>
                                            <td>{{$item->ci_pid }}</td> 
                                            <td>{{ $item->ci_fullname }} </td>                                            
                                            <td class="text-center" style="{{$showcolorptpid}}">{{$showstatus}}</td>  
                                            <td class="text-center" style="{{$showcolorhicipid}}">{{$showstatushicipid}}</td>    
                                            {{-- <td>{{karnController::checkptpid($item->ci_pid) }}</td>                                                                                    
                                            <td>{{karnController::checkhicipid($item->ci_pid) }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

         <!--  Modal content for the above ci -->
         <div class="modal fade bs-ci-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">CI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Import Excel</h4>
                                        <p class="card-title-desc"> นำไฟล์เข้าเพื่อเช็คซ้ำ ci  </p>
        
                                        <div>
                                            <form action="#" class="dropzone">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                                    </div>
                                                    
                                                    <h4>Drop files here or click to upload.</h4>
                                                </div>
                                            </form>
                                        </div>
        
                                        <div class="text-center mt-4">
                                            <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> 
                        
                    </div>
                </div> 
            </div> 
        </div> 

        <!--  Modal content for the above example -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">PT</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Import Excel</h4>
                                        <p class="card-title-desc"> นำไฟล์เข้าเพื่อเช็คซ้ำ PT  </p>
        
                                        <div>
                                            <form action="#" class="dropzone">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                                    </div>
                                                    
                                                    <h4>Drop files here or click to upload.</h4>
                                                </div>
                                            </form>
                                        </div>
        
                                        <div class="text-center mt-4">
                                            <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> 
                        
                    </div>
                </div> 
            </div> 
        </div> 

         <!--  Modal content for the above hici -->
         <div class="modal fade bs-hici-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">HICI</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Import Excel</h4>
                                        <p class="card-title-desc"> นำไฟล์เข้าเพื่อเช็คซ้ำ hici  </p>
        
                                        <div>
                                            <form action="#" class="dropzone">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-line"></i>
                                                    </div>
                                                    
                                                    <h4>Drop files here or click to upload.</h4>
                                                </div>
                                            </form>
                                        </div>
        
                                        <div class="text-center mt-4">
                                            <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> 
                        
                    </div>
                </div> 
            </div> 
        </div> 



    </div>
@endsection
@section('footer')

 <!-- Plugins js -->
 <script src="{{ asset('apkclaim/libs/dropzone/min/dropzone.min.js') }}"></script>

 <script src="{{ asset('apkclaim/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            $('#year_id').select2({
                placeholder: "== เลือกปีที่ต้องการ ==",
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
