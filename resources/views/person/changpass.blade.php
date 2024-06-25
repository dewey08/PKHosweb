<?php
$id_user = Auth::user()->PERSON_ID; ?>
<form method="post" action="{{ route('updatepass.store') }}" onSubmit="return checkpass({{ $person->ID }})">
    @csrf
    <input type="hidden" name="ID" value="{{ $person->ID }}" />
    <center>
        <div style="color: red;" id="text{{ $person->ID }}"></div>
    </center>

    <div class="row push">
        <div class="col-sm-4">
            <label>รหัสผ่านใหม่</label>
        </div>
        <div class="col-sm-8">
            <input type="password" name="NEWPASSWORD" id="NEWPASSWORD_{{ $person->ID }}" class="form-control input-lg"
                style=" font-family: 'Kanit', sans-serif;">
        </div>
    </div>
    <div class="row push mt-1">
        <div class="col-sm-4">
            <label>ยืนยันรหัสผ่านใหม่</label>
        </div>
        <div class="col-sm-8">
            <input type="password" name="CHECK_NEWPASSWORD" id="CHECK_NEWPASSWORD_{{ $person->ID }}"
                class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
        </div>
    </div>
    <input type="hidden" name="USER_EDIT_ID" id="USER_EDIT_ID" value="{{ $id_user }} ">


    </div>
    <hr>
 
        <div class="mt-3" align="right">
            <button type="submit" class="btn btn-hero-sm btn-hero-info"><i class="fas fa-save"></i> บันทึกแก้ไขข้อมูล</button>
            <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal"><i class="fas fa-times"></i> ยกเลิก</button>
        </div>
  
</form>
