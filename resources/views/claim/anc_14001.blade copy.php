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
                
                    <form action="{{ route('claim.anc_dent_search') }}" method="POST">
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
                                ค้นข้อมูล 
                            </button>
                            {{-- <a href="{{url('ssop_send')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>    ดึงข้อมูล --}}
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
                                <h4 class="card-title">Detail </h4>
                                <p class="card-title-desc">ส่งออก 16 แฟ้ม</p>
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
                                <a class="nav-link active" data-bs-toggle="tab" href="#adp" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">adp</span>    
                                </a>
                            </li>
                             <!-- 2 aer-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#aer" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">aer</span>    
                                </a>
                            </li>
                            <!-- 3 cha-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#cha" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">cha</span>    
                                </a>
                            </li>
                            <!-- 4 cht-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#cht" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">cht</span>    
                                </a>
                            </li>
                             <!-- 5 dru-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#dru" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">dru</span>    
                                </a>
                            </li>
                            <!-- 6 idx-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#idx" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">idx</span>    
                                </a>
                            </li>
                            <!-- 7 ins-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ins" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">ins</span>    
                                </a>
                            </li>
                             <!-- 8 iop-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#iop" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">iop</span>    
                                </a>
                            </li>
                             <!-- 9 ipd-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#ipd" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">ipd</span>    
                                </a>
                            </li>
                             <!-- 10 irf-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#irf" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">irf</span>    
                                </a>
                            </li>
                             <!-- 11 labfu-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#labfu" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">labfu</span>    
                                </a>
                            </li>
                             <!-- 12 lvd-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#lvd" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">lvd</span>    
                                </a>
                            </li>
                            <!-- 13 odx-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#odx" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">odx</span>    
                                </a>
                            </li>
                             <!-- 14 oop-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#oop" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">oop</span>    
                                </a>
                            </li>
                             <!-- 15 opd-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#opd" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">opd</span>    
                                </a>
                            </li>
                             <!-- 16 orf-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#orf" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">orf</span>    
                                </a>
                            </li>
                            <!-- 17 pat-->
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#pat" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">pat</span>    
                                </a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <!-- 1 adp-->
                            <div class="tab-pane active" id="adp" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center" width="5%">Station</th> 
                                                    <th class="text-center">DTtran</th>
                                                    <th class="text-center" >Hcode</th>
                                                    <th class="text-center" >Invno</th>
                                                    <th class="text-center">VerCode</th>
                                                    <th class="text-center">HN</th> 
                                                    <th class="text-center">Tflag</th>
                                                    <th class="text-center" width="7%">HMain</th>
                                                    <th class="text-center">Pid</th>
                                                    <th class="text-center">ชื่อ-สกุล </th>
                                                    <th class="text-center" width="8%">Amount</th>
                                                    <th class="text-center" width="8%">Paid</th> 
                                                    <th class="text-center" width="10%">ClaimAmt</th> 
                                                    <th class="text-center">PayPlan</th>
                                                    <th class="text-center">OtherPay</th>
                                                    <th class="text-center">pttype</th>
                                                    <th class="text-center">Diag</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_billtran as $item) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center" width="5%">{{ $item->Station }}</td> 
                                                        <td class="text-center">{{ $item->DTtran }}</td> 
                                                        <td class="text-center">{{ $item->Hcode }}</td>  
                                                        <td class="text-center">{{ $item->Invno }}</td>  
                                                        <td class="text-center">{{ $item->VerCode }}</td> 
                                                        <td class="text-center">{{ $item->HN }}</td>  
                                                        <td class="text-center">{{ $item->Tflag }}</td> 
                                                        <td class="text-center">{{ $item->HMain }}</td> 
                                                        <td class="text-center">{{ $item->Pid }}</td> 
                                                        <td class="p-2">{{ $item->Name }}</td> 
                                                        <td class="text-center">{{ number_format($item->Amount, 2) }}</td> 
                                                        <td class="text-center">{{ number_format($item->Paid, 2) }}</td>  
                                                        <td class="text-center">{{ number_format($item->ClaimAmt, 2) }}</td>  
                                                        <td class="text-center">{{ number_format($item->PayPlan, 2) }}</td> 
                                                        <td class="text-center">{{ number_format($item->OtherPay, 2) }}</td> 
                                                        <td class="text-center">{{ $item->pttype }}</td> 
                                                        <td class="text-center">{{ $item->Diag }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <!-- 2 aer-->
                            <div class="tab-pane" id="aer" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="selection-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">Invno</th>
                                                    <th class="text-center">SvDate</th>
                                                    <th class="text-center">BillMuad</th>
                                                    <th class="text-center">LCCode</th>
                                                    <th class="text-center">STDCode</th>   
                                                    <th class="text-center">Desc</th> 
                                                    <th class="text-center">QTY</th> 
                                                    <th class="text-center">UnitPrice</th> 
                                                    <th class="text-center">ChargeAmt</th> 
                                                    <th class="text-center">ClaimUP</th> 
                                                    <th class="text-center">ClaimAmount</th> 
                                                    <th class="text-center">SvRefID</th> 
                                                    <th class="text-center">ClaimCat</th> 
                                                    <th class="text-center">paidst</th>  
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_billitems as $item2) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item2->Invno }} </td>
                                                        <td class="text-center">{{ $item2->SvDate }}</td>
                                                        <td class="text-center">{{ $item2->BillMuad }} </td>
                                                        <td class="text-center">{{ $item2->LCCode }} </td>
                                                        <td class="text-center">{{ $item2->STDCode }} </td>
                                                        <td class="p-2">{{ $item2->Desc }}</td>   
                                                        <td class="text-center">{{ $item2->QTY }}</td>
                                                        <td class="text-center">{{ number_format($item2->UnitPrice, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ChargeAmt, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ClaimUP, 2) }}</td>
                                                        <td class="text-center">{{ number_format($item2->ClaimAmount, 2) }}</td>
                                                        <td class="text-center">{{ $item2->SvRefID }}</td>
                                                        <td class="text-center">{{ $item2->ClaimCat }}</td>
                                                        <td class="text-center">{{ $item2->paidst }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </p>
                            </div>
                             <!-- 3 cha-->
                            <div class="tab-pane" id="cha" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="key-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">ProviderID</th>
                                                    <th class="text-center">DispID</th>
                                                    <th class="text-center">Invno</th>
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">PID</th>   
                                                    <th class="text-center">Prescdt</th> 
                                                    <th class="text-center">Dispdt</th> 
                                                    <th class="text-center"><input type="checkbox" name="stamp" id="stamp" class="me-2">Prescb</th> 
                                                    <th class="text-center">Itemcnt</th> 
                                                    <th class="text-center">ChargeAmt</th> 
                                                    <th class="text-center">ClaimAmt</th> 
                                                    <th class="text-center">Paid</th> 
                                                    <th class="text-center">OtherPay</th> 
                                                    <th class="text-center">Reimburser</th>  
                                                    <th class="text-center">BenefitPlan</th> 
                                                    <th class="text-center">DispeStat</th> 
                                                    <th class="text-center">SvID</th> 
                                                    <th class="text-center">DayCover</th> 
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_dispensing as $item3) 
                                                    <tr id="prescbid{{$item3->ssop_dispensing_id}}">   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center">{{ $item3->ProviderID }} </td>
                                                        <td class="text-center">{{ $item3->DispID }}</td>
                                                        <td class="text-center" >{{ $item3->Invno }} </td>
                                                        <td class="text-center" >{{ $item3->HN }} </td>
                                                        <td class="text-center" >{{ $item3->PID }} </td>
                                                        <td class="text-center" >{{ $item3->Prescdt }}</td>   
                                                        <td class="text-center" >{{ $item3->Dispdt }}</td> 
                                                        <td class="p-2" >
                                                            <input type="checkbox" class="sub_chk me-2" data-id="{{$item3->ssop_dispensing_id}}">
                                                            <button type="button"class="btn btn-outline-danger btn-sm Edit_prescb"
                                                                value="{{ $item3->ssop_dispensing_id }}" data-bs-toggle="tooltip"
                                                                data-bs-placement="left" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-danger"></i>
                                                                <label for="" class="text-danger" style="font-size:13px;"> {{ $item3->Prescb }}</label>
                                                            </button>
                                                        </td> 
                                                        <td class="text-center" >{{ $item3->Itemcnt }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->ChargeAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->ClaimAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->Paid, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item3->OtherPay, 2) }}</td> 
                                                        <td class="text-center" >{{ $item3->Reimburser }}</td> 
                                                        <td class="text-center" >{{ $item3->BenefitPlan }}</td> 
                                                        <td class="text-center" >{{ $item3->DispeStat }}</td> 
                                                        <td class="text-center" >{{ $item3->SvID }}</td> 
                                                        <td class="text-center" >{{ $item3->DayCover }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </p>
                            </div>
                            <!-- 4 cht-->
                            <div class="tab-pane" id="cht" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">DispID</th>
                                                    <th class="text-center">PrdCat</th>
                                                    <th class="text-center">HospDrgID</th>
                                                    <th class="text-center">DrgID</th>   
                                                    <th class="text-center">dfsText</th> 
                                                    <th class="text-center">Packsize</th> 
                                                    <th class="text-center">sigCode</th> 
                                                    <th class="text-center">sigText</th> 
                                                    <th class="text-center">Quantity</th> 
                                                    <th class="text-center">UnitPrice</th> 
                                                    <th class="text-center">ChargeAmt</th> 
                                                    <th class="text-center">ReimbPrice</th> 
                                                    <th class="text-center">ReimbAmt</th>  
                                                    <th class="text-center">PrdSeCode</th> 
                                                    <th class="text-center">Claimcont</th> 
                                                    <th class="text-center">ClaimCat</th> 
                                                    <th class="text-center">paidst</th> 
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_dispenseditems as $item4) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item4->DispID }}</td>
                                                        <td class="text-center" >{{ $item4->PrdCat }} </td>
                                                        <td class="text-center" >{{ $item4->HospDrgID }} </td>
                                                        <td class="text-center" >{{ $item4->DrgID }} </td>
                                                        <td class="p-2" >{{ $item4->dfsText }}</td>   
                                                        <td class="p-2" >{{ $item4->Packsize }}</td> 
                                                        <td class="text-center" >{{ $item4->sigCode }}</td> 
                                                        <td class="p-2" width="15%">{{ $item4->sigText }}</td> 
                                                        <td class="text-center" >{{ $item4->Quantity }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->UnitPrice, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->ChargeAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->ReimbPrice, 2) }}</td> 
                                                        <td class="text-center" >{{ number_format($item4->ReimbAmt, 2) }}</td> 
                                                        <td class="text-center" >{{ $item4->PrdSeCode }}</td> 
                                                        <td class="text-center" >{{ $item4->Claimcont }}</td> 
                                                        <td class="text-center" >{{ $item4->ClaimCat }}</td> 
                                                        <td class="text-center" >{{ $item4->paidst }}</td> 
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </p>
                            </div>
                             <!-- 5 dru-->
                            <div class="tab-pane" id="dru" role="tabpanel">
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
                                                    <th class="p-2"><input type="checkbox" name="stamp2" id="stamp2" class="me-2">SvPID</th> 
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
                                            {{-- <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ssop_opservices as $item5) 
                                                    <tr id="prescbid{{$item5->ssop_opservices_id}}">   
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
                                                        <td class="p-2" > 
                                                            <input type="checkbox" class="sub_chk2 me-2" data-id="{{$item5->ssop_opservices_id}}">
                                                            <button type="button"class="btn btn-outline-warning btn-sm Edit_svpid"
                                                                value="{{ $item5->ssop_opservices_id }}" data-bs-toggle="tooltip"
                                                                data-bs-placement="left" title="แก้ไข">
                                                                <i class="fa-solid fa-pen-to-square me-2 text-warning"></i>
                                                                <label for="" class="text-warning" style="font-size:13px;"> {{ $item5->SvPID }}</label>
                                                            </button>
                                                        </td> 
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
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </p>
                            </div>
                             <!-- 6 idx-->
                            <div class="tab-pane" id="idx" role="tabpanel">
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
                                            {{-- <tbody>
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
                                            </tbody> --}}
                                             
                                        </table>
                                    </div>
                                </p>
                            </div>

                            <!-- 7 ins-->
                             <div class="tab-pane" id="ins" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example7" class="table table-hover table-sm table-light dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">INSCL</th>
                                                    <th class="text-center">SUBTYPE</th>
                                                    <th class="text-center">CID</th>
                                                    <th class="text-center">DATEIN</th>   
                                                    <th class="text-center" >DATEEXP</th>  
                                                    <th class="text-center" >HOSPMAIN</th> 
                                                    <th class="text-center" >HOSPSUB</th> 
                                                    {{-- <th class="text-center" >GOVCODE</th>  --}}
                                                    {{-- <th class="text-center" >GOVNAME</th>  --}}
                                                    <th class="text-center" >PERMITNO</th> 
                                                    {{-- <th class="text-center" >DOCNO</th>  --}}
                                                    {{-- <th class="text-center" >OWNRPID</th>  --}}
                                                    {{-- <th class="text-center" >OWNRNAME</th>  --}}
                                                    <th class="text-center" >AN</th> 
                                                    <th class="text-center" >SEQ</th> 
                                                    {{-- <th class="text-center" >SUBINSCL</th>  --}}
                                                    {{-- <th class="text-center" >RELINSCL</th>  --}}
                                                    {{-- <th class="text-center" >HTYPE</th>   --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($ins as $item7) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item7->HN }}</td>
                                                        <td class="text-center" >{{ $item7->INSCL }} </td>
                                                        <td class="text-center" >{{ $item7->SUBTYPE }} </td>
                                                        <td class="text-center" >{{ $item7->CID }} </td>                                                       
                                                        <td class="text-center" >{{ $item7->DATEIN }}</td>  
                                                        <td class="text-center" >{{ $item7->DATEEXP }}</td>  
                                                        <td class="text-center" >{{ $item7->HOSPMAIN }}</td>  
                                                        <td class="text-center" >{{ $item7->HOSPSUB }}</td>  
                                                        {{-- <td class="text-center" >{{ $item7->GOVCODE }}</td>   --}}
                                                        {{-- <td class="text-center" >{{ $item7->GOVNAME }}</td>   --}}
                                                        <td class="text-center" >{{ $item7->PERMITNO }}</td>  
                                                        {{-- <td class="text-center" >{{ $item7->DOCNO }}</td>   --}}
                                                        {{-- <td class="text-center" >{{ $item7->OWNRPID }}</td>   --}}
                                                        {{-- <td class="text-center" >{{ $item7->OWNRNAME }}</td>   --}}
                                                        <td class="text-center" >{{ $item7->AN }}</td>  
                                                        <td class="text-center" >{{ $item7->SEQ }}</td>  
                                                        {{-- <td class="text-center" >{{ $item7->SUBINSCL }}</td>   --}}
                                                        {{-- <td class="text-center" >{{ $item7->RELINSCL }}</td>   --}}
                                                        {{-- <td class="text-center" >{{ $item7->HTYPE }}</td>    --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                             
                                        </table>
                                    </div>
                                </p>
                            </div>

                             <!-- 13 odx-->
                             <div class="tab-pane" id="odx" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example13" class="table table-hover table-sm table-light dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">DATEDX</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">DIAG</th>
                                                    <th class="text-center">DXTYPE</th>   
                                                    <th class="text-center">DRDX</th>  
                                                    <th class="text-center">PERSON_ID</th>  
                                                    <th class="text-center">SEQ</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($odx as $item13) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item13->HN }}</td>
                                                        <td class="text-center">{{ $item13->DATEDX }} </td>
                                                        <td class="text-center">{{ $item13->CLINIC }} </td>
                                                        <td class="text-center">{{ $item13->DIAG }} </td>                                                       
                                                        <td class="text-center">{{ $item13->DXTYPE }}</td>  
                                                        <td class="text-center">{{ $item13->DRDX }}</td> 
                                                        <td class="text-center">{{ $item13->PERSON_ID }}</td> 
                                                        <td class="text-center">{{ $item13->SEQ }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                             
                                        </table>
                                    </div>
                                </p>
                            </div>

                             <!-- 14 oop-->
                             <div class="tab-pane" id="oop" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example14" class="table table-hover table-sm table-light dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">DATEOPD</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">OPER</th>
                                                    <th class="text-center">DROPID</th>   
                                                    <th class="text-center" >PERSON_ID</th> 
                                                    <th class="text-center" >SEQ</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($oop as $item14) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item14->HN }}</td>
                                                        <td class="text-center" >{{ $item14->DATEOPD }} </td>
                                                        <td class="text-center" >{{ $item14->CLINIC }} </td>
                                                        <td class="text-center" >{{ $item14->OPER }} </td>                                                       
                                                        <td class="text-center" >{{ $item14->DROPID }}</td>  
                                                        <td class="text-center" >{{ $item14->PERSON_ID }}</td> 
                                                        <td class="text-center" >{{ $item14->SEQ }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                             
                                        </table>
                                    </div>
                                </p>
                            </div>

                             <!-- 15 opd-->
                             <div class="tab-pane" id="opd" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="example15" class="table table-hover table-sm table-light dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th>  
                                                    <th class="text-center">HN</th>
                                                    <th class="text-center">CLINIC</th>
                                                    <th class="text-center">DATEOPD</th>
                                                    <th class="text-center">TIMEOPD</th>
                                                    <th class="text-center">SEQ</th>   
                                                    <th class="text-center" >UUC</th>   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($opd as $item15) 
                                                    <tr>   
                                                        <td class="text-center">{{ $i++ }}</td>    
                                                        <td class="text-center">{{ $item15->HN }}</td>
                                                        <td class="text-center" >{{ $item15->CLINIC }} </td>
                                                        <td class="text-center" >{{ $item15->DATEOPD }} </td>
                                                        <td class="text-center" >{{ $item15->TIMEOPD }} </td>                                                       
                                                        <td class="text-center" >{{ $item15->SEQ }}</td>  
                                                        <td class="text-center" >{{ $item15->UUC }}</td>  
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
