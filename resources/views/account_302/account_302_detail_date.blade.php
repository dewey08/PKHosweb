@extends('layouts.accountpk')
@section('title', 'PK-OFFICER || ACCOUNT')
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
            border-top: 10px #1fdab1 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(390deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style>

    <div class="tabs-animation">

        <div class="row text-center">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div> 
        </div> 
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>

        <form action="{{ url('account_302_detail_date') }}" method="GET">
            @csrf
    <div class="row"> 
        <div class="col-md-4">
            <h5 class="card-title">Detail 1102050101.302</h5>
            <p class="card-title-desc">รายละเอียดข้อมูล ผัง 1102050101.302</p>
        </div>
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control inputacc" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control inputacc" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
              
                    {{-- <button type="submit" class="btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button>   --}}
                    <button type="submit" class="ladda-button me-2 btn-pill btn btn-primary inputacc" data-style="expand-left">
                        <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                        <span class="ladda-spinner"></span>
                    </button> 
                    
                </div> 
            </div>
          
        </div>
    </form>

    <div class="row">
        <div class="col-xl-12">
                <div class="card cardacc">
                    {{-- <div class="card-header">
                    รายละเอียด 1102050101.302
                        <div class="btn-actions-pane-right">

                        </div>
                    </div> --}}
                    <div class="card-body">
                        {{-- <h4 class="card-title" style="color:rgb(10, 151, 85)">รายละเอียด 1102050101.302</h4> --}}
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        {{-- <th class="text-center" width="5%">repno</th> --}}
                                        <th class="text-center">an</th>
                                        <th class="text-center" >vn</th>
                                        <th class="text-center" >hn</th>
                                        <th class="text-center" >cid</th>
                                        <th class="text-center">ptname</th>

                                        <th class="text-center">vstdate</th>
                                        {{-- <th class="text-center">dchdate</th> --}}
                                        <th class="text-center">pttype</th>
                                        
                                        <th class="text-center">ลูกหนี้</th>
                                        {{-- <th class="text-center">ยอดชดเชย</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $number = 0; ?>
                                    @foreach ($data as $item)
                                        <?php $number++; ?>
                                    
                                            <tr height="20" style="font-size: 14px;">
                                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td> 
                                                <td class="text-center" width="10%">{{ $item->an }}</td>  
                                                        <td class="text-center" width="10%">{{ $item->vn }}</td> 
                                                        <td class="text-center" width="10%">{{ $item->hn }}</td>   
                                                        <td class="text-center" width="10%">{{ $item->cid }}</td>  
                                                        <td class="p-2" >{{ $item->ptname }}</td>  
                                                        <td class="text-center" width="10%">{{ $item->vstdate }}</td>    
                                                        <td class="text-center" width="10%">{{ $item->pttype }}</td> 
                                                        <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->debit_total,2)}}</td>
                                                        {{-- <td class="text-end" width="10%" style="color:rgb(216, 95, 14)"> 
                                                            {{ number_format($item->pricereq_all,2)}}   --}}
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
            $('#hospcode').select2({
                placeholder: "--เลือก--",
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
