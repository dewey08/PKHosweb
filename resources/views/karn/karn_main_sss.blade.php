 
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
                    <div class="col-md-1 text-end">วันที่</div>
                    <div class="col-md-2 text-center">
                        <input id="startdate" name="startdate" class="form-control form-control-sm" type="date" value="{{$startdate}}">
                                
                    </div>
                    <div class="col-md-1 text-center">ถึงวันที่</div>
                    <div class="col-md-2 text-center">
                        <input id="enddate" name="enddate" class="form-control form-control-sm" type="date" value="{{$enddate}}">                             
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
                                    <th width="3%" class="text-center">ลำดับ</th>
                                    <th class="text-center">hn</th>
                                    <th class="text-center">an</th>
                                    <th class="text-center">รายการค่าใช้จ่าย</th>
                                    <th class="text-center">fullname</th>
                                    <th class="text-center">cid</th>
                                    <th class="text-center">regdate</th>
                                    <th class="text-center">regtime</th>

                                    <th class="text-center">debname</th>
                                    {{-- <th class="text-center">n2</th> --}}
                                    <th class="text-center">pdx</th>
                                    {{-- <th class="text-center">income</th> --}}
                                    <th class="text-center">name income</th>
                                    <th class="text-center">pttype</th>
                                    <th class="text-center">billcode</th>
                                    {{-- <th class="text-center">ยอดรวม</th> --}}
                                    {{-- <th class="text-center">regtime</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($datashow as $item)                                    
                                    <tr>
                                        <td width="3%">{{$i++ }}</td>
                                        <td>{{$item->hn}}</td>
                                        <td>{{$item->an}}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#payModal{{$item->an }}"> รายการค่าใช้จ่าย / อื่นฯ</button>
                                         
                                        </td>
                                        <td>{{$item->fullname }}</td> 
                                        <td>{{ $item->cid }}</td>                                            
                                        <td class="text-center">{{ $item->regdate }} </td>  
                                        <td class="text-center"> {{ $item->regtime }}</td> 
                                        <td>{{ $item->debname }}</td>  
                                        <td>{{ $item->pdx }}</td>  
                                        <td>
                                            {{-- <button type="button" class="btn btn-info text-white detail" value="{{ $item->an }}" data-bs-toggle="tooltip" data-bs-placement="left" title="รายละเอียด"> {{ $item->namelab }}</button> --}}
                                            <a href="" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->an }}"> {{$item->namelab}}</a>
                                        </td>
                                        <td>{{ $item->pttype }}</td> 
                                        <td>{{ $item->billcode }}</td>  
                                    </tr>

                                    <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{$item->an }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    <label for="" style="color: white"> รายการค่าใช้จ่าย AN == > {{$item->an }} == > คุณ {{$item->fullname }}</label>
                                                   
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body"> 
                                                       <div class="row" >                                                         
                                                            <div class="col-md-1 text-center" >
                                                                <label for="" style="color: darkslategrey">ลำดับ</label>
                                                                </div>
                                                            <div class="col-md-2 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">รหัส</label></div>
                                                            <div class="col-md-6 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">รายการ</label></div>
                                                            <div class="col-md-1 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">จำนวน</label></div>
                                                            <div class="col-md-2 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">ราคา</label></div>
                                                       </div>
                                                       <hr>
                                                       <?php $ii = 1;                                                       
                                                            $datadetail = DB::connection('mysql3')->select('    
                                                                select n.billcode,ifnull(n.name,d.name) as namelab,sum(o.qty) as qt,format(sum(sum_price),2) as pricet
                                                                from opitemrece o
                                                                left outer join nondrugitems n on n.icode = o.icode
                                                                left outer join drugitems d on d.icode = o.icode
                                                                left outer join income i on i.income = o.income
                                                                where o.an ="'.$item->an .'" 
                                                                and o.income= "07"
                                                                and o.sum_price > "0"
                                                                group by o.icode
                                                                order by o.icode
                                                                ');

                                                                $totaldetail = DB::connection('mysql3')->select('    
                                                                select v.hn,v.an 
                                                                ,n.billcode 
                                                                ,op.income 
                                                                ,format(sum(op.sum_price),2) as pricetotal
                                                                from an_stat v
                                                                left outer join opitemrece op on op.an = v.an
                                                                left outer join nondrugitems n on n.icode = op.icode                                               
                                                                where v.dchdate between "2022-08-01" and "2022-08-31" and op.an ="'.$item->an .'" 
                                                                and op.sum_price > "0" 
                                                                and v.pttype in ("06","14","34","35","37","45","s7")                                                                  
                                                            
                                                                ');
                                                        ?>
                                                       @foreach ($datadetail as $item2) 
                                                        <div class="row">                                                        
                                                            <div class="col-md-1 text-center">{{$ii++ }}</div>
                                                            <div class="col-md-2 text-center">{{ $item2->billcode }}</div>
                                                            <div class="col-md-6">{{ $item2->namelab }}</div>
                                                            <div class="col-md-1 text-center">{{ $item2->qt }}</div>
                                                            <div class="col-md-2 text-center">{{ $item2->pricet }}</div>
                                                        </div>
                                                        <hr>
                                                        @endforeach
                                                        <div class="text-end me-5">
                                                            {{-- @foreach ($totaldetail as $item3) 
                                                            <label for="">{{ $item3->pricetotal}}</label>
                                                            @endforeach --}}
                                                            {{-- <label for="">{{ number_format(($item->sum_price),2 )}}</label> --}}
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                                                    <i class="fa-solid fa-xmark me-2"></i>
                                                    Close
                                                </button> 
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="payModal{{$item->an }}" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h5 class="modal-title" id="payModalLabel">
                                                        <label for="" style="color: white"> รายการค่าใช้จ่าย AN == > {{$item->an }} == > คุณ {{$item->fullname }}</label>                                                    
                                                    </h5>                                             
                                                    @foreach ($totaldetail as $item4) 
                                                        <label for="" style="color: white;font-size:17px" class="me-5"><b>ค่าใช้จ่ายทั้งหมด {{ $item4->pricetotal}} บาท</b></label>
                                                    @endforeach
                                            
                                                </div>
                                                <div class="modal-body"> 
                                                       <div class="row">
                                                         
                                                            <div class="col-md-1 text-center" > <label for="" style="color: darkslategrey:font-size:17xp">ลำดับ</label></div>
                                                            <div class="col-md-2 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">รหัสหมวด</label></div>
                                                            <div class="col-md-6 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">รายการ</label></div>
                                                            <div class="col-md-1 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">จำนวน</label></div>
                                                            <div class="col-md-2 text-center"> <label for="" style="color: darkslategrey:font-size:17xp">เบิกได้</label></div>
                                                       </div>
                                                       <hr>
                                                       <?php $ii = 1;                                                       
                                                            $datadetailpay = DB::connection('mysql3')->select('   
                                                            select i.income,i.name as labname,sum(o.qty) as payqty
                                                            ,(select format(sum(sum_price),2) from opitemrece where an=o.an and income = o.income and paidst in("02")) as priceclaim
                                                            from opitemrece o
                                                            left outer join nondrugitems n on n.icode = o.icode
                                                            left outer join income i on i.income = o.income
                                                            where o.an ="'.$item->an .'" 
                                                            group by i.name
                                                            order by i.income 
                                                                ');   
                                                                
                                                        $payroom = DB::connection('mysql3')->select('   
                                                        select n.billcode,n.name,sum(o.qty) as qqt,
                                                        sum(sum_price) as pr,
                                                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03")) from opitemrece o
                                                        left outer join nondrugitems n on n.icode = o.icode
                                                        left outer join income i on i.income = o.income
                                                        where o.an ="'.$item->an .'"  
                                                        and o.income="01"
                                                        and o.icode not in ("3010708","3010601","3010605","3010590","3010604")
                                                        group by n.name
                                                        order by i.income
                                                                ');  

                                                        $covid = DB::connection('mysql3')->select('   
                                                        select n.billcode,n.name,sum(o.qty) as qty6,sum(sum_price) as total6,
                                                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") from opitemrece o
                                                        left outer join nondrugitems n on n.icode = o.icode
                                                        left outer join income i on i.income = o.income 
                                                        where o.an ="'.$item->an .'"
                                                        and o.icode in("3010714","3010715","3010716","3010717","3010718","3010719","3010601","3010605","3010590","3010604","3010602","3010603","3010592","3010591","3010600"
                                                        ,"3000406"
                                                        ,"3000407","3010640","3010641","3010697","3010698","3010601","3010605","3010590","3010604","3010706","3010707","3010708")
                                                        group by n.name
                                                        order by i.income
                                                                ');  

                                                        $covid_ci = DB::connection('mysql3')->select('  
                                                        select n.billcode,n.name as n7,sum(o.qty) as qty7,sum(sum_price) as total7,
                                                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") from opitemrece o
                                                        left outer join nondrugitems n on n.icode = o.icode
                                                        left outer join income i on i.income = o.income 
                                                        where o.an ="'.$item->an .'"
                                                        and o.icode in("3010706","3010707","3010708")
                                                        group by n.name
                                                        order by i.income
                                                                ');  

                                                        $assets = DB::connection('mysql3')->select('  
                                                        select n.billcode,n.name as n8,o.qty as qty8,sum(sum_price) as total8,
                                                        (select sum(sum_price) from opitemrece where an=o.an and income = o.income and paidst in("01","03") and income="02") from opitemrece o
                                                        left outer join nondrugitems n on n.icode = o.icode
                                                        left outer join income i on i.income = o.income 
                                                        where o.an ="'.$item->an .'"
                                                        and o.income="02"
                                                        group by n.name
                                                        order by i.income
                                                                ');  
                                                        ?>
                                                       @foreach ($datadetailpay as $item3) 
                                                        <div class="row">                                                        
                                                            <div class="col-md-1 text-center">{{$ii++ }}</div>
                                                            <div class="col-md-2 text-center">{{ $item3->income }}</div>
                                                            <div class="col-md-6">{{ $item3->labname }}</div>
                                                            <div class="col-md-1 text-center">{{ $item3->payqty }}</div>
                                                            <div class="col-md-2 text-center">
                                                                {{ $item3->priceclaim }}
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @endforeach

                                                        
                                                        <div class="row bg-info">
                                                            <div class="col"></div>
                                                            <div class="col-md-3">
                                                                <label for="" style="color: white;font-size:20px"> รายการค่าใช้จ่ายห้อง</label> 
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>                                                        
                                                        <hr>                                                       
                                                        <div class="row">                                                         
                                                            <div class="col-md-1 text-center" >ลำดับ</div>
                                                            <div class="col-md-2 text-center">รหัส</div>
                                                            <div class="col-md-5 text-center">รายการ</div>
                                                            <div class="col-md-2 text-center">จำนวนวันที่นอน</div>
                                                            <div class="col-md-2 text-center">เบิกได้</div>
                                                       </div>
                                                       <hr>
                                                        <?php $iii = 1; ?>
                                                        @foreach ($payroom as $item5) 
                                                        <div class="row">                                                        
                                                                <div class="col-md-1 text-center">{{$iii++}}</div>
                                                            <div class="col-md-2 text-center">{{$item5->billcode}}</div>
                                                            <div class="col-md-5">{{$item5->name}}</div>
                                                            <div class="col-md-2 text-center">{{$item5->qqt}}</div>
                                                            <div class="col-md-2 text-center">
                                                               {{ number_format(($item5->pr),2 )}}
                                                            </div>
                                                        </div>
                                                        <hr>                                                        
                                                        @endforeach


                                                        <div class="row bg-info">
                                                            <div class="col"></div>
                                                            <div class="col-md-3">
                                                                <label for="" style="color: white;font-size:20px"> รายการ COVID</label> 
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>                                                        
                                                        <hr>                                                       
                                                        <div class="row">                                                         
                                                            <div class="col-md-1 text-center" >ลำดับ</div>
                                                            <div class="col-md-2 text-center">รหัส</div>
                                                            <div class="col-md-5 text-center">รายการ</div>
                                                            <div class="col-md-2 text-center">จำนวนวันที่นอน</div>
                                                            <div class="col-md-2 text-center">เบิกได้</div>
                                                        </div>
                                                        <hr>
                                                        <?php $iiii = 1; ?>
                                                        @foreach ($covid as $item6) 
                                                            <div class="row">                                                        
                                                                <div class="col-md-1 text-center">{{$iiii++}}</div>
                                                                <div class="col-md-2 text-center">{{$item6->billcode}}</div>
                                                                <div class="col-md-5">{{$item6->name}}</div>
                                                                <div class="col-md-2 text-center">{{$item6->qty6}}</div>
                                                                <div class="col-md-2 text-center">
                                                                {{ number_format(($item6->total6),2 )}}
                                                                </div>
                                                            </div>
                                                            <hr>                                                        
                                                        @endforeach


                                                        <div class="row bg-info">
                                                            <div class="col"></div>
                                                            <div class="col-md-3">
                                                                <label for="" style="color: white;font-size:20px"> รายการ COVID CI</label> 
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>                                                        
                                                        <hr>                                                       
                                                        <div class="row">                                                         
                                                            <div class="col-md-1 text-center" >ลำดับ</div>
                                                            <div class="col-md-2 text-center">รหัส</div>
                                                            <div class="col-md-5 text-center">รายการ</div>
                                                            <div class="col-md-2 text-center">จำนวนวันที่นอน</div>
                                                            <div class="col-md-2 text-center">เบิกได้</div>
                                                       </div>
                                                       <hr>
                                                       <?php $j = 1; ?>
                                                       @foreach ($covid_ci as $item7) 
                                                       <div class="row">                                                        
                                                            <div class="col-md-1 text-center">{{$j++}}</div>
                                                            <div class="col-md-2 text-center">{{$item7->billcode}}</div>
                                                            <div class="col-md-5">{{$item7->n7}}</div>
                                                            <div class="col-md-2 text-center">{{$item7->qty7}}</div>
                                                            <div class="col-md-2 text-center">{{ number_format(($item7->total7),2 )}}</div>
                                                        </div>
                                                        <hr>                                                        
                                                        @endforeach


                                                        <div class="row bg-info">
                                                            <div class="col"></div>
                                                            <div class="col-md-3">
                                                                <label for="" style="color: white;font-size:20px"> รายการค่าอุปกรณ์</label> 
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>                                                        
                                                        <hr>                                                       
                                                        <div class="row">                                                         
                                                            <div class="col-md-1 text-center" >ลำดับ</div>
                                                            <div class="col-md-2 text-center">รหัส</div>
                                                            <div class="col-md-5 text-center">รายการ</div>
                                                            <div class="col-md-2 text-center">จำนวนวันที่นอน</div>
                                                            <div class="col-md-2 text-center">เบิกได้</div>
                                                       </div>
                                                       <hr>
                                                       <?php $jj = 1; ?>
                                                       @foreach ($assets as $item8) 
                                                       <div class="row">                                                        
                                                            <div class="col-md-1 text-center">{{$jj++}}</div>
                                                            <div class="col-md-2 text-center">{{$item8->billcode}}</div>
                                                            <div class="col-md-5">{{$item8->n8}}</div>
                                                            <div class="col-md-2 text-center">{{$item8->qty8}}</div>
                                                            <div class="col-md-2 text-center"> {{ number_format(($item8->total8),2 )}}</div>
                                                        </div>
                                                        <hr>                                                        
                                                        @endforeach
                                                        

                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                                                    <i class="fa-solid fa-xmark me-2"></i>
                                                    Close
                                                </button> 
                                                </div>
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
    </div>
</div>

 <!--  Modal content for the above ci -->
 <div class="modal fade bs-example-modal-lg" id="labdetail" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">รายละเอียด</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
 
                                <div class="table-responsive"> 
                                    <table class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" > 
                               
                                        <thead>
                                            <tr>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>11</td>
                                                <td>22</td>
                                                <td>33</td>
                                                <td>44</td>
                                                <td>55</td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
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
        });
        $(document).on('click','.detail',function(){
                var an = $(this).val();
                // alert(line_token_id);
                        $('#labdetail').modal('show');
                        $.ajax({
                        type: "GET",
                        url:"{{url('k.karn_main_sss_detail')}}" +'/'+ an,  
                        success: function(data) {
                            console.log(data.datadetail.billcode);
                            $('#billcode').val(data.datadetail.billcode)  
                            $('#namelab').val(data.datadetail.namelab) 
                            $('#qt').val(data.datadetail.qt)    
                             $('#pricet').val(data.datadetail.pricet)             
                        },      
                });
        });

    </script>
@endsection
