@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || Stm-Walkin')
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
        $tel_ = Auth::user()->tel;
        $debsubsub = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $datenow = date('Y-m-d');
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SoteController;
    $refnumber = SoteController::refnumber();
    ?>
    <style>
        body{
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }
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
            border: 5px #ddd solid;
            border-top: 10px rgb(252, 161, 119) solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }
        
        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
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
        <form action="{{ url('hpv_report') }}" method="GET">
            @csrf
            <div class="row "> 
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(252, 161, 119)">Detail Report HPV</h4>
                    <p class="card-title-desc">รายละเอียดข้อมูล</p>
                </div>
                 
                <div class="col"></div>
                <div class="col-md-1 text-end mt-2">วันที่</div>
                <div class="col-md-5 text-end"> 
                    
                    <div class="input-daterange input-group" id="datepicker1" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control cardclaim" name="startdate" id="datepicker" placeholder="Start Date"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $startdate }}" required/>
                        <input type="text" class="form-control cardclaim" name="enddate" placeholder="End Date" id="datepicker2"
                            data-date-container='#datepicker1' data-provide="datepicker" data-date-autoclose="true" autocomplete="off"
                            data-date-language="th-th" value="{{ $enddate }}" required/>  
                        <button type="submit" class="ladda-button btn-pill btn btn-info cardclaim" data-style="expand-left">
                            <span class="ladda-label"> <i class="fa-solid fa-magnifying-glass text-white me-2"></i>ค้นหา</span>
                            <span class="ladda-spinner"></span>
                        </button>
                        <button type="button" class="ladda-button me-2 btn-pill btn btn-primary cardclaim" data-style="expand-left" id="Pulldata">
                            <span class="ladda-label"> <i class="fa-solid fa-file-circle-plus text-white me-2"></i>ดึงข้อมูล</span>
                            <span class="ladda-spinner"></span>
                        </button> 
               
                </div>
                </div>
            </div>
        </form>  


        <div class="row">
            <div class="col-xl-12">
                <div class="card cardclaim">
                  
                    <div class="table-responsive p-4"> 
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th> 
                                    <th class="text-center">hn</th> 
                                    <th class="text-center">vstdate</th> 
                                    <th class="text-center">cid</th>
                                    <th class="text-center">ptname</th>
                                    <th class="text-center">pttype</th> 
                                    <th class="text-center">debit</th>
                                    <th class="text-center">pp</th>
                                    <th class="text-center">fs</th>
                                    <th class="text-center">ชดเชยทั้งหมด</th>
                                    <th class="text-center">STMdoc</th>
                                    <th class="text-center">VA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 0;
                                    $total1 = 0;
                                    $total2 = 0;
                                    $total3 = 0;
                                    $total4 = 0;
                                    $total5 = 0;
                                 ?>
                                @foreach ($hpv_report as $item)
                                    <?php $number++; ?> 
                                    <tr id="#sid{{ $item->d_hpv_report_id }}">
                                        <td class="text-center" width="3%">{{ $number }}</td> 
                                        <td class="text-center" width="5%">{{ $item->hn }}</td> 
                                        <td class="text-center" width="8%">{{ $item->vstdate }} </td> 
                                        <td class="text-center" width="8%">{{ $item->cid }} </td>
                                        <td class="text-start">{{ $item->ptname }} </td>
                                        <td class="text-center" width="5%">{{ $item->pttype }} </td> 
                                        <td class="text-center" width="8%">{{ $item->debit }} </td>
                                        <td class="text-center" width="8%">{{ $item->pp }} </td>
                                        <td class="text-center" width="8%">{{ $item->fs }} </td>
                                        <td class="text-center" width="8%">{{ $item->total_approve }} </td>
                                        <td class="text-start" width="10%">{{ $item->STMdoc }} </td>
                                        <td class="text-center" width="8%">{{ $item->va }} </td>
                                    </tr>
                                    <?php
                                            $total1 = $total1 + $item->debit;
                                            $total2 = $total2 + $item->pp;
                                            $total3 = $total3 + $item->fs; 
                                            $total4 = $total4 + $item->total_approve; 
                                            $total5 = $total5 + ($item->debit-$item->pp); 
                                    ?> 
                                @endforeach 
                            </tbody>
                                    <tr style="background-color: #f3fca1">
                                        <td colspan="6" class="text-end" style="background-color: #fca1a1"></td>
                                        <td class="text-center" style="background-color: #47A4FA"><label for="" style="color: #FFFFFF">{{ number_format($total1, 2) }}</label></td>
                                        <td class="text-center" style="background-color: #5ad865" ><label for="" style="color: #FFFFFF">{{ number_format($total2, 2) }}</label></td>
                                        <td class="text-center" style="background-color: #5ff76c"><label for="" style="color: #FFFFFF">{{ number_format($total3, 2) }}</label> </td> 
                                        <td class="text-center" style="background-color: #18c527"><label for="" style="color: #FFFFFF">{{ number_format($total4, 2) }}</label> </td> 
                                        <td colspan="1" class="text-end" style="background-color: #fca1a1"></td>
                                        <td class="text-center" style="background-color: #f86855"><label for="" style="color: #FFFFFF">{{ number_format($total5, 2) }}</label> </td>
                                    </tr> 
                        </table>
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
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });
            // dabyear

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#Pulldata').click(function() {
                var startdate = $('#datepicker').val(); 
                var enddate = $('#datepicker2').val(); 
                Swal.fire({
                        title: 'ต้องการดึงข้อมูลใช่ไหม ?',
                        text: "You Warn Pull Data!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, pull it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#overlay").fadeIn(300);　
                                $("#spinner").show(); //Load button clicked show spinner 
                                
                                $.ajax({
                                    url: "{{ route('claim.hpv_report_pull') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    data: {
                                        startdate,
                                        enddate                        
                                    },
                                    success: function(data) {
                                        if (data.status == 200) { 
                                            Swal.fire({
                                                title: 'ดึงข้อมูลสำเร็จ',
                                                text: "You Pull data success",
                                                icon: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#06D177',
                                                confirmButtonText: 'เรียบร้อย'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    console.log(
                                                        data);
                                                    window.location.reload();
                                                    $('#spinner').hide();//Request is complete so hide spinner
                                                        setTimeout(function(){
                                                            $("#overlay").fadeOut(300);
                                                        },500);
                                                }
                                            })
                                        } else {
                                            
                                        }
                                    },
                                });
                                
                            }
                })
            });
 
           
        });
    </script>

@endsection
