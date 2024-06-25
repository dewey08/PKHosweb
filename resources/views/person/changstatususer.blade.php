<?php
 $id_user = Auth::user()->PERSON_ID;

$status = isset($user->status) ? $user->status : null;

?>
<form  method="post" action="{{ route('updatestatusuer.store') }}">
    @csrf
    <input type="hidden" name="ID" value="{{ $person->ID }}"/>
 
    <div class="row push">
    <div class="col-sm-12">  
    
          <label >กำหนดประเภทผู้ใช้งาน</label>
                <select  name = "status"  id="status"  class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
                    @if( $status == 'USER')
                    <option value="USER" selected>USER</option>
                    @else
                    <option value="USER">USER</option>
                    @endif
                    @if( $status == 'ADMIN')
                    <option value="ADMIN" selected>ADMIN</option>
                    @else<option value="ADMIN">ADMIN</option>
                    @endif
                    @if( $status == 'NOTUSER')
                    <option value="NOTUSER" selected>NOTUSER</option>
                    @else<option value="NOTUSER">NOTUSER</option>
                    @endif
              
                </select>

            </div>
        </div>

  <input type="hidden" name = "USER_EDIT_ID"  id="USER_EDIT_ID" value="{{ $id_user }} ">


  </div>
  <hr>
    <div class="mt-3">
      <div align="right">
    <button type="submit"  class="btn btn-hero-sm btn-hero-info"><i class="fas fa-save"></i> บันทึกข้อมูล</button>
    <button type="button" class="btn btn-hero-sm btn-hero-danger" data-dismiss="modal"><i class="fas fa-times"></i> ยกเลิก</button>
    </div>
  </div>
    </form>  


