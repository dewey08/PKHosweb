@extends('layouts.report_font')
@section('title', 'PK-OFFICER || ACCOUNT')
@section('content')
 
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
    <form action="{{ url('check_bumbat') }}" method="GET">
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
    </form>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    รายละเอียด ค่าอวัยวะเทียม/อุปกรณ์ในการบำบัดรักษา
                    <div class="btn-actions-pane-right">
                            <!-- Button trigger modal -->
                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Launch demo modal
                            </button> -->
                    </div>
                </div>
                <div class="card-body">

                    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">an</th>
                                <th class="text-center">hn</th>
                                <th class="text-center">cid</th>
                                <th class="text-center">dchdate</th> 
                                <th class="text-center">ptname</th>                             
                                {{-- <th class="text-center">rw</th>  --}}
                                {{-- <th class="text-center">อุปกรณ์</th>  --}}
                                <th class="text-center">pdx</th> 
                                <th class="text-center">icd9</th> 
                                {{-- <th class="text-center">DOCTOR</th>  --}}
                                
                                <th class="text-center">icode</th> 
                                <th class="text-center">รายการอุปกรณ์</th> 
                                <th class="text-center">ค่าอวัยวะเทียม</th> 
                                <th class="text-center">income</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $number = 0; ?>
                            @foreach ($data as $item)
                            <?php $number++; ?>

                            <tr height="20" style="font-size: 14px;">
                                <td class="text-font" style="text-align: center;" width="4%">{{ $number }}</td>
                                <td class="text-center" width="5%"> 
                                    {{ $item->an }}
                                    {{-- <a href="{{url('check_bumbat_/'.$item->an)}}" class="me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" target="_blank"> 
                                        <i class="fa-solid fa-asterisk text-info me-2"></i>
                                        {{ $item->an }}
                                    </a>                                    --}}
                                </td>
                                <td class="text-center" width="5%">{{ $item->hn }}</td>
                                <td class="text-center" width="10%">{{ $item->cid }}</td>
                                <td class="text-center" width="7%">{{ $item->dchdate }}</td> 
                                <td class="p-2">{{ $item->ptname }}</td>
                                {{-- <td class="text-center" width="5%">{{ $item->rw }}</td> --}}
                                {{-- <td class="p-2">{{ $item->incomename }}</td> --}}
                                <td class="text-center" width="5%">{{ $item->pdx }}</td>
                                <td class="text-center" width="5%">{{ $item->ICD9 }}</td>
                                {{-- <td class="p-2" width="10%">{{ $item->DOCTOR }}</td> --}}
                                {{-- <td class="text-center" width="10%">{{ $item->pttype }}</td> --}}
                               
                                <td class="text-center" width="10%">{{ $item->icode }}</td> 
                                <td class="p-2">{{ $item->inname }}</td>
                                <td class="text-end" width="10%">{{ number_format($item->sum_price,2)}}</td>
                                <td class="text-end" width="10%">{{ number_format($item->income,2)}}</td>
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