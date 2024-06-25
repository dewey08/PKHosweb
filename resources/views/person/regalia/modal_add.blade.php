
<?php 
  $time_now = date('d/m/Y'); 
  $year_now = date('Y'); 
  $id_user = Auth::user()->PERSON_ID; 
?>
<button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".bd-example-modal-lg">
  <i class="fas fa-plus"></i> เพิ่มข้อมูลเครื่องราชอิสริยาภรณ์
</button>

<div class="modal fade bd-example-modal-lg" id="add_data" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="block-header">
        <span class="font-title" style="margin-top:20px;">
          <b>เพิ่มข้อมูลราชอิสริยาภรณ์</b>
        </span>
    </div>
    <div class="block-content font-content">
        <div class="col-md-12" style="margin-top:10px;">
            <div class="row">
              <div class="col-md-4">
                <labal><b>ปีที่ได้รับ</b></labal><br>
                <span>
                  <select class="form-control" name="yearOfReceipt" id="yearOfReceipt" style="width: 100%;">
                    <option value="" disable>--กรุณาเลือกปีปีที่ได้รับ--</option>
                    @foreach ($budget as $row)
                      <option value="{{ $row->LEAVE_YEAR_ID  }}">{{ $row->LEAVE_YEAR_ID}}</option>
                    @endforeach
                  </select>
                </span>
              </div>
              <div class="col-md-4">
                <span><b>วันที่ได้รับ</b></span>
                <span><input type="text" class="form-control datepicker" name="dayOfReceipt" id="dayOfReceipt" readonly></span>
              </div>
              <div class="col-md-4">
                <span><b>วันที่ประกาศ</b></span>
                <span><input type="text" class="form-control datepicker" name="announcementDate" id="announcementDate" readonly></span>
              </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top:30px;">
          <div class="row">
            <div class="col-md-4">
              <labal><b>ชั้นตราเครื่องราช</b></labal><br>
              <span>
                <select class="form-control" name="badge" id="badge" style="width: 100%;">
                  <option value="ร.ง.ม.">ร.ง.ม.</option>
                  <option value="ร.ง.ช.">ร.ง.ช.</option>
                  <option value="ร.ท.ม.">ร.ท.ม.</option>
                  <option value="ร.ท.ช.">ร.ท.ช.</option>
                  <option value="บ.ม.">บ.ม.</option>
                  <option value="บ.ช.">บ.ช.</option>
                  <option value="จ.ม.">จ.ม.</option>
                  <option value="จ.ช.">จ.ช.</option>
                  <option value="ต.ม.">ต.ม.</option>
                  <option value="ต.ช.">ต.ช.</option>
                  <option value="ท.ม.">ท.ม.</option>
                  <option value="ท.ช.">ท.ช.</option>
                  <option value="ป.ม.">ป.ม.</option>
                  <option value="ป.ช.">ป.ช.</option>
                  <option value="ม.ว.ม.">ม.ว.ม.</option>
                  <option value="ม.ป.ช.">ม.ป.ช.</option>
                  <option value="ร.จ.พ.">ร.จ.พ.</option>




                </select>
              </span>
            </div>
            <div class="col-md-4">
              <span><b>ยศ/ตำแหน่ง</b></span>
              <span><input type="text" class="form-control" name="position" id="position"></span>
            </div>
            <div class="col-md-4">
              <span><b>หน่วยงาน</b></span>
              <span><input type="text" class="form-control" name="agency" id="agency"></span>
            </div>
          </div>
        </div>
        <div class="col-md-12" style="margin-top:30px;">
          <div class="row">
            <div class="col-md-4">
              <span><b>เล่มที่</b></span>
              <span><input type="text" class="form-control" name="volume" id="volume"></span>
            </div>
            <div class="col-md-4">
              <span><b>หน้าที่</b></span>
              <span><input type="text" class="form-control" name="duty" id="duty"></span>
            </div>
            <div class="col-md-4">
              <span><b>ลำดับที่</b></span>
              <span><input type="text" class="form-control" name="no" id="no"></span>
            </div>
          </div>
        </div>
        <div class="col-md-12" style="margin-top:30px;">
          <div class="row">
            <div class="col-md-2">
              <span><b>รก.ล.</b></span>
              <span><input type="text" class="form-control" name="badgeRgl" id="badgeRgl"></span>
            </div>
            <div class="col-md-2">
              <span><b>รก.ต.</b></span>
              <span><input type="text" class="form-control" name="badgeRgd" id="badgeRgd"></span>
            </div>
          </div>
        </div>
        <div class="col-md-12" style="text-align: right; margin-top:30px; margin-bottom:30px;">
          <button type="button" class="btn btn-hero-sm btn-hero-info btn-add-config" data-id="{{ $id_user }}">
            <i class="fas fa-save"></i> บันทึกข้อมูล
          </button>
          <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal">
            <i class="fas fa-window-close"></i> ยกเลิก
          </button>
        </div>
    </div>
    </div>
  </div>
</div>

<script>

  $(document).on('click','.btn-add-config', function() {
    var id = $(this).attr('data-id');
    var token = $("meta[name='csrf-token']").attr("content");
    var yearOfReceipt = $('#yearOfReceipt').val();
    var dayOfReceipt = $('#dayOfReceipt').val();
    var announcementDate = $('#announcementDate').val();
    var badge = $('#badge').val();
    var position = $('#position').val();
    var agency = $('#agency').val();
    var volume = $('#volume').val();
    var duty = $('#duty').val();
    var no = $('#no').val();
    var badgeRgl = $('#badgeRgl').val();
    var badgeRgd = $('#badgeRgd').val();

    $.ajax({

      type: 'POST',
      url: "{{ route('person.inforegalia.add_config') }}",

      data:{
        _token: token,
        _method: 'POST',
        yearOfReceipt: yearOfReceipt,
        dayOfReceipt: dayOfReceipt,
        announcementDate: announcementDate,
        badge: badge,
        position: position,
        agency: agency,
        volume: volume,
        duty: duty,
        no: no,
        badgeRgl: badgeRgl,
        badgeRgd: badgeRgd,
      },

      success: function (response) {
      }

    });
    var url = "{{url('person/inforegalia/main', '')}}"+"/"+id;
    window.location = url;

  });

</script>