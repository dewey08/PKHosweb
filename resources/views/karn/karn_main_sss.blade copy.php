 
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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">รายงาน  </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                            <li class="breadcrumb-item active">รายงาน </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('k.karn_main_sss') }}" method="POST" >
                    @csrf
                <div class="row">                   
                        <div class="col"></div>
                        <div class="col-md-1 text-end">ปีงบประมาณ</div>
                        <div class="col-md-2 text-center">
                            <input id="startdate" name="startdate" class="form-control form-control-sm" type="date">
                                 
                        </div>
                        <div class="col-md-1 text-center">ถึง</div>
                        <div class="col-md-2 text-center">
                            <input id="enddate" name="enddate" class="form-control form-control-sm" type="date">                             
                        </div>
                        <div class="col-md-2"> 
                            <button type="submit" class="btn btn-primary btn-sm">
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
            <div class="col-xl-12">             
                <div class="card shadow-lg">
                    <div class="card-body py-0 px-2 mt-2">
                        <div class="table-responsive"> 
                            <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;"
                                id="example"> 
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">hn</th>
                                        <th class="text-center">an</th>
                                        <th class="text-center">fullname</th>
                                        <th class="text-center">cid</th>
                                        <th class="text-center">regdate</th>
                                        <th class="text-center">regtime</th>

                                        <th class="text-center">debname</th>
                                        <th class="text-center">n2</th>
                                        <th class="text-center">pdx</th>
                                        <th class="text-center">income</th>
                                        <th class="text-center">pttype</th>
                                        <th class="text-center">regtime</th>
                                        <th class="text-center">regtime</th>
                                        <th class="text-center">regtime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($datashow as $item)                                    
                                        <tr>
                                            <td>{{$i++ }}</td>
                                            <td>{{$item->hn}}</td>
                                            <td>{{$item->an }}</td>
                                            <td>{{$item->fullname }}</td> 
                                            <td>{{ $item->cid }}</td>                                            
                                            <td class="text-center">{{ $item->regdate }} </td>  
                                            <td class="text-center"> {{ $item->regtime }}</td>

                                            <td>{{ $item->debname }}</td> 
                                            <td>{{ $item->n2 }}</td> 
                                            <td>{{ $item->pdx }}</td> 
                                            <td>{{ $item->income }}</td> 
                                            <td>{{ $item->pttype }}</td> 
                                            <td>{{ $item->cid }}</td> 
                                            <td>{{ $item->cid }}</td> 
                                            <td>{{ $item->cid }}</td> 
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

 <!-- Plugins js -->
 <script src="{{ asset('apkclaim/libs/dropzone/min/dropzone.min.js') }}"></script>

 <script src="{{ asset('apkclaim/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#example3').DataTable();

            // $('#startdate').select2({
            //     placeholder: "== วันที่ ==",
            //     allowClear: true
            // });
            // $('#enddate').select2({
            //     placeholder: "== วันที่ ==",
            //     allowClear: true
            // });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
        });
    </script>
@endsection
