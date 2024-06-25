@extends('layouts.pkclaim')
@section('title', 'PK-OFFICER || FS EClaim')
 
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
    $ynow = date('Y')+543;
    $yb =  date('Y')+542;
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

        .is-hide {
            display: none;
        }
    </style>

    <?php
        $ynow = date('Y')+543;
        $yb =  date('Y')+542;
    ?>

   <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner"> 
                </div>
            </div>
        </div>
        
        <div class="row ">    
            <div class="col-xl-12 col-md-5">
                <div class="main-card mb-3 card">   
                        <div class="table-responsive mt-2 ms-2 me-2"> 
                                    <table id="Tabledit" class="table table-striped table-hover table-sm" style="border-collapse: collapse;border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr> 
                                        <th class="text-center" width="5%">icode</th> 
                                        <th class="text-center" width="5%">income</th> 
                                        <th class="text-center" width="5%">รหัส FS</th>
                                        <th class="text-center" width="5%">รหัส HOSxP</th>
                                        <th class="text-center">ชื่อ</th>
                                        <th class="text-center" width="5%">ราคา FS</th>
                                        <th class="text-center" width="5%">ราคาทั่วไป1</th>
                                        <th class="text-center" width="5%">ราคาพิเศษ1</th>
                                        <th class="text-center" width="5%">ราคาพิเศษ2</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $ii = 1; ?>
                                    @foreach ($datashow_ as $item2) 
                                    <tr>   
                                        <td class="text-center">{{ $item2->icode }}</td> 
                                        <td class="text-center" width="5%">{{ $item2->group2 }}</td> 
                                        <td class="text-center">{{ $item2->fbillcode }}</td> 
                                        <td class="text-center">{{ $item2->nbillcode }}</td> 
                                        <td class="text-start" width="20%">{{ $item2->dname }}</td> 
                                        <td class="text-end">
                                            <button  class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success">
                                                {{-- <a href="{{url('fs_eclaim_instu_eclaim/'.$item2->icode)}}" class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item2->icode}}"> --}}
                                                {{ $item2->pay_rate }}
                                            </button>  
                                        </td> 
                                        <td class="text-end">{{ $item2->price }}</td> 
                                        <td class="text-end">{{ $item2->price2 }}</td> 
                                        <td class="text-end">{{ $item2->price3 }}</td> 
                                        {{-- <td class="text-start">{{ $item2->type }}</td>  --}}
                                        {{-- <td class="text-center">{{ $item2->nhso_adp_code }}</td>   --}}
                                        
                                    </tr>

                                     <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{$item2->icode}}"  tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">ปรับราคา</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body"> 
                                                    <div class="input-group">
                                                        <div class="input-group-text">
                                                            <span class="">ราคาทั่วไป1</span>
                                                        </div>
                                                        <input type="text" id="price" name="price" class="form-control" value="{{$item2->price}}">
                                                    </div>
                                                    <br>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-text">
                                                            <span class="">ราคาพิเศษ1</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="price2" name="price2" value="{{$item2->price2}}">
                                                    </div>
                                                    <br>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-text">
                                                            <span class="">ราคาพิเศษ2</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="price3" name="price3" value="{{$item2->price3}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer"> 
                                                    <button class="mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-info" id="PriceSave">
                                                        <i class="pe-7s-diskette btn-icon-wrapper"></i>Save changes
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

@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            // $('#Tabledit').DataTable();
            $('#Tabledit').Tabledit({
                url:'{{route("claim.fs_eclaim_editable")}}',
                dataType:"json",
                // editButton: true,
                removeButton: false,
                columns:{
                    identifier:[0,'icode'],
                    // editable:[[1,'group2'],[2,'fbillcode'],[3,'nbillcode'],[4,'dname'],[5,'pay_rate'],[6,'price'],[7,'price2'],[8,'price3']]
                    editable: [[6, 'price'], [7, 'price2'], [8, 'price3']]
                },
                // restoreButton:false,
                deleteButton: false,
                saveButton: false,
                autoFocus: false,
                buttons: {
                    edit: {
                        class: 'mb-2 me-2 btn-icon btn-shadow btn-dashed btn btn-outline-warning',
                        html: '<i class="fa-regular fa-pen-to-square"></i>',
                        action: 'Edit'
                    }
                },
                // onSuccess:function(data,textStatus,jqXHR)
                // {
                //     if (data.action == 'delete') 
                //     {
                //         $('#'+data.icode).remove();
                //     }
                // }

            });

            $('#p4p_work_month').select2({
                placeholder: "--เลือก--",
                allowClear: true
            });
            $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datepicker3').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker4').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
