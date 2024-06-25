@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || ANC')
 
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
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;   
    $count_meettingroom = StaticController::count_meettingroom();
    ?>    
 
    <div class="tabs-animation">
                
                    <form action="{{ route('claim.anc_14001') }}" method="POST">
                    @csrf
                    <div class="row"> 
                        <div class="col-md-2 text-end"></div>
                        <div class="col-md-1 text-end">วันที่</div>
                        <div class="col-md-6 text-center">
                        <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                            <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                             data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $start }}"/>
                            <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                            data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $end }}"/>
                            <button type="submit" class="btn btn-info">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                ค้นหาข้อมูล 
                            </button>
                            <a href="{{url('anc_14001_pull')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ดึงข้อมูล</a> 
                            <a href="{{url('anc_14001_pull2')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ดึงข้อมูล2</a>     
                            {{-- <a href="{{url('ssop_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>   --}}
                        </div>
                    </div>
                        
                        <div class="col"></div>
                    </div> 
                </form>
                

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail Data</h4>
                                <p class="card-title-desc">เตรียมข้อมูลส่งออก 16 แฟ้ม</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-3 text-end">
                                
                                {{-- <button type="button" class="btn btn-outline-danger btn-sm Updateprescb" data-url="{{url('ssop_prescb_update')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    Update Prescb
                                </button> --}}
                                {{-- <button type="button" class="btn btn-outline-warning btn-sm Updatesvpid" data-url="{{url('ssop_svpid_update')}}">
                                    <i class="fa-solid fa-file-waveform me-2"></i>
                                    Update SvPID
                                </button> --}}
                            </div>
                        </div>
 
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                             <!-- 1 adp-->
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#14001" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">บริการยาเม็ดเสริมธาตุเหล็ก</span>    
                                </a>
                            </li>
                             
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <!-- 1 adp-->
                            <div class="tab-pane active" id="14001" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                              
                                                    <th class="text-center">vn</th>
                                                    <th class="text-center" >hn</th>
                                                    <th class="text-center" >an</th>
                                                    <th class="text-center">cid</th>
                                                    <th class="text-center">ptname</th> 
                                                    {{-- <th class="text-center">vstdate</th>  --}}
                                                    <th class="text-center">inscl</th> 
                                                    <th class="text-center">pdx</th>
                                                    <th class="text-center" width="8%">drug</th> 
                                                    <th class="text-center">mo_hos</th> 
                                                    <th class="text-center">rcpt_mo</th>
                                                    <th class="text-center">debit</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($anc14001 as $item) 
                                                    <tr style="font-size: 13px;">   
                                                        <td class="text-center">{{ $i++ }}</td>  
                                                        <td class="text-center">{{ $item->vn }}</td> 
                                                        <td class="text-center">{{ $item->hn }}</td>  
                                                        <td class="text-center">{{ $item->an }}</td>  
                                                        <td class="text-center">{{ $item->cid }}</td> 
                                                        <td class="p-2">{{ $item->fullname }}</td>  
                                                        {{-- <td class="text-center">{{ $item->vstdate }}</td>   --}}
                                                        <td class="text-center">{{ $item->inscl }}</td>  
                                                        <td class="text-center">{{ $item->pdx }}</td> 
                                                        <td class="text-center">{{ $item->drug }}</td> 
                                                        <td class="text-center">{{ $item->money_hosxp }}</td> 
                                                        <td class="text-center">{{ $item->rcpt_money }}</td> 
                                                        <td class="text-center">{{ $item->debit }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
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
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#example').DataTable();
        $('#example2').DataTable();
        $('#example3').DataTable();
        $('#example4').DataTable();
        $('#example5').DataTable();
        $('#example6').DataTable();
        $('#example7').DataTable();
        $('#example8').DataTable();
        $('#example9').DataTable();
        $('#example10').DataTable();
        $('#example11').DataTable();
        $('#example12').DataTable();
        $('#example13').DataTable();
        $('#example14').DataTable();
        $('#example15').DataTable();
        $('#example16').DataTable();
        $('#example17').DataTable();
        
    });
    $(document).on('click', '.Edit_prescb', function() {
            var ssop_dispensing_id = $(this).val();  
            $.ajax({
                type: "POST",
                url: "{{ url('ssop_edit_prescb') }}" + '/' + ssop_dispensing_id,
                success: function(data) {
                    if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You edit data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }
                },
            });
    });

    $(document).on('click', '.Edit_svpid', function() {
            var ssop_opservices_id = $(this).val();  
            $.ajax({
                type: "POST",
                url: "{{ url('ssop_edit_svpid') }}" + '/' + ssop_opservices_id,
                success: function(data) {
                    if (data.status == 200) {
                            Swal.fire({
                                title: 'แก้ไขข้อมูลสำเร็จ',
                                text: "You edit data success",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#06D177',
                                confirmButtonText: 'เรียบร้อย'
                            }).then((result) => {
                                if (result
                                    .isConfirmed) {
                                    console.log(
                                        data);

                                    window.location
                                        .reload();
                                }
                            })
                        } else {

                        }
                },
            });
    });
        
</script>
@endsection
