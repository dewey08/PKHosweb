@extends('layouts.pkclaim')
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
    .modal-dis {
        width: 1350px;
        margin: auto;
    }
    @media (min-width: 1200px) {
        .modal-xlg {
            width: 90%; 
        }
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
    {{-- <form action="{{ url('ucep24') }}" method="GET">
            @csrf
    <div class="row"> 
            <div class="col"></div>
            <div class="col-md-1 text-end mt-2">วันที่</div>
            <div class="col-md-4 text-end">
                <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker1'>
                    <input type="text" class="form-control" name="startdate" id="datepicker" placeholder="Start Date" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $startdate }}" required/>
                    <input type="text" class="form-control" name="enddate" placeholder="End Date" id="datepicker2" data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                        data-date-language="th-th" value="{{ $enddate }}"/>  
                </div> 
            </div>
            <div class="col-md-1"> 
            <button type="submit" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info">
                        <i class="fa-solid fa-magnifying-glass text-info me-2"></i>
                        ค้นหา
                    </button> 
                  
            </div>
          
        </div>
    </form> --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    รายละเอียด UCEP
                    <div class="btn-actions-pane-right">
                        <a href="{{url('ucep24')}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning"> 
                            <i class="fa-solid fa-circle-arrow-left text-warning me-2"></i>
                            ย้อนกลับ
                        </a> 
                      
                    </div>
                </div>
                <div class="card-body">

                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">รหัสหมวด</th>
                                <th class="text-center">ชื่อ</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">เบิกได้</th>                           
                                
                                <th class="text-center">เบิกไม่ได้</th> 
                                <th class="text-center">ค่ารักษา UCEP 24</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0; ?>
                            @foreach ($data as $item)
                            <?php $number++; ?>

                            <tr height="20" style="font-size: 14px;">
                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>
                                <td class="text-center" width="10%">                               
                                        {{ $item->income }} 
                                </td>
                                <td class="p-2">{{ $item->nameliss }}</td>
                                <td class="text-center" width="10%">{{ $item->qty }}</td>
                          
                                <td class="text-center"> 
                                    @if ($item->paidst_ucep > 0)
                                    <a href="{{url('ucep24_income/'.$item->an.'/'.$item->income)}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" target="_blank"> 
                                     
                                        {{ $item->paidst02 }}
                                    </a>
                                    @else
                                    {{ number_format($item->paidst02,2)}} 
                                    @endif
                                </td>
                            
                                <td class="text-end" style="color:rgb(73, 147, 231)" width="7%">{{ number_format($item->paidst0103,2)}}</td>
                                <td class="text-end" style="color:rgb(231, 78, 73)" width="7%">
                                 
                                    {{-- @if ($item->paidst_ucep > 0)
                                    <a href="{{url('ucep24_income/'.$item->an.'/'.$item->income)}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info"> 
                                     
                                        {{ $item->paidst_ucep }}
                                    </a>
                                    @else --}}
                                    {{ number_format($item->paidst_ucep,2)}} 
                                    {{-- @endif --}}
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:1500px; max-height:1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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