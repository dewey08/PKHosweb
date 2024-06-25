@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || AIPN')
 
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
        function aipn_billitems_destroy(aipn_billitems_id) { 
            Swal.fire({
                title: 'ต้องการลบข้อมูลใช่ไหม?',
                text: "ข้อมูลนี้จะถูกลบ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ ',
                cancelButtonText: 'ไม่'
            }).then((result) => {
                if (result.isConfirmed) { 
                    $.ajax({
                        url: "{{ url('aipn_billitems_destroy') }}" + '/' + aipn_billitems_id,
                        type: "DELETE",
                        data: {
                            _token: $("input[name=_token]").val()
                        },
                        success: function(response) {
                            if (response == 200) {
                                Swal.fire({
                                    title: 'ลบข้อมูลสำเร็จ !!',
                                    text: "Delete Data Success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177', 
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#sidb" + aipn_billitems_id).remove();
                                        // window.location.reload();
                                        window.location="{{url('aipn')}}"; 
                                    }
                                })
                            } else {                                
                            }                            
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
    use App\Http\Controllers\StaticController;
    use Illuminate\Support\Facades\DB;   
    $count_meettingroom = StaticController::count_meettingroom();
    ?>    
 <style>
    #button{
           display:block;
           margin:20px auto;
           padding:30px 30px;
           background-color:#eee;
           border:solid #ccc 1px;
           cursor: pointer;
           }
           #overlay{	
           position: fixed;
           top: 0;
           z-index: 100;
           width: 100%;
           height:100%;
           display: none;
           background: rgba(0,0,0,0.6);
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
           .is-hide{
           display:none;
           }
</style>
    <div class="tabs-animation">

        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    
                </div>
            </div>
        </div>
        
                    <form action="{{ route('claim.aipnsearch') }}" method="POST">
                    @csrf

                    <div class="row"> 
                        {{-- <div class="col"></div> --}}
                        <div class="col-md-2 text-end">วันที่</div>
                        <div class="col-md-6 text-center">
                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1'
                                 data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $start }}"/>
                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1'
                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $end }}"/>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    ค้นหา 
                                </button>
                                {{-- <a href="{{url('aipn_send')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>      --}}
                                {{-- <a href="{{url('ssop_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>  --}}
                            </div>
                            {{-- <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" name="startdate" id="datepicker"  data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                    value="{{ $start }}"> 
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                ถึงวันที่
                                <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                value="{{ $end }}">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div> --}}
                           
                        </div>
                        {{-- <div class="col-md-1 text-center">ถึงวันที่</div>
                        <div class="col-md-2 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" name="enddate" id="datepicker2" data-date-container='#datepicker1'
                                    data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th"
                                    value="{{ $end }}">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>    --}}
                                           
                        {{-- <div class="col-md-3"> --}}
                            {{-- <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                ค้นหา 
                            </button>  --}}
                            {{-- <a href="{{url('aipn_send/'.$an)}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>  --}}
                            {{-- <a href="{{url('aipn_send/'.$an)}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>     
                            <a href="{{url('ssop_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>                             --}}
                        {{-- </div> --}}
                        
                        <div class="col"></div>
                    </div> 
                </form>
                <form action="{{ route('claim.aipnsearch') }}" method="POST">
                    @csrf
                    <br>
                    <div class="row">
                        {{-- <div class="col"></div> --}}
                        <div class="col-md-2 text-end">AN</div>
                        <div class="col-md-6 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" name="AN" id="AN" placeholder="AN" value="{{$an}}" required> 
                                <button type="submit" class="btn btn-info">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    ดึงข้อมูล 
                                </button>
                                {{-- <button class="btn btn-secondary" id="Changbillitems"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>ปรับ bilitems</button>  --}}
                                <button class="btn btn-success" id="Export"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</button>   
                                <a href="{{url('aipn_zip')}}" class="btn btn-danger" id="Zipfile"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>   
                                {{-- <a href="{{url('aipn_send_an'.)}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>   
                                <a href="{{url('ssop_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>    --}}
                            
                            </div>
                        </div>    
                        <div class="col"></div>
                    </div>
                
                  
                </form>
                
         
       

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        {{-- <h4 class="card-title">Detail AIPN</h4>
                        <p class="card-title-desc">รายละเอียดประกันสังคมผู้ป่วยใน</p> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail AIPN</h4>
                                <p class="card-title-desc">รายละเอียดประกันสังคมผู้ป่วยใน</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                {{-- <button class="btn btn-secondary" id="Changbillitems"><i class="fa-solid fa-wand-magic-sparkles me-3"></i>ปรับ bilitems</button>  --}}
                                
                            </div>
                        </div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#BillItems" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">BillItems</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPADT" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">IPADT</span>    
                                </a>
                            </li>
                            
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#BillItems" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">BillItems</span>    
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPDx" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IPDx</span>    
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPOp" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IPOp</span>    
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#OPServices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">OPServices</span>    
                                </a>
                            </li>
                          
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#OPDX" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">OPDX</span>    
                                </a>
                            </li> --}}
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted"> 
                            <div class="tab-pane active" id="BillItems" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="selection-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    {{-- <th width="5%" class="text-center"><input type="checkbox" name="" id=""> </th>  --}}
                                                    <th class="text-center">AN</th>
                                                    <th class="text-center">sequence</th>
                                                    <th class="text-center">ServDate</th>
                                                    <th class="text-center">ServTime</th>
                                                    <th class="text-center">BillGr</th>   
                                                   
                                                    <th class="text-center">BillGrCS</th> 
                                                   
                                                    <th class="text-center">CodeSys</th> 
                                                    <th class="text-center">CSCode</th>
                                                    <th class="text-center">STDCode</th>  
                                                    <th class="text-center">ClaimCat</th> 
                                                    <th class="text-center">LCCode</th> 
                                                    <th class="text-center">Descript</th> 
                                                    <th class="text-center">QTY</th> 
                                                    <th class="text-center">UnitPrice</th> 
                                                    <th class="text-center">ChargeAmt</th> 
                                                    <th class="text-center">Discount</th> 
                                                    <th class="text-center">ClaimUP</th> 
                                                    <th class="text-center">ClaimAmt</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($aipn_billitems as $item2) 
                                                    <tr id="sidb{{$item2->aipn_billitems_id }}">   
                                                        <td class="text-center">{{ $i++ }}</td> 
                                                        {{-- <td class="text-center" width="5%"><input type="checkbox" class="sub_chk" data-id="{{$item2->aipn_billitems_id}}"> </td>    --}}
                                                        <td class="text-center">{{ $item2->AN }} </td>
                                                        <td class="text-center">{{ $item2->sequence }}</td>
                                                        <td class="text-center">{{ $item2->ServDate }} </td>
                                                        <td class="text-center">{{ $item2->ServTime }} </td>
                                                        <td class="text-center">{{ $item2->BillGr }} </td>                                                         
                                                        <td class="p-2">{{ $item2->BillGrCS }}</td>  

                                                       @if ($item2->CodeSys == 'TMT' && $item2->STDCode == '')
                                                            <td class="text-center" style="background-color: pink">{{ $item2->CodeSys }} </td> 
                                                        @elseif ($item2->CodeSys == 'TMLT' && $item2->STDCode == '')
                                                            <td class="text-center" style="background-color: pink">{{ $item2->CodeSys }} </td> 
                                                       @else
                                                            <td class="text-center">{{ $item2->CodeSys }} </td> 
                                                       @endif
                                                       
                                                        <td class="p-2">{{ $item2->CSCode }}</td> 
                                                        <td class="text-center">{{ $item2->STDCode }} </td> 
                                                        <td class="text-center">{{ $item2->ClaimCat }} </td> 
                                                        <td class="text-center">
                                                            <a href="javascript:void(0)" onclick="aipn_billitems_destroy({{ $item2->aipn_billitems_id }})" data-bs-toggle="tooltip" data-bs-placement="left" title="ลบ" class="btn btn-outline-danger btn-sm"> 
                                                                <i class="fa-solid fa-trash-can text-danger me-2"></i> 
                                                                {{ $item2->LCCode }} 
                                                            </a>                                                           
                                                        </td>
 
                                                        <td class="p-2">{{ $item2->Descript }}</td>
                                                        <td class="text-center">{{ $item2->QTY }}</td>
                                                        <td class="text-center">{{ number_format($item2->UnitPrice, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ChargeAmt, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->Discount, 2) }}</td>

                                                        <td class="text-center">{{ number_format($item2->ClaimUP, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ClaimAmt, 2) }}</td>
                                                   
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="IPADT" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center" width="5%">AN</th> 
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center" >IDTYPE</th>
                                                    <th class="text-center" >PIDPAT</th>
                                                    <th class="text-center">TITLE</th>
                                                    <th class="text-center">NAMEPAT</th> 
                                                    <th class="text-center">DOB</th>
                                                    <th class="text-center" width="7%">SEX</th>
                                                    <th class="text-center">MARRIAGE</th>
                                                    <th class="text-center">CHANGWAT</th>
                                                    <th class="text-center" width="8%">AMPHUR</th>
                                                    <th class="text-center" width="8%">NATION</th> 
                                                    <th class="text-center" width="10%">AdmType</th> 
                                                    <th class="text-center">AdmSource</th>
                                                    <th class="text-center">DTAdm_d</th>
                                                    <th class="text-center">DTDisch_d</th>
                                                    <th class="text-center">LeaveDay</th>

                                                    <th class="text-center">DischStat</th>
                                                    <th class="text-center">DishType</th>
                                                    <th class="text-center">AdmWt</th>
                                                    <th class="text-center">DishWard</th>
                                                    <th class="text-center">Dept</th>
                                                    <th class="text-center">HMAIN</th>
                                                    <th class="text-center">ServiceType</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($aipn_data as $item) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center" width="5%">{{ $item->AN }}</td> 
                                                        <td class="text-center">{{ $item->HN }}</td> 
                                                        <td class="text-center">{{ $item->IDTYPE }}</td>  
                                                        <td class="text-center">{{ $item->PIDPAT }}</td>  
                                                        <td class="text-center">{{ $item->TITLE }}</td> 
                                                        <td class="text-center">{{ $item->NAMEPAT }}</td>  
                                                        <td class="text-center">{{ $item->DOB }}</td> 
                                                        <td class="text-center">{{ $item->SEX }}</td> 
                                                        <td class="text-center">{{ $item->MARRIAGE }}</td> 
                                                        <td class="p-2">{{ $item->CHANGWAT }}</td> 
                                                        {{-- <td class="text-center">{{ number_format($item->Amount, 2) }}</td>  --}}
                                                        <td class="text-center">{{ $item->AMPHUR }}</td> 
                                                        <td class="text-center">{{ $item->NATION }}</td> 
                                                        <td class="text-center">{{ $item->AdmType }}</td> 
                                                        <td class="text-center">{{ $item->AdmSource }}</td> 
                                                        <td class="text-center">{{ $item->DTAdm_d }}</td> 
                                                        <td class="text-center">{{ $item->DTDisch_d }}</td> 
                                                        <td class="text-center">{{ $item->LeaveDay }}</td> 

                                                        <td class="text-center">{{ $item->DischStat }}</td>
                                                        <td class="text-center">{{ $item->DishType }}</td>
                                                        <td class="text-center">{{ $item->AdmWt }}</td>
                                                        <td class="text-center">{{ $item->DishWard }}</td>
                                                        <td class="text-center">{{ $item->Dept }}</td>
                                                        <td class="text-center">{{ $item->HMAIN }}</td>
                                                        <td class="text-center">{{ $item->ServiceType }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <div class="tab-pane" id="IPDx" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">an</th>
                                                    <th class="text-center">sequence</th>
                                                    <th class="text-center">DxType</th>
                                                    <th class="text-center">CodeSys</th>
                                                    <th class="text-center">Dcode</th>   
                                                    <th class="text-center">DiagTerm</th> 
                                                    <th class="text-center">DR</th> 
                                                    <th class="text-center">datediag</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($aipn_ipdx as $item3) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item3->an }} </td>
                                                        <td class="text-center">{{ $item3->sequence }}</td>
                                                        <td class="text-center" >{{ $item3->DxType }} </td>
                                                        <td class="text-center" >{{ $item3->CodeSys }} </td>
                                                        <td class="text-center" >{{ $item3->Dcode }} </td>
                                                        <td class="p-2" >{{ $item3->DiagTerm }}</td>   
                                                        <td class="text-center" >{{ $item3->DR }}</td> 
                                                        <td class="text-center" >{{ $item3->datediag }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <div class="tab-pane" id="IPOp" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">an</th>
                                                    <th class="text-center">sequence</th>
                                                    <th class="text-center">CodeSys</th>
                                                    <th class="text-center">Code</th>   
                                                    <th class="text-center">Procterm</th> 
                                                    <th class="text-center">DR</th> 
                                                    <th class="text-center">DateIn</th> 
                                                    <th class="text-center">DateOut</th> 
                                                    <th class="text-center">Location</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($aipn_ipop as $item4) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item4->an }}</td>
                                                        <td class="text-center" >{{ $item4->sequence }} </td>
                                                        <td class="text-center" >{{ $item4->CodeSys }} </td>
                                                        <td class="text-center" >{{ $item4->Code }} </td>
                                                        <td class="p-2" >{{ $item4->Procterm }}</td>   
                                                        <td class="p-2" >{{ $item4->DR }}</td> 
                                                        <td class="text-center" >{{ $item4->DateIn }}</td> 
                                                        <td class="p-2" width="15%">{{ $item4->DateOut }}</td> 
                                                        <td class="text-center" >{{ $item4->Location }}</td> 
                                                          
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            {{-- <div class="tab-pane" id="OPServices" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">Invno</th>
                                                    <th class="text-center">SvID</th>
                                                    <th class="text-center">Class</th>
                                                    <th class="text-center">Hcode</th>   
                                                    <th class="text-center">HN</th> 
                                                    <th class="text-center">PID</th> 
                                                    <th class="text-center">CareAccount</th> 
                                                    <th class="text-center">TypeServ</th> 
                                                    <th class="text-center">TypeIn</th> 
                                                    <th class="text-center">TypeOut</th> 
                                                    <th class="text-center">DTAppoint</th> 
                                                    <th class="text-center">SvPID</th> 
                                                    <th class="text-center">Clinic</th>  
                                                    <th class="text-center">BegDT</th> 
                                                    <th class="text-center">EndDT</th> 
                                                    <th class="text-center">LcCode</th> 
                                                    <th class="text-center">CodeSet</th> 
                                                    <th class="text-center">STDCode</th> 
                                                    <th class="text-center">SvCharge</th> 
                                                    <th class="text-center">Completion</th> 
                                                    <th class="text-center">SvTxCode</th> 
                                                    <th class="text-center">ClaimCat</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_opservices as $item5) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item5->Invno }}</td>
                                                        <td class="text-center" >{{ $item5->SvID }} </td>
                                                        <td class="text-center" >{{ $item5->Class }} </td>
                                                        <td class="text-center" >{{ $item5->Hcode }} </td>
                                                        <td class="p-2" >{{ $item5->HN }}</td>   
                                                        <td class="p-2" >{{ $item5->PID }}</td> 
                                                        <td class="text-center" >{{ $item5->CareAccount }}</td> 
                                                        <td class="p-2">{{ $item5->TypeServ }}</td> 
                                                        <td class="text-center" >{{ $item5->TypeIn }}</td>  
                                                        <td class="text-center" >{{ $item5->TypeOut }}</td> 
                                                        <td class="text-center" >{{ $item5->DTAppoint }}</td> 
                                                        <td class="text-center" >{{ $item5->SvPID }}</td> 
                                                        <td class="text-center" >{{ $item5->Clinic }}</td> 
                                                        <td class="text-center" width="15%">{{ $item5->BegDT }}</td> 
                                                        <td class="text-center" width="15%">{{ $item5->EndDT }}</td> 
                                                        <td class="text-center" >{{ $item5->LcCode }}</td> 
                                                        <td class="text-center" >{{ $item5->CodeSet }}</td> 
                                                        <td class="text-center" >{{ $item5->STDCode }}</td> 
                                                        <td class="text-center" >{{ $item5->SvCharge }}</td> 
                                                        <td class="text-center" >{{ $item5->Completion }}</td> 
                                                        <td class="text-center" >{{ $item5->SvTxCode }}</td> 
                                                        <td class="text-center" >{{ $item5->ClaimCat }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div> --}}
                            {{-- <div class="tab-pane" id="OPDX" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example3" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">Class</th>
                                                    <th class="text-center">SvID</th>
                                                    <th class="text-center" width="15%">SL</th>
                                                    <th class="text-center" width="15%">CodeSet</th>
                                                    <th class="text-center">code</th>   
                                                    <th class="text-center" >Desc</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_opdx_ as $item6) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item6->Class }}</td>
                                                        <td class="text-center" >{{ $item6->SvID }} </td>
                                                        <td class="text-center" >{{ $item6->SL }} </td>
                                                        <td class="text-center" >{{ $item6->CodeSet }} </td>                                                       
                                                        <td class="text-center" >{{ $item6->code }}</td>  
                                                        <td class="text-center" >{{ $item6->Desc }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                             
                                        </table>
                                    </div>
                                </p>
                            </div> --}}
                             
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
 
        $("#spinner-div").hide(); //Request is complete so hide spinner
       
        $('#Export').click(function() {
            var AN = $('#AN').val();  
            $.ajax({
                url: "{{ route('claim.aipn_send_an') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    AN 
                },
                success: function(data) {
                    // if (data.status == 200) {
                    //     Swal.fire({
                    //         title: 'บันทึกข้อมูลสำเร็จ',
                    //         text: "You Insert data success",
                    //         icon: 'success',
                    //         showCancelButton: false,
                    //         confirmButtonColor: '#06D177',
                    //         confirmButtonText: 'เรียบร้อย'
                    //     }).then((result) => {
                    //         if (result
                    //             .isConfirmed) {
                    //             console.log(
                    //                 data);
                    //             window.location.reload();
                    //             // window.location="{{url('warehouse/warehouse_index')}}";
                    //         }
                    //     })
                    // } else {
                        

                    // }

                },
            });
        });
 
        // $('#Changbillitems').click(function() {
        //     var AN = $('#AN').val();  

        //     Swal.fire({
        //     title: 'ต้องการปรับข้อมูลใช่ไหม ??',
        //     text: "You Update Data ??",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, Update it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $("#overlay").fadeIn(300);　
        //              $("#spinner").show(); //Load button clicked show spinner         

        //                 $.ajax({
        //                     url: "{{ route('claim.aipn_send_chang') }}",
        //                     type: "POST",
        //                     dataType: 'json',
        //                     data: {
        //                         AN 
        //                     },
        //                     success: function(data) {
        //                         if (data.status == 200) {
        //                             Swal.fire({
        //                                 title: 'ปรับข้อมูลสำเร็จ',
        //                                 text: "You Update data success",
        //                                 icon: 'success',
        //                                 showCancelButton: false,
        //                                 confirmButtonColor: '#06D177',
        //                                 confirmButtonText: 'เรียบร้อย'
        //                             }).then((result) => {
        //                                 if (result
        //                                     .isConfirmed) {
        //                                     console.log(
        //                                         data);
        //                                     window.location.reload();
        //                                     $('#spinner').hide();//Request is complete so hide spinner
        //                                             setTimeout(function(){
        //                                                 $("#overlay").fadeOut(300);
        //                                          },500);
        //                                 }
        //                             })
        //                         } else {
                                    

        //                         }

        //                     },
        //                 });
        //             }
        //     })
        // });

        $('#Zipfile').click(function() {
            var AN = $('#AN').val();  
            $.ajax({
                url: "{{ route('claim.aipn_zip') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    AN 
                },
                success: function(data) { 
                },
            });
        });

       
    });
</script>
@endsection
