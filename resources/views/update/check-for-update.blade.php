<div class="container">
    <span id='version' value="<?= env('APP_VERSION') ?>" api-server="{{ env('APP_API') . 'versioninfo' }}"></span>
<div id="stable">
</div>

<div class="progress">
    <div class="progress-bar progress-bar-primary progress-bar-striped progress-bar-animated" style="width:100%"><i class="fas fa-circle-notch fa-spin"></i> ตรวจสอบการอัปเดท </div>
</div>
<div class="row justify-content-md-center mt-5">
    <div class="col col-lg-2">
        
    </div>
    <div class="col-md-auto">
        <h3 class="text-center" id="server-error"></h3>
        <a href="" id="newInstall" class="btn-block btn-hero-sm btn-hero-primary mb-5"><i class="fas fa-download"></i></a>
    </div>
    <div class="col col-lg-2">
        
    </div>
</div>


        <?php foreach ($files as $file): ?>

        <?php endforeach; ?>

        <script>
            $(document).ready(function() {
                $('#newInstall').hide();
                $.ajax({
                    type: "get",
                    url:$('#version').attr('api-server'),
                    data: {
                        version: $('#version').attr('value')
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#checkUpdate').html('<i class="fas fa-cog fa-spin"></i> กำลังดำเนินการ');
                    },
                    success: function(response) {

                        if (response.version) {
                            $('#stable').html('<h1 class="text-center"> '+response.msg+'</h1>');
                        downloadfile(response.version)
                            $('#newInstall').attr("href", response.version);
                            $('#newInstall').html("ติดตั้ง Version " + response.version);

                        } else {
                            $('.progress').hide();
                            $('#newInstall').hide();
                            $('#stable').html('<h1 class="text-center"> '+response.msg+'</h1>');
                        }

                        if (response.version) {
                            $('.progress').hide();
                            $('#newInstall').hide();
                            $('#stable').html('<h1 class="text-center">'+response.msg+'</h1>');
                        }
                        $('#checkUpdate').html('ตรวจสอบการอัปเดท').delay(3000);
                    }
                });
            });

            function downloadfile(version) {
                $.ajax({
                    type: "get",
                    url: "update/download",
                    data: {
                        version: version
                    },
                    beforeSend: function() {
                        $('#checkUpdate').html('<i class="fas fa-cog fa-spin"></i> Download...');
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#newInstall').show();
                        if (response) {
                            $('.progress').hide();
                        }
                    },
                    error: function(xhr, status, error){
                        console.log(xhr.status)   

                        $('#modalTitle').html('<h4>แจ้งเตือน</h4>');
                        $('.viewversion').hide();
                        $('#newInstall').hide();
                        $('#server-error').text('ไม่สามาถติดต่อเครื่องแม่ข่ายได้กรุณาทำรายการใหม่ภายหลัง')
                    }
                });
            }

            
            $('#newInstall').click(function(e) {
                var version = $(this).attr('href');
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "update/install",
                    data: {
                        version: version
                    },
                    beforeSend: function() {
                        $('#modalTitle').html('<h4>ดำเนินการติดตั้ง</h4>');
                        $('.modal-body').html('<h1 class="text-center"><i class="fas fa-cog fa-spin"></i> Install...</h1>');
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        // alert(response);
                        swal("Success!", 'การอัปเดทเสร็จสมบรูณ์', "success");
                        $('#mediumModal').hide();
                        window.location.reload();

                    },
                    error: function(xhr, status, error){
                        console.log(xhr.responseJSON.message)   
                        $('#modalTitle').html('<h4>แจ้งเตือน</h4>');
                        $('.viewversion').hide();
                        $('#newInstall').hide();
                        $('.modal-body').html(xhr.responseJSON.message);

                    }
                });
            });

        </script>
</div>
