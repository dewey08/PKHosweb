@extends('layouts.medicalslide')
@section('title', 'PK-OFFICER || เครื่องมือแพทย์')
 
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
                   border: 5px #ddd solid;
                   border-top: 10px #12c6fd solid;
                   border-radius: 50%;
                   animation: sp-anime 0.8s infinite linear;
                   }
                   @keyframes sp-anime {
                   100% { 
                       transform: rotate(360deg); 
                   }
                   }
                   .is-hide{
                   display:none;
                   }
        </style>
       <div class="container-fluid">
            <div id="preloader">
                <div id="status">
                    <div class="spinner">
                        
                    </div>
                </div>
            </div>
            <div class="row "> 
                <div class="col-6 col-md-4 col-xl-12 mt-3">  
                 
                        <form action="{{ route('med.med_store_subsave') }}" method="POST">
                            @csrf
                        <div class="card">
                            <div class="card-body text-center shadow-lg"> 
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="date_rep">รายการเครื่องมือแพทย์ :</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="hidden" id="medical_store_rep_id" name="medical_store_rep_id" class="form-control" value="{{$id}}">
                                            <select name="article_id" id="article_id" class="form-control" style="width: 100%">
                                                <option value=""></option>
                                                @foreach ($article_data as $item)
                                                <?php  $idarticle = DB::table('medical_stock')->where('article_id','=',$item->article_id)->count();?>
                                                @if ($idarticle > 0)
                                                
                                                @else
                                                <option value="{{$item->article_id}}">{{ $item->article_num}} {{ $item->article_name}}</option>
                                                @endif
                                               
                                                @endforeach
                                            </select>
                                        </div>   
                                    </div>
                                    
                                    <div class="col-md-1 text-start">
                                        {{-- <a href="" class="btn btn-outline-info btn-sm"><i class="fa-solid fa-plus me-2"></i>เพิ่ม</a> --}}
                                        <button type="submit" class="btn btn-outline-info btn-sm">
                                            {{-- <button type="button" id="Savebtn" class="btn btn-outline-info btn-sm"> --}}
                                            <i class="fa-solid fa-plus me-2"></i>
                                            เพิ่ม
                                        </button>
                                    </div>
                                </div>
                            </form>
                                <div class="row mt-4"> 
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>ลำดับ</th>
                                                        <th>เลขครุภัณฑ์</th>
                                                        <th>ชื่อครุภัณฑ์</th>                                                       
                                                        <th>จำนวน</th>
                                                        <th>หน่วย</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php $i = 1; ?>
                                                    @foreach ($data_repsub as $item) 
                                                        <tr style="font-size: 12px;" id="sid{{$item->article_id }}">  
                                                            <td width="5%">{{ $i++ }}</td> 
                                                            <td class="text-start">{{$item->article_num }}</td>
                                                            <td class="text-start">{{$item->article_name }}</td>
                                                            <td class="text-start">{{$item->qty }}</td>
                                                            <td class="text-start">{{$item->unit_name }}</td>
                                                            <td width="10%">
                                                                <div class="btn-group">
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                                        ทำรายการ 
                                                                    </button>
                                                                    <div class="dropdown-menu"> 
                                                                        <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                                            onclick="med_condestroy({{ $item->article_id }})"
                                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                                            data-bs-custom-class="custom-tooltip" title="ลบ">
                                                                            <i class="fa-solid fa-trash-can me-2 mb-1"></i>
                                                                            <label for=""
                                                                                style="color: rgb(255, 2, 2);font-size:13px">ลบ</label>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td> 
                                                        </tr>
                                                    @endforeach 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                
                               
                            </div>
                        
                        
                    {{-- </a> --}}
                </div> 
            </div>
            
        </div>
        
@endsection
@section('footer')
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#article_id').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#Savebtn').click(function() {
            var article_id = $('#article_id').val();  
            var medical_store_rep_id = $('#medical_store_rep_id').val(); 
            alert(article_id);
            $.ajax({
                url: "{{ route('med.med_store_subsave') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    article_id,medical_store_rep_id 
                },
                success: function(data) {
                    if (data.status == 200) {
                        Swal.fire({
                            title: 'เพิ่มข้อมูลสำเร็จ',
                            text: "You Insert data success",
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
                                // window.location="{{url('warehouse/warehouse_index')}}";
                            }
                        })
                    } else {
                        

                    }

                },
            });
        });
         
    });
    
</script>

@endsection
