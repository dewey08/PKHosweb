@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || IMC')
 
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
        
                    <form action="{{ route('data.imc') }}" method="POST">
                    @csrf

                    <div class="row">  
                        <div class="col-md-2 text-end">วันที่</div>
                        <div class="col-md-6 text-center">
                            <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' autocomplete="off"
                                 data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $startdate }}"/>
                                <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true" data-date-language="th-th" value="{{ $enddate }}"/>
                                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    ดึงข้อมูล 
                                </button>
                                <a href="{{url('aipn_send_all')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>  
                                {{-- <a href="{{url('aipn_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>    --}}
                            </div>
                          
                        </div>
                       
                        
                        <div class="col"></div>
                    </div> 
                </form>

                {{-- <form action="{{ route('data.imc') }}" method="POST">
                    @csrf
                    <br>
                    <div class="row"> 
                        <div class="col-md-2 text-end">AN</div>
                        <div class="col-md-6 text-center">
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control" name="AN" id="AN" placeholder="AN" required> 
                                <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    ดึงข้อมูล 
                                </button> 
                                <a href="{{url('aipn_send_an')}}" class="btn btn-success"><i class="fa-solid fa-arrow-up-right-from-square me-2"></i>ส่งออก</a>  
                                <a href="{{url('aipn_zip')}}" class="btn btn-danger"><i class="fa-solid fa-file-zipper me-2"></i>ZipFile</a>                                   
                            </div>
                        </div>    
                        <div class="col"></div>
                    </div> 
                </form> --}}
                
         
       

        <div class="row mt-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        {{-- <h4 class="card-title">Detail AIPN</h4>
                        <p class="card-title-desc">รายละเอียดประกันสังคมผู้ป่วยใน</p> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail IMC</h4>
                                <p class="card-title-desc">รายละเอียดกายภาพบำบัด IMC ในโรงพยาบาล</p>
                            </div>
                            <div class="col"></div>
                            <div class="col-md-2 text-end">
                                {{-- <button class="btn btn-secondary" id="Changbillitems"><i class="fa-solid fa-wand-magic-sparkles me-3"></i>ปรับ bilitems</button>  --}}
                                
                            </div>
                        </div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                         
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#IMC" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">IMC</span>    
                                </a>
                            </li>
                          
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPDx" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IPDx</span>    
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#IPOp" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">IPOp</span>    
                                </a>
                            </li> --}}
                           
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted"> 
                            
                            <div class="tab-pane active" id="IMC" role="tabpanel">
                                <p class="mb-0">
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ลำดับ</th> 
                                                    <th class="text-center" width="5%">an</th> 
                                                    <th class="text-center">hn</th>
                                                    <th class="text-center" >cid</th> 
                                                    <th class="text-center">ptname</th>
                                                    <th class="text-center">pttype</th> 
                                                    <th class="text-center">icd10</th>
                                                    <th class="text-center">dchdate</th> 
                                                    <th class="text-center">regdate</th>
                                                    <th class="text-center">income</th> 
                                                    <th class="text-center">paid_money</th> 
                                                    <th class="text-center">debit</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($data as $item) 
                                                    <tr style="font-size: 13px;">   
                                                        <td class="text-center">{{ $i++ }}</td>   
                                                        <td class="text-center" width="7%">{{ $item->an }}</td> 
                                                        <td class="text-center">{{ $item->hn }}</td> 
                                                        <td class="text-center">{{ $item->cid }}</td>  
                                                        <td class="p-2">{{ $item->ptname }}</td>  
                                                        <td class="text-center">{{ $item->pttype }}</td> 
                                                        <td class="p-2">{{ $item->icd10 }}</td>  
                                                        <td class="text-center" width="7%">{{ $item->dchdate }}</td> 
                                                        <td class="text-center" width="7%">{{ $item->regdate }}</td> 
                                                        <td class="text-center" width="7%">{{ $item->income }}</td>  
                                                        <td class="text-center" width="7%">{{ $item->paid_money }}</td> 
                                                        <td class="text-center" width="7%">{{ $item->debit }}</td>  
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </p>
                            </div>
                            {{-- <div class="tab-pane" id="IPDx" role="tabpanel">
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
                                                    <tr style="font-size: 12px;">   
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
                            </div> --}}

                            {{-- <div class="tab-pane" id="IPOp" role="tabpanel">
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
                                                    <tr style="font-size: 12px;">   
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
                            </div> --}}
                             
                        </div>
 

                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row mt-2">
           
            <div class="col-xl-12">
                <div class="card"> 
                    <div class="card-body">
                        <div class="row mt-2 ms-3">
                            <div class="col-md-4">
                                <h4 class="card-title">Detail BillItems</h4>
                                <p class="card-title-desc">รายละเอียด BillItems ผู้ป่วยใน</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="ex_1" class="table table-striped"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">ลำดับ</th>   
                                                <th class="text-center">AN</th> 
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($aipn_billitems as $item2) 
                                                <tr id="sidb{{$item2->aipn_billitems_id }}" style="font-size: 12px;">   
                                                    <td class="text-center">{{ $i++ }}</td>  
                                                    <td class="text-center">{{ $item2->AN }} </td> 
                                                    <td class="text-center" width="5%">{{ $item2->BillGr }} </td>                                                         
                                                    <td class="text-center" width="5%">{{ $item2->BillGrCS }}</td>   
                                                   @if ($item2->CodeSys == 'TMT' && $item2->STDCode == '')
                                                        <td class="text-center" style="background-color: rgb(241, 6, 45)" width="5%">{{ $item2->CodeSys }} </td> 
                                                    @elseif ($item2->CodeSys == 'TMLT' && $item2->STDCode == '')
                                                        <td class="text-center" style="background-color: rgb(252, 2, 44)" width="5%">{{ $item2->CodeSys }} </td> 
                                                   @else
                                                        <td class="text-center" width="5%">{{ $item2->CodeSys }} </td> 
                                                   @endif 
                                                    <td class="text-center" width="5%">{{ $item2->CSCode }}</td> 
                                                    <td class="text-center" width="5%">{{ $item2->STDCode }} </td> 
                                                    <td class="text-center" width="5%">{{ $item2->ClaimCat }} </td> 
                                                    <td class="text-center" width="10%">
                                                        
                                                        <a href="{{url('aipn_billitems_destroy/'.$item2->aipn_billitems_id)}}" data-bs-toggle="tooltip" data-bs-placement="left" title="ลบ" class="btn btn-outline-danger btn-sm"> 
                                                            <i class="fa-solid fa-trash-can text-danger me-2"></i> 
                                                            {{ $item2->LCCode }} 
                                                        </a>                                                            
                                                    </td> 
                                                    <td class="p-2">{{ $item2->Descript }}</td>
                                                    <td class="text-center" width="5%">{{ $item2->QTY }}</td>
                                                    <td class="text-center" width="5%">{{ number_format($item2->UnitPrice, 2) }}</td>
                                                    <td class="text-center" width="5%">{{ number_format($item2->ChargeAmt, 2) }}</td> 
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
        </div> --}}
               
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

        $('#ex_1').DataTable();
        $('#ex_2').DataTable();
        $('#ex_3').DataTable();
 
        // $("#spinner-div").hide(); //Request is complete so hide spinner
       
     
  
        
       
    });
</script>
@endsection
