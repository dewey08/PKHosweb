@extends('layouts.backend_admin')
   


@section('content')
<div class="content">
    <div class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-left">
        <div>
            <h1 class="h2 mb-1">
                <i class="fas fa-server"></i> Datacenter Sync
            </h1>
            <p class="mb-0">
                ระบบส่งข้อมูล  <a class="font-w500" href="javascript:void(0)">Datacenter</a>.
            </p>
        </div>
        <div class="mt-4 mt-md-0">

        </div>
    </div>
</div>
<div class="content">

    <div class="row">
        <div class="col-md-8">
            <div class="block block-rounded block-mode-loading-refresh">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        Latest Orders
                    </h3>
                    {{-- <div class="block-options">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                        <div class="dropdown">
                            <button type="button" class="btn-block-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="si si-chemistry"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-dot-circle opacity-50 mr-1"></i> Pending
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-times-circle opacity-50 mr-1"></i> Canceled
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="far fa-fw fa-check-circle opacity-50 mr-1"></i> Completed
                                </a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-eye opacity-50 mr-1"></i> View All
                                </a>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="block-content">
                    {{-- <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm"> --}}
                   @include('datacentersync.table')
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-center">
                    <p id="process"></p>
                   
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex flex-column">
            <div class="block block-rounded">
                <div class="block-content block-content-full d-flex justify-content-between align-items-center flex-grow-1">
                    <div class="mr-3">
                        <p class="font-size-h3 font-w700 mb-0">
                            <span id="percen">การประมวลผล</span>
                        </p>
                        <div style="height:40px;width:150%;">
                        <div id="pdiv" class="progress push">
                                    <div id="pgbar" class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width:0%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                    <span id="pgbartext" class="font-size-sm font-w600">การประมวลผลอยู่</span>
                            </div>
                        </div>
                        </div>
                        <p id="display-ps" class="text-muted mb-0">
                           สถานะการประมวลผล
                        </p>
                    </div>
                    <div class="item rounded-lg bg-body-dark">
                        <i id="success" class="fa fa-check text-muted fa-2x"></i>
                        <i id="process-status" class="fas fa-cog fa-spin fa-2x"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-center">
                    {{-- <a class="font-w500" href="javascript:void(0)" onclick="return getAsset()">
                        Sync Data
                        <i class="fa fa-arrow-right ml-1 opacity-25"></i>
                    </a> --}}
                </div>
            </div>
            {{-- <div class="block block-rounded text-center d-flex flex-column flex-grow-1">
                <div class="block-content block-content-full d-flex align-items-center flex-grow-1">
                    <div class="w-100">
                        <div class="item rounded-lg bg-body-dark mx-auto my-3">
                            <i class="fa fa-archive text-muted"></i>
                        </div>
                        <div class="text-black font-size-h1 font-w700">75</div>
                        <div class="text-muted mb-3">Products out of stock</div>
                        <div class="d-inline-block px-3 py-1 rounded-lg font-size-sm font-w600 text-warning bg-warning-lighter">
                            5% of portfolio
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                    <a class="font-w500" href="javascript:void(0)">
                        Order supplies
                        <i class="fa fa-arrow-right ml-1 opacity-25"></i>
                    </a>
                </div>
            </div> --}}
        </div>

        <span id="store"></span>
    </div>
</div>




@endsection

@section('footer')
<script>
$('#process-status').hide()
$('#pdiv').hide()
summaryClient()
summaryDatacenter()

async function getAsset(){
   await  $.ajax({
        type: "get",
        url: "datacentersync/getasset",
        beforeSend: function(){
            $('#pdiv').show()
            $('#process-status').show()
            $('#success').hide()
            $('#icon-asset').addClass('fa-spin')
            $('#percen').html('<span class="">การประมวลผล</span>');
            $('#pgbar').css('width','100%');

        },
        dataType: "json",
        success: async function (response) {
            await sendAsset(response) ;
        }
    });
}

 async function sendAsset(data){
     await $.ajax({
        type: "post",
        url: "{{env('APP_DATACENTER')}}datacenter/import-asset",
        data:data,
        dataType: "json",
        success: async function (response,status, xhr) {
            console.log(status)
            reset()
        },
        xhr: function () {
        var xhr = $.ajaxSettings.xhr();
        xhr.onprogress = function e() {
            // For downloads
            if (e.lengthComputable) {
                console.log(e.loaded / e.total);
            }
        };
        xhr.upload.onprogress = function (e) {
            // For uploads
            if (e.lengthComputable) {
                console.log(e.loaded / e.total);
            }
        };
        return xhr;
    },
        error: function(xhr, status, error){
                        $('#error').append(xhr.responseJSON.message);
                        alert(xhr.responseJSON.message);
                        return false;
        }
    });
}

function reset(){
                $('#percen').html('<span class="">ส่งข้อมูลสำเร็จ!</span>');
                $('#pgbar').css('width','0%');
                $('#pgbartext').text('สถานะการประมวลผล');
                 $('#process-status').hide()
                 $('#success').show()
                 $('#pdiv').hide()
                $('#display-ps').text('สถานะการประมวลผล')
                $('#icon-asset').removeClass('fa-spin')
                $('#icon-person').removeClass('fa-spin')
                summaryClient()
                summaryDatacenter()
}

async function getPerson(){

   await $.ajax({
        type: "get",
        url: "datacentersync/getperson",
        beforeSend: function(){
            $('#pdiv').show()
            $('#process-status').show()
            $('#success').hide()
            $('#icon-person').addClass('fa-spin')
            $('#percen').html('<span class="">การประมวลผล</span>');
            $('#pgbar').css('width','100%');
        },
        dataType: "json",
        success:    async function (response) {
            await sendPerson(response)
        }
    });
}

async function sendPerson(data){

 $('#icon-person').removeClass('fa-spin')
    $.ajax({
        type: "post",
        url: "{{env('APP_DATACENTER')}}datacenter/import-person",
        data:data,
        dataType: "json",
        success: function (response) {
           reset();
        }
    });
}

// เช็ต total ฝั่ง client
function summaryClient(){
    $.ajax({
        type: "get",
        url: "{{ url('datacentersync/summary')}}",
        dataType: "json",
        beforeSend: function(){
            $('#client-asset').text('loadding...')
        },
        success: function (response) {
            $('#client-asset').text(response.assets)
            $('#client-person').text(response.person)
        }
    });
}

// เช็ต total ฝั่ง datacenter
function summaryDatacenter(){
    $.ajax({
        type: "post",
        url: "{{env('APP_DATACENTER')}}datacenter/summary-client",
        data:{
            hospcode:"{{$hospcode}}"
        },
        beforeSend: function(){
            $('#datacenter-asset').text('loadding...')
        },
        dataType: "json",
        success: function (response) {
            $('#datacenter-asset').text(response.assets)
            $('#datacenter-person').text(response.person)
        }
    });
}


</script>
@endsection
