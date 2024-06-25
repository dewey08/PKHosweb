@extends('layouts.pkclaim')
@section('title','PK-OFFICER || Karn Report')
@section('content')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
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
    ?>
     <?php
     use App\Http\Controllers\karnController;
     use Illuminate\Support\Facades\DB; 
 ?>
  <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">เช็ครายการซ้ำ</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target=".bs-ci-modal-lg"><i class="fa-solid fa-file-excel me-2 text-white"></i> Import Excel CI </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"><i class="fa-solid fa-file-excel me-2"></i>Import Excel PT</a>
                            </li>
                            <li class="breadcrumb-item ">
                                <a href="" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target=".bs-hici-modal-lg"><i class="fa-solid fa-file-excel me-2"></i>Import Excel HICI</a>
                            </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card">                     
                        <div class="card-body py-0 px-2 mt-2"> 
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                    id="example"> 
                                        {{-- <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" >    --}}
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
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> 
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

    @endsection
    @section('footer')       
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#btn-click').click(function() {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
            });
        </script>
    
       
    @endsection
