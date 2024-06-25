@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || PCT')

     <?php
     use App\Http\Controllers\StaticController;
     use Illuminate\Support\Facades\DB;   
     $count_meettingroom = StaticController::count_meettingroom();
 ?>


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
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('pct.thalassemia_yearsearch') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            {{-- <h5 class="mb-sm-0">รายงานการลงข้อมูล OPD พรบ. </h5> --}}
                        </div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-2 text-center">
                            <input id="startdate" name="startdate" class="form-control form-control-sm" type="date"
                                value="{{ $startdate }}">
                        </div>
                        <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <input id="enddate" name="enddate" class="form-control form-control-sm" type="date"
                                value="{{ $enddate }}">
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
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>จำนวนผู้ป่วย Thalassemia OPD ให้เลือด</h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">เดือน</th> 
                                    <th class="text-center">จำนวนผู้ป่วยครั้ง</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow_opd as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td> 
                                      
                                        <td width="15%" class="text-center">{{ $item->years }}</td>
                                       
                                        <td>
                                            <a href="{{url('thalassemia_opd/'.$item->years.'/'.$startdate.'/'.$enddate)}}" target="_blank">{{ $item->VN }}</a>  
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
 
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>จำนวนผู้ป่วย Thalassemia IPD ให้เลือด</h5>
                            </div>
                            <div class="col"></div> 
                            <div class="col-md-2 text-end">
                           
                            </div>
    
                        </div>
                    </div>
                    <div class="card-body shadow-lg">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">เดือน</th> 
                                    <th class="text-center">จำนวนผู้ป่วยครั้ง</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow_ipd as $item2)
                                    <tr>
                                        <td>{{ $i++ }}</td> 
                                        <td width="15%" class="text-center">{{ $item2->years }}</td>
                                        
                                        <td>
                                            <a href="{{url('thalassemia_ipd/'.$item2->years)}}" target="_blank">{{ $item2->AN }}</a>  
                                        </td> 
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
    </div>
 

    @endsection
    @section('footer')
        <script>
            
            $(document).ready(function() {
                $('#example').DataTable();
                $('#example2').DataTable();
                $('#example3').DataTable();
    
                $('select').select2();
                $('#ECLAIM_STATUS').select2({
                    dropdownParent: $('#detailclaim')
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $('#heck_updateForm').on('submit', function(e) {
                    e.preventDefault();
                    var form = this;
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
                                    text: "You Insert data success",
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
