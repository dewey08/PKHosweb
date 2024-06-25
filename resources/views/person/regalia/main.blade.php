@extends('layouts.backend')

<!-- Page JS Plugins CSS -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{ asset('asset/ets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
<link href="{{asset('select2/select2.min.css')}}" rel="stylesheet" />

<style>
    .center {
        margin: auto;
        width: 100%;
        padding: 10px;
    }
    body {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
        
            }
    
            label{
                font-family: 'Kanit', sans-serif;
                font-size: 14px;
                
            } 
    
            @media only screen and (min-width: 1200px) {
    label {
        float:right;
        }
    
            }
    
            
            .text-pedding{
        padding-left:10px;
                        }
    
            .text-font {
        font-size: 13px;
                        }   
            
            


    .form-control {
        font-family: 'Kanit', sans-serif;
        font-size: 13px;
    }
    table, td, th {
        border: 1px solid black;
    }
    .font-table-th{
        font-family: 'Kanit', sans-serif;
        border-color:#F0FFFF;
        text-align: center;
        border: 1px solid black;
    }
    .font-table-td{
        border-color:#F0FFFF;
        font-size: 13px;
        border: 1px solid black;
    }  
    .text-font-content{
        font-family: 'Kanit', sans-serif; 
        font-size: 13px;
        font-weight:normal;
    }

</style>

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">ข้อมูลเครื่องราชอิสริยาภรณ์</h2>
         
                    @include('person.regalia.modal_add')
                <div class="col-md-12" style="margin-top: 30px;">
                    <div class="panel-body" style="overflow-x:auto;">     
                        <div class="table-responsive">
                            <table class="table-striped table-vcenter js-dataTable-simple" width="100%">
                                <thead style="background-color: #FFEBCD;">
                                    <tr height="40">
                                        <th class="text-font font-table-th">ปีที่รับ</th>
                                        <th class="text-font font-table-th">วันที่รับ</th>
                                        <th class="text-font font-table-th">ยศ/ตำแหน่ง</th>
                                        <th class="text-font font-table-th">ชั้นตราเครื่องราช</th>
                                        <th class="text-font font-table-th">รก.ล.</th>
                                        <th class="text-font font-table-th">รก.ด.</th>
                                        <th class="text-font font-table-th">วันที่ประกาศ</th>
                                        <th class="text-font font-table-th">เล่มที่</th>
                                        <th class="text-font font-table-th">หน้าที่</th>
                                        <th class="text-font font-table-th">ลำดับที่</th>
                                        <th class="text-font font-table-th">หน่วยงาน</th>
                                        <th class="text-font font-table-th">คำสั่ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hrd_regalias as $hrd_regalia )
                                        <tr height="40" align="center">
                                            <td class="font-table-td">{{ $hrd_regalia->YEAR_OF_RECEIPT }}</td>
                                            <td class="font-table-td">{{ Datethai($hrd_regalia->DAY_OF_RECEIPT) }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->POSITION }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->BADGE }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->BADGE_R_G_L }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->BADGE_R_G_D }}</td>
                                            <td class="font-table-td">{{ Datethai($hrd_regalia->ANNOUNCEMENT_DATE) }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->VOLUME }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->DUTY }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->NO }}</td>
                                            <td class="font-table-td">{{ $hrd_regalia->AGENCY }}</td>
                                        
                                            <td style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;">
                                                            ทำรายการ
                                                    </button>
                                                    <div class="dropdown-menu" style="width:10px">
                                                    <a class="dropdown-item  loadscreen"  href="{{ url('person/info_regalia/view_edit/'.$hrd_regalia->id)  }}"  
                                                        style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;">แก้ไขข้อมูล</a>
                                                 
                                                        <a class="dropdown-item" style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;"  href="{{ url('person/inforegalia/delete/config/'.$hrd_regalia->id)  }}"  onclick="return confirm('ต้องการที่จะลบข้อมูล ?')">ลบข้อมูล</a>
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
        </div>
    </div>
</div>


@endsection
@section('footer')

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>

 <!-- Page JS Plugins -->
 <script src="{{ asset('asset/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>

 <!-- Page JS Code -->
 <script src="{{ asset('asset/js/pages/be_tables_datatables.min.js') }}"></script>

 <script type="text/javascript">

    $(document).ready(function () {    
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            todayBtn: true,
            language: 'th',  //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true,
            autoclose: true  //Set เป็นปี พ.ศ.
        });  //กำหนดเป็นวันปัจุบัน
        document.getElementById("birth_date").style.display = "none";
    });
    //onclick="return confirm('ต้องการที่จะลบข้อมูลเครื่องราชอิสริยาภรณ์ ?')"
    $(document).on('click','.delete_regalia',function(){
        var id = $(this).attr('data-id');
        if (confirm("ต้องการที่จะลบข้อมูลเครื่องราชอิสริยาภรณ์?")) {
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: 'POST',
                url: "/person/inforegalia/delete/config/"+id,
                data: {
                    _token: token,
                    _method: 'POST',
                    id: id,
                },
                success: function (response) {

                    }
            });
        window.location.reload();
        }
    });

    $(document).on('click','.update_regalia',function(){
        var id = $(this).attr('data-id');
         //console.log(id);
        var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
        type: 'GET',
        url: '{{ url("person/info_regalia/view_edit/'+id+'") }}',
        data: {
            _token: token,
            _method: 'GET',
            id: id,
        },
            success: function (response) {
                console.log("ASD");

            }
        });
        window.location = "person/info_regalia/view_edit/"+id;
    });

</script>
<script src="{{ asset('select2/select2.min.js') }}"></script>
<script>
$(document).ready(function() {
   $("select").select2({ 
	dropdownParent: $("#add_data") 
	});
});
</script>

@endsection