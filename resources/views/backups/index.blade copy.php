
@extends('layouts.backend_admin')

@section('content')
<div class="content">




    <div class="container">

    <div class="row">
        <div class="col-md-8">
            <div class="block block-rounded block-mode-loading-refresh shadow">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        <i class="fas fa-database"></i> Database Backup Lists
                    </h3>
                    <div class="block-options">
                        {{-- <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" id="backupnow"> --}}
                        <button type="button" class="btn-block-option"  id="backupnow">
                            {{-- <i class="si si-refresh"></i> --}}
                            <i id="icon-backup" class="fas fa-sync"></i>
                            {{-- <i class="fas fa-sync"></i> --}}
                        </button>
                        {{-- <div class="dropdown">
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
                        </div> --}}
                    </div>
                </div>
                <div class="block-content">
                    <div id="viewbackup"></div>

                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex flex-column">
            <div class="block block-rounded shadow">
                <div class="block-content block-content-full d-flex justify-content-between align-items-center flex-grow-1">
                    <div class="mr-3">
                        <p class="font-size-h3 font-w700 mb-0">
                            <h1 style="font-size: 25px;" id="totalUnit"></h1>
                        </p>
                        <p class="text-muted mb-0">
                            ขนาดของการสำรองข้อมูล
                        </p>
                    </div>
                    <div class="item rounded-lg bg-body-dark">
                        <i class="fa fa-check text-muted"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-center">
                    <a class="font-w500" href="javascript:void(0)">
                        {{-- View Archive --}}
                        <i class="fa fa-arrow-right ml-1 opacity-25"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

      </div>

    </div>

@endsection

@section('footer')
<script type="text/javascript">
getBody();
getTotalUit()


$('body').on('click', '.delete', function (e) {
    e.preventDefault();
    var url = $(this).attr("href");
    var title = $(this).attr("title");
    swal({
        title: title,
        text: "Confirm delete ! ",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "YES",
        cancelButtonText: "NO",
        reverseButtons: !0,
    }).then(
        function (e) {
            if (e.value === true) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data:{
                        id: title
                    },
                    beforeSend: function(){
                        $('#viewbackup').html('<h1 class="text-center text-primary"><i class="fas fa-circle-notch fa-spin"></i> โหลดข้อมูลกรุณารอสักครู่...</h1>');
                    },
                    success: function (response) {
                        if (response.success) {
                            swal({
                                title: "Deleted!",
                                text: "Your row has been deleted.",
                                type: "success",
                                timer: 1000
                            });
                            // swal("Done !",timer: 3000, response.message, "success");
                            // window.location.reload(true);
                            getBody();
                            getTotalUit()
                        } else {
                            swal("Error!", response.message, "error");
                            getBody();
                            getTotalUit()
                        }
                    },
                });

                } else {
                    e.dismiss;
            }
        },
        function (dismiss) {
            return false;
        }
    );
    return false;
});
$('#backupnow').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "get",
        url: "backupnow",
        beforeSend: function(){
            $('#viewbackup').html('<h1 class="text-center text-primary"><i class="fas fa-cog fa-spin"></i> Backup Database กรุณารอสักครู่...</h1>');
            $('#icon-backup').addClass('fa-spin');
        },
        // dataType: "dataType",
        success: function (response) {
            getBody();
            getTotalUit();
            $('#icon-backup').removeClass('fa-spin');

        }
    });
});
function getBody() {
    $.ajax({
        type: "get",
        url: "backups/getbody",
        beforeSend: function(){
            $('#viewbackup').html('<h1 class="text-center text-primary"><i class="fas fa-circle-notch fa-spin"></i> โหลดข้อมูลกรุณารอสักครู่...</h1>');
        },
        success: function (response) {
            $('#viewbackup').html(response);
        }
    });
}

function getTotalUit() {
    $.ajax({
        type: "get",
        url: "backups/total-unit",
        success: function (response) {
            $('#totalUnit').html(response);
        }
    });
}

</script>
@endsection
